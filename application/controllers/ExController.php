<?php

namespace application\controllers;

use application\core\Controller;

class ExController extends Controller
{

    private $otvet = ['msg'=>'OK'];

    public function callback_exAction()
    {
        header('Content-Type: application/json');
        $callback_ex = json_decode( file_get_contents('php://input'), TRUE);

        if(!empty($callback_ex['txId'])){

            $get_pay = $this->model->GetProcessingPayEx($callback_ex['txId']);

            if($get_pay != null){

                switch ($callback_ex['action']) {
                    case 'payment':
                                                                       
                        $this->model->UpdatePayFromId($callback_ex['txId']);   

                        $get_pay = $this->model->GetPayEx($callback_ex['txId']);
                         
                        unset($get_pay['id'],$get_pay['partner_id']);
                        
                        $query = $this->model->query($get_pay['url'],$get_pay);

                        $query = json_decode($query,true);

                        $this->model->PayDeliveryStatus($query['status'],$callback_ex['txId']);

                        echo json_encode($this->otvet);

                        break;
                    
                    
                    default:
                    
                        break;
                }
            }
        }
        
    }
}