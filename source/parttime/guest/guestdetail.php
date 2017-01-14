<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST, F_GUEST_GUEST_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chi tiết khách hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .ui-combobox {
                position: relative;
                display: inline-block;
            }
            .ui-combobox-toggle {
                position: absolute;
                top: 0;
                bottom: 0;
                margin-left: -1px;
                padding: 0;
                /* adjust styles for IE 6/7 */
                *height: 1.7em;
                *top: 0.1em;
            }
            .ui-combobox-input {
                margin: 0;
                padding: 0.3em;
            }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": false,
                    "sAjaxSource": "../ajaxserver/assign_guest_list_server.php?id=<?php echo $_GET['item']; ?>",
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 6 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html("<span class='blue-text'>" + aData[0] + "</span>");
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html("<span class='blue-violet'>" + aData[2] + "</span>");
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html("<span class='orange'>" + aData[4] + "</span>");;
                        $('td:eq(5)', nRow).html(aData[5]);
                        $('td:eq(6)', nRow).html("<span class='blue-text'>" + aData[6] + "</span>");
                    }
                });
            });
        </script>
    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

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

                    <li><a class="shortcut-button upload-image" href="guestlist.php"><span class="png_bg">
                    Danh sách khách hàng
                            </span></a></li>

                </ul><!-- End .shortcut-buttons-set -->

                <div class="content-box column-left" style="width:100%">

                    <div class="content-box-header">

                        <h3>Chi tiết khách hàng</h3>

                    </div>

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                if (isset($_POST['submit'])) {
                                    $makhach = $_POST['item'];
                                    $hoten = $_POST['hoten'];
                                    $manhom = $_POST['nhomkhach'];
                                    $tiemnang = $_POST['tiemnang'];
                                    $dienthoai1 = $_POST['dienthoai1'];
                                    $dienthoai2 = $_POST['dienthoai2'];
                                    $dienthoai3 = $_POST['dienthoai3'];
                                    $email = $_POST['email'];
                                    $emailphu = $_POST['emailphu'];
                                    $diachi = $_POST['diachi'];
                                    $quan = $_POST['quan'];
                                    $tp = $_POST['tp'];

                                    include_once '../models/khach.php';
                                    $guest = new khach();
                                    $them_khach = $guest->cap_nhat_thong_tin($makhach, $hoten, $manhom, $tiemnang, $dienthoai1, $dienthoai2, $dienthoai3, $email, $emailphu, $diachi, $quan, $tp);
                                    if ($them_khach) {
                                        echo '<center><span class="input-notification success png_bg">Cập nhật thông tin khách hàng thành công</span><br /><br /></center>';
                                    } else {
                                        echo '<center><span class="input-notification error png_bg">' . $guest->getMessage() . '</span></center>';
                                    }
                                }
                                ?>
                                <table>                                                       
                                    <tfoot>                                        
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="submit" value="Cập nhật" />
                                                </div>                                            </td>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php
                                        include_once '../models/khach.php';
                                        $makhach = $_GET['item'];
                                        $khach = new khach();
                                        $row = $khach->thong_tin_khach_hang($makhach);
                                        ?>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Họ tên</span>                                            </td>
                                            <td width="80%">
                                                <input class="text-input small-input" type="hidden" id="item" name="item" value="<?php echo $row['makhach'] ?>" />
                                                <span id="sprytextfield1">
                                                    <input class="text-input small-input" type="text" id="hoten" name="hoten" value="<?php echo $row['hoten'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập họ tên.</span></span> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Nhóm khách</span>
                                            </td>
                                            <td>
                                                <select name="nhomkhach" id="nhomkhach">
                                                    <?php
                                                    include_once '../models/database.php';
                                                    $db = new database();
                                                    $db->setQuery("SELECT * FROM nhomkhach");
                                                    $array = $db->loadAllRow();

                                                    //Duyet ket qua
                                                    foreach ($array as $value) {
                                                        if ($value['manhom'] == $row['manhom'])
                                                            echo "<option value='" . $value['manhom'] . "' selected>" . $value['tennhom'] . "</option>";
                                                        else
                                                            echo "<option value='" . $value['manhom'] . "'>" . $value['tennhom'] . "</option>";
                                                    }
                                                    ?>
                                                </select>                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span class="bold">Điện thoại</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" id="dienthoai1" name="dienthoai1" value="<?php echo $row['dienthoai1'] ?>" />
                                                    <button type="button" onclick='f1(this);' value="<?php echo $row['dienthoai1']; ?>"> <?php echo $row['dienthoai1']; ?> </button>
                                                    <br />
                                                    <span class="textfieldRequiredMsg">Nhập số điện thoại 1.</span></span><span id="sprytextfield4">
                                                    <input class="text-input small-input" type="text" id="dienthoai2" name="dienthoai2" value="<?php echo $row['dienthoai2'] ?>" />
                                                    <button type="button" onclick='f1(this);' value="<?php echo $row['dienthoai2']; ?>"> <?php echo $row['dienthoai2']; ?> </button>
                                                    <span class="textfieldRequiredMsg">Nhập số điện thoại 2.</span></span><span id="sprytextfield5">
                                                    <br />
                                                    <input class="text-input small-input" type="text" id="dienthoai3" name="dienthoai3" value="<?php echo $row['dienthoai3'] ?>" />
                                                    <button type="button" onclick='f1(this);' value="<?php echo $row['dienthoai3']; ?>"> <?php echo $row['dienthoai3']; ?> </button>
                                                    <span class="textfieldRequiredMsg">Nhập số điện thoại 3.</span></span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Email marketing</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" id="email" name="email" value="<?php echo $row['email'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập email.</span></span><span id="sprytextfield4">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Email phụ</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" id="emailphu" name="emailphu" value="<?php echo $row['emailphu'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập email</span></span><span id="sprytextfield5">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Địa chỉ</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" id="diachi" name="diachi" value="<?php echo $row['diachi'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập Địa chỉ</span></span><span id="sprytextfield5">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Quận</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" id="quan" name="quan" value="<?php echo $row['quan'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập Quận</span></span><span id="sprytextfield5">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Thành phố</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" id="tp" name="tp" value="<?php echo $row['tp'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập Thành phố</span></span><span id="sprytextfield5">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tiềm năng</span>                                            </td>
                                            <td>
                                                <input type="radio" name="tiemnang" value="0" checked="<?php if ($row['tiemnang'] == 0)
                                                        echo "checked" ?>" />Không<br />
                                                 <input type="radio" name="tiemnang"  value="1" checked="<?php if ($row['tiemnang'] == 1)
                                                            echo "checked" ?>" />Có                                            </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </form>
                                 <br />
                                 <br />
                             </div> <!-- End #tab3 -->

                         </div> <!-- End .content-box-content -->

                     </div> <!-- End .content-box -->
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách coupon assign cho khách hàng</h3>
                    </div>
                    <div class="content-box-content tab-content default-tab" id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã coupon</th>
                                            <th>Nhóm coupon</th>
                                            <th>Hạn sử dụng</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Thành tiền</th>
                                            <th>Loại</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php require_once '../part/footer.php'; ?>

            </div> <!-- End #main-content -->

        </div>
        <script type="text/javascript">
            <!--
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
            //-->
        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
