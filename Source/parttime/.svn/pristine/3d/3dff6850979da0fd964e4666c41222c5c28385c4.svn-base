<?php
require_once '../part/common_start_page.php';
require_once '../models/working_calendar.php';
require_once '../models/working_leave_days.php';

$result = array (
        'result' => 0, // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => '', // Detail message
        'progress' => ''  // Progress status (success/total)
);

if (verify_access_right ( current_account (), F_WORKING_CALENDAR_LEAVE_DAYS )) {
    // debug($_POST);
    // Get input data
    $start_days = $_POST ['leave_days'];
    $end_days = $_POST ['leave_days_end'];
    $note_list = $_POST ['leave_days_note'];
    $worker = current_account ();
    $created_by = current_account ();
    
    // Filter leave days list
    $leave_days = array (); // Items format: ('day' => X, 'note' => Y)
    $added = array (); // Added values
    for($i = 0; $i < count ( $start_days ); $i ++) {
        $from = $start_days [$i];
        
        if (empty ( $from )) {
            // Do nothing
        } else {
            $to = $end_days [$i];
            
            // Single day
            if (empty ( $to )) {
                if (! in_array ( $from, $added )) {
                    // Insert to list
                    $leave_days [] = array (
                            'day' => $from,
                            'note' => $note_list [$i] 
                    );
                    // Flag that had added that value
                    $added [] = $from;
                }
            } else { // Multi days
                     
                // Convert to Unix time
                $from = strtotime ( $from );
                $to = strtotime ( $to );
                
                // Put each day in that range to list
                for($d = $from; $d <= $to;) {
                    // Date string
                    $tmp = date ( 'Y-m-d', $d );
                    // Insert to list
                    if (! in_array ( $d, $added )) {
                        $leave_days [] = array (
                                'day' => $tmp,
                                'note' => $note_list [$i] 
                        );
                        // Flag that had added that value
                        $added [] = $tmp;
                    }
                    
                    $d = strtotime ( "+1 day", $d );
                }
            }
        }
    }
    
    // Initial values
    $result ['result'] = 1; // Success status
    $total = 0; // Total items count
    $success = 0; // Success items count
    $detail_message = '';
    // Detail format
    $detail_format = "<br />• Ngày <span class='orange bold'>%s</span>: %s";
    $detail_format = str_replace ( "<", "@", $detail_format );
    $detail_format = str_replace ( ">", "#", $detail_format );
    
    // DB model
    $calendar_model = new working_calendar ();
    $leave_model = new working_leave_days ();
    
    try {
        if (count ( $leave_days ) == 0) {
            $result ['result'] = 0;
            $result ['message'] = 'Vui lòng nhập các ngày nghỉ bạn muốn đăng ký!';
        } else {
            // Process working days list
            for($i = 0; $i < count ( $leave_days ); $i ++) {
                
                $item = new working_leave_days_entity ();
                $item->worker = $worker; // Nhan vien nghi phep
                $item->created_by = $created_by; // Nguoi tao
                $item->new_date = $leave_days [$i] ['day']; // Ngay nghi phep
                $item->note = $leave_days [$i] ['note']; // Ghi chu
                                                         
                // Lay thong tin chi tiet ngay lam viec
                $cal = $calendar_model->detail_by_worker_date ( $item->worker, $item->new_date );
                
                if ($cal != NULL && $cal->approved == BIT_TRUE) {
                    if ($cal->on_leave == BIT_TRUE) {
                        $detail_message .= sprintf ( $detail_format, $item->new_date, 'Đã có ngày nghỉ này ở trong lịch làm việc' );
                    } else {
                        // Kiem tra da dang ky ngay nghi nay hay chua
                        if (! $leave_model->contains ( $item->worker, $item->new_date )) {
                            // Nguoi co quyen approve request nghi them -> cho phep approve
                            if (verify_access_right ( current_account (), F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD )) {
                                $item->approved = BIT_TRUE;
                            }
                            
                            // Save vao database
                            if ($leave_model->insert ( $item )) {
                                // Cap nhat lich lam viec cho nhung item da duoc approve
                                if ($item->approved == BIT_TRUE) {
                                    
                                    $cal->on_leave = BIT_TRUE;
                                    $cal->note = $item->note; // Thay doi ghi chu ngay nghi
                                    
                                    if ($calendar_model->update ( $cal )) {
                                        $success ++;
                                    } else {
                                        if ($leave_model->delete ( $item->uid )) {
                                            $detail_message .= sprintf ( $detail_format, $item->new_date, $calendar_model->getMessage () );
                                        } else {
                                            $detail_message .= sprintf ( $detail_format, $item->new_date, $leave_model->getMessage () );
                                        }
                                    }
                                } else {
                                    $success ++;
                                }
                            } else {
                                $detail_message .= sprintf ( $detail_format, $item->new_date, $leave_model->getMessage () );
                            }
                        } else {
                            $detail_message .= sprintf ( $detail_format, $item->new_date, 'Đã đăng ký ngày nghỉ này rồi' );
                        }
                    }
                } else {
                    $detail_message .= sprintf ( $detail_format, $item->new_date, 'Không tìm thấy ngày làm việc tương ứng' );
                }
                
                $total ++;
            }
            
            // Output message
            if ($detail_message != '') { // Detail message
                $result ['detail'] = 'Các hạng mục bị lỗi bao gồm:' . $detail_message;
            }
            $result ['progress'] = sprintf ( 'Đã đăng ký thành công %d/%d ngày nghỉ.', $success, $total ); // Progress status
        }
    } catch ( Exception $e ) {
        $result ['message'] = $e->getMessage ();
    }
}

echo json_encode ( $result );
// ob_end_flush();
require_once '../part/common_end_page.php';
?>