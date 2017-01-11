<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_ORDER_LIST, TRUE);
require_once "../models/deliver.php";
// Authenticate
$model_deliver = new deliver();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách đơn hàng chờ giao</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            @import "../resources/chosen/chosen.css";
            @import "../resources/jquery.bpopup/style.min.css";
            img { vertical-align: middle; }
            .none{
                display: none;
            }
            .btndeliver {
                height: 50px;
                width: 200px;
                float: right;
                margin: 10px;
                padding: 10px;
                text-shadow: 2px 2px 2px;
            }
            .btndeliver:hover{
                font-weight: bold;
            }
            #fdeliver{
                width: 400px;
                padding: 20px;
                background-color: #FFFFFF;
            }
            #fdeliver label {
                font-weight: bold;
            }
            #fdeliver td {
                padding: 10px 0px;
            }
            #submit {
                height: 50px;
                width: 100px;
                margin: 10px;
                padding: 10px;
                text-shadow: 2px 2px 2px;
            }

            #cancel {
                height: 50px;
                width: 100px;
                margin: 10px;
                padding: 10px;
                text-shadow: 2px 2px 2px;
            }

            #submit:hover{
                font-weight: bold;
            }
        </style>

        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#cashdelivery').numeric();
                // click chọn nhân viên giao hàng
                $('#select_deliver').click(function(event) {
                    /* Act on the event */
                    var listChecked = $('input[name="cb_item"]:checked');
                    if (listChecked.length > 0) {
                        fdeliver = $('#fdeliver').bPopup();
                        $("#sdeliver").chosen();
                    } else {
                        alert('Chưa có checkbox nào được chọn');
                    }
                });
                // submit form chọn nhân viên
                $('#cancel').click(function(event) {
                    fdeliver.close();
                });
                $('#submit').click(function(event) {
                    /* Act on the event */
                    var listEmployee = $('#sdeliver').val();
                    var money = $('#cashdelivery').val();
                    var checkedBill = $('#cbill').is(':checked') ? 1 : 0;
                    var listOrder = getInfoOderChecked();

                    // kiểm tra điều kiện trước khi sử lí dữ liệu
                    if (listEmployee.length > 0 && money != "") {
                         $.ajax({
                            url: '../ajaxserver/delivery_server.php',
                            type: 'POST',
                            dataType: 'text',
                            data: {action: 1, do:'addEmployeetoDelivery', employees:listEmployee, orders:listOrder,isBill:checkedBill, money:money},
                        })
                        .done(function(data) {
                            var json = $.parseJSON(data);
                            if (json.result == "success") {
                                fdeliver.close();
                                location.reload();
                            }
                        });
                    } 
                });
            });

            function getInfoOderChecked() {
                // body...
                var objs = $('input[name="cb_item"]:checked');
                var arr = [];
                for (var i = 0; i < objs.length; i++) {
                    arr.push(objs[i].value);
                }
                return arr;
            }

            $(function() {
                var i = 0;
                $.ajax({
                    url: '../ajaxserver/order_list_server.php',
                    type: 'GET',
                    data: {sEcho : 1},
                })
                .done(function(data) {
                    var json = jQuery.parseJSON(data);
                    html = "";
                    fm = "<tr> <td>{0}</td> <td>{1}</td> <td>{2}</td> <td>{3}</td> <td>{4}</td> <td>{5}</td> <td>{6}</td> <td>{7}</td> </tr>";

                     for (var i = 0; i < json.aaData.length; i++) {
                        console.log(json.aaData);
                        var aData = json.aaData[i];
                        if(aData[0] == '') {
                            html += String.format(fm, "<span class='price'>" + aData[3] + "</span>", '', '','','','', '', '');
                        }
                        else {
                            if (aData[11] == "order") {
                                rw0 = "<a href='../orders/orderdetail.php?item=" + aData[0] + "' id='div" + i + "'>" + aData[0] + "</a>";
                            }else {
                                rw0 = "<a href='../orders/vouchers.php?item=" + aData[0] + "' id='div" + i + "'>" + aData[0] + "</a>";
                            }
                             rw1 = "<label style='text-align: center; color: blue;'>" + aData[1] + "</label>";
                             rw2 = aData[9];
                            if ((aData[5]) && (aData[5]!='00:00:00') && (aData[5]!='23:00:00')) {
                                rw3 = "<label style='text-align: center; color: blue;'>" + aData[4] + "-" + aData[5] + "</label>";
                            } else {
                                rw3 = "<label style='text-align: center; color: blue;'>" + aData[4] + "</label>";
                            }
                             rw4 = aData[6];
                             rw5 = '<button type="button" onclick="f1(this);" value="' + aData[7] +'">'+aData[7]+' </button>';
                             if (aData[10] == null) {
                                rw6 = '-----';
                             } else {
                                rw6 = aData[10];
                             }
                             rw7 = '<div style="display: flex;"> <input name="cb_item" type="checkbox" value="'+aData[0]+'"/></div>';
                             html += String.format(fm, rw0, rw1, rw2, rw3, rw4, rw5, rw6, rw7);
                        }
                    }
                    console.log(html);
                    $('#example > tbody').html(html);
                    $('#example').dataTable({
                        "bSort": false,
                        "iDisplayLength": 20
                    });
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
                        <h3>Đơn hàng chờ giao</h3>
                    </div>
                    <input class="btndeliver" type="button" id="select_deliver" name="select_deliver" value="Chọn nhân viên giao hàng" />
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Địa chỉ</th>
                                            <th>Ngày giao</th>
                                            <th>Thành tiền</th>
                                            <th>Liên hệ</th>
                                            <th>Nhân viên giao</th>
                                            <th>Chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div style="padding-bottom: 10px;"></div>
                            </div>
                        </div>
                    </div>

                    <form action="" id="fdeliver" class="none">
                        <h3>THÊM NHÂN VIÊN GIAO HÀNG VÀO ĐƠN HÀNG</h3>
                        <table>
                            <tr>
                                <td><label>Nhân viên giao hàng:</label></td>
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
                                    <select name="sdeliver[]" id="sdeliver" data-placeholder=" " multiple style="width:250px;" tabindex="4" >
                                        <option value=""></option>
                                        <?php for ($i=0; $i < count($list_delivers); $i++) { 
                                            $obj = $list_delivers[$i];
                                        ?>
                                        <option value="<?php echo $obj['manv']; ?>"><?php echo $obj['hoten']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Tiền giao hàng:</label>
                                </td>
                                <td>
                                    <input type="text" name="cashdelivery" id="cashdelivery" placeholder="0"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Sinh phiếu chi</label></td><td><input type="checkbox" name="cbill" id="cbill"/></td>
                            </tr>
                            <tr>
                                <td><label>Lưu ý</label></td><td><label>Nhân viên công ty giao hàng thì không check vào</label></td>
                            </tr>
                        </table>
                        <input id="submit" type="button" value="Xác Nhận" />
                        <input id="cancel" type="button" value="Hủy" />
                    </form>

                </div>
                <?php require_once '../part/footer.php'; ?>

                <!-- thiết lập khung select -->
                <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                <script type="text/javascript">
                </script>
                <!-- bpopup -->
                <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
                <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
