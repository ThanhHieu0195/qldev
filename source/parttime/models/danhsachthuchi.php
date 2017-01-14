<?php 

require_once 'database.php';	
class listExpenses extends database
{

	function insert($id=NULL, $manhanvien, $madonhang, $loai=0, $sotien=0, $ghichu="", $trangthai=0, $approve=0) {
		
		$sql = "INSERT INTO `danhsachthuchi` (`id`, `manhanvien`, `madonhang`, `loai`, `sotien`, `ghichu`, `trangthai`, `approve`) VALUES ('{$id}', '{$manhanvien}', '{$madonhang}', '{$loai}', '{$sotien}', '{$ghichu}', '{$trangthai}', '{$approve}');";
		$this->setQuery($sql);
		$result = $this->query();
		if ($result) {
			return true;
		} 
		return false;
	}

	function reject($id) {
		$sql ="UPDATE `danhsachthuchi` SET `trangthai` = '-1' WHERE `danhsachthuchi`.`id` = $id;";
		$this->setQuery($sql);
		$result = $this->query();
		if ($result) {
			return true;
		} 
		return false;
	}

	function reject_list($arr) {
		$result = 1;
        for ($i=0; $i < count($arr); $i++) { 
            $result = $result && $this->reject($arr[$i]);
        }
        return $result;
	}
	function getListApprove() {
		$sql = "SELECT * FROM `danhsachthuchi` where loai=1 ORDER BY FIELD(approve ,0,-1,1) ASC";
		$this->setQuery($sql);
		$result = $this->query();
		$arr= array();
		while ($row = mysql_fetch_assoc($result)) {
			# code...
			$arr[] = $row;
		}
		return $arr;
	}	


	function updateApprove($id, $approve = 1) {
                if ($approve==1) {
      		    $sql = "UPDATE `danhsachthuchi` SET `approve` = '{$approve}', `ghichu` = CONCAT('APPROVED:',ghichu) WHERE `danhsachthuchi`.`id` = '{$id}';";
                } else {
                    $sql = "UPDATE `danhsachthuchi` SET `approve` = '{$approve}', `ghichu` = CONCAT('REJECTED:',ghichu) WHERE `danhsachthuchi`.`id` = '{$id}';";
                }
		$this->setQuery($sql);
		$result = $this->query();
		if ($result) {
			return true;
		} 
		return false;
	}

	function update_status($id) {
		$sql = "UPDATE `danhsachthuchi` SET `trangthai` = '1' WHERE `danhsachthuchi`.`id` = '{$id}';";
		$this->setQuery($sql);
		$result = $this->query();
		if ($result) {
			return true;
		} 
		return false;
	}

	function updateStatus($madonhang, $note, $type=0) {
		$sql = "UPDATE `danhsachthuchi` SET `trangthai` = '1' WHERE `danhsachthuchi`.`madonhang` = '{$madonhang}' AND `danhsachthuchi`.`ghichu` = '{$note}' AND `loai` = '{$type}';";
		$this->setQuery($sql);
		$result = $this->query();
		if ($result) {
			return true;
		} 
		return false;
	}

	function getInfoByOrder($madonhang, $trangthai="0", $loai = 0) {
		$sql="SELECT * FROM `danhsachthuchi` WHERE `madonhang` LIKE '{$madonhang}' AND `trangthai` = '{$trangthai}' AND `loai` = '{$loai}';";
		$this->setQuery($sql);
		$result = $this->query();
		$arr= array();
		while ($row = mysql_fetch_assoc($result)) {
			# code...
			$arr[] = $row;
		}
		return $arr;
	}
	function getNodesByOrder($madonhang) {
		$sql="SELECT `ghichu` FROM `danhsachthuchi` WHERE `madonhang` LIKE '{$madonhang}';";
		$this->setQuery($sql);
		$result = $this->query();
		$arr= array();
		while ($row = mysql_fetch_array($result)) {
			# code...
			$arr[] = $row[0];
		}
		return $arr;
	}

	function updateMoney($madon, $note, $money) {
		$sql = "UPDATE `danhsachthuchi` SET `sotien` = '{$money}' WHERE `danhsachthuchi`.`madonhang` = '{$madon}' AND `danhsachthuchi`.`ghichu` LIKE '{$note}';";
		$this->setQuery($sql);
		$result = $this->query();
		if ($result) {
			return true;
		} 
		return false;
	}
	
	function deleteByNote($madon, $note) {
		$sql = "DELETE FROM `danhsachthuchi` WHERE `danhsachthuchi`.`madonhang` = '{$madon}' AND `danhsachthuchi`.`ghichu` = '{$note}'; ";
		$this->setQuery($sql);
			$result = $this->query();
			if ($result) {
				return true;
			} 
			return false;	
	}
      
        function deleteById($id) {
                $sql = "UPDATE danhsachthuchi SET status=-1 WHERE id = '{$id}'; ";
                $this->setQuery($sql);
                        $result = $this->query();
                        if ($result) {
                                return true;
                        }
                        return false;
        }

}
// $md = new listExpenses();
// print_r($md->updateStatus('th1005', "6"));
?>
