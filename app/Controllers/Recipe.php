<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Recipe extends BaseController
{
    public function index()
    {
        helper('form');
        $recipes = Model('RecipeModel')->getAllRecipes(10);
        return $this->view('front/recipe/index', ['recipes'=>$recipes], false);
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
