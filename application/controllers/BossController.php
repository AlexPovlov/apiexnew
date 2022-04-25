<?php

namespace Controllers;

use core\Controller;
use Main\ExchangerBoss;

class BossController extends Controller
{
    public function callback_bossAction()
    {
        $update_boss = json_decode(file_get_contents('php://input'),true);
        $main = new ExchangerBoss();
        $main->Boss($update_boss);

    }
}