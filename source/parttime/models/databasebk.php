<?php

class database {

    var $_sql = '';         //noi dung cau truy van
    var $_connection = '';  //ket qua ham ket noi mysql_connect()
    var $_cursor = null;    //chua ket qua cua ham mysql_query()
    var $_error = '';       //loi truy van
    public static $SERVER = '112.78.2.242';
    public static $USERNAME = 'ho08061_banhang';
    public static $PASSWORD = '1qaz2wsx';
    public static $db = 'ho08061_banhang';

    //Ket noi CSDL
    function database()
    {
    }

    function _connect()
    {
        $this->_connection = @mysql_connect(database::$SERVER, database::$USERNAME, database::$PASSWORD);
        if (!$this->_connection) {
            die('Could not connect to MySQL' . mysql_error());
        }

        //chon va kiem tra CSDL
        $db = database::$db;
        if ($db != '' && !mysql_select_db($db, $this->_connection)) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_query("SET NAMES 'utf8'", $this->_connection);
    }

    //Gan gia tri cho thuoc tinh $_sql
    function setQuery($sql) {
        $this->_sql = $sql;
    }
    function getQuery() {
        return $this->_sql;
    }

    //Thuc thi cau truy van
    function query() {
        $this->_error = '';
        //mysql_query("SET NAMES 'utf8'", $this->_connection);
        $this->_connect();

        $this->_cursor = mysql_query($this->_sql, $this->_connection);
        $this->_error = mysql_error();
        return $this->_cursor;
    }

    //Lay thong bao loi
    function getMessage() {
        return $this->_error;
    }

    //Lay toan bo cac dong du lieu trong bang
    function loadAllRow() {
        if (!($cur = $this->query())) {
            return null;
        }
        $array = array();
        while ($row = mysql_fetch_assoc($cur)) {
            $array[] = $row;
        }
        mysql_free_result($cur);
        return $array;

        /*
         * //duyet tung dong cua mang ket qua
         * for($i = 0; $i < sizeof($array); ++$i)
          {
          $array[$i][$key];
          //trong do $key la ten cua cot can truy xuat gia tri
          }
         */
    }

    //Dong ket noi
    function disconnect() {
        mysql_close($this->_connection);
    }

}

?>
