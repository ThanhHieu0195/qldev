<?php 
	require_once "database.php";
	/**
	* 
	*/
	class list_request extends database
	{
		function current_date($format = 'Y-m-d') {
		    date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );
		    return date ( $format );
		}

		function getRequest($id) {
                        if ($id=='admin') {
                            $sql = "SELECT * FROM `danhsachlamthem` ORDER BY ngaylamthem DESC";
                        } else {
    			    $sql = "SELECT * FROM `danhsachlamthem` WHERE `manv` LIKE '$id' ORDER BY ngaylamthem DESC";
                        }
			$this->SetQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function statistic_employee_id_detail($manager_id) {
                        if ($manager_id=='admin') {
                            $sql = "SELECT  listrequest.manv AS EMPLOYEE_ID, listrequest.ngaylamthem AS DATE, SUM(listrequest.songay) DAY_REQUEST
                                                FROM danhsachlamthem listrequest
                                                WHERE listrequest.trangthai = 1
                                                GROUP BY listrequest.manv, listrequest.ngaylamthem";
                        } else {
			    $sql = "SELECT  listrequest.manv AS EMPLOYEE_ID, listrequest.ngaylamthem AS DATE, SUM(listrequest.songay) DAY_REQUEST
						FROM danhsachlamthem listrequest
						WHERE listrequest.maquanly = '$manager_id' AND listrequest.trangthai = 1
						GROUP BY listrequest.manv, listrequest.ngaylamthem";
                        }
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
                        if ($manager_id=='admin') {
   			    $sql = "SELECT listrequest.manv AS EMPLOYEE_ID, SUM(listrequest.songay) DAY_REQUEST
						FROM danhsachlamthem listrequest
						WHERE listrequest.trangthai = 1
						GROUP BY listrequest.manv";
                        } else {
                            $sql = "SELECT listrequest.manv AS EMPLOYEE_ID, SUM(listrequest.songay) DAY_REQUEST
                                                FROM danhsachlamthem listrequest
                                                WHERE listrequest.maquanly = '$manager_id' AND listrequest.trangthai = 1
                                                GROUP BY listrequest.manv";
                        }
			$this->SetQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[$row['EMPLOYEE_ID']] = $row; 
			}
			return $arr;
		}


		function getById($id) {
			$sql = "SELECT * FROM `danhsachlamthem` WHERE `id` LIKE '$id' ";
			$this->SetQuery($sql);
			$result = $this->query();
			$arr = array();
			$row = mysql_fetch_assoc($result);
			return $row;
		}

		function insert($id, $employee_id, $manager_id, $date_create = "", $date_request = "", $number_request = 1, $status = 0, $note = "") {
			if (empty($date_create)) {
				$date_create = $this->current_date();
			}

			if (empty($date_request)) {
				$date_request = $this->current_date();
			}

			$sql = "INSERT INTO `danhsachlamthem` (`id`, `manv`, `maquanly`, `ngaylap`, `ngaylamthem`, `songay`, `trangthai`, `ghichu`) VALUES ('$id', '$employee_id', '$manager_id', '$date_create', '$date_request', '$number_request', '$status', '$note');";

			$this->SetQuery($sql);
			$result = $this->query();
			if ($result) {
				return true;
			}
			return false;
		}

		function approve($id) {
			$sql = "UPDATE `danhsachlamthem` SET `trangthai` = '1' WHERE `danhsachlamthem`.`id` = '$id';";
			$this->SetQuery($sql);
			$result = $this->query();
			if ($result=1) {
				require_once "../models/danhsachsongaynghi.php";
				$model = new leave_number();
				$info = $this->getById($id);
				$num_request = floatval($info['songay']);

				$data1 = $model->getInfoByEmployeeId($info['manv']);
				$max_leave = floatval ($data1['songaynghi']);
				$num_reset = $num_request + $max_leave;

				if ($model->updateNumberLeave($info['manv'], $num_reset)) {
					return true;
				}
			}
			return false;
		}

		function reject($id) {
			$sql = "UPDATE `danhsachlamthem` SET `trangthai` = '-1' WHERE `danhsachlamthem`.`id` = '$id';";
			$this->SetQuery($sql);
			$result = $this->query();
			if ($result) {
				return true;
			}
			return false;
		}

		function reset($employee_id, $max_num_request) {
			$sql = "UPDATE `danhsachlamthem` SET `trangthai` = '1' WHERE `danhsachlamthem`.`manv` = '$employee_id';";
			$this->SetQuery($sql);
			if ($this->query()) {
				$listnumber = new request_number();
				if ($listnumber->reset($employee_id, $max_num_request)) {
					return true;
				}
			}
			return false;
		}

	}
 ?>
