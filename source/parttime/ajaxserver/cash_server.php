<?php
require_once '../part/common_start_page.php';
require_once '../models/donhang.php';

$output = array ();

if (verify_access_right ( current_account (), F_ORDERS_CASH_LIST )){
    if (isset($_REQUEST['detail_update'])) {
        $return_id = $_REQUEST ['trahangid'];
        $order_id = $_REQUEST ['donhangid'];
        $cashing_type = $_REQUEST ['taikhoan'];
        $money_amount = intval($_REQUEST ['money_amount']);
        $cashed_by = current_account ();   

        // tạo phiếu chi
        $token_id = create_uid();
        require_once "../models/finance_token.php";
        $model_finance_token = new finance_token();
        $model_finance_token_entity = new finance_token_entity();
        $model_finance_token_entity->assign(array('token_id' => $token_id, 'created_date'=>current_timestamp(), 'created_by' => $cashed_by, 'amount'=>$money_amount, 'token_type'=>'1', 'is_finished' => '1', 'approved'=>'1'));

        if($model_finance_token->insert($model_finance_token_entity) == 1) {
            $output['maphieuchi'] = $token_id;
            // tạo chi tiết phiếu chi
            require_once "../models/chitiettrahang.php";
            require_once "../models/finance_token_detail.php";
            $model_ctth = new chitiettrahang();
            $model_ftd = new finance_token_detail();
            $product_id = '53b213f154da7';
            $reference_id = '57bad3dc209ab';
            $category_id = 'CP0015';
            $item_id = '57cd50b464d68';

            $data_th = $model_ctth->laythongtin($return_id);
            $output['flag'] = true;
            for ($i=0; $i < count($data_th); $i++) { 
                # code...
                $obj = $data_th[$i];
                $model_ftd_e = new finance_token_detail_entity();
                $model_ftd_e->assign(array('uid'=>create_uid(), 'token_id'=>$token_id, 'reference_id' => $reference_id, 'madon'=>$obj['madon'], 'product_id' => $product_id, 'item_id' => $item_id, 'perform_by' => $cashed_by, 'money_amount' => $obj['giaban'], 'taikhoan' => $taikhoan, 'note'=>"", 'perform_date' => current_timestamp()));
                if ($model_ftd->insert($model_ftd_e) == 1){
                    $output['flag'] = $output['flag'] || true;
                } else {
                    $output['flag'] = false;
                }
            }
            if ($output['flag']) {
                // chia tiền cho nhân viên
                require_once "../models/employee_of_returns.php";
                $model_eor = new employee_of_returns();
                if ($model_eor->addEmployeeByOrder($return_id, $order_id)) {
                    $output['flag'] = $output['flag'] || true;
                } else {
                    $output['flag'] = false;
                }
            } else {
                $output['message'] = "Gặp lỗi trong quá trình thêm chi tiết phiếu chi";
            }

        } else {
                $output['flag'] = false;
        }

        // cập nhật phiếu trả hàng
        if ($output['flag']) {
            require_once "../models/trahang.php";
            $model_th = new trahang();
            if ($model_th->update_maphieuchi($return_id, $token_id)) {
                 $output['result'] = "success";
            } else {
                $output['result'] = "error";
                $output['message'] = "Cập nhật phiếu trả hàng thất bại";
            }
        }
        
    }
    
} 
echo json_encode($output);
require_once '../part/common_end_page.php';

/* End of file cash_server.php */
/* Location: ./ajaxserver/cash_server.php */