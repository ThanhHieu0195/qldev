<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loaitranh
 *
 * @author LuuBinh
 */
include_once 'database.php';

class loaitranh extends database {

    //them loai tranh
    function them_loai_tranh($tenloai, $donvi, $giasi, $giale) {
        $sql = "INSERT INTO loaitranh(tenloai, donvi, giasi, giale) VALUES('{$tenloai}', '{$donvi}', '{$giasi}', '{$giale}')";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }

    //chi tiet loai tranh
    function chi_tiet_loai_tranh($maloai) {
        $sql = "SELECT maloai, tenloai, donvi, giasi, giale FROM loaitranh
                WHERE maloai = '$maloai'";

        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array($result);
        $this->disconnect();
        return $row;
    }

    //cap nhat loai tranh
    function cap_nhat_loai_tranh($maloai, $tenloai, $donvi, $giasi, $giale) {
        $sql = "UPDATE loaitranh SET
                        tenloai = '$tenloai',
                        donvi = '$donvi',
                        giasi = '$giasi',
                        giale = '$giale'
                WHERE maloai = '$maloai'";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }

    //xoa loai tranh theo maloai
    function xoa_loai_tranh($maloai) {
        $sql = "DELETE FROM loaitranh WHERE maloai = '$maloai'";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }
    
    //++ REQ20120508_BinhLV_N
    // Danh sach loai tranh trong he thong (ma loai + ten loai)
    function danh_sach()
    {
        $sql = "SELECT maloai, tenloai, giasi, giale FROM loaitranh";

        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        return $result;
    }
    //++ REQ20120508_BinhLV_N

}

?>
