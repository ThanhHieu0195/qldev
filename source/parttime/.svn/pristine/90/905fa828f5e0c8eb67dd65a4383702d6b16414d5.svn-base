<?php
require_once '../entities/rewards_penalty_entity.php';
require_once '../models/database.php';
class rewards_penalty extends database {
    public function insert(rewards_penalty_entity $item) {
        $sql = "INSERT INTO `rewards_penalty` (`rewards_uid`, `created_date`, `content`, `created_by`, `assign_to`, `rewards_level`, `rewards_value`, `approved`, `feedback`)
                VALUES('{$item->rewards_uid}', '{$item->created_date}', '{$item->content}', '{$item->created_by}', 
                        '{$item->assign_to}', '{$item->rewards_level}', '{$item->rewards_value}', '{$item->approved}', '{$item->feedback}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function update(rewards_penalty_entity $item) {
        $sql = "UPDATE `rewards_penalty` 
                SET `rewards_uid` = '{$item->rewards_uid}' , `created_date` = '{$item->created_date}' , `content` = '{$item->content}' , 
                    `created_by` = '{$item->created_by}' , `assign_to` = '{$item->assign_to}' , `rewards_level` = '{$item->rewards_level}' , 
                    `rewards_value` = '{$item->rewards_value}' , `approved` = '{$item->approved}', `feedback` = '{$item->feedback}'
                WHERE `rewards_uid` = '{$item->rewards_uid}';";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete($rewards_uid) {
        $sql = "DELETE FROM `rewards_penalty` WHERE `rewards_uid` = '{$rewards_uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail($rewards_uid) {
        $sql = "SELECT * FROM `rewards_penalty` WHERE `rewards_uid` = '{$rewards_uid}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new rewards_penalty_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Thong ke tien doanh thu cua moi cong tac vien
    function _statistic($from, $to) {
        $approved = BIT_TRUE;
        
        $sql = "SELECT DATE(r.created_date) AS created_date,
                       TIME(r.created_date) AS created_time,
                       r.content,
                       n1.hoten AS created_by,
                       n2.hoten AS assign_to,
                       r.rewards_level,
                       r.rewards_value,
                       r.feedback
                FROM rewards_penalty r INNER JOIN nhanvien n1 ON r.created_by = n1.manv
                               INNER JOIN nhanvien n2 ON r.assign_to = n2.manv
                WHERE (DATE(created_date) BETWEEN '{$from}' AND '{$to}') AND approved = {$approved}
                ORDER BY created_date";
        
        $this->setQuery ( $sql );
        $array = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $array )) {
            // debug($array);
            return $array;
        }
        
        return NULL;
    }
    
    // Thong ke doanh thu cua cong tac vien
    function statistic_list($from, $to, $export = FALSE, &$field_list = NULL, &$column_name = NULL) {
        if ($export) {
            $field_list = array (
                    'created_date',
                    'created_time',
                    'content',
                    'created_by',
                    'assign_to',
                    'rewards_level',
                    'rewards_value',
                    'feedback' 
            );
            $column_name = array (
                    'Ngày',
                    'Giờ',
                    'Nội dung',
                    'Người ghi nhận',
                    'Người bị/được ghi nhận',
                    'Mức độ quan trọng',
                    'Mức độ mất mát hoặc đóng góp',
                    'Phản hồi' 
            );
        }
        
        if (empty ( $from )) {
            $from = NULL;
        }
        if (empty ( $to )) {
            $to = NULL;
        }
        
        if (isset ( $from ) && isset ( $to )) {
            $arr = $this->_statistic ( $from, $to );
            
            if (is_array ( $arr )) {
                // debug($arr);
                for($i = 0; $i < count ( $arr ); $i ++) {
                    $item = $arr [$i];
                    
                    $row = array ();
                    if ($export) {
                        $row ['created_date'] = $item ['created_date'];
                        $row ['created_time'] = $item ['created_time'];
                        $row ['content'] = $item ['content'];
                        $row ['created_by'] = $item ['created_by'];
                        $row ['assign_to'] = $item ['assign_to'];
                        $row ['rewards_level'] = $item ['rewards_level'];
                        $row ['rewards_value'] = $item ['rewards_value'];
                        $row ['feedback'] = $item ['feedback'];
                    } else {
                        $row [] = $item ['created_date'];
                        $row [] = $item ['created_time'];
                        $row [] = $item ['content'];
                        $row [] = $item ['created_by'];
                        $row [] = $item ['assign_to'];
                        $row [] = $item ['rewards_level'];
                        $row [] = number_2_string ( $item ['rewards_value'], '.' );
                        $row [] = $item ['feedback'];
                    }
                    $output [] = $row;
                }
            }
        }
        
        $result = array ();
        if (is_array ( $output )) {
            foreach ( $output as $row ) {
                $result [] = $row;
            }
        }
        
        return $result;
    }
}

/* End of file */