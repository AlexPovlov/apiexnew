<?php

namespace application\controllers;

use application\core\Controller;

class GetController extends Controller
{
    public function getexchangersAction()
    {
        $this->model->exchangers();
    }

    public function getwalletAction()
    {
        
        $this->model->btc_walet();
    }
}
