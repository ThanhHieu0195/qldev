<?php

require_once 'database.php';

class bill_note extends database {
    
    public static $MSG_RETURN             = 'Trả hàng: %s';
    public static $MSG_DELIVERY           = 'Giao hàng: <b>%s</b> từ showroom: <b>%s</b> (Id: %d)';
    public static $MSG_UPDATE_BILL        = 'Update thông tin đơn hàng:';
    public static $MSG_UPDATE_BILL_ITEM   = '<br />• %s: [%s] => [%s]';

    // Them mot ghi chu vao trong database
    function add_new($create_by, $bill_code, $content)
    {
        $sql = "INSERT INTO bill_note(id, create_date, create_by, bill_code, content)
                VALUES('%s', CURRENT_TIMESTAMP(), '%s', '%s', '%s')";
        $sql = sprintf($sql, uniqid('', true), $create_by, $bill_code, $content);
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Xoa mot ghi chu
    function delete($id)
    {
        $sql = "DELETE FROM bill_note WHERE id = '%s'";
        $sql = sprintf($sql, $id);
    
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Danh sach cac ghi chu cua mot hoa don
    function get_note_list($bill_code)
    {
        $sql = "SELECT id, create_date, create_by, bill_code, content
                FROM bill_note
                WHERE bill_code = '%s'
                ORDER BY create_date ASC";
        $sql = sprintf($sql, $bill_code);
    
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
    
        return $result;
    }
}

/* End of file bill_note.php */
/* Location: ./models/bill_note.php */