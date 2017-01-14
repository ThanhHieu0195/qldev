<?php

/*
 * To change this template, choose Tools | Templates and open the template in the editor.
 */

/**
 * Description of nhomkhach
 *
 * @author LuuBinh
 */
include_once 'database.php';
class nhomkhach extends database {
    
    // them nhom khach
    function them_nhom_khach($tennhom) {
        $sql = "INSERT INTO nhomkhach(tennhom) VALUES('$tennhom')";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }
    
    // chi tiet nhom khach
    function chi_tiet_nhom_khach($manhom) {
        $sql = "SELECT manhom, tennhom FROM nhomkhach
                WHERE manhom = '$manhom'";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        return $row;
    }
    
    // Get Id by name
    public function get_id_by_name($name) {
        $name = trim ( $name );
        $sql = "SELECT manhom FROM nhomkhach WHERE tennhom = '{$name}'";
        
        $this->setQuery ( $sql );
        $row = mysql_fetch_array ( $this->query () );
        $this->disconnect ();
        
        if (is_array ( $row )) {
            return $row ['manhom'];
        }
        return 0;
    }
    
    // cap nhat nhom khach
    function cap_nhat_nhom_khach($manhom, $tennhom) {
        $sql = "UPDATE nhomkhach SET
                        tennhom = '$tennhom'
                WHERE manhom = '$manhom'";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }
    
    // xoa nhom khach theo manhom
    function xoa_nhom_khach($manhom) {
        $sql = "DELETE FROM nhomkhach WHERE manhom = '$manhom'";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }
    
    // ++ REQ20120915_BinhLV_N
    // Tim kiem nhom khach hang theo tham so truyen vao
    function get_top($term, $limit) {
        // Ket qua default (khong tim thay)
        $output = array (
                'manhom' => '',
                'tennhom' => '' 
        );
        
        // Danh sach cac cot tim kiem trong bang 'nhomkhach'
        $columns = array (
                'tennhom' 
        );
        
        // Tao cau lenh SQL dung de tim kiem
        $where = "";
        if (isset ( $term ) && $term != "") {
            $where = "WHERE (";
            for($i = 0, $len = count ( $columns ); $i < $len; $i ++) {
                $where .= "`" . $columns [$i] . "` LIKE '%" . $term . "%' OR ";
            }
            $where = substr_replace ( $where, "", - 3 );
            $where .= ')';
        }
        
        $order = "ORDER BY tennhom ASC";
        
        $limit = "LIMIT " . $limit;
        
        $sql = "
    	        SELECT manhom, tennhom
    	        FROM nhomkhach
    	        $where
    	        $order
    	        $limit
    	        ";
        
        // Lay du lieu tu database
        $this->setQuery ( $sql );
        $array = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $output = array ();
            foreach ( $array as $row ) {
                array_push ( $output, array (
                        'manhom' => $row ['manhom'],
                        'tennhom' => $row ['tennhom'] 
                ) );
            }
        }
        
        return json_encode ( $output );
    }
    
    // Danh sach tong hop nhom khach hang va so luong moi nhom
    function danh_sach_tong_hop() {
        $sql = "SELECT nhomkhach.manhom,
                       nhomkhach.tennhom, 
                       (SELECT COUNT(makhach) FROM khach WHERE khach.manhom = nhomkhach.manhom) AS soluong
                FROM nhomkhach";
        
        $this->setQuery ( $sql );
        $array = $this->loadAllRow ();
        $this->disconnect ();
        
        return $array;
    }
    // -- REQ20120915_BinhLV_N
}

?>
