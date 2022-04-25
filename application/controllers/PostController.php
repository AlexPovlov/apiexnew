<?php

namespace application\controllers;

use application\core\Controller;


class PostController extends Controller
{

    public function createpaymentAction()
    {
        $update = json_decode( file_get_contents('php://input'), TRUE);
        
        //$this->model->getdetails($update['name'],$update['amount'],$update['user_id'],$update['url']);
        
        $exchangers = $this->model->getavailableexchangers($update['name']);     
        
            if($exchangers != NULL){
                $wallet = $this->model->getpartnerwallet();
              
                switch ($update['name']) {
                    case 'Exchanger4':
                       
                        $pay = $this->ExExchanger4Api->request($update['user_id'],$update['amount']);
                        $cryptocurrency_amount = $this->model->BtcExchenger4($update['amount']);
                        $this->model->InsertPay($update['user_id'],$update['name'],$pay['id'],$pay['amount'],'Сбербанк',$pay['walletCard'],'BTC',$cryptocurrency_amount,$update['url']);
                        $callback = [
                            'exchanger_name'=>$update['name'],
                            'id'=>$pay['id'],
                            'user_id'=>$update['user_id'],
                            'amount'=>$pay['amount'],
                            'walletcard'=>$pay['walletCard'],
                            'bank'=>'Сбербанк',
                            'cryptocurrency'=>'BTC',
                            'amount_crypto'=>$cryptocurrency_amount,
                            'url'=>$update['url'],
                            'status'=>'success'

                        ];
                        break;

                    case 'Exchanger1':
                
                        $pay = $this->ExExchanger1Api->create_order($update['amount'],$wallet);

                        $this->model->InsertPay($update['user_id'],$update['name'],$pay['order_id'],$pay['final_rub_sum'],'Тинькоф',$pay['payment_requisites'],$pay['cryptocurrency'],$pay['cryptocurrency_sum'],$update['url']);
                        
                        $callback = [
                            'exchanger_name'=>$update['name'],
                            'id'=>$pay['order_id'],
                            'user_id'=>$update['user_id'],
                            'amount'=>$pay['final_rub_sum'],
                            'walletcard'=>$pay['payment_requisites'],
                            'bank'=>'Тинькоф',
                            'cryptocurrency'=>$pay['cryptocurrency'],
                            'amount_crypto'=>$pay['cryptocurrency_sum'],
                            'url'=>$update['url'],
                            'status'=>'success'
                        ];

                        break;

                    case 'exchanger':
                        
                        $pay = $this->ExApi->create_order($update['user_id'],$update['amount'],$wallet);

                        $this->model->InsertPay($update['user_id'],$update['name'],$pay['tx_id'],$pay['amount'],'Сбербанк',$pay['address'],$pay['crypto_currency'],$pay['crypto_amount'],$update['url']);
            
                        $callback = [
                            'exchanger_name'=>$update['name'],
                            'id'=>$pay['tx_id'],
                            'user_id'=>$update['user_id'],
                            'amount'=>$pay['amount'],
                            'walletcard'=>$pay['address'],
                            'bank'=>'Сбербанк',
                            'cryptocurrency'=>$pay['crypto_currency'],
                            'amount_crypto'=>$pay['crypto_amount'],
                            'url'=>$update['url'],
                            'status'=>'success'
                        ];
                        
                        break;

                    case 'exchanger2':

                        

                        $pay = $this->ExExchanger2Api->createordercard($update['user_id'],$update['amount'],$wallet,$update['paymethod']);

                        $this->model->InsertPay($update['user_id'],$update['name'],$pay['orderid'],$pay['payvalue'],$update['paymethod'],$pay['paymentdata'],'BTC',$pay['cryptovalue'],$update['url']);
            
                        $callback = [
                            'exchanger_name'=>$update['name'],
                            'id'=>$pay['orderid'],
                            'user_id'=>$update['user_id'],
                            'amount'=>$pay['payvalue'],
                            'walletcard'=>$pay['paymentdata'],
                            'bank'=> $update['paymethod'],
                            'cryptocurrency'=>'BTC',
                            'amount_crypto'=>$pay['cryptovalue'],
                            'url'=>$update['url'],
                            'status'=>'success'
                        ];
                        
                        break;
                    
                    default:

                        $callback = [
                            'exchanger_name'=>'NULL',
                            'status'=>'fail'
                        ];
                        
                        break;
                }
            }else {
                $callback = [
                    'exchanger_name'=>'NULL',
                    'status'=>'fail'
                ];
            }

            echo json_encode($callback);
    }

    public function setwAction()
    {
        $update = json_decode( file_get_contents('php://input'), TRUE);
        $this->model->set($update['wallet']);
    }
}


