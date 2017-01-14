<?php 
	require_once "database.php";
	/**
	* 
	*/
	class detail_tk extends database
	{
		function detail_tk() {
			// SELECT * FROM `motataikhoan` 
			$sql = "SELECT * FROM `motataikhoan` ";
			$this->setQuery($sql);
			$result = $this->query();
			$arr = array();
			while ($row = mysql_fetch_assoc($result)) {
				# code...
				$arr[] = $row;
			}
			return $arr;
		}	
	
	}
 ?>
