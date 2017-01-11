
<?php
require_once '../entities/finance_token_detail_entity.php';
require_once '../models/database.php';

// Model class
class finance_token_detail extends database {
    // Insert new item
    public function insert(finance_token_detail_entity $item) {
        $sql = "INSERT INTO `finance_token_detail` 
                    (`uid`, `token_id`, `reference_id`, `madon`, 
                    `product_id`, `item_id`, `perform_by`, 
                    `money_amount`, `taikhoan`, `note`, `perform_date`
                    )
                VALUES
                    ('{$item->uid}', '{$item->token_id}', '{$item->reference_id}', '{$item->madon}',
                    '{$item->product_id}', '{$item->item_id}', '{$item->perform_by}', 
                    '{$item->money_amount}', '{$item->taikhoan}', '{$item->note}', '{$item->perform_date}'
                    );
                ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    public function check_madon($madon) {
        // SELECT COUNT(*) FROM donhang dh, trahang th where '%s' = dh.madon OR '%s' = th.id
        $sql = "SELECT COUNT(*) AS SOLUONG FROM donhang where madon = '%s'";
        $sql = sprintf($sql, $madon);
        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $arr = mysql_fetch_assoc($result);
        if ($arr['SOLUONG'] > 0) {
            return true;
        }

        return false;
    }

    function statistic_tk($from, $to) {
        // SELECT ftd.taikhoan, ft.token_type AS loai, SUM(ftd.money_amount) as tong,COUNT(*) as soluong FROM finance_token_detail ftd INNER JOIN finance_token ft on ftd.token_id = ft.token_id WHERE ftd.perform_date BETWEEN '%s' AND '%s' GROUP BY ftd.taikhoan, ft.token_type 
        $sql = "SELECT ftd.taikhoan, ft.token_type AS loai, SUM(ftd.money_amount) as tong,COUNT(*) as soluong FROM finance_token_detail ftd 
                INNER JOIN finance_token ft on ftd.token_id = ft.token_id 
                WHERE (ftd.perform_date BETWEEN '%s' AND '%s') AND (ft.is_finished=1) GROUP BY ftd.taikhoan, ft.token_type";
        $sql = sprintf($sql, $from, $to);
        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            # code...
            $arr[] = $row;
        }
        return $arr;
    }

