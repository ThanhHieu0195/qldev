<?php
require_once '../part/common_start_page.php';
// Authenticate
do_authenticate(G_MANAGER_BUILDING, F_CATEGORY_BUILDING, TRUE);
require_once "../ajaxserver/detail_category_server.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Chi tiết hạng mục</title>
    <?php require_once '../part/cssjs.php'; ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style type="text/css" title="currentStyle">
        @import "../resources/datatable/css/demo_page.css";
        @import "../resources/datatable/css/demo_table.css";

        img { vertical-align: middle; }

        .demo caption, th, td {
            text-align: center;
        }

        .information_category {
            padding: 15px 0;
        }
        .information_category label {
            background-color: #4e4e4e;
            color: #FFFFFF;
            margin-left: 10px;
            padding: 10px;
            border-radius: 10px;
            font-family: 'Roboto', sans-serif;
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
    <!--  -->

    <script type="text/javascript" src="../resources/scripts/utility/building/function-support.js"></script>
    <script type="text/javascript" src="../resources/scripts/utility/building/detail_category.js"></script>
    <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
</head>
<body>
    <div id="body-wrapper">
        <?php
        require_once '../part/menu.php';
        ?>
        <div id="main-content">
            <noscript>
                <div class="notification error png_bg">
                    <div>
                        Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                    </div>
                </div>
            </noscript>

            <div class="information_category">
                <?php 
                    $row = $data['category_building'];
                    echo "<label> Mã hạng mục: ".$row[0]."</label>";
                    echo "<label> Tên hạng mục: ".$row[1]."</label>";
                    echo "<label> Mô tả: ".$row[2]."</label>";
                 ?>
            </div>

            <div class="content-box column-left" style="width:100%">
                <div class="content-box-header">
                    <h3>Công việc của hạng mục</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div class="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã</th>
                                                <th>Mô tả công việc</th>
                                                <th>Tiêu chí hoàn thành</th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php 
                                            $list_arr = $data['work_category'];
                                            for ($i=0; $i < count($list_arr); $i++):
                                                $arr = $list_arr[$i];
                                                $row = '<tr> <td>'.$arr[0].'</td> <td>'.$arr[2].'</td> <td>'.$arr[3].'</td> <td><input class="delrow" type="button" value="del" onclick="delrow(\''.$arr[0].'\', \'work_category\')"></td> </tr>';
                                                echo $row;
                                            endfor;

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


            <div class="content-box column-left" style="width:100%">
                <div class="content-box-header">
                    <h3>Vật tư của hạng mục</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div class="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã</th>
                                                <th>Tên vật tư</th>
                                                <th>Giá thấp</th>
                                                <th>Giá cao</th>
                                                <th>Đơn vị tính</th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $list_arr = $data['material_category'];
                                            for ($i=0; $i < count($list_arr); $i++):
                                                $arr = $list_arr[$i];
                                                $row = '<tr> <td>'.$arr[0].'</td> <td>'.$arr[2].'</td> <td>'.$arr[3].'</td> <td>'.$arr[4].'</td> <td>'.$arr[5].'</td> <td><input class="delrow" type="button" value="del" onclick="delrow(\''.$arr[0].'\', \'material_category\')"></td> </tr>';
                                                echo $row;
                                            endfor;

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


            <div class="content-box column-left" style="width:100%">
                <div class="content-box-header">
                    <h3>Đội thi công của hạng mục</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div class="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã</th>
                                                <th>Tên đội</th>
                                                <th>Địa chỉ</th>
                                                <th>Số điện thoại</th>
                                                <th>Mã đội</th>
                                                <th>Đơn giá</th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $list_arr = $data['list_group_construction'];
                                            for ($i=0; $i < count($list_arr); $i++):
                                                $arr = $list_arr[$i];
                                                $row = '<tr> <td>'.$arr[0].'</td> <td>'.$arr[1].'</td> <td>'.$arr[2].'</td> <td>'.$arr[3].'</td> <td>'.$arr[4].'</td> <td>'.number_2_string($arr[5]).'</td> <td><input class="delrow" type="button" value="del" onclick="delrow(\''.$arr[0].'\', \'category_group_building\')"></td> </tr>';
                                                echo $row;
                                            endfor;

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


            <div class="content-box column-left" style="width:100%">
                <div class="content-box-header">
                    <h3>Nhà cung cấp của hạng mục</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div class="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã</th>
                                                <th>Tên</th>
                                                <th>Địa chỉ</th>
                                                <th>Số điện thoại</th>
                                                <th>Mã nhà cung cấp</th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $list_arr = $data['list_provider'];
                                            for ($i=0; $i < count($list_arr); $i++):
                                                $arr = $list_arr[$i];
                                                $row = '<tr> <td>'.$arr[0].'</td> <td>'.$arr[1].'</td> <td>'.$arr[2].'</td> <td>'.$arr[3].'</td> <td>'.$arr[5].'</td> <td><input class="delrow" type="button" value="del" onclick="delrow(\''.$arr[0].'\', \'list_provider\')"></td> </tr>';
                                                echo $row;
                                            endfor;

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
            <!-- popup -->
            <form id="f_del" class="popup" method="POST">
                <input type="hidden" name="table" id="f_del_table">
                <input type="hidden" name="cata" id="f_del_cata" value='<?php echo $_GET['id']; ?>'>
                <row>
                    <label class="title"></label>
                    <input type="hidden" name="id" id="id_del">
                </row>
                <row style="text-align: center;">
                    <input type="submit" name="del" class="btn_submit" value="Xóa">
                    <input type="button" name="exit" class="btn_exit" value="Thoát">
                </row>
            </form>
        </div>
    </body>
    </html>
    <?php 
    require_once '../part/common_end_page.php';
    ?>
