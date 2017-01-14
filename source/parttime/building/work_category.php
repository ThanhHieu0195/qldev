<?php
require_once '../part/common_start_page.php';
// Authenticate
do_authenticate(G_MANAGER_BUILDING, F_WORK_CATEGORY, TRUE);
?>
<?php 
    require_once "../models/congviechangmucthicong.php";
    require_once '../models/hangmucthicong.php';

    $work_category = new work_category();
    $category_building = new category_building();
    $list_category_building = $category_building->get_all();
    if (isset($_POST['del']) && isset($_POST['id'])) {
        $id = $_POST['id'];
        $work_category->delete($id);
    }

    if (isset($_POST['update']) && isset($_POST['id']) && isset($_POST['id_category']) && isset($_POST['describe']) && isset($_POST['target_complete'])) {
        $id = $_POST['id'];
        $id_category = $_POST['id_category'];
        $describe = $_POST['describe'];
        $target_complete = $_POST['target_complete'];
        $work_category->update($id, $id_category, $describe, $target_complete);
    }

    if (isset($_POST['add']) && isset($_POST['id_category']) && isset($_POST['describe']) && isset($_POST['target_complete'])) {
        $id_category = $_POST['id_category'];
        $describe = $_POST['describe'];
        $target_complete = $_POST['target_complete'];
        $work_category->insert($id_category, $describe, $target_complete);
    }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Công việc hạng mục thi công</title>
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
    <script type="text/javascript" src="../resources/scripts/utility/building/work_category.js"></script>
    <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8">
        var work_category = {};
        var list_category_building = <?php echo json_encode($list_category_building); ?>;
        $(function() {
            var oTable = $('#example').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "../ajaxserver/work_category_server.php",
                "aoColumnDefs": [
                { "sClass": "center", "aTargets": [ 0, 1, 2, 3] }
                ],
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    work_category[aData.id] = aData;
                    $('td:eq(0)', nRow).html(aData.id);
                    $('td:eq(1)', nRow).html("<label style='text-align: center; color: blue;'>" + aData.tenhangmuc + "</label>");
                    $('td:eq(2)', nRow).html("<label style='text-align: center; color: blue;'>" + aData.motacongviec + "</label>");
                    $('td:eq(3)', nRow).html("<label style='text-align: center; color: blue;'>" + aData.tieuchihoanthanh + "</label>");
                    $('td:eq(4)', nRow).html('<input class="editrow" type="button" value="edit" onclick="editrow(\''+aData.id+'\')"> <input class="delrow" type="button" value="del" onclick="delrow(\''+aData[0]+'\')">');
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
                    <h3>Công việc hạng mục thi công</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div id="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã công việc</th>
                                                <th>Mã hạng mục</th>
                                                <th>Mô tả cônng việc</th>
                                                <th>Tiêu chí công việc</th>
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
                <input id="fedit_id" name="id" type="hidden">
                <table>
                    <tr>
                        <th>Mã công việc</th>
                        <th>Mã hạng mục</th>
                        <th>Mô tả cônng việc</th>
                        <th>Tiêu chí công việc</th>
                    </tr>
                    <tr>
                        <td><p id="fedit_title"></p></td>
                        <td>
                            <select id="fedit_id_category" name="id_category">
                                <option value=""></option>
                                <?php 
                                    for ($i=0; $i < count($list_category_building); $i++) { 
                                        $obj = $list_category_building[$i];
                                        $id = $obj['id'];
                                        $name = $obj['tenhangmuc'];
                                        $echo = "<option value='$id'>$name</option>";
                                        echo $echo;
                                    }
                                 ?>
                            </select>
                        </td>
                        <td><input id="fedit_describe" name="describe" type="text"></td>
                        <td><input id="fedit_target_complete" name="target_complete" type="text"></td>
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
                        <th>Mã hạng mục</th>
                        <th>Mô tả cônng việc</th>
                        <th>Tiêu chí công việc</th>
                    </tr>
                    <tr>
                        <td>
                            <select id="fadd_id_category" name="id_category">
                                <option value=""></option>
                                <?php 
                                    for ($i=0; $i < count($list_category_building); $i++) { 
                                        $obj = $list_category_building[$i];
                                        $id = $obj['id'];
                                        $name = $obj['tenhangmuc'];
                                        $echo = "<option value='$id'>$name</option>";
                                        echo $echo;
                                    }
                                 ?>
                            </select>
                        </td>
                        <td><input id="fadd_describe" name="describe" type="text"></td>
                        <td><input id="fadd_target_complete" name="target_complete" type="text"></td>
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
