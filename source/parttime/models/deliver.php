<?php 
	require_once "database.php";
	require_once "helper.php";
	/**
	* 
	*/
	class deliver extends database
	{
		function loadListInvalid() {
			// SELECT manv, hoten FROM account_role_of_employee aroe JOIN nhanvien nv on aroe.employee_id = nv.manv WHERE aroe.role_id = 'deliver' 
			$deliver = G_DELIVER;
			$sql = "SELECT manv, hoten FROM account_role_of_employee aroe JOIN nhanvien nv on aroe.employee_id = nv.manv WHERE aroe.role_id = '{$deliver}' ";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function update($order_id, $employee_id) {
			$sql = " UPDATE `giaohang` SET `manv` = '{$employee_id}' WHERE `giaohang`.`madon` = '{$order_id}'";
			$this->setQuery($sql);
			$result = $this->query();
			if ($result == 1) {
				return true;
			} else {
				return false;
			}
		}

		function insert($order_id, $employee_id, $money=0){
			$sql = "INSERT INTO `giaohang` (`id`, `madon`, `manv`, `tiengiaohang`) VALUES (NULL, '{$order_id}', '{$employee_id}', '{$money}')";
			$this->setQuery($sql);
			$result = $this->query();
			if ($result == 1) {
				return true;
			} else {
				return false;
			}
		}
		function delete($order_id) {
			$sql = "DELETE FROM `giaohang` WHERE `giaohang`.`madon` = '{$order_id}';";
			$this->setQuery($sql);
			$result = $this->query();
			if ($result == 1) {
				return true;
			} else {
				return false;
			}
		}
		function checkAccount($order_id) {
			$sql = "SELECT * FROM `giaohang` WHERE `madon` LIKE '{$order_id}'";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();

			while ($row=mysql_fetch_assoc($result)) {
				$arr[]=$row;
			}

			if (is_array($arr) && count($arr) > 0) {
				return true;
			} else {
				return false;
			}
		}

		function setValue($order_id, $employee_id) {
			if (empty($employee_id) || empty($order_id))
				return false;
			if ($this->checkAccount($order_id)) {
				// update
				return $this->update($order_id, $employee_id);
			} else {
				// insert
				return $this->insert($order_id, $employee_id);
			}
		}

		function getDeliver($order_id) {
			// SELECT gh.manv FROM giaohang gh WHERE gh.madon = '{$order_id}' 
			$sql = "SELECT gh.manv FROM giaohang gh WHERE gh.madon = '{$order_id}'";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}

			if (is_array($arr) && count($arr) > 0) {
				return $arr[0]['manv'];
			}
			return "";
		}
		// SELECT gh.manv, dh.madon, dh.ngaydat, dh.tongtien FROM donhang dh JOIN giaohang gh ON dh.madon = gh.madon WHERE dh.ngaydat BETWEEN '2016-09-01' AND '2016-09-09' GROUP BY gh.manv, dh.madon 
		function getListEmployeeByTime($from, $to) {
			$sql = "SELECT gh.manv, nv.hoten, SUM(dh.tongtien) AS sum FROM donhang dh JOIN giaohang gh ON dh.madon = gh.madon JOIN nhanvien nv ON gh.manv = nv.manv WHERE dh.ngaydat BETWEEN '{$from}' AND '{$to}' GROUP BY gh.manv ";

			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function getListDate($from, $to) {
			$sql = "SELECT dh.ngaygiao AS DATE FROM giaohang gh INNER JOIN (SELECT ngaygiao, manv ,madon, trangthai, 'order' AS loai
										FROM donhang dh1
										UNION 
										SELECT  ngaygiao as ngaygiao, manhanvien as manv , maphieu as madon, trangthai,'voucher' AS loai
										FROM giaochungtu dh2) 
			AS dh on gh.madon = dh.madon INNER JOIN nhanvien nv ON gh.manv = nv.manv WHERE dh.ngaygiao BETWEEN '{$from}' AND '{$to}' GROUP BY dh.ngaygiao ";

			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function getListDate_employee($from, $to, $employee_id) {
			$sql = "SELECT dh.ngaygiao AS DATE FROM giaohang gh INNER JOIN (SELECT ngaygiao, manv ,madon, trangthai, 'order' AS loai
										FROM donhang dh1
										UNION 
										SELECT  ngaygiao as ngaygiao, manhanvien as manv , maphieu as madon, trangthai,'voucher' AS loai
										FROM giaochungtu dh2) 
			AS dh on gh.madon = dh.madon INNER JOIN nhanvien nv ON gh.manv = nv.manv WHERE dh.ngaygiao BETWEEN '{$from}' AND '{$to}' AND gh.manv = '{$employee_id}' GROUP BY dh.ngaygiao ";

			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}


		function statistics($from, $to) {
			$sql = "SELECT dh.ngaygiao AS DATE, gh.manv AS EMPLOYEE_ID, gh.madon AS ORDER_ID, gh.tiengiaohang AS MONEY, dh.loai AS TYPE, nv.hoten AS NAME,SUM(gh.tiengiaohang) SUM_MONEY,COUNT(dh.madon) AS SUM, COUNT(CASE dh.trangthai WHEN '0' THEN 1 ELSE null END) AS SUM_WAITING, COUNT(CASE dh.trangthai WHEN '1' THEN 1 ELSE null END) AS SUM_ASSIGN 
			FROM giaohang gh INNER JOIN (SELECT ngaygiao, manv ,madon, trangthai, 'order' AS loai
										FROM donhang dh1
										UNION 
										SELECT  ngaygiao as ngaygiao, manhanvien as manv , maphieu as madon, trangthai,'voucher' AS loai
										FROM giaochungtu dh2) 
			AS dh on gh.madon = dh.madon INNER JOIN nhanvien nv ON gh.manv = nv.manv WHERE dh.ngaygiao BETWEEN '{$from}' AND '{$to}' 
			GROUP BY dh.ngaygiao, gh.manv";

			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

		function statistics_employee($from, $to, $employee_id) {
			$sql = "SELECT dh.ngaygiao AS DATE, gh.manv AS EMPLOYEE_ID, gh.madon AS ORDER_ID, gh.tiengiaohang AS MONEY, dh.loai AS TYPE, nv.hoten AS NAME,SUM(gh.tiengiaohang) SUM_MONEY,COUNT(dh.madon) AS SUM, COUNT(CASE dh.trangthai WHEN '0' THEN 1 ELSE null END) AS SUM_WAITING, COUNT(CASE dh.trangthai WHEN '1' THEN 1 ELSE null END) AS SUM_ASSIGN 
			FROM giaohang gh INNER JOIN (SELECT ngaygiao, manv ,madon, trangthai, 'order' AS loai
										FROM donhang dh1
										UNION 
										SELECT  ngaygiao as ngaygiao, manhanvien as manv , maphieu as madon, trangthai,'voucher' AS loai
										FROM giaochungtu dh2) 
			AS dh on gh.madon = dh.madon INNER JOIN nhanvien nv ON gh.manv = nv.manv WHERE dh.ngaygiao BETWEEN '{$from}' AND '{$to}' AND gh.manv = '{$employee_id}'
			GROUP BY dh.ngaygiao, gh.manv";

			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}

                function statistics_new($from, $to, $employee_id='') {
                        $sql = "select g.madon as madon, g.manv as nhanvien, g.tiengiaohang as tiengiaohang, d.ngaygiao as ngaygiao, d.thanhtien as thanhtien, k.diachi as diachi, k.quan as quan, k.tp as tp, 'donhang' as loai from giaohang g inner join donhang d on d.madon=g.madon inner join khach k on k.makhach = d.makhach where d.ngaygiao between '{$from}' and '{$to}'";
                        if (strlen($employee_id)>1) {
                            $sql .= " and g.manv = '{$employee_id}'";
                        }
                        $sql .= " UNION ";
                        $sql .= "select c.maphieu as madon, c.manhanvien as nhanvien, g.tiengiaohang as tiengiaohang, c.ngaygiao as ngaygiao, '----' as thanhtien, k.diachi as diachi, k.quan as quan, k.tp as tp, 'chungtu' as loai  from giaochungtu c inner join giaohang g on g.madon=c.maphieu inner join khach as k on k.makhach=c.makhach";
                        if (strlen($employee_id)>1) {
                            $sql .= " and c.manhanvien = '{$employee_id}'";
                        }
                        $sql .= " order by ngaygiao desc, madon asc"; 
                        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
                        $this->setQuery($sql);
                        $result = $this->query();
                        $arr = array();
                        while ($row = mysql_fetch_assoc($result)) {
                                $arr[] = $row;
                        }
                        return $arr;
                }

		function statistics_sum($from, $to) {
			$sql = "SELECT gh.manv AS MANV, SUM(tiengiaohang) SUM_DELIVER, SUM(money_order) SUM_ORDER
			FROM giaohang gh INNER JOIN (SELECT ngaygiao, manv ,madon, trangthai, 'order' AS loai, thanhtien AS money_order
										FROM donhang dh1
										UNION 
										SELECT  ngaygiao as ngaygiao, manhanvien as manv , maphieu as madon, trangthai,'voucher' AS loai, '0' AS money_order
										FROM giaochungtu dh2) 
			AS dh on gh.madon = dh.madon INNER JOIN nhanvien nv ON gh.manv = nv.manv WHERE dh.ngaygiao BETWEEN '{$from}' AND '{$to}' 
			GROUP BY gh.manv";

			$this->setQuery($sql);
			$result = $this->query();	
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				$arr[] = $row;
			}
			return $arr;
		}
	}
 ?>
