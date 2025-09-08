<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tag extends BaseController
{
    public function index()
    {
        helper('form');
        return $this->view('admin/tag');
    }

    public function insert()
    {
        $tm = model("TagModel");
        $data = $this->request->getPost();
        if ($tm->insert($data)) {
            $this->success('Mot-clé créé avec succès');
        } else {
            foreach ($tm->errors() as $key => $error) {
                $this->error($error . "[" . $key . "]");
            }
        }
        return $this->redirect('admin/tag');
    }

        public function update()
        {
            $tm = model("TagModel");
            $data = $this->request->getPost();
            $id=$data['id'];
            unset($data['id']);
            if ($tm->update($id,$data)) {
                $this->success('Mot-clé modifié avec succès');
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Le mot-clé a été modifié avec succès !',
                ]);
            } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $tm->errors()
            ]);
        }
    }

    public
    function delete()
    {
        $tm=model('TagModel');
        $id=$this->request->getPost('id');
        if($tm->delete($id)){
            return $this->response->setJSON([
                'success' => true,
                'message' => 'La permission a bien été supprimée !',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $tm->errors()
            ]);
        }
    }
}
