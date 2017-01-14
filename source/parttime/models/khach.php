<?php

/*
 * To change this template, choose Tools | Templates and open the template in the editor.
 */

/**
 * Description of khach
 *
 * @author LuuBinh
 */
require_once '../entities/guest_entity.php';
include_once 'database.php';
include_once 'helper.php';
class khach extends database {
    var $_YES = 0x01;
    var $_NO = 0x00;
    
    // them khach hang moi
    function them_khach($manhom, $hoten, $diachi, $quan, $tp, $tiemnang, $dienthoai1, $dienthoai2, $dienthoai3, $emailchinh, $emailphu) {
        $sql = "INSERT INTO khach (manhom, hoten, diachi, quan, tp, tiemnang, dienthoai1, dienthoai2, dienthoai3, email, emailphu) ";
        if ($tiemnang == 0)
            $sql .= "VALUES ('$manhom', '$hoten', '$diachi', '$quan', '$tp', 0x00, '$dienthoai1', '$dienthoai2', '$dienthoai3', '$emailchinh', '$emailphu')";
        else
            $sql .= "VALUES ('$manhom', '$hoten', '$diachi', '$quan', '$tp', 0x01, '$dienthoai1', '$dienthoai2', '$dienthoai3', '$emailchinh', '$emailphu')";
        $this->setQuery ( $sql );
        
        $result = $this->query ();
        $this->disconnect ();
        // echo $tiemnang;
        return $result;
    }
	 function them_khach_online($manhom, $hoten, $diachi, $tiemnang, $dienthoai1,$email) {
        $sql = "INSERT INTO khach (manhom, hoten, diachi, tiemnang, dienthoai1,email) ";
        if ($tiemnang == 0)
            $sql .= "VALUES ('$manhom', '$hoten', '$diachi', 0x00, '$dienthoai1','$email')";
        else
            $sql .= "VALUES ('$manhom', '$hoten', '$diachi', 0x01, '$dienthoai1','$email')";
        $this->setQuery ( $sql );
        
        $result = $this->query ();
        $this->disconnect ();
        // echo $tiemnang;
        return $result;
    }
	 function khach_exist($sodienthoai)
    {
        $result = TRUE;
        $sql = "SELECT * FROM khach WHERE dienthoai1 = '{$sodienthoai}' OR dienthoai2 = '{$sodienthoai}' OR dienthoai3 = '{$sodienthoai}'";
        $this->setQuery($sql);
        $r = $this->query();
        $row = mysql_fetch_array ( $r );
        $this->disconnect();
        if ((! is_array($row)) || (strlen($sodienthoai)<6)) {
            $result = FALSE;
        }
        return $result;
    }

         function khach_exist_email($email)
    {
        $result = TRUE;
        $sql = "SELECT * FROM khach WHERE email = '{$email}'";
        $this->setQuery($sql);
        $r = $this->query();
        $row = mysql_fetch_array ( $r );
        $this->disconnect();
        if ((! is_array($row)) || (strlen($email)<6)) {
            $result = FALSE;
        }
        return $result;
    }

	 function get_customerid($sodienthoai)
    {
        $sql = "SELECT `makhach` FROM khach WHERE dienthoai1 = '{$sodienthoai}' OR dienthoai2 = '{$sodienthoai}' OR dienthoai3 = '{$sodienthoai}' LIMIT 1";
        $this->setQuery($sql);
        $r = $this->query();
        $row = mysql_fetch_array ( $r );
        $this->disconnect();
        if (! is_array($row)) {
            $result = FALSE;
            return $result;
        }
        return  $row[0];
    }
    
    // Insert
    public function insert(guest_entity $item) {
        $sql = "INSERT INTO `khach` 
                    (`manhom`, `hoten`, `diachi`, 
                    `quan`, `tp`, `tiemnang`, 
                    `dienthoai1`, `dienthoai2`, `dienthoai3`, 
                    `email`, `emailphu`, `development`
                    )
                VALUES
                    ('{$item->manhom}', '{$item->hoten}', '{$item->diachi}', 
                    '{$item->quan}', '{$item->tp}', '{$item->tiemnang}', 
                    '{$item->dienthoai1}', '{$item->dienthoai2}', '{$item->dienthoai3}', 
                    '{$item->email}', '{$item->emailphu}', '{$item->development}'
                    );";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $item->makhach = mysql_insert_id ();
        $this->disconnect ();
        
        return $result;
    }

