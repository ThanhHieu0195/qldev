<?php
/**
 * Description of tentranh
 *
 * @author LuuBinh
 */
include_once 'database.php';
include_once 'khohang.php';
include_once 'nhanvien.php';
include_once 'loaitranh.php';
include_once 'chitietdoanhthu.php';
include_once 'helper.php';

class doanhthu extends database {
    
    //++ REQ20120508_BinhLV_M
    // Cap nhat doanh thu va chi tiet doanh thu cua mot kho hang theo ngay
    function cap_nhat_doanh_thu($maso, $ngay, $makho, $nguoicapnhat, $ngaygiocapnhat, $ghichu, $loaisanpham, $sotien)
    {
        // Tong so tien
        $tongso = 0;
        
        // Cap nhat chi tiet doanh thu
        $ctdt = new chitietdoanhthu();
        for($i = 0; $i < count($loaisanpham); $i++)
        {
            $ctdt->cap_nhat($maso, $loaisanpham[$i], $sotien[$i]);
            $tongso += $sotien[$i];
        }
        
        // Cap nhat doanh thu
        $this->cap_nhat($maso, $ngay, $makho, $nguoicapnhat, $ngaygiocapnhat, $tongso, $ghichu);
        
        return $tongso;
    }
    //-- REQ20120508_BinhLV_M
    
    //++ REQ20120508_BinhLV_N
    // Tao mot ma so doanh thu
    function _tao_ma_so($ngay, $makho)
    {
        $result = str_replace('-', '', $ngay) . $makho;
        return $result;
    }
    
    // Them mot doanh thu
    function them($maso, $ngay, $makho, $nguoicapnhat, $ngaygiocapnhat, $tongso, $ghichu)
    {
        //$maso = $this->_tao_ma_so($ngay, $makho);
        $sql = "INSERT INTO doanhthu(maso, ngay, makho, nguoicapnhat, ngaygiocapnhat, tongso, ghichu) 
                VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')";
        $sql = sprintf($sql, $maso, $ngay, $makho, $nguoicapnhat, $ngaygiocapnhat, $tongso, $ghichu);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }
    
    // Cap nhat mot doanh thu
    function cap_nhat($maso, $ngay, $makho, $nguoicapnhat, $ngaygiocapnhat, $tongso, $ghichu)
    {
        $sql = "UPDATE doanhthu
                SET 
                   ngay = '%s',
                   makho = %d,
                   nguoicapnhat = '%s',
                   ngaygiocapnhat = '%s',
                   tongso = %f,
                   ghichu = '%s'
                WHERE maso = '%s'";
        $sql = sprintf($sql, $ngay, $makho, $nguoicapnhat, $ngaygiocapnhat, $tongso, $ghichu, $maso);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }
    
    // Kiem tra chi tiet doanh thu cua mot ngay
    function _kiem_tra($ngay, $count)
    {
        $sql = "SELECT COUNT(chitietdoanhthu.maso) AS num
                FROM chitietdoanhthu 
                        INNER JOIN doanhthu ON chitietdoanhthu.maso = doanhthu.maso
                WHERE DATEDIFF(doanhthu.ngay, '%s') = 0";
        $sql = sprintf($sql, $ngay);

        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array($result);
        $this->disconnect();
        //echo $row['num'] . '<br />' . $count . '<br />';
        return ($row['num'] == $count);
    }
    
    // Tao bang doanh thu va chi tiet doanh thu cua mot ngay
    function tao_bang_doanh_thu($ngay)
    {
        $db = new khohang();
        $store_list = $db->danh_sach();
        $db = new loaitranh();
        $type_list = $db->danh_sach();
        $ctdt = new chitietdoanhthu();
        
        if( ! $this->_kiem_tra($ngay, count($store_list) * count($type_list)))
        {
            foreach($store_list as $store)
            {
                // Them vao bang doanh thu
                $makho = $store['makho'];
                $maso[$makho] = $this->_tao_ma_so($ngay, $makho);
                $this->them($maso[$makho], $ngay, $makho, ACCOUNT_ADMIN, date("Y-m-d H:i:s"), 0, '');
                
                // Them vao bang chi tiet doanh thu
                foreach($type_list as $type)
                {
                    $ctdt->them($maso[$makho], $type['maloai'], 0);
                }
            }
        }
    }
    //-- REQ20120508_BinhLV_N
    
