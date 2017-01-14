<?php
//++ REQ20120915_BinhLV_N

require_once 'database.php';
require_once 'helper.php';
require_once 'coupon_assign.php';
require_once 'khach.php';
require_once 'donhang.php';

function changtonumdatebyformat($fm) {
    $arr = explode("d", $fm);
    if (count($arr) == 2) {
        return intval($arr[0]);
    }

    $arr = explode("m", $fm);
    
    if (count($arr) == 2) {
        return intval($arr[0])*30;
    }

    return intval(strtotime($fm))/86400;
}

class coupon extends database {

    function get_list_coupon_for_guest($group_id) {
        $sql = "SELECT * FROM `coupon` WHERE `group_id` LIKE '$group_id' AND `status` = 'V';";
        //error_log ("Add new ". $sql , 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();

        $current_date = changtonumdatebyformat(date("Y-m-d"));

        while ($row = mysql_fetch_assoc($result)) {
            # code...
            # xd
            $expire_time = $row['expire_time'];
            $row['expire_time'] = changtonumdatebyformat($expire_time);
            #xy
            $total_time_coupon = $expire_time + changtonumdatebyformat($row['generate_date']);
            $time_again = $total_time_coupon - $current_date;
            if ($time_again >= 0) {
                $arr[] = $row;
            }
        }
        return $arr;
    }
    
    // Kiem tra mot coupon co ton tai
    function is_exist($coupon_code)
    {
        $sql = "SELECT coupon_code FROM coupon WHERE coupon_code = '%s'";
        $sql = sprintf($sql, $coupon_code);
        
        $this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        return is_array($array);
    }
    
    // Generate coupon code chu co trong database
    function generate_code($length)
    {
        $coupon_code = random_string($length);
        while($this->is_exist($coupon_code))
            $coupon_code = random_string($length);
    
        return $coupon_code;
    }
    
    // Them mot coupon vao trong database
    function add_new($coupon_code, $group_id, $expire_time)
    {
        $sql = "INSERT INTO coupon(coupon_code, expire_time, group_id, generate_date, status)
	            VALUES('%s', '%s', '%s', CURRENT_TIMESTAMP(), '%s')";
        $sql = sprintf($sql, $coupon_code, $expire_time, $group_id, COUPON_STATUS_VACANCY);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Cap nhat trang thai cua mot coupon
    function update_status($coupon_code, $status)
    {
    	$sql = "UPDATE coupon SET status = '%s' WHERE coupon_code = '%s'";
    	$sql = sprintf($sql, $status, $coupon_code);
    
    	$this->setQuery($sql);
    	$result = $this->query();
    	$this->disconnect();
    
    	return $result;
    }
    
    // Lay mot coupon co san cua mot nhom
    function get_vacancy($group_id)
    {
    	$sql = "SELECT coupon_code, expire_time
                FROM coupon 
                WHERE group_id = '%s' AND STATUS = '%s' 
                LIMIT 1";
    	$sql = sprintf($sql, $group_id, COUPON_STATUS_VACANCY);
    
    	$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            $obj = (object) $array;
            return $obj;
        }
        return NULL;
    }
    
    // Assign mot coupon moi
    function assign_new($assign_to, $bill_code, $group_id, $assign_type, $amount=1, $third_used=FALSE)
    {
        $result = FALSE;
        $coupon_assign = new coupon_assign();
        $donhang = new donhang();
        
        for($i = 1; $i <= $amount; $i++)
        {
            $obj = $this->get_vacancy($group_id);
            
            if($obj != NULL)
            {
                // Them vao bang 'coupon_assign'
                $result = $coupon_assign->add_new($obj->coupon_code, $assign_to, $obj->expire_time, $bill_code, $assign_type);
                
                // Cap nhat trang thai trong bang 'coupon'
                if($result)
                    $result = $result && $this->update_status($obj->coupon_code, COUPON_STATUS_ASSIGN);
                
                // Cap nhat so lan assign vao hoa don
                if( ! $third_used)
                {
                    if($result)
                        $done = $donhang->update($bill_code, NULL, 'assign_coupon = assign_coupon + 1');
                }
            }
        }
        
        // Cap nhat trang thai don hang cho cham soc
        if($result)
        {
            $donhang->set_support($bill_code, donhang::$SUPPORT_NEED);
        }
        
        return $result;
    }
    
    // Assign mot nhom coupon cho mot nhom khach
    function assign_guest_group($manhom, $group_id)
    {
        $count = 0;
        // Lay danh sach khach hang theo nhom
        $khach = new khach();
        $array = $khach->danh_sach_theo_nhom($manhom);
        
        // debug($array);
        
        if(is_array($array))
        {
            // Assign coupon cho tung khach hang
            foreach ($array as $item)
            {
                if($this->assign_new($item['makhach'], '', $group_id, COUPON_ASSIGN_GUEST_NEW))
                    $count++;
            }
        }
        
        return $count;
    }
    
    // Verify mot coupon code
    function verify($coupon_code)
    {
        $result = array('verify' => FALSE, 'message' => 'Coupon không tồn tại');
        
        $sql = "SELECT coupon_assign.coupon_code, 
                       expire_date, 
                       coupon.status, 
                       IFNULL(DATEDIFF(expire_date, CURRENT_TIMESTAMP()), -1) AS expired,
                       assign_type
                FROM coupon_assign inner join coupon on coupon_assign.coupon_code = coupon.coupon_code
                WHERE coupon_assign.coupon_code = '$coupon_code'";
        
        $this->setQuery($sql);
        $array = mysql_fetch_assoc($this->query());
        $this->disconnect();
        
        if(is_array($array))
        {
            switch ($array['status'])
            {
                case COUPON_STATUS_ASSIGN:
                    if($array['expired'] >= 0)
                        $result = array('verify' => TRUE, 'message' => $coupon_code, 'assign_type' => $array['assign_type']);
                    else
                        $result = array('verify' => FALSE, 'message' => 'Coupon đã hết hạn sử dụng');
                    break;
                    
                case COUPON_STATUS_USED:
                    $result = array('verify' => FALSE, 'message' => 'Coupon đã được sử dụng');
                    break;
            }
        }
        
        return $result;
    }
    
    // Cap nhat han su dung cua mot coupon
    function set_expired_date($coupon_code, $end_date)
    {
    	$sql = "UPDATE coupon SET end_date = '%s' WHERE coupon_code = '%s'";
    	$sql = sprintf($sql, $end_date, $coupon_code);
    
    	$this->setQuery($sql);
    	$result = $this->query();
    	$this->disconnect();
    
    	return $result;
    }
}
//-- REQ20120915_BinhLV_N

/* End of file coupon.php */
/* Location: ./models/coupon.php */
