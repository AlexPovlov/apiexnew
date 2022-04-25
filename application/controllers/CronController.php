<?php

namespace application\controllers;

use application\core\Controller;

class CronController extends Controller
{

    public function timeExchanger1Action()
    {
        $AllProcessingPay = $this->model->GetAllProcessingPayIdExchanger1();
        
        foreach ($AllProcessingPay as $key => $ProcessingPay) {
            if ((time()-strtotime($ProcessingPay['date'])) >= 7200) {
                $this->model->UpdateTimeOutFromId($ProcessingPay['order_id']);
            }
            
        }
        
    }

    public function timeexAction()
    {
        $AllProcessingPay = $this->model->GetAllProcessingPayIdEx();
        
        foreach ($AllProcessingPay as $key => $ProcessingPay) {
            if ((time()-strtotime($ProcessingPay['date'])) >= 7200) {
                $this->model->UpdateTimeOutFromId($ProcessingPay['order_id']);
            }
            
        }
    }
}