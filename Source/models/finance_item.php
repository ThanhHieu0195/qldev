<?php
require_once '../entities/finance_item_entity.php';
require_once '../models/database.php';

// Model class
class finance_item extends database {
    // Insert new item
    public function insert(finance_item_entity $item) {
        $sql = "INSERT INTO `finance_item` 
                   (`item_id`, `category_id`, `name`, `enable`)
                VALUES
                   ('{$item->item_id}', '{$item->category_id}', '{$item->name}', '{$item->enable}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Delete items by category
    public function delete_by_category($category_id) {
        $sql = "DELETE FROM `finance_item` WHERE `category_id` = '{$category_id}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Update an item
    public function update(finance_item_entity $item) {
        $sql = "UPDATE `finance_item`
                SET
                    `category_id` = '{$item->category_id}' , 
                    `name` = '{$item->name}' ,
                    `enable` = '{$item->enable}'
                WHERE `item_id` = '{$item->item_id}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Get detail
    public function detail($item_id) {
        $sql = "SELECT * FROM `finance_item` WHERE `item_id` = '{$item_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new finance_item_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Get items list by category
    public function list_by_category($category_id, $all = FALSE) {
        $where = " WHERE `category_id` = '{$category_id}' ";
        if (! $all) {
            $enable = BIT_TRUE;
            $where .= " AND `enable` = '{$enable}' ";
        }
        $sql = "SELECT * FROM `finance_item` $where ORDER BY `name`";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new finance_item_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */