<?php
//++ REQ20120915_BinhLV_N

require_once 'database.php';
require_once 'helper.php';
require_once 'donhang.php';

class coupon_third_used extends database {
        
    // Them mot record vao trong database
    function add_new($coupon_code, $assign_to, $used_by)
    {
        $sql = "INSERT INTO coupon_third_used(coupon_code, assign_to, used_by, assigned)
        VALUES('%s', '%s', '%s', 0)";
        $sql = sprintf($sql, $coupon_code, $assign_to, $used_by);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Cap nhat trang thai assigned cua mot record
    function update_assigned($coupon_code, $assigned)
    {
        $sql = "UPDATE coupon_third_used SET assigned = '%s' WHERE coupon_code = '%s'";
        $sql = sprintf($sql, $assigned, $coupon_code);
    
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Danh sach cac khach hang gioi thieu
    function third_used_list()
    {
        $sql = "SELECT t. coupon_code, t.assign_to, t.used_by, t.assigned,
                       u.bill_code, u.used_date,
                       (SELECT hoten FROM khach WHERE makhach = t.assign_to) AS assign_name,
                       (SELECT hoten FROM khach WHERE makhach = t.used_by) AS used_name
                FROM coupon_third_used t 
                                  INNER JOIN coupon_used u ON t.coupon_code = u.coupon_code
                                  INNER JOIN donhang d ON u.bill_code = d.madon
                WHERE d.approved = %d AND t.assigned = %d";
        $sql = sprintf($sql, donhang::$APPROVED, 0);
    
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
    
        return $result;
    }
}
//-- REQ20120915_BinhLV_N

/* End of file coupon_third_used.php */
/* Location: ./models/coupon_third_used.php */