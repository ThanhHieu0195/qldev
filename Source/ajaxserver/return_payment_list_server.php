<?php
require_once '../part/common_start_page.php';
require_once '../models/donhang.php';

$output = array ();

if (verify_access_right ( current_account (), F_RETURN_WAITING )){

    if (isset($_REQUEST['del_return_payment'])) {
        $listdel = $_REQUEST['list_return'];
        require_once "../models/danhsachthuchi.php";
        $model = new listExpenses();
        $output['result'] = $model->reject_list($listdel);
    }

    if (isset($_REQUEST['detail_update'])) {
        $type = $_REQUEST ['type'];
      
        $id = $_REQUEST ['id'];

        $order_id = $_REQUEST ['donhangid'];
        $amount = $_REQUEST ['amount'];
        $cashing_type = $_REQUEST ['taikhoan'];
        $money_amount = intval($_REQUEST ['money_amount']);
        $cashed_by = current_account ();   

        // tạo phiếu chi
        $token_id = create_uid(FALSE);
        require_once "../models/finance_token.php";
        $model_finance_token = new finance_token();
        $model_finance_token_entity = new finance_token_entity();
        $model_finance_token_entity->assign(array('token_id' => $token_id, 'created_date'=>current_timestamp(), 'created_by' => $cashed_by, 'amount'=>1, 'token_type'=>'1', 'is_finished' => '0', 'approved'=>'0'));
        $continue = TRUE;
        $lasttoken = $model_finance_token->get_last_modified_token($cashed_by, FINANCE_PAYMENT);
        if (is_null($lasttoken)) {
            if($model_finance_token->insert($model_finance_token_entity) == 1) {
                $continue = TRUE;
            } else {
                $continue = FALSE;
            }
        } else {
            $token_id = $lasttoken;
        }
        if ($continue) {
            $output['maphieuchi'] = $token_id;
            // tạo chi tiết phiếu chi
            require_once "../models/chitiettrahang.php";
            require_once "../models/finance_token_detail.php";
            $model_ctth = new chitiettrahang();
            $model_ftd = new finance_token_detail();
                        
            // $product_id = RETURN_PRODUCT_ID;
            // $reference_id = RETURN_REFERENCE_ID;
            // $category_id = RETURN_CATEGORY_ID;
            // $item_id = RETURN_ITEM_ID;

            $product_id = $_REQUEST['product_id'];
            $reference_id = $_REQUEST['reference_id'];
            $category_id = $_REQUEST['category_id'];
            $item_id = $_REQUEST['item_id'];
            $note = $_REQUEST['note'];

            $output['flag'] = true;
            $model_ftd_e = new finance_token_detail_entity();
            $model_ftd_e->assign(array('uid'=>create_uid(), 'token_id'=>$token_id, 'reference_id' => $reference_id, 'madon'=>$order_id, 'product_id' => $product_id, 'item_id' => $item_id, 'perform_by' => $cashed_by, 'money_amount' => $money_amount, 'taikhoan' => $cashing_type, 'note'=>$note, 'perform_date' => current_timestamp()));
            
            if ($model_ftd->insert($model_ftd_e) == 1){
                $model_finance_token->add_new_item_token($token_id);
                $output['flag'] = $output['flag'] || true;
            } else {
                $output['flag'] = false;
            }

            if ($output['flag']) {
                // chia tiền cho nhân viên
                require_once "../models/employee_of_returns.php";
                //$model_eor = new employee_of_returns();
                //if ($model_eor->addEmployeeByOrder($return_id, $order_id)) {
                //    $output['flag'] = $output['flag'] || true;
                //} else {
                //    $output['flag'] = false;
                //}
            } else {
                $output['message'] = "Gặp lỗi trong quá trình thêm chi tiết phiếu chi";
            }

        } else {
                $output['flag'] = false;
        }

        // cập nhật phiếu trả hàng
        if ($output['flag'] && $type == "0") {
            require_once "../models/trahang.php";
            $model_th = new trahang();
            if ($model_th->update_maphieuchi($id, $token_id)) {
                 $output['result'] = "success";
            } else {
                $output['result'] = "error";
                $output['message'] = "Cập nhật phiếu trả hàng thất bại";
            }
        }

         // cập nhật phiếu trả hàng
        if ($output['flag'] && $type == "1") {
           require_once "../models/danhsachthuchi.php";
           $listExpenses = new listExpenses();
          
            if ( $listExpenses->update_status($id)) {
                 $output['result'] = "success";
            } else {
                $output['result'] = "error";
                $output['message'] = "Cập nhật khoan chi thất bại";
            }
        }

        
    }
    if (isset($_REQUEST['detail_delete'])) {
        require_once "../models/danhsachthuchi.php";
        $id = $_REQUEST ['id'];
        $type = $_REQUEST ['type'];
        if ($type == "1") {
            $listExpenses = new listExpenses();     
            if ( $listExpenses->deleteById($id)) {
                 $output['result'] = "success";
            } else {
                $output['result'] = "error";
                $output['message'] = "Cập nhật khoan chi thất bại";
            }
 
        }
    }
    
} 
echo json_encode($output);
require_once '../part/common_end_page.php';

/* End of file cash_server.php */
/* Location: ./ajaxserver/cash_server.php */


