<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_MANAGER_BUILDING, F_GROUP_CATEGORY_BUILDING, TRUE);
?>
<?php 
    require_once "../models/nhomhangmuc.php";
    $group_category_building = new group_category_building();
    if (isset($_POST['del']) && isset($_POST['id'])) {
        $id = $_POST['id'];
        $group_category_building->delete($id);
    }

    if (isset($_POST['update']) && isset($_POST['id']) && isset($_POST['describe'])) {
        $id = $_POST['id'];
        $describe = $_POST['describe'];
        $group_category_building->update($id, $describe);
    }

    if (isset($_POST['add']) && isset($_POST['describe'])) {
        $describe = $_POST['describe'];
        $group_category_building->insert($describe);
    }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Nhóm hạng mục</title>
    <?php require_once '../part/cssjs.php'; ?>

    <style type="text/css" title="currentStyle">
        @import "../resources/datatable/css/demo_page.css";
        @import "../resources/datatable/css/demo_table.css";
        img { vertical-align: middle; }
    </style>
    <link rel="stylesheet" type="text/css" href="../resources/css/building/custom-popup.css">
    <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />

    <!-- jQuery.bPopup -->
    <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
    <!--  -->
    <script type="text/javascript" src="../resources/scripts/utility/building/group_category_building.js"></script>
    <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8">

        $(function() {
            var oTable = $('#example').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "../ajaxserver/group_category_building_server.php",
                "aoColumnDefs": [
                { "sClass": "center", "aTargets": [ 0, 1, 2 ] }
                ],
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    console.log(nRow);
                    $('td:eq(0)', nRow).html(aData[0]);
                    $('td:eq(1)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[1] + "</label>");
                    $('td:eq(2)', nRow).html('<input class="editrow" type="button" value="edit" onclick="editrow(\''+aData[0]+'\', \''+aData[1]+'\')"> <input class="delrow" type="button" value="del" onclick="delrow(\''+aData[0]+'\')">');
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
                    <h3>Nhóm hạng mục</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div id="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã nhóm</th>
                                                <th>Tên nhóm</th>
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
                        <th>Mã nhóm</th>
                        <th>Tên nhóm</th>
                    </tr>
                    <tr>
                        <td><p id="fedit_title"></p></td>
                        <td><textarea rows="4" id="fedit_describe" name="describe"></textarea></td>
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
                        <th>Tên nhóm</th>
                        <td><textarea rows="2" id="fadd_describe" name="describe"></textarea></td>
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
