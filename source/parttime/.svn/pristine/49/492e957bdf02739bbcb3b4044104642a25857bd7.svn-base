<?php 
	require_once "database.php";
	require_once "danhsachsongaynghi.php";
	/**
	* 
	*/
	class list_leave extends database
	{
		function current_date($format = 'Y-m-d') {
		    date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );
		    return date ( $format );
		}

		function getListByManagerId($manager_id) {
			$sql = "SELECT * FROM `danhsachnghi` WHERE `maquanli` LIKE '$manager_id' ";
			$this->SetQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function getLeave($id) {
			$sql = "SELECT * FROM `danhsachnghi` WHERE `manv` LIKE '$id' ORDER BY ngaynghi DESC";
			$this->SetQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function statistic_employee_id_detail($manager_id) {
			$sql = "SELECT  listleave.manv AS EMPLOYEE_ID, listleave.ngaynghi AS DATE, SUM(listleave.songaynghi) DAY_LEAVE, listnum.songaynghi DAY_LEAVE_MAX 
						FROM danhsachnghi listleave INNER JOIN danhsachsongaynghi listnum on listnum.manv = listleave.manv
						WHERE listleave.maquanli = '$manager_id' AND listleave.trangthai = 1
						GROUP BY listleave.manv, listleave.ngaynghi";
			$this->SetQuery($sql);
			$result = $this->query();
			$arr = array();
			$employee_id = "";
			while($row = mysql_fetch_assoc($result)) {
				if ($employee_id != $row['EMPLOYEE_ID']) {
					$employee_id = $row['EMPLOYEE_ID'];
					$arr[$employee_id] = array();
					$arr[$employee_id][] = $row;
				} else {
					$arr[$employee_id][] = $row;
				}
			}
			return $arr;
		}

		function statistic_employee_id($manager_id) {
			$sql = "SELECT listleave.manv AS EMPLOYEE_ID, SUM(listleave.songaynghi) DAY_LEAVE, listnum.songaynghi DAY_LEAVE_MAX 
						FROM danhsachnghi listleave INNER JOIN danhsachsongaynghi listnum on listnum.manv = listleave.manv
						WHERE listleave.maquanli = '$manager_id' AND listleave.trangthai = 1
						GROUP BY listleave.manv";
			$this->SetQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[$row['EMPLOYEE_ID']] = $row; 
			}
			return $arr;
		}


		function getById($id) {
			$sql = "SELECT * FROM `danhsachnghi` WHERE `id` LIKE '$id' ";
			$this->SetQuery($sql);
			$result = $this->query();
			$arr = array();
			$row = mysql_fetch_assoc($result);
			return $row;
		}

		function insert($id, $employee_id, $manager_id, $date_create = "", $date_leave = "", $number_leave = 1, $status = 0, $note = "") {
			if (empty($date_create)) {
				$date_create = $this->current_date();
			}

			if (empty($date_leave)) {
				$date_leave = $this->current_date();
			}

			$sql = "INSERT INTO `danhsachnghi` (`id`, `manv`, `maquanli`, `ngaylap`, `ngaynghi`, `songaynghi`, `trangthai`, `ghichu`) VALUES ('$id', '$employee_id', '$manager_id', '$date_create', '$date_leave', '$number_leave', '$status', '$note');";
			$this->SetQuery($sql);
			$result = $this->query();
			if ($result) {
				return true;
			}
			return false;
		}

		function approve($id) {
			$sql = "UPDATE `danhsachnghi` SET `trangthai` = '1' WHERE `danhsachnghi`.`id` = '$id';";
			$this->SetQuery($sql);
			$result = $this->query();
			if ($result) {
				return true;
			}
			return false;
		}

		function reject($id) {
			$sql = "UPDATE `danhsachnghi` SET `trangthai` = '-1' WHERE `danhsachnghi`.`id` = '$id';";
			$this->SetQuery($sql);
			$result = $this->query();
			if ($result) {
				return true;
			}
			return false;
		}

		function reset($employee_id, $max_num_leave) {
			$sql = "UPDATE `danhsachnghi` SET `trangthai` = '1' WHERE `danhsachnghi`.`manv` = '$employee_id';";
			$this->SetQuery($sql);
			if ($this->query()) {
				$listnumber = new leave_number();
				if ($listnumber->reset($employee_id, $max_num_leave)) {
					return true;
				}
			}
			return false;
		}

	}
 ?>
