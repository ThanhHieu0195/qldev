<?php 
include_once 'database.php';
include_once 'employee_of_order.php';
include_once 'helper.php';

/**
* 
*/
class employee_of_returns extends database
{
	function them($id, $employees) {
		// INSERT INTO `employee_of_returns` (`return_id`, `employee_id`) VALUES ('%s', '%s');
		$sql="";
	        $result = true;
		if (is_array($employees)) {
			for ($i=0; $i < count($employees); $i++) { 
				# code...
				$insert = "INSERT INTO `employee_of_returns` (`return_id`, `employee_id`) VALUES ('%s', '%s'); ";
				$insert = sprintf($insert, $id, $employees[$i]);
	                        $sql = $insert;
	                        $this->setQuery($sql);
	                        $result .= $this->query();
	                        $this->disconnect();
			}
		}
        // error_log ("Add new" . $sql, 3, '/var/log/phpdebug.log');
        return $result;
	}

	function addEmployeeByOrder($id, $madon) {
	  require_once "employee_of_order.php";
      $eoo = new employee_of_order();
      $arr_employee_id = $eoo->getRowsbyId($madon);
      $arr_id = array();
      if (is_array($arr_employee_id)) {
         for ($i=0; $i < count($arr_employee_id); $i++) { 
           $arr_id[] = $arr_employee_id[$i]['employee_id'];
         }
      }

      if ($this->them($id, $arr_id)) {
        return true;
      } else {
           return false;
      }
	}

}
?>
