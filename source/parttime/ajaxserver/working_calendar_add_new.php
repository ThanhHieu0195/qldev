<?php
require_once '../part/common_start_page.php';
require_once '../models/working_calendar.php';
require_once '../models/working_plan.php';

$result = array (
        'result' => 0, // Error status
                       // 0: Error occurred
                       // 1: There is no data
                       // 2: Success
        'action' => '', // Actions: 'approve', 'reject'
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => ''  // Detail message
);

if (verify_access_right ( current_account (), G_WORKING_CALENDAR, KEY_GROUP )) {
    
    // DB model
    $calendar_model = new working_calendar ();
    $plan_model = new working_plan ();
    
    try {
        
        // Detail format
        $detail_format = "<span style=''><a id='%s' href='javascript:' onclick='return deleteWorker(\"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\");' title='Xóa'><img src='../resources/images/icons/delete_16.png' alt='delete'></a> %s</span><br />";
        $detail_format = str_replace ( "<", "@", $detail_format );
        $detail_format = str_replace ( ">", "#", $detail_format );
        
        // $detail_format_onleave = "• <span style='text-decoration:line-through;'>%s</span><br />";
        $detail_format_onleave = "<span style='color:red;'><a id='%s' href='javascript:' onclick='return deleteWorker(\"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\");' title='Xóa'><img src='../resources/images/icons/delete_16.png' alt='delete'></a> %s</span><br />";
        $detail_format_onleave = str_replace ( "<", "@", $detail_format_onleave );
        $detail_format_onleave = str_replace ( ">", "#", $detail_format_onleave );
        
        // Create a new calendar
        if (isset ( $_REQUEST ['submit'] )) {
            // Get input data
            $branches = $_REQUEST ['branch'];
            $from_date = $_REQUEST ['from_date'];
            $to_date = $_REQUEST ['to_date'];
            
            // Insert a plan into database
            $plan = new working_plan_entity ();
            $plan->branches = $branches;
            $plan->from_date = $from_date;
            $plan->to_date = $to_date;
            $plan->created_by = current_account ();
            
            if ($plan_model->insert ( $plan )) {
                // Generate calendar information
                $cal = $calendar_model->create_calendar ( $from_date, $to_date, $branches );
                
                if ($cal ['count'] == 0) {
                    $result ['result'] = 0;
                    $result ['message'] = 'Không tạo được bảng lịch làm việc. Vui lòng kiểm tra lại các dữ liệu bạn đã nhập!';
                } else {
                    $result ['result'] = 2;
                    
                    // Create ouput html
                    $output_html = '';
                    $day_of_week = array (
                            'mon',
                            'tue',
                            'wed',
                            'thu',
                            'fri',
                            'sat',
                            'sun' 
                    );
                    
                    // Plan uid
                    $output_html .= "<input type='hidden' name='plan_uid' value='{$plan->plan_uid}' />";
                    
                    $i = 0;
                    foreach ( $cal ['data'] as $key => $d ) {
                        $i ++;
                        $count = count ( $d ['calendar'] );
                        
                        $output_html .= "<div class='scroll'>";
                        // $output_html .= "<hr />";
                        $output_html .= "<div>&nbsp;<img src='../resources/images/icons/calendar_16.png' alt='calendar'> Tuần <label class='price bold'>{$d['week']}</label> ({$d['description']})</div>";
                        $output_html .= "    <table class='bordered' id='example_{$i}'>";
                        $output_html .= "        <thead>";
                        $output_html .= "            <tr>";
                        // $output_html .= " <th rowspan='2'>Tuần</th>";
                        $output_html .= "                <th rowspan='2' width='16P%'>Chi nhánh</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T2</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T3</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T4</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T5</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T6</th>";
                        $output_html .= "                <th class='sat' width='12P%'>T7</th>";
                        $output_html .= "                <th class='sun' width='12P%'>CN</th>";
                        $output_html .= "            </tr>";
                        $output_html .= "            <tr>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['mon']}</th>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['tue']}</th>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['wed']}</th>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['thu']}</th>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['fri']}</th>";
                        $output_html .= "                <th class='sat'>{$d['days']['sat']}</th>";
                        $output_html .= "                <th class='sun'>{$d['days']['sun']}</th>";
                        $output_html .= "            </tr>";
                        $output_html .= "        </thead>";
                        $output_html .= "        <tbody>";
                        
                        $j = 0;
                        foreach ( $d ['calendar'] as $key2 => $c ) {
                            $class = ($j % 2 != 0) ? 'alt-row' : '';
                            
                            $row_id = create_uid ();
                            $output_html .= "            <tr id='{$row_id}'>";
                            if ($j == 0) {
                                // $output_html .= " <td rowspan='{$count}'><label class='price bold'>{$d['week']}</label><br /><br />({$d['description']})</td>";
                            }
                            $output_html .= "                <td class='{$class}'><span class='blue-text'>{$c['name']}</span>
                            <a href='%messages' rel='modal' title='Chọn nhân viên' onclick='return setInputData(\"{$plan->plan_uid}\", \"{$d['week']} ({$d['description']})\", 
                                                                                                                \"{$c['branch']}\", \"{$c['name']}\", \"{$d['days']['start_date']}\", 
                                                                                                                \"{$row_id}\");'>
                            <img src='../resources/images/icons/user_16.png' alt='Add'>
                            </a></td>";
                            
                            for($index = 0; $index < count ( $day_of_week ); $index ++) {
                                $output_html .= "                <td col_name='{$day_of_week [$index]}' class='{$class}'>";
                                for($z = 0; $z < count ( $c [$day_of_week [$index]] ); $z ++) {
                                    $s = $c [$day_of_week [$index]] [$z];
                                    if (! empty ( $s )) {
                                        $output_html .= "                    • {$s}<br />";
                                    }
                                }
                                $output_html .= "                </td>";
                            }
                            
                            $output_html .= "            </tr>";
                            
                            $j ++;
                        }
                        
                        $output_html .= "        </tbody>";
                        $output_html .= "    </table>";
                        $output_html .= "</div>";
                        if ($i != count ( $cal ['data'] )) {
                            $output_html .= "<div class='clear'></div>";
                        }
                    }
                    // Script to display dialog
                    $output_html .= "<script type=\"text/javascript\">";
                    $output_html .= "    $('a[rel*=modal]').facebox();";
                    $output_html .= "</script>";
                    
                    // Ouput
                    $output_html = str_replace ( "<", "@", $output_html );
                    $output_html = str_replace ( ">", "#", $output_html );
                    $result ['detail'] = $output_html;
                }
            } else {
                $result ['result'] = 0;
                $result ['message'] = $plan_model->getMessage ();
            }
        }
        
        // Get plan detail to approve/reject
        if (isset ( $_REQUEST ['get_plan_detail'] )) {
            // Get input data
            $plan_uid = $_REQUEST ['plan_uid'];
            
            // Get plan detail from database
            $plan = $plan_model->detail ( $plan_uid );
            
            if ($plan != NULL && $plan->approved == BIT_FALSE) {
                // Generate calendar information
                $cal = $calendar_model->plan_detail ( $plan_uid );
                
                if ($cal ['count'] == 0) {
                    $result ['result'] = 0;
                    $result ['message'] = 'Không tìm thấy chi tiết của lịch làm việc';
                } else {
                    $result ['result'] = 2;
                    
                    // Create ouput html
                    $output_html = '';
                    $day_of_week = array (
                            'mon',
                            'tue',
                            'wed',
                            'thu',
                            'fri',
                            'sat',
                            'sun' 
                    );
                    
                    // Plan uid
                    $output_html .= "<input type='hidden' name='plan_uid' value='{$plan->plan_uid}' />";
                    
                    $i = 0;
                    foreach ( $cal ['data'] as $key => $d ) {
                        $i ++;
                        $count = count ( $d ['calendar'] );
                        
                        $output_html .= "<div class='scroll'>";
                        // $output_html .= "<hr />";
                        $output_html .= "<div>&nbsp;<img src='../resources/images/icons/calendar_16.png' alt='calendar'> Tuần <label class='price bold'>{$d['week']}</label> ({$d['description']})</div>";
                        $output_html .= "    <table class='bordered' id='example_{$i}'>";
                        $output_html .= "        <thead>";
                        $output_html .= "            <tr>";
                        // $output_html .= " <th rowspan='2'>Tuần</th>";
                        $output_html .= "                <th rowspan='2' width='16P%'>Chi nhánh</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T2</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T3</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T4</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T5</th>";
                        $output_html .= "                <th class='weekdays' width='12P%'>T6</th>";
                        $output_html .= "                <th class='sat' width='12P%'>T7</th>";
                        $output_html .= "                <th class='sun' width='12P%'>CN</th>";
                        $output_html .= "            </tr>";
                        $output_html .= "            <tr>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['mon']}</th>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['tue']}</th>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['wed']}</th>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['thu']}</th>";
                        $output_html .= "                <th class='weekdays'>{$d['days']['fri']}</th>";
                        $output_html .= "                <th class='sat'>{$d['days']['sat']}</th>";
                        $output_html .= "                <th class='sun'>{$d['days']['sun']}</th>";
                        $output_html .= "            </tr>";
                        $output_html .= "        </thead>";
                        $output_html .= "        <tbody>";
                        
                        $j = 0;
                        foreach ( $d ['calendar'] as $key2 => $c ) {
                            $class = ($j % 2 != 0) ? 'alt-row' : '';
                            
                            $row_id = create_uid ();
                            $output_html .= "            <tr id='{$row_id}'>";
                            if ($j == 0) {
                                // $output_html .= " <td rowspan='{$count}'><label class='price bold'>{$d['week']}</label><br /><br />({$d['description']})</td>";
                            }
                            $output_html .= "                <td class='{$class}'><span class='blue-text'>{$c['name']}</span>
                            <a href='%messages' rel='modal' title='Chọn nhân viên' onclick='return setInputData(\"{$plan->plan_uid}\", \"{$d['week']} ({$d['description']})\",
                            \"{$c['branch']}\", \"{$c['name']}\", \"{$d['days']['start_date']}\",
                            \"{$row_id}\");'>
                                    <img src='../resources/images/icons/user_16.png' alt='Add'>
                                    </a></td>";
                            
                            for($index = 0; $index < count ( $day_of_week ); $index ++) {
                                $output_html .= "                <td col_name='{$day_of_week [$index]}' class='{$class}'>";
                                for($z = 0; $z < count ( $c [$day_of_week [$index]] ); $z ++) {
                                    $s = $c [$day_of_week [$index]] [$z];
                                    if (! empty ( $s )) {
                                        $ctrl_id = create_uid ();
                                        
                                        if ($s ['on_leave'] == BIT_FALSE) {
                                            $html_text = sprintf ( $detail_format, $ctrl_id, $ctrl_id, $row_id, $s ['uid'], $plan_uid, $day_of_week [$index], $s ['working_date'], $c ['branch'], $s ['hoten'] );
                                        } else {
                                            $html_text = sprintf ( $detail_format_onleave, $ctrl_id, $ctrl_id, $row_id, $s ['uid'], $plan_uid, $day_of_week [$index], $s ['working_date'], $c ['branch'], $s ['hoten'] );
                                        }
                                        
                                        $output_html .= $html_text;
                                    }
                                }
                                $output_html .= "                </td>";
                            }
                            
                            $output_html .= "            </tr>";
                            
                            $j ++;
                        }
                        
                        $output_html .= "        </tbody>";
                        $output_html .= "    </table>";
                        $output_html .= "</div>";
                        if ($i != count ( $cal ['data'] )) {
                            $output_html .= "<div class='clear'></div>";
                        }
                    }
                    // Script to display dialog
                    $output_html .= "<script type=\"text/javascript\">";
                    $output_html .= "    $('a[rel*=modal]').facebox();";
                    $output_html .= "</script>";
                    
                    // Ouput
                    $output_html = str_replace ( "<", "@", $output_html );
                    $output_html = str_replace ( ">", "#", $output_html );
                    $result ['detail'] = $output_html;
                }
            } else {
                $result ['result'] = 0;
                $result ['message'] = "The plan '{$plan_uid}' has no detail or it had approved.";
            }
        }
        
        // Add workers to calendar
        if (isset ( $_REQUEST ['add_workers'] )) {
            
            // Get input data
            $plan_uid = $_REQUEST ['dest_plan_uid'];
            $start_date = $_REQUEST ['start_date'];
            $workers = $_REQUEST ['worker'];
            $weekdays = $_REQUEST ['weekdays'];
            // debug($weekdays);
            $branch = $_REQUEST ['dest_branch'];
            $row_id = $_REQUEST ['row_id'];
            $created_by = current_account ();
            
            if (is_array ( $workers )) {
                
                // Initial values
                $success = 0;
                
                // DB model
                $model = new working_calendar ();
                $nv = new nhanvien ();
                
                // Workers names
                $worker_names = $nv->get_list_name ( $workers );
                
                // Detail messages
                $detail_message = array (
                        'row' => "{$row_id}",
                        'mon' => '',
                        'tue' => '',
                        'wed' => '',
                        'thu' => '',
                        'fri' => '',
                        'sat' => '',
                        'sun' => '' 
                );
                
                // Week days name
                $day_numeric = array (
                        'mon' => 0,
                        'tue' => 1,
                        'wed' => 2,
                        'thu' => 3,
                        'fri' => 4,
                        'sat' => 5,
                        'sun' => 6 
                );
                
                // Week days
                $days = get_weekdays ( $start_date );
                
                // Create calendar items for above week days
                foreach ( $days as $key => $wday ) {
                    $item = new working_calendar_entity ();
                    $item->branch = $branch; // Chi nhanh
                    $item->created_by = $created_by; // Nguoi tao
                    $item->working_date = $wday; // Ngay lam viec
                                                 // Kiem tra ngay nghi phep
                    if (array_search ( $day_numeric [$key], $weekdays ) === FALSE) {
                        $item->on_leave = BIT_TRUE;
                        $item->note = '';
                    } else {
                        $item->on_leave = BIT_FALSE;
                    }
                    $item->approved = BIT_FALSE;
                    $item->plan_uid = $plan_uid;
                    
                    // Worker list
                    for($j = 0; $j < count ( $workers ); $j ++) {
                        $entity = $item->copy ();
                        $entity->worker = $workers [$j]; // Nhan vien lam viec
                        if ($model->insert ( $entity )) {
                            $success ++;
                            $w_name = $worker_names [$entity->worker];
                            $ctrl_id = create_uid ();
                            
                            if ($entity->on_leave == BIT_FALSE) {
                                $detail_message [$key] .= sprintf ( $detail_format, $ctrl_id, $ctrl_id, $row_id, $entity->uid, $plan_uid, $key, $wday, $branch, $w_name );
                            } else {
                                $detail_message [$key] .= sprintf ( $detail_format_onleave, $ctrl_id, $ctrl_id, $row_id, $entity->uid, $plan_uid, $key, $wday, $branch, $w_name );
                            }
                        } else {
                            // Do nothing
                            // $result ['message'] .= $model->getMessage();
                        }
                    }
                }
                
                // Output results
                if ($success > 0) {
                    $result ['result'] = 1;
                    $result ['message'] = '';
                    // $detail_message['row'] = $row_id;
                    $result ['detail'] = array (
                            $detail_message 
                    );
                }
            }
        }
        
        // Add workers to calendar
        if (isset ( $_REQUEST ['delete_workers'] )) {
            // Get input data
            $row_id = $_REQUEST ['row_id'];
            $cal_uid = $_REQUEST ['cal_uid'];
            $plan_uid = $_REQUEST ['plan_uid'];
            $wday = $_REQUEST ['wday'];
            $date = $_REQUEST ['date'];
            $branch = $_REQUEST ['branch'];
            
            // DB model
            $model = new working_calendar ();
            $nv = new nhanvien ();
            
            if ($model->delete ( $cal_uid )) {
                // Ouput results
                $result ['result'] = 1;
                $result ['message'] = '';
                $detail_message = '';
                
                $arr = $model->detail_list ( $plan_uid, $date, $branch );
                if (is_array ( $arr )) {
                    foreach ( $arr as $entity ) {
                        $w_name = $nv->thong_tin_nhan_vien ( $entity->worker );
                        $w_name = $w_name ['hoten'];
                        $ctrl_id = create_uid ();
                        
                        if ($entity->on_leave == BIT_FALSE) {
                            $detail_message .= sprintf ( $detail_format, $ctrl_id, $ctrl_id, $row_id, $entity->uid, $plan_uid, $wday, $date, $branch, $w_name );
                        } else {
                            $detail_message .= sprintf ( $detail_format_onleave, $ctrl_id, $ctrl_id, $row_id, $entity->uid, $plan_uid, $wday, $date, $branch, $w_name );
                        }
                    }
                    
                    $result ['detail'] = $detail_message;
                }
            }
        }
        
        // Reject plan calendar
        if (isset ( $_REQUEST ['reject'] )) {
            if (verify_access_right ( current_account (), F_WORKING_CALENDAR_APPROVE_CALENDAR )) {
                // Get input data
                $plan_uid = $_REQUEST ['plan_uid'];
                
                // DB model
                $model = new working_plan ();
                
                // Delete plan calendar
                $result ['action'] = 'reject';
                if ($model->delete ( $plan_uid )) {
                    // Ouput results
                    $result ['result'] = 1;
                    $result ['message'] = '';
                } else {
                    $result ['result'] = 0;
                    $result ['message'] = $model->getMessage ();
                }
            }
        }
        
        // Reject plan calendar
        if (isset ( $_REQUEST ['approve'] )) {
            if (verify_access_right ( current_account (), F_WORKING_CALENDAR_APPROVE_CALENDAR )) {
                // Get input data
                $plan_uid = $_REQUEST ['plan_uid'];
                
                // DB model
                $plan_model = new working_plan ();
                $cal_model = new working_calendar ();
                
                // Approve plan calendar
                $result ['action'] = 'approve';
                // Get plan detail from database
                $plan = $plan_model->detail ( $plan_uid );
                
                if ($plan != NULL && $plan->approved == BIT_FALSE) {
                    
                    // Update database
                    $plan->approved = BIT_TRUE;
                    if ($plan_model->update ( $plan )) {
                        if ($cal_model->approve_by_plan ( $plan_uid )) {
                            // Ouput results
                            $result ['result'] = 1;
                            $result ['message'] = '';
                        } else {
                            $result ['result'] = 0;
                            $result ['message'] = $cal_model->getMessage ();
                        }
                    } else {
                        $result ['result'] = 0;
                        $result ['message'] = $plan_model->getMessage ();
                    }
                } else {
                    $result ['result'] = 0;
                    $result ['message'] = "The plan '{$plan_uid}' has no detail or it had approved.";
                }
            }
        }
    } catch ( Exception $e ) {
        $result ['message'] = $e->getMessage ();
    }
}

echo json_encode ( $result );
// echo $result ['detail'];
// ob_end_flush();
require_once '../part/common_end_page.php';
?>