<?php
require_once '../part/common_start_page.php';
require_once '../models/orders_question.php';
require_once '../models/orders_question_option.php';

$result = array (
        'result' => 0, // Error status
                       // 0: Error occurred
                       // 1: Success
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => '', // Detail message
        'flag' => 0  // Flag status (1: Update template)
);

if (verify_access_right ( current_account (), G_SYSTEM_ADMIN, KEY_GROUP )) {
    try {
        // Create new question
        if (isset ( $_REQUEST ['create_question'] )) {
            if (verify_access_right ( current_account (), F_ORDERS_QUESTIONS_LIST )) {
                // Get input data
                $content = $_POST ['content'];
                $enable = isset($_POST['enable']);
                
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

                if (count ( $detail_list ) > 0) {
                    // DB model
                    $question_model = new orders_question ();
                    
                    // Insert question to database
                    $item = new orders_question_entity ();
                    $item->content = $content;
                    $item->enable = $enable;
                    
                    if ($question_model->insert ( $item )) {
                        $result ['result'] = 1;
                        $result ['message'] = 'Thêm câu hỏi thành công';
                        $result ['detail'] = array ();
                        
                        // Insert options list
                        $question_option_model = new orders_question_option ();
                            
                        for($j = 0; $j < count ( $detail_list ); $j ++) {
                            $d = new orders_question_option_entity ();
                            $d->no = $j + 1;
                            $d->question_id = $item->question_id;
                            $d->content = $detail_list [$j];
                            
                            if (! $question_option_model->insert ( $d )) {
                                $result ['detail'] [] = array (
                                        'content' => $d->content,
                                        'error' => $question_option_model->getMessage () 
                                );
                            }
                        }
                        // Warning message
                        if (count ( $result ['detail'] ) > 0) {
                            $result ['message'] = 'Không thể thực hiện thêm một số công việc nhỏ trong danh sách vào database:';
                        }
                    } else {
                        $result ['message'] = $question_model->getMessage ();
                    }
                }
                else {
                    $result ['message'] = 'Danh sách lựa chọn không được để trống';
                }
            }
        }
        
        // Update question
        if (isset ( $_REQUEST ['update_question'] )) {
            $result ['flag'] = 1;
            
            if (verify_access_right ( current_account (), F_ORDERS_QUESTIONS_LIST )) {
                // Get input data
                $content = $_POST ['content'];
                $question_id = $_POST ['question_id'];
                $enable = isset($_POST['enable']);
                
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

                if (count ( $detail_list ) > 0) {
                    // DB model
                    $question_model = new orders_question ();
                    $question_option_model = new orders_question_option ();
                    
                    // Get question information from database
                    $item = $question_model->detail ( $question_id );
                    
                    if ($item != NULL) {
                        // Update question
                        $item->content = $content;
                        $item->enable = $enable;
                        
                        if ($question_model->update ( $item )) {
                            $result ['result'] = 1;
                            $result ['message'] = 'Cập nhật câu hỏi thành công';
                            $result ['detail'] = array ();
                            
                            // Delete old question detail list
                            if (! $question_option_model->delete_by_question ( $question_id )) {
                                $result ['detail'] [] = array (
                                        'content' => "Cannot delete by question '{$question_id}'",
                                        'error' => $question_option_model->getMessage () 
                                );
                            }
                            
                            // Insert new question detail list
                            for($j = 0; $j < count ( $detail_list ); $j ++) {
                                $d = new orders_question_option_entity ();
                                $d->no = $j + 1;
                                $d->question_id = $item->question_id;
                                $d->content = $detail_list [$j];
                                    
                                if (! $question_option_model->insert ( $d )) {
                                    $result ['detail'] [] = array (
                                            'content' => "Cannot insert question option item '{$d->content}'",
                                            'error' => $question_option_model->getMessage () 
                                    );
                                }
                            }
                            
                            // Warning message
                            if (count ( $result ['detail'] ) > 0) {
                                $result ['message'] = 'Warning: Có một số lỗi xảy ra khi cập nhật câu hỏi như bên dưới';
                            } else {
                                $result ['message'] = "Cập nhật câu hỏi thành công.";
                            }
                        } else {
                            $result ['message'] = 'Không thể thực hiện cập nhật câu hỏi';
                        }
                    } else {
                        $result ['message'] = 'Không tìm thấy chi tiết câu hỏi';
                    }
                } else {
                    $result ['message'] = 'Danh sách lựa chọn không được để trống';
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