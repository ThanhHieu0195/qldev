<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tho
 *
 * @author LuuBinh
 */
include_once 'database.php';

class tho extends database {

    //them tho lam tranh
    function them_tho($matho, $hoten, $ngaysinh, $diachi, $dienthoai) {
        $sql = "INSERT INTO tho (matho, hoten, ngaysinh, diachi, dienthoai) ";
        $sql .= "VALUES ('$matho', '$hoten', '$ngaysinh', '$diachi', '$dienthoai')";
        $this->setQuery($sql);

        $result = $this->query();
        $this->disconnect();
        return $result;
    }

    //dem so luong tho
    function so_luong() {
        $this->setQuery("SELECT COUNT(*) AS total FROM tho");

        $result = $this->query();
        $row = mysql_fetch_array($result);
        $this->disconnect();
        return $row;
    }

    //danh sach nhan vien
    function danh_sach_tho($limit) {
        $sql = "SELECT * FROM tho ORDER BY hoten ASC";
        //$sql = "SELECT * FROM tho ORDER BY hoten ASC LIMIT $limit";
        $this->setQuery($sql);

        $result = $this->loadAllRow();
        $this->disconnect();
        return $result;
    }

    //lay thong tin tho
    function thong_tin_tho($matho) {
        $sql = "SELECT * FROM tho WHERE matho='$matho'";
        $this->setQuery($sql);

        $result = $this->query();
        $row = mysql_fetch_array($result);
        $this->disconnect();
        return $row;
    }

    //cap nhat thong tin cua 1 nhan vien
    function cap_nhat_tho($id, $matho, $hoten, $ngaysinh, $diachi, $dienthoai) {
        $sql = "UPDATE tho SET ";
        $sql .= "matho = '$matho', ";
        $sql .= "hoten = '$hoten', ";
        $sql .= "ngaysinh = '$ngaysinh', ";
        $sql .= "diachi = '$diachi', ";
        $sql .= "dienthoai = '$dienthoai' ";
        $sql .= "WHERE matho = '$id'";
        $this->setQuery($sql);

        $result = $this->query();
        $this->disconnect();
        return $result;
    }

    //xoa tho lam tranh
    function xoa_tho($matho) {
        $sql = "DELETE FROM tho WHERE matho = '$matho'";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }

}

?>
