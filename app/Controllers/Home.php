<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return $this->view('/templates/front/home',[],false);
    }
}
