<?php 
	require_once 'database.php';
	/**
	* 
	*/
	class RedBill extends database
	{
		// INSERT INTO `hoadondo` (`id`, `mahoadon`, `ngayxuat`, `giatri`) VALUES ('%s', '%s', '%s', '%s');
		function insert($id, $mahoadon, $ngayxuat, $giatri) {
			$sql = "INSERT INTO `hoadondo` (`id`, `mahoadon`, `ngayxuat`, `giatri`) VALUES ('%s', '%s', '%s', '%s');";
			$sql = sprintf($sql, $id, $mahoadon, $ngayxuat, $giatri);

			$this->setQuery($sql);
			$result = $this->query();

			if ($result == 1) {
				return true;
			}
			return false;
		}

		function update_status_by_order($mahoadon) {
			$sql = "UPDATE `hoadondo` SET `trangthai` = '1' WHERE `hoadondo`.`mahoadon` = '{$mahoadon}';";
			$this->setQuery($sql);
			$result = $this->query();
			if ($result) {
				return true;
			} else {
				return false;
			}
		}

                function hdd_chuathu($madon) {
                        $sql = "select dh.hoa_don_do, dh.madon from donhang as dh inner join finance_token_detail as ft on ft.madon = dh.madon where item_id like '%53b22965bf2d5%' and dh.hoa_don_do<>'0' and dh.madon='{$madon}'";
                        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
                        $this->setQuery($sql);
                        $result = $this->query();
                        if ($result) {
                            $array = $this->loadAllRow ();
                            if (count( $array )>0) {
                                return false;
                            } else {
                                return true;
                            }
                            $this->disconnect ();
                        } 
                        return false;

                }

		function statisticVAT() {
			$sql_update = "UPDATE hoadondo AS hd INNER JOIN donhang AS dh ON dh.hoa_don_do =hd.mahoadon
                                       INNER JOIN finance_token_detail AS ft ON (dh.madon = ft.madon AND ft.item_id='53b22965bf2d5')
                                       SET hd.trangthai=1
                                       WHERE 0.1*REPLACE(hd.giatri,',','') + 0.2*(REPLACE(hd.giatri,',','')-dh.thanhtien*1.1)=ft.money_amount*1.1";

			$sql = "SELECT @row := @row + 1 AS stt, dh.madon, dh.ngaygiao, hdd.mahoadon, dh.thanhtien, dh.giatrihoadondo, hdd.ngayxuat, ROUND(REPLACE(hdd.giatri,',','')/1.1,0) as giatri, ftd.money_amount, ftd.item_id, ftd.token_id
				FROM  (SELECT @row := 0) r, hoadondo hdd LEFT JOIN donhang dh ON INSTR(dh.hoa_don_do, hdd.mahoadon)>0 LEFT JOIN finance_token_detail ftd ON (ftd.madon = dh.madon AND ftd.item_id='53b22965bf2d5')
				WHERE hdd.trangthai is NULL
				order by dh.madon;";
			// cập nhật table hoadondo
			$this->setQuery($sql_update);
			$result = $this->query();

			$arr = array();
			if ($result) {
				$this->setQuery($sql);
				$result = $this->query();
				while($row = mysql_fetch_assoc($result)) {
					$arr[] = $row;
				}
			}
			return $arr;
		}
	}
 ?>
