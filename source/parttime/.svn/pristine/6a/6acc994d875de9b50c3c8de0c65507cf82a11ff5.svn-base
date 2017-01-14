<?php
require_once '../part/common_start_page.php';
require_once '../models/working_calendar.php';
require_once '../models/working_leave_days.php';

$result = array (
        'result' => 0, // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => '', // Detail message
        'progress' => '', // Progress status (success/total)
        'reload' => 0  // Reload flag
);

if (verify_access_right ( current_account (), F_WORKING_CALENDAR_LEAVE_DAYS )) {
    // debug($_POST);
    // Get input data
    $old_days_list = $_POST ['leave_days_old'];
    $new_days_list = $_POST ['leave_days_new'];
    $note_list = $_POST ['leave_days_note'];
    if (isset ( $_POST ['worker'] )) {
        $worker = $_POST ['worker'];
    } else {
        $worker = current_account ();
    }
    $created_by = current_account ();
    
    // Filter leave days list
    $old_leave_days = array ();
    $new_leave_days = array ();
    $leave_note = array ();
    for($i = 0; $i < count ( $old_days_list ); $i ++) {
        if (! empty ( $new_days_list [$i] )) {
            $old_leave_days [] = $old_days_list [$i];
            $new_leave_days [] = $new_days_list [$i];
            $leave_note [] = $note_list [$i];
        }
    }
    
    // Initial values
    $result ['result'] = 1; // Success status
    $total = 0; // Total items count
    $success = 0; // Success items count
    $detail_message = '';
    // Detail format
    $detail_format = "<br />• Ngày nghỉ cũ <span class='orange bold'>%s</span> - Ngày nghỉ mới <span class='orange bold'>%s</span>: %s";
    $detail_format = str_replace ( "<", "@", $detail_format );
    $detail_format = str_replace ( ">", "#", $detail_format );
    
    // DB model
    $calendar_model = new working_calendar ();
    $leave_model = new working_leave_days ();
    
    try {
        if (count ( $new_leave_days ) == 0) {
            $result ['result'] = 0;
            $result ['message'] = 'Chọn các ngày nghỉ muốn dời sang!!';
        } else {
            // Process working days list
            for($i = 0; $i < count ( $new_leave_days ); $i ++) {
                
                $item = new working_leave_days_entity ();
                $item->worker = $worker; // Nhan vien nghi phep
                $item->created_by = $created_by; // Nguoi tao
                $item->old_date = $old_leave_days [$i]; // Ngay nghi cu
                $item->new_date = $new_leave_days [$i]; // Ngay nghi moi
                $item->note = $leave_note [$i]; // Ghi chu
                                                
                // Lay thong tin chi tiet ngay lam viec (moi)
                $cal = $calendar_model->detail_by_worker_date ( $item->worker, $item->new_date );
                
                if ($cal != NULL && $cal->approved == BIT_TRUE) {
                    if ($cal->on_leave == BIT_TRUE) {
                        $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, "Đã có ngày nghỉ này ({$item->new_date}) ở trong lịch làm việc" );
                    } else {
                        
                        // Kiem tra da dang ky ngay nghi nay hay chua
                        if (! $leave_model->contains ( $item->worker, $item->new_date, $item->old_date )) {
                            
                            // Lay thong tin chi tiet ngay lam viec (cu)
                            $cal_old = $calendar_model->detail_by_worker_date ( $item->worker, $item->old_date );
                            if ($cal_old != NULL && $cal_old->approved == BIT_TRUE) {
                                // Nguoi co quyen approve request doi ngay nghi -> cho phep approve
                                if (verify_access_right ( current_account (), F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_CHANGE )) {
                                    $item->approved = BIT_TRUE;
                                }
                                
                                // Save vao database
                                if ($leave_model->insert ( $item )) {
                                    // Cap nhat lich lam viec cho nhung item da duoc approve
                                    if ($item->approved == BIT_TRUE) {
                                        // Backup note cua cac ngay nghi
                                        $old_date_note = $cal_old->note;
                                        $new_date_note = $cal->note;
                                        
                                        $cal->on_leave = BIT_TRUE;
                                        $cal->note = $item->note; // Thay doi ghi chu ngay nghi (moi)
                                        
                                        $cal_old->on_leave = BIT_FALSE;
                                        $cal_old->note = "Đổi ngày nghỉ cho ngày {$item->new_date}"; // Thay doi ghi chu ngay nghi (cu)
                                        
                                        if ($calendar_model->update ( $cal )) {
                                            if ($calendar_model->update ( $cal_old )) {
                                                $success ++;
                                            } else {
                                                // Roll back viec cap nhat ngay nghi
                                                $cal->on_leave = BIT_FALSE;
                                                $cal->note = $new_date_note;
                                                
                                                $cal_old->on_leave = BIT_TRUE;
                                                $cal_old->note = $old_date_note;
                                                
                                                $message = $calendar_model->getMessage ();
                                                if ($calendar_model->update ( $cal_old ) && $calendar_model->update ( $cal ) && $leave_model->delete ( $item->uid )) {
                                                    $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, $message );
                                                } else {
                                                    $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, "Cannot roll back the action" );
                                                }
                                            }
                                        } else {
                                            // Roll back viec cap nhat ngay nghi
                                            $cal->on_leave = BIT_FALSE;
                                            $cal->note = $new_date_note;
                                            
                                            $cal_old->on_leave = BIT_TRUE;
                                            $cal_old->note = old_date_note;
                                            
                                            $message = $calendar_model->getMessage ();
                                            if ($calendar_model->update ( $cal_old ) && $calendar_model->update ( $cal ) && $leave_model->delete ( $item->uid )) {
                                                $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, $message );
                                            } else {
                                                $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, "Cannot roll back the action" );
                                            }
                                        }
                                    } else {
                                        $success ++;
                                    }
                                } else {
                                    $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, $leave_model->getMessage () );
                                }
                            } else {
                                $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, "Không tìm thấy ngày nghỉ tương ứng {$item->old_date}" );
                            }
                        } else {
                            $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, 'Đã đăng ký dời ngày nghỉ này rồi' );
                        }
                    }
                } else {
                    $detail_message .= sprintf ( $detail_format, $item->old_date, $item->new_date, "Không tìm thấy ngày làm việc tương ứng {$item->new_date}" );
                }
                
                $total ++;
            }
            
            // Output message
            if ($detail_message != '') { // Detail message
                $result ['detail'] = 'Các hạng mục bị lỗi bao gồm:' . $detail_message;
            }
            $result ['progress'] = sprintf ( 'Đã đăng ký thành công %d/%d ngày nghỉ.', $success, $total ); // Progress status
                                                                                                               // if ($total > 0 && ($total - $success == 0)) {
                                                                                                               // $result ['reload'] = 5 * 1000;
                                                                                                               // $result ['progress'] .= ' Page sẽ tự động reload sau 5 giây.';
                                                                                                               // }
        }
    } catch ( Exception $e ) {
        $result ['message'] = $e->getMessage ();
    }
}

echo json_encode ( $result );
// ob_end_flush();
require_once '../part/common_end_page.php';
?>