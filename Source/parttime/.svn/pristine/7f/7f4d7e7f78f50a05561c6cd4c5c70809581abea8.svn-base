<?php
require_once '../entities/baogiadetail_entity.php';
require_once '../models/database.php';
class baogiadetail extends database {
    public function insert(baogiadetail_entity $item) {
        $sql = "INSERT INTO `baogiadetail` 
                    (`id`, `ngaygionote`, `noidung`) 
                VALUES
                    ('{$item->id}', '{$item->ngaygionote}', '{$item->noidung}');"; 
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_all_baogiaid($id) {
        $sql = "SELECT * FROM `baogiadetail` WHERE `id` = '{$id}' ORDER BY ngaygionote DESC";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new baogiadetail_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */
