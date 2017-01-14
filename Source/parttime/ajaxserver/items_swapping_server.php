<?php
require_once '../part/common_start_page.php';
require_once '../models/tonkho.php';
include_once '../models/finance_token.php';
require_once '../models/trahang.php';
require_once '../models/items_swapping.php';
require_once '../models/items_swapping_detail.php';
require_once '../models/items_swapping_note.php';
require_once '../models/tonkhosanxuat.php';
require_once "../models/tranh.php";
require_once "../models/chitietsanphammapping.php";


$result = array(
    'result' => 'error', // Result status: 'success', 'error', 'warning'
    'message' => 'Thực hiện thao tác thất bại.', // Message
    'detail' => array(), // Detail message list (if any)
    'item' => array(
        'flag' => 0
    ), // Item status
    'token' => array(
        'flag' => 0
    )  // Token status
);

// Define function to swap item(s)
if (!function_exists('swap_items')) {
    function swap_items(items_swapping_detail_entity $swapping_detail, $action, $note, items_swapping_entity $swap = NULL)
    {
        // Output format
        $output = array(
            'result' => 'error', // Result status: 'success', 'error', 'warning'
            'message' => 'Thực hiện thao tác thất bại.', // Message
            'detail' => array(), // Detail message list (if any)
            'item' => array(
                'flag' => 0
            ), // Item status
            'token' => array(
                'flag' => 0
            )  // Token status
        );

        if ($swapping_detail->status == SWAPPING_DETAIL_WAIT) {

            // DB model
            $swapping_model = new items_swapping ();
            $swapping_detail_model = new items_swapping_detail ();
            $tonkho_model = new tonkho ();
            $tonkhosanxuat = new tonkhosanxuat();
            $tranh = new tranh();
            $chitietsanphammapping = new chitietsanphammapping();
            $loai = $tranh->loai_tranh( $swapping_detail->product_id );

            // Get token information
            if ($swap == NULL) {
                $swap = $swapping_model->detail($swapping_detail->swap_uid);
            }

            if ($swap != NULL) {

                // Warning messages
                $warning = NULL; // For "error" status
                $item_flag = 0;
                $token_flag = 0;

                // Delivery item(s)
                if ($action == 'delivery') {

                     $check_amount = 0;
                    if ($loai == TYPE_ITEM_PRODUCE) {
                        // Check remain amount of from store
                        $amount = $swapping_detail->amount;
                        $remain_amount = $tonkho_model->so_luong_ton_kho($swapping_detail->product_id, TEMP_STORE_ID);
                        if ( $remain_amount >= $amount ) {
                            $check_amount = 1;
                        }
                    } else if ( $loai == TYPE_ITEM_ASSEMBLY) {
                        $chitiets = array();
                        $danhsach_chitiet = $chitietsanphammapping->laymachitiet($swapping_detail->product_id);
                        $num = 0;
                        foreach ($danhsach_chitiet as $chitiet) {
                            $machitiet = $chitiet[0];
                            $note = '';
                            $remain_amount = $tonkhosanxuat->so_luong_ton_kho($machitiet, TEMP_STORE_ID );
                            $swap_amount = intval( $swapping_detail->amount ) * intval( $chitiet[1] );
                            $chitiets[] = array('machitiet' => $machitiet, 'remain_amount' => $remain_amount, 'swap_amount' => $swap_amount);
                            if ($remain_amount >= $swap_amount) {
                                $num++;
                            } else {
                                if ( !is_empty($note) ) {
                                    $note .= ', ';
                                }
                                $note .= $machitiet;
                            }
                        }
                        if ( $num == count($danhsach_chitiet) ) {
                            $check_amount = 1;
                        }
                    }

                    if ($check_amount) {
                        $check_update_amount_from = 0;
                        if ($loai == TYPE_ITEM_PRODUCE) {
                            $check_update_amount_from = $tonkho_model->cap_nhat_so_luong($swapping_detail->product_id, TEMP_STORE_ID, -$amount);
                        } else if ($loai == TYPE_ITEM_ASSEMBLY) {
                            $list_success = array();
                            foreach ($chitiets as $chitiet) {
                                $check = $tonkhosanxuat->giaohang( TEMP_STORE_ID, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                if ($check) {
                                    $list_success[] = $chitiet;
                                }
                            }
                            if ( count($chitiets) == count($list_success) ) {
                                $check_update_amount_from = 1;
                            } else {
                                foreach ($list_success as $chitiet) {
                                    $tonkhosanxuat->trahang( TEMP_STORE_ID, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                }
                            }
                        }

                        // Update amount in from store
                        if ($check_update_amount_from) {
                             // Update amount of product in to store
                            $updated = 0;
                            if ( $loai == TYPE_ITEM_PRODUCE ) {
                                if ($tonkho_model->is_exist($swapping_detail->product_id, $swap->to_store)) {
                                    // Update amount (added the value) of the existing item
                                    $updated = $tonkho_model->cap_nhat_so_luong($swapping_detail->product_id, $swap->to_store, $amount, TRUE);
                                } else {
                                    // Insert a new item
                                    $updated = $tonkho_model->them($swapping_detail->product_id, $swap->to_store, $amount);
                                }
                            } else if ( $loai == TYPE_ITEM_ASSEMBLY ) {
                                $list_success = array();
                                foreach ($chitiets as $chitiet) {
                                    if ( $tonkhosanxuat->tranhtontai($chitiet['machitiet'], $swap->to_store) ) {
                                        $check = $tonkhosanxuat->trahang( $swap->to_store, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                    } else {
                                        $check = $tonkhosanxuat->insert( array($swap->to_store, $chitiet['machitiet'], $chitiet['swap_amount']) );
                                    }

                                    if ($check) {
                                        $list_success[] = $chitiet;
                                    }
                                }
                                if ( count($chitiets) == count($list_success) ) {
                                    $updated = 1;
                                } else {
                                    foreach ($list_success as $chitiet) {
                                        $tonkhosanxuat->giaohang( $swap->to_store, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                    }
                                }
                            }
                   

                            if ($updated) {

                                // Warning messages
                                $warning = array();

                                // Update information of item
                                $swapping_detail->status = SWAPPING_DETAIL_DELIVERIED;
                                $swapping_detail->note = $note;

                                if ($swapping_detail_model->update($swapping_detail)) {

                                    // Refresh item status
                                    $item_flag = 1;

                                    // Update status of token
                                    $count = $swapping_model->count_of_wait($swap->swap_uid);
                                    if ($count == 0) {
                                        $swap->status = SWAPPING_FINISHED;
                                        if (!$swapping_model->update($swap)) {
                                            $warning [] = array(
                                                'title' => "Cập nhật trạng thái của phiếu chuyển '{$swap->swap_uid}'",
                                                'error' => $swapping_model->getMessage()
                                            );
                                        } else {
                                            // Refresh token status
                                            $token_flag = 1;
                                        }
                                    }

                                    // History DB model
                                    $show_room = new khohang ();
                                    $history = new import_export_history ();

                                    // Add export history of from store
                                    $msg = sprintf(import_export_history::$MSG_SWAP_ITEMS, $show_room->ten_kho($swap->to_store), $swap->swap_uid);
                                    $type = import_export_history::$TYPE_EXPORT;
                                    if ($history->add_new(current_account(), $swapping_detail->product_id, $swap->from_store, $amount, NULL, $type, $msg, TRUE)) {
                                        // Do nothing
                                    } else {
                                        $warning [] = array(
                                            'title' => "Thêm nhật ký xuất hàng ('{$msg}')",
                                            'error' => $history->getMessage()
                                        );
                                    }

                                    // Add import history of to store
                                    $msg = sprintf(import_export_history::$MSG_DELIVERY_SWAPPING_ITEM, $show_room->ten_kho($swap->from_store), $swap->swap_uid);
                                    $type = import_export_history::$TYPE_IMPORT;
                                    if ($history->add_new(current_account(), $swapping_detail->product_id, $swap->to_store, $amount, NULL, $type, $msg, TRUE)) {
                                        // Do nothing
                                    } else {
                                        $warning [] = array(
                                            'title' => "Thêm nhật ký nhập hàng ('{$msg}')",
                                            'error' => $history->getMessage()
                                        );
                                    }
                                } else {
                                    $output ['message'] = sprintf("Lỗi cập nhật hạng mục '{$swapping_detail->uid}': %s", $swapping_detail_model->getMessage());
                                }
                            } else {
                                $output ['message'] = sprintf("Lỗi cập nhật số lượng tồn của kho '{$swap->to_store}': %s", $tonkho_model->getMessage());
                            }
                        } else {
                            $output ['message'] = sprintf("Lỗi cập nhật số lượng tồn của kho '{$swap->from_store}': %s", $tonkho_model->getMessage());
                        }
                    } else {
                        $output ['message'] = "Số lượng tồn kho không đủ";
                    }
                } else { // Return item(s)
                    // Update information of item
                    if ($swap->from_store != 33) {
                        $swapping_detail->status = SWAPPING_DETAIL_RETURNED;
                        $swapping_detail->note = $note;
                        //kien
//
                        $check_amount = 0;
                        if ($loai == TYPE_ITEM_PRODUCE) {
                            // Check remain amount of from store
                            $amount = $swapping_detail->amount;
                            $remain_amount = $tonkho_model->so_luong_ton_kho($swapping_detail->product_id, TEMP_STORE_ID);
                            if ( $remain_amount >= $amount ) {
                                $check_amount = 1;
                            }
                        } else if ( $loai == TYPE_ITEM_ASSEMBLY) {
                            $chitiets = array();
                            $danhsach_chitiet = $chitietsanphammapping->laymachitiet($swapping_detail->product_id);
                            $num = 0;
                            foreach ($danhsach_chitiet as $chitiet) {
                                $machitiet = $chitiet[0];
                                $note = '';
                                $remain_amount = $tonkhosanxuat->so_luong_ton_kho($machitiet, TEMP_STORE_ID );
                                $swap_amount = intval( $swapping_detail->amount ) * intval( $chitiet[1] );
                                $chitiets[] = array('machitiet' => $machitiet, 'remain_amount' => $remain_amount, 'swap_amount' => $swap_amount);
                                if ($remain_amount >= $swap_amount) {
                                    $num++;
                                } else {
                                    if ( !is_empty($note) ) {
                                        $note .= ', ';
                                    }
                                    $note .= $machitiet;
                                }
                            }
                            if ( $num == count($danhsach_chitiet) ) {
                                $check_amount = 1;
                            }
                        }

                        if ($check_amount) {
                            $check_update_amount_from = 0;
                            if ($loai == TYPE_ITEM_PRODUCE) {
                                $check_update_amount_from = $tonkho_model->cap_nhat_so_luong($swapping_detail->product_id, TEMP_STORE_ID, -$amount);
                            } else if ($loai == TYPE_ITEM_ASSEMBLY) {
                                $list_success = array();
                                foreach ($chitiets as $chitiet) {
                                    $check = $tonkhosanxuat->giaohang( TEMP_STORE_ID, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                    if ($check) {
                                        $list_success[] = $chitiet;
                                    }
                                }
                                if ( count($chitiets) == count($list_success) ) {
                                    $check_update_amount_from = 1;
                                } else {
                                    foreach ($list_success as $chitiet) {
                                        $tonkhosanxuat->trahang( TEMP_STORE_ID, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                    }
                                }
                            }

                            // Update amount in from store
                            if ($check_update_amount_from) {//from temp store
                                if ($check_update_amount_from) {
                                    // Update amount of product in to store
                                    $updated = 0;
                                    if ($loai == TYPE_ITEM_PRODUCE) {
                                        if ($tonkho_model->is_exist($swapping_detail->product_id, $swap->from_store)) {
                                            // Update amount (added the value) of the existing item
                                            $updated = $tonkho_model->cap_nhat_so_luong($swapping_detail->product_id, $swap->from_store, $amount, TRUE);
                                        } else {
                                            // Insert a new item
                                            $updated = $tonkho_model->them($swapping_detail->product_id, $swap->from_store, $amount);
                                        }
                                    } else if ($loai == TYPE_ITEM_ASSEMBLY) {
                                        $list_success = array();
                                        foreach ($chitiets as $chitiet) {
                                            if ($tonkhosanxuat->tranhtontai($chitiet['machitiet'], $swap->from_store)) {
                                                $check = $tonkhosanxuat->trahang($swap->from_store, $chitiet['machitiet'], $chitiet['swap_amount']);
                                            } else {
                                                $check = $tonkhosanxuat->insert(array($swap->from_store, $chitiet['machitiet'], $chitiet['swap_amount']));
                                            }

                                            if ($check) {
                                                $list_success[] = $chitiet;
                                            }
                                        }
                                        if (count($chitiets) == count($list_success)) {
                                            $updated = 1;
                                        } else {
                                            foreach ($list_success as $chitiet) {
                                                $tonkhosanxuat->giaohang($swap->from_store, $chitiet['machitiet'], $chitiet['swap_amount']);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //end kien

                        if ($swapping_detail_model->update($swapping_detail)) {

                            // Warning messages
                            $warning = array();

                            // Refresh item status
                            $item_flag = 1;

                            // Update status of token
                            $count = $swapping_model->count_of_wait($swap->swap_uid);
                            if ($count == 0) {
                                $swap->status = SWAPPING_FINISHED;
                                if (!$swapping_model->update($swap)) {
                                    $warning [] = array(
                                        'title' => "Cập nhật trạng thái của phiếu chuyển '{$swap->swap_uid}'",
                                        'error' => $swapping_model->getMessage()
                                    );
                                } else {
                                    // Refresh token status
                                    $token_flag = 1;
                                }
                            }
                        } else {
                            $output ['message'] = sprintf("Lỗi cập nhật hạng mục '{$swapping_detail->uid}': %s", $swapping_detail_model->getMessage());
                        }
                    } else {
                        $warning [] = array(
                            'title' => "Lỗi từ chối phiếu nhập kho",
                            'error' => "Hàng khách trả lại bắt buộc nhập kho"
                        );
                    }
                }

                /* Output result */
                if (is_array($warning)) {
                    if (count($warning) > 0) {
                        $output ['result'] = "warning";
                        $output ['message'] = "Quá trình xử lý có một số lỗi như sau:";
                    } else {
                        $output ['result'] = "success";
                        $output ['message'] = "Thực hiện xử lý thành công";
                    }
                    $output ['detail'] = $warning;

                    // Refresh item
                    if ($item_flag == 1) {
                        $item_status = items_swapping_detail::$styleArr [$swapping_detail->status];
                    }
                    $item_status ['flag'] = $item_flag;
                    $item_status ['note'] = $swapping_detail->note;
                    $item_status ['uid'] = $swapping_detail->uid;
                    $output ['item'] = $item_status;

                    // Refresh token
                    if ($token_flag == 1) {
                        $token_status = items_swapping::$tokenStyleArr [$swap->status];
                    }
                    $token_status ['flag'] = $token_flag;
                    $output ['token'] = $token_status;
                } else {
                    // Do nothing
                }

                /* End processing */
            } else {
                $output ['message'] = "Không tìm thấy thông tin phiếu chuyển kho '{$swapping_detail->swap_uid}'";
            }
        } else {
            $output ['result'] = "success";

            $output ['message'] = "Hạng mục '{$swapping_detail->uid}' đã được xử lý";
        }

        return $output;
    } // End of function
}

//kien
if (!function_exists('swap_items_temp')) {
    function swap_items_temp(items_swapping_detail_entity $swapping_detail, $action, $note, items_swapping_entity $swap = NULL)
    {
        // Output format
        $output = array(
            'result' => 'error', // Result status: 'success', 'error', 'warning'
            'message' => 'Thực hiện thao tác thất bại.', // Message
            'detail' => array(), // Detail message list (if any)
            'item' => array(
                'flag' => 0
            ), // Item status
            'token' => array(
                'flag' => 0
            )  // Token status
        );

        if ($swapping_detail->status == SWAPPING_DETAIL_WAIT) {

            // DB model
            $swapping_model = new items_swapping ();
            $swapping_detail_model = new items_swapping_detail ();
            $tonkho_model = new tonkho ();
            $tranh = new tranh();
            $tonkhosanxuat = new tonkhosanxuat();
            $chitietsanphammapping = new chitietsanphammapping();
            $loai = $tranh->loai_tranh( $swapping_detail->product_id );
            // Get token information
            if ($swap == NULL) {
                $swap = $swapping_model->detail($swapping_detail->swap_uid);
            }

            if ($swap != NULL) {

                // Warning messages
                $warning = NULL; // For "error" status
                $item_flag = 0;
                $token_flag = 0;

                // Delivery item(s)
                if ($action == 'delivery') {
                    $check_amount = 0;
                    if ($loai == TYPE_ITEM_PRODUCE) {
                        // Check remain amount of from store
                        $amount = $swapping_detail->amount;
                        $remain_amount = $tonkho_model->so_luong_ton_kho($swapping_detail->product_id, $swap->from_store);
                        if ( $remain_amount >= $amount ) {
                            $check_amount = 1;
                        }
                    } else if ( $loai == TYPE_ITEM_ASSEMBLY) {
                        $chitiets = array();
                        $danhsach_chitiet = $chitietsanphammapping->laymachitiet($swapping_detail->product_id);
                        $num = 0;
                        foreach ($danhsach_chitiet as $chitiet) {
                            $machitiet = $chitiet[0];
                            $note = '';
                            $remain_amount = $tonkhosanxuat->so_luong_ton_kho($machitiet,$swap->from_store );
                            $swap_amount = intval( $swapping_detail->amount ) * intval( $chitiet[1] );
                            $chitiets[] = array('machitiet' => $machitiet, 'remain_amount' => $remain_amount, 'swap_amount' => $swap_amount);
                            if ($remain_amount >= $swap_amount) {
                                $num++;
                            } else {
                                if ( !is_empty($note) ) {
                                    $note .= ', ';
                                }
                                $note .= $machitiet;
                            }
                        }
                        if ( $num == count($danhsach_chitiet) ) {
                            $check_amount = 1;
                        }
                    }

                    if (!$check_amount) {
                        if ( $loai == TYPE_ITEM_PRODUCE ) {
                            $note = "Sản phẩm " . $swapping_detail->product_id . " Không đủ số lượng trong kho. Đã cập nhật lại số lượng từ " . $amount . " xuống còn " . $remain_amount;
                            $created_by = current_account();
                            $created_date = current_timestamp();

                            // DB model
                            $db_model = new items_swapping_note ();

                            // Insert to database
                            $db_model->add_new($created_date, $created_by, $swapping_detail->swap_uid, $note);
                            $amount = $remain_amount;
                            $swapping_detail->amount = $amount;
                            $swapping_detail_model->update($swapping_detail);
                        } else if ($loai == TYPE_ITEM_ASSEMBLY) {
                            $note = "Sản phẩm " . $swapping_detail->product_id . " Không đủ số lượng chi tiết trong kho. (".$note.")";
                            $created_by = current_account();
                            $created_date = current_timestamp();

                            // DB model
                            $db_model = new items_swapping_note ();

                            // Insert to database
                            $db_model->add_new($created_date, $created_by, $swapping_detail->swap_uid, $note);
                        }
                    }//

                    if ($check_amount) {

                        // Update amount in from store
                        $check_update_amount_from = 0;
                        if ($loai == TYPE_ITEM_PRODUCE) {
                            $check_update_amount_from = $tonkho_model->cap_nhat_so_luong($swapping_detail->product_id, $swap->from_store, -$amount);
                        } else if ($loai == TYPE_ITEM_ASSEMBLY) {
                            $list_success = array();
                            foreach ($chitiets as $chitiet) {
                                $check = $tonkhosanxuat->giaohang( $swap->from_store, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                if ($check) {
                                    $list_success[] = $chitiet;
                                }
                            }
                            if ( count($chitiets) == count($list_success) ) {
                                $check_update_amount_from = 1;
                            } else {
                                foreach ($list_success as $chitiet) {
                                    $tonkhosanxuat->trahang( $swap->from_store, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                }
                            }
                        }
                        if ($check_update_amount_from) {

                            // Update amount of product in to store
                            $updated = 0;
                            if ( $loai == TYPE_ITEM_PRODUCE ) {
                                if ($tonkho_model->is_exist($swapping_detail->product_id, TEMP_STORE_ID)) {
                                    // Update amount (added the value) of the existing item
                                    $updated = $tonkho_model->cap_nhat_so_luong($swapping_detail->product_id, TEMP_STORE_ID, $amount, TRUE);
                                } else {
                                    // Insert a new item
                                    $updated = $tonkho_model->them($swapping_detail->product_id, TEMP_STORE_ID, $amount);
                                }
                            } else if ( $loai == TYPE_ITEM_ASSEMBLY ) {
                                $list_success = array();
                                foreach ($chitiets as $chitiet) {
                                    if ( $tonkhosanxuat->tranhtontai($chitiet['machitiet'], TEMP_STORE_ID) ) {
                                        $check = $tonkhosanxuat->trahang( TEMP_STORE_ID, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                    } else {
                                        $check = $tonkhosanxuat->insert( array(TEMP_STORE_ID, $chitiet['machitiet'], $chitiet['swap_amount']) );
                                    }

                                    if ($check) {
                                        $list_success[] = $chitiet;
                                    }
                                }
                                if ( count($chitiets) == count($list_success) ) {
                                    $updated = 1;
                                } else {
                                    foreach ($list_success as $chitiet) {
                                        $tonkhosanxuat->giaohang( TEMP_STORE_ID, $chitiet['machitiet'], $chitiet['swap_amount'] );
                                    }
                                }
                            }
                            if ($updated) {

                                // Warning messages
                                $warning = array();

                                // Update information of item
//                               $swapping_detail->status = SWAPPING_DETAIL_DELIVERIED;
                                $swapping_detail->note = $note;

                                if ($swapping_detail_model->update($swapping_detail)) {

                                    // Refresh item status
                                    $item_flag = 1;

                                    // Update status of token

                                    $swap->status = SWAPPING_NEW;
                                    if (!$swapping_model->update($swap)) {
                                        $warning [] = array(
                                            'title' => "Cập nhật trạng thái của phiếu chuyển '{$swap->swap_uid}'",
                                            'error' => $swapping_model->getMessage()
                                        );
                                    } else {
                                        // Refresh token status
                                        $token_flag = 1;
                                    }


                                    // History DB model
                                    $show_room = new khohang ();
                                    $history = new import_export_history ();

                                    // Add export history of from store
                                    $msg = sprintf(import_export_history::$MSG_SWAP_ITEMS_TMP, $show_room->ten_kho($swap->to_store), $swap->swap_uid);
                                    $type = import_export_history::$TYPE_EXPORT;
                                    if ($history->add_new(current_account(), $swapping_detail->product_id, $swap->from_store, $amount, NULL, $type, $msg, TRUE)) {
                                        // Do nothing
                                    } else {
                                        $warning [] = array(
                                            'title' => "Thêm nhật ký xuất hàng ('{$msg}')",
                                            'error' => $history->getMessage()
                                        );
                                    }

                                    // Add import history of to store
                                    $msg = sprintf(import_export_history::$MSG_DELIVERY_SWAPPING_ITEM_TMP, $show_room->ten_kho($swap->from_store), $swap->swap_uid);
                                    $type = import_export_history::$TYPE_IMPORT;
                                    if ($history->add_new(current_account(), $swapping_detail->product_id, $swap->to_store, $amount, NULL, $type, $msg, TRUE)) {
                                        // Do nothing
                                    } else {
                                        $warning [] = array(
                                            'title' => "Thêm nhật ký nhập hàng ('{$msg}')",
                                            'error' => $history->getMessage()
                                        );
                                    }
                                } else {
                                    $output ['message'] = sprintf("Lỗi cập nhật hạng mục '{$swapping_detail->uid}': %s", $swapping_detail_model->getMessage());
                                }
                            } else {
                                $output ['message'] = sprintf("Lỗi cập nhật số lượng tồn của kho '{$swap->to_store}': %s", $tonkho_model->getMessage());
                            }
                        } else {
                            $output ['message'] = sprintf("Lỗi cập nhật số lượng tồn của kho '{$swap->from_store}': %s", $tonkho_model->getMessage());
                        }
                    } else {
                        $output ['message'] = "Số lượng tồn kho không đủ";
                    }
                } else { // Return item(s)
                    // Update information of item
                    $swapping_detail->status = SWAPPING_DETAIL_RETURNED;
                    $swapping_detail->note = $note;

                    if ($swapping_detail_model->update($swapping_detail)) {

                        // Warning messages
                        $warning = array();

                        // Refresh item status
                        $item_flag = 1;

                        // Update status of token
                        $count = $swapping_model->count_of_wait($swap->swap_uid);
                        if ($count == 0) {
                            $swap->status = SWAPPING_FINISHED;
                            if (!$swapping_model->update($swap)) {
                                $warning [] = array(
                                    'title' => "Cập nhật trạng thái của phiếu chuyển '{$swap->swap_uid}'",
                                    'error' => $swapping_model->getMessage()
                                );
                            } else {
                                // Refresh token status
                                $token_flag = 1;
                            }
                        }
                    } else {
                        $output ['message'] = sprintf("Lỗi cập nhật hạng mục '{$swapping_detail->uid}': %s", $swapping_detail_model->getMessage());
                    }
                }

                /* Output result */
                if (is_array($warning)) {
                    if (count($warning) > 0) {
                        $output ['result'] = "warning";
                        $output ['message'] = "Quá trình xử lý có một số lỗi như sau:";
                    } else {
                        $output ['result'] = "success";
                        $output ['message'] = "Thực hiện xử lý thành công";
                    }
                    $output ['detail'] = $warning;

                    // Refresh item
                    if ($item_flag == 1) {
                        $item_status = items_swapping_detail::$styleArr [$swapping_detail->status];
                    }
                    $item_status ['flag'] = $item_flag;
                    $item_status ['note'] = $swapping_detail->note;
                    $item_status ['uid'] = $swapping_detail->uid;
                    $output ['item'] = $item_status;

                    // Refresh token
                    if ($token_flag == 1) {
                        $token_status = items_swapping::$tokenStyleArr [$swap->status];
                    }
                    $token_status ['flag'] = $token_flag;
                    $output ['token'] = $token_status;
                } else {
                    // Do nothing
                }

                /* End processing */
            } else {
                $output ['message'] = "Không tìm thấy thông tin phiếu chuyển kho '{$swapping_detail->swap_uid}'";
            }
        } else {
            $output ['result'] = "success";

            $output ['message'] = "Hạng mục '{$swapping_detail->uid}' đã được xử lý";
        }

        return $output;
    } // End of function
}


//end kien
if (verify_access_right ( current_account (), G_STORES, KEY_GROUP ) ) {
    /* Process user request(s) */
    try {

        // Swap items
        if (isset ($_REQUEST ['swap_items'])) {

            if (verify_access_right(current_account(), F_STORES_SWAP)) {

                // Get input data
                $masotranh = $_REQUEST ['masotranh'];
                $soluong = $_REQUEST ['soluongchuyen'];
                $from_store = $_REQUEST ['from'];
                $to_store = $_REQUEST ['to'];

                // DB model
                $tonkho_model = new tonkho ();
                $swapping_model = new items_swapping ();
                $swapping_detail_model = new items_swapping_detail ();
                $history = new import_export_history ();

                $tranh = new tranh();
                $chitietsanphammapping = new chitietsanphammapping();
                $tonkhosanxuat = new tonkhosanxuat();
                // Items list
                $items = array();
                if (count($masotranh) > 0) {
                    for ($i = 0; $i < count($masotranh); $i++) {
                        $loai = $tranh->loai_tranh($masotranh[$i]);
                        $z = array(
                            'product_id' => $masotranh [$i],
                            'loai' => $loai
                        );
                        if ($loai == TYPE_ITEM_PRODUCE) {
                            $z['remain_amount'] = $tonkho_model->so_luong_ton_kho($masotranh [$i], $from_store);
                            $z['swap_amount'] = $soluong [$i];
                        } else if ($loai == TYPE_ITEM_ASSEMBLY) {
                            $danhsach_chitiet = $chitietsanphammapping->laymachitiet($masotranh[$i]);
                            $z['chitiet'] = array();
                            $z['swap_amount'] = $soluong [$i];
                            foreach ($danhsach_chitiet as $chitiet) {
                                $machitiet = $chitiet[0];
                                $remain_amount = $tonkhosanxuat->so_luong_ton_kho($machitiet, $from_store);
                                $swap_amount = intval($soluong [$i]) * intval($chitiet[1]);
                                $z['chitiet'][] = array('machitiet' => $machitiet, 'remain_amount' => $remain_amount, 'swap_amount' => $swap_amount);
                            }
                        }
                        $items [] = $z;
                    }
                }
                if (count($items) > 0) {
                    $continue = TRUE;
                    /* Get last modified swapping */
                    $swap_uid = $swapping_model->get_last_modified_swapping(current_account(), $from_store, $to_store);
                    if ($swap_uid != NULL) {
                        $swap = $swapping_model->detail($swap_uid);
                        if ($swap == NULL) {
                            $continue = FALSE;
                        }
                    } else {
                        /* Create a new swapping token */
                        $swap = new items_swapping_entity ();
                        $swap->created_by = current_account();
                        $swap->from_store = $from_store;
                        $swap->to_store = $to_store;

                        // Generate swapping UID (with '10' retry times)
                        $tmp = 'YmdHisu';
                        $swap_uid = '';
                        for ($i = 0; $i <= 10; $i++) {
                            usleep(5);
                            $swap_uid = substr(udate($tmp), 0, 17);
                            if (!$swapping_model->check_existing($swap_uid)) {
                                break;
                            }
                        }
                        $swap->swap_uid = $swap_uid;
                        $result['swap_uid'] = $swap_uid;
                        // Insert to database
                        if (!$swapping_model->insert($swap)) {
                            $continue = FALSE;
                        }
                    }

                    // Check continous condition
                    if ($continue) {
                        $total_amount = 0;
                        $warning = array();

                        // Process with item list
                        foreach ($items as $p) {
                            if ($p['loai'] == TYPE_ITEM_PRODUCE) {
                                // Check remain amount
                                if ($p ['remain_amount'] >= $p ['swap_amount']) {

                                    // Add swapping detail to database
                                    $swap_detail = new items_swapping_detail_entity ();
                                    $swap_detail->swap_uid = $swap->swap_uid;
                                    $result['swap_uid'] = $swap->swap_uid;
                                    $swap_detail->product_id = $p ['product_id'];
                                    $swap_detail->amount = $p ['swap_amount'];

                                    if ($swapping_detail_model->insert($swap_detail)) {
                                        // Total products number
                                        $total_amount++;
                                    } else {
                                        $warning [] = array(
                                            'product' => $p ['product_id'],
                                            'amount' => $p ['swap_amount'],
                                            'error' => $swapping_detail_model->getMessage()
                                        );
                                    }
                                } else {
                                    $warning [] = array(
                                        'product' => $p ['product_id'],
                                        'amount' => $p ['swap_amount'],
                                        'error' => "Số lượng tồn kho không đủ"
                                    );
                                }
                            } else if ($p['loai'] == TYPE_ITEM_ASSEMBLY) {
                                $chitiet = $p['chitiet'];
                                $numcheck = 0;
                                $inserted = 1;
                                for ($i = 0; $i < count($chitiet); $i++) {
                                    if ($chitiet[$i]['remain_amount'] >= $chitiet[$i]['swap_amount']) {
                                        // Add swapping detail to database
                                        $swap_detail = new items_swapping_detail_entity ();
                                        $swap_detail->swap_uid = $swap->swap_uid;
                                        $result['swap_uid'] = $swap->swap_uid;
                                        $swap_detail->product_id = $p ['product_id'];
                                        $swap_detail->amount = $p ['swap_amount'];

                                        if ($swapping_detail_model->insert($swap_detail)) {
                                            // Total products number
                                        } else {
                                            $inserted = 0;
                                            $warning [] = array(
                                                'product' => $p ['product_id'],
                                                'amount' => $p ['swap_amount'],
                                                'error' => $swapping_detail_model->getMessage()
                                            );
                                        }
                                    } else {
                                        $warning [] = array(
                                            'product' => $p ['product_id'],
                                            'amount' => $p ['swap_amount'],
                                            'error' => "Số lượng tồn kho không đủ"
                                        );
                                    }
                                }
                                $total_amount+= $inserted;
                            }
                        }

                        // Update swapping token information
                        if ($total_amount > 0) {
                            $swap->total_amount += $total_amount;

                            if ($swapping_model->update($swap)) {
                                // Do nothing
                            } else {
                                $warning [] = array(
                                    'product' => '',
                                    'amount' => '',
                                    'error' => $swapping_model->getMessage()
                                );
                            }
                        }

                        // Remove items which remain amount = 0
                        if ($tonkho_model->xoa_hang_muc_het_so_luong()) {
                            // Do nothing
                        } else {
                            $warning [] = array(
                                'product' => '',
                                'amount' => '',
                                'error' => $tonkho_model->getMessage()
                            );
                        }

                        // Result
                        if (count($warning) > 0) {
                            $result ['result'] = "warning";
                            $result ['message'] = "Quá trình tạo phiếu chuyển kho có một số lỗi như sau:";
                        } else {
                            $result ['result'] = "success";
                            $result ['message'] = "Các sản phẩm đã được thêm vào phiếu chuyển '{$swap_uid}' thành công!";
                        }
                        $result ['detail'] = $warning;
                    } else {
                        $result ['result'] = "error";
                        $result ['message'] = $swapping_model->getMessage();
                    }
                } else {
                    $result ['result'] = "warning";
                    $result ['message'] = "Không có sản phẩm để thực hiện chuyển kho";
                }
            }
        }

        // Get swapping detail
        if (isset ($_POST ['load_swapping_detail'])) {

            if (verify_access_right(current_account(), F_STORES_SWAP)) {
                // Get input data
                $swap_uid = $_POST ['swap_uid'];

                // DB model
                $swapping_model = new items_swapping ();
                $swapping_detail_model = new items_swapping_detail ();

                // Get swap token information
                $swap = $swapping_model->detail($swap_uid);
                if ($swap != NULL) {
                    // Check acces rights
                    $access = items_swapping::check_viewing_right(current_account(), $swap);

                    if ($access != 0) {
                        // Get detail list
                        $arr = $swapping_detail_model->array_by_swapping($swap_uid);
                        if (is_array($arr)) {
                            // Update the array's data
                            for ($i = 0; $i < count($arr); $i++) {
                                // Enable/Disable actions
                                if ($arr [$i] ['status'] == SWAPPING_DETAIL_WAIT) {
                                    $arr [$i] ['actions'] = 1;
                                } else {
                                    $arr [$i] ['actions'] = 0;
                                }

                                // 'Status' values
                                $tmp = items_swapping_detail::$styleArr [$arr [$i] ['status']];
                                $tmp ['value'] = $arr [$i] ['status'];
                                $arr [$i] ['status'] = $tmp;

                                // 'Price' value
                                $arr [$i] ['price'] = number_format($arr [$i] ['price'], 0, ",", ".");
                            }

                            // Output result
                            $result ['result'] = "success";
                            $result ['message'] = "";
                            $result ['detail'] = $arr;
                            $result ['flag'] = ($access == 2) ? 1 : 0;
                            $result ['finished'] = ($swap->status == SWAPPING_NEW) ? 0 : 1;
                            $result ['shipping'] = ($swap->status == SWAPPING_COMPLETED && $swap->created_by == current_account()) ? 1 : 0;
                            $result ['report'] = ($swap->status == SWAPPING_DRAFT && $swap->created_by == current_account()) ? 1 : 0;
                        } else {
                            $result ['message'] = "Không tìm thấy danh sách sản phẩm của phiếu chuyển kho '{$swap_uid}'";
                        }
                    } else {
                        $result ['message'] = "Bạn không có quyền xem thông tin phiếu chuyển kho '{$swap_uid}'";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy thông tin phiếu chuyển kho '{$swap_uid}'";
                }
            }
        }
//        Hieu
        if (isset ($_POST ['report_shipping'])) {
            if (verify_access_right ( current_account (), F_STORES_SWAP )) {
                // Get input data
                if ($_POST ['action'] == "cancel") {
                    //cance;
                } else {
                    $item_uid = $_POST ['swap_uid'];
                    $action = 'delivery'; // Actions: 'delivery', 'return'
                    $swap_type = 'multi'; // Type: 'single', 'multi'
                    $note = "";

                    // DB model
                    $swapping_model = new items_swapping ();
                    $swapping_detail_model = new items_swapping_detail ();
                    $tonkho_model = new tonkho ();

                    /*
                     * //For failed testing (start) $debugFlag = TRUE; if ($debugFlag) { $result ['result'] = "warning"; $tmp = array (); $tmp [] = array ( 'title' => "Cập nhật trạng thái của phiếu chuyển '123456'", 'error' => "ERROR 01" ); $tmp [] = array ( 'title' => "Thêm nhật ký nhập hàng ('{msg}')", 'error' => '$history->getMessage ()' ); $result ['detail'] = $tmp; $item_status = array (); $item_status ['flag'] = 0; $item_status ['note'] = '$swapping_detail->note'; $item_status ['uid'] = '$swapping_detail->uid'; $result ['item'] = $item_status; $token_status = array (); $token_status ['flag'] = 0; $result ['token'] = '$token_status'; echo json_encode ( $result ); exit (); } //For failed testing (end)
                     */
                    // Single item
                    if ($swap_type == "single") {
                        // Get item's detail
                        $swapping_detail = $swapping_detail_model->detail($item_uid);
                        if ($swapping_detail != NULL) {
                            $result = swap_items_temp($swapping_detail, $action, $note);
                        } else {
                            $result ['message'] = "Không tìm thấy thông tin hạng mục '{$item_uid}'";
                        }
                    } else { // Multi items

                        // Get swap token information
                        $swap = $swapping_model->detail($item_uid);
                        if ($swap != NULL) {
                            // Get detail list
                            $list = $swapping_detail_model->list_by_swapping($swap->swap_uid, FALSE);
                            if (($list == NULL) || (count($list) == 0)) {
                                $result ['message'] = "Không có hạng mục chờ nhận nào trong phiếu chuyển kho '{$swap->swap_uid}'";
                            } else {
                                // Initial values
                                $total = count($list); // Total processing items
                                $success = 0;
                                $items = array();
                                $token = NULL;
                                $detail = array(); // Detail message list

                                // Process each item in the list
                                foreach ($list as $swapping_detail) {
                                    $arr = swap_items_temp($swapping_detail, $action, $note, $swap);

                                    if ($arr ['result'] == "error") {
                                        // Add to detail list
                                        $detail [] = array(
                                            'product_id' => $swapping_detail->product_id,
                                            'error' => $arr ['message']
                                        );
                                    } else {
                                        // Count the success items
                                        $success++;

                                        // Get item status
                                        $items [] = $arr ['item'];

                                        // Get token status
                                        $token = $arr ['token'];

                                        // Warning message list
                                        $warning = $arr ['detail'];
                                        if (is_array($warning) && count($warning) > 0) {
                                            $tmp = array();
                                            foreach ($warning as $w) {
                                                $tmp [] = $w ['title'];
                                            }
                                            // Add to detail list
                                            $detail [] = array(
                                                'product_id' => $swapping_detail->product_id,
                                                'error' => implode("; ", $tmp)
                                            );
                                        }
                                    }
                                }//end foreach

                                // Output result
                                $result ['result'] = "success";
                                $msg = sprintf("Xử lý thành công %d/%d mã hàng.", $success, $total);
                                if (count($detail) > 0) {
                                    $msg .= " Có một số lỗi xảy ra như sau:";
                                }
                                $result ['message'] = $msg;
                                $result ['detail'] = $detail;
                                $result ['item'] = $items;
                                if (is_array($token)) {
                                    $result ['token'] = $token;
                                } else {
                                    $result['result'] = "error";
                                    $result['message'] = $amount_failse;
                                }
                            }
                        } else {
                            $result ['message'] = "Không tìm thấy thông tin phiếu chuyển kho '{$item_uid}'";
                        }
                    }

                    // Set type to output
                }

                //update status

                // Report a swapping token

                if ($result['result'] != 'error') {
                    if (verify_access_right(current_account(), F_STORES_SWAP)) {
                        // Get input data
                        $swap_uid = $_POST ['swap_uid'];
                        $action = $_POST ['action']; // action = 'accept' / 'cancel'

                        // DB model
                        $swapping_model = new items_swapping ();

                        // Get swap token information
                        $swap = $swapping_model->detail($swap_uid);
                        if ($swap != NULL) {
                            // Check acces rights
                            $access = items_swapping::check_viewing_right(current_account(), $swap);

                            if ($access != 0) {
                                if ($swap->status == SWAPPING_DRAFT) {
                                    if ($action == 'accept') {
                                        if ($result['result'] != 'error') {
                                            $swap->status = SWAPPING_NEW;

                                            if ($swapping_model->update($swap)) {
                                                $result ['result'] = 'success';
                                                $result ['message'] = "Thực hiện hoàn tất phiếu chuyển kho '{$swap_uid}' thành công!";
                                            } else {
                                                $result ['message'] = "Không thể hoàn tất phiếu chuyển kho '{$swap_uid}'. Lỗi: {$swapping_model->getMessage()}";
                                            }
                                        }//check error
                                    } elseif ($action == 'cancel') {
                                        if ($swapping_model->delete($swap_uid)) {
                                            $result ['result'] = 'success';
                                            $result ['message'] = "Đã thực hiện hủy bỏ phiếu chuyển kho '{$swap_uid}' thành công!";
                                        } else {
                                            $result ['message'] = "Không thể hủy bỏ phiếu chuyển kho '{$swap_uid}'. Lỗi: {$swapping_model->getMessage()}";
                                        }
                                    }
                                } else {
                                    $result ['message'] = "Phiếu chuyển kho '{$swap_uid}' đã được hoàn tất";
                                }
                            } else {
                                $result ['message'] = "Bạn không có quyền xem thông tin phiếu chuyển kho '{$swap_uid}'";
                            }
                        } else {
                            $result ['message'] = "Không tìm thấy thông tin phiếu chuyển kho '{$swap_uid}'";
                        }
                    }
                    // end accept
                }// end check error

            } // end check role
        }//end delivery by kien
        //end kien


        // Delivery/Return item in swap token
        if (isset ($_POST ['swap_processing'])) {

            if (verify_access_right(current_account(), F_STORES_SWAP)) {
                // Get input data
                $item_uid = $_POST ['item_uid'];
                $action = $_POST ['action']; // Actions: 'delivery', 'return'
                $swap_type = $_POST ['swap_type']; // Type: 'single', 'multi'
                $note = $_POST ['note'];
                $tranh = new tranh();
                $tonkhosanxuat = new tonkhosanxuat();
                $chitietsanphammapping  = new chitietsanphammapping();
                // DB model
                $swapping_model = new items_swapping ();
                $swapping_detail_model = new items_swapping_detail ();
                $tonkho_model = new tonkho ();

                /*
                 * //For failed testing (start) $debugFlag = TRUE; if ($debugFlag) { $result ['result'] = "warning"; $tmp = array (); $tmp [] = array ( 'title' => "Cập nhật trạng thái của phiếu chuyển '123456'", 'error' => "ERROR 01" ); $tmp [] = array ( 'title' => "Thêm nhật ký nhập hàng ('{msg}')", 'error' => '$history->getMessage ()' ); $result ['detail'] = $tmp; $item_status = array (); $item_status ['flag'] = 0; $item_status ['note'] = '$swapping_detail->note'; $item_status ['uid'] = '$swapping_detail->uid'; $result ['item'] = $item_status; $token_status = array (); $token_status ['flag'] = 0; $result ['token'] = '$token_status'; echo json_encode ( $result ); exit (); } //For failed testing (end)
                 */

                // Single item
                if ($swap_type == "single") {
                    // Get item's detail
                    $swapping_detail = $swapping_detail_model->detail($item_uid);
                    if ($swapping_detail != NULL) {
                        $result = swap_items($swapping_detail, $action, $note);
                    } else {
                        $result ['message'] = "Không tìm thấy thông tin hạng mục '{$item_uid}'";
                    }
                } else { // Multi items

                    // Get swap token information
                    $swap = $swapping_model->detail($item_uid);
                    if ($swap != NULL) {
                        // Get detail list
                        $list = $swapping_detail_model->list_by_swapping($swap->swap_uid, FALSE);
                        if (($list == NULL) || (count($list) == 0)) {
                            $result ['message'] = "Không có hạng mục chờ nhận nào trong phiếu chuyển kho '{$swap->swap_uid}'";
                        } else {
                            // Initial values
                            $total = count($list); // Total processing items
                            $success = 0;
                            $items = array();
                            $token = NULL;
                            $detail = array(); // Detail message list

                            // Process each item in the list
                            foreach ($list as $swapping_detail) {
                                $arr = swap_items($swapping_detail, $action, $note, $swap);

                                if ($arr ['result'] == "error") {
                                    // Add to detail list
                                    $detail [] = array(
                                        'product_id' => $swapping_detail->product_id,
                                        'error' => $arr ['message']
                                    );
                                } else {
                                    // Count the success items
                                    $success++;

                                    // Get item status
                                    $items [] = $arr ['item'];

                                    // Get token status
                                    $token = $arr ['token'];

                                    // Warning message list
                                    $warning = $arr ['detail'];
                                    if (is_array($warning) && count($warning) > 0) {
                                        $tmp = array();
                                        foreach ($warning as $w) {
                                            $tmp [] = $w ['title'];
                                        }
                                        // Add to detail list
                                        $detail [] = array(
                                            'product_id' => $swapping_detail->product_id,
                                            'error' => implode("; ", $tmp)
                                        );
                                    }
                                }
                            }

                            // Output result
                            $result ['result'] = "success";
                            $msg = sprintf("Xử lý thành công %d/%d mã hàng.", $success, $total);
                            if (count($detail) > 0) {
                                $msg .= " Có một số lỗi xảy ra như sau:";
                            }
                            $result ['message'] = $msg;
                            $result ['detail'] = $detail;
                            $result ['item'] = $items;
                            if (is_array($token)) {
                                $result ['token'] = $token;
                            }
                        }
                    } else {
                        $result ['message'] = "Không tìm thấy thông tin phiếu chuyển kho '{$item_uid}'";
                    }
                }

                // Set type to output
                $result ['swap_type'] = $swap_type;
            }
        }

        // Update amount in store
        if (isset ($_POST ['update_amount'])) {
            if (verify_access_right(current_account(), F_STORES_AMOUNT_MANAGEMENT)) {
                // Get input data
                $product_id = $_POST ['product_id'];
                $store_id = $_POST ['store_id'];
                $amount = $_POST ['amount'];

                // DB model
                $tonkho_model = new tonkho ();

                if ($tonkho_model->is_exist($product_id, $store_id)) {
                    // Get remain amount
                    $remain_amount = $tonkho_model->so_luong_ton_kho($product_id, $store_id);

                    if ($remain_amount >= $amount) {
                        $done = FALSE;
                        // Remove item
                        if ($amount == $remain_amount) {
                            $done = $tonkho_model->xoa($product_id, $store_id);
                        } else { // Update amount of item
                            $done = $tonkho_model->cap_nhat_so_luong($product_id, $store_id, -$amount);
                        }

                        if ($done) {
                            // Warning messages
                            $warning = array();

                            // Add export history of destination store
                            $show_room = new khohang ();
                            $history = new import_export_history ();
                            $msg = sprintf(import_export_history::$MSG_AMOUNT_MANAGEMENT_DELETE, $amount, $remain_amount);
                            if ($history->add_new(current_account(), $product_id, $store_id, $amount, NULL, import_export_history::$TYPE_EXPORT, $msg, TRUE)) {
                                // Do nothing
                            } else {
                                $warning [] = array(
                                    'title' => "Thêm nhật ký xuất hàng ('{$msg}')",
                                    'error' => $history->getMessage()
                                );
                            }
                            // $tonkho_model->xoa_hang_muc_het_so_luong ();

                            /* Output result */
                            if (count($warning) > 0) {
                                $result ['result'] = "warning";
                                $result ['message'] = "Quá trình xử lý có một số lỗi như sau:";
                            } else {
                                $result ['result'] = "success";
                                $result ['message'] = "Thực hiện thao tác thành công";
                            }
                            $result ['detail'] = $warning;
                        } else {
                            $result ['message'] = $tonkho_model->getMessage();
                        }
                    } else {
                        $result ['message'] = "Số lượng tồn không đủ";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy hạng mục '{$product_id}' trong kho '{$store_id}'";
                }
            }
        }

        // Report a swapping token
        if (isset ($_POST ['report_swapping'])) {

            if (verify_access_right(current_account(), F_STORES_SWAP)) {
                // Get input data
                $swap_uid = $_POST ['swap_uid'];
                $action = $_POST ['action']; // action = 'accept' / 'cancel'
                $create_by = current_account();
                $create_date = current_timestamp();
                if (isset ($_POST ['swap_note'])) {
                    $swap_note = $_POST ['swap_note'];
                } else {
                    $swap_note = '';
                }

                // DB model
                $swapping_model = new items_swapping ();

                // Get swap token information
                $swap = $swapping_model->detail($swap_uid);
                if ($swap != NULL) {
                    // Check acces rights
                    $access = items_swapping::check_viewing_right(current_account(), $swap);

                    if ($access != 0) {
                        if ($swap->status == SWAPPING_DRAFT) {
                            if ($action == 'accept') {
                                $swap->status = SWAPPING_COMPLETED;
                                if ($swapping_model->update($swap)) {
                                    if ($swap_note <> '') {
                                        $db_model = new items_swapping_note ();
                                        $db_model->add_new($create_date, $create_by, $swap_uid, $swap_note);
                                    }

                                    // $th = new trahang();
                                    // $arr = $th->tim_kiem('','', $swap_uid);
                                    // if (is_array($arr)) {
                                    //     for ($i=0; $i < count($arr); $i++) { 
                                    //             $th->approved_maphieuchi($arr[$i]['maphieuchi']);
                                    //      }
                                    // }

                                    $result ['result'] = 'success';
                                    $result ['message'] = "Thực hiện hoàn tất phiếu chuyển kho '{$swap_uid}' thành công!";
                                } else {
                                    $result ['message'] = "Không thể hoàn tất phiếu chuyển kho '{$swap_uid}'. Lỗi: {$swapping_model->getMessage()}";
                                }
                            } elseif ($action == 'cancel') {
                                if ($swapping_model->delete($swap_uid)) {
                                    $result ['result'] = 'success';
                                    $result ['message'] = "Đã thực hiện hủy bỏ phiếu chuyển kho '{$swap_uid}' thành công!";
                                } else {
                                    $result ['message'] = "Không thể hủy bỏ phiếu chuyển kho '{$swap_uid}'. Lỗi: {$swapping_model->getMessage()}";
                                }
                            }
                        } else {
                            $result ['message'] = "Phiếu chuyển kho '{$swap_uid}' đã được hoàn tất";
                        }
                    } else {
                        $result ['message'] = "Bạn không có quyền xem thông tin phiếu chuyển kho '{$swap_uid}'";
                    }
                } else {
                    $result ['message'] = "Không tìm thấy thông tin phiếu chuyển kho '{$swap_uid}'";
                }
            }
        }

        // Create note for an item
        if (isset ($_POST ['create_note'])) {

            if (verify_access_right(current_account(), F_STORES_SWAP)) {
                // Get input data
                $swap_uid = $_POST ['swap_uid'];
                $message = $_POST ['message'];
                $created_by = current_account();
                $created_date = current_timestamp();

                // DB model
                $db_model = new items_swapping_note ();

                // Insert to database
                if ($db_model->add_new($created_date, $created_by, $swap_uid, $message)) {
                    $result ['result'] = 'success';
                    $result ['message'] = 'Success';
                    $result ['note'] = array('create_by' => $created_by, 'create_date' => $created_date, 'message' => $message);
                } else {
                    //$result ['message'] = $db_model->getMessage ();
                    $result ['message'] = $db_model->getQuery();
                }
            }
        }

    } catch (Exception $e) {
        $result ['result'] = "error";
        $result ['message'] = $e->getMessage();
    }
}

echo json_encode($result);
// echo $result ['detail'];
// ob_end_flush();
require_once '../part/common_end_page.php';
?>
