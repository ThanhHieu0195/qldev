<?php
require_once '../part/common_start_page.php';
require_once '../models/working_calendar.php';
require_once '../models/khohang.php';

$result = array (
        'result' => 0, // Error status
                       // 0: Error occurred
                       // 1: There is no data
                       // 2: Success
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => ''  // Detail message
);

if (verify_access_right ( current_account (), array (
        F_WORKING_CALENDAR_UPDATE_CALENDAR
) )) {
    
    // DB model
    $calendar_model = new working_calendar ();
    
    try {
        // Detail format
        // Function: changeStore(ctrl_id, week_id, worker, from_store, day_of_week, start_date)
        $detail_format = "<span style=''><a id='%s' href='javascript:' onclick='return changeStore(\"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\");' title='Cập nhật chi nhánh'><img src='../resources/images/icons/hammer_screwdriver.png' alt='update'></a> %s</span><br />";
        $detail_format = str_replace ( "<", "@", $detail_format );
        $detail_format = str_replace ( ">", "#", $detail_format );
        
        /* Get the calendar data */
        if (isset ( $_POST ['get_calendar'] )) {
            // Get input data
            $is_view_all = (isset ( $_POST ['view'] )) ? FALSE : TRUE;
            if (! $is_view_all) {
                $date = $_POST ['from'];
                $to = $_POST ['to'];
            } else {
                // Get first day of the current week
                $arr = getweek_first_last_date ( current_timestamp ( 'Y-m-d' ) );
                $date = date ( 'Y-m-d', $arr ['start_date_of_week'] );
                
                $to = NULL;
            }
            
            // Get calendar information
            $cal = $calendar_model->calendar ( $date, $to );
            
            if ($cal ['count'] == 0) {
                $result ['result'] = 1;
                $result ['message'] = 'Không có dữ liệu lịch làm việc tương ứng';
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
                
                $i = 0;
                foreach ( $cal ['data'] as $key => $d ) {
                    $i ++;
                    $week_id = "{$d['year']}_{$d['week']}"; // Week Id and table Id
                    $count = count ( $d ['calendar'] );
                    
                    $output_html .= "<div class='scroll'>";
                    // $output_html .= "<hr />";
                    $output_html .= "<div>&nbsp;<img src='../resources/images/icons/calendar_16.png' alt='calendar'> Tuần <label class='price bold'>{$d['week']}</label>({$d['description']})</div>";
                    $output_html .= "    <table class='bordered' id='{$week_id}'>";
                    $output_html .= "        <thead>";
                    $output_html .= "            <tr>";
                    // $output_html .= " <th rowspan='2'>Tuần</th>";
                    $output_html .= "                <th rowspan='2' width='16%'>Chi nhánh</th>";
                    $output_html .= "                <th class='weekdays'>T2</th>";
                    $output_html .= "                <th class='weekdays'>T3</th>";
                    $output_html .= "                <th class='weekdays'>T4</th>";
                    $output_html .= "                <th class='weekdays'>T5</th>";
                    $output_html .= "                <th class='weekdays'>T6</th>";
                    $output_html .= "                <th class='sat'>T7</th>";
                    $output_html .= "                <th class='sun'>CN</th>";
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
                        $class = ($j % 2 !== 0) ? 'alt-row' : '';
                        
                        $row_id = "{$week_id}_{$c['branch']}"; // Row Id
                        $output_html .= "            <tr id='{$row_id}'>";
                        if ($j == 0) {
                            // $output_html .= " <td rowspan='{$count}'><label class='price bold'>{$d['week']}</label><br /><br />({$d['description']})</td>";
                        }
                        $output_html .= "                <td class='{$class}'><span class='blue-text'>{$c['name']}</span></td>";
                        
                        for($index = 0; $index < count ( $day_of_week ); $index ++) {
                            $output_html .= "                <td col_name='{$day_of_week [$index]}' class='{$class}'>";
                            for($z = 0; $z < count ( $c [$day_of_week [$index]] ); $z ++) {
                                $s = $c [$day_of_week [$index]] [$z];
                                if (! empty ( $s )) {
                                    $ctrl_id = create_uid ();
                                    $html_text = sprintf ( $detail_format, $ctrl_id, $ctrl_id, $week_id, $s ['worker'], $c ['branch'], $day_of_week [$index], $d ['days'] ['start_date'], $s ['hoten'] );
                                    
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
                    
                    // Ouput
                    $output_html = str_replace ( "<", "@", $output_html );
                    $output_html = str_replace ( ">", "#", $output_html );
                    $result ['detail'] = $output_html;
                }
            }
        }
        
        /* Load store list */
        if (isset ( $_POST ['load_store_list'] )) {
            // Get input data
            $from_store = $_POST ['from_store'];
            $start_date = $_POST ['start_date'];
            $worker = $_POST ['worker'];
            $day_of_week = $_POST ['day_of_week'];
            
            // Get the week days of '$start_date'
            $arr = getweek_first_last_date ( $start_date );
            $monday = $arr ['start_date_of_week'];
            $sunday = $arr ['end_date_of_week'];
            $wkdays = array (
                    'mon' => $monday,
                    'tue' => strtotime ( "+1 day", $monday ),
                    'wed' => strtotime ( "+2 days", $monday ),
                    'thu' => strtotime ( "+3 days", $monday ),
                    'fri' => strtotime ( "+4 days", $monday ),
                    'sat' => strtotime ( "+5 days", $monday ),
                    'sun' => $sunday 
            );
            
            // Get data from database
            $approved = BIT_TRUE;
            $day_format = 'Y-m-d';
            $monday = date ( $day_format, $monday );
            $sunday = date ( $day_format, $sunday );
            $db = new database ();
            $sql = "SELECT makho, tenkho
                    FROM khohang
                    WHERE makho IN (
                                    SELECT DISTINCT branch 
                                    FROM working_calendar 
                                    WHERE (working_date BETWEEN '{$monday}' AND '{$sunday}') AND (approved = '{$approved}') AND (branch <> '{$from_store}')
                                   )";
            $db->setQuery ( $sql );
            $arr = $db->loadAllRow ();
            $db->disconnect ();
            
            // Description information
            $showroom = new khohang ();
            $nv = new nhanvien ();
            $info = array (
                    'employee' => $nv->get_name ( $worker ),
                    'date' => date ( 'd/m/Y', $wkdays [$day_of_week] ),
                    'branch_name' => $showroom->ten_kho ( $from_store ) 
            );
            
            // Get store items
            $items = array ();
            if (is_array ( $arr )) {
                foreach ( $arr as $z ) {
                    $items [] = array (
                            'value' => $z ['makho'],
                            'text' => $z ['tenkho'] 
                    );
                }
            }
            
            // Output result
            $result ['result'] = 1;
            $result ['message'] = "";
            $result ['items'] = $items;
            $result ['info'] = $info;
        }
        
        /* Change store in the calendar */
        if (isset ( $_POST ['change_store'] )) {
            // Get input data
            $week_id = $_POST ['week_id'];
            $worker = $_POST ['worker'];
            $from_store = $_POST ['from_store'];
            $day_of_week = $_POST ['day_of_week'];
            $start_date = $_POST ['start_date'];
            $to_store = $_POST ['to_store'];
            
            // Get the week days of '$start_date'
            $arr = getweek_first_last_date ( $start_date );
            $monday = $arr ['start_date_of_week'];
            $sunday = $arr ['end_date_of_week'];
            $day_format = 'Y-m-d';
            $wkdays = array (
                    'mon' => date ( $day_format, $monday ),
                    'tue' => date ( $day_format, strtotime ( "+1 day", $monday ) ),
                    'wed' => date ( $day_format, strtotime ( "+2 days", $monday ) ),
                    'thu' => date ( $day_format, strtotime ( "+3 days", $monday ) ),
                    'fri' => date ( $day_format, strtotime ( "+4 days", $monday ) ),
                    'sat' => date ( $day_format, strtotime ( "+5 days", $monday ) ),
                    'sun' => date ( $day_format, $sunday ) 
            );
            
            // Get detail of the calendar item
            $new_date = $wkdays [$day_of_week];
            $cal_item = $calendar_model->detail_by_worker_date ( $worker, $new_date );
            if ($cal_item != NULL) {
                if ($cal_item->on_leave == BIT_FALSE) {
                    if ($cal_item->branch == $from_store) {
                        // Update information of calendar item
                        $cal_item->branch = $to_store;
                        
                        if ($calendar_model->update ( $cal_item )) {
                            
                            $src = ""; // Employee list of from store
                            $dst = ""; // Employee list of to store
                                       
                            // DB model
                            $nv = new nhanvien ();
                            
                            // Get employee list of from store
                            $arr = $calendar_model->detail_list_by_date ( $new_date, $from_store );
                            if (is_array ( $arr )) {
                                foreach ( $arr as $entity ) {
                                    $w_name = $nv->thong_tin_nhan_vien ( $entity->worker );
                                    $w_name = $w_name ['hoten'];
                                    
                                    // Add to employee list of from store
                                    $ctrl_id = create_uid ();
                                    $src .= sprintf ( $detail_format, $ctrl_id, $ctrl_id, $week_id, $entity->worker, $entity->branch, $day_of_week, $start_date, $w_name );
                                }
                            }
                            
                            // Get employee list of to store
                            $arr = $calendar_model->detail_list_by_date ( $new_date, $to_store );
                            if (is_array ( $arr )) {
                                foreach ( $arr as $entity ) {
                                    $w_name = $nv->thong_tin_nhan_vien ( $entity->worker );
                                    $w_name = $w_name ['hoten'];
                                    
                                    // Add to employee list of to store
                                    $ctrl_id = create_uid ();
                                    $dst .= sprintf ( $detail_format, $ctrl_id, $ctrl_id, $week_id, $entity->worker, $entity->branch, $day_of_week, $start_date, $w_name );
                                }
                            }
                            
                            // Output result
                            $result ['result'] = 1;
                            $result ['week_id'] = $week_id;
                            $result ['from_store'] = $from_store;
                            $result ['to_store'] = $to_store;
                            $result ['source'] = $src;
                            $result ['destination'] = $dst;
                            $result ['day_of_week'] = $day_of_week;
                        } else {
                            $result ['message'] = sprintf ( "Thực hiện cập nhật thông tin lịch làm việc thất bại: %s", $calendar_model->getMessage () );
                        }
                    } else {
                        $showroom = new khohang ();
                        $result ['message'] = sprintf ( "Không có nhân viên '{$worker}' trong lịch làm việc ngày '{$new_date}' của chi nhánh '%s'", $showroom->ten_kho ( $from_store ) );
                    }
                } else {
                    $result ['message'] = "Ngày '{$new_date}' là ngày nghỉ của nhân viên '{$worker}'";
                }
            } else {
                $result ['message'] = "Không tìm thấy chi tiết làm việc ngày '{$new_date}' của nhân viên '{$worker}'";
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