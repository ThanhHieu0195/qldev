<?php
require_once '../part/common_start_page.php';

$output = array ();
$output ['result'] = 0;
$output ['data'] = array ();
$output ['d'] = array ();

if (verify_access_right ( current_account (), F_ORDERS_DELIVERY )) {
    if (isset($_REQUEST['action'])) {
        $do = $_REQUEST['do'];
        if ($do == 'addEmployeetoDelivery') {
            require_once "../models/deliver.php";
            // Authenticate
            $model = new deliver();

            $employees = $_REQUEST['employees'];

            $isBill = 0;

            if (isset($_REQUEST['isBill'])) {
                $isBill = $_REQUEST['isBill'];
            } 

            $money = $_REQUEST['money'];
            $orders = $_REQUEST['orders'];

            $money_deliver = floatval($money)/(count($employees)*count($orders));
            $money_deliver = intval($money_deliver);

            $output['money_deliver'] = $money_deliver;

            // thêm data vào bảng giaohang
            for ($i=0; $i < count($orders); $i++) { 
                # code...
                $order_id = $orders[$i];
                #$model->delete($order_id);
                for ($j=0; $j < count($employees); $j++) { 
                    $employee_id = $employees[$j];
                    $model->insert($order_id, $employee_id, $money_deliver);
                }
            }

            if ($isBill == 1) {
                require_once "../models/danhsachthuchi.php";
                $moneyBill = floatval($money)/count($orders);
                $moneyBill = intval($moneyBill);
                $listExpenses = new listExpenses();

                $employee_id = current_account();
                for ($i=0; $i < count($orders); $i++) { 
                    $order_id = $orders[$i];
                    $output ['d'][] = $listExpenses->insert('', $employee_id, $order_id, 1, $moneyBill,"APPROVED:Chi tiền giao hàng", 0, 1);
                }
            }

            $output['result'] = 'success';
        }
    } else {
         // Mã sản phẩm
        $masotranh = $_REQUEST ['masotranh'];
        // Số lượng cần giao
        $soluong = $_REQUEST ['soluong'];
        
        $sql = "SELECT makho, tenkho 
                FROM khohang 
                WHERE makho IN (SELECT makho FROM tonkho WHERE masotranh = '$masotranh' AND soluong >= $soluong)
                ORDER BY tenkho";
        
        $db = new database ();
        $db->setQuery ( $sql );
        $arr = $db->loadAllRow ();
        $db->disconnect ();
        
        if (is_array ( $arr ) && count ( $arr ) > 0) {
            $output ['result'] = 1;
            $output ['data'] = $arr;
        }
    }
}

echo json_encode ( $output );

require_once '../part/common_end_page.php';

/* End of file delivery_server.php */
/* Location: ./ajaxserver/delivery_server.php */
