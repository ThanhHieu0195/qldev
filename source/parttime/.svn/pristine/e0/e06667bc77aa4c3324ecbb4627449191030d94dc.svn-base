<?php
//++ REQ20120915_BinhLV_N

require_once 'database.php';
require_once 'helper.php';

class coupon_group extends database {
    
    // Them mot nhom coupon moi
    function add_new($group_id, $content, $description)
    {
        $sql = "INSERT INTO coupon_group VALUES('%s', '%s', '%s')";
        $sql = sprintf($sql, $group_id, $content, $description);
        
        $this->setQuery($sql);        
        $result = $this->query();
        $this->disconnect();
        
        return $result;
    }
    
    // Cap nhat thong tin mot nhom coupon
    function update($group_id, $content, $description)
    {
        $sql = "UPDATE coupon_group SET content = '%s', description = '%s' WHERE group_id = '%s'";
        $sql = sprintf($sql, $content, $description, $group_id);
    
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Lay thong tin chi tiet cua mot nhom coupon
    function detail($group_id)
    {
        $sql = "SELECT group_id, content, description FROM coupon_group WHERE group_id = '%s'";
        $sql = sprintf($sql, $group_id);
    
        $this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
    
        return $array;
    }
    
    // Xoa mot nhom coupon
    function delete($group_id)
    {
        $sql = "DELETE FROM coupon_group WHERE group_id = '%s'";
        $sql = sprintf($sql, $group_id);
    
        $this->setQuery($sql);        
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Lay danh sach cac nhom coupon
    function get_list()
    {
        $sql = "SELECT group_id, content, description FROM coupon_group";
        $this->setQuery($sql);
    
        $result = $this->loadAllRow();
        $this->disconnect();
        
        return $result;
    }
    
    // Danh sach tong hop nhom coupon va so luong coupon co san cua moi nhom
    function general_list()
    {
    	$sql = "SELECT coupon_group.group_id,
    	               coupon_group.content, 
                       (SELECT COUNT(group_id) FROM coupon WHERE coupon.group_id = coupon_group.group_id AND coupon.status = 'V') AS amount
                FROM coupon_group";
    	$this->setQuery($sql);
    
    	$result = $this->loadAllRow();
    	$this->disconnect();
    
    	return $result;
    }
}

/* End of file coupon_group.php */
/* Location: ./models/coupon_group.php */