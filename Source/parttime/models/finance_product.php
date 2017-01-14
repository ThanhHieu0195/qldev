<?php
require_once '../entities/finance_product_entity.php';
require_once '../models/database.php';

// Model class
class finance_product extends database {
    // Insert new item
    public function insert(finance_product_entity $item) {
        $sql = "INSERT INTO `finance_product` 
                   (`product_id`, `name`, `enable`, `used_type`)
                VALUES
                   ('{$item->product_id}', '{$item->name}', '{$item->enable}', '{$item->used_type}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Update an item
    public function update(finance_product_entity $item) {
        $sql = "UPDATE `finance_product` 
                SET
                    `name` = '{$item->name}' , 
                    `enable` = '{$item->enable}',
                    `used_type` = '{$item->used_type}'
                WHERE `product_id` = '{$item->product_id}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Update 'enable' status
    public function enable($product_id, $enable = BIT_TRUE) {
        $sql = "UPDATE `finance_product`
                SET
                    `enable` = '{$enable}'
                WHERE `product_id` = '{$product_id}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Get detail
    public function detail($product_id) {
        $sql = "SELECT * FROM `finance_product` WHERE `product_id` = '{$product_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new finance_product_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Get items list
    public function get_list($all = FALSE, $used_type = FINANCE_BOTH) {
        $where = "";
        if (! $all) {
            $enable = BIT_TRUE;
            $where = " WHERE `enable` = '{$enable}' ";
        }
        
        // Filter by used type
        $filter = "";
        if ($used_type != FINANCE_BOTH) {
            $arr = array (
                    FINANCE_BOTH,
                    $used_type 
            );
            $filter = "'" . str_replace ( ", ", "', '", implode ( ", ", $arr ) ) . "'";
            $filter = " `used_type` IN ({$filter}) ";
        }
        if ($filter != "") {
            if ($where != "") {
                $where .= " AND {$filter} ";
            } else {
                $where = " WHERE {$filter} ";
            }
        }
        
        // SQL statement
        $sql = "SELECT * FROM `finance_product` $where ORDER BY `name`";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new finance_product_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */