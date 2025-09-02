<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Recipe extends BaseController
{
    protected $breadcrumb=[['text' => 'Tableau de bord','url'=>'admin/dashboard' ]];
    public function index()
    {
        return $this->view('/admin/recipe/index');
    }
    public function create(){
        $this->addBreadcrumb('Recettes',"admin/recipe");
        $this->addBreadcrumb("Création d'une recette","");
        return $this->view('admin/recipe/form');
    }


}
