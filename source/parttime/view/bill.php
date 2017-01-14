<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_SALE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Hóa đơn</title>
        <?php require_once '../part/cssjs.php'; ?>
    </head>
    <body>
        <div id="body-wrapper">
            <?php
            require_once '../part/menu.php';
            ?>
            <div id="main-content">
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <!-- //-- REQ20120508_BinhLV_N -->
                <?php
                include_once '../models/cart.php';
                include_once '../config/constants.php';
                include_once '../models/helper.php';
                include_once '../models/nhanvien.php';

                //Kiem tra so luong trong gio hang
                $cart = new Cart(CART_NAME);
                $cart->register();
                if ($cart->count() === 0)
                {
                    header('location: ../view/cart.php');
                    exit();
                }

                //Nhan nut 'Luu hoa don'
                if (isset($_POST['save']))
                {
                    $manv = current_account();                               //ma nhan vien
                    $makhach = $_POST['hotenkhach'];                         //ma khach
                    $tongtien = str_replace(",", "", $_POST['tongtien']);    //tong tien
                    $theophamtram = isset($_POST['checkboxpercent']) ? TRUE : FALSE;               //theo phan tram
                    $tiengiam = $_POST['tiengiam'];                          //tien giam
                    $thanhtien = str_replace(",", "", $_POST['thanhtien']);  //thanhtien
                    $duatruoc = str_replace(",", "", $_POST['duatruoc']);    //tien dua truoc
                    $conlai = str_replace(",", "", $_POST['conlai']);        //so tien con lai
                    $mahoadon = $_POST['mahoadon'];                          //ma hoa don
                    $henngaygiao = 'off';                                    //hen ngay giao hang

                    // kiểm tra bộ phận
                    $nv = new nhanvien();
                    $row = $nv->thong_tin_nhan_vien($manv);
                    $bophan = $row['bophan'];

                    if (isset($_POST['checkboxngaygiao']))
                        $henngaygiao = $_POST['checkboxngaygiao'];
                    $ngaygiao = $_POST['ngaygiao'];                          //ngay giao
                    $giogiao = $_POST['giogiao'];                          //ngay giao

                    if (empty($giogiao)) {
                        $giogiao = '23:00:00';
                    } else {
                        $giogiao .= ':00:00';
                    }  
                    $ghichu = $_POST['ghichu'];                              //ghi chu
                    // Hoa don do

                    if (!isset($_POST['hoadondo']) 
                        || empty($_POST['hoadondo'])
                        || $_POST['hoadondo'] == "") {
                        $hoadondo = "0";
                        $giatrihoadondo = "0";
                    }
                    else {
                        $hoadondo = $_POST['hoadondo'];
                        $giatrihoadondo = $_POST['giatrihoadondo'];
                    }

                    //Class thao tac CSDL
                    include_once '../models/donhang.php';
                    $db = new donhang();
                    date_default_timezone_set('UTC');

                    //Ngay dat la ngay hien tai
                    $ngaydat = date("Y-m-d");

                    //Trang thai don hang
                    $trangthai = donhang::$CHO_GIAO;                    
                    if ($henngaygiao === 'on')  //Neu co hen ngay giao
                    {
                        $trangthai = donhang::$CHO_GIAO;
                    }
                    else
                    {
                        $ngaygiao = date("Y-m-d");  //Ngay giao la ngay hien tai
                        $trangthai = donhang::$DA_GIAO;
                    }

                    if ( $_SESSION['phanbu'] ) {
                        $trangthai = donhang::$NOTCOMPLETE;
                    }

                    // Ngay can phai thu tien
                    if (!isset($_POST['cashing_date']) 
                        || empty($_POST['cashing_date'])
                        || $_POST['cashing_date'] == "") {
                        $ngay_can_thu_tien = $ngaygiao;
                    }
                    else {
                        $ngay_can_thu_tien = $_POST['cashing_date'];
                    }

                    //Neu tien giam tinh theo phan tram
                    $giamtheo = 0;
                    if ($theophamtram)
                        $giamtheo = donhang::$GIAM_THEO_PHAN_TRAM;

                    $query = $db->them_don_hang($mahoadon, $ngaydat, $ngaygiao, $giogiao, $tongtien, $tiengiam, $thanhtien, $duatruoc, $conlai, $manv, $makhach, $giamtheo, $trangthai, $ghichu, $ngay_can_thu_tien, $hoadondo, $giatrihoadondo);

                    //Neu luu hoa don len he thong thanh cong
                    if ($query)
                    {
                        //                sử lý attach
                        if ( isset($_FILES['attach']) ) {
                            $file_attach = $_FILES['attach'];
                            require_once "../models/support_process_excel.php";
                            require_once  "../models/bill_note.php";
                            $upload = uploadFile($file_attach, '', '../'.UPLOAD_FOLDER);
                            $format_attach = '<a href="%1$s" target="_blank">%2$s</a>';
                            if ($upload['result'] == 1) {
                                $bill_note = new bill_note();
                                $attach = sprintf($format_attach, $upload['location'], $file_attach['name']);
                                $bill_note->add_new(current_account(), $_POST['mahoadon'], $attach);
                            }
                        }

                        //Thong bao luu thanh cong
                        echo '<div class="notification success png_bg">';
                        echo '  <div>';
                        echo 'Đơn hàng <span style="font-weight: bold; color: blue;">' . $mahoadon . '</span> đã được lưu vào hệ thống. ';
                        echo 'Nhấn <a href="store.php" title="Về trang bán hàng">vào đây</a> để trở về trang bán hàng.';
                        echo '  </div>';
                        echo '</div>';
                        unset($_SESSION["ordernumber"]);

                        include_once '../models/chitietdonhang.php';
                        include_once '../models/tranh.php';
                        include_once '../config/constants.php';
                        include_once '../models/dathang.php';
                        include_once '../models/coupon_used.php';
                        include_once '../models/import_export_history.php';
                        require_once '../models/employee_group_members.php';
                        require_once '../models/employee_of_order.php';

                        include_once '../models/danhsachthuchi.php';
                        require_once '../models/hangkhachdat.php';
                        $hangkhachdat = new hangkhachdat();

                        // tienthicong
                        // tiencattham
                        // phuthugiaohang
                        // thutiengiumkhacsi
                        if (isset($_REQUEST['cb_tienthicong']) || isset($_REQUEST['cb_tiencattham']) || isset($_REQUEST['cb_phuthugiaohang']) || isset($_REQUEST['cb_thutiengiumkhacsi'])) {
                            $manv = current_account(); 
                            $tienthicong = 0;
                            $tiencattham=0;
                            $thutiengiumkhacsi=0;
                            $phuthugiaohang=0;

                            $listExpenses = new listExpenses();
                            $note = "";

                            if (isset($_REQUEST['cb_tienthicong'])) {
                                $sumExpenses = $_REQUEST['tienthicong'];
                                $note = TIENTHICONG;
                                $result = $listExpenses->insert('', $manv, $mahoadon, FINANCE_RECEIPT, $sumExpenses, $note, 0, 1);
                            } 

                            if (isset($_REQUEST['cb_tiencattham'])) {
                                $sumExpenses = $_REQUEST['tiencattham'];
                                $note = TIENCATTHAM;
                                $result = $listExpenses->insert('', $manv, $mahoadon, FINANCE_RECEIPT, $sumExpenses, $note, 0, 1);
                            } 
                            if (isset($_REQUEST['cb_phuthugiaohang'])) {
                                $sumExpenses = $_REQUEST['phuthugiaohang'];
                                $note = PHUTHUGIAOHANG;
                                $result = $listExpenses->insert('', $manv, $mahoadon, FINANCE_RECEIPT, $sumExpenses, $note, 0, 1);
                            } 

                            if (isset($_REQUEST['cb_thutiengiumkhacsi'])) {
                                $sumExpenses = $_REQUEST['thutiengiumkhacsi'];
                                $note = THUTIENGIUMKHACHSI;
                                $result = $listExpenses->insert('', $manv, $mahoadon, FINANCE_RECEIPT, $sumExpenses, $note, 0, 1);
                            } 
                        }

                        /* Luu thong tin chi tiet hoa don */
                        if ($cart->count() > 0)
                        {
                            $ctdh = new chitietdonhang();
                            $dathang = new dathang();
                            $history = new import_export_history();
                            $array = $cart->detail_list();
                            $list_assembly = $cart->detail_list_ASSEMBLY();
                            
                            foreach ($array as $value)
                            {
                                if($value['trangthai'] == chitietdonhang::$DAT_HANG)  // Neu la hang dat
                                {
                                    $tinhtrang = chitietdonhang::$CAN_SAN_XUAT;
                                    
                                    // Cap nhat ma hoa don trong bang dathang
                                    $dathang->cap_nhat_ma_don($value['masotranh'], $mahoadon);
                                }
                                else                                                  // Neu khong phai hang dat
                                {
                                    switch($trangthai)  // Xet trang thai cua don hang
                                    {
                                        case donhang::$CHO_GIAO:
                                            $tinhtrang = chitietdonhang::$CHO_GIAO;
                                        break;
                                        
                                        case donhang::$DA_GIAO:
                                            $tinhtrang = chitietdonhang::$DA_GIAO;
                                        break;
                                    }
                                }
                                
                                require_once "../models/loaitranh.php";
                                $lt = new loaitranh();
                                $row = $lt->chi_tiet_loai_tranh($value['maloai']);

                                $giavon = $value['giaban'];
                                if ($bophan == 0  && isset($row['giasi'])) {
                                    // $giavon = $value['giaban']*$row['giasi']/100;
                                    $giavon = $row['giasi'];
                                }

                                if ($bophan == 1 && isset($row['giale'])) {
                                    // $giavon = $value['giaban']*$row['giale']/100;
                                    $giavon = $row['giale'];
                                }
                                

                                $ctdh->them($mahoadon, $value['masotranh'], $value['makho'], $value['soluong'], $value['giaban'], $giavon, $tinhtrang);
                                
                                // Them lich su xuat hang
                                if($trangthai == donhang::$DA_GIAO)
                                {
                                    $history->add_new($manv, $value['masotranh'], $value['makho'], $value['soluong'], 
                                                      $mahoadon, import_export_history::$TYPE_EXPORT, 
                                                      import_export_history::$MSG_SELL);
                                }

                                if ( isset($list_assembly[ $value['masotranh'] ])) {
                                    $arr = $list_assembly[ $value['masotranh'] ];
                                    foreach ($arr as $obj) {
                                        $obj['soluong'] = intval($obj['soluong'])* intval($value['soluong']);
                                        $params = array($mahoadon, $value['masotranh'], $obj['machitiet'], $obj['soluong'], 0);
                                        $hangkhachdat->insert($params);
                                    }
                                }
                            }
                        }
                        $cart->clear();
                        
                        // Cap nhat lai bang 'coupon_used'
                        $data = array('bill_code' => $mahoadon);
                        $coupon_used = new coupon_used();
                        $coupon_used->update($_SESSION[COUPON_CODE], $data);
                        
                        // Xoa coupon code
                        unset ($_SESSION[COUPON_CODE]);
                        
                        /* Danh sach nguoi ban cua hoa don */
                        $members_model = new employee_group_members();
                        // Get input data
                        $groups = $_POST['groups'];
                        $members = $_POST['members'];
                        $sellers = array();
                        if (is_array($groups)) { // Group
                            foreach ($groups as $g) {
                                // Get employees in group
                                $arr = $members_model->list_members_of_group($g);
                                foreach ($arr['employee_id'] as $e) {
                                    if (array_search($e, $sellers) === FALSE) {
                                        $sellers[] = $e;
                                    }
                                }
                            }
                        }
                        if (is_array($members)) { // Members
                            foreach ($members as $e) {
                                if (array_search($e, $sellers) === FALSE) {
                                    $sellers[] = $e;
                                }
                            }
                        }
                        // Save list to databse
                        $employee_order_model = new employee_of_order();
                        foreach ($sellers as $s) {
                            $item = new employee_of_order_entity();
                            $item->order_id = $mahoadon;
                            $item->employee_id = $s;
                            if (!$employee_order_model->insert($item)) {
                                debug($employee_order_model->getMessage());
                                exit();
                            }
                        }
                        
                    }
                    //Khong them thong tin hoa don duoc
                    else
                    {
                        echo '<div class="notification error png_bg">';
                        echo '  <div>';
                        echo 'Có lỗi xảy ra: <span style="font-weight: bold; color: blue;">' . $db->_error . '</span>. ';
                        echo 'Đơn hàng <span style="font-weight: bold; color: blue;">' . $mahoadon . '</span> không được lưu vào hệ thống. ';
                        echo 'Nhấn <a href="pay.php" title="Về trang thanh toán">vào đây</a> để trở về trang thanh toán.';
                        echo '  </div>';
                        echo '</div>';
                    }
                }
                else
                {
                    header('location: ../view/pay.php');
                    exit();
                }
                ?>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
