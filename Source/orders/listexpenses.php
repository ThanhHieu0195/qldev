<!-- expenses_approve.php -->
<?php
require_once '../part/common_start_page.php';
do_authenticate(G_ORDERS, F_LIST_EXPENSES, TRUE);
    require_once "../models/danhsachthuchi.php";
    $listExpenses = new listExpenses();

    // if (isset($_REQUEST['action'])) {
    //     $do = $_REQUEST['do'];
    //     if ($do == "approve") {
    //         $id = $_REQUEST['id'];
    //         $listExpenses->updateApprove($id);
    //     }
    // } 
    $listApprove = $listExpenses->getListApprove();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Phát sinh khoản chi</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            .none {
                display: none;
            }
        </style>

        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
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
                <div class="content-box column-left" style="width: 100%">
                    <div class="content-box-header">
                        <h3>Danh sách chi cần approve</h3>
                    </div>
                    <!-- STT, Mã đơn (hyperlink đến đơn hàng), Số tiền, Ghi chú, Approve -->
                     <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã đơn</th>
                                <th>Số tiền</th>
                                <th>Ghi chú</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- content -->
                        </tbody>
                    </table>
                    <form action="" method="POST" class="none">
                        <input type="text" name="id" id="fid"/>
                        <input type="text" name="action"/>
                        <input type="text" name="do" value="approve"/>
                        <input type="submit" id="fsubmit" value="submit" />
                    </form>
                </div>
                <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
                <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
                <script type="text/javascript">
                    var listApprove = <?php echo json_encode($listApprove); ?>;
                    var fm = "<tr><td>{0}</td> <td><a href='orderdetail.php?item={1}'>{1}</a></td> <td>{2}</td> <td>{3}</td> <td>{4}</td></tr>";
                    var html = "";
                    for (var i = 0; i < listApprove.length; i++) {
                        var obj = listApprove[i];
                        var btn = String.format('<input type="button" onclick="updateApprove({0})" value="Cập nhật"/>', obj.id);
                        html = String.format(fm, i+1, obj.madonhang, obj.sotien, obj.ghichu, btn);
                        $('#example > tbody').append(html);
                    }
                    $('#example').dataTable();
                    function updateApprove(id) {
                        $('#fid').val(id);
                        $('#fsubmit').click();
                    }
                </script>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
