<?php 
	require_once "database.php";
	require_once "helper.php";
	class phanquyen extends database
	{
		function load() {
			$sql = "SELECT * FROM `phanquyen` ";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function loadKeyValid() {
			// SELECT n.manv, n.hoten FROM nhanvien n WHERE n.manv not in (SELECT manv FROM phanquyen)
			$sql = "SELECT n.manv, n.hoten FROM nhanvien n WHERE n.manv not in (SELECT manv FROM phanquyen WHERE uid IS NOT NULL) AND n.enable=1 AND manv<>'admin'";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function loadInfo() {
			$sql = "SELECT n.manv, n.hoten FROM nhanvien n";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function add($obj) {
			$manv = $obj['manv'];
			$mota = $obj['content'];
			$uid = $obj['uid'];
                        $sqldel = "DELETE FROM phanquyen WHERE manv='{$manv}'";
			// INSERT INTO `phanquyen` (`id`, `manv`, `mota`, `uid`) VALUES (NULL, '%s', '%s', '%s');
			$sql = "INSERT INTO `phanquyen` (`id`, `manv`, `mota`, `uid`) VALUES (NULL, '%s', '%s', '%s')";
			$sql = sprintf($sql, $manv, $mota, $uid);
                        $this->setQuery($sqldel);
                        if ($this->query()) {
                            $this->setQuery($sql);
                            $result = $this->query();
			    if ($result == 1) {
				return true;
                            }
                        }
			return false;
		}

		function move($obj) {
			$id = $obj['id'];
			$uid = $obj['uid'];
			// UPDATE `phanquyen` SET `uid` = '%s' WHERE `phanquyen`.`id` = '%s';
			if ($uid == '-1') {
				$sql = "UPDATE `phanquyen` SET `uid` = NULL WHERE `phanquyen`.`id` = '%s';";
				$sql = sprintf($sql, $id);
			} else {
				$sql = "UPDATE `phanquyen` SET `uid` = '%s' WHERE `phanquyen`.`id` = '%s';";
				$sql = sprintf($sql, $uid, $id);
			}
		
			$this->setQuery($sql);
			$result = $this->query();

			if ($result == 1) {
				return true;
			}
			return false;
		}

		function delNode($obj) {
			$sql = "DELETE FROM `phanquyen` WHERE id = '%s'";
			$sql = sprintf($sql, $obj['id']);
			$this->setQuery($sql);
			$result = $this->query();
			if ($result == 1) {
				for ($i=0; $i < count($obj['g']); $i++) { 
					$o = $obj['g'][$i];
					$this->move(array("id"=>$o, "uid"=>'-1'));
				}
				return true;
			}
			return false;
		}

		function edit($obj) {
			$id = $obj['id'];
			$content = $obj['content'];
			// UPDATE `phanquyen` SET `uid` = '%s' WHERE `phanquyen`.`id` = '%s';
			$sql = "UPDATE `phanquyen` SET `mota` = '%s' WHERE `phanquyen`.`id` = '%s';";
			$sql = sprintf($sql, $content, $id);

			$this->setQuery($sql);
			$result = $this->query();

			if ($result == 1) {
				return true;
			}
			return false;
		}


		function getListDetail() {
			$sql = "SELECT * FROM `chitietmotaphanquyen` ";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function getByEmployeeId($employee_id) {
			$sql = "SELECT * FROM `phanquyen` WHERE manv = '$employee_id';";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			$row = mysql_fetch_assoc($result);
			return $row;
		}

		function getByManagerId($uid) {
			$sql = "SELECT * FROM `phanquyen` WHERE uid = '$uid';";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				# code...
				$arr[] = $row;
			}
			
			return $arr;
		}
		function getById($id) {
			$sql = "SELECT * FROM `phanquyen` WHERE id = '$id';";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			$row = mysql_fetch_assoc($result);
			return $row;
		}

		function loadManager($employee_id) {
			$manager = array();

			$obj = $this->getByEmployeeId($employee_id);
			$obj = $this->getById($obj['uid']);

			while ($obj) {
				# code...
				$manager[] = $obj;
				$obj = $this->getById($obj['uid']);
			}
			return $manager;
		}

		function loadEmployeeLevel1($manager_id) {
			$employees = array();
			$info = $this->getByEmployeeId($manager_id);

			$list_employee = $this->getByManagerId($info['id']);
			
			for ($i=0; $i < count($list_employee); $i++) { 
				$obj = $list_employee[$i];
				$employees[] = $obj['manv'];
			}
			return $employees;
		}

		function loadEmployee($manager_id) {
			$list_employee = $this->loadEmployeeLevel1($manager_id);
			$arr = array();
			$arr = $list_employee;

			for ($i=0; $i < count($list_employee); $i++) { 
				# code...
				$arr = add_array($arr, $this->loadEmployee($list_employee[$i]));
			}
			return $arr;
		}
	}
?>