    // Set development date
    public function set_development_date($guest_id, $date)
    {
        $sql = "UPDATE `khach` 
                SET
                    `development_date` = '{$date}'
                WHERE
                    `makhach` = '{$guest_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }

    // Set unfollow 
    public function set_unfollow($guest_id)
    {
        $sql = "UPDATE `khach`
                SET
                    `development` = 3 
                WHERE
                    `makhach` = '{$guest_id}' ;";

        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();

        return $result;
    }
    
    // Update
    public function update(guest_entity $item) {
        $sql = "UPDATE `khach` 
                SET
                    `manhom` = '{$item->manhom}' , 
                    `hoten` = '{$item->hoten}' , 
                    `diachi` = '{$item->diachi}' , 
                    `quan` = '{$item->quan}' , 
                    `tp` = '{$item->tp}' , 
                    `tiemnang` = '{$item->tiemnang}' , 
                    `dienthoai1` = '{$item->dienthoai1}' , 
                    `dienthoai2` = '{$item->dienthoai2}' , 
                    `dienthoai3` = '{$item->dienthoai3}' , 
                    `email` = '{$item->email}' , 
                    `emailphu` = '{$item->emailphu}' ,
                    `development` = '{$item->development}'
                WHERE
                    `makhach` = '{$item->makhach}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Get detail
    public function detail_by_id($guest_id) {
        $sql = "SELECT * FROM `khach` WHERE `makhach` = '{$guest_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new guest_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Set development status
    public function set_development_status($guest_id, $status) {
        $sql = "UPDATE `khach`
                SET
                    `development` = '{$status}'
                WHERE
                    `makhach` = '{$guest_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // thong tin khach hang
    function thong_tin_khach_hang($makhach) {
        $sql = "SELECT
                    khach.makhach,
                    khach.hoten,
                    khach.tiemnang,
                    khach.dienthoai1,
                    khach.dienthoai2,
                    khach.dienthoai3,
                    khach.manhom,
                    nhomkhach.tennhom,
                    khach.email,
                    khach.emailphu,
                    khach.diachi,
                    khach.quan,
                    khach.tp
                FROM
                    khach inner join nhomkhach on khach.manhom = nhomkhach.manhom
                WHERE khach.makhach = '$makhach'";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        return $row;
    }
    
    // ++ REQ20120915_BinhLV_N
    // Thong tin chi tiet cua mot khach hang
    function detail($makhach) {
        $result = array ();
        $result ['makhach'] = '';
        $result ['hoten'] = '';
        $result ['tennhom'] = '';
        $result ['diachi'] = '';
        
        $sql = "SELECT makhach,
                       hoten,
                       ( SELECT tennhom
                         FROM nhomkhach
                         WHERE manhom = (SELECT manhom FROM khach WHERE makhach = '$makhach')
                       ) AS tennhom,
                       diachi,
                        quan,
                       tp
                FROM khach 
                WHERE makhach = '$makhach'";
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $result ['makhach'] = $array ['makhach'];
            $result ['hoten'] = $array ['hoten'];
            $result ['tennhom'] = $array ['tennhom'];
            $result ['diachi'] = sprintf ( "%s, %s, %s", $array ['diachi'], $array ['quan'], $array ['tp'] );
        }
        
        return $result;
    }
    
    // Them record moi vao database, ket qua inserted id tra ve $id
    function add_new(&$id, $manhom, $hoten, $diachi, $quan, $tp, $tiemnang, $dienthoai1, $dienthoai2, $dienthoai3) {
        $sql = "INSERT INTO khach (manhom, hoten, diachi, quan, tp, tiemnang, dienthoai1, dienthoai2, dienthoai3)
                VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
        $sql = sprintf ( $sql, $manhom, $hoten, $diachi, $quan, $tp, $tiemnang, $dienthoai1, $dienthoai2, $dienthoai3 );
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $id = mysql_insert_id ();
        $this->disconnect ();
        
        return $result;
    }
    // -- REQ20120915_BinhLV_N
    
    // cap nhat thong tin khach hang
    function cap_nhat_thong_tin($makhach, $hoten, $manhom, $tiemnang, $dienthoai1, $dienthoai2, $dienthoai3, $email, $emailphu, $diachi, $quan, $tp) {
        if ($tiemnang == 0)
            $tiemnang = 0x00;
        else
            $tiemnang = 0x01;
        $sql = "UPDATE khach
                SET
                       hoten = '$hoten',
                       manhom = '$manhom',
                       tiemnang = $tiemnang,
                       dienthoai1 = '$dienthoai1',
                       dienthoai2 = '$dienthoai2',
                       dienthoai3 = '$dienthoai3',
                       email = '$email',
                       emailphu = '$emailphu',
                       diachi = '$diachi',
                       quan = '$quan',
                       tp = '$tp'
                WHERE makhach = '$makhach'";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }
    
    // tong hop thong tin khach hang theo doanh so
    // case when tiemnang = '0' then N'Không' else N'Có' end AS tiemnang,
    public static $query_tong_hop_theo_doanh_so = "SELECT
                                                        khach.makhach, khach.hoten, khach.diachi, khach.quan, khach.tp,
                                                        khach.dienthoai1, khach.dienthoai2, khach.dienthoai3,
                                                        case when tiemnang = '0' then N'Không' else N'Có' end AS tiemnang,
                                                        case when SUM(donhang.thanhtien) is null then 0
                                                             else SUM(donhang.thanhtien) end
                                                                AS doanhso
                                                    FROM khach LEFT JOIN donhang on donhang.makhach = khach.makhach
                                                    GROUP BY khach.makhach";
    function tong_hop_theo_doanh_so() {
        $this->setQuery ( khach::$query_tong_hop_theo_doanh_so );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        return $result;
    }
    
    // xoa khach hang
    function xoa_khach_hang($makhach) {
        $sql = "DELETE FROM khach WHERE makhach = '$makhach'";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        return $result;
    }
    
    // ++ REQ20120508_BinhLV_N
    // Danh sach ten tieng Viet cac cot cua danh sach khach hang
    function danh_sach_column() {
        $result = array ();
        $result [] = 'Mã khách hàng';
        $result [] = 'Họ tên';
        $result [] = 'Nhóm khách';
        $result [] = 'Địa chỉ';
        $result [] = 'Quận';
        $result [] = 'Thành phố';
        $result [] = 'ĐT1';
        $result [] = 'ĐT2';
        $result [] = 'ĐT3';
        $result [] = 'Tiềm năng';
        $result [] = 'Doanh số';
        
        return $result;
    }
    
    // Tong hop danh sach khach hang
    function danh_sach_tong_hop($nhomkhach = -1) {
        $sql = "SELECT
                        khach.makhach, khach.hoten, nhomkhach.tennhom, khach.diachi, khach.quan, khach.tp,
                        khach.dienthoai1, khach.dienthoai2, khach.dienthoai3,
                        case when tiemnang = '0' then N'Không' else N'Có' end AS tiemnang,
                        case when SUM(donhang.thanhtien) is null then 0
                        else SUM(donhang.thanhtien) end
                        AS doanhso
                FROM khach INNER JOIN nhomkhach ON khach.manhom = nhomkhach.manhom
                           LEFT JOIN donhang on donhang.makhach = khach.makhach
                %s
                GROUP BY khach.makhach";
        $query = sprintf($sql, ($nhomkhach == -1) ? "" : "WHERE khach.manhom = '{$nhomkhach}'");
        $this->setQuery ($query);
        $array = $this->loadAllRow ();
        $this->disconnect ();
        
        foreach ( $array as $row ) :
            $item ['Mã khách hàng'] = $row ['makhach'];            
            $item ['Họ tên'] = $row ['hoten'];
            $item ['Nhóm khách'] = $row ['tennhom'];
            $item ['Địa chỉ'] = $row ['diachi'];
            $item ['Quận'] = $row ['quan'];
            $item ['Thành phố'] = $row ['tp'];
            $item ['ĐT1'] = ' ' . $row ['dienthoai1'];
            $item ['ĐT2'] = ' ' . $row ['dienthoai2'];
            $item ['ĐT3'] = ' ' . $row ['dienthoai3'];
            $item ['Tiềm năng'] = $row ['tiemnang'];
            $item ['Doanh số'] = number_2_string ( $row ['doanhso'], '' );
            
            $result [] = $item;
        endforeach
        ;
        
        return $result;
    }
    // -- REQ20120508_BinhLV_N
    
    // ++ REQ20120915_BinhLV_N
    // Tim kiem khach hang theo tham so truyen vao
    function get_top($term, $limit, $all = true) {
        // Ket qua default (khong tim thay)
        $output = array (
                'makhach' => '',
                'hoten' => '',
                'nhomkhach' => '',
                'diachi' => '' 
        );
        if (!isset ( $term ) || $term == "") {
            return json_encode ( $output );
        }
        
        // Danh sach cac cot tim kiem trong bang 'khach hang'
        if ($all) {
            $columns = array (
                    'hoten',
                    'diachi',
                    'quan',
                    'tp',
                    'dienthoai1',
                    'dienthoai2',
                    'dienthoai3' 
            );
        }
        else {
            $columns = array (
                    'dienthoai1',
                    'dienthoai2',
                    'dienthoai3' 
            );
        }
        
        // Tao cau lenh SQL dung de tim kiem
        $where = "";
        if (isset ( $term ) && $term != "") {
            $where = "WHERE (";
            for($i = 0, $len = count ( $columns ); $i < $len; $i ++) {
                $where .= "khach." . $columns [$i] . " LIKE '%" . $term . "%' OR ";
            }
            $where = substr_replace ( $where, "", - 3 );
            $where .= ')';
        }
        //$where .=  "AND (khach.development=0)";
        $order = "ORDER BY khach.hoten ASC";
        
        $limit = "LIMIT " . $limit;
        
        $sql = "
              SELECT khach.makhach, nhomkhach.manhom, nhomkhach.tennhom, khach.hoten, khach.diachi, khach.quan, khach.tp,
                     khach.dienthoai1, khach.dienthoai2, khach.dienthoai3, khach.email, khach.emailphu
              FROM khach INNER JOIN nhomkhach ON khach.manhom = nhomkhach.manhom
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
                $dienthoai1 = trim($row ['dienthoai1']);
                $dienthoai2 = trim($row ['dienthoai2']);
                $dienthoai3 = trim($row ['dienthoai3']);
                
                array_push ( $output, array (
                        'makhach' => $row ['makhach'],
                        'hoten' => $row ['hoten'],
                        'nhomid' => $row ['manhom'],
                        'nhomkhach' => $row ['tennhom'],
                        'dienthoai1' => $dienthoai1,
                        'dienthoai2' => $dienthoai2,
                        'dienthoai3' => $dienthoai3,
                        'email' => $row ['email'],
                        'emailphu' => $row ['emailphu'],
                        'diachi' => sprintf ( '%s%s%s', 
                                    (! empty($row ['diachi'])) ? $row ['diachi'] : '',
                                    (! empty($row ['quan'])) ? ", {$row ['quan']}" : '',
                                    (! empty($row ['tp'])) ? ", {$row ['tp']}" : ''
                                ) 
                ) );
            }
        }
        
        return json_encode ( $output );
    }
    
    // Danh sach khach hang theo nhom
    function danh_sach_theo_nhom($manhom) {
        $sql = "SELECT makhach, hoten FROM khach WHERE manhom='%s'";
        $sql = sprintf ( $sql, $manhom );
        
        $this->setQuery ( $sql );
        $array = $this->loadAllRow ();
        $this->disconnect ();
        
        return $array;
    }
    // -- REQ20120915_BinhLV_N
    
    // lay thong tin ten khach hang
    function get_name($guest_id) {
        $sql = "SELECT hoten FROM khach WHERE makhach='{$guest_id}'";
        $this->setQuery ( $sql );
    
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
    
        if (is_array ( $row )) {
            return $row ['hoten'];
        }
    
        return "?????";
    }

    function get_email($guest_id) {
        $sql = "SELECT email FROM khach WHERE makhach='{$guest_id}'";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['email'];
        }

        return "?????";
    }

    function get_makhach($phone) {
        $sql = "SELECT makhach FROM khach WHERE (dienthoai1='{$phone}') or (dienthoai2='{$phone}') or (dienthoai3='{$phone}')";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['makhach'];
        }
   
        return "";
    }

    function get_makhachemail($email) {
        $sql = "SELECT makhach FROM khach WHERE (email='{$email}') or (INSTR(emailphu,'$email')>0)";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['makhach'];
        }

        return "";
    }

    function get_development($makhach) {
        $sql = "SELECT development FROM khach WHERE makhach='{$makhach}'";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['development'];
        }

        return "";
    }


    function get_hotenkhach($ten) {
        $sql = "SELECT hoten FROM khach where hoten LIKE '%$ten%' limit 1";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['hoten'];
        }
  
        return "";
    }


    function get_doanhthu($makhach) {
        $sql = "SELECT SUM(donhang.thanhtien) AS doanhso FROM khach LEFT JOIN donhang ON donhang.makhach = khach.makhach where khach.makhach={$makhach}";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['doanhso'];
        }
  
        return 0;
    }


}

?>
