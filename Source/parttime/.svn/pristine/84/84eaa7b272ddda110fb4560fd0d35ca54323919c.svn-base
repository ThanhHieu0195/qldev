<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_MANAGER_BUILDING_1, F_CREATE_BUILDING, TRUE);
require_once '../models/hangmucthicong.php';
require_once '../models/nhanvien.php';
$category_building = new category_building();
$data_category_building = $category_building->get_all();
$nhanvien = new nhanvien();
$danhsachnv = $nhanvien->employee_list();
$sale = current_account();

if ( isset($_POST['add']) ) {
    require_once "../models/danhsachcongtrinh.php";
    $name_building = $_POST['name_building'];
    $address = $_POST['address'];
    $id_guest = $_POST['id_guest'];
    $list_id_category = $_POST['id_category'];
    $date_start = $_POST['date_start'];
    $date_expect_complete = $_POST['date_expect_complete'];
    $giamsat = $_POST['assessor'];
    $thietke = $_POST['designer'];
    $status = STATUS_DEFAULT;
    $money_estimate = "";
    $money_collect = "";
    $money_spent = "";
    $list_building = new list_building(); 
    $id_building = $list_building->insert($name_building, $address, $id_guest, $status, $date_start, $date_expect_complete, $money_estimate, $money_collect, $money_spent, $thietke, $giamsat, $sale); 
    //error_log ("Add new " . $id_building, 3, '/var/log/phpdebug.log'); 
    if ( $id_building ) {
        require_once "../models/chitiethangmuccongtrinh.php";
        $detail_category_building = new detail_category_building();
        $d = 0;
        for ($i=0; $i < count($list_id_category); $i++) { 
            $id_category = $list_id_category[$i];
            $detail_category_building->insert($id_building, $id_category);
            $d++;
        }
        if ($d == count($list_id_category)) {
            header("location: detail_building.php?token_id=$id_building");
        }
    }

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Thêm công trình mới</title>
    <?php require_once '../part/cssjs.php'; ?>

    <style type="text/css" title="currentStyle">
        @import "../resources/datatable/css/demo_page.css";
        @import "../resources/datatable/css/demo_table.css";
        img { vertical-align: middle; }
        .chosen-container { 
            width: 500px !important;
         }
    </style>
    <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
    <link rel="stylesheet" type="text/css" href="../resources/css/building/custom-popup.css">
    <!-- jQuery.bPopup -->
    <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
    <link rel="stylesheet" href="../resources/chosen/chosen.css">
    <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
    <!--  -->
    <script type="text/javascript" src="../resources/scripts/utility/building/category_building.js"></script>
    <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('input[name="date_start"]').datepicker({
                minDate: new Date()
            });
            $('input[name="date_expect_complete"]').datepicker({
                 minDate: new Date($('input[name="date_start"]').val())
            });

              var ctrl = $( 'input[name="id_guest"]' ).autocomplete({
                    minLength: 1,
                    source: "../ajaxserver/autocomplete_server.php?type=abc",
                    select: function( event, ui ) {
                        $( 'input[name="id_guest"]' ).val(ui.item.makhach);
                        return false;
                    }
                }).data( "autocomplete" );

                ctrl. _renderItem = function( ul, item ) {
                    return $( "<li></li>" )
                            .data( "item.autocomplete", item )
                            .append( "<a>" + "<span class='name'>" + item.hoten + "</span>" + "<br>" + item.diachi + "</a>" )
                            .appendTo( ul );
                };
                $('#id_category').chosen();
        });

        function checkValue() {
            var name_building = $('input[name = "name_building"]').val();
            var address = $('input[name = "address"]').val();
            var id_guest = $('input[name = "id_guest"]').val();
            var date_start = $('input[name = "date_start"]').val();
            var date_expect_complete = $('input[name = "date_expect_complete"]').val();
            var pass = true;
            if (name_building == "") {
                $('input[name = "name_building"]').css('border', '1px solid red');
                pass = false;
            } else {
                $('input[name = "name_building"]').css('border', 'none');
            }

            if (address == "") {
                $('input[name = "address"]').css('border', '1px solid red');
                pass = false;
            } else {
                $('input[name = "address"]').css('border', 'none');
            }

            if (id_guest == "") {
                $('input[name = "id_guest"]').css('border', '1px solid red');
                pass = false;
            } else {
                $('input[name = "id_guest"]').css('border', 'none');
            }

            if (date_start == "") {
                $('input[name = "date_start"]').css('border', '1px solid red');
                pass = false;
            } else {
                $('input[name = "date_start"]').css('border', 'none');
            }

            if (date_expect_complete == "") {
                $('input[name = "date_expect_complete"]').css('border', '1px solid red');
                pass = false;
            } else {
                $('input[name = "date_expect_complete"]').css('border', 'none');
            }
            return pass;
        }
    </script>
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
            <div class="content-box column-left" style="width:100%">
                <div class="content-box-header">
                    <h3>Thêm công trình mới</h3>
                </div>
                <div class="content-box-content">
                    <form method="POST">
                        <table id="t_create_building">
                            <tr>
                                <th>Tên công trình</th>
                                <td><input class="text-input small-input" type="text" name="name_building" placeholder="Nhập tên công trình :A-Za-z0-9_{12 ky tu}" pattern="[A-Za-z0-9_]{8-12}"> </td>
                            </tr>
                             <tr>
                                <th>Địa chỉ</th>
                                <td><input class="text-input small-input" type="text" name="address" placeholder="Nhập tên địa chỉ"></td>
                            </tr>
                             <tr>
                                <th>Mã khách</th>
                                <td>
                                    <input class="text-input small-input" type="text" name="id_guest" placeholder="Nhập số điện thoại">
                                </td>

                            </tr>

                             <tr>
                                <th>Danh sách hạng mục</th>
                                <td>
                                    <select data-placeholder="Choose a category..." class="text-input small-input" type="text" name="id_category[]" id="id_category" multiple style="width: 500px;">
                                    <?php 
                                        for ($i=0; $i < count($data_category_building); $i++) { 
                                            $data = $data_category_building[$i];
                                            $id = $data[0];
                                            $value = $data[1];
                                            $option = "<option value='$id' selected>$value</option>";
                                            echo $option;
                                        }
                                     ?>
                                    </select>
                                </td>

                            </tr>
            
                            <tr>
                                <th>Trạng thái</th>
                                <td>
                                    <input type="text" name="status" class="text-input small-input" readonly value="Khởi tạo">
                                </td>
                            </tr>
                            <tr>
                                <th>Nhân viên thiết kế</th>
                                <td>
                                    <select data-placeholder="..." class="text-input small-input" type="text" name="designer" id="designer" style="width: 500px;">
                                    <?php
                                    for ($i=0; $i < count($danhsachnv); $i++) {
                                        $data = $danhsachnv[$i];
                                        $manv = $data['manv'];
                                        $hoten = $data['hoten'];
                                        echo '<option value="'. $manv .'">'. $hoten .'</option>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Nhân viên giám sát</th>
                                <td>
                                    <select data-placeholder="..." class="text-input small-input" type="text" name="assessor" id="assessor" style="width: 500px;">
                                    <?php
                                    for ($i=0; $i < count($danhsachnv); $i++) {
                                        $data = $danhsachnv[$i];
                                        $manv = $data['manv'];
                                        $hoten = $data['hoten'];
                                        echo '<option value="'. $manv .'">'. $hoten .'</option>';
                                    }
                                    ?>
                                </td>
                            </tr>
                             <tr>
                                <th>Ngày khởi công</th>
                                <td>
                                    <input name="date_start" class="text-input small-input" style="width: 150px !important" type="text" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày dự kiên hoàn thành</th>
                                <td>
                                    <input name="date_expect_complete" class="text-input small-input" style="width: 150px !important" type="text" readonly="readonly"/>
                                </td>
                            </tr>
                        </table>
                        <input class="btn-function" type="submit" name="add" value="Thêm" onClick="return checkValue()">
                        <input class="btn-function" type="button" name="reset" value="Reset" onClick="resetValue()">
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php 
    require_once '../part/common_end_page.php';
    ?>
