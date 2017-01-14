<?php

/**
 * @author Luu Binh
 * @copyright 2012
 */

include_once 'database.php';

class chitietdoanhthu extends database {
    // Them mot du lieu
    function them($maso, $maloai, $sotien)
    {
        $sql = "INSERT INTO chitietdoanhthu (maso, maloai, sotien)
                VALUES ('%s', '%s', '%s')";
        $sql = sprintf($sql, $maso, $maloai, $sotien);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }
    
    // Cap nhat du lieu
    function cap_nhat($maso, $maloai, $sotien)
    {
        $sql = "UPDATE chitietdoanhthu
                SET sotien = '%s'
                WHERE maso ='%s' AND maloai = '%s'";
        $sql = sprintf($sql, $sotien, $maso, $maloai);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }
}

/* End of file chitietdoanhthu.php */