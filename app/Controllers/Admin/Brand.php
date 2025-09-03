<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Brand extends BaseController
{
    public function index()
    {
        helper('form');
        return $this->view('admin/brand');
    }

    public function insert()
    {
        $bm = model('BrandModel');
        $data = $this->request->getPost();
        if ($bm->insert($data)) {
            $this->success('Marque créée avec succès');
        } else {
            foreach ($bm->errors() as $key => $error) {
                $this->error($error . "[" . $key . "]");
            }
        }
        return $this->redirect('admin/brand');
    }
    public function update()
    {
        $bm = Model('BrandModel');
        $data = $this->request->getPost();
        $id = $data['id'];
        unset($data['id']);
        if ($bm->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'La marque a été modifiée avec succès !',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $bm->errors()
            ]);
        }
    }
    public function delete(){
        $bm = Model('BrandModel');
        $id = $this->request->getPost('id');
        if ($bm->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'La marque a bien été supprimée !',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $bm->errors()
            ]);
        }
    }
}