    function statistic_tk_type($taikhoan, $type, $from, $to){
        // SELECT * FROM finance_token_detail ftd INNER JOIN finance_token ft on ftd.token_id = ft.token_id WHERE ft.token_type = '%s' AND (ftd.perform_date BETWEEN '%s' AND '%s') GROUP by ftd.taikhoan, ftd.madon, ftd.token_id 
        $sql = "SELECT * FROM finance_token_detail ftd INNER JOIN finance_token ft on ftd.token_id = ft.token_id WHERE ftd.taikhoan = '%s' AND ft.token_type = '%s' AND (ftd.perform_date BETWEEN '%s' AND '%s')";
        $sql = sprintf($sql, $taikhoan, $type,$from, $to);
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            # code...
            $arr[] = $row;
        }
        return $arr;
    }
    // Update an item
    public function update(finance_token_detail_entity $item) {
        $sql = "UPDATE `finance_token_detail` 
                SET
                    `token_id` = '{$item->token_id}' , 
                    `reference_id` = '{$item->reference_id}' , 
                    `madon` = '{$item->madon}' , 
                    `product_id` = '{$item->product_id}' , 
                    `item_id` = '{$item->item_id}' , 
                    `perform_by` = '{$item->perform_by}' , 
                    `money_amount` = '{$item->money_amount}' , 
                    `taikhoan` = '{$item->taikhoan}' , 
                    `note` = '{$item->note}' , 
                    `perform_date` = '{$item->perform_date}'
                WHERE
                    `uid` = '{$item->uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Delete an item
    public function delete($uid) {
        $sql = "DELETE FROM `finance_token_detail` WHERE `uid` = '{$uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Get detail
    public function detail_object($uid) {
        $sql = "SELECT * FROM `finance_token_detail` WHERE `uid` = '{$uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new finance_token_detail_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Delete items by category
    public function delete_by_token($token_id) {
        $sql = "DELETE FROM `finance_token_detail` WHERE `token_id` = '{$token_id}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Get items list by category
    public function list_by_token($token_id) {
        $sql = "SELECT * FROM `finance_token_detail` WHERE `token_id` = '{$token_id}' ORDER BY `uid`";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new finance_token_detail_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
    
    // Get item's detail by UID
    public function detail_by_uid($uid) {
        $sql = "SELECT d.uid, d.madon, d.token_id, 
                       d.reference_id, r.name AS reference, 
                       d.product_id, p.name AS product, 
                       c.category_id, c.name AS category, 
                       d.item_id, i.name AS item, 
                       d.perform_by, n.hoten AS performer,
                       d.money_amount, d.taikhoan, d.note, d.perform_date
                FROM finance_token_detail d INNER JOIN finance_reference r ON d.reference_id = r.reference_id
                                            INNER JOIN finance_product p ON d.product_id = p.product_id
                                            INNER JOIN finance_item i ON d.item_id = i.item_id
                                            INNER JOIN finance_category c ON i.category_id = c.category_id
                                            INNER JOIN nhanvien n ON d.perform_by = n.manv
                WHERE d.uid = '{$uid}'";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Get items list by category
    public function detail_list_by_token($token_id) {
        $sql = "SELECT d.uid, d.madon, d.token_id, r.name AS reference, p.name AS product, c.name AS category, i.name AS item, n.hoten AS perform_by, 
                       d.money_amount, d.taikhoan, IFNULL(m.mota,'#') as mota, d.note, d.perform_date
                FROM finance_token_detail d INNER JOIN finance_reference r ON d.reference_id = r.reference_id
                                            INNER JOIN finance_product p ON d.product_id = p.product_id
                                            INNER JOIN finance_item i ON d.item_id = i.item_id
                                            INNER JOIN finance_category c ON i.category_id = c.category_id
                                            INNER JOIN nhanvien n ON d.perform_by = n.manv
                                            LEFT JOIN motataikhoan m ON m.taikhoan = d.taikhoan
                WHERE d.token_id = '{$token_id}'";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Statistic
    public function statistic($from_date, $to_date, $account=NULL) {
        $approved = BIT_TRUE;
        $W = "";
        if (! is_null($account)) { 
            $W = " AND d.taikhoan = '" . $account . "'"; 
        } else {
            $W = " AND t.approved = '{$approved}'"; 
        }
        $sql = "SELECT d.uid, d.token_id, r.name AS reference, p.name AS product, c.name AS category, i.name AS item, n.hoten AS performer,
                       d.money_amount, d.madon, d.taikhoan, IFNULL(m.mota,'#') as mota, d.note, d.perform_date, t.approved, t.token_type
                FROM finance_token_detail d INNER JOIN finance_token t ON d.token_id = t.token_id
                                            INNER JOIN finance_reference r ON d.reference_id = r.reference_id
                                            INNER JOIN finance_product p ON d.product_id = p.product_id
                                            INNER JOIN finance_item i ON d.item_id = i.item_id
                                            INNER JOIN finance_category c ON i.category_id = c.category_id
                                            INNER JOIN nhanvien n ON d.perform_by = n.manv
                                            LEFT JOIN motataikhoan m ON m.taikhoan = d.taikhoan
                WHERE (d.perform_date BETWEEN '{$from_date}' AND '{$to_date}')
                       {$W}
                ORDER BY d.perform_date, t.token_type ";
        error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log'); 
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Total money amount by token
    public function total_money_by_token($token_id) {
        $sql = "SELECT SUM(money_amount) AS num
                FROM finance_token_detail
                WHERE token_id = '{$token_id}'";
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            return $array ['num'];
        }
        
        return 0;
    }
    
    // Total items number by token
    public function count_items_by_token($token_id) {
        $sql = "SELECT COUNT(uid) AS num
                FROM finance_token_detail
                WHERE token_id = '{$token_id}'";
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            return $array ['num'];
        }
        
        return 0;
    }

    public function summary_account($token_id) {
        $sql = "select mt.mota as taikhoan, sum(ft.money_amount) as sotien from finance_token_detail as ft inner join motataikhoan as mt on mt.taikhoan = ft.taikhoan where ft.token_id='{$token_id}' group by ft.taikhoan";
        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery ( $sql );
        $cur = $this->query ();
        $array = array();
        while ($row = mysql_fetch_assoc($cur)) {
            $array[] = $row;
        }
        mysql_free_result($cur);
        if (is_array ( $array )) {
            return $array;
        }

        return 0;
    }
}
/* End of file */

?>
