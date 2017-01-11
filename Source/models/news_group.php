<?php
require_once '../entities/news_group_entity.php';
require_once '../models/database.php';
class news_group extends database {
    // Insert new item
    public function insert(news_group_entity $item) {
        $sql = "INSERT INTO `news_group` (`group_id`, `name`, `note`, `enable`)
                VALUES ('{$item->group_id}', '{$item->name}', '{$item->note}', '{$item->enable}'); ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Update an item
    public function update(news_group_entity $item) {
        $sql = "UPDATE `news_group` 
                SET
                    `name` = '{$item->name}' , 
                    `note` = '{$item->note}' , 
                    `enable` = '{$item->enable}'
                WHERE
                    `group_id` = '{$item->group_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Get detail of an item
    public function detail($group_id) {
        $sql = "SELECT * FROM `news_group` WHERE `group_id` = '{$group_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new news_group_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Get list
    public function list_group($all = FALSE) {
        $sql = "SELECT * FROM `news_group` ";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " WHERE `enable` = '{$enable}' ";
        }
        $sql .= " ORDER BY `uid` ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new news_group_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */