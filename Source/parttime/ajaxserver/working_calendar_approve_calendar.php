<?php
require_once '../part/common_start_page.php';
require_once '../models/working_calendar.php';
require_once '../models/working_leave_days.php';
require_once '../models/working_plan.php';
require_once '../models/working_plan_leave_days.php';

$result = array (
        'result' => 0, // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => '', // Detail message
        'progress' => '', // Progress status (success/total)
        'refresh' => 0, // Refresh data flag
        'flag' => - 1  // Remain items count: -1: Do nothing; 0: Update form controls
);

if (verify_access_right ( current_account (), F_WORKING_CALENDAR_APPROVE_CALENDAR )) {
    // debug($_POST);
    // Get input data
    $plan_uid = $_POST ['plan_uid'];
    $branch = $_POST ['branch'];
    $from_date = $_POST ['from_date'];
    $to_date = $_POST ['to_date'];
    $days_list = $_POST ['leave_days'];
    $note_list = $_POST ['leave_days_note'];
    $worker = $_POST ['worker'];
    // User actions
    $is_update = (isset ( $_POST ['update'] )) ? TRUE : FALSE;
    $is_approve = (isset ( $_POST ['approve'] )) ? TRUE : FALSE;
    $is_reject = (isset ( $_POST ['reject'] )) ? TRUE : FALSE;
    // Check if valid actions
    $valid_actions = $is_update || $is_approve || $is_reject;
    
    // Filter leave days list
    $leave_days = array ();
    $leave_note = array ();
    for($i = 0; $i < count ( $days_list ); $i ++) {
        if (! empty ( $days_list [$i] )) {
            $leave_days [] = $days_list [$i];
            $leave_note [] = $note_list [$i];
        }
    }
    
    if ($valid_actions) {
        // DB model
        // $calendar_model = new working_calendar ();
        // $leave_model = new working_leave_days ();
        $plan_model = new working_plan ();
        $plan_leave_days_model = new working_plan_leave_days ();
        
        try {
            
            // Get detail of plan
            $plan = $plan_model->detail ( $plan_uid );
            if ($plan != NULL) {
                
                // Update action
                if ($is_update) {
                    
                    // Set new information for that detail plan
                    $plan->branch = $branch;
                    $plan->from_date = $from_date;
                    $plan->to_date = $to_date;
                    $plan->workers = implode ( ARRAY_DELIMITER, $worker );
                    $plan->leave_days_count = count ( $leave_days );
                    
                    // Update plan to database
                    // 1: Clear all leave days information
                    if ($plan_leave_days_model->delete_by_plan ( $plan->plan_uid )) {
                        
                        // 2: Update plan information
                        if ($plan_model->update ( $plan )) {
                            
                            // Process leave days list
                            $success = 0;
                            for($i = 0; $i < count ( $leave_days ); $i ++) {
                                $l = new working_plan_leave_days_entity ();
                                $l->plan_uid = $plan->plan_uid;
                                $l->leave_date = $leave_days [$i];
                                $l->note = $leave_note [$i];
                                
                                if ($plan_leave_days_model->insert ( $l )) {
                                    $success ++;
                                } else {
                                    $detail_message .= sprintf ( $detail_format, $l->leave_date, $plan_leave_day_model->getMessage () );
                                }
                            }
                            
                            // Check if that all of leave days are inserted
                            if ($success == count ( $leave_days )) {
                                $result ['result'] = 1;
                                $result ['message'] = 'Update thông tin lịch làm việc thành công!';
                            } else {
                                $result ['message'] = 'Update thông tin lịch làm việc thất bại: ';
                                
                                // Delete above plan item
                                if ($plan_model->delete ( $item->plan_uid )) {
                                    $result ['detail'] = $detail_message;
                                } else {
                                    $result ['message'] .= $plan_model->getMessage ();
                                }
                            }
                        } else {
                            $result ['message'] = $plan_model->getMessage ();
                        }
                    } else {
                        $result ['message'] = $plan_leave_days_model->getMessage ();
                    }
                }                

                // Reject action
                elseif ($is_reject) {
                    if ($plan_model->delete ( $plan->plan_uid )) {
                        $result ['result'] = 1;
                        $result ['message'] = 'Reject thông tin lịch làm việc thành công!';
                    } else {
                        $result ['message'] = $plan_model->getMessage ();
                    }
                }                

                // Approve action
                elseif ($is_approve) {
                    // Get leave days
                    $leave_days = $plan_leave_days_model->detail_list ( $plan->plan_uid );
                    
                    if (is_array ( $leave_days ) && count ( $leave_days ) == $plan->leave_days_count) {
                        
                        // Update 'approved' status
                        $plan->approved = BIT_TRUE;
                        if ($plan_model->update ( $plan )) {
                            
                            // Get plan information
                            $branch = $plan->branch;
                            $from_date = $plan->from_date;
                            $to_date = $plan->to_date;
                            $worker = $plan->workers;
                            $created_by = $plan->created_by;
                            
                            // Convert date string to date
                            $from_date = strtotime ( $from_date );
                            $to_date = strtotime ( $to_date );
                            
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
                            $model = new working_calendar ();
                            
                            // Process working days list
                            for($wday = $from_date; $wday <= $to_date;) {
                                $working_date = date ( 'Y-m-d', $wday );
                                
                                $item = new working_calendar_entity ();
                                $item->branch = $branch; // Chi nhanh
                                $item->created_by = $created_by; // Nguoi tao
                                $item->working_date = $working_date; // Ngay lam viec
                                                                     // Xac dinh ngay nghi phep
                                foreach ( $leave_days as $obj ) {
                                    if ($obj->leave_date == $working_date) {
                                        $item->on_leave = BIT_TRUE;
                                        $item->note = $obj->note;
                                        
                                        break;
                                    }
                                }
                                $item->approved = BIT_TRUE; // Approved
                                                            
                                // Worker list
                                for($j = 0; $j < count ( $worker ); $j ++) {
                                    $entity = $item->copy ();
                                    $entity->worker = $worker [$j]; // Nhan vien lam viec
                                    
                                    if ($model->insert ( $entity )) {
                                        $success ++;
                                    } else {
                                        $detail_message .= sprintf ( $detail_format, $entity->working_date, $entity->worker, $model->getMessage () );
                                    }
                                    
                                    $total ++;
                                }
                                
                                $wday = strtotime ( "+1 day", $wday );
                            }
                            
                            /* Output results */
                            // Success status
                            $result ['result'] = 1;
                            // Message
                            $result ['message'] = sprintf ( 'Thực hiện approve thành công %d/%d hạng mục.', $success, $total );
                            if ($total > 0 && $success == $total) {
                                $result ['detail'] = '';
                            } else {
                                if ($detail_message != '') { // Detail message
                                    $result ['detail'] = 'Các hạng mục bị lỗi bao gồm:' . $detail_message;
                                }
                            }
                        } else {
                            $result ['message'] = $plan_model->getMessage ();
                        }
                    } else {
                        $result ['message'] = "Cannot get leaves days data of plan Id = '{$plan_uid}'";
                    }
                }
            } else {
                $result ['message'] = "Không tìm thấy thông tin lịch làm việc Id = '{$plan_uid}'";
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