<?php
require_once '../part/common_start_page.php';
require_once '../models/khach.php';
require_once '../models/nhomkhach.php';
require_once '../models/guest_events.php';
require_once '../models/guest_responsibility.php';
require_once '../models/guest_development_history.php';
require_once '../models/guest_favourite.php';

$result = array (
        'result' => "error", // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => array (), // Detail message
        'data' => '', // History data (if any)
        'reload' => 0  // Reload flag
);

if (verify_access_right ( current_account (), G_GUEST_DEVELOPMENT, KEY_GROUP )) {
    try {
        // Add new
        if (isset ( $_POST ['add_new'] )) {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_ADD_NEW )) {
                // Get input data
                $hoten = $_POST ['hoten'];
                $diachi = $_POST ['diachi'];
                $dienthoai = $_POST ['dienthoai'];
                $didong = $_POST ['didong'];
                $email = $_POST ['email'];
                $days = $_POST ['day'];
                $notes = $_POST ['note'];
                $is_events = $_POST ['is_event'];
                
                // Create events list
                $events = array ();
                for($i = 0; $i < count ( $days ); $i ++) {
                    if (! empty ( $days [$i] )) {
                        $events [] = array (
                                'day' => $days [$i],
                                'note' => $notes [$i],
                                'enable' => ($is_events [$i] == 1) ? BIT_TRUE : BIT_FALSE 
                        );
                    }
                }
                
                // DB models
                $khach_model = new khach ();
                $nhomkhach_model = new nhomkhach ();
                $events_model = new guest_events ();
                $responsibility_model = new guest_responsibility ();
                
                // Add new guest to database
                $guest = new guest_entity ();
                $guest->hoten = $hoten;
                $guest->manhom = $nhomkhach_model->get_id_by_name ( 'Tiếp thị trực tiếp' );
                $guest->diachi = $diachi;
                $guest->dienthoai1 = $dienthoai;
                $guest->dienthoai2 = $didong;
                $guest->email = $email;
                
                if ($khach_model->insert ( $guest )) {
                    // Add new guest responsibility item
                    $res = new guest_responsibility_entity ();
                    $res->employee_id = current_account ();
                    $res->guest_id = $guest->makhach;
                    
                    if ($responsibility_model->insert ( $res )) {
                        $detail = array ();
                        
                        // Add guest's events
                        if (count ( $events ) > 0) {
                            foreach ( $events as $z ) {
                                $item = new guest_events_entity ();
                                $item->guest_id = $guest->makhach;
                                $item->event_date = $z ['day'];
                                $item->note = $z ['note'];
                                $item->enable = $z ['enable'];
                                $item->is_event = BIT_TRUE;
                                
                                // Insert to database
                                if ($events_model->insert ( $item )) {
                                    // Do nothing
                                } else {
                                    $detail [] = array (
                                            'day' => $item->event_date,
                                            'error' => $events_model->getMessage () 
                                    );
                                }
                            }
                        }
                        
                        if (count ( $detail ) == 0) {
                            $result ["result"] = "success";
                            $result ['message'] = "Thực hiện thao tác thành công!";
                        } else {
                            $result ["result"] = "warning";
                            $result ['message'] = "Có một số lỗi xảy ra khi thêm các ngày cần ghi nhớ của khách hàng như sau:";
                        }
                        $result ['detail'] = $detail;
                    } else {
                        $result ['message'] = "Lỗi phân công theo dõi khách hàng: '{$responsibility_model->getMessage ()}'";
                    }
                } else {
                    $result ['message'] = "Lỗi thêm khách hàng: '{$khach_model->getMessage ()}'";
                }
            }
        }
        
        // Add new from db
        if (isset ( $_POST ['add_from_db'] )) {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_ADD_FROM_DB )) {
                // Get input data
                $guest_id = $_POST ['guest_id'];
                $email = $_POST ['email'];
                $days = $_POST ['day'];
                $notes = $_POST ['note'];
                $is_events = $_POST ['is_event'];
                
                // Create events list
                $events = array ();
                for($i = 0; $i < count ( $days ); $i ++) {
                    if (! empty ( $days [$i] )) {
                        $events [] = array (
                                'day' => $days [$i],
                                'note' => $notes [$i],
                                'enable' => ($is_events [$i] == 1) ? BIT_TRUE : BIT_FALSE 
                        );
                    }
                }
                
                // DB models
                $khach_model = new khach ();
                $nhomkhach_model = new nhomkhach ();
                $events_model = new guest_events ();
                $responsibility_model = new guest_responsibility ();
                
                // Get guest information from database
                $guest = $khach_model->detail_by_id ( $guest_id );
                if ($guest != NULL) {
                    // Update guest information
                    $guest->development = GUEST_DEVELOPMENT_ONGOING;
                    $guest->email = $email;
                    
                    if ($khach_model->update ( $guest )) {
                        // Add new guest responsibility item
                        $res = new guest_responsibility_entity ();
                        $res->employee_id = current_account ();
                        $res->guest_id = $guest->makhach;
                        
                        if ($responsibility_model->insert ( $res )) {
                            $detail = array ();
                            
                            // Add guest's events
                            if (count ( $events ) > 0) {
                                foreach ( $events as $z ) {
                                    $item = new guest_events_entity ();
                                    $item->guest_id = $guest->makhach;
                                    $item->event_date = $z ['day'];
                                    $item->note = $z ['note'];
                                    $item->enable = $z ['enable'];
                                    $item->is_event = BIT_TRUE;
                                    
                                    // Insert to database
                                    if ($events_model->insert ( $item )) {
                                        // Do nothing
                                    } else {
                                        $detail [] = array (
                                                'day' => $item->event_date,
                                                'error' => $events_model->getMessage () 
                                        );
                                    }
                                }
                            }
                            
                            if (count ( $detail ) == 0) {
                                $result ["result"] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công!";
                            } else {
                                $result ["result"] = "warning";
                                $result ['message'] = "Có một số lỗi xảy ra khi thêm các ngày cần ghi nhớ của khách hàng như sau:";
                            }
                            $result ['detail'] = $detail;
                        } else {
                            $result ['message'] = "Lỗi phân công theo dõi khách hàng: '{$responsibility_model->getMessage ()}'";
                        }
                    } else {
                        $result ['message'] = "Lỗi cập nhật khách hàng: '{$khach_model->getMessage ()}'";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy thông tin của khách hàng '{$guest_id}'";
                }
            }
        }
        
        // Update guest's information
        if (isset ( $_POST ['edit'] )) {
            // Get input data
            $guest_id = $_POST ['guest_id'];
            $hoten = $_POST ['hoten'];
            $diachi = $_POST ['diachi'];
            $dienthoai = $_POST ['dienthoai'];
            $didong = $_POST ['didong'];
            $email = $_POST ['email'];
            $days = $_POST ['day'];
            $notes = $_POST ['note'];
            $is_events = $_POST ['is_event'];
            
            // Create events list
            $events = array ();
            for($i = 0; $i < count ( $days ); $i ++) {
                if (! empty ( $days [$i] )) {
                    $events [] = array (
                            'day' => $days [$i],
                            'note' => $notes [$i],
                            'enable' => ($is_events [$i] == 1) ? BIT_TRUE : BIT_FALSE 
                    );
                }
            }
            
            // DB models
            $khach_model = new khach ();
            $nhomkhach_model = new nhomkhach ();
            $events_model = new guest_events ();
            $responsibility_model = new guest_responsibility ();
            
            if ($responsibility_model->check_responsibility ( current_account (), $guest_id )) {
                // Get guest information from database
                $guest = $khach_model->detail_by_id ( $guest_id );
                if ($guest != NULL) {
                    // Update guest information
                    $guest->hoten = $hoten;
                    $guest->diachi = $diachi;
                    $guest->dienthoai1 = $dienthoai;
                    $guest->dienthoai2 = $didong;
                    $guest->email = $email;
                    
                    if ($khach_model->update ( $guest )) {
                        // Delete old event(s)
                        if ($events_model->delete_by_guest ( $guest_id )) {
                            $detail = array ();
                            
                            // Add guest's events
                            if (count ( $events ) > 0) {
                                foreach ( $events as $z ) {
                                    $item = new guest_events_entity ();
                                    $item->guest_id = $guest->makhach;
                                    $item->event_date = $z ['day'];
                                    $item->note = $z ['note'];
                                    $item->enable = $z ['enable'];
                                    $item->is_event = BIT_TRUE;
                                    
                                    // Insert to database
                                    if ($events_model->insert ( $item )) {
                                        // Do nothing
                                    } else {
                                        $detail [] = array (
                                                'day' => $item->event_date,
                                                'error' => $events_model->getMessage () 
                                        );
                                    }
                                }
                            }
                            
                            if (count ( $detail ) == 0) {
                                $result ["result"] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công!";
                            } else {
                                $result ["result"] = "warning";
                                $result ['message'] = "Có một số lỗi xảy ra khi thêm các ngày cần ghi nhớ của khách hàng như sau:";
                            }
                            $result ['detail'] = $detail;
                        } else {
                            $result ['message'] = "Cannot delete old event(s): '{$events_model->getMessage ()}'";
                        }
                    } else {
                        $result ['message'] = "Lỗi cập nhật khách hàng: '{$khach_model->getMessage ()}'";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy thông tin của khách hàng '{$guest_id}'";
                }
            } else {
                $result ['message'] = "Bạn không có quyền cập nhật thông tin khách hàng '{$guest_id}'";
            }
        }
        
        // Add guests to favourites
        if (isset ( $_POST ['list_all_action'] ) && $_POST ['list_all_action'] == "add_favourites") {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_LIST_FAVOURITE )) {
                // Get input data
                $guest = $_POST ['guest'];
                
                // DB models
                $favourite_model = new guest_favourite ();
                
                if (count ( $guest ) > 0) {
                    // Initial values
                    $employee_id = current_account ();
                    $total = count ( $guest );
                    $success = 0;
                    $detail = array ();
                    
                    foreach ( $guest as $g ) {
                        if ($favourite_model->check_favourite ( $employee_id, $g )) {
                            $detail [] = array (
                                    'guest_id' => $g,
                                    'error' => 'Đã có khách hàng này trong danh sách quan tâm' 
                            );
                        } else {
                            $item = new guest_favourite_entity ();
                            $item->guest_id = $g;
                            $item->employee_id = $employee_id;
                            // Insert into database
                            if ($favourite_model->insert ( $item )) {
                                $success ++;
                            } else {
                                $detail [] = array (
                                        'guest_id' => $g,
                                        'error' => $favourite_model->getMessage () 
                                );
                            }
                        }
                    }
                    
                    // Output result
                    $result ['message'] = "Thêm thành công {$success}/{$total} khách hàng vào danh sách quan tâm. ";
                    if (count ( $detail ) == 0) {
                        $result ['result'] = "success";
                    } else {
                        $result ['message'] .= "Có một số lỗi như sau: ";
                        $result ['result'] = "warning";
                    }
                    $result ['detail'] = $detail;
                }
            }
        }
        
        // Re-assign resposibility
        if (isset ( $_POST ['list_all_action'] ) && $_POST ['list_all_action'] == "re_assign") {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_LIST_ALL )) {
                // Get input data
                $guest = $_POST ['guest'];
                $employee_id = $_POST ['assign_to'];
                
                // DB models
                $resposibility_model = new guest_responsibility ();
                
                if (count ( $guest ) > 0) {
                    // Initial values
                    $total = count ( $guest );
                    $success = 0;
                    $detail = array ();
                    
                    foreach ( $guest as $g ) {
                        // Update to database
                        if ($resposibility_model->re_assign ( $g, $employee_id )) {
                            $success ++;
                        } else {
                            $detail [] = array (
                                    'guest_id' => $g,
                                    'error' => $resposibility_model->getMessage () 
                            );
                        }
                    }
                    
                    // Output result
                    $result ['message'] = "Phân công theo dõi thành công {$success}/{$total} khách hàng. ";
                    if (count ( $detail ) == 0) {
                        $result ['result'] = "success";
                    } else {
                        $result ['message'] .= "Có một số lỗi như sau: ";
                        $result ['result'] = "warning";
                    }
                    $result ['detail'] = $detail;
                }
            }
        }
        
        // Remove favourite guest(s)
        if (isset ( $_POST ['remove_favourite'] )) {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_LIST_FAVOURITE )) {
                // Get input data
                $guest_id = $_POST ['guest_id'];
                $employee_id = current_account ();
                
                // DB models
                $favourite_model = new guest_favourite ();
                
                if ($favourite_model->check_favourite ( $employee_id, $guest_id )) {
                    if ($favourite_model->remove ( $employee_id, $guest_id )) {
                        $result ['result'] = "success";
                        $result ['message'] = "Thực hiện thao tác thành công";
                    } else {
                        $result ['message'] = $favourite_model->getMessage ();
                    }
                } else {
                    $result ['message'] = "Không tìm thấy thông tin trong danh sách quan tâm";
                }
            }
        }
        
        // Statistic updated
        if (isset ( $_POST ['statistic_updated'] )) {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_STATISTIC_UPDATED )) {
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                
                // DB models
                $history_model = new guest_development_history ();
                
                // Get data from database
                $arr = $history_model->statistic_updated ( $from_date, $to_date );
                $items = array ();
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    foreach ( $arr as $row ) {
                        $items [] = array (
                                'guest_name' => $row ['hoten'],
                                'address' => $row ['diachi'],
                                'telephone' => $row ['dienthoai1'],
                                'mobile' => $row ['dienthoai2'],
                                'email' => $row ['email'],
                                'assign_to' => $row ['tennv'],
                                'guest_id' => $row ['guest_id'] 
                        );
                    }
                }
                
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Tìm thấy tất cả %d item(s).", count ( $items ) );
                $result ['items'] = $items;
            }
        }
        
        // Statistic contacted
        if (isset ( $_POST ['statistic_contacted'] )) {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED )) {
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                
                // DB models
                $history_model = new guest_development_history ();
                $events_model = new guest_events ();
                
                // Get data from database
                $arr = $history_model->statistic_contacted ( $from_date, $to_date );
                $items = array ();
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    $i = 0;
                    foreach ( $arr as $key => $row ) {
                        $items [] = array (
                                'no' => ++ $i,
                                'employee_name' => $row ['employee_name'],
                                'total_amount' => $events_model->count_need_contacting($key, $from_date, $to_date),
                                'amount' => count ( $row ['guests'] ),
                                'payment_amount' => $row ['payment_amount'],
                                'payment_money' => number_format ( $row ['payment_money'], 0, ",", "." ),
                                'employee_id' => $key,
                                'from_date' => $from_date,
                                'to_date' => $to_date 
                        );
                    }
                }
                
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Tìm thấy tất cả %d item(s).", count ( $items ) );
                $result ['items'] = $items;
            }
        }
        
        // Statistic contacted detail
        if (isset ( $_POST ['statistic_contacted_detail'] )) {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED )) {
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                $employee_id = $_POST ['employee_id'];
                
                // DB models
                $history_model = new guest_development_history ();
                
                // Get data from database
                $arr = $history_model->statistic_updated ( $from_date, $to_date, $employee_id );
                $items = array ();
                if (is_array ( $arr ) && count ( $arr ) > 0) {
                    foreach ( $arr as $row ) {
                        $items [] = array (
                                'guest_name' => $row ['hoten'],
                                'address' => $row ['diachi'],
                                'telephone' => $row ['dienthoai1'],
                                'mobile' => $row ['dienthoai2'],
                                'email' => $row ['email'],
                                'assign_to' => $row ['tennv'],
                                'guest_id' => $row ['guest_id'] 
                        );
                    }
                }
                
                $result ['result'] = "success";
                $result ['message'] = sprintf ( "Tìm thấy tất cả %d item(s).", count ( $items ) );
                $result ['items'] = $items;
            }
        }
        
        // Show orders list in 'Statistic contacted' function
        if (isset ( $_POST ['show_orders'] )) {
            if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED )) {
                // Get input data
                $from_date = $_POST ['from_date'];
                $to_date = $_POST ['to_date'];
                $employee_id = $_POST ['employee_id'];
                
                // DB models
                $history_model = new guest_development_history ();
                
                // Get data from database
                $arr = $history_model->statistic_contacted ( $from_date, $to_date, $employee_id );
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
        
        // Load history items
        if (isset ( $_POST ['load_history'] )) {
            // Get input data
            $guest_id = $_POST ['guest_id'];
            
            // DB models
            $history_model = new guest_development_history ();
            $nv = new nhanvien ();
            
            // Get data from database
            $arr = $history_model->list_by_guest ( $guest_id );
            $items = array ();
            if (is_array ( $arr ) && count ( $arr ) > 0) {
                foreach ( $arr as $z ) {
                    $title = sprintf ( "%s - %s", $nv->get_name ( $z->employee_id ), dbtime_2_systime ( $z->created_date, 'H:i:s d/m/Y' ) );
                    
                    $items [] = array (
                            'title' => $title,
                            'content' => $z->note 
                    );
                }
            }
            
            $result ['result'] = "success";
            $result ['message'] = sprintf ( "Tìm thấy tất cả %d item(s).", count ( $items ) );
            $result ['items'] = $items;
        }
        
        // Update contact content
        if (isset ( $_POST ['contact'] )) {
            // Initial values
            $contact_content = "";
            $next_schedule = "";
            $note = "";
            
            // Get input data
            $guest_id = $_POST ['guest_id'];
            if (isset ( $_POST ['contact_content'] )) {
                // $contact_content = trim ( $_POST ['contact_content'] );
                $contact_content = my_nl2br ( trim ( $_POST ['contact_content'] ) );
            }
            if (isset ( $_POST ['next_schedule'] )) {
                $next_schedule = $_POST ['next_schedule'];
            }
            if (isset ( $_POST ['note'] )) {
                $note = $_POST ['note'];
            }
            if (empty ( $note )) {
                $note = "Hẹn lịch liên hệ lại"; // Default note
            }
            $is_cancelled = isset ( $_POST ['cancelled'] );
            
            // debug("guest_id = {$guest_id}");
            // debug("contact_content = {$contact_content}");
            // debug("next_schedule = {$next_schedule}");
            // debug("note = {$note}");
            // debug("is_cancelled = {$is_cancelled}");
            
            // Validate data
            if (empty ( $contact_content ) && empty ( $next_schedule ) && ! $is_cancelled) {
                $result ['message'] = "Dữ liệu không hợp lệ, vui lòng kiểm tra lại!";
            } else {
                // DB models
                $khach_model = new khach ();
                $history_model = new guest_development_history ();
                $events_model = new guest_events ();
                $responsibility_model = new guest_responsibility ();
                
                if ($responsibility_model->check_responsibility ( current_account (), $guest_id )) {
                    // Get guest information from database
                    $guest = $khach_model->detail_by_id ( $guest_id );
                    if ($guest != NULL) {
                        // Flag value
                        $continue = TRUE;
                        
                        // Add contact history
                        if (! empty ( $contact_content )) {
                            $h = new guest_development_history_entity ();
                            $h->guest_id = $guest_id;
                            $h->employee_id = current_account ();
                            $h->note = $contact_content;
                            
                            $continue = $history_model->insert ( $h );
                        }
                        
                        if ($continue) {
                            if (! empty ( $contact_content )) {
                                // Add an item to history list in client
                                $result ['data'] = array (
                                        'title' => sprintf ( "%s - %s", current_account ( TENNV ), dbtime_2_systime ( $h->created_date, 'H:i:s d/m/Y' ) ),
                                        'content' => $h->note 
                                );
                            }
                            
                            // Flag value
                            $continue = TRUE;
                            
                            if (! empty ( $next_schedule )) {
                                // Insert next schedule of contacting
                                $event = new guest_events_entity ();
                                $event->guest_id = $guest_id;
                                $event->event_date = $next_schedule;
                                $event->note = $note;
                                $event->is_event = BIT_FALSE;
                                $event->enable = BIT_TRUE;
                                
                                $continue = $events_model->insert ( $event );
                            }
                            
                            if ($continue) {
                                if ($is_cancelled) {
                                    // Update 'development' status
                                    if ($khach_model->set_development_status ( $guest_id, GUEST_DEVELOPMENT_CANCELLED )) {
                                        $result ['result'] = "success";
                                        $result ['message'] = "Thực hiện thao tác thành công";
                                        $result ['reload'] = 1; // Reload data of the page
                                    } else {
                                        $result ['message'] = "Lỗi cập nhật thông tin khách hàng: '{$khach_model->getMessage()}'";
                                    }
                                } else {
                                    $result ['result'] = "success";
                                    $result ['message'] = "Thực hiện thao tác thành công";
                                }
                            } else {
                                $result ['message'] = "Lỗi cập nhật ngày liên hệ tiếp theo: '{$events_model->getMessage()}'";
                            }
                        } else {
                            $result ['message'] = "Lỗi cập nhật nội dung liên hệ: '{$history_model->getMessage()}'";
                        }
                    } else {
                        $result ['message'] = "Không tìm thấy thông tin của khách hàng '{$guest_id}'";
                    }
                } else {
                    $result ['message'] = "Bạn không có quyền cập nhật thông tin khách hàng '{$guest_id}'";
                }
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