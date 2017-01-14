<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trahang
 *
 * //
 * @author HieuThanh
 */
include_once 'database.php';
include_once 'chitiettrahang.php';
include_once 'finance_token.php';
include_once 'helper.php';

class trahang extends database
{
    // private $result = array();
    function update_maphieuchi($id, $maphieuchi)
    {
        // UPDATE `trahang` SET `maphieuchi` = '{$maphieuchi}' WHERE `trahang`.`id` = '{$id}';
        $sql = "UPDATE `trahang` SET `maphieuchi` = '{$maphieuchi}' WHERE `trahang`.`id` = '{$id}'";
        $this->setQuery($sql);
        $result = $this->query();

        if ($result == 1) {
            return true;
        }
        return false;
    }

    function them_tra_hang($id, $ngaylap, $manv, $madon, $machuyenkho, $maphieuchi, $tientralai, $tiendoanhso, $makho, $trangthai, $nguyennhan, $donhangmoi)
    {
        $this->_connect();
        $sql = "INSERT INTO `trahang`(`id`, `ngaylap`, `manv`, `madon`, `maphieuchi`, `maphieuchuyenkho`, `tientralai`, `tiendoanhso`, `makho`,`trangthai`, `nguyennhan`, `donhangmoi`) VALUES ('%s','%s','%s','%s','%s','%s','%s', '%s', '%s', '%s', '%s', '%s')";
        $sql = sprintf($sql, $id, $ngaylap, $manv, $madon, $maphieuchi, $machuyenkho, $tientralai, $tiendoanhso, $makho, $trangthai, $nguyennhan, $donhangmoi);
        // echo $sql;
        $this->setQuery($sql);
        $result = $this->query();
        // echo $sql;
        $this->disconnect();
        if ($result == 1) return true;
        return false;
    }

