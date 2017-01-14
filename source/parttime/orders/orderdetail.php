<?php
require_once '../part/common_start_page.php';
require_once "../models/deliver.php";
require_once "../models/danhsachthuchi.php";
// Authenticate
do_authenticate(G_ORDERS, '', TRUE);
$model_deliver = new deliver();
$listExpenses = new listExpenses();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Chi tiết đơn hàng</title>
    <?php
    require_once '../part/cssjs.php';
    ?>
    <style type="text/css" title="currentStyle">
        @import "../resources/css/practical.css3.tables.css";
        img { vertical-align: middle; }
    </style>
    <link rel="stylesheet" href="../resources/chosen/chosen.css">
    <style type="text/css">
        #order_detail tbody tr.alt-row { background: none; }
        #fchonkhohang {
            background-color: white;
            padding: 20px;
        }
        #fchonkhohang select {
            width: 100px !important;
        }
    </style>

    <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
    <!-- jQuery.bPopup -->
    <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
    <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
    <script type="text/javascript" src="../resources/stickytooltip/stickytooltip.js"></script>
    <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
    <script type="text/javascript" src="../resources/scripts/utility/orderdetail.js"></script>
    <script type="text/javascript" charset="utf-8">
        jQuery(document).ready(function($) {
            $('.chosen-select').chosen();
//            giao hang phan bu
            $('a[action="deliver-premium"]').click(function(){
                var row = $(this);
                var masotranh = row.attr('data-masotranh');
                var machitiet = row.attr('data-machitiet');
                var is_ok = confirm('Giao hàng: '+machitiet);
                if (is_ok == true) {
                    var data = {ACCESS_AJAX:1, MODEL: 'chitietphanbu', FUNCTION:'deliver', DATA:{condition:{madonhang:madon, machitiet:machitiet, masotranh:masotranh} } };
                    var path = "../ajaxserver/ajax_model.php";
                    $.ajax({
                        url: path,
                        type: 'POST',
                        dataType: 'text',
                        data: data,
                    })
                    .done(function(res) {
                        json = jQuery.parseJSON(res);
                        if ( json.result == true) {
                            alert('Thao tác thành công!');
                            row.remove();

                        } else {
                            alert('Thao tác thất bại');
                        }
                    });
                }

            });
//            hoan thanh cong viec
            $('a[action="complete-order"]').click(function(){
                var is_ok = confirm("Hoàn thành đơn hàng");
                if (is_ok == true) {
                    var data = {ACCESS_AJAX:1, MODEL: 'donhang', FUNCTION:'cap_nhat_trang_thai', DATA:{madon:madon, trangthai:0} };
                    var path = "../ajaxserver/ajax_model.php";
                    $.ajax({
                        url: path,
                        type: 'POST',
                        dataType: 'text',
                        data: data,
                    })
                    .done(function(res) {
                        json = jQuery.parseJSON(res);
                        if ( json.result == true) {
                            alert('Thao tác thành công!');
                            window.location = "";
                        } else {
                            alert('Thao tác thất bại');
                        }
                    });
                }
            });
//          hien dialog add them row table chi tiet phan bu
            $('a[action="show-premium-dialog"]').click(function(){
                var masotranh = $(this).attr('data_masotranh');
                $('#premium-dialog input[name="masotranh"]').val(masotranh);
                $('#premium-dialog input[name = "dai"]').val(0);
                $('#premium-dialog input[name = "cao"]').val(0);
                $('#premium-dialog input[name = "rong"]').val(0);
                $('#premium-dialog input[name = "sluong"]').val(0);
                $('#premium-dialog select[name = "danchi"]').val(0);
                $('#premium-dialog select[name = "makhoan"]').val(0);
                $('#premium-dialog select[name = "mavan"]').val(0);
                $('#premium-dialog').dialog('open');

            });
//            xoa row cua table chi tiet phan bu
            $('a[action="del-row-premium"]').live('click', function() {
                console.log(this);
                var row = $(this);
                var masotranh = row.attr('data-masotranh');
                var machitiet = row.attr('data-machitiet');
                var is_ok = confirm(' Xoá hàng mã chi tiết: '+machitiet);
                if (is_ok) {
                    var data = {ACCESS_AJAX:1, MODEL: 'chitietphanbu', FUNCTION:'delete', DATA:{condition:{ madonhang:madon, masotranh:masotranh, machitiet:machitiet } } };
                    var path = "../ajaxserver/ajax_model.php";
                    $.ajax({
                        url: path,
                        type: 'POST',
                        dataType: 'text',
                        data: data,
                    })
                    .done(function(res) {
                        json = jQuery.parseJSON(res);
                        if ( json.result == true) {
                            alert('Thao tác thành công!');
                            $('tr').has(row).remove();
                        } else {
                            alert('Thao tác thất bại');
                        }
                    });
                }
            });

            $('#premium-dialog input[name = "dai"]').numeric({allow:"."});
            $('#premium-dialog input[name = "rong"]').numeric({allow:"."});
            $('#premium-dialog input[name = "cao"]').numeric({allow:"."});
            $('#premium-dialog input[name = "sluong"]').numeric();
            $( "#premium-dialog" ).dialog({
                autoOpen: false,
                resizable: false,
                modal: true,
                buttons: {
                    OK: function() {
                        row = $(this);
                        var masotranh   = row.children().find('input[name = "masotranh"]').val();
                        var machitiet   = row.children().find('input[name = "machitiet"]').val();
                        var dai         = row.children().find('input[name = "dai"]').val();
                        var rong        = row.children().find('input[name = "rong"]').val();
                        var cao         = row.children().find('input[name = "cao"]').val();
                        var danchi      = row.children().find('select[name = "danchi"]').val();
                        var makhoan     = row.children().find('select[name = "makhoan"]').val();
                        var mavan       = row.children().find('select[name = "mavan"]').val();
                        var soluong     = row.children().find('input[name = "sluong"]').val();
                        var trangthai   = 0;
                        if (machitiet == "" || masotranh == "" || madon == "") {
                            alert('Thông số rỗng!');
                        } else {
                            var data = {ACCESS_AJAX:1, MODEL: 'chitietphanbu', FUNCTION:'insert', DATA:{param:[madon, masotranh, machitiet, dai, rong, cao, danchi, makhoan, mavan, soluong, trangthai]}};
                            var path = "../ajaxserver/ajax_model.php";
                            $.ajax({
                                url: path,
                                type: 'POST',
                                dataType: 'text',
                                data: data,
                            })
                                .done(function(res) {
                                    json = jQuery.parseJSON(res);
                                    if ( json.result == true) {
                                        alert('Thao tác thành công!');
                                        var tbody =  $('#table__phanbu tbody');
                                        var html = tbody.html();
                                        if ( tbody.length == 0 ) {
                                            window.location = "";
                                        } else {
                                            var format_row = "<tr> <td>{0}</td> <td>{1}</td> <td>{2}</td> <td>{3}</td> <td>{4}</td> <td>{5}</td> <td>{6}</td> <td>{7}</td> <td>{8}</td> </tr>";
                                            var html_row = '';
                                            var format_btn_del = "<a href=\"javascript:void(0)\" title=\"Xóa\" action=\"del-row-premium\" data-masotranh=\"{0}\" data-machitiet=\"{1}\">Xóa</a>";
                                            var btn_del = String.format(format_btn_del, masotranh, machitiet);
                                            html_row = String.format(format_row, machitiet, dai, rong, cao, danchi, makhoan, mavan, soluong, btn_del);
                                            html += html_row;

                                            $('#table__phanbu tbody').html(html);
                                            $(row).dialog("close");
                                        }
                                    } else {
                                        alert('Thao tác thất bại');
                                    }
                                });
                        }
                    }
                }
            });
        });
        // Kiểm tra tính hợp lệ của các dữ liệu
        function validatecb(name) {
            if (!$("input[name='cb_"+name+"']").is(':checked')) {
                $("input[name='"+name+"']").val(0);
                $("input[name='"+name+"']").attr('readonly', true);
            } else {
                $("input[name='"+name+"']").attr('readonly', false);
            }
        }
        function checkValidData() {
            var isValid = true;
            var checked = $("#checkboxpercent").attr("checked");
            var tongtien = stripNonNumeric($("#tongtien").val());
            var tiengiam = $("#tiengiam").val();
            var duatruoc = $("#duatruoc").val();
            var error_1 = $("#error-1");

            error_1.text("");
            if(tiengiam=="" || isNaN(tiengiam)) {
                error_1.text("*Nhập vào số tiền giảm hợp lệ");
                isValid = false;
            }
            else {
                //Kiem tra mien gia tri
                tiengiam = stripNonNumeric(tiengiam);  //doi ra so
                if(checked=="checked") {
                    if(tiengiam<0 || tiengiam>100) {
                        error_1.text("*Số % tiền giảm phải nằm trong khoảng [0, 100]");
                        isValid = false;
                    }
                }
                else{
                    if(tiengiam<0) {
                        error_1.text("*Số tiền giảm không được nhỏ hơn 0");
                        isValid = false;
                    }
                    else if(eval(tiengiam-tongtien)>0) {
                        error_1.text("*Số tiền giảm không được lớn hơn tống số tiền phải trả");
                        isValid = false;
                    }
                }
            }

            return isValid;
        }

        // Nhập/hiển thị tiền giảm và thành tiền
        function pay() {
            var checked = $("#checkboxpercent").attr("checked");
            var tongtien = stripNonNumeric($("#tongtien").val());
            var tiengiam = $("#tiengiam").val();
            var thanhtien;

            if(checkValidData()) {
                tiengiam = stripNonNumeric(tiengiam);
                if(checked=="checked")  // giảm theo phần trăm
                    thanhtien = tongtien *(1 - tiengiam/100);
                else
                    thanhtien = tongtien - tiengiam;  // giảm theo VNĐ
                thanhtien = numberFormat(roundNumber(thanhtien, 0));
                $("#thanhtien").val(thanhtien);
                left();
            }
            else {
                $("#thanhtien").val("?");
                $("#conlai").val("?");
            }
        }

        // Tính số tiền còn lại phải thanh toán
        function left()
        {
            var thanhtien = stripNonNumeric($("#thanhtien").val());
            var duatruoc = $("#duatruoc").val();

            if(duatruoc == "") {
                //$("#duatruoc").val("0");
                duatruoc = 0;
            }
            $("#conlai").val(numberFormat(eval(thanhtien)));
        }

        // DOM load
        $(function() {
            // numeric
            $("input[name='cb_tienthicong']").change(function() {
                validatecb('tienthicong');
            });
            $("input[name='cb_tiencattham']").change(function() {
                validatecb('tiencattham');
            });
            $("input[name='cb_phuthugiaohang']").change(function() {
                validatecb('phuthugiaohang');
            });
            $("input[name='cb_thutiengiumkhacsi']").change(function() {
                validatecb('thutiengiumkhacsi');
            });
            // dialog
            $( "#dialog-message" ).dialog({
                autoOpen: false,
                resizable: false,
                modal: true,
                buttons: {
                    OK: function() {
                        $(this).dialog("close");
                    }
                }
            });

            // numeric
            $("#tiengiam").numeric({allow:"."});
            $("#duatruoc").numeric();

            // Nhung nguoi co quyen giao hang => co quyen thay doi ngay giao
            <?php if (verify_access_right(current_account(), F_ORDERS_DELIVERY)): ?>
            // datepicker
            $("#ngaygiao").datepicker({
                minDate: +0,
                changeMonth: true,
                changeYear: true
            });
            <?php endif; ?>

            // Thay doi ngay phai tra tien
            <?php if (verify_access_right(current_account(), F_ORDERS_UPDATE_CASHING_DATE)): ?>
            // datepicker
            $("#cashing_date").datepicker({
                //minDate: +0,
                changeMonth: true,
                changeYear: true
            });
            <?php endif; ?>

            // submit event
            $("#form-cthd").submit(function() {
                if(!checkValidData()) {
                    $("#message").text("Các thông tin trên form chưa đúng. Vui lòng kiểm tra lại");
                    $("#dialog-message").dialog("open");
                    return false;
                }
                else
                    return true;
            });
        });
    </script>
    <link rel="stylesheet" type="text/css" href="../resources/stickytooltip/stickytooltip.css" />
    <style type="text/css">
        img {
            vertical-align: middle;
        }
        .blue-violet { color: blueviolet; font-weight: normal; }
        .bolder { color: black; font-weight: bolder; }
    </style>
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
        <ul class="shortcut-buttons-set">
            <?php if (verify_access_right(current_account(), F_ORDERS_ORDER_LIST)): ?>
                <li>
                    <a class="shortcut-button add-event" href="orderlist.php">
                        <span class="png_bg">Đơn hàng chờ giao</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (verify_access_right(current_account(), F_ORDERS_ORDER_DELIVERED)): ?>
                <li>
                    <a class="shortcut-button upload-image" href="orderdelivered.php">
                        <span class="png_bg">Đơn hàng đã giao</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (verify_access_right(current_account(), F_ORDERS_RESERVATION_LIST)): ?>
                <li>
                    <a class="shortcut-button new-page" href="reservationlist.php">
                        <span class="png_bg">Đơn hàng chờ duyệt</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (verify_access_right(current_account(), F_ORDERS_CASH_LIST)): ?>
                <li>
                    <a class="shortcut-button manage-money" href="cashlist.php">
                        <span class="png_bg">Đơn hàng chờ thu tiền</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <?php
        require_once '../models/chitietdonhang.php';
        require_once '../models/tranh.php';
        require_once '../models/donhang.php';
        require_once '../models/coupon_used.php';
        require_once '../models/chitietphanbu.php';
        $chitietphanbu = new chitietphanbu();
        ?>
        <div class="content-box column-left" style="width:100%">
            <div class="content-box-header">
                <h3>Chi tiết đơn hàng <span class="blue"><?php if (isset($_GET['item'])) echo $_GET['item']; ?></span> </h3>
            </div>
            <div class="content-box-content">
                <div class="tab-content default-tab">
                    <?php

                    // Get input data
                    $madon = (isset($_GET['item'])) ? $_GET['item'] : '';

                    $db = new donhang();
                    $row = $db->chi_tiet_don_hang($madon);
                    if (is_array($row)):
                        ?>
                        <form id="form-cthd" action="" method="post">
                            <!-- Danh sach san pham (start) -->
                            <table class="bordered">
                                <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng</th>
                                    <th>Trả hàng</th>
                                    <th>Giao hàng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                /* Danh sach cac mat hang trong hoa don */
                                $madon = $_GET['item'];
                                $db = new chitietdonhang();
                                $array = $db->danh_sach_san_pham($madon);
                                $i = 0;
                                foreach ($array as $value)
                                {
                                    $i++;
                                    $images = "balloon" . $i;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            switch ($value['trangthai'])
                                            {
                                                case chitietdonhang::$CAN_SAN_XUAT:
                                                case chitietdonhang::$DANG_SAN_XUAT:
                                                    $link = sprintf('../items/tpdetail.php?item=%s', $value['masotranh']);
                                                    break;

                                                default:
                                                    $link = '#';
                                            }
                                            ?>
                                            <a href="<?php echo $link; ?>" data-tooltip="<?php echo $images ?>">
                                                <?php echo $value['masotranh'] ?>
                                            </a>
                                        </td>
                                        <td>
                                                <span class="price">
                                                    <?php echo $value['tentranh'] ?>
                                                </span>
                                        </td>
                                        <td>
                                                <span class="blue">
                                                    <?php echo number_format($value['giaban'], 0, ",", ".") ?>
                                                </span>
                                        </td>
                                        <td>
                                                <span>
                                                    <?php echo number_format($value['soluong'], 0, ",", ".") ?>
                                                </span>
                                        </td>
                                        <?php
//                                        san pham thuoc loai san xuat hoac phan bu
                                        if ($value['loai'] == TYPE_ITEM_PRODUCE || $value['loai'] == TYPE_ITEM_PREMIUM):
                                            $themchitiet_phanbu = '';
                                            if ( $value['loai'] == TYPE_ITEM_PREMIUM ) {
                                                if ( $row['trangthai'] == donhang::$NOTCOMPLETE ) {
                                                    $themchitiet_phanbu = '
                                                        <a title="Thêm chi tiết (phần bù)" href="javascript:void(0)" action="show-premium-dialog" data_masotranh="'.$value['masotranh'].'" >
                                                            <img alt="add" src="../resources/images/icons/add.png" />
                                                        </a>';
                                                }
                                                if ($value['trangthai'] == chitietdonhang::$CHO_GIAO) {
                                                    $is_all_deliver = $chitietphanbu->checkAllStatus($madon, chitietphanbu::$DAGIAO);
                                                    if ($is_all_deliver) {
                                                        $db->capnhattrangthaisanphamphanbu($madon, $value['masotranh'], chitietdonhang::$DA_GIAO);
                                                        header('location');
                                                    }
                                                }
                                            }
                                            if (verify_access_right(current_account(), array (F_ORDERS_DELIVERY, F_ORDERS_RETURNS)) && $row['approved'] == donhang::$APPROVED)
                                            {
                                                $state = $value['trangthai'];
                                                if ($state == chitietdonhang::$CHO_GIAO):
                                                    $link = "%s?order=%s&item=%s&store=%s";
                                                    ?>
                                                    <?php if (verify_access_right(current_account(), F_ORDERS_RETURNS)): ?>
                                                    <td>
                                                        <a class="button" onclick="return confirm('Bạn có chắc không?');" href="<?php echo sprintf($link, 'returns.php', $madon, $value['masotranh'], $value['makho']); ?>">Trả hàng</a>
                                                    </td>
                                                <?php else: ?>
                                                    <td>
                                                        <a title="<?php echo 'Bạn không có quyền thực hiện thao tác'; ?>" href="javascript:">
                                                            <img alt="add" src="../resources/images/icons/add.jpg" />
                                                        </a>
                                                    </td>
                                                <?php endif; ?>
                                                    <?php if ( $value['loai'] == TYPE_ITEM_PRODUCE  ): ?>
                                                    <td>
                                                        <div id="<?php echo $value['uid']; ?>">
                                                            <!--<a class="button" href="<?php //echo sprintf($link, 'delivery.php', $madon, $value['masotranh'], $value['makho']); ?>">Giao hàng</a>-->
                                                            <a class="button" href="javascript:showDialog('<?php echo $madon; ?>', '<?php echo $value['masotranh']; ?>', <?php echo $value['soluong']; ?>, '<?php echo $value['uid']; ?>');">Giao hàng</a>
                                                        </div>
                                                    </td>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php if ($state == chitietdonhang::$DA_GIAO): ?>
                                                <td></td>
                                                <td>
                                                    <img alt="tick_circle" src="../resources/images/icons/tick_circle.png" />
                                                </td>
                                            <?php endif; ?>
                                                <?php if ($state == chitietdonhang::$TRA_HANG): ?>
                                                <td>
                                                    <img alt="tick_circle" src="../resources/images/icons/tick_circle.png" />
                                                </td>
                                                <td></td>
                                            <?php endif; ?>
                                                <?php if ($state == chitietdonhang::$CAN_SAN_XUAT || $state == chitietdonhang::$DANG_SAN_XUAT): ?>
                                                <td>
                                                    <a title="Sản phẩm chưa sản xuất xong" href="javascript:">
                                                        <img alt="minus" src="../resources/images/icons/minus.jpg" />
                                                    </a>
                                                    <?php echo $themchitiet_phanbu; ?>
                                                </td>
                                                <td>
                                                    <a title="Sản phẩm chưa sản xuất xong" href="javascript:">
                                                        <img alt="minus" src="../resources/images/icons/minus.jpg" />
                                                    </a>
                                                    <?php echo $themchitiet_phanbu; ?>
                                                </td>
                                            <?php endif; ?>
                                                <?php

                                            }
                                            else
                                            {
                                                $title = (verify_access_right(current_account(), F_ORDERS_RESERVATION_LIST)) ? 'Đơn hàng chưa approve' : 'Bạn không có quyền thực hiện thao tác';
                                                ?>
                                                <td>
                                                    <a title="<?php echo $title; ?>" href="javascript:">
                                                        <img alt="minus" src="../resources/images/icons/minus.jpg" />
                                                    </a>
                                                </td>
                                                <td>
                                                    <a title="<?php echo $title; ?>" href="javascript:">
                                                        <img alt="minus" src="../resources/images/icons/minus.jpg" />
                                                        <?php echo $themchitiet_phanbu; ?>
                                                    </a>
                                                </td>
                                                <?php
                                            }
                                        else:
                                            echo "<td></td><td></td>";
                                        endif;
                                        ?>
                                    </tr>
                                    <?php
                                    //$s[] = $value['masotranh'];
                                }
                                require_once '../models/chitiettrahang.php';
                                $db = new chitiettrahang();
                                $array = $db->danh_sach_san_pham($madon);
                                $i = 0;
                                if (is_array($array)):
                                    foreach ($array as $value)
                                    {
                                        $i++;
                                        $row = '<tr>';
                                        $row .= '<td class="price">'.$value['masotranh'].'</td>';
                                        $row .= '<td class="price">'.$value['tentranh'].'</td>';
                                        $row .= '<td class="blue">'.number_format($value['giaban'], 0, ",", ".").'</td>';
                                        $row .= '<td>'.number_format($value['soluong'], 0, ",", ".").'</td>';
                                        $row .= '<td>Đã trả lại: <a href="../orders/returns-detail.php?i='.$value['id'].'" target="_blank">'.$value['id'].'</a> - '.$value['nguyennhan'].'</td>';
                                        $row .= '<td><img alt="minus" src="../resources/images/icons/minus.jpg" /></td>';
                                        $row .= '</tr>';
                                        echo $row;
                                    }
                                endif;
                                ?>
                                </tbody>
                            </table>
                            <?php if ($row['trangthai'] == donhang::$CHO_GIAO): ?>
                                <div class="clear" style="padding-bottom: 15px;"></div>
                                <a id="export-panel" title="Xuất phiếu giao hàng" style="color: black" href="export-order-cash-xls.php?i=<?php echo $madon; ?>" target="blank">
                                    <img width="24" alt="export" src="../resources/images/icons/excel_32.png"> Xuất phiếu giao hàng
                                </a>
                                <hr />
                            <?php endif; ?>
                            <!-- Danh sach san pham (end) -->
                            <!-- danh sach chi tiet -->
                            <?php

                            require_once "../models/hangkhachdat.php";
                            $hangkhachdat = new hangkhachdat();
                            $param = array('hangkhachdat.masotranh','chitietsanpham.machitiet', 'chitietsanpham.mota', 'hangkhachdat.soluong', 'hangkhachdat.trangthai');
                            $condition = array('madonhang' => $madon);
                            $tablejoin = 'inner join chitietsanpham on chitietsanpham.machitiet = hangkhachdat.machitiet';
                            $list_arr_data = $hangkhachdat->getAll($param, $tablejoin, $condition);

                            $format = '<tr> <td>%1$s</td> <td>%2$s</td> <td>%3$s</td> <td>%4$s</td> <td>%5$s</td> </tr>';
                            $html = '';
                            $arr = $list_arr_data;
                            foreach ($arr as $data) {
                                $btn_trahang = array();
                                $btn_giaohang = array();

                                if ($row['approved'] == donhang::$APPROVED) {
                                    $btn_trahang = array('tag' => 'a', 'innerHTML', 'onclick'=>'return confirm("Bạn có chắc không")', 'class' => 'button', 'value' => 'trả hàng', 'href' => 'returns.php?action=chitietsp&do=reject&madonhang='.$madon.'&machitiet='.$data[1].'&masotranh='.$data[0]);
                                    $function = 'showPopupGiaoHang("%s","%s", "%s", "%s")';
                                    $function = sprintf($function, $madon, $data[0], $data[1], $data[3]);
                                    $btn_giaohang = array('tag' => 'input', 'onclick'=>$function, 'class' => 'button', 'value' => 'giao hàng');
                                }

                                if ($data[4] == $hangkhachdat->_TRANGTHAI_RECEIVED) {
                                    $btn_trahang = "";
                                    $btn_giaohang = array('tag' => 'img', 'src' => '../resources/images/icons/tick_circle.png');
                                }

                                if ($data[4] == $hangkhachdat->_TRANGTHAI_REJECT) {
                                    $btn_giaohang = "";
                                    $btn_trahang =  array('tag' => 'img', 'src' => '../resources/images/icons/tick_circle.png');
                                }

                                //echo sprintf($format, $data[1], $data[2], $data[3], _render_html($btn_trahang), _render_html($btn_giaohang));
                                $html .= sprintf($format, $data[1], $data[2], $data[3], "", _render_html($btn_giaohang));
                            }
                            ?>
                            <?php if ( !empty($html) ): ?>
                                <div style="padding-top: 20px"></div>
                                <h3>Chi tiết lắp rắp</h3>
                                <table class="bordered" id="table_detail">
                                    <thead>
                                    <th>Mã chi tiết</th>
                                    <th>Tên chi tiết</th>
                                    <th>Số lượng</th>
                                    <th>Trả hàng</th>
                                    <th>Giao hàng</th>
                                    </thead>
                                    <tbody>
                                    <?php echo $html; ?>
                                    </tbody>
                                </table>
                            <?php endif;                            
                            ?>

                            <!-- danh sach chi tiet (end) -->
                            <!-- chi tiet san xuat phan bu -->
                            <!-- tag: table-chitietphanbu -->
                            <?php
                            $data_chitietphanbu = $chitietphanbu->getAll( array(), '', array( 'madonhang'=>$madon ) );
                            $html = '';
                            $format = '<tr> <td>%1$s</td> <td>%2$s</td> <td>%3$s</td> <td>%4$s</td> <td>%5$s</td> <td>%6$s</td> <td>%7$s</td> <td>%8$s</td>  <td>%9$s</td> </tr>';
                            foreach ($data_chitietphanbu as $arr) {
                                $btn = '';
                                if ($arr[10] == chitietphanbu::$SOANHANG) {
                                    $btn_del = '<a class="button" href="javascript:void(0)" title="Xóa" action="del-row-premium" data-masotranh="%1$s" data-machitiet="%2$s">Xóa</a>';
                                    $btn .= sprintf($btn_del, $arr[1], $arr[2]);
                                }
                                if ($arr[10] == chitietphanbu::$HOANTAT) {
                                    $btn_deliver = '<a class="button" href="javascript:void(0)" title="Xóa" action="deliver-premium" data-masotranh="%1$s" data-machitiet="%2$s">Giao hàng</a>';
                                    $btn .= sprintf($btn_deliver, $arr[1], $arr[2]);
                                }
                                if ($arr[10] == chitietphanbu::$DAGIAO) {
                                    $img = '<img alt="tick_circle" src="../resources/images/icons/tick_circle.png">';
                                    $btn .= $img;
                                }
                                $html .= sprintf($format, $arr[2], $arr[3],$arr[4],$arr[5], $arr[6], $arr[7], $arr[8], $arr[9],  $btn);
                            }
                            ?>
                            <?php if ( !empty($html) ): ?>
                                <div style="padding-top: 20px;"></div>
                                <h3>Chi tiết phần bù</h3>
                            <table class="bordered" id="table__phanbu">
                                <thead>
                                    <th>Mã chi tiết</th>
                                    <th>Dài</th>
                                    <th>Rộng</th>
                                    <th>Cao</th>
                                    <th>Mã ván</th>
                                    <th>Mã chỉ</th>
                                    <th>Mã khoan</th>
                                    <th>Số lượng</th>
                                    <th>Chức năng</th>
                                </thead>
                                <tbody>
                                <?php echo $html; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>

                            
                                <!--HTML for the tooltips-->
                            <div id="mystickytooltip" class="stickytooltip">
                                <div style="padding:5px">
                                    <?php
                                    $i = 0;
                                    foreach ($array as $value)
                                    {
                                        $i++;
                                        $images = "balloon" . $i;
                                        ?>
                                        <div id="<?php echo $images ?>" class="atip" style="width:200px">
                                            <img width="200" height="180" alt="<?php echo $value['masotranh'] ?>" src="../<?php echo $value['hinhanh'] ?>" />
                                            <br />
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="stickystatus"></div>
                            </div>
                            <br />
                            <br />
                            <?php
                            //                                $item = "";
                            //                                if (!empty($s))
                            //                                    $items = implode(",", $s);
                            ?>
                            <input type="hidden" value="<?php echo $madon ?>" name="mahoadon" />
                            <div class="clear"></div>
                            <?php
                            if (isset($_POST["submit"]))
                            {
                                require_once '../models/donhang.php';
                                require_once '../models/employee_group_members.php';
                                require_once '../models/employee_of_order.php';

                                $manv = current_account();                               //ma nhan vien
                                $madon = $_POST["mahoadon"];                             //ma hoa don
                                $ngaygiao = $_POST["ngaygiao"];                          //ngay giao
                                $giogiao = $_POST["giogiao"];                          //ngay giao
                                $ngayphaithutien = $_POST["cashing_date"];                          //ngay phai thu tien
                                $tongtien = str_replace(",", "", $_POST["tongtien"]);    //tong tien
                                $tiengiam = $_POST["tiengiam"];                          //tien giam
                                $thanhtien = str_replace(",", "", $_POST["thanhtien"]);  //thanhtien
                                $duatruoc = str_replace(",", "", $_POST["duatruoc"]);    //dua truoc
                                $conlai = str_replace(",", "", $_POST["conlai"]);        //so tien con lai
                                $theophamtram = $_POST['checkboxpercent'];               //theo phan tram
                                $giamtheo = 0;                                           //giam theo so tien
                                // $deliver_id = $_POST['deliver'];
                                if ($theophamtram == 'on')
                                    $giamtheo = donhang::$GIAM_THEO_PHAN_TRAM;           //giam theo phan tram
                                else
                                    $giamtheo = 0;
                                $ghichu = trim($_POST["ghichu"]);                        //ghi chu hoa don
                                if(empty($ghichu))
                                    $ghichu = NULL;

                                $hoa_don_do = $_POST['hoadondo'];
                                if ($hoa_don_do == "") {
                                    $hoa_don_do = "0";
                                }

                                $giatrihoadondo = $_POST['giatrihoadondo'];

                                // cập nhât danh sách thu chi

                                // lấy các phiếu thu có trong hệ thôngs

                                $listNode = $listExpenses->getNodesByOrder($madon);

                                if (empty(array_search(TIENTHICONG, $listNode)) && array_search(TIENTHICONG, $listNode)!==0) {
                                    $is_isset = false;
                                } else {
                                    $is_isset = true;
                                }

                                if (isset($_REQUEST['cb_tienthicong']) ||  $is_isset == true) {
                                    if (isset($_REQUEST['cb_tienthicong']) && $is_isset == true ) {
                                        $money = $_REQUEST['tienthicong'];
                                        $sql = $listExpenses->updateMoney($madon, TIENTHICONG, $money);
                                    }
                                    else if (isset($_REQUEST['cb_tienthicong'])){
                                        $money = $_REQUEST['tienthicong'];
                                        $listExpenses->insert('', $manv, $madon, FINANCE_RECEIPT, $money, TIENTHICONG, 0, 1);
                                    } else {
                                        $listExpenses->deleteByNote($madon, TIENTHICONG);
                                    }
                                }

                                //
                                if (empty(array_search(TIENCATTHAM, $listNode)) && array_search(TIENCATTHAM, $listNode)!==0) {
                                    $is_isset = false;
                                } else {
                                    $is_isset = true;
                                }
                                if (isset($_REQUEST['cb_tiencattham']) ||  $is_isset == true) {
                                    if (isset($_REQUEST['cb_tiencattham']) && $is_isset == true) {
                                        $money = $_REQUEST['tiencattham'];
                                        $sql = $listExpenses->updateMoney($madon, TIENCATTHAM, $money);
                                    } else if (isset($_REQUEST['cb_tiencattham'])){
                                        $money = $_REQUEST['tiencattham'];
                                        $listExpenses->insert('', $manv, $madon, FINANCE_RECEIPT, $money, TIENCATTHAM, 0, 1);
                                    } else {
                                        $listExpenses->deleteByNote($madon, TIENCATTHAM);
                                    }
                                }
                                //
                                if (empty(array_search(PHUTHUGIAOHANG, $listNode)) && array_search(PHUTHUGIAOHANG, $listNode)!==0) {
                                    $is_isset = false;
                                } else {
                                    $is_isset = true;
                                }
                                if (isset($_REQUEST['cb_phuthugiaohang']) ||  $is_isset == true) {
                                    if (isset($_REQUEST['cb_phuthugiaohang']) && $is_isset == true) {
                                        $money = $_REQUEST['phuthugiaohang'];
                                        $sql = $listExpenses->updateMoney($madon, PHUTHUGIAOHANG, $money);
                                    } else if (isset($_REQUEST['cb_phuthugiaohang'])){
                                        $money = $_REQUEST['phuthugiaohang'];
                                        $listExpenses->insert('', $manv, $madon, FINANCE_RECEIPT, $money, PHUTHUGIAOHANG, 0, 1);
                                    } else {
                                        $listExpenses->deleteByNote($madon, PHUTHUGIAOHANG);
                                    }
                                }

                                //
                                if (empty(array_search(THUTIENGIUMKHACHSI, $listNode)) && array_search(THUTIENGIUMKHACHSI, $listNode)!==0) {
                                    $is_isset = false;
                                } else {
                                    $is_isset = true;
                                }

                                if (isset($_REQUEST['cb_thutiengiumkhacsi']) ||  $is_isset == true) {
                                    if (isset($_REQUEST['cb_thutiengiumkhacsi']) && $is_isset == true) {
                                        $money = $_REQUEST['thutiengiumkhacsi'];
                                        $sql = $listExpenses->updateMoney($madon, THUTIENGIUMKHACHSI, $money);
                                    } else if (isset($_REQUEST['cb_thutiengiumkhacsi'])){
                                        $money = $_REQUEST['thutiengiumkhacsi'];
                                        $listExpenses->insert('', $manv, $madon, FINANCE_RECEIPT, $money, THUTIENGIUMKHACHSI, 0, 1);
                                    } else {
                                        $listExpenses->deleteByNote($madon, THUTIENGIUMKHACHSI);
                                    }
                                }


                                // debug($_POST); //exit();

                                $dh = new donhang();
                                $result = $dh->cap_nhat_don_hang($manv, $madon, $ngaygiao, $giogiao, $ngayphaithutien, $tongtien, $tiengiam, $thanhtien, $duatruoc, $conlai, $giamtheo, $ghichu, $hoa_don_do, $giatrihoadondo);
                                /* Danh sach nguoi ban cua hoa don */
                                $groups = NULL;
                                $members = NULL;
                                if ($result) {
                                    // Get input data
                                    if (!empty($_POST['groups'])) {
                                        $groups = $_POST['groups'];
                                    }
                                    if (!empty($_POST['members'])) {
                                        $members = $_POST['members'];
                                    }
                                    // Innitial value
                                    $members_model = new employee_group_members();
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
                                    if (count($sellers) > 0) {
                                        $employee_order_model = new employee_of_order();
                                        // Delete old sellers
                                        if (!$employee_order_model->delete_by_order($madon)) {
                                            debug($employee_order_model->getMessage());
                                            exit();
                                        }
                                        // Insert new sellers
                                        foreach ($sellers as $s) {
                                            $item = new employee_of_order_entity();
                                            $item->order_id = $madon;
                                            $item->employee_id = $s;
                                            if (!$employee_order_model->insert($item)) {
                                                debug($employee_order_model->getMessage());
                                                exit();
                                            }
                                        }
                                    }
                                }

                                // cập nhật giao hang
                                // if (!empty($deliver_id)) {
                                //     $result_deliver = $model_deliver->setValue($madon, $deliver_id);
                                //     $result = $result&&$result_deliver;
                                // }


                                //echo $dh->_sql;
                                if ($result)
                                    echo '<center><span class="input-notification success png_bg">Cập nhật thông tin đơn hàng.</span></center><br /><br />';
                                else
                                    echo '<center><span class="input-notification error png_bg">Lỗi: ' . $dh->_error . '</span></center><br /><br />';;
                            }
                            ?>

                            <!-- Chi tiet hoa don (start) -->
                            <table id="order_detail">
                                <?php
                                /*require_once '../models/donhang.php';
                                require_once '../models/nhanvien.php';
                                require_once '../config/constants.php';*/
                                require_once '../models/khach.php';

                                $db = new donhang();
                                $row = $db->chi_tiet_don_hang($madon);
                                //debug($row);

                                if (!empty($row))
                                {
                                    $guest_id = $row['makhach'];
                                    if ($row['trangthai'] == donhang::$CHO_GIAO || $row['trangthai'] == donhang::$DA_GIAO)
                                    {
                                        // Neu khong co quyen approve don hang
                                        if (! verify_access_right(current_account(), F_ORDERS_RESERVATION_LIST))
                                        {
                                            $status = "readonly='readonly'";
                                            $onclick = "onclick='return false;' onkeydown='return false;'";
                                        }
                                        else
                                        {
                                            $status = "";
                                            $onclick = "onclick='pay();'";
                                        }
                                        ?>
                                        <tfoot>
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                                <?php
                                                if($row['approved'] == donhang::$UNAPPROVED && verify_access_right(current_account(), F_ORDERS_RESERVATION_LIST))
                                                {
                                                    ?>
                                                    <div class="bulk-actions align-left">
                                                        <?php
                                                        $format = "revieworder.php?do=%s&item=%s&status=%d";
                                                        ?>
                                                        <a href="<?php echo sprintf($format, 'approve', $madon, $row['trangthai']); ?>" title="Duyệt đơn hàng này"
                                                           onclick="return confirm('Bạn có chắc không?');">
                                                            <img src="../resources/images/approve.jpg" alt="approve" height="20px" width="20px" />
                                                            <b>Approve</b>
                                                        </a>
                                                        <span>&nbsp;&nbsp;</span>
                                                        <a href="<?php echo sprintf($format, 'reject', $madon, $row['trangthai']); ?>" title="Hủy bỏ đơn hàng này"
                                                           onclick="return confirm('Bạn có chắc không?');">
                                                            <img src="../resources/images/reject.jpg" alt="reject" height="20px" width="20px" />
                                                            <b>Reject</b>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td width="15%">
                                            <span class="bold">Liên hệ:</span>
                                        </td>
                                        <td width="85%">
                                            <?php
                                            $khach_model = new khach();
                                            $guest = $khach_model->detail_by_id ( $guest_id );
                                            if ($guest->dienthoai1) {
                                                echo '<input type="submit" class="ClicktoCall" value="'. $guest->dienthoai1. '" id="ClicktoCall1" onclick="f1(this)"/>'; }
                                            if ($guest->dienthoai2) {
                                                echo '<input type="submit" class="ClicktoCall" value="'. $guest->dienthoai2. '" id="ClicktoCall1" onclick="f1(this)"/>';}
                                            if ($guest->dienthoai3) {
                                                echo '<input type="submit" class="ClicktoCall" value="'. $guest->dienthoai3. '" id="ClicktoCall1" onclick="f1(this)"/>';}
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%">
                                            <span class="bold">Ngày đặt:</span>
                                        </td>
                                        <td width="85%">
                                            <span class="blue"><?php echo $row['ngaydat'] ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Ngày giao:</span>
                                        </td>
                                        <?php if ($row['trangthai'] == donhang::$DA_GIAO): ?>
                                            <td>
                                                <input name="ngaygiao" value="<?php echo $row['ngaygiao'] ?>" type="text" id="ngaygiao2" class="text-input small-input"
                                                       onclick="//setYears(2000, 2100); showCalender(this, 'ngaygiao');return false;"
                                                       readonly="readonly" />
                                            </td>
                                        <?php else: ?>
                                            <td>
                                                <input name="ngaygiao" value="<?php echo $row['ngaygiao'] ?>" type="text" id="ngaygiao" class="text-input small-input"
                                                       onclick="//setYears(2000, 2100); showCalender(this, 'ngaygiao');return false;"
                                                       readonly="readonly" />
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Giờ giao hàng (0-24):</span>
                                        </td>
                                        <?php if ($row['trangthai'] == donhang::$DA_GIAO): ?>
                                            <td>
                                                <input name="giogiao" value="<?php echo $row['giogiao'] ?>" type="text" id="giogiao2" class="text-input small-input" readonly="readonly" />
                                            </td>
                                        <?php else: ?>
                                            <td>
                                                <input name="giogiao" value="<?php echo $row['giogiao'] ?>" type="text" id="giogiao" class="text-input small-input" />
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Tổng tiền:</span>
                                        </td>
                                        <td>
                                            <input readonly="readonly" class="text-input small-input" type="text" id="tongtien" name="tongtien" value="<?php echo number_format($row['tongtien'], 0) ?>" />
                                            <?php if ($row['approved'] == donhang::$APPROVED): ?>
                                                <!--<div style="padding: 5px"></div>
                                                <div class="notification attention png_bg">
                                                    <div>
                                                        Đơn hàng đã được approve. Bạn không thể thực hiện thay đổi các giá trị tiền của hóa đơn!
                                                    </div>
                                                </div>-->
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $coupon_used = new coupon_used();
                                    $used_detail = $coupon_used->used_detail(array('bill_code' => $madon));

                                    if(is_array($used_detail)):
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="bold">Coupon:</span>
                                            </td>
                                            <td>
                                                <span class="blue"><?php echo $used_detail['coupon_code']; ?></span> -
                                                <span class="price"><u><?php echo $used_detail['content']; ?></u></span>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>
                                            <span class="bold">Tiền giảm:</span>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="checkboxpercent" id="checkboxpercent"
                                                <?php if ($row['giamtheo'] == donhang::$GIAM_THEO_PHAN_TRAM)
                                                    echo "checked='checked'" ?>
                                                <?php echo $onclick; ?> />Theo %
                                            <span id="sprytextfield1">
                                                <?php
                                                //$tiengiam =  number_format($row['tiengiam'], 0);
                                                //$tiengiam =  str_replace(",", "", $tiengiam);
                                                $tiengiam = number_format($row['tiengiam'], 0, "", "");
                                                ?>
                                                <input class="text-input small-input" type="text"
                                                       id="tiengiam" name="tiengiam"
                                                    <?php echo $status; ?>
                                                       value="<?php echo $tiengiam; ?>" onkeyup="pay();" />
                                                    <span class="textfieldRequiredMsg">Nhập giá trị.</span>
                                                </span>
                                            <span id="error-1" style="color: red"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Thành tiền:</span>                                                                                                            </td>
                                        <td>
                                            <input readonly="readonly" class="text-input small-input" type="text" id="thanhtien" name="thanhtien" value="<?php echo number_format($row['thanhtien'], 0) ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Tiền cọc (Đưa trước):</span>                                                                                                            </td>
                                        <td>
                                            <?php
                                            $duatruoc = number_format($row['duatruoc']);
                                            $duatruoc = str_replace(',', '', $duatruoc);
                                            ?>
                                            <span id="sprytextfield2">
                                                               <input class="text-input small-input" type="text"
                                                                      id="duatruoc" name="duatruoc"
                                                                   <?php echo $status; ?>
                                                                      value="<?php echo $duatruoc ?>" onblur="left()" onkeyup="left();" />
                                                    <span class="textfieldRequiredMsg">Nhập giá trị hợp lệ.</span>
                                                    <span id="error-2" style="color: red"></span>
                                                </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Tiền giao hàng (Còn lại):</span>                                                                                                            </td>
                                        <td>
                                            <input readonly class="text-input small-input" type="text" id="conlai" name="conlai" value="<?php echo number_format($row['conlai'], 0) ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Tien da thu:</span>                                                                                                            </td>
                                        <td>
                                            <input readonly class="text-input small-input" type="text" id="tiendathu" name="tiendathu" value="<?php echo number_format($row['cashed_money'], 0) ?>" />
                                        </td>
                                    </tr>

                                    <!-- Disable pay updating -->
                                    <?php if ($row['approved'] == donhang::$APPROVED): ?>
                                    <script type="text/javascript" charset="utf-8">
                                        //disablePayUpdating();
                                    </script>
                                <?php endif; ?>
                                    <tr>
                                        <td>
                                            <span class="bold">Ngày cần phải thu tiền:</span>
                                        </td>
                                        <td>
                                            <input name="cashing_date" value="<?php echo $row['cashing_date'] ?>" type="text" id="cashing_date" class="text-input small-input"
                                                   readonly="readonly" />
                                            <img src="../resources/images/icons/calendar_16_2.png" alt="Ngày cần phải thu tiền" title="Ngày cần phải thu tiền">
                                            <small><i>Chọn ngày</i></small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Hóa đơn đỏ</span>
                                        </td>
                                        <td>
                                            <input maxlength="11" class="text-input small-input" type="text" value="<?php echo $row['hoa_don_do']; ?>" id="hoadondo" name="hoadondo" autocomplete="off" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="bold">Giá trị hóa đơn đỏ</span>
                                        </td>
                                        <td>
                                            <input class="text-input small-input" type="text" value="<?php echo $row['giatrihoadondo']; ?>" id="giatrihoadondo" name="giatrihoadondo" autocomplete="off" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Trạng thái:</span>                                                                                                            </td>
                                        <td>
                                                <span class="blue">
                                                <?php
                                                if ($row['trangthai'] == donhang::$CHO_GIAO)
                                                    echo "<u><i>Chờ giao</i></u>";
                                                if ($row['trangthai'] == donhang::$DA_GIAO)
                                                    echo "<u><i>Đã giao</i></u>";
                                                ?>
                                                </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <?php
                                        require_once '../models/bill_note.php';

                                        // Note list of this bill
                                        $bill_note = new bill_note();
                                        $note_list = $bill_note->get_note_list($madon);
                                        ?>
                                        <td>
                                            <span class="bold">Ghi chú:</span>
                                        </td>
                                        <td>
                                            <?php foreach ($note_list as $note): ?>
                                                <div class="notification information png_bg">
                                                    <!--<a class="close" href="#">
                                                        <img alt="close" title="Close this notification" src="">
                                                    </a>-->
                                                    <div>
                                                        <span class="blue-violet"><?php echo(sprintf('%s - %s', $note['create_by'], $note['create_date'])); ?></span><br />
                                                        <?php echo($note['content']); ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <textarea id="ghichu" name="ghichu"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Khách hàng:</span>
                                        </td>
                                        <td>
                                            <span class="price"><?php echo $row['khachhang'] ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Nhóm khách:</span>
                                        </td>
                                        <td>
                                            <span class="price"><?php echo $row['nhomkhach'] ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Địa chỉ:</span>
                                        </td>
                                        <td>
                                            <span class="blue"><?php echo $row['diachi'] . ", " . $row['quan'] . ", " . $row['tp'] ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Điện thoại:</span>
                                        </td>
                                        <td>
                                                <span class="blue">
                                                <?php
                                                $space = "&bull; ";
                                                $dienthoai = $space . $row['dienthoai1'] . "<br />" . $space . $row['dienthoai2'] . "<br />" . $space . $row['dienthoai3'];
                                                echo $dienthoai;
                                                ?>
                                                </span>
                                        </td>
                                    </tr>
                                    <?php
                                    require_once '../models/coupon_assign.php';
                                    require_once '../models/employee_of_order.php';

                                    if (verify_access_right(current_account(), F_ORDERS_RESERVATION_LIST))
                                    {
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="bold">Người lập:</span>
                                            </td>
                                            <td>
                                                <span class="price"><?php echo $row['manv'] . " - " . $row['nhanvien'] ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Nhân viên bán:</span>
                                                <img src="../resources/images/icons/user_16.png" alt="employee">
                                            </td>

                                            <td>
                                                <?php
                                                $employee_order_model = new employee_of_order();
                                                $members = $employee_order_model->list_employees_of_order($madon, TRUE);
                                                $i = 0;
                                                foreach ($members['employee_name'] as $e):
                                                    $i++;
                                                    ?>
                                                    <span class="blue"><?php echo $i . '. ' . $e; ?></span><br />
                                                <?php endforeach; ?>
                                                <div style="padding: 10px"></div>
                                                <small>Chọn nhóm nhân viên:</small>
                                                <select name="groups[]" id="groups" data-placeholder=" " class="chosen-select" multiple style="width:350px;" tabindex="4">
                                                    <option value=""></option>
                                                    <?php
                                                    require_once '../models/employee_group.php';

                                                    $group_model = new employee_group();
                                                    $groups = $group_model->list_group();
                                                    if(is_array($groups)):
                                                        foreach ($groups as $g):
                                                            echo "<option value=\"{$g->group_id}\">{$g->group_name}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                                <div style="padding: 10px;"></div>
                                                <small>Chọn nhân viên:</small>
                                                <select name="members[]" id="members" data-placeholder=" " class="chosen-select" multiple style="width:350px;" tabindex="4">
                                                    <option value=""></option>
                                                    <?php
                                                    require_once '../models/nhanvien.php';

                                                    $nhanvien = new nhanvien();
                                                    $arr = $nhanvien->employee_list();
                                                    if(is_array($arr)):
                                                        foreach ($arr as $item):
                                                            $selected = '';
                                                            if (in_array($item['manv'], $members['employee_id']) === TRUE) {
                                                                $selected = 'selected';
                                                            }
                                                            echo "<option {$selected} value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr>
                                        <td><span class="bold">Nhân viên giao hàng:</span></td>
                                        <td>
                                            <?php
                                            $order_id = $_GET['item'];
                                            $list_delivers = $model_deliver->loadListInvalid();
                                            $deliver = $model_deliver->getDeliver($order_id);
                                            for ($i=0; $i < count($list_delivers); $i++) {
                                                $obj =$list_delivers[$i];
                                                if ($obj['manv'] == $deliver) {
                                                    $deliver = $obj['hoten'];
                                                }
                                            }
                                            ?>
                                            <span class="blue"><?php echo $deliver; ?></span><br /><br />
                                        </td>
                                    </tr>
                                    <?php if(($db->is_support_need($madon) || $db->is_support_monitor($madon)) && (verify_access_right(current_account(), F_ORDERS_SUPPORT_LIST))): ?>
                                    <?php
                                    $coupon_assign = new coupon_assign();
                                    ?>
                                    <tr>
                                        <td><span class="bold">Coupon assign:</span></td>
                                        <td><span class="blue"><?php echo $coupon_assign->assign_list_for_bill($madon); ?></span></td>
                                    </tr>
                                <?php endif; ?>

                                    <?php if($db->is_support_need($madon) && (verify_access_right(current_account(), F_ORDERS_SUPPORT_LIST))): ?>
                                    <tr>
                                        <td><span class="bold">Cần theo dõi đặc biệt:</span></td>
                                        <td>
                                            <input type="checkbox" name="monitor" id="monitor"
                                                   title="Chọn ô này nếu cần người có quyền cao hơn xử lý"
                                                <?php if(isset($_POST['monitor'])) echo "checked='checked'"; ?> />
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                    <!-- danh sách thu chi -->
                                    <!-- tiền thi công -->

                                    <?php

                                    $dataExpenses = $listExpenses->getInfoByOrder($madon);
                                    $tienthicong =0;
                                    $tiencattham =0;
                                    $phuthugiaohang =0;
                                    $thutiengiumkhacsi =0;
                                    $tienthicong_cb = "RO";
                                    $tiencattham_cb = "RO";
                                    $phuthugiaohang_cb = "RO";
                                    $thutiengiumkhacsi_cb = "RO";
                                    for ($i=0; $i < count($dataExpenses); $i++) {
                                        $obj = $dataExpenses[$i];
                                        if ($obj['ghichu'] == TIENTHICONG) {
                                            $tienthicong = $obj;
                                            if ($obj['trangthai']=="1") {
                                                $tienthicong_cb = "RO";
                                            }
                                        }
                                        if ($obj['ghichu'] == TIENCATTHAM) {
                                            $tiencattham = $obj;
                                            if ($obj['trangthai']=="1") {
                                                $tiencattham_cb = "RO";
                                            }
                                        }
                                        if ($obj['ghichu'] == PHUTHUGIAOHANG) {
                                            $phuthugiaohang = $obj;
                                            if ($obj['trangthai']=="1") {
                                                $phuthugiaohang_cb = "RO";
                                            }
                                        }
                                        if ($obj['ghichu'] == THUTIENGIUMKHACHSI) {
                                            $thutiengiumkhacsi = $obj;
                                            if ($obj['trangthai']=="1") {
                                                $thutiengiumkhacsi_cb = "RO";
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if(verify_access_right(current_account(), F_ORDERS_UPDATE_CASH)): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="cb_tienthicong" name="cb_tienthicong" /><span class="bold">Tiền thi công</span>
                                        </td>
                                        <td>
                                            <input class="text-input small-input" type="text" placeholder="0" id="tienthicong" name="tienthicong" autocomplete="off" readonly/>
                                        </td>
                                    </tr>
                                    <!-- Tiền cắt thảm-->
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="cb_tiencattham" name="cb_tiencattham" /><span class="bold">Tiền cắt thảm</span>
                                        </td>
                                        <td>
                                            <input class="text-input small-input" type="text" placeholder="0" id="tiencattham" name="tiencattham" autocomplete="off" readonly/>
                                        </td>
                                    </tr>
                                    <!-- Phụ thu giao hàng-->
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="cb_phuthugiaohang" name="cb_phuthugiaohang" /><span class="bold">Tiền phụ thu giao hàng</span>
                                        </td>
                                        <td>
                                            <input class="text-input small-input" type="text" placeholder="0" id="phuthugiaohang" name="phuthugiaohang" autocomplete="off" readonly/>
                                        </td>
                                    </tr>
                                    <!-- Thu tiền giùm khách sĩ -->
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="cb_thutiengiumkhacsi" name="cb_thutiengiumkhacsi" /><span class="bold">Tiền thu giùm khách hàng sĩ</span>
                                        </td>
                                        <td>
                                            <input class="text-input small-input" type="text" placeholder="0" id="thutiengiumkhacsi" name="thutiengiumkhacsi" autocomplete="off" readonly/>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                    </tbody>
                                    <?php
                                }
                                ?>
                            </table>
                            <!-- Chi tiet hoa don (end) -->

                            <div class="bulk-actions align-left">
                                <?php if ($row['trangthai'] == $db::$NOTCOMPLETE): ?>
                                    <a class="button" href="javascript:void(0)" title="Hoàn tất" action="complete-order">hoàn tất</a>
                                <?php endif;?>

                                <input type="submit" name="submit" value="Cập nhật" title="Cập nhật thông tin hóa đơn" class="button" />

                                <?php if($db->is_support_need($madon) && (verify_access_right(current_account(), F_ORDERS_SUPPORT_LIST))): ?>
                                    <input type="submit" name="supported" value="Đã chăm sóc" title="Đã thực hiện chăm sóc hóa đơn" class="button" />
                                <?php endif; ?>

                                <?php if($db->is_support_monitor($madon) && (verify_access_right(current_account(), F_ORDERS_SPECIAL_LIST))): ?>
                                    <input type="submit" name="monitored" value="Xử lý xong" title="Đã thực hiện xử lý đơn hàng cần theo dõi đặc biệt" class="button" />
                                <?php endif; ?>

                                <?php
                                if(isset($_POST['supported']))
                                {
                                    $support = (isset($_POST['monitor'])) ? donhang::$SUPPORT_MONITOR : donhang::$SUPPORT_NORMAL;
                                    $db->set_support($madon, $support);

                                    redirect('support_list.php');
                                }

                                if(isset($_POST['monitored']))
                                {
                                    $support = donhang::$SUPPORT_NORMAL;
                                    $db->set_support($madon, $support);

                                    redirect('special_list.php');
                                }
                                ?>
                            </div>
                        </form>
                    <?php endif; ?>


                    <br />
                    <br />
                </div>
            </div>
        </div>
        <?php require_once '../part/footer.php'; ?>
    </div>
</div>
<form id="fchonkhohang" method="post" style="display: none;">
    <span>Kho hàng</span>
    <select name="khohang" style="width: 20px;"></select>
    <a href="" class="button">Xác nhận</a>
</form>
<!-- Dialog thông báo -->
<div id="dialog-message" title="Thông báo">
    <p class="align-left">
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
        <span id="message">Your files have downloaded successfully into the My Downloads folder.</span>
    </p>
</div>
<?php
require_once  "../models/danchi.php";
require_once  "../models/mavan.php";
require_once  "../models/makhoan.php";
$danchi         = new danchi();
$mavan          = new mavan();
$makhoan        = new makhoan();
$data_option_danchi    = $danchi->getAllOption();
$data_option_mavan     = $mavan->getAllOption();
$data_option_makhoan   = $makhoan->getAllOption();
?>
<style>
    #premium-dialog table td, th {
        padding-bottom: 20px;
    }
</style>
<div id="premium-dialog" title="Thêm chi tiết">
    <table>
        <input type="hidden" name="masotranh" value="">
        <tr>
            <th><span>Mã chi tiết</span></th>
            <td><input type="text" name="machitiet" value=""></td>
        </tr>
        <tr>
            <th><span>Dài</span></th>
            <td><input type="text" name="dai" value="">&nbsp;m</td>
        </tr>
        <tr>
            <th> <span>Rộng</span>
            <td> <input type="text" name="rong" value="">&nbsp;m</td>
        </tr>
        <tr>
            <th> <span>Cao</span></th>
            <td> <input type="text" name="cao" value="">&nbsp;m</td>
        </tr>
        <tr>
            <th> <span>Dán chỉ</span></th>
            <td>
                <select name="danchi" value="">
                    <?php echo $data_option_danchi; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th> <span>Mã khoan</span></th>
            <td>
                <select name="makhoan" value="">
                    <?php echo $data_option_makhoan; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th> <span>Mã ván</span></th>
            <td>
                <select name="mavan" value="">
                    <?php echo $data_option_mavan; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th> <span>Số lượng</span></th>
            <td> <input type="text" name="sluong" value=""></td>
        </tr>
    </table>
</div>
<!-- Dialog -->
<div id="delivery-dialog" title="Chọn showroom giao hàng">
    <form id="delivery-form" action="../orders/delivery.php" method="get">
        <fieldset>
            <div style="padding: 5px"></div>
            <label for="name">Showroom:</label>
            <input type="hidden" id="order" name="order" value="" />
            <input type="hidden" id="item" name="item" value="" />
            <input type="hidden" id="amount" name="amount" value="" />
            <input type="hidden" id="uid" name="uid" value="" />
            <select name="store" id="store">
                <option value=""></option>
            </select>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    madon = '<?php echo $madon; ?>';
    dataExpenses = <?php echo json_encode($dataExpenses); ?>;
    tienthicong = <?php echo json_encode($tienthicong); ?>;
    tiencattham = <?php echo json_encode($tiencattham); ?>;
    phuthugiaohang = <?php echo json_encode($phuthugiaohang); ?>;
    thutiengiumkhacsi = <?php echo json_encode($thutiengiumkhacsi); ?>;
    tienthicong_cb = <?php echo json_encode($tienthicong_cb); ?>;
    tiencattham_cb = <?php echo json_encode($tiencattham_cb); ?>;
    phuthugiaohang_cb = <?php echo json_encode($phuthugiaohang_cb); ?>;
    thutiengiumkhacsi_cb = <?php echo json_encode($thutiengiumkhacsi_cb); ?>;
    resetExpenses();

    if (tienthicong) {
        $('#cb_tienthicong').attr('checked', 'on');
        $('#tienthicong').val(tienthicong.sotien);
        $("#tienthicong").attr('readonly', false);
    }
    if (tienthicong_cb=="RO") {
        $('#cb_tienthicong').hide();
        $("#tienthicong").attr('readonly', true);
    }
    if (tiencattham) {
        $('#cb_tiencattham').attr('checked', 'on');
        $('#tiencattham').val(tiencattham.sotien);
        $("#tiencattham").attr('readonly', false);
    }
    if (tiencattham_cb=="RO") {
        $('#cb_tiencattham').hide();
        $("#tiencattham").attr('readonly', true);
    }
    if (phuthugiaohang) {
        $('#cb_phuthugiaohang').attr('checked', 'on');
        $('#phuthugiaohang').val(phuthugiaohang.sotien);
        $("#phuthugiaohang").attr('readonly', false);
    }
    if (phuthugiaohang_cb=="RO") {
        $('#cb_phuthugiaohang').hide();
        $("#phuthugiaohang").attr('readonly', true);
    }
    if (thutiengiumkhacsi) {
        $('#cb_thutiengiumkhacsi').attr('checked', 'on');
        $('#thutiengiumkhacsi').val(thutiengiumkhacsi.sotien);
        $("#thutiengiumkhacsi").attr('readonly', false);
    }
    if (thutiengiumkhacsi_cb=="RO") {
        $('#cb_thutiengiumkhacsi').hide();
        $("#thutiengiumkhacsi").attr('readonly', true);
    }

    function resetExpenses() {
        // $('#cb_tienthicong').removeAttr('checked');
        // $('#cb_tiencattham').removeAttr('checked');
        // $('#cb_phuthugiaohang').removeAttr('checked');
        // $('#cb_thutiengiumkhacsi').removeAttr('checked');

        $('#tienthicong').val("");
        $('#tiencattham').val("");
        $('#phuthugiaohang').val("");
        $('#thutiengiumkhacsi').val("");
    }

    data_giaohang = {madon:'', masotranh:'', machitiet:'', makho:'', soluong: ''};
    function showPopupGiaoHang(madon, masotranh,machitiet, soluong) {
        data_giaohang = {madon:'', masotranh:'', machitiet:'', makho:'', soluong: ''};
        var query = "machitiet={0}&soluong={1}";
        query = String.format(query, machitiet, soluong);
        $.get('returns.php?action=chitietsp&do=loadmakho&'+query, function(data) {
            json = jQuery.parseJSON(data);
            if (json.result == 1) {
                var format = "<option value={0}>{1}</option>";
                var option_html = String.format(format, '', '');
                var data = json.data;
                for (var i = 0; i < data.length; i++) {
                    var arr = data[i];
                    option_html += String.format(format, arr[0], arr[1]);
                }
                $('#fchonkhohang select').html(option_html);
                $('#fchonkhohang').bPopup();
                data_giaohang['madon'] = madon;
                data_giaohang['masotranh'] = masotranh;
                data_giaohang['machitiet'] = machitiet;
                data_giaohang['soluong'] = soluong;
                data_giaohang['makho'] = '';
            }
        });
    }
    $('#fchonkhohang a').click(function(event) {
        data_giaohang['makho'] = $('#fchonkhohang select').val();
        if (data_giaohang['madon'] == '' ||  data_giaohang['masotranh'] == '' || data_giaohang['machitiet'] == ''|| data_giaohang['soluong'] == ''|| data_giaohang['makho'] == '') {
            alert('Dữ liệu chưa hợp lệ');
            $('#fchonkhohang a').attr('href', '#');
            return false;
        }
        var r = confirm('Xác nhận giao hàng?');
        if (r == true) {
            var query = "madon={0}&masotranh={1}&machitiet={2}&soluong={3}&makho={4}";
            query = String.format(query, data_giaohang['madon'], data_giaohang['masotranh'], data_giaohang['machitiet'], data_giaohang['soluong'], data_giaohang['makho']);
            var href = "returns.php?action=chitietsp&do=giaohang&"+query;
            $('#fchonkhohang a').attr('href', href);
        } else {
            $('#fchonkhohang a').attr('href', '#');
        }
    });
</script>
</body>
</html>
<?php
require_once '../part/common_end_page.php';
?>