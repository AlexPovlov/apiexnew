<?php

namespace application\controllers;

use application\core\Controller;

class Exchanger2Controller extends Controller
{

    public function callback_exchanger2Action()
    {
       
        $AllProcessingPayExchanger2 = $this->model->GetAllProcessingPayIdExchanger2();
        $idarr = [];
        foreach ($AllProcessingPayExchanger2 as $key => $ProcessingPayExchanger2) {
            $idarr[] = $ProcessingPayExchanger2['order_id'];
        }

        $payment_information_arr = $this->ExExchanger2Api->handleorder($idarr);
    
        foreach ($payment_information_arr['orders'] as $key => $payment_information) {
           
           switch ($payment_information['status']) {
                case 'delete':
                    $this->model->UpdateTimeOutFromId($payment_information['orderid']);
                    break;
                case 'canceled':
                    $this->model->UpdateCancelFromId($payment_information['orderid']);
                    break;
                case 'success':

                    $this->model->UpdatePayFromId($payment_information['orderid']);

                    $get_pay = $this->model->GetPayexchanger2($payment_information['orderid']);

                    unset($get_pay['id'],$get_pay['partner_id']);
                        
                    $query = $this->model->query($get_pay['url'],$get_pay);

                    $query = json_decode($query,true);

                    $this->model->PayDeliveryStatus($query['status'],$payment_information['orderid']);

                    break;
                default:
                   # code...
                    break;
           }
        }
        
    }
}