    function tim_kiem($id = '', $maphieuchi = '', $maphieuchuyen = '')
    {
        $sql = "";

        if (!empty($id)) {
            $sql = "SELECT * FROM `trahang` WHERE id = '%s' ";
            $sql = sprintf($sql, $id);
        }
        if (!empty($maphieuchi)) {
            $sql = "SELECT * FROM `trahang` WHERE maphieuchi = '%s' ";
            $sql = sprintf($sql, $maphieuchi);
        }
        if (!empty($maphieuchuyen)) {
            $sql = "SELECT * FROM `trahang` WHERE maphieuchuyenkho = '%s' ";
            $sql = sprintf($sql, $maphieuchuyen);
        }
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_array($result)) {
            $arr[] = $row;
        }
        $this->disconnect();
        return $arr;
    }

    function timkiembymadon($madon, $trangthai = '0')
    {
        $sql = "";

        $sql = "SELECT * FROM `trahang` WHERE madon = '%s' AND trangthai = '%s'";
        $sql = sprintf($sql, $madon, $trangthai);

        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_array($result)) {
            $arr[] = $row;
        }
        $this->disconnect();
        return $arr;
    }


    function SumAmount_by_Order_Id($order_id)
    {
        $sql = "SELECT tientralai AS Sum_Amount FROM `donhang` WHERE madon = '%s';";
        $sql = sprintf($sql, $order_id);
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array($result);
        $this->disconnect();
        return $row['Sum_Amount'];
    }


        function cap_nhat_tientralai($id)
    {
        $sql = "UPDATE `donhang` INNER JOIN `trahang` ON `trahang`.madon=`donhang`.madon SET `donhang`.tientralai=`donhang`.tientralai + `trahang`.tientralai WHERE `trahang`.`id` = '$id';";
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        if ($result == 1)
            return true;
        else
            return false;
    }


    function cap_nhat_trang_thai($id, $maphieuchi, $maphieuchuyenkho, $trangthai = '1')
    {
        $sql = "UPDATE `trahang` SET `maphieuchi` = '%s', `maphieuchuyenkho` = '%s', `trangthai` = '%s' WHERE `trahang`.`id` = '%s';";
        $sql = sprintf($sql, $maphieuchi, $maphieuchuyenkho, $trangthai, $id);
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        if ($result) {
            $result=$this->cap_nhat_tientralai($id);
        }
        if ($result == 1)
            return true;
        else
            return false;
    }

    function reject($id, $masotranh)
    {
        $arr = array();
        $arr['trahang'] = $this->cap_nhat_trang_thai($id, '-1', '-1', '-1');
        if (!is_array($masotranh)) {
            $ctth = new chitiettrahang();
            $arr['chitiettrahang'] = $ctth->capnhattrangthai($id, '-1');
        }
        return $arr;

    }

    function approved_maphieuchi($maphieuchi)
    {
        $tk = new finance_token();
        return $tk->approved($maphieuchi);
    }

    function xoa($id)
    {
        // DELETE FROM `chitiettrahang` WHERE `chitiettrahang`.`id` = '%s'
        $sql = "DELETE FROM `trahang` WHERE `trahang`.`id` = '%s'";
        $sql = sprintf($sql, $id);
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        if ($result == 1)
            return true;
        return false;
    }

    function xoa_danh_sach($arr)
    {
        $result = 1;
        for ($i = 0; $i < count($arr); $i++) {
            $result = $result && $this->xoa($arr[$i]);
        }
        return $result;
    }

    function thongke($from, $to, $type = NULL)
    {
        if ($type == 1) {
            $doanhsotralai = "SUM(th.tiendoanhso/(SELECT COUNT(*) FROM employee_of_returns WHERE return_id = th.id)) AS doanhsotralai";

            $tienvon = "IF (th.tiendoanhso = 0 OR th.tiendoanhso is null, 0, SUM((SELECT SUM(ctth.giaban*ctth.giavon*ctth.soluong/100) FROM chitiettrahang ctth WHERE th.id = ctth.id)/(SELECT COUNT(*) FROM employee_of_returns eor WHERE eor.return_id = th.id)) ) AS tienvon";
            $sql = "SELECT th.id, n.manv, n.hoten, $doanhsotralai, $tienvon
                FROM trahang AS th INNER JOIN employee_of_returns AS eor on th.id = eor.return_id 
                                                INNER JOIN nhanvien AS n on n.manv = eor.employee_id
                WHERE (th.ngaylap BETWEEN '%s' AND '%s') AND (th.tiendoanhso>0) AND n.bophan = $type
                GROUP BY n.manv
                ORDER BY th.ngaylap";
        }

        if ($type == 0) {
            $doanhsotralai = "IF (th.tiendoanhso = 0 OR th.tiendoanhso is null, 0, if(n.bophan = 0, 
             SUM(th.tiendoanhso/(SELECT COUNT(*) FROM employee_of_returns WHERE return_id = th.id)), 

             SUM((select sum(ctth.soluong*ctth.giaban*ctth.giavon/100) from chitiettrahang ctth where ctth.id = th.id)/(SELECT COUNT(*) FROM employee_of_returns WHERE return_id = th.id)) 
             ) ) AS doanhsotralai";

            // $tienvon = "SUM((SELECT SUM(ctth.soluong*ctth.giaban*ctth.giavon/100) FROM chitiettrahang ctth WHERE th.id = ctth.id)/(SELECT COUNT(*) FROM employee_of_returns eor WHERE eor.return_id = th.id)) AS tienvon";
            // 
            $tienvon = "IF (th.tiendoanhso = 0 OR th.tiendoanhso is null, 0, if(n.bophan = 0, 

                SUM((SELECT SUM(ctth.soluong*ctth.giaban*ctth.giavon/100) FROM chitiettrahang ctth WHERE th.id = ctth.id)/(SELECT COUNT(*) FROM employee_of_returns eor WHERE eor.return_id = th.id)), 

                SUM((SELECT SUM(ctth.soluong*ctth.giaban*ctth.giavon*0.9/100) FROM chitiettrahang ctth WHERE th.id = ctth.id)/(SELECT COUNT(*) FROM employee_of_returns eor WHERE eor.return_id = th.id)) )) AS tienvon";
            // $tienvon = "10 AS tienvon";

            $sql = "SELECT th.id, n.manv, n.hoten, $doanhsotralai, $tienvon
                FROM trahang AS th INNER JOIN employee_of_returns AS eor on th.id = eor.return_id 
                                                INNER JOIN nhanvien AS n on n.manv = eor.employee_id
                WHERE (th.ngaylap BETWEEN '%s' AND '%s') AND n.bophan is not NULL
                GROUP BY n.manv
                ORDER BY th.ngaylap";
        }

        $sql = sprintf($sql, $from, $to);
        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        // print_r($sql);
        while ($row = mysql_fetch_assoc($result)) {
            # code...
            $row['doanhsotralai'] = round($row['doanhsotralai']);
            $tienvon = round($row['tienvon']);
            $row['tienvon'] = number_2_string($tienvon, ".");
            $row['tv'] = $tienvon;

            $tienlaitrahang = -($row['doanhsotralai'] - $tienvon);
            $row['tienlaitrahang'] = number_2_string($tienlaitrahang, ".");
            $row['tlth'] = $tienlaitrahang;

            $arr[] = $row;
        }
        return $arr;
    }

    function return_payment_list()
    {
        // $sql = "SELECT th.id, th.ngaylap, th.madon, th.donhangmoi, th.tientralai, th.tiendoanhso, th.manv, ifnull(isw.status,1) as status, count(th.id) as amount
        //        FROM trahang AS th INNER JOIN chitiettrahang AS ctth ON th.id = ctth.id
        //        LEFT JOIN items_swapping AS isw ON isw.swap_uid=th.maphieuchuyenkho
        //        WHERE th.trangthai = '1' AND th.maphieuchi = '1'
        //        GROUP BY th.id ";
        $sql = 'SELECT th.id, th.ngaylap, th.madon, th.donhangmoi, th.tientralai, CONCAT("APPROVED:Trả hàng ",th.nguyennhan) as chuthich, th.manv, ifnull(isw.status,1) as status, count(th.id) as amount, "0" as loai 
                FROM trahang AS th INNER JOIN chitiettrahang AS ctth ON th.id = ctth.id
                LEFT JOIN items_swapping AS isw ON isw.swap_uid=th.maphieuchuyenkho
                WHERE th.trangthai = "1" AND th.maphieuchi = "1" AND th.tientralai > 0
                GROUP BY th.id
            UNION
            SELECT tc.id, DATE_FORMAT(tc.ngaylap, "%Y-%c-%d") AS ngaylap, tc.madonhang AS madon, "---" AS donhangmoi, tc.sotien AS tientralai, tc.ghichu AS chuthich, tc.manhanvien as manv, "1" AS status, "0" AS amount, "1" as loai
            FROM danhsachthuchi tc
            WHERE tc.loai=1 AND tc.approve=1 AND tc.trangthai=0';

        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $arr[] = $row;
        }
        return $arr;
    }

    function motadoanhsotralai($from, $to, $casher)
    {

        $sql = "SELECT th.id AS maphieu, th.ngaylap as ngaytra, th.tiendoanhso AS tien, (th.tiendoanhso/(SELECT COUNT(*) FROM employee_of_returns WHERE return_id = th.id)) AS tralai 
                FROM trahang AS th INNER JOIN employee_of_returns AS eor on th.id = eor.return_id AND eor.employee_id='%s' 
                WHERE (th.ngaylap BETWEEN '%s' AND '%s') AND th.trangthai = '1'
                 ORDER BY th.ngaylap ";
        $sql = sprintf($sql, $casher, $from, $to);
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $arr[] = $row;
        }
        return $arr;
    }

    function export_doanhso_1($from, $to)
    {
        $type = 1;
        $count_employee = "(SELECT COUNT(*) FROM employee_of_returns WHERE return_id = th.id) AS count_employee";
        $giavon = "IF(th.tiendoanhso <= 0 OR th.tiendoanhso is null, 0, (SELECT SUM(ctth.soluong*ctth.giavon*ctth.giaban/100) AS giavon FROM chitiettrahang ctth WHERE th.id = ctth.id GROUP BY ctth.id) ) as giavon";
        $sql = "SELECT th.id, n.hoten, eor.employee_id, th.ngaylap, th.tiendoanhso, th.madon as madon, $giavon, $count_employee
        FROM trahang AS th INNER JOIN employee_of_returns eor on th.id = eor.return_id
                    INNER JOIN nhanvien n on eor.employee_id = n.manv
        WHERE (th.ngaylap BETWEEN '%s' AND '%s') AND th.trangthai = '1' AND n.bophan = $type
        ORDER BY th.ngaylap";
        $sql = sprintf($sql, $from, $to);
        // return $sql;
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            if ($row['id']) {
                $giavon = round($row['giavon'] / $row['count_employee']);
                $doanhso = round($row['tiendoanhso'] / $row['count_employee']);
                $tienlai = -($doanhso - $giavon);

                $arr[] = array(
                    'tennv' => $row['hoten'],
                    'madon' => $row['id'],
                    'hoten' => "khachtrahang: " . $row['madon'],
                    'ngaydat' => $row['ngaylap'],
                    'ngaygiao' => $row['ngaylap'],
                    'thanhtien' => $doanhso,
                    'giavon' => $giavon,
                    'tienlai' => $tienlai
                );
            }
        }
        return $arr;
    }

    function export_doanhso_0($from, $to)
    {
        $doanhso = "IF(th.tiendoanhso <= 0 OR th.tiendoanhso is null, 0, IF(n.bophan = 1, (SELECT SUM(ctth.soluong*ctth.giavon*ctth.giaban/100) AS tiendoanhso FROM chitiettrahang ctth WHERE th.id = ctth.id GROUP BY ctth.id), th.tiendoanhso) ) as tiendoanhso";

        $giavon = "IF(th.tiendoanhso <= 0 OR th.tiendoanhso is null, 0, IF(n.bophan = 1, (SELECT SUM(ctth.soluong*ctth.giavon*ctth.giaban/100*(1-0.1)) as giavon FROM chitiettrahang ctth WHERE th.id = ctth.id GROUP BY ctth.id), (SELECT SUM(ctth.soluong*ctth.giavon*ctth.giaban/100) as giavon FROM chitiettrahang ctth WHERE th.id = ctth.id GROUP BY ctth.id)) ) as giavon";

        $count_employee = "(SELECT COUNT(*) FROM employee_of_returns WHERE return_id = th.id) AS count_employee";

        $sql = "SELECT th.id, n.hoten, eor.employee_id, th.ngaylap, th.madon as madon, $doanhso, $giavon, $count_employee
        FROM trahang AS th INNER JOIN employee_of_returns eor on th.id = eor.return_id
                    INNER JOIN nhanvien n on eor.employee_id = n.manv
        WHERE (th.ngaylap BETWEEN '%s' AND '%s') AND th.trangthai = '1' AND n.bophan IS NOT NULL
        ORDER BY th.id";
        $sql = sprintf($sql, $from, $to);
        $this->setQuery($sql);
        $result = $this->query();
        // return $sql;
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            if ($row['id']) {
                $giavon = round($row['giavon'] / $row['count_employee']);
                $doanhso = round($row['tiendoanhso'] / $row['count_employee']);
                $tienlai = -($doanhso - $giavon);

                $arr[] = array(
                    'tennv' => $row['hoten'],
                    'madon' => $row['id'],
                    'hoten' => "khachtrahang: " . $row['madon'],
                    'ngaydat' => $row['ngaylap'],
                    'ngaygiao' => $row['ngaylap'],
                    'thanhtien' => $doanhso,
                    'giavon' => $giavon,
                    'tienlai' => $tienlai
                );
            }
        }
        return $arr;
    }

    function export_doanhso($from, $to, $type)
    {
        if ($type == 1) {
            return $this->export_doanhso_1($from, $to);
        } else if ($type == 0) {
            return $this->export_doanhso_0($from, $to);
        }
    }

    function dashboard()
    {
        $sql = "SELECT COUNT(*) AS num FROM trahang WHERE trangthai = 0";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array($result);
        $this->disconnect();
        return $row['num'];
    }

}

?>
