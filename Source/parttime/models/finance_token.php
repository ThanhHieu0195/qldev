<?php
require_once '../entities/finance_token_entity.php';
require_once '../models/database.php';

// Model class
class finance_token extends database {
    // Token type style
    public static $financeTokenTypeArr = array (
            FINANCE_RECEIPT => array (
                    'value' => FINANCE_RECEIPT,
                    'text' => 'Thu',
                    'css' => 'tag belize' 
            ),
            FINANCE_PAYMENT => array (
                    'value' => FINANCE_PAYMENT,
                    'text' => 'Chi',
                    'css' => 'tag pomegranate' 
            ) 
    );
    
    // Insert new item
    public function insert(finance_token_entity $item) {
        $sql = "INSERT INTO `finance_token` 
                    (`token_id`, `created_date`, `created_by`, `amount`, 
                     `token_type`, `is_finished`, `approved`
                    )
                VALUES
                    ('{$item->token_id}', '{$item->created_date}', '{$item->created_by}', '{$item->amount}', 
                     '{$item->token_type}', '{$item->is_finished}', '{$item->approved}'
                    );";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // báo cáo cho phiếu
    public function is_finished($token_id) {
         $sql = "UPDATE `finance_token` 
                SET
                    `is_finished` = '1' 
                WHERE
                    `token_id` = '%s' ;";
        $sql = sprintf($sql, $token_id);
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }

    public function approved($token_id) {
         $sql = "UPDATE `finance_token` SET `approved` = '1' WHERE `finance_token`.`token_id` = '%s';";
         $sql = sprintf($sql, $token_id);
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }

     public function is_approve($token_id, $approved='1') {
         $sql = "UPDATE `finance_token` SET `approved` = '%s' WHERE `finance_token`.`token_id` = '%s';";
         $sql = sprintf($sql, $approved, $token_id);
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }

    // Update an item
    public function update(finance_token_entity $item) {
        $sql = "UPDATE `finance_token` 
                SET
                    `created_date` = '{$item->created_date}' , 
                    `created_by` = '{$item->created_by}' , 
                    `amount` = (select count(*) from finance_token_detail where token_id='{$item->token_id}'), 
                    `token_type` = '{$item->token_type}' , 
                    `is_finished` = '{$item->is_finished}' , 
                    `approved` = '{$item->approved}'
                WHERE
                    `token_id` = '{$item->token_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }

    public function add_new_item_token($token_id) {
        $sql = "UPDATE finance_token set amount=(select count(*) from finance_token_detail where token_id='{$token_id}') where token_id='{$token_id}'";

        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();

        return $result;
    }
    
    // Get detail
    public function detail($token_id) {
        $sql = "SELECT * FROM `finance_token` WHERE `token_id` = '{$token_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new finance_token_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Delete
    public function delete($token_id) {
        $sql = "DELETE FROM `finance_token` WHERE `token_id` = '{$token_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Get last worked item's id
    public function get_last_modified_token($account, $type = FINANCE_RECEIPT) {
        $is_finished = BIT_FALSE;
        $sql = "SELECT `token_id` FROM `finance_token` 
                WHERE `created_by` = '{$account}' AND `token_type` = '{$type}' AND `is_finished` = '{$is_finished}'
                ORDER BY `created_date` DESC LIMIT 1";
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            return $array ['token_id'];
        }
        
        return NULL;
    }
    
    // Count of unapproved item(s)
    public function count_for_unapproved() {
        $is_finished = BIT_TRUE;
        $approved = BIT_FALSE;
        $sql = "SELECT COUNT(`token_id`) AS num FROM `finance_token`
                WHERE (`is_finished` = '{$is_finished}') AND (`approved` = '{$approved}') AND (`amount` > 0) 
                ";
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            return $array ['num'];
        }
        
        return 0;
    }
}
/* End of file */
