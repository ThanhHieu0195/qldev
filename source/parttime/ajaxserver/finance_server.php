<?php
require_once '../part/common_start_page.php';
require_once '../models/finance_token.php';
require_once '../models/finance_token_detail.php';
require_once '../models/finance_reference.php';
require_once '../models/finance_product.php';
require_once '../models/finance_category.php';
require_once '../models/finance_item.php';
require_once '../models/motataikhoan.php';

$result = array (
        'result' => "error", // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => array (), // Detail message
        'token_id' => '',
        'perform_date' => current_timestamp ( 'Y-m-d' ),
        'references' => array (),
        'products' => array (),
        'categories' => array (),
        'token_items' => array (),
        'performers' => array () 
);

if (verify_access_right ( current_account (), G_FINANCE, KEY_GROUP )) {
    // Token type name
    $type_names = array (
            FINANCE_RECEIPT => 'thu',
            FINANCE_PAYMENT => 'chi'    
    );
    
    try {
        // Create new
        if (isset ( $_POST ['create_new'] )) {
            if (verify_access_right ( current_account (), array (
                    F_FINANCE_CREATE_RECEIPT,
                    F_FINANCE_CREATE_PAYMENT 
            ) )) {
                // Get token type
                $token_type = $_POST ['token_type'];
                
                $access = FALSE;
                
                // Add new receipt token
                if ($token_type == FINANCE_RECEIPT && verify_access_right ( current_account (), F_FINANCE_CREATE_RECEIPT )) {
                    $access = TRUE;
                }
                
                // Add new payment token
                if ($token_type == FINANCE_PAYMENT && verify_access_right ( current_account (), F_FINANCE_CREATE_PAYMENT )) {
                    $access = TRUE;
                }
                
                $token_items = array (); // Token's items
                
                if ($access) {
                    // DB models
                    $token_model = new finance_token ();
                    
                    // Get last modified token
                    $token_id = $token_model->get_last_modified_token ( current_account (), $token_type );

                    $detail_tk_model = new detail_tk();
                    $result['detail_tk'] = $detail_tk_model->detail_tk();
                    
                    if ($token_id != NULL) { // The token is existing
                        $result ['result'] = "success";
                        $result ['message'] = "Phiếu {$type_names[$token_type]} '{$token_id}' tồn tại trong hệ thống";
                        
                        // Get the item list of that token
                        $detail_model = new finance_token_detail ();
                        $arr = $detail_model->detail_list_by_token ( $token_id );
                        if (is_array ( $arr ) && count ( $arr ) > 0) {
                            foreach ( $arr as $r ) {
                                $r ['money_amount'] = number_format ( $r ['money_amount'], 0, ",", "." );
                                $r ['perform_date'] = dbtime_2_systime ( $r ['perform_date'], 'd/m/Y' );
                                
                                $token_items [] = $r;
                            }
                        }
                    } else {
                        // Create a new token in database
                        $token = new finance_token_entity ();
                        $token->created_by = current_account ();
                        $token->token_type = $token_type;
                        
                        if ($token_model->insert ( $token )) {
                            $token_id = $token->token_id;
                            
                            $result ['result'] = "success";
                            $result ['message'] = "Tạo thành công phiếu {$type_names[$token_type]} '{$token->token_id}'";
                        } else {
                            $result ['message'] = "Lỗi tạo phiếu {$type_names[$token_type]}: '{$token_model->getMessage()}'";
                        }
                    }
                    
                    // Initial values
                    $references = array ();
                    $products = array ();
                    $categories = array ();
                    $performers = array ();
                    
                    if ($result ['result'] == "success") {
                        
                        // Get the references
                        $model = new finance_reference ();
                        $arr = $model->get_list ( FALSE, $token_type );
                        if (is_array ( $arr ) && count ( $arr ) > 0) {
                            foreach ( $arr as $z ) {
                                $references [] = array (
                                        'id' => $z->reference_id,
                                        'name' => $z->name 
                                );
                            }
                        }
                        
                        // Get the products
                        $model = new finance_product ();
                        $arr = $model->get_list ( FALSE, $token_type );
                        if (is_array ( $arr ) && count ( $arr ) > 0) {
                            foreach ( $arr as $z ) {
                                $products [] = array (
                                        'id' => $z->product_id,
                                        'name' => $z->name 
                                );
                            }
                        }
                        
                        // Get the categories
                        $model = new finance_category ();
                        $arr = $model->get_list ( FALSE, $token_type );
                        if (is_array ( $arr ) && count ( $arr ) > 0) {
                            foreach ( $arr as $z ) {
                                $categories [] = array (
                                        'id' => $z->category_id,
                                        'name' => $z->name 
                                );
                            }
                        }
                        
                        // Get the performers
                        $model = new nhanvien ();
                        $arr = $model->employee_list ();
                        if (is_array ( $arr ) && count ( $arr ) > 0) {
                            foreach ( $arr as $z ) {
                                $performers [] = array (
                                        'id' => $z ['manv'],
                                        'name' => $z ['hoten'] 
                                );
                            }
                        }
                    }
                    
                    // Output result
                    $result ['token_id'] = $token_id; // Token Id
                    $result ['references'] = $references;
                    $result ['products'] = $products;
                    $result ['categories'] = $categories;
                    $result ['token_items'] = $token_items;
                    $result ['performers'] = $performers;
                }
            }
        }
        
        // Load items by category
        if (isset ( $_POST ['load_items_by_category'] )) {
            // Get input data
            $category_id = $_POST ['category_id'];
            
            // DB model
            $item_model = new finance_item ();
            $arr = $item_model->list_by_category ( $category_id );
            $items = array ();
            if (is_array ( $arr ) && count ( $arr ) > 0) {
                foreach ( $arr as $z ) {
                    $items [] = array (
                            'id' => $z->item_id,
                            'name' => $z->name 
                    );
                }
            }
            
            // Output result
            $result ['result'] = "success";
            $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $items ) );
            $result ['items'] = $items;
        }
        
        // Update items of a token
        if (isset ( $_POST ['detail_update'] )) {
            if (verify_access_right ( current_account (), array (
                    F_FINANCE_CREATE_RECEIPT,
                    F_FINANCE_CREATE_PAYMENT 
            ) )) {
                
                // Get input data
                $action = $_POST ['action'];
                $madon = $_POST['madon'];
                $uid = $_POST ['uid'];
                $token_id = $_POST ['detail_token_id'];
                $reference_id = $_POST ['reference_id'];
                $product_id = $_POST ['product_id'];
                $category_id = $_POST ['category_id'];
                $item_id = $_POST ['item_id'];
                $perform_by = $_POST ['perform_by'];
                $money_amount = $_POST ['money_amount'];
                $taikhoan = $_POST['taikhoan'];
                $note = $_POST ['note'];
                $perform_date = $_POST ['perform_date'];
                // DB model

                $token_model = new finance_token ();
                $detail_model = new finance_token_detail ();

                 $check_madon = false;
                if ($madon == "" || $detail_model->check_madon($madon)) {
                    $check_madon = true;
                }
                
                // Get token detai
                $token = $token_model->detail ( $token_id );
                if ($token != NULL && $check_madon) {
                    // Set action value to the result
                    $result ['action'] = $action;
                    
                    // Add new item
                    if ($action == "add") {
                        $item = new finance_token_detail_entity ();
                        $item->token_id = $token_id;
                        $item->reference_id = $reference_id;
                        $item->madon = $madon;
                        $item->product_id = $product_id;
                        $item->item_id = $item_id;
                        $item->perform_by = $perform_by;
                        $item->money_amount = $money_amount;
                        $item->taikhoan = $taikhoan;
                        $item->note = $note;
                        $item->perform_date = $perform_date;
                        
                        if ($detail_model->insert ( $item )) {
                            // Update amount of token
                            $token->amount ++;
                            if ($token_model->update ( $token )) {
                                $result ['result'] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công";
                                $result ['total_money'] = number_format ( $detail_model->total_money_by_token ( $token->token_id ), 0, ",", "." ); // Total money
                                $result ['total_items'] = $detail_model->count_items_by_token ( $token->token_id ); // Total items
                                                                                                                    
                                // Detail of item
                                $token_items = array ();
                                $arr = $detail_model->detail_by_uid ( $item->uid );
                                if (is_array ( $arr ) && count ( $arr ) > 0) {
                                    foreach ( $arr as $r ) {
                                        $r ['money_amount'] = number_format ( $r ['money_amount'], 0, ",", "." );
                                        $r ['perform_date'] = dbtime_2_systime ( $r ['perform_date'], 'd/m/Y' );
                                        
                                        $token_items [] = $r;
                                    }
                                }
                                $result ['token_items'] = $token_items;
                            } else {
                                $result ['message'] = "Lỗi cập nhật thông tin phiếu thu/chi '{$token_id}': '{$token_model->getMessage()}'";
                            }
                        } else {
                            $result ['message'] = "Lỗi thêm chi tiết phiếu thu/chi: '{$detail_model->getMessage()}'";
                        }
                    } else { // Update an item
                             
                        // Get item detail from database
                        $item = $detail_model->detail_object ( $uid );
                        if ($item != NULL) {
                            $item->reference_id = $reference_id;
                            $item->product_id = $product_id;
                            $item->item_id = $item_id;
                            $item->perform_by = $perform_by;
                            $item->money_amount = $money_amount;
                            $item->taikhoan = $taikhoan;
                            $item->note = $note;
                            $item->perform_date = $perform_date;
                            $item->madon = $madon;
                            
                            if ($detail_model->update ( $item )) {
                                $result ['result'] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công";
                                $result ['total_money'] = number_format ( $detail_model->total_money_by_token ( $token->token_id ), 0, ",", "." ); // Total money
                                $result ['total_items'] = $detail_model->count_items_by_token ( $token->token_id ); // Total items
                                                                                                                    
                                // Detail of item
                                $token_items = array ();
                                $arr = $detail_model->detail_by_uid ( $item->uid );
                                if (is_array ( $arr ) && count ( $arr ) > 0) {
                                    foreach ( $arr as $r ) {
                                        $r ['money_amount'] = number_format ( $r ['money_amount'], 0, ",", "." );
                                        $r ['perform_date'] = dbtime_2_systime ( $r ['perform_date'], 'd/m/Y' );
                                        
                                        $token_items [] = $r;
                                    }
                                }
                                $result ['token_items'] = $token_items;
                            } else {
                                $result ['message'] = "Lỗi cập nhật chi tiết phiếu thu/chi: '{$detail_model->getMessage()}'";
                            }
                        } else {
                            $result ['message'] = "Không tìm thấy item '{$uid}' trong table 'finance_token_detail'";
                        }
                    }
                } else {
                    $result ['message'] = "Không tìm thấy chi tiết phiếu thu/chi '{$token_id}'";
                    if (!$check_madon) {
                         $result['message'] = "Mã đơn không hợp lệ!";
                    }
                }
            }
        }
        
        // Get token detail item by uid
        if (isset ( $_POST ['get_token_detail_item'] )) {
            // Get input data
            $uid = $_POST ['uid'];
            
            // DB models
            $detail_model = new finance_token_detail ();
            $item_model = new finance_item ();
            
            // Get token detail item
            $arr = $detail_model->detail_by_uid ( $uid );
            
            if (is_array ( $arr ) && count ( $arr ) > 0) {
                $result ['result'] = "success";
                $result ['message'] = "Tìm thấy item '{$uid}' tồn tại trong table 'finance_token_detail'";
                
                // Add item to the result
                $token_items = array ();
                foreach ( $arr as $r ) {
                    // $r ['money_amount'] = number_format ( $r ['money_amount'], 0, ",", "" );
                    
                    $token_items [] = $r;
                }
                $result ['token_items'] = $token_items;
                
                // Get list of item by category
                $arr = $item_model->list_by_category ( $r ['category_id'] );
                $items = array ();
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    foreach ( $arr as $z ) {
                        $items [] = array (
                                'id' => $z->item_id,
                                'name' => $z->name 
                        );
                    }
                }
                $result ['items'] = $items;
            } else {
                $result ['message'] = "Không tìm thấy item '{$uid}' trong table 'finance_token_detail'";
            }
        }
        
        // Delete token detail item by uid
        if (isset ( $_POST ['delete_token_detail_item'] )) {
            if (verify_access_right ( current_account (), array (
                    F_FINANCE_CREATE_RECEIPT,
                    F_FINANCE_CREATE_PAYMENT 
            ) )) {
                
                // Get input data
                $uid = $_POST ['uid'];
                
                // DB models
                $token_model = new finance_token ();
                $detail_model = new finance_token_detail ();
                
                // Get detail of item
                $item = $detail_model->detail_object ( $uid );
                if ($item != NULL) {
                    // Get token detail
                    $token = $token_model->detail ( $item->token_id );
                    if ($token != NULL) {
                        // Remove the item
                        if ($detail_model->delete ( $uid )) {
                            // Update amount of token
                            $token->amount --;
                            if ($token_model->update ( $token )) {
                                $result ['result'] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công";
                                $result ['total_money'] = number_format ( $detail_model->total_money_by_token ( $token->token_id ), 0, ",", "." ); // Total money
                                $result ['total_items'] = $detail_model->count_items_by_token ( $token->token_id ); // Total items
                                                                                                                    
                                // Enable flag
                                $result ['enable_flag'] = ($token->amount != 0) ? BIT_TRUE : BIT_FALSE;
                            } else {
                                $result ['message'] = "Lỗi cập nhật thông tin phiếu thu/chi '{$token_id}': '{$token_model->getMessage()}'";
                            }
                        } else {
                            $result ['message'] = "Không thể xóa item '{$uid}' trong table 'finance_token_detail': {$detail_model->getMessage()}";
                        }
                    } else {
                        $result ['message'] = "Không tìm thấy thông tin phiếu thu/chi '{$item->token_id}'";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy item '{$uid}' trong table 'finance_token_detail'";
                }
            }
        }
        
        // Report a token
        if (isset ( $_POST ['report_token'] )) {
            if (verify_access_right ( current_account (), array (
                    F_FINANCE_CREATE_RECEIPT,
                    F_FINANCE_CREATE_PAYMENT 
            ) )) {
                
                // Get input data
                $token_id = $_POST ['token_id'];
                
                // DB model
                $token_model = new finance_token ();
                
                // Get token detail
                $token = $token_model->detail ( $token_id );
                if ($token != NULL) {
                    if ($token->is_finished == BIT_FALSE) {
                        if ($token->approved == BIT_FALSE) {
                            // Update finished status
                            $token->is_finished = BIT_TRUE;
                            
                            if ($token_model->update ( $token )) {
                                $result ['result'] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công! Phiếu thu/chi sẽ được gửi tới cho admin thực hiện approve.";
                            } else {
                                $result ['message'] = "Lỗi cập nhật thông tin phiếu thu/chi '{$token_id}': '{$token_model->getMessage()}'";
                            }
                        } else {
                            $result ['message'] = "Phiếu thu/chi '{$token_id}' đã được approve rồi";
                        }
                    } else {
                        $result ['message'] = "Phiếu thu/chi '{$token_id}' đã được báo cáo rồi";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy chi tiết phiếu thu/chi '{$token_id}'";
                }
            }
        }
        
        // Load items of a token
        if (isset ( $_POST ['load_token_items'] )) {
            // Get input data
            $token_id = $_POST ['token_id'];
            
            // DB model
            $token_model = new finance_token ();
            
            // Get token detail
            $token = $token_model->detail ( $token_id );
            if ($token != NULL) {
                $result ['result'] = "success";
                $result ['message'] = "Phiếu thu/chi '{$token_id}' tồn tại trong hệ thống";
                
                // Get the item list of that token
                $detail_model = new finance_token_detail ();
                $arr = $detail_model->detail_list_by_token ( $token_id );
                
                $token_items = array ();
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    foreach ( $arr as $r ) {
                        $r ['money_amount'] = number_format ( $r ['money_amount'], 0, ",", "." );
                        $r ['perform_date'] = dbtime_2_systime ( $r ['perform_date'], 'd/m/Y' );
                        
                        $token_items [] = $r;
                    }
                    $result ['token_items'] = $token_items;
                }
                // Enable flag for action button(s)
                $result ['enable_flag'] = ($token->approved == BIT_FALSE && $token->amount > 0) ? BIT_TRUE : BIT_FALSE;
                
                // Initial values
                $references = array ();
                $products = array ();
                $categories = array ();
                $performers = array ();
                
                if ($result ['result'] == "success") {
                    
                    // Get the references
                    $model = new finance_reference ();
                    $arr = $model->get_list ( FALSE, $token->token_type );
                    if (is_array ( $arr ) && count ( $arr ) > 0) {
                        foreach ( $arr as $z ) {
                            $references [] = array (
                                    'id' => $z->reference_id,
                                    'name' => $z->name 
                            );
                        }
                    }
                    
                    // Get the products
                    $model = new finance_product ();
                    $arr = $model->get_list ( FALSE, $token->token_type );
                    if (is_array ( $arr ) && count ( $arr ) > 0) {
                        foreach ( $arr as $z ) {
                            $products [] = array (
                                    'id' => $z->product_id,
                                    'name' => $z->name 
                            );
                        }
                    }
                    
                    // Get the categories
                    $model = new finance_category ();
                    $arr = $model->get_list ( FALSE, $token->token_type );
                    if (is_array ( $arr ) && count ( $arr ) > 0) {
                        foreach ( $arr as $z ) {
                            $categories [] = array (
                                    'id' => $z->category_id,
                                    'name' => $z->name 
                            );
                        }
                    }
                    
                    // Get the performers
                    $model = new nhanvien ();
                    $arr = $model->employee_list ();
                    if (is_array ( $arr ) && count ( $arr ) > 0) {
                        foreach ( $arr as $z ) {
                            $performers [] = array (
                                    'id' => $z ['manv'],
                                    'name' => $z ['hoten'] 
                            );
                        }
                    }
                }
                
                // Add to output result
                $result ['references'] = $references;
                $result ['products'] = $products;
                $result ['categories'] = $categories;
                $result ['performers'] = $performers;
            } else {
                $result ['message'] = "Không tìm thấy chi tiết phiếu thu/chi '{$token_id}'";
            }
        }
        
        //báo cáo cho admin
        if (isset($_POST['finished_token'])) {
            $token_id = $_POST ['finished_token'];
            $token_model = new finance_token ();
            $flag = $token_model->is_finished($token_id);
            if ($flag == 1) {
                $result ['message_finished'] = "báo cáo thành công"; 
            } else {
                $result ['message_finished'] = "báo cáo thất bại"; 

            }
        }

        // Approve a token
        if (isset ( $_POST ['approve_token'] )) {
            if (verify_access_right ( current_account (), F_FINANCE_APPROVE )) {
                
                // Get input data
                $token_id = $_POST ['token_id'];
                
                // DB model
                $token_model = new finance_token ();
                
                // Get token detail
                $token = $token_model->detail ( $token_id );
                if ($token != NULL) {
                    if ($token->is_finished == BIT_TRUE) {
                        if ($token->approved == BIT_FALSE) {
                            // Update approve status
                            $token->approved = BIT_TRUE;
                            
                            if ($token_model->update ( $token )) {
                                $result ['result'] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công!";
                            } else {
                                $result ['message'] = "Lỗi cập nhật thông tin phiếu thu/chi '{$token_id}': '{$token_model->getMessage()}'";
                            }
                        } else {
                            $result ['message'] = "Phiếu thu/chi '{$token_id}' đã được approve rồi";
                        }
                    } else {
                        $result ['message'] = "Phiếu thu/chi '{$token_id}' chưa được báo cáo";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy chi tiết phiếu thu/chi '{$token_id}'";
                }
            }
        }
        
        // Reject a token
        if (isset ( $_POST ['reject_token'] )) {
            if (verify_access_right ( current_account (), F_FINANCE_APPROVE )) {
                
                // Get input data
                $token_id = $_POST ['token_id'];
                
                // DB model
                $token_model = new finance_token ();
                
                // Get token detail
                $token = $token_model->detail ( $token_id );
                if ($token != NULL) {
                    if ($token->is_finished == BIT_TRUE) {
                        if ($token->approved == BIT_FALSE) {
                            // Delete the token from database
                            if ($token_model->delete ( $token_id )) {
                                $result ['result'] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công!";
                            } else {
                                $result ['message'] = "Lỗi reject phiếu thu/chi '{$token_id}': '{$token_model->getMessage()}'";
                            }
                        } else {
                            $result ['message'] = "Phiếu thu/chi '{$token_id}' đã được approve rồi";
                        }
                    } else {
                        $result ['message'] = "Phiếu thu/chi '{$token_id}' chưa được báo cáo";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy chi tiết phiếu thu/chi '{$token_id}'";
                }
            }
        }
        
        // Statistic
        if (isset ( $_POST ['statistic'] )) {
            if (verify_access_right ( current_account (), F_FINANCE_STATISTIC )) {
                
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                $account = $_POST ['account'];
                
                // Initial value
                $total_receipt = 0;
                $total_payment = 0;
                
                // DB model
                $detail_model = new finance_token_detail ();
                
                // Get the item list of that token
                $token_items = array ();
                
                $arr = $detail_model->statistic ( $from_date, $to_date , $account);
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    foreach ( $arr as $r ) {
                        switch ($r ['token_type']) {
                            case FINANCE_RECEIPT :
                                $total_receipt += $r ['money_amount'];
                                $r ['money_value'] = 0 + $r ['money_amount'];
                                break;
                            case FINANCE_PAYMENT :
                                $total_payment += $r ['money_amount'];
                                $r ['money_value'] = 0 - $r ['money_amount'];
                                break;
                        }
                        
                        $r ['money_amount'] = number_format ( $r ['money_amount'], 0, ",", "." );
                        $r ['perform_date'] = dbtime_2_systime ( $r ['perform_date'], 'd/m/Y' );
                        $r ['token_type'] = finance_token::$financeTokenTypeArr [$r ['token_type']];
                        $token_items [] = $r;
                    }
                }
                
                // Output result
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $token_items ) );
                $result ['token_items'] = $token_items;
                $result ['total_receipt'] = number_format ( $total_receipt, 0, ",", "." );
                $result ['total_payment'] = number_format ( $total_payment, 0, ",", "." );
                $result ['total_difference'] = number_format ( $total_receipt - $total_payment, 0, ",", "." );
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
