<?php

namespace App\Models;

use App\Traits\DataTableTrait;
use App\Traits\Select2Searchable;
use CodeIgniter\Model;

class IngredientModel extends Model
{
    use Select2Searchable;
    use DataTableTrait;
    protected $table = 'ingredient';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'description', 'id_brand', 'id_categ'];
    protected $beforeInsert = ['setInsertValidationRules'];
    protected $beforeUpdate = ['setUpdateValidationRules'];

    protected function setInsertValidationRules(array $data){
        $this->validationRules = [
            'name'      => 'required|max_length[255]|is_unique[ingredient.name,id]',
            'description' => 'permit_empty|string',
            'id_categ'  => 'permit_empty|integer',
            'id_brand'  => 'permit_empty|integer',
        ];
        return $data;
    }

    protected function setUpdateValidationRules(array $data){
        $id = $data['data']['id_recipe'] ?? null;
        $this->validationRules = [
            'name'      => "required|max_length[255]|is_unique[ingredient.name,id,$id]",
            'description' => 'permit_empty|string',
            'id_categ'  => 'permit_empty|integer',
            'id_brand'  => 'permit_empty|integer',
        ];
        return $data;
    }
    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom de l’ingrédient est obligatoire.',
            'max_length' => 'Le nom de l’ingrédient ne peut pas dépasser 255 caractères.',
            'is_unique'  => 'Cet ingrédient existe déjà.',
        ],
        'id_categ' => [
            'integer' => 'L’ID de catégorie doit être un nombre.',
        ],
        'id_brand' => [
            'integer' => 'L’ID de marque doit être un nombre.',
        ],
    ];
    protected $select2SearchFields= ['name','description'];
    protected $select2DisplayField='name';
    protected $select2AdditionalFields=['description'];
    protected function getDataTableConfig(): array
    {
        return [
            'searchable_fields' => [
              'name',
              'description',
              'brand.name',
              'categ_ing.name'
            ],
            'joins' => [
                [
                'table' => 'brand',
                'condition' => 'ingredient.id_brand = brand.id',
                'type' => 'left'// permet de lister les éléments même si pas de correspondance (par forcément de marque ou de catégorie associée)
                ],
                [
                'table' =>'categ_ing',
                'condition' => 'ingredient.id_categ=categ_ing.id',
                'type' => 'left'
                ]
            ], 'select' => 'ingredient.*, brand.name as brand, categ_ing.name as category'
        ];
    }
    public function getNbingredients () {
        $this->selectMax('id');
        return $this->find();
    }
}
