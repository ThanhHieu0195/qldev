<?php
require_once '../part/common_start_page.php';
require_once '../models/donhang.php';
require_once '../models/trahang.php';

$result = array (
        'result' => "error", // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => array (), // Detail message
        'output_items' => array (), 
        'total_receipt' => 0
);

if (verify_access_right ( current_account (), G_ORDERS, KEY_GROUP )) {
    try {
        // Statistic
        if (isset ( $_POST ['statistic'] )) {
            if (verify_access_right ( current_account (), F_ORDERS_CASHED_LIST )) {
                
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                $cashier = $_POST ['cashier'];
                
                // DB model
                $db_model = new donhang ();
                
                // Get data from database
                $total_receipt = 0;
                $output_items = array ();
                $arr = $db_model->cashed_list ( $from_date, $to_date, $cashier );
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    // foreach ( $arr as $r ) {
                    // $r ['tongtien'] = number_2_string ( $r ['tongtien'], '.' );
                    // $r ['tiencoc'] = number_2_string ( $r ['tiencoc'], '.' );
                    // $r ['tienconlai'] = number_2_string ( $r ['tienconlai'], '.' );
                    // $r ['sotiendathu'] = number_2_string ( $r ['sotiendathu'], '.' );
                    
                    // $output_items [] = $r;
                    // }
                    $output_items = $arr;
                    foreach ($arr as $row)
                    {
                        $total_receipt += $row['cashed_money'];
                    }
                }
                
                // Output result
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $output_items ) );
                $result ['output_items'] = $output_items;
                $result ['total_receipt'] = number_2_string($total_receipt);
            }
        }

        if (isset($_POST['returndeliveredstatistic'])) {
             $from_date = $_POST ['from_date'];
             $to_date = $_POST ['to_date'];
             $cashier = $_POST ['cashier'];

             $db_model = new trahang();
             $arr = $db_model->motadoanhsotralai($from_date, $to_date, $cashier);
             if (is_array($arr) && count($arr) > 0) {
                $result['result'] = "success";
                $result['message'] = sprintf("Found '%d' in item(s)", count($arr)); 
                $result['output_items'] = $arr;
             }

        }
        
        //order_delivered statistic
        if (isset ( $_POST ['orderdeliveredstatistic'] )) {
            if ((verify_access_right ( current_account (), F_ORDERS_CASHED_LIST )) || (verify_access_right ( current_account (), F_ORDERS_DETAIL_LIST))) {
                
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                $cashier = $_POST ['cashier'];
                
                // DB model
                $db_model = new donhang ();
                
                // Get data from database
                $total_receipt = 0;
                $output_items = array ();
                $arr = $db_model->order_delivered_list ( $from_date, $to_date, $cashier );
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    // foreach ( $arr as $r ) {
                    // $r ['tongtien'] = number_2_string ( $r ['tongtien'], '.' );
                    // $r ['tiencoc'] = number_2_string ( $r ['tiencoc'], '.' );
                    // $r ['tienconlai'] = number_2_string ( $r ['tienconlai'], '.' );
                    // $r ['sotiendathu'] = number_2_string ( $r ['sotiendathu'], '.' );
                    
                    // $output_items [] = $r;
                    // }
                    $output_items = $arr;
                    foreach ($arr as $row)
                    {
                        $total_receipt += $row['ds'];
                    }
                }
                
                // Output result
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $output_items ) );
                $result ['output_items'] = $output_items;
                $result ['total_receipt'] = number_2_string($total_receipt);
            }
        }
        // Do nothing
        //
		//order statistic
        if (isset ( $_POST ['orderstatistic'] )) {
            if ((verify_access_right ( current_account (), F_ORDERS_CASHED_LIST )) || (verify_access_right ( current_account (), F_ORDERS_DETAIL_LIST))) {
                
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                $cashier = $_POST ['cashier'];
                
                // DB model
                $db_model = new donhang ();
                
                // Get data from database
                $total_receipt = 0;
                $output_items = array ();
                $arr = $db_model->order_list ( $from_date, $to_date, $cashier );
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    // foreach ( $arr as $r ) {
                    // $r ['tongtien'] = number_2_string ( $r ['tongtien'], '.' );
                    // $r ['tiencoc'] = number_2_string ( $r ['tiencoc'], '.' );
                    // $r ['tienconlai'] = number_2_string ( $r ['tienconlai'], '.' );
                    // $r ['sotiendathu'] = number_2_string ( $r ['sotiendathu'], '.' );
                    
                    // $output_items [] = $r;
                    // }
                    $output_items = $arr;
                    foreach ($arr as $row)
                    {
                        $total_receipt += $row['ds'];
                    }
                }
                
                // Output result
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $output_items ) );
                $result ['output_items'] = $output_items;
                $result ['total_receipt'] = number_2_string($total_receipt);
            }
        }
		  //sales_delivered
        if (isset ( $_POST ['sales_delivered'] )) {
            if ((verify_access_right ( current_account (), F_ORDERS_CASHED_LIST )) || (verify_access_right ( current_account (), F_ORDERS_DETAIL_LIST))) {
                
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                $cashier = $_POST ['cashier'];
                $type = $_POST['type'];


                // DB model
                $db_model = new donhang ();

                // Lấy thông kê tra hang
                
                // Get data from database
                $total_receipt = 0;
                $output_items = array ();
                $arr = $db_model->sales_list_delivered ( $from_date, $to_date, $cashier, $type);
                // print_r($arr);

                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    // foreach ( $arr as $r ) {
                    // $r ['tongtien'] = number_2_string ( $r ['tongtien'], '.' );
                    // $r ['tiencoc'] = number_2_string ( $r ['tiencoc'], '.' );
                    // $r ['tienconlai'] = number_2_string ( $r ['tienconlai'], '.' );
                    // $r ['sotiendathu'] = number_2_string ( $r ['sotiendathu'], '.' );
                    
                    // $output_items [] = $r;
                    // }
                    $output_items = $arr;
                    foreach ($arr as $row)
                    {
                        $total_receipt += $row['ds'];
                    }
                }

                $db_model2  = new trahang();
                $doanhsotrahang = $db_model2->thongke($from_date, $to_date, $type);
                // Output result
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $output_items ) );
                $result ['output_items'] = $output_items;
                $result['doanhsotrahang'] = $doanhsotrahang;
                $result ['total_receipt'] = number_2_string($total_receipt);
            }
        }
				  //sales
        if (isset ( $_POST ['sales'] )) {
            if ((verify_access_right ( current_account (), F_ORDERS_CASHED_LIST )) || (verify_access_right ( current_account (), F_ORDERS_DETAIL_LIST))) {
                
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                $cashier = $_POST ['cashier'];
                
                // DB model
                $db_model = new donhang ();
                
                // Get data from database
                $total_receipt = 0;
                $output_items = array ();
                $arr = $db_model->sales_list ( $from_date, $to_date, $cashier );
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    // foreach ( $arr as $r ) {
                    // $r ['tongtien'] = number_2_string ( $r ['tongtien'], '.' );
                    // $r ['tiencoc'] = number_2_string ( $r ['tiencoc'], '.' );
                    // $r ['tienconlai'] = number_2_string ( $r ['tienconlai'], '.' );
                    // $r ['sotiendathu'] = number_2_string ( $r ['sotiendathu'], '.' );
                    
                    // $output_items [] = $r;
                    // }
                    $output_items = $arr;
                    foreach ($arr as $row)
                    {
                        $total_receipt += $row['ds'];
                    }
                }
                
                // Output result
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $output_items ) );
                $result ['output_items'] = $output_items;
                $result ['total_receipt'] = number_2_string($total_receipt);
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
