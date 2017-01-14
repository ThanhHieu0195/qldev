<?php
require_once '../part/common_start_page.php';
require_once '../models/orders_question.php';
require_once '../models/orders_question_option.php';
require_once '../models/orders_question_result.php';
require_once '../models/donhang.php';

$result = array (
        'result' => "error", // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => array (), // Detail message
        'items' => array ()
);

if (verify_access_right ( current_account (), G_ORDERS, KEY_GROUP )) {
    
    try {
        // Statistic
        if (isset ( $_POST ['question_statistic'] )) {
            if (verify_access_right ( current_account (), F_ORDERS_CHECKED_LIST )) {
                
                // Get input data
                $question_id = $_POST ['question_id'];
                
                // DB model
                $option_model = new orders_question_option ();
                $result_model = new orders_question_result();

                // Get results list
                $arr = $result_model->results_list($question_id);
                $results = array();
                $checked = array();
                if ($arr != NULL) {
                    foreach ($arr as $r) {
                        if (in_array($r->option, $checked)) {
                            $results[$r->option] += 1;
                        } else {
                            $checked[] = $r->option;
                            $results[$r->option] = 1;
                        }
                    }
                }
                
                // Get the item list of that token
                $items = array ();
                $total = 0;
                $options = $option_model->option_list($question_id);
                if ($options != NULL) {
                    $i = 0;
                    foreach ($options as $o) {
                        $amount = (isset($results[$o->uid]))? $results[$o->uid] : "";
                        $items[] = array(
                            'no' => ++$i, 
                            'uid' => $o->uid, 
                            'option' => $o->content, 
                            'amount' => $amount
                        );
                        if ($amount != "") {
                            $total++;
                        }
                    }
                }
                
                // Output result
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $items ) );
                $result ['items'] = $items;
                $skipped = 0;
                $donhang = new donhang();
                $result ['total'] = array('checked' => $total, 'skipped' => $donhang->skipped_count());
            }
        }

        // Show orders list of an option (of a question)
        if (isset ( $_POST ['show_orders_by_question_option'] )) {
            if (verify_access_right ( current_account (), F_ORDERS_CHECKED_LIST )) {
                // Get input data
                $option_id = $_POST ['option_id'];
                
                // DB models
                $db = new database();
                
                // Get data from database
                $approved = BIT_TRUE;
                $sql = "SELECT d.madon, d.ngaydat, d.ngaygiao, d.thanhtien, d.makhach, k.hoten, d.trangthai
                    FROM donhang d INNER JOIN khach k ON d.makhach = k.makhach
                                   INNER JOIN orders_question_result o ON o.order_id = d.madon
                    WHERE o.option = '{$option_id}'
                          -- AND d.thanhtien > 0
                          -- AND d.approved = '{$approved}'
                    ORDER BY d.ngaygiao";
                $db->setQuery ( $sql );
                $arr = $db->loadAllRow ();
                $db->disconnect ();
                
                $items = array ();
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    $text = array (
                            '0' => 'Chờ giao',
                            '1' => 'Đã giao' 
                    );
                    $css = array (
                            '0' => 'tag belize',
                            '1' => 'tag pomegranate' 
                    );
                    
                    $i = 0;
                    foreach ( $arr as $row ) {
                        $items [] = array (
                                'no' => ++ $i,
                                'order_id' => $row ['madon'],
                                'money' => number_format ( $row ['thanhtien'], 0, ",", "." ),
                                'guest_name' => $row ['hoten'],
                                'created_date' => dbtime_2_systime ( $row ['ngaydat'], 'd/m/Y' ),
                                'delivery_date' => dbtime_2_systime ( $row ['ngaygiao'], 'd/m/Y' ),
                                'status' => array (
                                        'text' => $text [$row ['trangthai']],
                                        'css' => $css [$row ['trangthai']] 
                                ) 
                        );
                    }
                }
                
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Tìm thấy tất cả %d item(s).", count ( $items ) );
                $result ['items'] = $items;
            }
        }

        // Show skipped orders list
        if (isset ( $_POST ['show_skipped_orders'] )) {
            if (verify_access_right ( current_account (), F_ORDERS_CHECKED_LIST )) {
                // Get input data
                
                // DB models
                $db = new database();
                
                // Get data from database
                $approved = BIT_TRUE;
                $sql = "SELECT d.madon, d.ngaydat, d.ngaygiao, d.thanhtien, d.makhach, k.hoten, d.trangthai
                    FROM donhang d INNER JOIN khach k ON d.makhach = k.makhach
                    WHERE d.checked = '2'
                          -- AND d.thanhtien > 0
                          -- AND d.approved = '{$approved}'
                    ORDER BY d.ngaygiao";
               error_log ($sql, 3, '/var/log/phpdebug.log');
                $db->setQuery ( $sql );
                $arr = $db->loadAllRow ();
                $db->disconnect ();
                
                $items = array ();
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    $text = array (
                            '0' => 'Chờ giao',
                            '1' => 'Đã giao' 
                    );
                    $css = array (
                            '0' => 'tag belize',
                            '1' => 'tag pomegranate' 
                    );
                    
                    $i = 0;
                    foreach ( $arr as $row ) {
                        $items [] = array (
                                'no' => ++ $i,
                                'order_id' => $row ['madon'],
                                'money' => number_format ( $row ['thanhtien'], 0, ",", "." ),
                                'guest_name' => $row ['hoten'],
                                'created_date' => dbtime_2_systime ( $row ['ngaydat'], 'd/m/Y' ),
                                'delivery_date' => dbtime_2_systime ( $row ['ngaygiao'], 'd/m/Y' ),
                                'status' => array (
                                        'text' => $text [$row ['trangthai']],
                                        'css' => $css [$row ['trangthai']] 
                                ) 
                        );
                    }
                }
                
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Tìm thấy tất cả %d item(s).", count ( $items ) );
                $result ['items'] = $items;
            }
        }
        
        // Do nothing
        //
    } catch ( Exception $e ) {
        $result ['message'] = $e->getMessage ();
    }
}

echo json_encode ( $result );
// echo $result ['detail'];
// ob_end_flush();
require_once '../part/common_end_page.php';
?>
