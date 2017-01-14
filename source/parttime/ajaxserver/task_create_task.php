<?php
require_once '../part/common_start_page.php';
require_once '../models/task.php';
require_once '../models/task_detail.php';
require_once '../models/mail_helper.php';
require_once '../models/task_template.php';
require_once '../models/task_template_detail.php';

$result = array (
        'result' => 0, // Error status
                       // 0: Error occurred
                       // 1: Success
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => '', // Detail message
        'flag' => 0  // Flag status (1: Update template)
);

if (verify_access_right ( current_account (), G_TASK, KEY_GROUP )) {
    try {
        // Create new task(s)
        if (isset ( $_REQUEST ['submit'] )) {
            if (isset ( $_FILES ['attachment_file'] ) && ! empty ( $_FILES ['attachment_file'] ['name'] )) {
                // Save upload file
                $done = FALSE;
                $file_name = basename ( $_FILES ['attachment_file'] ['name'] );
                $upload = FALSE;
                // Make folder
                $dir_name = date ( "Ymd" );
                $dir = sprintf ( "../%s/%s", UPLOAD_FOLDER, $dir_name );
                if (! file_exists ( $dir ) and ! is_dir ( $dir )) {
                    if (mkdir ( $dir, 0777 )) {
                        $target_filepath = sprintf ( "%s/%s", $dir, $file_name );
                    } else {
                        $target_filepath = sprintf ( "../%s/%s", UPLOAD_FOLDER, $file_name );
                    }
                } else {
                    $target_filepath = sprintf ( "%s/%s", $dir, $file_name );
                }
                // Upload file
                if ($_FILES ['attachment_file'] ['error'] > 0) {
                    $message = 'Chưa chọn file đính kèm';
                } else {
                    if (move_uploaded_file ( $_FILES ['attachment_file'] ['tmp_name'], $target_filepath )) {
                        $upload = TRUE;
                    } else {
                        $upload = FALSE;
                        $message = 'Không thực hiện save file ' . $target_filepath . ' được.';
                    }
                }
            } else { // No attachment file
                $upload = TRUE;
                $target_filepath = "";
            }
            
            if ($upload) {
                $done = TRUE;
                
                // debug($_POST);
                $title = $_POST ['title'];
                $content = $_POST ['content'];
                $assign_to = $_POST ['assign_to'];
                $deadline = $_POST ['deadline'];
                $repeat = $_POST ['repeat'];
                $repeat_times = $_POST ['repeat_times'];
                $repeat_by = $_POST ['repeat_by'];
                $weekly = $_POST ['weekly'];
                $monthly = $_POST ['monthly'];
                $template_id = $_POST ['template_id'];
                
                // Get detail list (if any) and remove empty items
                if (isset ( $_POST ['detail_list'] )) {
                    $arr = $_POST ['detail_list'];
                } else {
                    $arr = array ();
                }
                $detail_list = array ();
                for($i = 0; $i < count ( $arr ); $i ++) {
                    if (! empty ( $arr [$i] )) {
                        $detail_list [] = $arr [$i];
                    }
                }
                $has_detail = (count ( $detail_list ) > 0) ? BIT_TRUE : BIT_FALSE;
                
                // Mail data list
                $mail_data_list = array ();
                $nv = new nhanvien ();
                
                $model = new task ();
                $task_list = array ();
                for($i = 0; $i < count ( $assign_to ); $i ++) {
                    $item = new task_entity ();
                    $item->title = $title;
                    $item->content = $content;
                    $item->has_detail = $has_detail;
                    $item->created_by = current_account ();
                    $item->assign_to = $assign_to [$i];
                    $item->deadline = $deadline;
                    $item->attachment = $target_filepath;
                    $item->template_id = $template_id;
                    
                    if ($model->insert ( $item )) {
                        if ($has_detail == BIT_TRUE) {
                            $task_detail = new task_detail ();
                            for($j = 0; $j < count ( $detail_list ); $j ++) {
                                $d = new task_detail_entity ();
                                $d->no = $j + 1;
                                $d->task_id = $item->task_id;
                                $d->content = $detail_list [$j];
                                $task_detail->insert ( $d );
                            }
                        }
                        
                        // Add to task list
                        $task_list [] = $item;
                        
                        // Add to mail list
                        if (! isset ( $mail_data_list [$item->assign_to] )) {
                            $tmp = $nv->thong_tin_nhan_vien ( $item->assign_to );
                            $mail_data_list [$item->assign_to] = array (
                                    'email' => $tmp ['email'],
                                    'name' => $tmp ['hoten'],
                                    'content' => $item->content,
                                    'deadline' => array () 
                            );
                        }
                        $mail_data_list [$item->assign_to] ['deadline'] [] = $item->deadline;
                    }
                }
                
                // Repeat
                if ($repeat == 1) {
                    // Set starting deadline value
                    $repeat_by = intval ( $repeat_by );
                    switch ($repeat_by) {
                        // Daily
                        case 1 :
                            $deadline = strtotime ( $deadline );
                            break;
                        // Weekly
                        case 2 :
                            $deadline = next_day_by_name ( $deadline, $weekly );
                            break;
                        // Monthly
                        case 3 :
                            $date = get_date_by_day ( intval ( $monthly ), $deadline );
                            break;
                    }
                    
                    for($i = 0; $i < $repeat_times; $i ++) {
                        // Get deadline
                        switch ($repeat_by) {
                            // Daily
                            case 1 :
                                $deadline = strtotime ( "+1 day", $deadline );
                                break;
                            // Weekly
                            case 2 :
                                if ($i > 0) {
                                    $deadline = strtotime ( "+1 week", $deadline );
                                }
                                break;
                            // Monthly
                            case 3 :
                                $deadline = get_x_months_to_the_future ( $date, $i + 1 );
                                break;
                        }
                        
                        for($j = 0; $j < count ( $task_list ); $j ++) {
                            $t = $task_list [$j]->copy ();
                            $t->deadline = date ( 'Y-m-d', $deadline );
                            if ($model->insert ( $t )) {
                                if ($has_detail == BIT_TRUE) {
                                    $task_detail = new task_detail ();
                                    for($z = 0; $z < count ( $detail_list ); $z ++) {
                                        $d = new task_detail_entity ();
                                        $d->no = $z + 1;
                                        $d->task_id = $t->task_id;
                                        $d->content = $detail_list [$z];
                                        $task_detail->insert ( $d );
                                    }
                                }
                                
                                // Add to mail list
                                if (! isset ( $mail_data_list [$t->assign_to] )) {
                                    $tmp = $nv->thong_tin_nhan_vien ( $t->assign_to );
                                    $mail_data_list [$t->assign_to] = array (
                                            'email' => $tmp ['email'],
                                            'name' => $tmp ['hoten'],
                                            'content' => $t->content,
                                            'deadline' => array () 
                                    );
                                }
                                $mail_data_list [$t->assign_to] ['deadline'] [] = $t->deadline;
                            }
                        }
                    }
                }
            } else {
                $done = FALSE;
            }
            
            // Send mail
            $warning = array ();
            if (count ( $mail_data_list ) > 0) {
                // debug ( $mail_data_list );
                $mail = new mail_helper ();
                // Detail format
                // $message_format = "<br />• Nhân viên <span class='orange bold'>%s</span> - email <span class='orange bold'>%s</span>: %s";
                // $message_format = str_replace ( "<", "@", $message_format );
                // $message_format = str_replace ( ">", "#", $message_format );
                
                foreach ( $mail_data_list as $key => $v ) {
                    // Create mail data
                    $c = count ( $v ['deadline'] );
                    $body = "Chào bạn, <b>{$v['name']}</b>!<br />
                    <br>Bạn vừa được phân công {$c} công việc với nội dung: <br>
                    &nbsp; <b>{$v['content']}";
                    for($z = 0; $z < count ( $detail_list ); $z ++) {
                        $body .= sprintf ( "<br> &nbsp;&nbsp;&nbsp;&nbsp;%d. %s", $z + 1, $detail_list [$z] );
                    }
                    $body .= "</b><br><br>Các ngày phải hoàn thành:";
                    for($s = 0; $s < $c; $s ++) {
                        $body .= sprintf ( "<br> &nbsp;&nbsp;• %s", dbtime_2_systime ( $v ['deadline'] [$s], 'd/m/Y' ) );
                    }
                    $body .= "<br><br> Chi tiết xem tại trang Dashboard của hệ thống website bán hàng.
                        <br><br> Thân ái,<br> Admin
                        ";
                    
                    // Send a mail
                    $data = array (
                            'to' => array (
                                    'email' => $v ['email'],
                                    'name' => $v ['name'] 
                            ),
                            'body' => $body 
                    );
                    // debug ( $data );
                    if (! $mail->Send ( $data )) {
                        // debug ( $mail->ErrorInfo );
                        $warning [] = array (
                                'name' => $v ['name'],
                                'email' => $v ['email'],
                                'error' => $mail->ErrorInfo 
                        );
                    }
                }
                // Mail warning message
                // if ($warning != '') {
                // $tmp = "<br><span class='blue-violet'>Tuy nhiên có một số email thông báo công việc cho nhân viên chưa được gửi như sau:</span>";
                // $tmp = str_replace ( "<", "@", $tmp );
                // $tmp = str_replace ( ">", "#", $tmp );
                
                // $warning = $tmp . $warning;
                // }
            }
            
            if ($done) {
                $result ['result'] = 1;
                $result ['message'] = 'Thực hiện tạo công việc thành công!';
                $result ['warning'] = $warning;
            } else {
                $result ['message'] = $message;
                ;
            }
        }
        
        // Get task template content and detail (if any)
        if (isset ( $_REQUEST ['load_template'] )) {
            // Get input data
            $template_id = $_REQUEST ['template_id'];
            // DB model
            $template_model = new task_template ();
            
            // Get template information
            $t = $template_model->detail ( $template_id );
            if ($t != NULL) {
                $result ['result'] = 1;
                $result ['title'] = $t->title;
                $result ['content'] = $t->content;
                $result ['message'] = '';
                $result ['detail'] = '';
                
                // Get detail list (if any)
                if ($t->has_detail == BIT_TRUE) {
                    $detail_model = new task_template_detail ();
                    $arr = $detail_model->detail_list ( $t->template_id );
                    
                    if ($arr != NULL) {
                        $tmp = array ();
                        foreach ( $arr as $z ) {
                            $tmp [] = $z->content;
                        }
                        
                        $result ['detail'] = $tmp;
                    }
                }
            } else {
                $result ['message'] = 'Không thực hiện lấy thông tin của công việc mẫu được';
            }
        }
        
        // Create new task template
        if (isset ( $_REQUEST ['create_template'] )) {
            if (verify_access_right ( current_account (), F_TASK_TEMPLATE_LIST )) {
                // Get input data
                $title = $_POST ['title'];
                $content = $_POST ['content'];
                
                // Get detail list (if any) and remove empty items
                if (isset ( $_POST ['detail_list'] )) {
                    $arr = $_POST ['detail_list'];
                } else {
                    $arr = array ();
                }
                $detail_list = array ();
                for($i = 0; $i < count ( $arr ); $i ++) {
                    $s = trim ( $arr [$i] );
                    if (! empty ( $s )) {
                        $detail_list [] = $s;
                    }
                }
                $has_detail = (count ( $detail_list ) > 0) ? BIT_TRUE : BIT_FALSE;
                
                // DB model
                $template_model = new task_template ();
                
                // Insert template to database
                $item = new task_template_entity ();
                $item->title = $title;
                $item->content = $content;
                $item->has_detail = $has_detail;
                
                if ($template_model->insert ( $item )) {
                    $result ['result'] = 1;
                    $result ['message'] = 'Thêm công việc mẫu thành công';
                    $result ['detail'] = array ();
                    
                    // Insert task template detail list
                    if ($has_detail == BIT_TRUE) {
                        $task_detail = new task_template_detail ();
                        
                        for($j = 0; $j < count ( $detail_list ); $j ++) {
                            $d = new task_template_detail_entity ();
                            $d->no = $j + 1;
                            $d->template_id = $item->template_id;
                            $d->content = $detail_list [$j];
                            
                            if (! $task_detail->insert ( $d )) {
                                $result ['detail'] [] = array (
                                        'content' => $d->content,
                                        'error' => $task_detail->getMessage () 
                                );
                            }
                        }
                    }
                    // Warning message
                    if (count ( $result ['detail'] ) > 0) {
                        $result ['message'] = 'Không thể thực hiện thêm một số công việc nhỏ trong danh sách vào database:';
                    }
                } else {
                    $result ['message'] = $template_model->getMessage ();
                }
            }
        }
        
        // Update contents of task template
        if (isset ( $_REQUEST ['update_template'] )) {
            $result ['flag'] = 1;
            
            if (verify_access_right ( current_account (), F_TASK_TEMPLATE_LIST )) {
                // Get input data
                $title = $_POST ['title'];
                $content = $_POST ['content'];
                $template_id = $_POST ['template_id'];
                
                // Get detail list (if any) and remove empty items
                if (isset ( $_POST ['detail_list'] )) {
                    $arr = $_POST ['detail_list'];
                } else {
                    $arr = array ();
                }
                $detail_list = array ();
                for($i = 0; $i < count ( $arr ); $i ++) {
                    $s = trim ( $arr [$i] );
                    if (! empty ( $s )) {
                        $detail_list [] = $s;
                    }
                }
                $has_detail = (count ( $detail_list ) > 0) ? BIT_TRUE : BIT_FALSE;
                
                // DB model
                $template_model = new task_template ();
                $task_detail = new task_template_detail ();
                
                // Get template information from database
                $item = $template_model->detail ( $template_id );
                
                if ($item != NULL) {
                    // Update template
                    $item->has_detail = $has_detail;
                    $item->title = $title;
                    $item->content = $content;
                    
                    if ($template_model->update ( $item )) {
                        $result ['result'] = 1;
                        $result ['message'] = 'Cập nhật công việc mẫu thành công';
                        $result ['detail'] = array ();
                        
                        // Delete old task template detail list
                        if (! $task_detail->delete_by_template ( $template_id )) {
                            $result ['detail'] [] = array (
                                    'content' => "Cannot delete by template '{$template_id}'",
                                    'error' => $task_detail->getMessage () 
                            );
                        }
                        
                        // Insert new task template detail list
                        if ($has_detail == BIT_TRUE) {
                            $task_detail = new task_template_detail ();
                            
                            for($j = 0; $j < count ( $detail_list ); $j ++) {
                                $d = new task_template_detail_entity ();
                                $d->no = $j + 1;
                                $d->template_id = $item->template_id;
                                $d->content = $detail_list [$j];
                                
                                if (! $task_detail->insert ( $d )) {
                                    $result ['detail'] [] = array (
                                            'content' => "Cannot insert template detail item '{$d->content}'",
                                            'error' => $task_detail->getMessage () 
                                    );
                                }
                            }
                        }
                        
                        /* Update relation task(es) in database */
                        // DB model
                        $task_model = new task ();
                        $task_detail_model = new task_detail ();
                        
                        // 1: Get taskes which using that template
                        $unfinished_list = $task_model->unfinished_list_by_template ( $template_id );
                        
                        $total = 0;
                        $success = 0;
                        // 2: Update content of these taskes
                        if (is_array ( $unfinished_list )) {
                            $total = count ( $unfinished_list );
                            
                            foreach ( $unfinished_list as $task ) {
                                // $task->title = $item->title;
                                $task->content = $item->content;
                                $task->has_detail = $item->has_detail;
                                
                                if ($task_model->update ( $task )) {
                                    
                                    // Delete old task detail list
                                    if (! $task_detail_model->delete_by_task ( $task->task_id )) {
                                        $result ['detail'] [] = array (
                                                'content' => "Cannot delete by task '{$task->$task_id}'",
                                                'error' => $task_detail->getMessage () 
                                        );
                                    }
                                    
                                    // Insert new task detail list
                                    if ($has_detail == BIT_TRUE) {
                                        
                                        for($j = 0; $j < count ( $detail_list ); $j ++) {
                                            $d = new task_detail_entity ();
                                            $d->no = $j + 1;
                                            $d->task_id = $task->task_id;
                                            $d->content = $detail_list [$j];
                                            
                                            if (! $task_detail_model->insert ( $d )) {
                                                $result ['detail'] [] = array (
                                                        'content' => "Cannot insert task ('{$d->task_id}') detail item '{$d->content}'",
                                                        'error' => $task_detail_model->getMessage () 
                                                );
                                            }
                                        }
                                    }
                                    
                                    $success ++;
                                } else {
                                    $result ['detail'] [] = array (
                                            'content' => "Cannot update task '{$task->task_id}'",
                                            'error' => $task_model->getMessage () 
                                    );
                                }
                            }
                        }
                        
                        // Warning message
                        if (count ( $result ['detail'] ) > 0) {
                            $result ['message'] = 'Warning: Có một số lỗi xảy ra khi cập nhật công việc mẫu như bên dưới';
                        } else {
                            $result ['message'] = "Cập nhật công việc mẫu thành công. Đồng thời cập nhật thành công cho {$success}/{$total} công việc (chưa hoàn thành) có sử dụng mẫu này.";
                        }
                    } else {
                        $result ['message'] = 'Không thể thực hiện cập nhật công việc mẫu';
                    }
                } else {
                    $result ['message'] = 'Không tìm thấy chi tiết công việc mẫu';
                }
            }
        }
        
        // Delete a task template
        if (isset ( $_REQUEST ['delete_template'] )) {
            if (verify_access_right ( current_account (), F_TASK_TEMPLATE_LIST )) {
                // Get input data
                $template_id = $_POST ['template_id'];
                
                // DB model
                $template_model = new task_template ();
                
                // Delete the above template
                if ($template_model->delete ( $template_id )) {
                    $result ['result'] = 1;
                    $result ['message'] = '';
                } else {
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