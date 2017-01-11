<?php

/*
 * To change this template, choose Tools | Templates and open the template in the editor.
 */

/**
 * Description of nhanvien
 *
 * @author LuuBinh
 */
require_once '../entities/nhanvien_entity.php';
require_once 'database.php';
class nhanvien extends database {
    
    // lay thong tin nhan vien
    function thong_tin_nhan_vien($manv) {
        $sql = "SELECT * FROM nhanvien WHERE manv='$manv'";
        $this->setQuery ( $sql );
        
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        return $row;
    }
    
    // lay thong tin nhan vien
    function detail_by_uid($uid) {
        $sql = "SELECT * FROM nhanvien WHERE uid='$uid'";
        $this->setQuery ( $sql );
        
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        return $row;
    }
    public function insert(nhanvien_entity $item) {
        $sql = "INSERT INTO `nhanvien` (`manv`, `macn`,`bophan`, `password`, `hoten`, `uid`, 
                            `ngaysinh`, `diachi`, `dienthoai`, `dienthoaiban`,`email`, `enable`)
                VALUES('{$item->manv}', '{$item->macn}','{$item->bophan}', '{$item->password}', '{$item->hoten}', '{$item->uid}', 
                       '{$item->ngaysinh}', '{$item->diachi}', '{$item->dienthoai}', '{$item->dienthoaiban}','{$item->email}', '{$item->enable}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();   
        
        return $result;
    }
    public function update(nhanvien_entity $item) {
        $sql = "UPDATE `nhanvien` SET
                `macn` = '{$item->macn}' , 
                `bophan` = '{$item->bophan}' , 
                `password` = '{$item->password}' , 
                `hoten` = '{$item->hoten}' , 
                `uid` = '{$item->uid}' , 
                `ngaysinh` = '{$item->ngaysinh}' , 
                `diachi` = '{$item->diachi}' , 
                `dienthoai` = '{$item->dienthoai}' , 
                `dienthoaiban` = '{$item->dienthoaiban}' , 
                `email` = '{$item->email}' , 
                `enable` = '{$item->enable}'
                WHERE `manv` = '{$item->manv}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function enable($account, $enable = BIT_TRUE) {
        $enable = ($enable == BIT_TRUE) ? BIT_TRUE : BIT_FALSE;
        $sql = "UPDATE `nhanvien` SET `enable` = '{$enable}' WHERE `manv` = '{$account}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Lay thong tin nhan vien theo user name
    public function detail($manv) {
        $sql = "SELECT * FROM `nhanvien` WHERE `manv` = '{$manv}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new nhanvien_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // cap nhat thong tin cua 1 nhan vien
    function cap_nhat_nhan_vien2($id, $manv, $macn, $hoten, $ngaysinh, $diachi, $dienthoai, $dienthoanban, $level) {
        $sql = "UPDATE nhanvien SET ";
        $sql .= "manv = '$manv', ";
        $sql .= "macn = '$macn', ";
        $sql .= "hoten = '$hoten', ";
        $sql .= "ngaysinh = '$ngaysinh', ";
        $sql .= "diachi = '$diachi', ";
        $sql .= "dienthoai = $dienthoai, ";
        $sql .= "dienthoaiban = $dienthoaiban, ";
        $sql .= "level = '$level' ";
        $sql .= "WHERE manv = '$id'";
        $this->setQuery ( $sql );
        
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }
    
    // cap nhat thong tin cua 1 nhan vien (co them doi mat khau)
    function cap_nhat_nhan_vien($id, $manv, $macn, $hoten, $ngaysinh, $diachi, $dienthoai, $dienthoaiban, $level, $email, $doimatkhau, $password) {
        $format = "UPDATE nhanvien
                   SET manv = '%s',
                       macn = %d,
                       hoten = '%s',
                       ngaysinh = '%s',
                       diachi = '%s',
                       dienthoai = '%s',
                       dienthoaiban = '%s',
                       email = '%s',
                       %s
                       level = %d
                   WHERE manv = '%s'";
        $password = md5 ( $password );
        $change = ($doimatkhau) ? "password='$password', " : "";
        $sql = sprintf ( $format, $manv, $macn, $hoten, $ngaysinh, $diachi, $dienthoai, $dienthoaiban, $email, $change, $level, $id );
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }
    
    // doi mat khau
    function doi_mat_khau($manv, $password) {
        $sql = "UPDATE nhanvien SET ";
        $sql .= "password = '$password' ";
        $sql .= "WHERE manv = '$manv'";
        $this->setQuery ( $sql );
        
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }
    
    // Danh sach nhan vien/cong tac vien
    function employee_list($type = 'employee', $all = FALSE) {
        $sql = "SELECT * FROM `nhanvien` ";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " WHERE `enable` = '{$enable}'";
        }
        $sql .= " ORDER BY `hoten` ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                
                // Employee list
                if ($type == 'employee') {
                    if (is_freelancer ( $row ['manv'] )) {
                        continue;
                    }
                } else { // Freelancer list
                    if (! is_freelancer ( $row ['manv'] )) {
                        continue;
                    }
                }
                
                // $item = new nhanvien_entity ();
                // $item->assign ( $row );
                // $list [] = $item;
                
                $list [] = $row;
            }
        }
        
        return $list;
    }
    function get_list_name($arr) {
        $tmp = "'" . str_replace ( ", ", "', '", implode ( ", ", $arr ) ) . "'";
        $sql = "SELECT manv, hoten FROM nhanvien WHERE manv IN ({$tmp})";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $result )) {
            $output = array ();
            
            foreach ( $result as $row ) {
                $output [$row ['manv']] = $row ['hoten'];
            }
            
            return $output;
        }
        
        return NULL;
    }
    
    // lay thong tin nhan vien
    function get_name($manv) {
        $sql = "SELECT hoten FROM nhanvien WHERE manv='$manv'";
        $this->setQuery ( $sql );
        
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        
        if (is_array ( $row )) {
            return $row ['hoten'];
        }
        
        return "?????";
    }

    // lay thong tin nhan vien
    function get_ext($manv) {
        $sql = "SELECT dienthoaiban FROM nhanvien WHERE manv='$manv'";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['dienthoaiban'];
        }

        return "?????";
    }

    // lay thong tin nhan vien
    function get_manv($email) {
        $sql = "SELECT manv FROM nhanvien WHERE email='$email'";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['manv'];
        }

        return "?????";
    }
}

?>
