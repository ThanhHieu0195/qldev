<?php 
	require_once "database.php";
	require_once "../config/constants.php";
	/**
	* 
	*/
	class leave_number extends database
	{
		function autoUpdateByMonth() {
			$sql = "UPDATE `danhsachsongaynghi` AS numleave 
					SET numleave.songaynghi = numleave.songaynghi + 1, numleave.capnhatcuoi = CURDATE() 
					WHERE DATEDIFF(CURRENT_DATE, numleave.capnhatcuoi) >= 30;";
			$this->setQuery($sql);
			if ($this->query()) {
				return true;
			}
			return false;

		}
		function getInfoByEmployeeId($employee_id) {
			$sql = "SELECT * FROM `danhsachsongaynghi` WHERE `manv` LIKE '$employee_id'";
			$this->setQuery($sql);
			$result = $this->query();
			$row = mysql_fetch_assoc($result);
			return $row;
		}
		function updateNumberLeave($employee_id, $number_leave) {
			$sql = "UPDATE `danhsachsongaynghi` SET `songaynghi` = '$number_leave', `capnhatcuoi` = CURDATE() WHERE `danhsachsongaynghi`.`manv` = '$employee_id';";
			$this->setQuery($sql);
			$result = $this->query();
			if ($result) {
				return true;
			}
			return false;
		}

		function reset ($employee_id, $max_num_leave) {
			$maxleave = $max_num_leave;
			return $this->updateNumberLeave($employee_id, $maxleave);
		}

		function getByArrayEmployee($arr_employee) {
			$in_query =  "'$arr_employee[0]'";

			for ($i=1; $i < count($arr_employee); $i++) { 
				# code...
				$in_query.=", '$arr_employee[$i]'";
			}

			//$sql = "SELECT manv AS EMPLOYEE_ID, songaynghi AS DAY_LEAVE_MAX FROM `danhsachsongaynghi` WHERE manv IN ($in_query);";
                        $sql1 = "INSERT INTO danhsachsongaynghi (manv, songaynghi, capnhatcuoi) (select manv, '0' as songaynghi, DATE_FORMAT(now(),'%Y-%m-%d') as capnhatcuoi from nhanvien where enable=1 and manv not in (select manv from danhsachsongaynghi))";
                        $sql = "SELECT n.manv AS EMPLOYEE_ID, IFNULL(d.songaynghi,0) AS DAY_LEAVE_MAX FROM nhanvien n LEFT JOIN danhsachsongaynghi d ON d.manv=n.manv WHERE n.manv IN ($in_query);";
                        //error_log ("Add new" . $sql , 3, '/var/log/phpdebug.log');
                        $this->setQuery($sql1);
                        if ($this->query()) {
                            $this->setQuery($sql);
			    $result = $this->query();
                        }
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;

		}

	}
 ?>
