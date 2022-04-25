<?php

namespace application\controllers;

use application\core\Controller;

class Exchanger3Controller extends Controller
{

    public function callback_exchanger3Action()
    {
       
        $AllProcessingPayExchanger3 = $this->model->GetAllProcessingPayIdExchanger3();
        $idarr = [];
        foreach ($AllProcessingPayExchanger3 as $key => $ProcessingPayExchanger3) {
            $idarr[] = $ProcessingPayExchanger3['order_id'];
        }

        $payment_information_arr = $this->ExExchanger3Api->handleorder($idarr);

    
        foreach ($payment_information_arr['data'] as $key => $payment_information) {
           
           switch ($payment_information['status']) {
                case 'time_end':
                    $this->model->UpdateTimeOutFromId($payment_information['id']);
                    break;
                case 'canceled':
                    $this->model->UpdateCancelFromId($payment_information['id']);
                    break;
                case 'paid':

                    $this->model->UpdatePayFromId($payment_information['id']);

                    $get_pay = $this->model->GetPayexchanger3($payment_information['id']);

                    unset($get_pay['id'],$get_pay['partner_id']);
                        
                    $query = $this->model->query($get_pay['url'],$get_pay);

                    $query = json_decode($query,true);

                    $this->model->PayDeliveryStatus($query['status'],$payment_information['id']);

                    break;
                default:
                   # code...
                    break;
           }
        }
        
    }

    public function setpaidAction()
    {
        $update = json_decode( file_get_contents('php://input'), TRUE);
        if (!empty($update['id'])) {
            $this->ExExchanger3Api->setPaid($update['id']);
        }
        
    }
}