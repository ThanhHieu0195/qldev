<?php

require_once '../entities/sms_entity.php';
require_once '../models/database.php';

class sms_model extends database {
	
	public function insert(sms_entity $item)
	{
		$sql = "INSERT INTO `smstemplate` (`smstemplate`, `smstype`)
                VALUES('{$item->smstemplate}', '{$item->smstype}');";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}

        public function update($smstype, $smstemplate)
        {
                $sql = "UPDATE smstemplate SET smstemplate='$smstemplate' WHERE smstype='$smstype'";

                $this->setQuery($sql);
                $result = $this->query();
                $this->disconnect();

                return $result;
        }

	public function sms_exist($smstype)
	{
        $sql = "SELECT * FROM smstemplate WHERE smstype='{$smstype}'";
	$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_array ( $result );
        $this->disconnect();
        
        if(is_array($array))
        {
            return TRUE;
        }
        return FALSE;
	}

        public function get_template($smstype)
        {
        $sql = "SELECT smstemplate FROM smstemplate WHERE smstype='{$smstype}'";
        $this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_array ( $result );
        $this->disconnect();

        if(is_array($array))
        {
            return $array;
        }
        return NULL;
        }

	
	public function results_list()
	{
        $sql = "SELECT * FROM smstemplate";
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();

        if (is_array ( $result )) {
            $output = array ();

            foreach ( $result as $row ) {
                $output [] = $row;
            }

            return $output;
        }

        return NULL;
	}
	
}

/* End of file */
