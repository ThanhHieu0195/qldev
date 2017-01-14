<?php

include_once 'database.php';
include_once 'helper.php';
class khachvip extends database {

    // them khach hang moi
    function them_khach_vip($makhach) {
        $sql = "INSERT INTO khachguicatalog (makhach) VALUES ('$makhach')";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $this->disconnect ();
        // echo $tiemnang;
        return $result;
    }

    function khach_exist($makhach)
    {
        $result = TRUE;
        $sql = "SELECT * FROM khachguicatalog WHERE makhach = '{$makhach}'";
        $this->setQuery($sql);
        $r = $this->query();
        $row = mysql_fetch_array ( $r );
        $this->disconnect();
        if (! is_array($row)) {
            $result = FALSE;
        } 
        return $result;
    }

}
