<?php

namespace application\controllers;

use application\core\Controller;

class Exchanger1Controller extends Controller
{

    private $otvet = ['status'=>'OK'];

    public function callback_exchanger1Action()
    {
        header('Content-Type: application/json');
        $callback_exchanger1 = json_decode( file_get_contents('php://input'), TRUE);

        if(!empty($callback_exchanger1['order_id'])){

            $get_pay = $this->model->GetProcessingPayExchanger1($callback_exchanger1['order_id']);

            if($get_pay != null){

                switch ($callback_exchanger1['event']) {
                    case 'received_payment':
                                                                       
                        $this->model->UpdatePayFromId($callback_exchanger1['order_id']);   

                        $get_pay = $this->model->GetPayExchanger1($callback_exchanger1['order_id']);
                         
                        unset($get_pay['id'],$get_pay['partner_id']);
                        
                        $query = $this->model->query($get_pay['url'],$get_pay);

                        $query = json_decode($query,true);

                        $this->model->PayDeliveryStatus($query['status'],$callback_exchanger1['order_id']);

                        echo json_encode($this->otvet);

                        break;
                    case 'order_timed_out':
                        
                        $this->model->UpdateTimeOutFromId($callback_exchanger1['order_id']);

                        $get_pay = $this->model->GetPayExchanger1($callback_exchanger1['order_id']);

                        unset($get_pay['id'],$get_pay['partner_id']);

                        $query = $this->model->query($get_pay['url'],$get_pay);

                        $query = json_decode($query,true);

                        $this->model->PayDeliveryStatus($query['status'],$callback_exchanger1['order_id']);

                        echo json_encode($this->otvet);

                        break;
                    
                    default:
                    
                        break;
                }
            }
        }
        
    }
}