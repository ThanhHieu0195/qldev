<?php

require_once '../entities/task_result_entity.php';
require_once '../models/database.php';
require_once '../models/nhanvien.php';
require_once '../models/task_result_category.php';

class task_result extends database {
    
    public function insert(task_result_entity $item)
    {
        $sql = "INSERT INTO `task_result` (`uid`, `task_id`, `item_id`, `result`)
                VALUES('{$item->uid}', '{$item->task_id}', '{$item->item_id}', '{$item->result}');";
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    public function detail_by_task($task_id, $category_id, $assign_to)
    {
        $sql = "SELECT r.uid, r.task_id, r.result, r.item_id, e.rate, i.item_name, c.category_id, c.category_name
                FROM task_result r INNER JOIN task_result_rate e ON r.item_id = e.item_id
                   INNER JOIN task_result_item i ON e.item_id = i.item_id
                   INNER JOIN task_result_category c ON i.category_id = c.category_id
                WHERE r.task_id = '{$task_id}' AND e.manv = '{$assign_to}' AND i.category_id = {$category_id};";
        
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        
        if(is_array($result))
        {
            $list = array();
            foreach ($result as $row)
            {
                $item = new task_result_entity();
                $item->assign($row);
        
                $list[] = $item;
            }
                
            return $list;
        }
        
        return NULL;
    }
    
    /**
     * @param unknown $task_id
     * @param unknown $assign_to
     * @return array ('result', 'rate')
     */
    public function result_by_task($task_id, $assign_to) {
        $total = array('result' => 0, 'rate' => 0);
        
        $category_model = new task_result_category();
        $arr = $category_model->get_all();
        if($arr != NULL) {
            foreach ($arr as $c) {
                $result_list = $this->detail_by_task($task_id, $c->category_id, $assign_to);
                if ($result_list != NULL) {
                    foreach ($result_list as $i) {
                        if ($i->result != TASK_RESULT_NA) {
                            $total['result'] += $i->rate * $i->result;
                            $total['rate'] += $i->rate;
                        }
                    }
                }
            }
        }
        
        return $total;
    }
    
    public function statistic($from, $to)
    {
        $nv = new nhanvien();
        $staff_list = $nv->employee_list();
        
        $category_model = new task_result_category();
        
        $output = array();
        if (is_array($staff_list))
        {
            $category_list = $category_model->get_all();
            
            foreach ($staff_list as $e)
            {
                $output[$e['manv']] = array('hoten' => $e['hoten'], 'result' => '');
                
                if ($category_list == NULL) {
                    return NULL; 
                }
                foreach ($category_list as $c)
                {
                    $output[$e['manv']]['result'][$c->category_id] = array('category_name' => $c->category_name, 
                                                                           'total' => 0, 
                                                                           'rate' => 0,
                                                                          );
                }
            }
            
            // Danh sach cac task trong khoang thoi gian $from -> $to
            $checked = BIT_TRUE;
            $sql = "SELECT task_id, assign_to FROM task WHERE (checked = {$checked}) AND (deadline BETWEEN '{$from}' AND '{$to}')";
            $this->setQuery($sql);
            $arr = $this->loadAllRow();
            $this->disconnect();
            if (!is_array($arr)) {
                return NULL;
            }
            // Thuc hien lay ket qua cua cac task trong danh sach
            foreach ($arr as $i)
            {
                //debug($i);
                foreach ($category_list as $c)
                {
                   $r_list = $this->detail_by_task($i['task_id'], $c->category_id, $i['assign_to']);
                   //debug($r_list);
                   
                   if ($r_list != NULL) {
                       foreach ($r_list as $r) {
                           if ($r->result != TASK_RESULT_NA) {
                               $output[$i['assign_to']]['result'][$c->category_id]['total'] += $r->rate * $r->result;
                               $output[$i['assign_to']]['result'][$c->category_id]['rate'] += $r->rate;
                           }
                       }
                   }
                }
            }
            
            return $output;
        }
        
        return NULL;
    }
    
    public function statistic_list($from, $to, $export=FALSE, &$field_list=NULL, &$column_name=NULL)
    {
        $data = $this->statistic($from, $to);
        $category_model = new task_result_category();
        $category_list = $category_model->get_all();
        
        if ($data != NULL) {
            if (!$export) { // No export
                $arr = array();
            
                foreach ($data as $k => $v)
                {
                    $row = array();
                    $total = 0;
            
                    $row[] = $v['hoten'];
                    foreach ($category_list as $c)
                    {
                        $tmp = $v['result'][$c->category_id]['total'];
                        $row[] = $tmp;
            
                        $total += $tmp;
                    }
                    $row[] = $total;
            
                    $arr[] = $row;
                }
                
                return $arr;
            } else { // Export to Excel
                $field_list = array('manv');
                $column_name = array('Nhân viên');
                foreach ($category_list as $c)
                {
                    $field_list[] = $c->category_id;
                    $column_name[] = $c->category_name;
                }
                $field_list[] = 'total';
                $column_name[] = 'Tổng cộng';
                
                $arr = array();
                
                foreach ($data as $k => $v)
                {
                    $row = array();
                    $total = 0;
                
                    $row['manv'] = $v['hoten'];
                    foreach ($category_list as $c)
                    {
                        $tmp = $v['result'][$c->category_id]['total'];
                        $row[$c->category_id] = $tmp;
                
                        $total += $tmp;
                    }
                    $row['total'] = $total;
                
                    $arr[] = $row;
                }
                
                return $arr;
            }
        }
        
        return NULL;
    }
    
    public function average_list($from, $to, $export=FALSE, &$field_list=NULL, &$column_name=NULL)
    {
        $data = $this->statistic($from, $to);
        $category_model = new task_result_category();
        $category_list = $category_model->get_all();
    
        if ($data != NULL) {
            if (!$export) { // No export
                $arr = array();
                foreach ($data as $k => $v)
                {
                    $row = array();
                    $total = 0;
                    $rate = 0;
    
                    $row[] = $v['hoten'];
                    foreach ($category_list as $c)
                    {
                        $tmp_total = $v['result'][$c->category_id]['total'];
                        $tmp_rate = $v['result'][$c->category_id]['rate'];
                        $row[] = ($tmp_rate != 0) ? round($tmp_total / $tmp_rate, 2) : 0;
    
                        $total += $tmp_total;
                        $rate += $tmp_rate;
                    }
                    $row[] = ($rate != 0) ? round($total / $rate, 2) : 0;;
    
                    $arr[] = $row;
                }
    
                return $arr;
            } else { // Export to Excel
                $field_list = array('manv');
                $column_name = array('Nhân viên');
                foreach ($category_list as $c)
                {
                    $field_list[] = $c->category_id;
                    $column_name[] = $c->category_name;
                }
                $field_list[] = 'total';
                $column_name[] = 'Tổng cộng';
    
                $arr = array();
                foreach ($data as $k => $v)
                {
                    $row = array();
                    $total = 0;
                    $rate = 0;
    
                    $row['manv'] = $v['hoten'];
                    foreach ($category_list as $c)
                    {
                        $tmp_total = $v['result'][$c->category_id]['total'];
                        $tmp_rate = $v['result'][$c->category_id]['rate'];
                        $row[$c->category_id] = ($tmp_rate != 0) ? round($tmp_total / $tmp_rate, 2) : 0;
    
                        $total += $tmp_total;
                        $rate += $tmp_rate;
                    }
                    $row['total'] = ($rate != 0) ? round($total / $rate, 2) : 0;;
    
                    $arr[] = $row;
                }
    
                return $arr;
            }
        }
    
        return NULL;
    }
}

/* End of file */