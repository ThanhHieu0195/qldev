<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/01/2017
 * Time: 9:52 CH
 */
include_once 'database.php';
include_once 'helper.php';
require_once 'yeucauthaydoihangmuc.php';
require_once 'yeucauthaydoivattu.php';

class duyetphatsinh extends database
{
    function taidulieu() {
        $sql = 'select yeucauthaydoihangmuc.id, tencongtrinh, tenhangmuc, 0 loaiyeucau,"" tenvattu, khoiluongbandau, 
                        khoiluongthaydoi, nhanvienyeucau, ghichu, idcongtrinh 
                from yeucauthaydoihangmuc inner join danhsachcongtrinh on danhsachcongtrinh.id = idcongtrinh
                                           inner join hangmucthicong on hangmucthicong.id = idhangmuc
                where yeucauthaydoihangmuc.trangthai = 0
                UNION ALL 
                select yeucauthaydoivattu.id, tencongtrinh, tenhangmuc, 1 loaiyeucau, tenvattu, khoiluongbandau, 
                        khoiluongthaydoi, nhanvienyeucau, ghichu, idcongtrinh 
                from yeucauthaydoivattu inner join danhsachcongtrinh on danhsachcongtrinh.id = idcongtrinh
                                           inner join hangmucthicong on hangmucthicong.id = idhangmuc
                                           inner join vattuhangmucthicong on vattuhangmucthicong.id = idvattu
                where yeucauthaydoivattu.trangthai = 0
                order by tencongtrinh, tenhangmuc, loaiyeucau
                ';
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_array($result) ) {
            $arr[] = $row;
        }
        return $arr;
    }
    function phatsinhdaduyet($idcongtrinh) {
        $sql = 'select yeucauthaydoihangmuc.id, tencongtrinh, tenhangmuc, 0 loaiyeucau,"" tenvattu, khoiluongbandau, 
                        khoiluongthaydoi, nhanvienyeucau, ghichu, idcongtrinh, ngayyeucau, yeucauthaydoihangmuc.trangthai 
                from yeucauthaydoihangmuc inner join danhsachcongtrinh on danhsachcongtrinh.id = idcongtrinh
                                           inner join hangmucthicong on hangmucthicong.id = idhangmuc
                where yeucauthaydoihangmuc.trangthai != 2 and idcongtrinh = "'.$idcongtrinh.'"
                UNION ALL 
                select yeucauthaydoivattu.id, tencongtrinh, tenhangmuc, 1 loaiyeucau, tenvattu, khoiluongbandau, 
                        khoiluongthaydoi, nhanvienyeucau, ghichu, idcongtrinh, ngayyeucau, yeucauthaydoivattu.trangthai 
                from yeucauthaydoivattu inner join danhsachcongtrinh on danhsachcongtrinh.id = idcongtrinh
                                           inner join hangmucthicong on hangmucthicong.id = idhangmuc
                                           inner join vattuhangmucthicong on vattuhangmucthicong.id = idvattu
                where yeucauthaydoivattu.trangthai != 2 and idcongtrinh = "'.$idcongtrinh.'"
                order by tencongtrinh, tenhangmuc, loaiyeucau
                ';
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_array($result) ) {
            $arr[] = $row;
        }
        return $arr;
    }
}