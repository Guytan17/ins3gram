<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Recipe extends BaseController
{
    public function index()
    {
        helper('form');
        //Récupération des filtres
        $filters = [
            'alcool' => $this->request->getGet('alcool'),
            'search' => $this->request->getGet('search'),
            'sort' => $this->request->getGet('sort'),
            'ingredients'=>$this->request->getGet('ingredients')
        ];
        //Paramètres de tri et de pagination
        $orderBy = $this->request->getGet('order_by') ?? 'name';
        $per_page = (int)($this->request->getGet('per_page') ?? 8);
        $current_page = (int) ($this->request->getGet('page') ?? 1);
        //Appel du Model
        $recipeModel = Model('RecipeModel');
        $allowedPerPage = [8,16,24];
        if(!in_array($per_page,$allowedPerPage)) {
            $per_page = 8 ;
        }
        $result=$recipeModel->getAllRecipes($filters, $orderBy, 'ASC',$per_page,$current_page);
        return $this->view('front/recipe/index', [
            'recipes'=>$result['data'],
            'pager' => $result['pager'],
            'current_page'=>$current_page,
            'per_page'=>$per_page,
            'filters' => $filters
            ],false);
    }

    public function show($slug) {
        $rm = Model('RecipeModel');
        $recipe = $rm->getFullRecipe(null,$slug);
            if(!$recipe) {
                $this->title = "Recette : " . $recipe['name'];
                return $this->view('front/recipe/404.php',['recipe'=>$recipe],false);
            }
        $tags = Model('TagRecipeModel')->getTagByRecipe($recipe['id']);
        $ingredients = Model('QuantityModel')->getQuantityByRecipe($recipe['id']);
        $steps = Model('StepModel')->getStepsByIdRecipe($recipe['id']);
        return $this->view('front/recipe/show', ['recipe' => $recipe,'tags'=>$tags,'ingredients'=>$ingredients,'steps'=>$steps], false);
    }
}
