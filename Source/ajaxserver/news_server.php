<?php
require_once '../part/common_start_page.php';
require_once '../models/news.php';

$result = array (
        'result' => 'error', // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => ''  // Detail message
);

if (verify_access_right ( current_account (), F_SYSTEM_ADMIN_NEWS_MANAGEMENT )) {
    
    // DB model
    $news_model = new news ();
    
    try {
        
        // Re-order of an item
        if (isset ( $_POST ['re_order'] )) {
            // Get input data
            $news_id = $_POST ['news_id'];
            $action = $_POST ['action']; // Actions: orderup, orderdown
                                         
            // Get news detail
            $src_news = $news_model->detail ( $news_id );
            if ($src_news != NULL) {
                // Get source order
                $src_order = $src_news->news_order;
                
                // Get destination news
                if ($action == "orderup") {
                    $dest_order = $src_order - 1;
                } else {
                    $dest_order = $src_order + 1;
                }
                $dest_news = $news_model->detail_by_order ( $src_news->group_id, $dest_order );
                if ($dest_news != NULL) {
                    // Update order of source news
                    if ($news_model->re_order ( $src_news->news_id, $dest_order )) {
                        // Update order of destination news
                        if ($news_model->re_order ( $dest_news->news_id, $src_order )) {
                            $result ['result'] = "success";
                            $result ['message'] = "Thực hiện thao tác thành công";
                        } else {
                            $result ['message'] = "Không thể cập nhật thứ tự cho bài viết '{$dest_news->news_id}'";
                        }
                    } else {
                        $result ['message'] = "Không thể cập nhật thứ tự cho bài viết '{$src_news->news_id}'";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy chi tiết bài viết thứ '{$dest_order}' của nhóm '{$src_news->group_id}'";
                }
            } else {
                $result ['message'] = "Không tìm thấy chi tiết bài viết '{$news_id}'";
            }
        }
        
        // Change the order of an item
        if (isset ( $_POST ['save_order'] )) {
            // Get input data
            $news_id = $_POST ['news_id'];
            $order = intval ( $_POST ['order'] );
            
            // Get news detail
            $news = $news_model->detail ( $news_id );
            if ($news != NULL) {
                
                $max_order = $news_model->get_max_order ( $news->group_id );
                if ($order > $max_order) {
                    $order = $max_order;
                }
                if ($order <= 1) {
                    $order = 1;
                }
                
                if ($news->news_order == $order) {
                    $result ['result'] = "warning";
                    $result ['message'] = "Không cần update thứ tự";
                } else {
                    
                    // Update the order
                    if ($order == $max_order) {
                        $seed = $news->news_order;
                        $start_num = $news->news_order;
                    } else {
                        $seed = $order + 1;
                        $start_num = $order;
                    }
                    $news_model->correct_order ( $news->group_id, $start_num, $seed, $news_id );
                    
                    if ($news_model->re_order ( $news->news_id, $order )) {
                        $result ['result'] = "success";
                        $result ['message'] = "Thực hiện thao tác thành công";
                    } else {
                        $result ['message'] = "Không thể cập nhật thứ tự cho bài viết '{$news_id}'";
                    }
                }
            } else {
                $result ['message'] = "Không tìm thấy chi tiết bài viết '{$news_id}'";
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