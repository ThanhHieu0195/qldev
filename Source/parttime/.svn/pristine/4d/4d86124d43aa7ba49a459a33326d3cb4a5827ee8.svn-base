<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_MANAGER_BUILDING, F_CATEGORY_BUILDING, TRUE);
?>
<?php 
    require_once "../models/hangmucthicong.php";
    require_once "../models/nhomhangmuc.php";
    $status_building = new category_building();
    $nhangmuc = new group_category_building();
    $manhom = $nhangmuc->get_all(); 
    $tennhom = array();
    foreach ($manhom as $h) {
        array_push($tennhom, $h['mota']);
    }
    if (isset($_POST['del']) && isset($_POST['id'])) {
        $id = $_POST['id'];
        $status_building->delete($id);
    }

    if (isset($_POST['update']) && isset($_POST['id']) && isset($_POST['name']) && isset($_POST['group_category']) && isset($_POST['describe'])&& isset($_POST['construction_date'])&& isset($_POST['expect_cost'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $group_category = $_POST['group_category'];
        $describe = $_POST['describe'];
        $construction_date = string_2_number($_POST['construction_date']);
        $expect_cost = string_2_number($_POST['expect_cost']);
        $status_building->update(array( "id"=>$id, "name_category" => $name_category, "group_category" => $group_category, "describe" => $describe, "construction_date" => $construction_date, "expect_cost" => $expect_cost));
    }

    if (isset($_POST['add']) && isset($_POST['name']) && isset($_POST['group_category']) && isset($_POST['describe'])&&isset($_POST['construction_date'])&& isset($_POST['expect_cost'])) {
        $name_category = $_POST['name'];
        $group_category = $_POST['group_category'];
        $describe = $_POST['describe'];
        $construction_date = string_2_number($_POST['construction_date']);
        $expect_cost = string_2_number($_POST['expect_cost']);
        $status_building->insert($name_category, $group_category, $describe, $construction_date, $expect_cost);
    }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Danh sách hạng mục thi công</title>
    <?php require_once '../part/cssjs.php'; ?>

    <style type="text/css" title="currentStyle">
        @import "../resources/datatable/css/demo_page.css";
        @import "../resources/datatable/css/demo_table.css";
        img { vertical-align: middle; }
    </style>
    <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
    <link rel="stylesheet" type="text/css" href="../resources/css/building/custom-popup.css">
    <!-- jQuery.bPopup -->
    <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
    <!--  -->
    <script type="text/javascript" src="../resources/scripts/utility/building/category_building.js"></script>
    <script type="text/javascript" src="../resources/scripts/utility/building/function-support.js"></script>

    <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8">
        
        $(function() {
            var map = <?php echo json_encode($tennhom); ?>;
            var oTable = $('#example').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "../ajaxserver/category_building_server.php",
                "aoColumnDefs": [
                { "sClass": "center", "aTargets": [ 0, 1, 2 , 3, 4, 5, 6] }
                ],
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    aData[3] = number2string(aData[3]);
                    aData[4] = number2string(aData[4]);
                    $('td:eq(0)', nRow).html(aData[0]);
                    $('td:eq(1)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[1] + "</label>");
                    $('td:eq(2)', nRow).html("<label style='text-align: center; color: blue;'>" + map[aData[2]] + "</label>");
                    $('td:eq(3)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[3] + "</label>");
                    $('td:eq(4)', nRow).html("<label style='text-align: center; color: blue;'><a href='detail_category.php?id="+aData[0]+"' target='blank'>Chi tiêt<a/></label>");
                    $('td:eq(5)', nRow).html("<label style='text-align: center; color: blue;'>" + (aData[4] == null ? "": aData[4]) + "</label>");
                    $('td:eq(6)', nRow).html("<label style='text-align: center; color: blue;'>" + (aData[5] == null ? "": aData[5]) + "</label>");
                    $('td:eq(7)', nRow).html('<input class="editrow" type="button" value="edit" onclick="editrow(\''+aData[0]+'\', \''+aData[1]+'\', \''+aData[2]+'\', \''+aData[3]+'\', \''+aData[4]+'\', \''+aData[5]+'\')"> <input class="delrow" type="button" value="del" onclick="delrow(\''+aData[0]+'\')">');
                }
            });
        });
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
                    <h3>Danh sách hạng mục thi công</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div id="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã hạng mục</th>
                                                <th>Tên hạng mục</th>
                                                <th>Nhóm hạng mục</th>
                                                <th>Mô tả</th>
                                                <th>Chi tiết</th>
                                                <th>Số ngày thi công</th>
                                                <th>Đơn giá dự đoán</th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div style="padding-bottom: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="button" onclick="addrow()" value="Thêm" class="addrow">
                </div>
            </div>
            <!-- popup -->
            <form id="f_del" class="popup" method="POST">
                <row>
                    <label class="title"></label>
                    <input type="hidden" name="id" id="id_del">
                </row>
                <row style="text-align: center;">
                    <input type="submit" name="del" class="btn_submit" value="Xóa">
                    <input type="button" name="exit" class="btn_exit" value="Thoát">
                </row>
            </form>

            <form id="f_edit" class="popup" method="POST">
                <table>
                    <tr>
                        <th>Mã hạng mục</th>
                        <td><input style="color: #FF0000" id="fedit_id" name="id" type="text" readonly></td>
                    </tr>
                    <tr>
                        <th>Tên hạng mục</th>
                        <td><input id="fedit_name" name="name" type="text"></td>
                    </tr>
                    <tr>
                        <th>Nhóm hạng mục</th>
                        <td><select id="fedit_group_category" name="group_category" type="text">
                            <?php foreach ($manhom as $mh) {
                                echo "<option value='" . $mh['id'] . "'>" . $mh['mota'] . "</option>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td><textarea number="true" id="fedit_describe" name="describe" type="text"/></textarea></td>
                    </tr>
                     <tr>
                        <th>Số ngày thi công</th>
                        <td><input id="fedit_construction_date" name="construction_date" type="text"></td>
                    </tr>
                     <tr>
                        <th>Đơn giá dự đoán</th>
                        <td><input id="fedit_expect_cost" name="expect_cost" type="text"></td>
                    </tr>
                </table>
                <row style="text-align: center;">
                    <input type="submit" name="update" class="btn_submit" value="Cập nhật">
                    <input type="button" name="exit" class="btn_exit" value="Thoát">
                </row>
            </form>

            <form id="f_add" class="popup" method="POST">
                <table>
                     <tr>
                        <th>Tên hạng mục</th>
                        <td><input id="fadd_name" name="name" type="text"></td>
                    </tr>
                    <tr>
                        <th>Nhóm hạng mục</th>
                        <td><select id="fadd_group_category" name="group_category" type="text">
                            <?php foreach ($manhom as $mh) {
                                echo "<option value='" . $mh['id'] . "'>" . $mh['mota'] . "</option>";
                            }
                            ?>
                        </td>
                    </tr>
                     <tr>
                        <th>Mô tả</th>
                        <td><textarea id="fadd_describe" name="describe" type="text"/></textarea></td>
                    </tr>
                       <tr>
                        <th>Số ngày thi công</th>
                        <td><input id="fadd_construction_date" name="construction_date" type="text"></td>
                    </tr>
                     <tr>
                        <th>Đơn giá dự đoán</th>
                        <td><input id="fadd_expect_cost" name="expect_cost" type="text"></td>
                    </tr>
                </table>
                <row style="text-align: center;">
                    <input type="submit" name="add" class="btn_submit" value="Thêm">
                    <input type="button" name="exit" class="btn_exit" value="Thoát">
                </row>
            </form>

        </div>

        
    </body>
    </html>
    <?php 
    require_once '../part/common_end_page.php';
    ?>
