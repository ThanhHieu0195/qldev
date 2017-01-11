<?php
//++ REQ20120915_BinhLV_N

require_once 'database.php';
require_once 'helper.php';
require_once 'nhanvien.php';
require_once 'donhang.php';

class coupon_used extends database {
    
    // Them mot record moi
    // Data them vao co dang array(key => value)
    function add_new($data)
    {
        if(is_array($data))
        {
            $insert = "INSERT INTO coupon_used(used_date, ";
            $value = "VALUES(CURRENT_TIMESTAMP(), ";
            
            foreach ($data as $k => $v)
            {
                $insert = $insert . $k . ", ";
                $value = $value . "'" . $v . "', ";
            }
            $insert = substr_replace( $insert, "", -2 );
            $value = substr_replace( $value, "", -2 );
            
            $insert = $insert . ")";
            $value = $value . ")";
            
            $sql = "$insert $value";
            
            $this->setQuery($sql);
            $result = $this->query();
            $this->disconnect();
            
            return $result;
        }
        
        return FALSE;
    }
    
    // Update thong tin mot record
    // Data co dang array(key => value)
    function update($coupon_code, $data)
    {
        if(is_array($data))
        {
            $set = "";
    
            foreach ($data as $k => $v)
            {
                $set = $set . sprintf("%s = '%s', ", $k, $v);
            }
            $set = substr_replace( $set, "", -2 );
    
            $sql = "UPDATE coupon_used SET $set WHERE coupon_code = '$coupon_code'";
            
            $this->setQuery($sql);
            $result = $this->query();
            $this->disconnect();
            
            return $result;
        }
    
        return FALSE;
    }
    