    //++ REQ20120508_BinhLV_N
    // Tao bang thong ke doanh thu, gom nhom theo kho hang
    function _create_array($data)
    {
        $db = new loaitranh();
        $type_list = $db->danh_sach();
        $makho = NULL;
        $count = 0;
        foreach ($data as $value)
        {
            if ($makho != $value['makho'])
            {
                $count = 0;
                $item = array();
                $item['maso'] = $value['maso'];
                $item['ngay'] = $value['ngay'];
                $item['makho'] = $value['makho'];
                $item['tenkho'] = $value['tenkho'];
                $item['nguoicapnhat'] = $value['nguoicapnhat'];
                $item['ngaygiocapnhat'] = $value['ngaygiocapnhat'];
                $item['tongso'] = $value['tongso'];
                $item['ghichu'] = $value['ghichu'];
                $item[$value['maloai']] = array('sotien' => $value['sotien']);
            }
            else
            {
                ++$count;
                $item[$value['maloai']] = array('sotien' => $value['sotien']);
                if($count === count($type_list) - 1)
                {
                    $result[] = $item;
                }
            }
            $makho = $value['makho'];
        }
        return $result;
    }
    //-- REQ20120508_BinhLV_N
    
    //-- REQ20120508_BinhLV_M
    // Thong ke doanh thu cua cac kho theo ngay
    public static $query_bang_doanh_thu = "SELECT doanhthu.*,
                                                  khohang.tenkho,
                                                  chitietdoanhthu.maloai,
                                                  chitietdoanhthu.sotien    
                                           FROM doanhthu
                                                      INNER JOIN khohang ON doanhthu.makho = khohang.makho                                       
                                                      INNER JOIN chitietdoanhthu ON doanhthu.maso = chitietdoanhthu.maso
                                           WHERE DATEDIFF(doanhthu.ngay, '%s') = 0
                                           ORDER BY khohang.tenkho";                                                                                           
    function bang_doanh_thu($ngay)
    {
        $sql = sprintf(doanhthu::$query_bang_doanh_thu, $ngay);
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        return $this->_create_array($result);
        //return $result;
    }
    //-- REQ20120508_BinhLV_M
    
