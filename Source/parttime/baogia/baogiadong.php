<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_QLBAOGIA, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Quản lý báo giá</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript">
         $(function() {
    // datepicker
        var dates = $("#tungay, #denngay").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            /*var option = this.id == "tungay" ? "minDate" : "maxDate",
                instance = $( this ).data( "datepicker" ),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );*/
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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <li>
                        <a class="shortcut-button add current" href="../baogia/baogiamo.php">
                            <span class="png_bg">Quản lý báo giá mở</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button add current" href="../baogia/baogiadong.php">
                            <span class="png_bg">Quản lý báo giá đóng</span>
                        </a>
                    </li>
                </ul>
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Quản lý báo giá đóng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="excel-export" action="baogiadong.php" method="POST">
                                <div>
                                    <label>Từ ngày (yyyy-mm-dd):</label>
                                    <input id="tungay" name="tungay"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="<?php echo (isset($_REQUEST['tungay'])) ? $_REQUEST['tungay'] : '' ?>" 
                                           type="text" readonly="readonly" />
                                    <span id="error-1" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Đến ngày (yyyy-mm-dd):</label>
                                    <input id="denngay" name="denngay"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="<?php echo (isset($_REQUEST['denngay'])) ? $_REQUEST['denngay'] : '' ?>"
                                           type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <input class="button" type="submit" id="thongke" name="thongke" value="Thống kê">
                                </div>
                                <br>
                            </form>
                                    <?php
                                if (isset($_POST['thongke'])) {
                                    $tungay = $_POST['tungay'];
                                    $denngay = $_POST['denngay'];
                                } else {
                                    $day = date('w');
                                    $tungay = date("Y-m-d", mktime(0, 0, 0, date("m"), 1));
                                    $denngay = date("Y-m-d", mktime(0, 0, 0, date("m")+1, 0));
                                }
                                    ?>
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">         
                               <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Nguyên nhân</th>
                                                    <th>Số lượng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            <?php
                                require_once '../models/baogia.php';
                                $baogia = new baogia();
                                $manv = '';
                                if (! verify_access_right ( current_account (), F_VIEW_QLBAOGIA_ALL )) {
                                    $manv = current_account ();
                                }
                                $arri = $baogia->list_close_by_reason($tungay, $denngay, $manv);
                                if(is_array($arri)):
                                    $i = 1;
                                    foreach ($arri as $itemi):
                                        $row = '<tr><td>' . $i . '</td>'; 
                                        $row .= '<td>' . $itemi['nguyennhan'] . '</td>';
                                        $row .= '<td>' . $itemi['soluong'] . '</td></tr>';
                                        echo $row;
                                        $i++;
                                    endforeach;
                                endif;      
                            ?>
                                            </tbody>
                                        </table>
                             </div>
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>ID</th>
                                                    <th>Ngày báo giá</th>
                                                    <th>Ngày đóng</th>
                                                    <th>Tên nhân viên</th>
                                                    <th>Ngày cập nhật</th>
                                                    <th>Lần cập nhật cuối</th>
                                                    <th>Nguyên nhân</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                <?php
                                require_once '../models/baogia.php';
                                $baogia = new baogia();
                                $arri = $baogia->list_by_state(0, $tungay, $denngay, $manv);
                                $row = '<tr>';
                                if(is_array($arri)):
                                    $i = 1;
                                    foreach ($arri as $itemi):
                                            $row .= '<td>'.$i.'</td>'.'<td><a href="../baogia/baogiadetail.php?baogiaid='. $itemi['id'] . '" target="_blank">'.$itemi['id'].'</a></td>';
                                            $row .= '<td>'.$itemi['ngaybaogia'].'</td>'.'<td>'.$itemi['ngayclose'].'</td>'.'<td>'.$itemi['hoten'].'</td>';
                                            $row .= '<td>'.$itemi['ngaycapnhat'].'</td><td>'.$itemi['capnhat'].'</td>';
                                            if ($itemi['nguyennhan']=="Thành đơn hàng"){
                                                $row .= '<td ><a href="../orders/orderdetail.php?item='.$itemi['id'].'" target="blank">'.$itemi['nguyennhan'].'</a></td></tr>';
                                            } else {
                                                $row .= '<td >'.$itemi['nguyennhan'].'</td></tr>';
                                            }
                                            $i++;
                                    endforeach;
                                endif;
                                echo $row . '</tr>';
                                ?>
                                            </tbody>
                                        </table>
                                        <div style="padding-bottom: 10px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div id="detail_dialog" class="bMulti2" style="display: none">
                    <span class="button_popup b-close"><span>X</span></span>
                    <div id="detail_dialog_content">
                       <div>
                        <table class="bordered" id="detail_items">
                            <thead>
                                <tr id="detail_size_head">
                                </tr>
                            </thead>
                            <tbody id="detail_size_body">
                            </tbody>
                        </table>
                       </div>
                       <div>
                        <br>
                        <table class="bordered" id="detail_items">
                            <thead>
                                <tr id="detail_color_head">
                                </tr>
                            </thead>
                            <tbody id="detail_color_body">
                            </tbody>
                        </table>
                        <br>
                       </div>
                       <div>
                        <table class="bordered" id="detail_items">
                            <thead>
                                <tr id="detail_design_head">
                                </tr>
                            </thead>
                            <tbody id="detail_design_body">
                            </tbody>
                        </table>
                       </div>
                    </div>
                </div>
                 <div id="popup" style="display: none">
                    <div id="popup_msg"></div>
                </div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
