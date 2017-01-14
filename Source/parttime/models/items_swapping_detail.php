<?php
require_once '../entities/items_swapping_detail_entity.php';
require_once '../models/database.php';
class items_swapping_detail extends database {
    
    // Item status style
    public static $styleArr = array (
            SWAPPING_DETAIL_WAIT => array (
                    'value' => SWAPPING_DETAIL_WAIT,
                    'text' => 'Chờ nhận',
                    'css' => 'tag belize' 
            ),
            SWAPPING_DETAIL_DELIVERIED => array (
                    'value' => SWAPPING_DETAIL_DELIVERIED,
                    'text' => 'Đã nhận',
                    'css' => 'tag pomegranate' 
            ),
            SWAPPING_DETAIL_RETURNED => array (
                    'value' => SWAPPING_DETAIL_RETURNED,
                    'text' => 'Trả hàng',
                    'css' => 'tag orange' 
            ) 
    );
    public function insert(items_swapping_detail_entity $item) {
        $sql = "INSERT INTO `items_swapping_detail` (`uid`, `swap_uid`, `product_id`, `amount`, `status`, `note`)
                VALUES ('{$item->uid}', '{$item->swap_uid}', '{$item->product_id}', 
                        '{$item->amount}', '{$item->status}', '{$item->note}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function update(items_swapping_detail_entity $item) {
        $sql = "UPDATE `items_swapping_detail` 
                SET `swap_uid` = '{$item->swap_uid}' , 
                    `product_id` = '{$item->product_id}' , 
                    `amount` = '{$item->amount}' , 
                    `status` = '{$item->status}' , 
                    `note` = '{$item->note}'
                WHERE `uid` = '{$item->uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail($uid) {
        $sql = "SELECT * FROM `items_swapping_detail` WHERE `uid` = '{$uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new items_swapping_detail_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    public function list_by_swapping($swap_uid, $all = TRUE) {
        $sql = "SELECT * FROM `items_swapping_detail` WHERE `swap_uid` = '{$swap_uid}' ";
        if (! $all) {
            $status = SWAPPING_DETAIL_WAIT;
            $sql .= " AND (`status` = '{$status}') ";
        }
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $result )) {
            $list = array ();
            foreach ( $result as $row ) {
                $item = new items_swapping_detail_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
            
            return $list;
        }
        return NULL;
    }
    public function array_by_swapping($swap_uid) {
        $sql = "SELECT d.uid, d.product_id, t.dai, t.rong, t.tentranh, l.donvi, d.amount, t.giaban, d.status, d.note, t.hinhanh
                FROM items_swapping_detail d INNER JOIN tranh t ON d.product_id = t.masotranh
                                             INNER JOIN loaitranh l ON t.maloai = l.maloai
                WHERE d.swap_uid = '{$swap_uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $result )) {
            $arr = array ();
            $items = array ();
            
            foreach ( $result as $z ) {
                if (! in_array ( $z ['product_id'], $items )) {
                    $arr [] = array (
                            'product_id' => $z ['product_id'],
                            'size' => "{$z ['dai']}x{$z ['rong']}",
                            'name' => $z ['tentranh'],
                            'unit' => $z ['donvi'],
                            'amount' => $z ['amount'],
                            'price' => $z ['giaban'],
                            'uid' => $z ['uid'],
                            'status' => $z ['status'],
                            'note' => $z ['note'],
                            'image' => $z ['hinhanh'] 
                    );
                } else {
                    $items [] = $z ['product_id'];
                }
            }
            
            return $arr;
        }
        
        return NULL;
    }
}

/* End of file */