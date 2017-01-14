<?php
require_once '../part/common_start_page.php';
require_once '../models/working_calendar.php';

$result = array (
        'result' => 0, // Error status
                       // 0: Error occurred
                       // 1: There is no data
                       // 2: Success
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => ''  // Detail message
);

if (verify_access_right ( current_account (), array (
        F_WORKING_CALENDAR_CALENDAR,
        F_WORKING_CALENDAR_CALENDAR_BY_TIME 
) )) {
    
    // DB model
    $calendar_model = new working_calendar ();
    
    try {
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
                $count = count ( $d ['calendar'] );
                
                $output_html .= "<div class='scroll'>";
                // $output_html .= "<hr />";
                $output_html .= "<div>&nbsp;<img src='../resources/images/icons/calendar_16.png' alt='calendar'> Tuần <label class='price bold'>{$d['week']}</label>({$d['description']})</div>";
                $output_html .= "    <table class='bordered' id='example_{$i}'>";
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
                    
                    $output_html .= "            <tr>";
                    if ($j == 0) {
                        // $output_html .= " <td rowspan='{$count}'><label class='price bold'>{$d['week']}</label><br /><br />({$d['description']})</td>";
                    }
                    $output_html .= "                <td class='{$class}'><span class='blue-text'>{$c['name']}</span></td>";
                    
                    for($index = 0; $index < count ( $day_of_week ); $index ++) {
                        $output_html .= "                <td class='{$class}'>";
                        for($z = 0; $z < count ( $c [$day_of_week [$index]] ); $z ++) {
                            $s = $c [$day_of_week [$index]] [$z];
                            $output_html .= "                    • {$s ['hoten']}<br />";
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
    } catch ( Exception $e ) {
        $result ['message'] = $e->getMessage ();
    }
}

echo json_encode ( $result );
// echo $result ['detail'];
// ob_end_flush();
require_once '../part/common_end_page.php';
?>