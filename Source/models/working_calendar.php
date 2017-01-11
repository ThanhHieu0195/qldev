<?php
require_once '../entities/working_calendar_entity.php';
require_once '../models/database.php';
require_once '../models/nhanvien.php';
require_once '../models/khohang.php';
class working_calendar extends database {
    public function insert(working_calendar_entity $item) {
        $sql = "INSERT INTO `working_calendar` (`uid`, `worker`, `working_date`, `branch`, 
                                                `on_leave`, `note`, `created_by`, `approved`, `plan_uid`)
                VALUES('{$item->uid}', '{$item->worker}', '{$item->working_date}', '{$item->branch}', 
                       '{$item->on_leave}', '{$item->note}', '{$item->created_by}', '{$item->approved}', '{$item->plan_uid}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function update(working_calendar_entity $item) {
        $sql = "UPDATE `working_calendar` 
                SET `uid` = '{$item->uid}' , `worker` = '{$item->worker}' , `working_date` = '{$item->working_date}' , `branch` = '{$item->branch}' , 
                    `on_leave` = '{$item->on_leave}' , `note` = '{$item->note}' , `created_by` = '{$item->created_by}' , `approved` = '{$item->approved}' ,
                    `plan_uid` = '{$item->plan_uid}'
                WHERE `worker` = '{$item->worker}' AND `working_date` = '{$item->working_date}'; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete($uid) {
        $sql = "DELETE FROM `working_calendar` WHERE `uid` = '{$uid}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function approve_by_plan($plan_uid, $approved = TRUE) {
        $sql = "UPDATE `working_calendar` SET `approved` = '{$approved}' WHERE `plan_uid` = '{$plan_uid}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail_by_worker_date($worker, $new_date) {
        $sql = "SELECT * FROM `working_calendar` WHERE `worker` = '{$worker}' AND working_date = '{$new_date}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new working_calendar_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    public function detail($uid) {
        $sql = "SELECT * FROM `working_calendar` WHERE `uid` = '{$uid}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new working_calendar_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    public function detail_list($plan_uid, $date, $branch) {
        $sql = "SELECT * FROM `working_calendar` WHERE `plan_uid` = '{$plan_uid}' AND `working_date` = '{$date}' AND `branch` = '{$branch}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $result )) {
            $list = array ();
            foreach ( $result as $row ) {
                $item = new working_calendar_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
            
            return $list;
        }
        return NULL;
    }
    public function detail_list_by_date($date, $branch, $all_type = FALSE, $all_item = FALSE) {
        $sql = "SELECT * FROM `working_calendar` WHERE `working_date` = '{$date}' AND `branch` = '{$branch}'";
        
        if (! $all_type) {
            $on_leave = BIT_FALSE;
            $sql .= " AND `on_leave` = '{$on_leave}' ";
        }
        if (! $all_item) {
            $approved = BIT_TRUE;
            $sql .= " AND `approved` = '{$approved}' ";
        }
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $result )) {
            $list = array ();
            foreach ( $result as $row ) {
                $item = new working_calendar_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
            
            return $list;
        }
        return NULL;
    }
    public function leave_days_by_account($worker) {
        $on_leave = BIT_TRUE;
        $approved = BIT_TRUE;
        $sql = "SELECT * FROM `working_calendar` 
                WHERE `worker` = '{$worker}' AND on_leave = {$on_leave}
                      AND approved = {$approved} AND (DATEDIFF(working_date, CURRENT_DATE()) >= 0); ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $result )) {
            $list = array ();
            foreach ( $result as $row ) {
                $item = new working_calendar_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
            
            return $list;
        }
        
        return NULL;
    }
    public function leave_days_statistic($from, $to) {
        // Lay danh sach ngay nghi cua cac nhan vien
        $on_leave = BIT_TRUE;
        $approved = BIT_TRUE;
        $sql = "SELECT worker, COUNT(working_date) AS leave_days
                FROM working_calendar
                WHERE on_leave = {$on_leave} AND approved = {$approved} AND (working_date BETWEEN '{$from}' AND '{$to}')
                GROUP BY worker";
        $this->setQuery ( $sql );
        $leave_days = $this->loadAllRow ();
        $this->disconnect ();
        
        // Danh sach ket qua
        $nv = new nhanvien ();
        $staff_list = $nv->employee_list ();
        if (is_array ( $staff_list )) {
            $output = array ();
            
            foreach ( $staff_list as $e ) {
                $output [$e ['manv']] = array (
                        'manv' => $e ['manv'],
                        'hoten' => $e ['hoten'],
                        'leave_days' => 0 
                );
            }
            
            if (is_array ( $leave_days )) {
                foreach ( $leave_days as $r ) {
                    $output [$r ['worker']] ['leave_days'] = $r ['leave_days'];
                }
            }
            
            return $output;
        }
        
        return NULL;
    }
    public function leave_days_statistic_list($from, $to, $export = FALSE, &$field_list = NULL, &$column_name = NULL) {
        $data = $this->leave_days_statistic ( $from, $to );
        
        if ($data != NULL) {
            if (! $export) { // No export
                $arr = array ();
                
                foreach ( $data as $k => $v ) {
                    $row = array ();
                    
                    $row [] = $v ['manv'];
                    $row [] = $v ['hoten'];
                    $row [] = $v ['leave_days'];
                    
                    $arr [] = $row;
                }
                
                return $arr;
            } else { // Export to Excel
                $field_list = array (
                        'manv',
                        'hoten',
                        'leave_days' 
                );
                $column_name = array (
                        'Mã nhân viên',
                        'Họ tên',
                        'Tổng số ngày nghỉ' 
                );
                
                $arr = array ();
                
                foreach ( $data as $k => $v ) {
                    $row = array ();
                    
                    $row ['manv'] = $v ['manv'];
                    $row ['hoten'] = $v ['hoten'];
                    $row ['leave_days'] = $v ['leave_days'];
                    
                    $arr [] = $row;
                }
                
                return $arr;
            }
        }
        
        return NULL;
    }
    public function create_calendar($from_date, $to_date, $branches) {
        // Output format
        $cal = array (
                'count' => 0,
                'data' => array () 
        );
        
        // Get branches name
        $kh = new khohang ();
        $branch_names = $kh->get_list_name ( $branches );
        // debug ( $branch_names );
        
        $from_date = strtotime ( $from_date );
        $to_date = strtotime ( $to_date );
        // debug ( $from_date );
        // debug ( $to_date );
        $list = NULL;
        if ($from_date <= $to_date && is_array ( $branch_names )) {
            // w.worker, n.hoten, w.working_date, w.branch, k.tenkho
            $list = array ();
            
            for($day = $from_date; $day <= $to_date;) {
                foreach ( $branches as $b ) {
                    $tmp = array (
                            'worker' => '',
                            'hoten' => '',
                            'working_date' => date ( 'Y-m-d', $day ),
                            'branch' => $b,
                            'tenkho' => $branch_names [$b] 
                    );
                    
                    $list [] = $tmp;
                }
                
                $day = strtotime ( "+1 day", $day );
            }
        }
        
        if (is_array ( $list )) {
            // Array list determines mumeric representation of the day of the week
            $day_of_week = array (
                    0 => 'sun',
                    1 => 'mon',
                    2 => 'tue',
                    3 => 'wed',
                    4 => 'thu',
                    5 => 'fri',
                    6 => 'sat' 
            );
            
            // Create calendar data
            foreach ( $list as $row ) {
                // 1: Get the mumeric representation of the week
                $wk = dbtime_2_systime ( $row ['working_date'], 'W' );
                
                // 2: Get the item in 'data' list
                if (! isset ( $cal ['data'] [$wk] )) {
                    // Get first & last day of the week that contains the working date
                    $arr = getweek_first_last_date ( $row ['working_date'] );
                    $monday = $arr ['start_date_of_week'];
                    $sunday = $arr ['end_date_of_week'];
                    $day_format = 'd/m/Y';
                    
                    // Create new item
                    $data_item = array (
                            'week' => $wk,
                            'description' => sprintf ( '%s - %s', date ( 'd/m', $monday ), date ( 'd/m/Y', $sunday ) ),
                            'days' => array (
                                    'start_date' => date ( 'Y-m-d', $monday ),
                                    'mon' => date ( $day_format, $monday ),
                                    'tue' => date ( $day_format, strtotime ( "+1 day", $monday ) ),
                                    'wed' => date ( $day_format, strtotime ( "+2 days", $monday ) ),
                                    'thu' => date ( $day_format, strtotime ( "+3 days", $monday ) ),
                                    'fri' => date ( $day_format, strtotime ( "+4 days", $monday ) ),
                                    'sat' => date ( $day_format, strtotime ( "+5 days", $monday ) ),
                                    'sun' => date ( $day_format, $sunday ) 
                            ),
                            'calendar' => array () 
                    );
                    
                    // Insert that item to 'data' list
                    $cal ['data'] [$wk] = $data_item;
                }
                
                // 3: Get the item in 'calendar' list
                $branch = $row ['branch'];
                if (! isset ( $cal ['data'] [$wk] ['calendar'] [$branch] )) {
                    // Create new item
                    $calendar_item = array (
                            'branch' => $branch,
                            'name' => $row ['tenkho'],
                            'mon' => array (),
                            'tue' => array (),
                            'wed' => array (),
                            'thu' => array (),
                            'fri' => array (),
                            'sat' => array (),
                            'sun' => array () 
                    );
                    
                    // Insert that item to 'calendar' list
                    $cal ['data'] [$wk] ['calendar'] [$branch] = $calendar_item;
                }
                
                // 4: Insert worker information
                $cal ['data'] [$wk] ['calendar'] [$branch] [$day_of_week [dbtime_2_systime ( $row ['working_date'], 'w' )]] [] = $row ['hoten'];
            }
            
            // Calculate length of output
            $cal ['count'] = count ( $cal ['data'] );
        }
        
        return $cal;
        // return json_encode($cal);
    }
    public function calendar($date, $to = NULL) {
        // Output format
        $cal = array (
                'count' => 0,
                'data' => array () 
        );
        
        // Get calendar data from database
        $approved = BIT_TRUE;
        $on_leave = BIT_FALSE;
        
        $where = "WHERE approved = {$approved} AND on_leave = {$on_leave}";
        if ($to == NULL) {
            $where .= " AND DATEDIFF(working_date, '$date') >= 0 ";
        } else {
            $where .= " AND(working_date BETWEEN '{$date}' AND '{$to}') ";
        }
        
        $sql = "SELECT w.worker, n.hoten, w.working_date, w.branch, k.tenkho, 
                       w.uid, w.working_date, w.branch, w.on_leave
                FROM working_calendar w INNER JOIN nhanvien n ON w.worker = n.manv
                                        INNER JOIN khohang k ON w.branch = k.makho
                $where
                ORDER BY working_date, tenkho, worker";
        $this->setQuery ( $sql );
        $list = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $list )) {
            // Array list determines mumeric representation of the day of the week
            $day_of_week = array (
                    0 => 'sun',
                    1 => 'mon',
                    2 => 'tue',
                    3 => 'wed',
                    4 => 'thu',
                    5 => 'fri',
                    6 => 'sat' 
            );
            
            // Create calendar data
            foreach ( $list as $row ) {
                // 1: Get the mumeric representation of the week
                $wk = dbtime_2_systime ( $row ['working_date'], 'W' );
                $year = dbtime_2_systime ( $row ['working_date'], 'Y' );
                
                // 2: Get the item in 'data' list
                if (! isset ( $cal ['data'] [$wk] )) {
                    // Get first & last day of the week that contains the working date
                    $arr = getweek_first_last_date ( $row ['working_date'] );
                    $monday = $arr ['start_date_of_week'];
                    $sunday = $arr ['end_date_of_week'];
                    $day_format = 'd/m/Y';
                    
                    // Create new item
                    $data_item = array (
                            'week' => $wk,
                            'year' => $year,
                            'description' => sprintf ( '%s - %s', date ( 'd/m', $monday ), date ( 'd/m/Y', $sunday ) ),
                            'days' => array (
                                    'start_date' => date ( 'Y-m-d', $monday ),
                                    'mon' => date ( $day_format, $monday ),
                                    'tue' => date ( $day_format, strtotime ( "+1 day", $monday ) ),
                                    'wed' => date ( $day_format, strtotime ( "+2 days", $monday ) ),
                                    'thu' => date ( $day_format, strtotime ( "+3 days", $monday ) ),
                                    'fri' => date ( $day_format, strtotime ( "+4 days", $monday ) ),
                                    'sat' => date ( $day_format, strtotime ( "+5 days", $monday ) ),
                                    'sun' => date ( $day_format, $sunday ) 
                            ),
                            'calendar' => array () 
                    );
                    
                    // Insert that item to 'data' list
                    $cal ['data'] [$wk] = $data_item;
                }
                
                // 3: Get the item in 'calendar' list
                $branch = $row ['branch'];
                if (! isset ( $cal ['data'] [$wk] ['calendar'] [$branch] )) {
                    // Create new item
                    $calendar_item = array (
                            'branch' => $branch,
                            'name' => $row ['tenkho'],
                            'mon' => array (),
                            'tue' => array (),
                            'wed' => array (),
                            'thu' => array (),
                            'fri' => array (),
                            'sat' => array (),
                            'sun' => array () 
                    );
                    
                    // Insert that item to 'calendar' list
                    $cal ['data'] [$wk] ['calendar'] [$branch] = $calendar_item;
                }
                
                // 4: Insert worker information
                $tmp = array (
                        // 'uid' => $row ['uid'],
                        'worker' => $row ['worker'],
                        'hoten' => $row ['hoten'] 
                // 'working_date' => $row ['working_date'],
                // 'on_leave' => $row ['on_leave']
                                );
                $cal ['data'] [$wk] ['calendar'] [$branch] [$day_of_week [dbtime_2_systime ( $row ['working_date'], 'w' )]] [] = $tmp;
            }
            
            // Calculate length of output
            $cal ['count'] = count ( $cal ['data'] );
        }
        
        return $cal;
        // return json_encode($cal);
    }
    public function plan_detail($plan_uid) {
        // Output format
        $cal = array (
                'count' => 0,
                'data' => array () 
        );
        
        // Get calendar data from database
        $approved = BIT_TRUE;
        $on_leave = BIT_FALSE;
        
        $where = "WHERE w.plan_uid = '{$plan_uid}'";
        
        $sql = "SELECT w.worker, n.hoten, w.working_date, w.branch, k.tenkho,
                       w.uid, w.working_date, w.branch, w.on_leave
                FROM working_calendar w INNER JOIN nhanvien n ON w.worker = n.manv
                                        INNER JOIN khohang k ON w.branch = k.makho
                $where
                ORDER BY tenkho, working_date, worker";
        $this->setQuery ( $sql );
        $list = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $list )) {
            // Array list determines mumeric representation of the day of the week
            $day_of_week = array (
                    0 => 'sun',
                    1 => 'mon',
                    2 => 'tue',
                    3 => 'wed',
                    4 => 'thu',
                    5 => 'fri',
                    6 => 'sat' 
            );
            
            // Create calendar data
            foreach ( $list as $row ) {
                // 1: Get the mumeric representation of the week
                $wk = dbtime_2_systime ( $row ['working_date'], 'W' );
                
                // 2: Get the item in 'data' list
                if (! isset ( $cal ['data'] [$wk] )) {
                    // Get first & last day of the week that contains the working date
                    $arr = getweek_first_last_date ( $row ['working_date'] );
                    $monday = $arr ['start_date_of_week'];
                    $sunday = $arr ['end_date_of_week'];
                    $day_format = 'd/m/Y';
                    
                    // Create new item
                    $data_item = array (
                            'week' => $wk,
                            'description' => sprintf ( '%s - %s', date ( 'd/m', $monday ), date ( 'd/m/Y', $sunday ) ),
                            'days' => array (
                                    'start_date' => date ( 'Y-m-d', $monday ),
                                    'mon' => date ( $day_format, $monday ),
                                    'tue' => date ( $day_format, strtotime ( "+1 day", $monday ) ),
                                    'wed' => date ( $day_format, strtotime ( "+2 days", $monday ) ),
                                    'thu' => date ( $day_format, strtotime ( "+3 days", $monday ) ),
                                    'fri' => date ( $day_format, strtotime ( "+4 days", $monday ) ),
                                    'sat' => date ( $day_format, strtotime ( "+5 days", $monday ) ),
                                    'sun' => date ( $day_format, $sunday ) 
                            ),
                            'calendar' => array () 
                    );
                    
                    // Insert that item to 'data' list
                    $cal ['data'] [$wk] = $data_item;
                }
                
                // 3: Get the item in 'calendar' list
                $branch = $row ['branch'];
                if (! isset ( $cal ['data'] [$wk] ['calendar'] [$branch] )) {
                    // Create new item
                    $calendar_item = array (
                            'branch' => $branch,
                            'name' => $row ['tenkho'],
                            'mon' => array (),
                            'tue' => array (),
                            'wed' => array (),
                            'thu' => array (),
                            'fri' => array (),
                            'sat' => array (),
                            'sun' => array () 
                    );
                    
                    // Insert that item to 'calendar' list
                    $cal ['data'] [$wk] ['calendar'] [$branch] = $calendar_item;
                }
                
                // 4: Insert worker information
                $tmp = array (
                        'uid' => $row ['uid'],
                        'hoten' => $row ['hoten'],
                        'working_date' => $row ['working_date'],
                        'on_leave' => $row ['on_leave'] 
                );
                $cal ['data'] [$wk] ['calendar'] [$branch] [$day_of_week [dbtime_2_systime ( $row ['working_date'], 'w' )]] [] = $tmp;
            }
            
            // Calculate length of output
            $cal ['count'] = count ( $cal ['data'] );
        }
        
        return $cal;
        // return json_encode($cal);
    }
}

/* End of file */