    // Chi tiet used cua mot coupon
    function used_detail($data, $coupon_code=NULL)
    {
        $where = "";
        if(is_array($data))
        {
            $where = "WHERE ";
            foreach ($data as $k => $v)
            {
                $where = $where . sprintf("%s = '%s' AND ", $k, $v);
            }
            $where = substr_replace( $where, "", -5 );
        }
        
        $sql = "SELECT coupon_code, ";
        if(isset($coupon_code))
        {
            $sql .= "( SELECT content
                        FROM coupon_group
                        WHERE group_id = (SELECT group_id FROM coupon WHERE coupon_code = '$coupon_code')
                    ) AS content,";
        }
        else
        {
            $sql .= "( SELECT content
                       FROM coupon_group
                       WHERE group_id = (SELECT group_id FROM coupon WHERE coupon.coupon_code = coupon_used.coupon_code)
                     ) AS content,";
        }
        $sql .= "used_by,
                 used_date,
                 bill_code
                FROM coupon_used
                $where";

        $this->setQuery($sql);
        $array = mysql_fetch_assoc($this->query());
        $this->disconnect();
    
        if(is_array($array))
            return $array;
        return FALSE;
    }
    
    // Thong ke so luong used trong mot nam
    function statistic($year)
    {
        $result = FALSE;
        $month = array( '01' => 1, '02' => 2, '03' => 3, '04' => 4, '05' => 5, '06' => 6,
                        '07' => 7, '08' => 8, '09' => 9, '10' => 10, '11' => 11, '12' => 12,
                      );
    
        $sql = "SELECT MONTH(used_date) AS month, COUNT(*) AS amount
                FROM coupon_used
                WHERE YEAR(used_date) = %d
                GROUP BY MONTH(used_date)";
        $sql = sprintf($sql, $year);
        $this->setQuery($sql);
        $q = $this->loadAllRow();
        $this->disconnect();
    
        if(is_array($q))
        {
            $array = array();
            foreach ($q as $row)
            {
                $array[$row['month']] = $row['amount'];
            }
    
            $result = array();
            foreach ($month as $key => $value)
            {
                if(isset($array[$value]))
                    $result[$key] = $array[$value];
                else
                    $result[$key] = 0;
            }
        }
    
        return $result;
    }

    // Thong ke tien doanh thu cua moi cong tac vien
    function _freelancer_statistic_by_id($uid, $from, $to, $status)
    {
        $approved = donhang::$APPROVED;
        $assign_type = COUPON_ASSIGN_FREELANCER_NEW;

        $sql = "SELECT DATE(coupon_used.used_date) AS used_date,
                       TIME(coupon_used.used_date) AS used_time,
                       coupon_used.bill_code,
                       coupon_group.content,
                       coupon_used.coupon_code,
                       khach.hoten,
                       donhang.thanhtien
                FROM coupon_used INNER JOIN donhang ON coupon_used.bill_code = donhang.madon
                                 INNER JOIN khach ON donhang.makhach = khach.makhach
                                 INNER JOIN coupon ON coupon_used.coupon_code = coupon.coupon_code
                                 INNER JOIN coupon_group ON coupon.group_id = coupon_group.group_id
                WHERE coupon_used.coupon_code IN (SELECT coupon_code FROM coupon_assign WHERE assign_to = $uid AND assign_type = '$assign_type')
                      AND (DATE(coupon_used.used_date) BETWEEN '$from' AND '$to')
                      AND donhang.approved = $approved";
        if(isset($status))
        {
            $sql .= " AND donhang.trangthai = $status";
        }
        $sql .= " ORDER BY coupon_used.used_date ASC";
        $this->setQuery($sql);
        $array = $this->loadAllRow();
        $this->disconnect();
        
        if(is_array($array))
        {
            //debug($array);
            return $array;
        }
        
        return NULL;
    }

    // Thong ke doanh thu cua cong tac vien
    function freelancer_statistic($uid, $from, $to, $status = NULL, $export = FALSE, &$field_list = NULL, &$column_name = NULL)
    {
        if($export)
        {
            $field_list = array('used_date', 'used_time', 'bill_code', 'coupon_code', 'content', 'hoten', 'thanhtien');
            $column_name = array('Ngày', 'Giờ', 'Hóa đơn', 'Coupon', 'Nội dung coupon', 'Khách hàng', 'Thành tiền');
        }
        
        $tong_tien = 0;
        
        if(empty($from))
        {
            $from = NULL;
        }
        if(empty($to))
        {
            $to = NULL;
        }
        
        if(isset($from) && isset($to))
        {
            $arr = $this->_freelancer_statistic_by_id($uid, $from, $to, $status);
            
            if(is_array($arr))
            {
                //debug($arr);
                $output = array();
                
                for($i=0; $i<count($arr); $i++)
                {
                    $item = $arr[$i];

                    $row = array();
                    if($export)
                    {
                        $row['used_date']   = $item['used_date'];
                        $row['used_time']   = $item['used_time'];
                        $row['bill_code']   = $item['bill_code'];
                        $row['coupon_code'] = $item['coupon_code'];
                        $row['content']     = $item['content'];
                        $row['hoten']       = $item['hoten'];
                        $row['thanhtien']   = number_2_string($item['thanhtien'], '.');
                    }
                    else
                    {
                        $row[] = $item['used_date'];
                        $row[] = $item['used_time'];
                        $row[] = $item['bill_code'];
                        $row[] = $item['coupon_code'];
                        $row[] = $item['content'];
                        $row[] = $item['hoten'];
                        $row[] = number_2_string($item['thanhtien'], '.');
                    }
                    
                    $output[] = $row;
                    
                    $tong_tien += $item['thanhtien'];
                }
            }
        }
        
        $result = array();
        $row = array();
        if($export)
        {
            $row['used_date']   = 'Tổng số';
            $row['used_time']   = '';
            $row['bill_code']   = '';
            $row['coupon_code'] = '';
            $row['content']     = '';
            $row['hoten']       = '';
            $row['thanhtien']   = number_2_string($tong_tien, '.');
        }
        else
        {
            $row[] = 'Tổng số';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = number_2_string($tong_tien, '.');
        }
        $result[] = $row;
        
        if(isset($output) && is_array($output))
        {
            foreach($output as $row)
            {
                $result[] = $row;
            }
        }
        
        return $result;
    }

    // Thong ke doanh thu cua cong tac vien (dung cho export file Excel)
    function freelancer_statistic_export($uid, $from, $to, &$field_list, &$column_name)
    {
        $field_list = array('used_date', 'used_time', 'bill_code', 'coupon_code', 'content', 'hoten', 'thanhtien');
        $column_name = array('Ngày', 'Giờ', 'Hóa đơn', 'Coupon', 'Nội dung coupon', 'Khách hàng', 'Thành tiền');
        
        $tong_tien_cho_giao = 0;
        $tong_tien_da_giao = 0;
        
        if(empty($from))
        {
            $from = NULL;
        }
        if(empty($to))
        {
            $to = NULL;
        }
        
        if(isset($from) && isset($to))
        {
            // Don hang cho giao
            $arr_chogiao = $this->_freelancer_statistic_by_id($uid, $from, $to, donhang::$CHO_GIAO);
            
            if(is_array($arr_chogiao))
            {
                $output_chogiao = array();
                for($i=0; $i<count($arr_chogiao); $i++)
                {
                    $item = $arr_chogiao[$i];

                    $row = array();
                    $row['used_date']   = $item['used_date'];
                    $row['used_time']   = $item['used_time'];
                    $row['bill_code']   = $item['bill_code'];
                    $row['coupon_code'] = $item['coupon_code'];
                    $row['content']     = $item['content'];
                    $row['hoten']       = $item['hoten'];
                    $row['thanhtien']   = number_2_string($item['thanhtien'], '.');
                    
                    $output_chogiao[] = $row;
                    
                    $tong_tien_cho_giao += $item['thanhtien'];
                }
            }

            // Don hang da giao
            $arr_dagiao = $this->_freelancer_statistic_by_id($uid, $from, $to, donhang::$DA_GIAO);
            
            if(is_array($arr_dagiao))
            {
                $output_dagiao = array();
                for($i=0; $i<count($arr_dagiao); $i++)
                {
                    $item = $arr_dagiao[$i];

                    $row = array();
                    $row['used_date']   = $item['used_date'];
                    $row['used_time']   = $item['used_time'];
                    $row['bill_code']   = $item['bill_code'];
                    $row['coupon_code'] = $item['coupon_code'];
                    $row['content']     = $item['content'];
                    $row['hoten']       = $item['hoten'];
                    $row['thanhtien']   = number_2_string($item['thanhtien'], '.');
                    
                    $output_dagiao[] = $row;
                    
                    $tong_tien_da_giao += $item['thanhtien'];
                }
            }
        }
        
        $result_chogiao = array();
        $row = array();
        $row['used_date']   = 'Tổng số';
        $row['used_time']   = '';
        $row['bill_code']   = '';
        $row['coupon_code'] = '';
        $row['content']     = '';
        $row['hoten']       = '';
        $row['thanhtien']   = number_2_string($tong_tien_cho_giao, '.');
        $result_chogiao[] = $row;

        $result_dagiao = array();
        $row = array();
        $row['used_date']   = 'Tổng số';
        $row['used_time']   = '';
        $row['bill_code']   = '';
        $row['coupon_code'] = '';
        $row['content']     = '';
        $row['hoten']       = '';
        $row['thanhtien']   = number_2_string($tong_tien_da_giao, '.');
        $result_dagiao[] = $row;
        
        if(is_array($output_chogiao))
        {
            foreach($output_chogiao as $row)
            {
                $result_chogiao[] = $row;
            }
        }

        if(is_array($output_dagiao))
        {
            foreach($output_dagiao as $row)
            {
                $result_dagiao[] = $row;
            }
        }
        
        return array($result_chogiao, $result_dagiao);
    }

    // Thong ke tien doanh thu cua moi cong tac vien
    function _freelancer_trade_total_by_id($uid, $from, $to, $status)
    {
        $approved = donhang::$APPROVED;
        $assign_type = COUPON_ASSIGN_FREELANCER_NEW;

        $sql = "SELECT SUM(donhang.thanhtien) AS thanhtien
                FROM coupon_used INNER JOIN donhang ON coupon_used.bill_code = donhang.madon
                WHERE coupon_used.coupon_code IN (SELECT coupon_code FROM coupon_assign WHERE assign_to = $uid AND assign_type = '$assign_type')
                      AND (DATE(coupon_used.used_date) BETWEEN '$from' AND '$to')
                      AND donhang.approved = $approved";
        if(isset($status))
        {
            $sql .= " AND donhang.trangthai = $status";
        }
        //debug($status);
        //debug($sql);
        $this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_array($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            return $array['thanhtien'];
        }
        
        return 0;
    }

    // Thong ke danh sach doanh thu cua cac cong tac vien
    function freelancer_statistic_list($from, $to, $status = NULL, $export = FALSE, &$field_list = NULL, &$column_name = NULL)
    {
        if($export)
        {
            $field_list = array('account', 'hoten', 'doanhthu');
            $column_name = array('Cộng tác viên', 'Họ tên', 'Doanh thu');
        }
        
        $tong_tien = 0;
        
        if(empty($from))
        {
            $from = NULL;
        }
        if(empty($to))
        {
            $to = NULL;
        }
        
        if(isset($from) && isset($to))
        {
            $nhanvien = new nhanvien();
            $arr = $nhanvien->employee_list('freelancer');
            
            if(is_array($arr))
            {
                //debug($arr);
                foreach($arr as $item)
                {
                    $doanhthu = $this->_freelancer_trade_total_by_id($item['uid'], $from, $to, $status);

                    $row = array();
                    if($export)
                    {
                        $row['account']  = $item['manv'];
                        $row['hoten']    = $item['hoten'];
                        $row['doanhthu'] = number_2_string($doanhthu, '.');
                    }
                    else
                    {
                        $row[] = $item['manv'];
                        $row[] = $item['hoten'];
                        $row[] = number_2_string($doanhthu, '.');
                        $row[] = $item['uid'];
                    }
                    $output[] = $row;
                    
                    $tong_tien += $doanhthu;
                }
            }
        }
        
        $result = array();
        $row = array();
        if($export)
        {
            $row['account']   = 'Tổng số';
            $row['hoten']   = '';
            $row['doanhthu']   = number_2_string($tong_tien, '.');
        }
        else
        {
            $row[] = 'Tổng số';
            $row[] = '';
            $row[] = number_2_string($tong_tien, '.');
            $row[] = '';
        }
        $result[] = $row;
        
        if(is_array($output))
        {
            foreach($output as $row)
            {
                $result[] = $row;
            }
        }
        
        return $result;
    }

    // Thong ke danh sach doanh thu cua cac cong tac vien (dung cho export file Excel)
    function freelancer_statistic_list_export($from, $to, &$field_list, &$column_name)
    {
        $field_list = array('account', 'hoten', 'doanhthu');
        $column_name = array('Cộng tác viên', 'Họ tên', 'Doanh thu');
        
        $tong_tien_cho_giao = 0;
        $tong_tien_da_giao = 0;
        
        if(empty($from))
        {
            $from = NULL;
        }
        if(empty($to))
        {
            $to = NULL;
        }
        
        if(isset($from) && isset($to))
        {
            $nhanvien = new nhanvien();
            $arr = $nhanvien->employee_list('freelancer');
            
            if(is_array($arr))
            {
                //debug($arr);
                foreach($arr as $item)
                {
                    $row_chogiao = array();
                    $row_dagiao = array();

                    $doanhthu_chogiao = $this->_freelancer_trade_total_by_id($item['uid'], $from, $to, donhang::$CHO_GIAO);
                    $doanhthu_dagiao = $this->_freelancer_trade_total_by_id($item['uid'], $from, $to, donhang::$DA_GIAO);

                    $row_chogiao['account']  = $item['manv'];
                    $row_chogiao['hoten']    = $item['hoten'];
                    $row_chogiao['doanhthu'] = number_2_string($doanhthu_chogiao, '.');

                    $row_dagiao['account']  = $item['manv'];
                    $row_dagiao['hoten']    = $item['hoten'];
                    $row_dagiao['doanhthu'] = number_2_string($doanhthu_dagiao, '.');

                    $output_chogiao[] = $row_chogiao;
                    $output_dagiao[] = $row_dagiao;
                    
                    $tong_tien_cho_giao += $doanhthu_chogiao;
                    $tong_tien_da_giao += $doanhthu_dagiao;
                }
            }
        }
        
        // Tong tien don hang cho giao
        $result_chogiao = array();
        $row = array();
        $row['account']   = 'Tổng số';
        $row['hoten']   = '';
        $row['doanhthu']   = number_2_string($tong_tien_cho_giao, '.');
        $result_chogiao[] = $row;

        // Tong tien don hang da giao
        $result_dagiao = array();
        $row = array();
        $row['account']   = 'Tổng số';
        $row['hoten']   = '';
        $row['doanhthu']   = number_2_string($tong_tien_da_giao, '.');
        $result_dagiao[] = $row;
        
        if(is_array($output_chogiao))
        {
            foreach($output_chogiao as $row)
            {
                $result_chogiao[] = $row;
            }
        }

        if(is_array($output_dagiao))
        {
            foreach($output_dagiao as $row)
            {
                $result_dagiao[] = $row;
            }
        }
        
        return array($result_chogiao, $result_dagiao);
    }
}

/* End of file coupon_used.php */
/* Location: ./models/coupon_used.php */