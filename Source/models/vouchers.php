<?php 
	/**
	* 
	*/
	require_once "database.php";
	class voucher extends database
	{
		function insert($maphieu, $ngaygiao, $giogiao, $makhach, $ghichu, $trangthai, $manhanvien) {
			$sql = "INSERT INTO `giaochungtu` (`maphieu`, `ngaygiao`, `giogiao`, `makhach`, `ghichu`, `trangthai`, `manhanvien`) VALUES ('$maphieu', '$ngaygiao', '$giogiao', '$makhach', '$ghichu', '$trangthai', '$manhanvien');";
			$this->setQuery($sql);
			$result = $this->query();
			if ($result == 1) {
				return true;
			}
			return false;

		}

		function update($maphieu, $ngaygiao, $giogiao, $makhach, $ghichu, $trangthai, $manhanvien) {
			$sql = "UPDATE `giaochungtu` SET `ngaygiao` = '$ngaygiao', `giogiao` = '$giogiao', `makhach`= '$makhach', `ghichu`= '$ghichu', `trangthai`= '$trangthai', `manhanvien` = '$manhanvien' WHERE `giaochungtu`.`maphieu` = '$maphieu';";

			$this->setQuery($sql);
			$result = $this->query();
			if ($result == 1) {
				return true;
			}
			return false;

		}

		function get($maphieu) {
			$sql = "SELECT * FROM `giaochungtu` WHERE `maphieu` LIKE '$maphieu' ";
			$this->setQuery($sql);
			$result = $this->query();
			$row = mysql_fetch_assoc($result);
			return $row;
		}
		function accept($maphieu) {
			$sql = "UPDATE `giaochungtu` SET `trangthai`= '1' WHERE `giaochungtu`.`maphieu` = '$maphieu';";
			$this->setQuery($sql);
			$result = $this->query();
			if ($result == 1) {
				return true;
			}
			return false;
		}
	}
 ?>