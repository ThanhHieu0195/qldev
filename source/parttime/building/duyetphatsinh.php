<?php
require_once '../part/common_start_page.php';
// Authenticate
do_authenticate(G_MANAGER_BUILDING_1, F_LIST_BUILDING, TRUE);
require_once "../models/duyetphatsinh.php";
$duyetphatsinh = new duyetphatsinh();
$data = $duyetphatsinh->taidulieu();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Duyệt phát sinh</title>
    <?php require_once '../part/cssjs.php'; ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style type="text/css" title="currentStyle">
        @import "../resources/datatable/css/demo_page.css";
        @import "../resources/datatable/css/demo_table.css";
    </style>
    <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
    <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
    <!--  -->

    <script type="text/javascript" src="../resources/scripts/utility/building/function-support.js"></script>
    <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>

    <script>
        function  comfrim(loai, id, idcongtrinh) {
            var is_ok = confirm('Approve yêu cầu?');
            if (is_ok == true) {
                $.post('ajaxserver.php', {action:'comfrim-duyetyeucau', loai: loai, id:id, idcongtrinh:idcongtrinh}, function(data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    console.log(data);
                    data = jQuery.parseJSON(data);
                    if (data.result == 1) {
                        window.location = "";
                    }
                });
            }
        }

        function  reject(loai, id) {
            var is_ok = confirm('Reject yêu cầu?');
            if (is_ok == true) {
                $.post('ajaxserver.php', {action:'reject-duyetyeucau', loai: loai, id:id}, function(data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    data = jQuery.parseJSON(data);
                    if (data.result == 1) {
                        window.location = "";
                    }
                });
            }
        }
    </script>
</head>
<body>
    <div id="body-wrapper">
        <?php
        require_once '../part/menu.php';
        ?>
        <div id="main-content" style="display: table">
            <noscript>
                <div class="notification error png_bg">
                    <div>
                        Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                    </div>
                </div>
            </noscript>
            <div class="content-box column-left" style="width:100%">
                <div class="content-box-header">
                    <h3>Duyệt phát sinh</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div class="detail-category">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Tên công trình</th>
                                                <th>Tên hạng mục</th>
                                                <th>Loại yêu cầu</th>
                                                <th>Tên vật tư</th>
                                                <th>Lượng ban đầu</th>
                                                <th>Lượng phát sinh</th>
                                                <th>Nhân viên yêu cầu</th>
                                                <th>Ghi chú</th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $format = '<tr> <td>%1$s</td> <td>%2$s</td> <td>%3$s</td> <td>%4$s</td> <td>%5$s</td> <td>%6$s</td>
                                                    <td>%7$s</td> <td>%8$s</td> <td>%9$s</td> </tr>';
                                        $format_comfrim = '<a class="button" onclick="comfrim(%1$s, %2$s, %3$s);">comfrim</a>';
                                        $format_reject = '<a class="button" onclick="reject(%1$s, %2$s);">Reject</a>';
                                        foreach ($data as $arr):
                                            $btn1 = sprintf($format_comfrim, $arr['loaiyeucau'], $arr['id'],  $arr['idcongtrinh']);
                                            $btn2 = sprintf($format_reject, $arr['loaiyeucau'], $arr['id']);
                                            echo sprintf($format, $arr[1], $arr[2], $arr[3]==0?'hạng mục':'vật tư', $arr[4], $arr[5], $arr[6], $arr[7], $arr[8], $btn1.$btn2);
                                        endforeach;
                                        ?>
                                        </tbody>
                                    </table>

                                    <div style="padding-bottom: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php 
    require_once '../part/common_end_page.php';
    ?>
