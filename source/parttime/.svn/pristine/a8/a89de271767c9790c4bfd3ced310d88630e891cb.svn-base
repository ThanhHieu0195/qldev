<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( '', '', FALSE );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Export 2 Excel</title>
    <? require_once '../part/cssjs.php'; ?>
    <style type="text/css">
#download {
    vertical-align: middle;
    padding-right: 5px;
}
</style>
</head>
<body>
    <div id="body-wrapper">
        <? require_once '../part/menu.php'; ?>
        <div id="main-content">
            <noscript>
                <div class="notification error png_bg">
                    <div>
                        Javascript is disabled or is not supported by your browser. Please
                        <a href="http://browsehappy.com/"
                            title="Upgrade to a better browser">upgrade</a> your browser or <a
                            href="http://www.google.com/support/bin/answer.py?answer=23852"
                            title="Enable Javascript in your browser">enable</a> Javascript
                        to navigate the interface properly.
                    </div>
                </div>
            </noscript>

            <?php
            $valid = TRUE;
            
            if ((isset ( $_REQUEST ["do"] )) && ($_REQUEST ["do"] == "export") && (isset ( $_REQUEST ["table"] ))) {
                require_once 'excel.php';
                require_once '../models/helper.php';
                
                $table = $_REQUEST ["table"];
                $excel = new excel ();
                $xls_folder = "xls-data/";
                $filename = $xls_folder . $table . ".xls";
                $format = "../excelfiles/%s.xls";
                
                switch ($table) {
                    
                    // Danh sach san pham dat hang can san xuat
                    case "dathang" :
                        if (verify_access_right ( current_account (), F_ORDERS_TP )) {
                            require_once '../models/dathang.php';
                            
                            $dathang = new dathang ();
                            $data = $dathang->danh_sach ( TRUE );
                            $fieldlist = $dathang->danh_sach_column ();
                            $filename = sprintf ( $format, 'San pham dat hang' );
                            $excel->export_custom_data ( $filename, $data, $fieldlist );
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Danh sach khach hang cua cong ty
                    case "danhsachkhachhang" :
                        if (verify_access_right ( current_account (), F_GUEST_GUEST_LIST )) {
                            require_once '../models/khach.php';
                            
                            $nhomkhach = isset($_REQUEST["nhomkhach"]) ? $_REQUEST["nhomkhach"] : -1;
                            $khach = new khach ();
                            $data = $khach->danh_sach_tong_hop ($nhomkhach);
                            $fieldlist = $khach->danh_sach_column ();
                            $filename = sprintf ( $format, 'Danh sach khach hang' );
                            $excel->export_custom_data ( $filename, $data, $fieldlist );
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Danh sach san pham cua mot kho hang
                    case "danhsachtranh" :
                        $valid = FALSE;
                        if (verify_access_right ( current_account (), F_STORES_ITEM_OF_STORE )) {
                            require_once '../models/tranh.php';
                            require_once '../models/khohang.php';
                            
                            if (isset ( $_REQUEST ["store"] )) {
                                $makho = $_REQUEST ["store"];
                                $khohang = new khohang ();
                                $filename = sprintf ( $format, 'Danh sach san pham kho hang ' . unicode_to_ascii ( $khohang->ten_kho ( $makho ) ) );
                                $data = $khohang->danh_sach_tong_hop ( $makho );
                                $fieldlist = $khohang->danh_sach_column ();
                                $excel->export_custom_data ( $filename, $data, $fieldlist );
                                
                                $valid = TRUE;
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Doanh thu hang ngay (trong mot khoang thoi gian) cua mot showroom
                    case "showroom" :
                        if (verify_access_right ( current_account (), F_VIEW_TRADE_ADMIN )) {
                            require_once '../models/doanhthu.php';
                            require_once '../models/khohang.php';
                            
                            $id = $_REQUEST ["id"];
                            $from = $_REQUEST ["from"];
                            $to = $_REQUEST ["to"];
                            
                            $khohang = new khohang ();
                            $filename = sprintf ( $format, 'Doanh thu showroom ' . unicode_to_ascii ( $khohang->ten_kho ( $id ) ) );
                            $db = new doanhthu ();
                            $data = $db->tong_hop_doanh_thu ( $id, $from, $to, TRUE );
                            $fieldlist = $db->danh_sach_column ( $data );
                            $excel->export_custom_data ( $filename, $data, $fieldlist );
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Thong ke chenh lech so luong
                    case "chenhlech" :
                        if (verify_access_right ( current_account (), F_ORDERS_DIFFERENCE )) {
                            require_once '../models/tonkho.php';
                            
                            $ton_kho = new tonkho ();
                            $filename = sprintf ( $format, 'Thong ke so luong chenh lech' );
                            $data = $ton_kho->thong_ke_so_luong_chenh_lech ();
                            $fieldlist = array (
                                    'masotranh',
                                    'tentranh',
                                    'loaitranh',
                                    'soluongton',
                                    'soluongmua',
                                    'soluongcan' 
                            );
                            $column_names = $ton_kho->danh_sach_column_chenh_lech ();
                            $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Danh sach san pham (muc Quan ly san pham)
                    case "danhsachsanpham" :
                        if (verify_access_right ( current_account (), F_ITEMS_LIST )) {
                            require_once '../models/tranh.php';
                            
                            $tranh = new tranh ();
                            $filename = sprintf ( $format, 'Danh sach san pham' );
                            $data = $tranh->danh_sach_san_pham_export ();
                            $fieldlist = $tranh->danh_sach_field_export ();
                            $column_names = $tranh->danh_sach_column_export ();
                            $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Thong ke coupon assign hang ngay
                    case "couponassign" :
                        if (verify_access_right ( current_account (), F_COUPON_ASSIGN_LIST )) {
                            require_once '../models/coupon_assign.php';
                            
                            $coupon_assign = new coupon_assign ();
                            
                            $date = $_REQUEST ["date"];
                            $filename = sprintf ( $format, 'Danh sach coupon assign ' . $date );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $coupon_assign->assign_list ( $date, TRUE, $fieldlist, $column_names );
                            $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names, array (
                                    'Assign mới',
                                    'Giới thiệu',
                                    'Cộng tác viên' 
                            ) );
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Nhat ky nhap xuat hang
                    case "import_export" :
                        if (verify_access_right ( current_account (), F_ITEMS_HISTORY )) {
                            require_once '../models/import_export_history.php';
                            
                            $history = new import_export_history ();
                            
                            $from = $_REQUEST ["from"];
                            $to = $_REQUEST ["to"];
                            $showroom = $_REQUEST ["showroom"];
                            $filename = sprintf ( $format, sprintf ( 'Nhat ky nhap xuat hang %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $history->history_list ( $from, $to, $showroom, TRUE, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Don hang da giao
                    case "orderdelivered" :
                        if (verify_access_right ( current_account (), F_ORDERS_ORDER_DELIVERED )) {
                            require_once '../models/donhang.php';
                            
                            $donhang = new donhang ();
                            
                            $from = $_REQUEST ["from"];
                            $to = $_REQUEST ["to"];
                            $filename = sprintf ( $format, sprintf ( 'Don hang da giao %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();

                            $data = $donhang->order_statistic ( $from, $to, donhang::$DA_GIAO, TRUE, $fieldlist, $column_names );

                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    // Don hang cho thu tien
                    case "cashinglist" :
                        if (verify_access_right ( current_account (), F_ORDERS_CASH_LIST )) {
                            require_once '../models/donhang.php';
                        
                            $donhang = new donhang ();
                        
                            $from = $_REQUEST ["from"];
                            $to = $_REQUEST ["to"];
                            $filename = sprintf ( $format, sprintf ( 'Don hang cho thu tien %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $donhang->cashing_list ( $from, $to, TRUE, $fieldlist, $column_names );                    
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    // Doanh so theo don hang da giao
                    case "orderdelivered_sellers" :
                        if (verify_access_right ( current_account (), F_ORDERS_ORDER_DELIVERED )) {
                            require_once '../models/donhang.php';
                            require_once '../models/trahang.php';

                            
                            $donhang = new donhang ();
                            
                            $from = $_REQUEST ["from"];
                            $to = $_REQUEST ["to"];
                            $type = $_REQUEST ["type"];

                            $filename = sprintf ( $format, sprintf ( 'Doanh so %s_%s', $from, $to ) );

                            $fieldlist = array ();
                            $column_names = array ();

                            $data = $donhang->order_statistic_by_employees ( $from, $to, donhang::$DA_GIAO, $type);
                            // print_r($data);

                            // thêm data trả hàng
                            $th = new trahang();
                            $arr = $th->export_doanhso($from, $to, $type);
                            for ($i=0; $i < count($arr); $i++) { 
                                $row = $arr[$i];
                                if ($row) {
                                    $data[] = $arr[$i];
                                }
                            }
                            // print_r($arr);
                            
                            if ($data != NULL) {
                                //error_log ("HUAN EXPORT 1111111 " . serialize($data), 3, '/var/log/phpdebug.log');
                                $field_list = array('tennv', 'madon', 'hoten', 'ngaydat', 'ngaygiao', 'thanhtien', 'giavon', 'tienlai');
                                $column_name = array('Nhân viên', 'Mã hóa đơn', 'Khách hàng', 'Ngày đặt', 'Ngày giao', 'Doanh số', 'Giá vốn', 'Tiền lãi');
                                $excel->export_custom_data ( $filename, $data, $field_list, $column_name);
                            }
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Thong ke thu tien
                    case "cash_statistic" :
                        if (verify_access_right ( current_account (), F_ORDERS_CASH_STATISTIC )) {
                            require_once '../models/donhang.php';
                            
                            $donhang = new donhang ();
                            
                            $from = $_REQUEST ["from"];
                            $to = $_REQUEST ["to"];
                            $filename = sprintf ( $format, sprintf ( 'Thong ke thu tien %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $donhang->cash_statistic ( $from, $to, TRUE, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Tong hop doanh thu moi cong tac vien
                    case "freelancer-statistic" :
                        if (verify_access_right ( current_account (), F_COUPON_FREELANCER_STATISTIC )) {
                            require_once '../models/coupon_used.php';
                            
                            $coupon_used = new coupon_used ();
                            
                            $account = (isset ( $_REQUEST ['account'] )) ? $_REQUEST ['account'] : current_account ();
                            $uid = (isset ( $_REQUEST ['uid'] )) ? $_REQUEST ['uid'] : current_account ( UID );
                            $from = $_REQUEST ['from'];
                            $to = $_REQUEST ['to'];
                            
                            $filename = sprintf ( $format, sprintf ( 'Doanh thu CTV %s %s_%s', $account, $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $coupon_used->freelancer_statistic_export ( $uid, $from, $to, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names, array (
                                        'Doanh thu đơn hàng chờ giao',
                                        'Doanh thu đơn hàng đã giao' 
                                ) );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Tong hop doanh thu cac cong tac vien
                    case "freelancer-statistic-list" :
                        if (verify_access_right ( current_account (), F_COUPON_FREELANCER_STATISTIC_ALL )) {
                            require_once '../models/coupon_used.php';
                            
                            $coupon_used = new coupon_used ();
                            
                            $from = $_REQUEST ['from'];
                            $to = $_REQUEST ['to'];
                            
                            $filename = sprintf ( $format, sprintf ( 'Doanh thu cua cac CTV %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $coupon_used->freelancer_statistic_list_export ( $from, $to, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names, array (
                                        'Doanh thu đơn hàng chờ giao',
                                        'Doanh thu đơn hàng đã giao' 
                                ) );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // (Quan ly cong viec) Thong ke Tong diem
                    case "task-statistic-list" :
                        if (verify_access_right ( current_account (), F_TASK_STATISTIC )) {
                            require_once '../models/task_result_category.php';
                            require_once '../models/task_result.php';
                            
                            $model = new task_result ();
                            
                            $from = $_REQUEST ['from'];
                            $to = $_REQUEST ['to'];
                            
                            $filename = sprintf ( $format, sprintf ( 'Tong hop diem %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $data = $model->statistic_list ( $from, $to, TRUE, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // (Quan ly cong viec) Thong ke Diem trung binh
                    case "task-average-list" :
                        if (verify_access_right ( current_account (), F_TASK_STATISTIC )) {
                            require_once '../models/task_result_category.php';
                            require_once '../models/task_result.php';
                            
                            $model = new task_result ();
                            
                            $from = $_REQUEST ['from'];
                            $to = $_REQUEST ['to'];
                            
                            $filename = sprintf ( $format, sprintf ( 'Tong hop diem trung binh %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $data = $model->average_list ( $from, $to, TRUE, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // (Quan ly cong viec) Danh sach Xong toan bo
                    case "task-completed-list" :
                        if (verify_access_right ( current_account (), F_TASK_LIST_ALL )) {
                            require_once '../models/task.php';
                            
                            $model = new task ();
                            
                            $from = $_REQUEST ['from'];
                            $to = $_REQUEST ['to'];
                            
                            $filename = sprintf ( $format, sprintf ( 'Danh sach viec xong toan bo %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $data = $model->completed_list ( $from, $to, TRUE, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // (Ghi nhan va dong gop) Thong ke
                    case "rewards-statistic-list" :
                        if (verify_access_right ( current_account (), F_REWARDS_PENALTY_STATISTIC_LIST )) {
                            require_once '../models/rewards_penalty.php';
                            
                            $model = new rewards_penalty ();
                            
                            $from = $_REQUEST ['from'];
                            $to = $_REQUEST ['to'];
                            
                            $filename = sprintf ( $format, sprintf ( 'Tong hop khen thuong ky luat %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $data = $model->statistic_list ( $from, $to, TRUE, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // (Quan ly lich lam viec) Lich nghi phep -> Thong ke
                    case "leave-days-statistic-list" :
                        if (verify_access_right ( current_account (), F_WORKING_CALENDAR_LEAVE_DAYS_STATISTIC )) {
                            require_once '../models/working_calendar.php';
                            
                            $model = new working_calendar ();
                            
                            $from = $_REQUEST ['from'];
                            $to = $_REQUEST ['to'];
                            
                            $filename = sprintf ( $format, sprintf ( 'Tong hop ngay nghi %s_%s', $from, $to ) );
                            $fieldlist = array ();
                            $column_names = array ();
                            $data = $data = $model->leave_days_statistic_list ( $from, $to, TRUE, $fieldlist, $column_names );
                            if ($data != NULL)
                                $excel->export_custom_data ( $filename, $data, $fieldlist, $column_names );
                            else {
                                echo '<h3>Không có data để export!</h3>';
                            }
                        } else {
                            $valid = FALSE;
                        }
                        break;
                    
                    // Default
                    default :
                }
            } else {
                $valid = FALSE;
            }
            
            if (! $valid) {
                redirect ( "../part/access_forbidden.php" );
            }
            ?>

            <? require_once '../part/footer.php'; ?>
        </div>
    </div>
</body>
</html>
<?php
require_once '../part/common_end_page.php';
?>