    //++ REQ20120508_BinhLV_N
    // Tao bang tong hop thong ke doanh thu, gom nhom theo ngay
    function _create_report_array($data, $export = FALSE)
    {
        $db = new loaitranh();
        $type_list = $db->danh_sach();
        $test = array();      // Dong thong ke tong cong
        $tongso = 0;          // Tong cua cac cot 'Tong so'
        $count = 0;
        $ngay = NULL;
        
        // Khoi tao dong thong ke tong cong
        if( ! $export)
        {
            $test['ngay']           = 'Tổng số';
            $test['nguoicapnhat']   = '';
            $test['ngaygiocapnhat'] = '';
            $test['tongso']         = 0;
            $test['ghichu']         = '';
            foreach($type_list as $type)
            {
                $test[$type['maloai']] = array('sotien' => 0);
            }
        }
        else
        {
            $test['Ngày'] = 'Tổng số';
            foreach($type_list as $type)
            {
                $test[$type['tenloai']] = 0;
            }
        }
        
        // Tao danh sach cac dong tong hop
        foreach ($data as $value)
        {
            if ($ngay != $value['ngay'])
            {
                $count = 0;
                $item = array();
                if( ! $export)
                {
                    $item['ngay'] = $value['ngay'];
                    $item['nguoicapnhat'] = $value['nguoicapnhat'];
                    $item['ngaygiocapnhat'] = $value['ngaygiocapnhat'];
                    $item['tongso'] = $value['tongso'];
                    $item['ghichu'] = $value['ghichu'];
                    $item[$value['maloai']] = array('sotien' => $value['sotien']);
                    // Dong tong hop tong so
                    $test[$value['maloai']]['sotien'] += $value['sotien'];
                    $tongso += $value['tongso'];
                }
                else
                {
                    $item['Ngày'] = $value['ngay'];
                    $item[$value['loaisanpham']] = number_2_string($value['sotien'], '');
                    // Dong tong hop tong so
                    $test[$value['loaisanpham']] += $value['sotien'];
                    $tongso += $value['tongso'];
                }
            }
            else
            {
                ++$count;
                if( ! $export)
                {
                    $item[$value['maloai']] = array('sotien' => $value['sotien']);
                    // Dong tong hop tong so
                    $test[$value['maloai']]['sotien'] += $value['sotien'];
                }
                else
                {
                    $item[$value['loaisanpham']] = number_2_string($value['sotien'], '');
                    // Dong tong hop tong so
                    $test[$value['loaisanpham']] += $value['sotien'];
                }
                if($count === count($type_list) - 1)
                {
                    if($export)
                    {
                        $item['Tổng số'] = number_2_string($value['tongso'], '');
                        $item['Người cập nhật'] = $value['nguoicapnhat'];
                        $item['Ngày giờ cập nhật'] = $value['ngaygiocapnhat'];
                        $item['Ghi chú'] = $value['ghichu'];
                    }
                    
                    $array[] = $item;
                }
            }
            $ngay = $value['ngay'];
        }
        // Dong tong hop tong so
        if( ! $export)
        {
            $test['tongso'] = $tongso;
        }
        else
                {
            $test['Tổng số'] = $tongso;
            $test['Người cập nhật'] = '';
            $test['Ngày giờ cập nhật'] = '';
            $test['Ghi chú'] = '';
        }
        
        // Ghep cac ket qua lai (dua dong thong ke tong cong len dau tien)
        $result[] = $test;
        if($array):
            foreach ($array as $item)
            {
                $result[] = $item;
            }
        endif;
        
        return $result;
    }
    //-- REQ20120508_BinhLV_N
    
    //++ REQ20120508_BinhLV_N
    // Tao danh sach cac cot export ra Excel cua bang doanh thu
    function danh_sach_column($data)
    {
        $db = new loaitranh();
        $type_list = $db->danh_sach();
        
        $result = array();
        $result[] = 'Ngày';
        foreach($type_list as $value)
            $result[] = $value['tenloai'];
        $result[] = 'Tổng số';
        $result[] = 'Người cập nhật';
        $result[] = 'Ngày giờ cập nhật';
        $result[] = 'Ghi chú';        
        
        /*$result = array();
        foreach($data as $row)
        {
            foreach($row as $key => $value)
                $result[] = $key;
            break;
        }*/
            
        return $result;
    }
    
    //++ REQ20120508_BinhLV_M
    // Tong hop doanh thu cua mot kho theo khoang thoi gian
    public static $query_tong_hop_doanh_thu = "SELECT doanhthu.ngay,
                                                      khohang.tenkho AS showroom,
                                                      doanhthu.tongso,
                                                      chitietdoanhthu.maloai,
                                                      loaitranh.tenloai AS loaisanpham,
                                                      chitietdoanhthu.sotien,
                                                      doanhthu.nguoicapnhat,
                                                      doanhthu.ngaygiocapnhat,
                                                      doanhthu.ghichu
                                                FROM doanhthu
                                                      INNER JOIN khohang ON doanhthu.makho = khohang.makho                                       
                                                      INNER JOIN chitietdoanhthu ON doanhthu.maso = chitietdoanhthu.maso
                                                      INNER JOIN loaitranh ON chitietdoanhthu.maloai = loaitranh.maloai
                                               WHERE doanhthu.makho = '%s' AND (doanhthu.ngay BETWEEN '%s' AND '%s')
                                                ORDER BY ngay ASC";    
    function tong_hop_doanh_thu($makho, $tungay, $denngay, $export = FALSE)
    {
        $sql = sprintf(doanhthu::$query_tong_hop_doanh_thu, $makho, $tungay, $denngay);
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        return $this->_create_report_array($result, $export);
        //return $result;
    }
    //-- REQ20120508_BinhLV_M
}