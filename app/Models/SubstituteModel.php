<?php

namespace App\Models;

use CodeIgniter\Model;

class SubstituteModel extends Model
{
    protected $table            = 'substitute';
    protected $primaryKey       = 'id_ingredient_base';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_ingredient_base','id_ingredient_sub'];
    protected $validationRules = [
        'id_ingredient_base' => 'required|integer',
        'id_ingredient_sub'  => 'required|integer|differs[id_ingredient_base]',
    ];

    protected $validationMessages = [
        'id_ingredient_base' => [
            'required' => 'L’ingrédient de base est obligatoire.',
            'integer'  => 'L’ID de l’ingrédient de base doit être un nombre.',
        ],
        'id_ingredient_sub' => [
            'required'  => 'L’ingrédient substitut est obligatoire.',
            'integer'   => 'L’ID de l’ingrédient substitut doit être un nombre.',
            'different' => 'L’ingrédient substitut doit être différent de l’ingrédient de base.',
        ],
    ];

    public function getSubByIdBase($id_ingredient_base){
      $this->select('substitute.*,ingredient.name as sub_name');
      $this->join('ingredient','ingredient.id=substitute.id_ingredient_sub');
      $this->where('id_ingredient_base',$id_ingredient_base);
      return $this->findAll();
    }

    public function getBaseByIdSub($id_ingredient_sub) {
        $this->select('substitute.*,ingredient.name as base_name, ingredient.description as description');
        $this->join('ingredient','ingredient.id=substitute.id_ingredient_base');
        $this->where('id_ingredient_sub',$id_ingredient_sub);
        return $this->findAll();
    }

}
