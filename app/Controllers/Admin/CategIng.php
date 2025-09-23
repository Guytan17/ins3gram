<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CategIng extends BaseController
{
    public function search()
    {
        $request = $this->request;

        // Vérification AJAX
        if (!$request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Requête non autorisée']);
        }

        $cim = Model('CategIngModel');

        // Paramètres de recherche
        $search = $request->getGet('search') ?? '';
        $page = (int)($request->getGet('page') ?? 1);
        $limit = 20;

        // Utilisation de la méthode du Model (via le trait)
        $result = $cim->quickSearchForSelect2($search, $page, $limit);

        // Réponse JSON
        return $this->response->setJSON($result);
    }
    public function index()
    {
        helper('form');
        $cim=model('CategIngModel');
        $categorie=$cim->orderBy('name')->findAll();
        return $this->view('/admin/categ-ing',['categorie'=>$categorie]);
    }
    public function insert(){
        $cim=model('CategIngModel');
        $categorie=$cim->orderBy('name')->findAll();
        $data=$this->request->getPost();
        if(empty($data['id_categ_parent'])) unset($data['id_categ_parent']);
        if($cim->insert($data)){
            $this->success('Catégorie d\'ingrédient bien créée');
        } else {
            foreach ($cim->errors() as $key=>$error){
                $this->error($error."[".$key."]");
            }
        }
        return $this->redirect('admin/categ-ing',['categorie'=>$categorie]);
    }
    public function update()
    {
        $cim = Model('CategIngModel');
        $data = $this->request->getPost();
        $id = $data['id'];
        unset($data['id']);
        if ($cim->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'La catégorie a été modifiée avec succès !',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $cim->errors()
            ]);
        }
    }
    public function delete(){
        $cim = Model('CategIngModel');
        $id = $this->request->getPost('id');
        if ($cim->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'La catégorie a bien été supprimée !',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $cim->errors()
            ]);
        }
    }
}
