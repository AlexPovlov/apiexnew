<?php

namespace application\models;

use application\core\ModelPartner;


class Get extends ModelPartner
{
    public function exchangers()
    {
        $exchangers = $this->db->GetAllSqlRequest("SELECT `id`,`title`,`name` FROM `exchangers` WHERE `on_off`='1'",[]);
        echo json_encode($exchangers);
    }

    public function btc_walet()
    {
        $btc_walet = $this->db->GetOneSqlRequest("SELECT `btc_walet` FROM `partner` WHERE `id`=:id",['id'=>$this->partner_id])['btc_walet'];
        echo json_encode($btc_walet);
       
    }
}
