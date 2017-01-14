<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nhatky
 *
 * @author LuuBinh
 */
include_once 'database.php';

class nhatky extends database {

    public static $THEM_TRANH = 0;
    public static $DAT_TRANH = 1;

    //them nhat ky
    function them_nhat_ky($manv, $viec, $idtranh) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ngay = date("Y-m-d");
        $gio = date("H:i:s");

        $sql = "INSERT INTO nhatky VALUES('$manv', '$viec', '$idtranh', '$ngay', '$gio')";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }

    //lay danh sach nhat ky
    public static $query_nhat_ky = "SELECT
                                            nhatky.manv,
                                            nhanvien.hoten,
                                            CASE WHEN nhatky.viec='0' THEN N'Thêm tranh'
                                                 ELSE N'Đặt tranh' END AS tenviec,
                                            tranh.masotranh,
                                            nhatky.ngay,
                                            nhatky.gio
                                    FROM nhatky
                                            INNER JOIN nhanvien ON nhatky.manv = nhanvien.manv
                                            INNER JOIN tranh ON nhatky.idtranh = tranh.idtranh
                                    ORDER BY nhatky.ngay DESC, manv ASC";

    function tong_hop_nhat_ky() {
        $sql = "SELECT
                                            nhatky.manv,
                                            nhanvien.hoten,
                                            tranh.idtranh,
                                            tranh.masotranh,
                                            nhatky.viec,
                                            CASE WHEN nhatky.viec='0' THEN N'Thêm tranh'
                                                 ELSE N'Đặt tranh' END AS tenviec,
                                            nhatky.ngay,
                                            nhatky.gio
                                    FROM nhatky
                                            INNER JOIN nhanvien ON nhatky.manv = nhanvien.manv
                                            INNER JOIN tranh ON nhatky.idtranh = tranh.idtranh
                                    ORDER BY nhatky.ngay DESC, manv ASC";

        $this->setQuery($sql);

        $result = $this->loadAllRow();
        $this->disconnect();
        return $result;
    }

    //xoa nhat ky theo dong
    function xoa_nhat_ky($manv, $viec, $idtranh) {
        $sql = "DELETE FROM nhatky WHERE manv = '$manv' AND viec='$viec' AND idtranh='$idtranh'";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }

    //xoa toan bo nhat ky
    function xoa_toan_bo_nhat_ky() {
        $sql = "DELETE FROM nhatky";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }

}

?>
