<?php

namespace App\Models;

use App\Traits\DataTableTrait;
use CodeIgniter\Model;

class RecipeModel extends Model
{
    use DataTableTrait;

    protected $table = 'recipe';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = ['name','slug','description','alcool','id_user'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $beforeInsert = ['setInsertValidationRules','validateAlcool'];
    protected $beforeUpdate = ['setUpdateValidationRules','validateAlcool'];

    protected function setInsertValidationRules(array $data){
        $this->validationRules = [
            'name'    => 'required|max_length[255]|is_unique[recipe.name]',
            'description'=>'permit_empty',
            'alcool'  => 'permit_empty|in_list[0,1,on]',
            'id_user' => 'permit_empty|integer',
        ];
        return $data;
    }

    protected function setUpdateValidationRules(array $data){
        $id = $data['data']['id_recipe'] ?? null;
        $this->validationRules = [
            'name'    => "required|max_length[255]|is_unique[recipe.name,id,$id]",
            'description'=>'permit_empty',
            'alcool'  => 'permit_empty|in_list[0,1,on]',
            'id_user' => 'permit_empty|integer',
        ];
        return $data;
    }

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom de la recette est obligatoire.',
            'max_length' => 'Le nom de la recette ne peut pas dépasser 255 caractères.',
            'is_unique'  => 'Cette recette existe déjà.',
        ],
        'alcool' => [
            'in_list' => 'Le champ alcool doit être 0 (sans alcool) ou 1 (avec alcool).',
        ],
        'id_user' => [
            'integer' => 'L’ID de l’utilisateur doit être un nombre.',
        ],
    ];

    /**
     * Récupère depuis la base de données une recette avec tout ses éléments associés(étapes, ingrédients, mots clés, utilisateur, image,...)
     * @param $id null Récupère depuis un ID (mettre null pour récupérer via le slug)
     * @param $slug null Récupère depuis un slug (l'ID doit être à null sinon il est prioritaire)
     * @return array Tableau contenant toutes les informations de notre recette
     */
    public function getFullRecipe($id = null, $slug = null) {
        if($id != null) {
            $recipe = $this->find($id);
        } elseif($slug != null) {
            $recipe = $this->where('slug',$slug)->withDeleted()->first();
        } else {
            return [];
        }
        if(!$recipe) return [];
        $id_recipe = $recipe['id'];
        $user = Model('UserModel')->withDeleted()->find($recipe['id_user']);
        unset($recipe['id_user']);
        $recipe['user'] = $user;
        $ingredients = Model('QuantityModel')->getQuantityByRecipe($id_recipe);
        $recipe['ingredients'] = $ingredients;
        //Gestion pour le cas d'un ID (notamment pour l'édition en BO)
        if($id != null) {
            //Récupération des mots-clés associés à notre recette
            $recipe_tags = Model('TagRecipeModel')->where('id_recipe',$id_recipe)->findAll();
            foreach($recipe_tags as $recipe_tag) {
                $recipe['tags'][] = $recipe_tag['id_tag'];
            }
        } else { //cas d'un SLUG (notamment pour l'affichage en FO)
            $recipe['tags'] = Model ('TagRecipeModel')->join('tag','tag_recipe.id_tag = tag.id')->where('id_recipe',$id_recipe)->findAll();
        }
        $mediamodel = Model('MediaModel');
        $recipe['mea'] = $mediamodel->where('entity_id', $id_recipe)->where('entity_type', 'recipe_mea')->first();
        $recipe['images'] = $mediamodel->where('entity_id', $id_recipe)->where('entity_type', 'recipe')->findAll();
        $steps = Model('StepModel')->where('id_recipe',$id_recipe)->orderBy('order', 'ASC')->findAll();
        $recipe['steps']=$steps;
        return $recipe ;
    }

    public function getAllRecipes($limit=8, $offset=0) {
        $this->select('recipe.id,recipe.name,alcool,slug,media.file_path as mea,COALESCE(AVG(score),0) as score');
        $this->join('media','recipe.id = media.entity_id AND media.entity_type = \'recipe_mea\'','left');
        $this->join('opinion','opinion.id_recipe = recipe.id','left');
        $this->groupBy('recipe.id');
        return $this->findAll($limit,$offset);
        // version alternative
        /* $recipes = $this->select('id,name,alcool,slug')->findAll();
        $mediaModel = Model('MediaModel');
        foreach ($recipes as &$recipe){
            $score = model("OpinionModel")->select('AVG(score) as average_score')->where('id_recipe', $recipe['id'])->first();
            $mea = $mediaModel->where('entity_id', $recipe['id'])->where('entity_type','recipe_mea')->first();
            $recipe['mea'] = $mea['file_path'];
            $recipe['score']=$score['average_score'] ?? 0;
        }
        return $recipes;*/
    }

    public function reactive(int $id): bool
    {
        return $this->builder()
            ->where('id', $id)
            ->update(['deleted_at' => null]);
    }

    protected function validateAlcool($data){
        if(isset($data['alcool'])):
            $data['data']['alcool'] =1;
        else :
            $data['data']['alcool']=0;
        endif;
        return $data;
    }
    protected function getDataTableConfig(): array
    {
        return [
            'searchable_fields' => [
                'name',
            ],
            'joins' => [
                [
                    'table' => 'user',
                    'condition' => 'user.id = recipe.id_user',
                    'type' => 'left'
                ]
            ],
            'select' => 'recipe.*, user.username as creator',
            'with_deleted' => true
        ];
    }
}

