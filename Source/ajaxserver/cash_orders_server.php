<?php
require_once '../part/common_start_page.php';
require_once '../models/donhang.php';
require_once "../models/finance_token_detail.php";
require_once "../models/finance_token.php";

$output = array ();
$output['message'] = array();
// verify_access_right ( current_account (), F_ORDERS_CASH_LIST )
if (verify_access_right ( current_account (), F_ORDERS_CASH_LIST )) {
    $order_id = $_REQUEST ['order_id']; // Mã hóa đơn
    $cashing_type = $_REQUEST ['cashing_type']; // Loại thu tiền
    $money_amount = intval($_REQUEST ['money_amount']);
    $cashed_by = current_account ();   
    $token_id = create_uid(FALSE);
    $created_date = current_timestamp();

    // cập nhật tiền
    $donhang = new donhang ();

    //if ($cashing_type == '0' || $cashing_type == '1' || $cashing_type == '2' || $cashing_type == '3' || $cashing_type == '4') {
        $result = $donhang->update_cash($order_id, $cashing_type, $money_amount, $cashed_by);
    //} else {
    //    $result = array("result"=>true, 'remain' => null, "cashed_money" => null, "total" => null);
    //}
    $continue = TRUE;

    // tạo phiếu thu
    if ($result ['result']) {
        $output['remain'] = $result ['remain'];
        $output['cashed'] = $result ['cashed_money'];
        $output['vat'] = $result ['vat'];
        $output['total'] = $result ['total'];
        $output['message'] = "Success";
    	$model_ft = new finance_token();
        $lasttoken = $model_ft->get_last_modified_token($cashed_by, FINANCE_RECEIPT);
        if (is_null($lasttoken)) {
            $item = array('token_id'=> $token_id,
                 'created_date'=> $created_date,
                 'created_by'=> $cashed_by,
                 'amount'=> '1',

                 'token_type'=> '0',
                 'is_finished'=> '0',
                 'approved'=> '0'
                 );
            $model_ft_e = new finance_token_entity();
            $model_ft_e->assign($item);
            if ($model_ft->insert($model_ft_e)) {
                $output['message'] = "Tạo thành công phiếu thu: {$token_id}";;
            } else {
                $output['message'] = "Không thể tạo phiếu thu";
                $continue = FALSE;
            }
        } else {
            $token_id = $lasttoken;
        }
        if ($continue) {
            // tạo chi tiết phiếu thu
            require_once "../models/danhsachthuchi.php";
            $listExpenses = new listExpenses();

            $uid = create_uid();
            $madon = $order_id;
            $reference_id = $_REQUEST['reference_id'];
            $product_id = $_REQUEST['product_id'];
            $item_id = $_REQUEST['item_id'];

            $perform_by = $cashed_by;
            $taikhoan = $_REQUEST ['taikhoan'];
            $note = "";

            if ($cashing_type == CASHED_TYPE_PARTLY) {
                $note = THUTIENMOTPHAN;
            } else if ($cashing_type == CASHED_TYPE_TIEN_COC) {
                $note = THUTIENCOC;
            } else if ($cashing_type == CASHED_TYPE_ALL) {
                $note = THUTIENTATCA;
            } else if ($cashing_type == CASHED_TYPE_VAT) {
                $note = THUTIENVAT;
            } else if ($cashing_type == CASHED_TYPE_TIENTHICONG) {
                $note = TIENTHICONG;
                $listExpenses->insert('', $cashed_by, $madon, 1, $money_amount, CHITIENTHICONG, 0, 1);
            } else if ($cashing_type == CASHED_TYPE_TIENCATTHAM) {
                $note = TIENCATTHAM;
                $listExpenses->insert('', $cashed_by, $madon, 1, $money_amount, CHITIENCATTHAM, 0, 1);
            } else if ($cashing_type == CASHED_TYPE_PHUTHUGIAOHANG) {
                $note = PHUTHUGIAOHANG;
            } else if ($cashing_type == CASHED_TYPE_THUTIENGIUMKHACHSI) {
                $note = THUTIENGIUMKHACHSI;
                $listExpenses->insert('', $cashed_by, $madon, 1, $money_amount, CHITIENTRAKHACHSI, 0, 1);
            }
            $perform_date = $created_date;
            // array('uid'=> , 'token_id'=> , 'reference_id'=> , 'madon'=> , 'product_id'=> , 'item_id'=> , 'perform_by'=> , 'money_amount'=> , 'taikhoan'=> , 'note'=> , 'perform_date'=> );
            $model_ftd = new finance_token_detail();
            $model_ftd_e = new finance_token_detail_entity();
            $item = array('uid'=> $uid, 'token_id'=> $token_id, 'reference_id'=> $reference_id, 'madon'=> $madon, 'product_id'=> $product_id, 'item_id'=> $item_id, 'perform_by'=> $perform_by, 'money_amount'=> $money_amount, 'taikhoan'=> $taikhoan, 'note'=> $note, 'perform_date'=> $perform_date);
            $model_ftd_e->assign($item);

            if ($model_ftd->insert($model_ftd_e)==1) {
                if ($cashing_type == CASHED_TYPE_TIENTHICONG || $cashing_type == CASHED_TYPE_TIENCATTHAM || $cashing_type == CASHED_TYPE_PHUTHUGIAOHANG || $cashing_type == CASHED_TYPE_THUTIENGIUMKHACHSI) {

                    $listExpenses->updateStatus($madon, $note);
                }
                $model_ft->add_new_item_token($token_id);

                $output['result'] = "success";
            } else {
                $output['result'] = "error";
            }
        } else {
            $output['result'] = "error";
            $output['message'][] = "Tạo phiếu thu thất bại";
        }
    	
    }else {
        $output['result'] = "error";
        $output['message'][] = $result['message'];
    }

   
} else {
    $output ['message'] = 'Không có quyền thu tiền';
    $output ['result'] = "error";
}

echo json_encode ( $output );

require_once '../part/common_end_page.php';

/* End of file cash_server.php */
/* Location: ./ajaxserver/cash_server.php */
