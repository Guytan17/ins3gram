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
        $nb_ing = model('IngredientModel')->getNbingredients();
        $next_id=$nb_ing[0]['id']+1;
        $brands=model('BrandModel')->orderBy('name')->findAll();
        $categories=model('CategIngModel')->orderBy('name')->findAll();
        return $this->view('/admin/ingredient/form', ['brands'=>$brands,'categories'=>$categories,'next_id'=>$next_id]);
    }
    public function insert()
    {
        $data = $this->request->getPost();
        $im = Model('IngredientModel');
        if(empty($data['id_brand']))unset($data['id_brand']);
        if ($im->insert($data)) {
            $this->success('L\'ingrédient a été ajouté avec succès');
            //Ajout des substituts s'il y en a
            $sm=Model('SubstituteModel');
            if(isset($data['substitute'])){
                foreach($data['substitute'] as $sub) {
                    if ($sm->insert($sub)) {
                        $this->success('Substitut ajouté avec succès');
                    }
                }
            }
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
        $substitutes=model('SubstituteModel')->getSubByIdBase($id_ingredient);
        $substituted=model('SubstituteModel')->getBaseByIdSub($id_ingredient);
        $brand=model('BrandModel')->find($ingredient['id_brand']);
        $category=model('CategIngModel')->find($ingredient['id_categ']);
        if (!$ingredient) {
            $this->error('Ingrédient introuvable');
            return $this->redirect('admin/ingredient');
        }
        return $this->view('admin/ingredient/form', ['brands'=>$brands,'categories'=>$categories, 'ingredient'=>$ingredient,'brand'=>$brand,'category'=>$category,'substitutes'=>$substitutes,
            'substituted'=>$substituted]);
    }
    public function update(){
        $data=$this->request->getPost();
        $id_ingredient=$data['id_ingredient'];
        $im=model('IngredientModel');
        if(empty($data['id_brand'])) {
            $data['id_brand']=null;
        };
        if ($im->update($id_ingredient,$data)) {
            $this->success('L\'ingrédient a été modifié avec succès');
            //Gestion des substituts
            $sm=Model('SubstituteModel');
            //Suppression des substituts existants
            $sm->where('id_ingredient_base',$id_ingredient)->delete();
            //Ajout des nouveaux substituts s'il y en a
            if(isset($data['substitute'])){
                foreach($data['substitute'] as $sub) {
                    if ($sm->insert($sub)) {
                        $this->success('Substitut modifié avec succès');
                    }
                }
            }
        } else {
            foreach ($im->errors() as $error):
                $this->error($error);
            endforeach;
        }
        return $this->redirect('/admin/ingredient');
    }
    public function delete(){
        $im = Model('IngredientModel');
        $id = $this->request->getPost('id');
        if ($im->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'L\'ingrédient a bien été supprimé !',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $im->errors()
            ]);
        }
    }
}
