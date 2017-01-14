<?php
require_once '../part/common_start_page.php';
require_once '../models/working_calendar.php';
require_once '../models/working_leave_days.php';

$result = array (
        'result' => 0, // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => '', // Detail message
        'progress' => '', // Progress status (success/total)
        'refresh' => 0, // Refresh data flag
        'flag' => -1   // Remain items count
                       //-1: Do nothing
                       //0: Update form controls
);

if (verify_access_right(current_account(), F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD)) {
    // debug($_POST);
    // Get input data
    $leave_days = $_POST ['leave_days'];
    $is_approve = (isset ( $_POST ['approve'] )) ? TRUE : FALSE;
    $is_reject = (isset ( $_POST ['reject'] )) ? TRUE : FALSE;
    
    if ($is_approve || $is_reject) {
        
        // Initial values
        $result ['result'] = 1; // Success status
        $total = 0; // Total items count
        $success = 0; // Success items count
        $detail_message = '';
        // Detail format
        $detail_format = "<br />• Ngày <span class='orange bold'>%s</span> Nhân viên <span class='blue-text bold'>%s</span>: %s";
        $detail_format = str_replace ( "<", "@", $detail_format );
        $detail_format = str_replace ( ">", "#", $detail_format );
        
        // DB model
        $calendar_model = new working_calendar ();
        $leave_model = new working_leave_days ();
        
        try {
            if (count ( $leave_days ) == 0) {
                $result ['result'] = 0;
                $result ['message'] = 'Chọn các ngày nghỉ bạn muốn approve/reject!';
            } else {
                // Approve
                if ($is_approve) {
                    // Process working days list
                    for($i = 0; $i < count ( $leave_days ); $i ++) {
                        
                        // Lay thong tin cua ngay nghi
                        $item = $leave_model->detail ( $leave_days [$i] );
                        
                        if ($item != NULL) {
                            // Lay thong tin chi tiet ngay lam viec (da approved)
                            $cal = $calendar_model->detail_by_worker_date ( $item->worker, $item->new_date );
                            
                            if ($cal != NULL && $cal->approved == BIT_TRUE) {
                                $item->approved = BIT_TRUE;
                                
                                if ($cal->on_leave == BIT_TRUE) {
                                    // Update 'approved' status cua ngay nghi
                                    if ($leave_model->update ( $item )) {
                                        $detail_message .= sprintf ( $detail_format, $item->new_date, $item->worker, 'Đã có ngày nghỉ này ở trong lịch làm việc' );
                                    } else {
                                        $detail_message .= sprintf ( $detail_format, $item->new_date, $item->worker, $leave_model->getMessage () );
                                    }
                                } else {
                                    // Thay doi thong tin cua ngay lam viec -> ngay nghi
                                    $cal->on_leave = BIT_TRUE;
                                    $cal->note = $item->note;
                                    
                                    // Update 'approved' status cua ngay nghi
                                    if ($leave_model->update ( $item )) {
                                        // Update lich lam viec
                                        if ($calendar_model->update ( $cal )) {
                                            $success ++;
                                        } else {
                                            // Revert trang thai chua approve
                                            $item->approved = BIT_FALSE;
                                            if ($leave_model->update ( $item )) {
                                                $detail_message .= sprintf ( $detail_format, $item->new_date, $item->worker, $calendar_model->getMessage () );
                                            } else {
                                                $detail_message .= sprintf ( $detail_format, $item->new_date, $item->worker, $leave_model->getMessage () );
                                            }
                                        }
                                    } else {
                                        $detail_message .= sprintf ( $detail_format, $item->new_date, $item->worker, $leave_model->getMessage () );
                                    }
                                }
                            } else {
                                $detail_message .= sprintf ( $detail_format, $item->new_date, $item->worker, 'Không tìm thấy ngày làm việc tương ứng' );
                            }
                        } else {
                            $detail_message .= "@br /#• Cannot get detail of '{$leave_days [$i]}' from table 'working_leave_days'";
                        }
                        
                        $total ++;
                    }
                    
                    // Output message
                    if ($detail_message != '') { // Detail message
                        $result ['detail'] = 'Các hạng mục bị lỗi bao gồm:' . $detail_message;
                    }
                    $result ['progress'] = sprintf ( 'Đã approve thành công %d/%d ngày nghỉ.', $success, $total ); // Progress status
                    if ($success > 0) {
                        $result ['refresh'] = 1;
                    }
                }                

                // Reject
                elseif ($is_reject) {
                    // Process working days list
                    for($i = 0; $i < count ( $leave_days ); $i ++) {
                        
                        // Lay thong tin cua ngay nghi
                        $item = $leave_model->detail ( $leave_days [$i] );
                        
                        if ($item != NULL) {
                            // Delete item in database
                            if ($leave_model->delete ( $item->uid )) {
                                $success ++;
                            } else {
                                $detail_message .= sprintf ( $detail_format, $item->new_date, $item->worker, $leave_model->getMessage () );
                            }
                        } else {
                            $detail_message .= "@br /#• Cannot get detail of '{$leave_days [$i]}' from table 'working_leave_days'";
                        }
                        
                        $total ++;
                    }
                    
                    // Output message
                    if ($detail_message != '') { // Detail message
                        $result ['detail'] = 'Các hạng mục bị lỗi bao gồm:' . $detail_message;
                    }
                    $result ['progress'] = sprintf ( 'Đã reject thành công %d/%d ngày nghỉ.', $success, $total ); // Progress status
                    if ($success > 0) {
                        $result ['refresh'] = 1;
                    }
                }
                
                // Remain items count
                $result ['flag'] = $leave_model->unapprove_count()->add;
            }
        } catch ( Exception $e ) {
            $result ['message'] = $e->getMessage ();
        }
    }
}

echo json_encode ( $result );
// ob_end_flush();
require_once '../part/common_end_page.php';
?>