<?php

/*
 * To change this template, choose Tools | Templates and open the template in the editor.
 */

/**
 * Description of khach
 *
 * @author LuuBinh
 */
include_once 'database.php';
include_once 'helper.php';


class marketing extends database {
    
    // set lien he
    public function set_lienhe($makhach)
    {
        $sql = "UPDATE `marketing` 
                SET
                    `lienhe` = 1
                WHERE
                    `makhach` = '{$makhach}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }

    function update($makhach, $arr) {
         $sql = "UPDATE `marketing` 
                SET
                    `lienhe` = '{$arr[3]}' ,
                    `ghichu` = '{$arr[4]}'
                WHERE
                    `makhach` = '{$makhach}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $sql;
    }
 // insert customer
    public function insert_lienhe($manv,$makhach,$chiendich,$lienhe,$ghichu)
    {
        $sql = "INSERT INTO `marketing`(`manv`, `makhach`, `chiendich`, `lienhe`, `ghichu`)
				VALUES ('$manv','$makhach','$chiendich','$lienhe','$ghichu')";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }

	 public function get_makhach($sodienthoai)
    {
        $sql = "SELECT `makhach` FROM `khach` WHERE dienthoai1 = '{$sodienthoai}' LIMIT 1";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        return $row[0];
    }
    function khach_exist($makhach)
    {
        $result = TRUE;
        $message = '';
        $nhomkhach = '';
        $sql = "SELECT * FROM marketing WHERE makhach = '{$makhach}'";
        $this->setQuery($sql);
        $r = $this->query();
        $row = mysql_fetch_array ( $r );
        $this->disconnect();
        if (! is_array($row)) {
            $result = FALSE;
        }
        return $result;
    }
	 function xoa_khach_hang_marketing($makhach) {
        $sql = "UPDATE marketing SET lienhe=1 WHERE makhach = '$makhach'";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }

    public function get_guest_by_id($id) {
        $promotion_guest = PROMOTION_GUEST;
        $sql = "SELECT * FROM `marketing` AS mkt WHERE `makhach` = '$id' AND lienhe = '0' AND ghichu = '$promotion_guest';";
        $this->setQuery ( $sql );
        $result = $this->query ();
        $arr = array();
        while ($row = mysql_fetch_array ( $result )) {
            # code...
            $arr[] = $row;
        }
        $this->disconnect ();
        return $arr;
    }

    function get_guest_send_sms($id) {
         $sql = "SELECT * FROM `marketing` AS mkt WHERE `makhach` = '$id' AND lienhe = '1';";
        $this->setQuery ( $sql );
        $result = $this->query ();
        $arr = array();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        return $row;
    }

         public function get_khachkhuyenmai()
    {
        $sql = "select k.hoten, ifnull(k.dienthoai1,'') as dt1, ifnull(k.dienthoai2,'') as dt2, ifnull(k.dienthoai3,'') as dt3 from khach as k inner join marketing as m on m.makhach = k.makhach where m.ghichu = 'Khách liên hệ chờ khuyến mãi' and m.lienhe=0";
    
        $this->setQuery ( $sql );
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        return $row;
    }

         function khach_hang_lienhe($makhach) {
        $sql = "UPDATE marketing SET lienhe=0 WHERE makhach = '$makhach'";

        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }

}

?>
