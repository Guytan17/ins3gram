<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Ingredient extends BaseController
{
        public function search()
    {
        $request = $this->request;

        // Vérification AJAX
        if (!$request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Requête non autorisée']);
        }

        $im = Model('IngredientModel');

        // Paramètres de recherche
        $search = $request->getGet('search') ?? '';
        $page = (int)($request->getGet('page') ?? 1);
        $limit = 20;

        // Utilisation de la méthode du Model (via le trait)
        $result = $im->quickSearchForSelect2($search, $page, $limit);

        // Réponse JSON
        return $this->response->setJSON($result);
    }
    public function index(){
        return $this->view('/admin/ingredient/index');
    }
    public function create() {
        helper('form');
        $brands=model('BrandModel')->orderBy('name')->findAll();
        $categories=model('CategIngModel')->orderBy('name')->findAll();
        return $this->view('/admin/ingredient/form', ['brands'=>$brands,'categories'=>$categories]);
    }
    public function insert()
    {
        $im = Model('IngredientModel');
        $data = $this->request->getPost();
        print_r($data);die;
        if(empty($data['id_brand']))unset($data['id_brand']);
        if ($im->insert($data)) {
            $this->success('L\'ingrédient a été ajouté avec succès');
        } else {
            foreach ($im->errors() as $error):
                $this->error($error);
            endforeach;
        }

        return $this->redirect('admin/ingredient');
    }
    public function edit($id_ingredient) {
        helper('form');
        $brands=model('BrandModel')->orderBy('name')->findAll();
        $categories=model('CategIngModel')->orderBy('name')->findAll();
        $ingredient=model('IngredientModel')->find($id_ingredient);
        if (!$ingredient) {
            $this->error('Ingrédient introuvable');
            return $this->redirect('admin/ingredient');
        }
        return $this->view('admin/ingredient/form', ['brands'=>$brands,'categories'=>$categories, 'ingredient'=>$ingredient]);
    }
    public function update(){
        $data=$this->request->getPost();
        $id_ingredient=$data['id_ingredient'];
        $im=model('IngredientModel');
        if(empty($data['id_brand']))unset($data['id_brand']);
        if ($im->update($id_ingredient,$data)) {
            $this->success('L\'ingrédient a été modifié avec succès');
        } else {
            foreach ($im->errors() as $error):
                $this->error($error);
            endforeach;
        }
        return $this->redirect('/admin/ingredient');
    }
}
