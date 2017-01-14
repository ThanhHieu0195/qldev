<?php
require_once '../entities/items_swapping_entity.php';
require_once '../models/database.php';
class items_swapping extends database {
    
    // Token status style
    public static $tokenStyleArr = array (
            SWAPPING_DRAFT => array (
                    'value' => SWAPPING_DRAFT,
                    'text' => 'Phiếu chưa hoàn tất',
                    'css' => 'tag turquoise' 
            ),
            SWAPPING_NEW => array (
                    'value' => SWAPPING_NEW,
                    'text' => 'Đang xử lý',
                    'css' => 'tag belize' 
            ),
            SWAPPING_FINISHED => array (
                    'value' => SWAPPING_FINISHED,
                    'text' => 'Xử lý xong',
                    'css' => 'tag pomegranate' 
            ), 
			 SWAPPING_COMPLETED => array (
                    'value' => SWAPPING_COMPLETED,
                    'text' => 'Chưa chuyển',
                    'css' => 'tag turquoise' 
            ) 
    );
    public function insert(items_swapping_entity $item) {
        $sql = "INSERT INTO `items_swapping` (`swap_uid`, `created_date`, `created_by`, `from_store`, 
                              `to_store`, `total_amount`, `status`)
                VALUES ('{$item->swap_uid}', '{$item->created_date}', '{$item->created_by}', '{$item->from_store}', 
                        '{$item->to_store}', '{$item->total_amount}', '{$item->status}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function update(items_swapping_entity $item) {
        $sql = "UPDATE `items_swapping` SET
                    `created_date` = '{$item->created_date}' , `created_by` = '{$item->created_by}' , `from_store` = '{$item->from_store}' , 
                    `to_store` = '{$item->to_store}' , `total_amount` = '{$item->total_amount}' , `status` = '{$item->status}'
                WHERE `swap_uid` = '{$item->swap_uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete($swap_uid) {
        $sql = "DELETE FROM `items_swapping` WHERE `swap_uid` = '{$swap_uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail($swap_uid) {
        $sql = "SELECT * FROM `items_swapping` WHERE `swap_uid` = '{$swap_uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new items_swapping_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    // Get last modified swapping item's id
    public function get_last_modified_swapping($created_by, $from_store, $to_store, $status = SWAPPING_DRAFT) {
        $is_finished = BIT_FALSE;
        $sql = "SELECT `swap_uid` FROM `items_swapping`
                WHERE `created_by` = '{$created_by}' AND `from_store` = '{$from_store}' AND `to_store` = '{$to_store}' AND `status` = '{$status}'
                ORDER BY `created_date` DESC LIMIT 1";
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            return $array ['swap_uid'];
        }
        
        return NULL;
    }
    public function check_existing($swap_uid) {
        $sql = "SELECT `swap_uid` FROM `items_swapping` WHERE `swap_uid` = '{$swap_uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $arr = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        return (is_array ( $arr ) && count ( $arr ) > 0);
    }
    public function count_of_wait($swap_uid) {
        $status = SWAPPING_DETAIL_WAIT;
        $sql = "SELECT COUNT(`uid`) AS `num` FROM `items_swapping_detail` WHERE `swap_uid` = '{$swap_uid}' AND `status` = '{$status}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $arr = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $arr )) {
            return $arr ['num'];
        }
        
        return - 1;
    }
    
    // 0: Has no access
    // 1: View
    // 2: View and processing
    public static function check_viewing_right($account, items_swapping_entity $swap) {
        // Check acces rights
        $access = 0;
        if ($swap->created_by == $account) {
            $access = 1;
        } elseif (check_store_manager ( $account, $swap->to_store )) {
            $access = 2;
        }
        
        return $access;
    }
}

/* End of file */