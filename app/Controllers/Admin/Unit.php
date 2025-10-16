<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Unit extends BaseController
{
    public function search()
    {
        $request = $this->request;

        // Vérification AJAX
        if (!$request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Requête non autorisée']);
        }

        $um = Model('UnitModel');

        // Paramètres de recherche
        $search = $request->getGet('search') ?? '';
        $page = (int)($request->getGet('page') ?? 1);
        $limit = 20;

        // Utilisation de la méthode du Model (via le trait)
        $result = $um->quickSearchForSelect2($search, $page, $limit);

        // Réponse JSON
        return $this->response->setJSON($result);
    }
    public function index() {
        helper('form');
        return $this->view('admin/unit');
    }

    public function insert() {
        $um = Model('UnitModel');
        $data=$this->request->getPost();
        if($um->insert($data)) {
            $this->success ("L'unité a bien été crée !");
        } else {
            foreach ($um->errors() as $key => $error) {
                $this->error($error . "[" . $key . "]");
            }
        }
        return $this->redirect('admin/unit');
    }

    public function update() {
        $um = Model('UnitModel');
        $data=$this->request->getPost();
        $id=$data['id'];
        unset($data['id']);
        if ($um->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'L\'unité a été modifiée avec succès !',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $um->errors()
            ]);
        }
    }

    public function delete() {
        $um = Model('UnitModel');
        $id = $this->request->getPost('id');
        if ($um->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'L\'unité a bien été supprimée !',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $um->errors()
            ]);
        }
    }
}
