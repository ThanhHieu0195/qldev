<?php
//++ REQ20120915_BinhLV_N

require_once 'database.php';
require_once 'helper.php';

class coupon_assign extends database {
        
    // Them mot coupon_assign vao trong database
    function add_new($coupon_code, $assign_to, $expire_time, $bill_code, $assign_type)
    {
        $assign_date = current_timestamp();
        $expire_date = get_expire_date($assign_date, $expire_time);
        
        if($bill_code == NULL)
        {
            $sql = "INSERT INTO coupon_assign(coupon_code, assign_to, assign_date, expire_date, assign_type)
                    VALUES('%s', '%s', '%s', '%s', '%s')";
            $sql = sprintf($sql, $coupon_code, $assign_to, $assign_date, $expire_date, $assign_type);
        }
        else
        {            
            $sql = "INSERT INTO coupon_assign(coupon_code, assign_to, assign_date, expire_date, bill_code, assign_type)
                    VALUES('%s', '%s', '%s', '%s', '%s', '%s')";
            $sql = sprintf($sql, $coupon_code, $assign_to, $assign_date, $expire_date, $bill_code, $assign_type);
        }
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // So luong coupon assign trong mot ngay
    function assign_count($date)
    {
        $sql = "SELECT COUNT(coupon_code) AS num FROM coupon_assign WHERE DATEDIFF(assign_date, '$date') = 0";
        
        $this->setQuery($sql);
        $array = mysql_fetch_assoc($this->query());
        $this->disconnect();
        
        if(is_array($array))
            return $array['num'];
        return 0;
    }
    
    // Tim kiem mot item trong danh sach export
    private function _search($array, $hoten)
    {        
        for ($i = 0, $count = count($array); $i < $count; $i++)
        {
            if(strcmp($array[$i]['hoten'], $hoten)  == 0)
                return $i; 
        }
        
        return -1;
    }
    
    // Thong ke danh sach coupon duoc assign trong mot ngay
    function assign_list($date, $export = FALSE, &$field_list = NULL, &$column_name = NULL)
    {
        $assign_type = COUPON_ASSIGN_FREELANCER_NEW;
        $makhach = NULL;
        $array = array();
        
        // Danh sach coupon assign cho khach hang
        $sql = "SELECT a.coupon_code,
                       a.expire_date,
                       g.content,
                       k.makhach, k.hoten, k.diachi, k.quan, k.tp, k.dienthoai1, k.dienthoai2, k.dienthoai3,
                       n.tennhom,
                       bill_code,
                       a.assign_type,
                       IFNULL((SELECT thanhtien FROM donhang WHERE madon = bill_code), 0) AS money,
                       (SELECT COUNT(coupon_code) FROM coupon_third_used WHERE assign_to = a. assign_to) AS third_used
                FROM coupon_assign a
                           INNER JOIN khach k ON a.assign_to = k.makhach
                           INNER JOIN nhomkhach n ON k.manhom = n.manhom
                           INNER JOIN coupon c ON a.coupon_code = c.coupon_code
                           INNER JOIN coupon_group g ON c.group_id = g.group_id
                WHERE DATEDIFF(a.assign_date, '$date') = 0
                      AND a.assign_type <> '$assign_type'
                ORDER BY k.makhach";
        $this->setQuery($sql);
        $arr1 = $this->loadAllRow();
        $this->disconnect();
        
        // Danh sach coupon assign cho cong tac vien
        $sql = "SELECT a.coupon_code,
                       a.expire_date,
                       g.content,
                       n.hoten,
                       n.diachi,
                       n.dienthoai,
                       a.bill_code,
                       a.assign_type
                FROM coupon_assign a
                           INNER JOIN nhanvien n ON a.assign_to = n.uid
                           INNER JOIN coupon c ON a.coupon_code = c.coupon_code
                           INNER JOIN coupon_group g ON c.group_id = g.group_id
                WHERE DATEDIFF(a.assign_date, '$date') = 0
                      AND a.assign_type = '$assign_type'
                ORDER BY n.uid";
        $this->setQuery($sql);
        $arr2 = $this->loadAllRow();
        $this->disconnect();

        // Merge ket qua
        $result = NULL;
        if(is_array($arr1) || is_array($arr2))
        {
            $result = array();

            if(is_array($arr1))
            {
                foreach($arr1 as $row)
                {
                    $result[] = $row;
                }
            }

            if(is_array($arr2))
            {
                foreach($arr2 as $row)
                {
                    $result[] = $row;
                }
            }
        }

        if(is_array($result))
        {
            if($export)
            {
                $field_list = array('coupon_code', 'hoten', 'tennhom', 'diachi', 'dienthoai1', 'dienthoai2', 'dienthoai3', 'bill_code', 'money', 'assign_type');
                $column_name = array('Mã coupon', 'Tên khách hàng', 'Nhóm khách', 'Địa chỉ', 'Điện thoại 1', 'Điện thoại 2', 'Điện thoại 3', 'Mã hóa đơn', 'Thành tiền', 'Loại');
            }
            
            $array_guest = array();
            $array_employee = array();
            $array_freelancer = array();
            
            /* Format for date time */
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $format = "d/m/Y";
            foreach ($result as $row)
            {
                $datetime = strtotime($row['expire_date']);
                $datetime = date($format, $datetime);
                
                if( ! $export)
                {
                    if($row['assign_type'] != COUPON_ASSIGN_FREELANCER_NEW)
                    {
                        $item = array( 'coupon_code' => $row['coupon_code'], 
                                       'content'     => $row['content'],
                                       'expire_date' => $datetime,
                                       'hoten'       => $row['hoten'],
                                       'tennhom'     => $row['tennhom'],
                                       'diachi'      => sprintf('%s, %s, %s', $row['diachi'], $row['quan'], $row['tp']),
                                       'dienthoai'   => sprintf('%s<br />%s<br />%s', $row['dienthoai1'], $row['dienthoai2'], $row['dienthoai3']),
                                       'bill_code'   => $row['bill_code'],
                                       'money'       => ($row['money'] == 0) ? '' : number_2_string($row['money']),
                                       'assign_type' => coupon_type_string($row['assign_type'])
                                     );
                    }
                    else
                    {
                        $item = array( 'coupon_code' => $row['coupon_code'], 
                                       'content'     => $row['content'],
                                       'expire_date' => $datetime,
                                       'hoten'       => $row['hoten'],
                                       'tennhom'     => '',
                                       'diachi'      => $row['diachi'],
                                       'dienthoai'   => $row['dienthoai'],
                                       'bill_code'   => $row['bill_code'],
                                       'money'       => '',
                                       'assign_type' => coupon_type_string($row['assign_type'])
                                     );
                    }

                    array_push($array, $item);
                }
                else
                {
                    switch($row['assign_type'])
                    {
                        case COUPON_ASSIGN_GUEST_NEW:
                            $index = $this->_search($array_guest, $row['hoten']);
                            break;
                            
                        case COUPON_ASSIGN_GUEST_THIRD_USED:
                            $index = $this->_search($array_employee, $row['hoten']);
                            break;
                            
                        case COUPON_ASSIGN_FREELANCER_NEW:
                            $index = $this->_search($array_freelancer, $row['hoten']);
                            break;
                    }
    
                    if($index != -1)
                    {
                        if($row['assign_type'] == COUPON_ASSIGN_GUEST_NEW)
                        {
                            $array_guest[$index]['coupon_code'] = $array_guest[$index]['coupon_code'] 
                            . sprintf("; \n%s (%s, HSD: %s)", $row['coupon_code'], $row['content'], $datetime);
                        }
                        else if($row['assign_type'] == COUPON_ASSIGN_GUEST_THIRD_USED)
                        {
                            $array_employee[$index]['coupon_code'] = $array_employee[$index]['coupon_code'] 
                            . sprintf("; \n%s (%s, HSD: %s)", $row['coupon_code'], $row['content'], $datetime);
                        }
                        else if($row['assign_type'] == COUPON_ASSIGN_FREELANCER_NEW)
                        {
                            $array_freelancer[$index]['coupon_code'] = $array_freelancer[$index]['coupon_code'] 
                            . sprintf("; \n%s (%s, HSD: %s)", $row['coupon_code'], $row['content'], $datetime);
                        }
                    }
                    else
                    {
                        if($row['assign_type'] != COUPON_ASSIGN_FREELANCER_NEW)
                        {
                            $item = array(  'coupon_code' => sprintf("%s (%s, HSD: %s)", $row['coupon_code'], $row['content'], $datetime),
                                            'content'     => 'content',
                                            'hoten'       => $row['hoten'],
                                            'tennhom'     => $row['tennhom'],
                                            'diachi'      => sprintf('%s, %s, %s', $row['diachi'], $row['quan'], $row['tp']),
                                            'dienthoai1'  => $row['dienthoai1'] . ' ',
                                            'dienthoai2'  => $row['dienthoai2'] . ' ',
                                            'dienthoai3'  => $row['dienthoai3'] . ' ',
                                            'bill_code'   => $row['bill_code'] . ' ',
                                            'money'       => ($row['money'] == 0) ? '' : number_2_string($row['money'], ''),
                                            // 'third_used' => $row['third_used'],
                                            'assign_type' => coupon_type_string($row['assign_type'])
                                         );
                        }
                        else
                        {
                            $item = array(  'coupon_code' => sprintf("%s (%s, HSD: %s)", $row['coupon_code'], $row['content'], $datetime),
                                            'content'     => 'content',
                                            'hoten'       => $row['hoten'],
                                            'tennhom'     => '',
                                            'diachi'      => $row['diachi'],
                                            'dienthoai1'  => $row['dienthoai'] . ' ',
                                            'dienthoai2'  => ' ',
                                            'dienthoai3'  => ' ',
                                            'bill_code'   => $row['bill_code'] . ' ',
                                            'money'       => '',
                                            'assign_type' => coupon_type_string($row['assign_type'])
                                         );
                        }

                        if($row['assign_type'] == COUPON_ASSIGN_GUEST_NEW)
                            array_push($array_guest, $item);
                        else if($row['assign_type'] == COUPON_ASSIGN_GUEST_THIRD_USED)
                            array_push($array_employee, $item);
                        else if($row['assign_type'] == COUPON_ASSIGN_FREELANCER_NEW)
                            array_push($array_freelancer, $item);
                    }
                }
            }
        }
        
        if($export)
        {
            array_push($array, $array_guest);
            array_push($array, $array_employee);
            array_push($array, $array_freelancer);
        }
        
        return $array;
    }
    
    // Chi tiet assign cua mot coupon
    function assign_detail($coupon_code)
    {
        $sql = "SELECT  coupon_code,
                        ( SELECT content
                          FROM coupon_group
                          WHERE group_id = (SELECT group_id FROM coupon WHERE coupon_code = '$coupon_code')
                        ) AS content,
                        expire_date,
                        assign_to,
                        assign_date, 
                        bill_code, 
                        assign_type
               FROM coupon_assign 
               WHERE coupon_code = '$coupon_code'";
        $this->setQuery($sql);
        $array = mysql_fetch_assoc($this->query());
        $this->disconnect();
        
        if(is_array($array))
            return $array;
        return FALSE;
    }
    
    // Thong ke so luong assign trong mot nam
    function statistic($year)
    {
        $result = FALSE;
        $month = array( '01' => 1, '02' => 2, '03' => 3, '04' => 4, '05' => 5, '06' => 6,
                        '07' => 7, '08' => 8, '09' => 9, '10' => 10, '11' => 11, '12' => 12, 
                      );
        
        $sql = "SELECT MONTH(assign_date) AS month, COUNT(*) AS amount
                FROM coupon_assign
                WHERE YEAR(assign_date) = %d
                GROUP BY MONTH(assign_date)";
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
    
    // Thong ke danh sach coupon duoc assign cho mot hoa don
    function assign_list_for_bill($madon, $html = TRUE)
    {          
        $sql = "SELECT a.coupon_code,
                       a.expire_date,
                       g.content,
                       a.assign_type
                FROM coupon_assign a
                           INNER JOIN coupon c ON a.coupon_code = c.coupon_code
                           INNER JOIN coupon_group g ON c.group_id = g.group_id
                WHERE bill_code = '$madon'
                ORDER BY a.expire_date";
        
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        
        if($html)
        {            
            if(is_array($result))
            {
                $output = "";
                $item_format = "&bull; %s (%s, HSD: %s)<br />";
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $format = "d/m/Y";
                foreach ($result as $row)
                {
                    $datetime = strtotime($row['expire_date']);
                    $datetime = date($format, $datetime);                    
                    $output .= sprintf($item_format, $row['coupon_code'], $row['content'], $datetime);
                }
                
                return $output;
            }
            else
            {
                return "";
            }
        }
        else
        {
            return $result;
        }
    }

    // Thong ke so luong coupon duoc assign cho mot cong tac vien
    function statistic_assign_for_freelancer($uid)
    {
        $total   = 0;
        $expired = 0;
        $used    = 0;
        $valid   = 0;

        $assign_type = COUPON_ASSIGN_FREELANCER_NEW;

        $sql = "SELECT coupon_assign.coupon_code,
                       DATEDIFF(coupon_assign.expire_date, CURRENT_TIMESTAMP) AS expired,
                       coupon.status
                FROM coupon_assign INNER JOIN coupon ON coupon_assign.coupon_code = coupon.coupon_code
                WHERE assign_to = $uid AND assign_type = '$assign_type'";
        
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        
        if(is_array($result))
        {
            foreach ($result as $row)
            {
                $total++;

                switch($row['status'])
                {
                    case COUPON_STATUS_ASSIGN:
                        if($row['expired'] < 0)
                            $expired++;
                        else
                            $valid++;
                        break;
                        
                    case COUPON_STATUS_USED:
                        $used++;
                        break;
                }
            }
        }

        $output = "";
        $output .= sprintf("&bull; <span style='color:rgb(22,167,101);'>Total:</span> %d<br />", $total);
        $output .= sprintf("&bull; <span style='color:rgb(73,134,231);'>Expired:</span> %d<br />", $expired);
        $output .= sprintf("&bull; <span style='color:rgb(246,145,178);'>Used:</span> %d<br />", $used);
        $output .= sprintf("&bull; <span style='color:rgb(251,76,47);'>Valid:</span> %d", $valid);

        return $output;
    }
}
//-- REQ20120915_BinhLV_N

/* End of file coupon_assign.php */
/* Location: ./models/coupon_assign.php */