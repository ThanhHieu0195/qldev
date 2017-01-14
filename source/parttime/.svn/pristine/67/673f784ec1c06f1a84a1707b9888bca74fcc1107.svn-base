<?php
include_once '../config/constants.php';
include_once '../models/helper.php';
require_once '../models/database.php';

class Config extends database {
    
    // Them mot constants moi
    function add($name, $value)
    {
        $sql = "REPLACE INTO config(name, value) VALUES('%s', '%s')";
        $sql = sprintf($sql, $name, $value); 
                          
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        
        return $result;
    }
    
    // Lay gia tri cua mot constants
    function get($name)
    {
        $sql = "SELECT value FROM config WHERE name = '%s'";
        $sql = sprintf($sql, $name); 
                          
        $this->setQuery($sql);
        $row =  mysql_fetch_object($this->query());
        $this->disconnect();
        
        if($row)
            return $row->value;
        return '';
    }
}

/* End of file config.php */
/* Location: ./models/config.php */