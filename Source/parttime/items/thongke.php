<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_THONGKE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thống kê hàng đã bán</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <?php
        require_once '../models/donhang.php';
        $don_hang = new donhang();
        ?>
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/items_thongkedetail.js"></script>
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
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thống kê hàng đã bán</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="excel-export" action="thongke.php" method="POST">
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
                                    <input class="button" type="submit" id="thongke" name="thongke" value="Thống kê theo thời gian">
                                    <input class="button" type="submit" id="thongke2" name="thongke2" value="Thống kê 1 năm">
                                </div>
                            </form>
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Dòng sản phẩm</th>
                                                    <th>Tồn kho</th>
                                    <?php
                                function diffInMonths(\DateTime $date1, \DateTime $date2) {
                                    $diff =  $date1->diff($date2);
                                    $months = $diff->y * 12 + $diff->m + $diff->d / 30;
                                    return (int) round($months);
                                }
                                if (isset($_POST['thongke'])) {
                                    $tungay = $_POST['tungay'];
                                    $denngay = $_POST['denngay'];
                                } else {
                                    $tungay = date("Y-m-01", strtotime("-11 month"));
                                    $denngay = date("Y-m-01", strtotime("+1 month"));
                                }
                                $m = diffInMonths(new DateTime($tungay), new DateTime($denngay));
                                    $time = strtotime($tungay);
                                    $currM = date('n',$time);
                                    $currY = date('Y',$time);
                                    for ($i=1;$i<=$m;$i++) {
                                        echo "<th> T $currM-$currY </th>";
                                        if ($currM<12) {
                                            $currM++;
                                        } else {
                                            $currM=1;
                                            $currY++;
                                        }
                                    }
                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                <?php
                                require_once '../models/database.php';
                                function Display($tenloai, $maloai, $tot) {
                                    global $tungay, $denngay;
                                    $d1 = new DateTime($tungay);
                                    $d2 = new DateTime($denngay);
                                    $m = diffInMonths($d1, $d2);
                                    $dbi = new database();
                                    $sql = "SELECT DATE_FORMAT(d.ngaydat, '%c-%Y') AS Month, sum(c.soluong) AS total FROM donhang AS d LEFT JOIN (SELECT soluong, madon, masotranh FROM chitietdonhang GROUP BY madon, masotranh) as c ON d.madon = c.madon LEFT JOIN tranh AS t ON t.masotranh = c.masotranh WHERE t.maloai=$maloai AND d.ngaydat>='$tungay' AND d.ngaydat<='$denngay' GROUP BY Month ORDER BY d.ngaydat ASC";
                                    $dbi->setQuery($sql);
                                    $arri = $dbi->loadAllRow();
                                    $row = '<tr><td align="center"><a href="javascript:showOrdersByGuest('.$maloai.',\''.$tungay.'\',\''.$denngay.'\',1);">'.$tenloai.'</a></td>';
                                    $row .= '<td align="center"><a href="javascript:showOrdersByGuest('.$maloai.',\''.$tungay.'\',\''.$denngay.'\',0);">'.$tot.'</td>';
                                    if(is_array($arri)):
                                        $time = strtotime($tungay);
                                        $currM = date('n', $time);
                                        $currY = date('Y', $time);
                                        for ($i=1;$i<=$m;$i++) {
                                            $found = false;
                                            foreach ($arri as $itemi):
                                                $date = $itemi['Month'];
                                                if ($date == $currM."-".$currY) {
                                                    $row .= '<td align="center">'.$itemi['total'].'</td>';
                                                    $found = true;
                                                    break;
                                                }
                                            endforeach; 
                                            if (! $found) {
                                                $row .= '<td>0</td>';
                                            }
                                            if ($currM<12) {
                                                $currM++;
                                            } else {
                                                $currM=1;
                                                $currY++;
                                            }
                                        }
                                    endif;
                                    echo $row . '</tr>';
                                }

                                $db = new database();
                                $db->setQuery("select l.tenloai as tenloai, l.maloai as maloai, IFNULL(sum(tk.soluong),0) as total from loaitranh as l left join tranh as t on t.maloai = l.maloai left join tonkho as tk on tk.masotranh = t.masotranh group by l.maloai");
                                $arr = $db->loadAllRow();
                                if(is_array($arr)):
                                    foreach ($arr as $item):
                                        Display($item['tenloai'], $item['maloai'], $item['total'], '');  
                                    endforeach;
                                endif;
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
