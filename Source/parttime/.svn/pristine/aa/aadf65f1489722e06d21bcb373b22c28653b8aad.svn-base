<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_MUAHANG, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thống kê sản phẩm</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            #dialog-form label, #dialog-form input { display: block; }
            #dialog-form input.text { margin-bottom: 12px; width: 95%; padding: .4em; }
            #dialog-form fieldset { padding: 0; border: 0; margin-top: 25px; }
            #dialog-form h1 { font-size: 1.2em; margin: .6em 0; }
            #loading { display: none; }
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
               <!-- //-- REQ20120508_BinhLV_N -->
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thống kê sản phẩm</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="excel-export" action="muahang.php" method="POST">
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
                                Chọn dòng sản phẩm:
                                <select name="sanpham" id="sanpham" data-placeholder=" " class="chosen-select" style="width:350px;" tabindex="4">
                                    <?php
                                    require_once '../models/database.php';
                                    echo "<option value=\"-1\">Chọn dòng sản phẩm</option>";
                                    $db = new database();
                                    $db->setQuery("SELECT maloai, tenloai FROM loaitranh ORDER BY maloai");
                                    $arr = $db->loadAllRow();
                                    if(is_array($arr)):
                                        foreach ($arr as $item):
                                            echo "<option value=\"{$item['maloai']}\">{$item['tenloai']}</option>";
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                                Dự tính đặt thêm (m2):
                                <input type="text" id="datthem" name="datthem" value="1000"> 
                                <div>
                                    <input class="button" type="submit" id="thongke" name="thongke" value="Thống kê">
                                </div>
                                <br>
                            </form>
                                    <?php
                                if (isset($_POST['thongke'])) {
                                    $tungay = $_POST['tungay'];
                                    $denngay = $_POST['denngay'];
                                    if ($_POST['sanpham']<>-1) {
                                        $sanpham = $_POST['sanpham'];
                                    }
                                    if (isset($_POST['datthem']) && ($_POST['datthem']<>'')) {
                                        $datthem = $_POST['datthem'];
                                    }
                                } else {
                                    $day = date('w');
                                    $tungay = '2016-08-01';
                                    $denngay = date('Y-m-d', strtotime('+'.(30-$day).' days'));
                                }
 
                                    ?>
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>ID</th>
                                                    <th>Kích thướt</th>
                                                    <th>Diện tích</th>
                                                    <th>Màu sắc</td>
                                                    <th>Hoa văn</th>
                                                    <th>Lượng bán</th>
                                                    <th>SQM bán</td>
                                                    <th>Tổng SQM bán</th>
                                                    <th>Phần trăm SQM bán</th>
                                                    <th>Lượng tồn</td>
                                                    <th>SQM tồn</th>
                                                    <th>Đặt thêm</th>
                                                    <th>SL Đặt thêm</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                <?php
                                require_once '../models/database.php';
                                $db = new database();
                                $sql = "select c.masotranh as matranh, t.dai as dai, t.rong as rong, @dtx:=t.dai*t.rong/10000 as dientich, t.tongmau as mausac, t.hoavan as hoavan, sum(c.soluong) as luongban, sum(c.soluong)*t.dai*t.rong/10000 as SQMBan, BA.SQTban as SQMTotal, round(sum(c.soluong)*t.dai*t.rong/BA.SQTban/100,2) as phantram, tk.tonkho as tonkho, tk.tonkho*t.dai*t.rong/10000 as SQMTonkho, round((round(sum(c.soluong)*t.dai*t.rong/BA.SQTban/10000,2)*(TK.SQTtonkho + ".$datthem.")-tk.tonkho*t.dai*t.rong/10000),2) as SQMDatthem, round(round((round(sum(c.soluong)*t.dai*t.rong/BA.SQTban/10000,2)*(TK.SQTtonkho + ".$datthem.")-tk.tonkho*t.dai*t.rong/10000),2)/@dtx,0) as SLDatthem  from (select sum(round(k.soluong*t.dai*t.rong/10000,2)) as SQTtonkho from tonkho as k inner join tranh as t on t.masotranh = k.masotranh where t.maloai=".$sanpham.") as TK, (select sum(round(c.soluong*t.dai*t.rong/10000,2)) as SQTban from chitietdonhang as c inner join tranh as t on t.masotranh = c.masotranh inner join donhang as d on d.madon = c.madon where t.maloai=".$sanpham." and d.ngaydat>='".$tungay."' and d.ngaydat<='".$denngay."') as BA, chitietdonhang as c inner join tranh as t on t.masotranh=c.masotranh inner join donhang as d on d.madon = c.madon inner join (select sum(k.soluong) as tonkho, k.masotranh as matranh from tonkho as k inner join tranh as t on t.masotranh = k.masotranh where t.maloai=".$sanpham." group by k.masotranh) as tk on tk.matranh = c.masotranh where t.maloai=".$sanpham." and d.ngaydat>='".$tungay."' and d.ngaydat<='".$denngay."' group by c.masotranh order by phantram desc";
                                //echo $sql;
                                $db->setQuery($sql);
                                $arr = $db->loadAllRow();
                                if(is_array($arr)):
                                    $i = 1;
                                    foreach ($arr as $item):
                                        $row = '<tr>';
                                        $row .= '<td>'.$i.'</td>'.'<td>'.$item['matranh'].'</td>';
                                        $row .= '<td>'.$item['dai'].'x'.$item['rong'].'</td>';
                                        $row .= '<td>'.$item['dientich'].'</td>';
                                        $row .= '<td>'.$item['mausac'].'</td>';
                                        $row .= '<td>'.$item['hoavan'].'</td>';
                                        $row .= '<td>'.$item['luongban'].'</td>';
                                        $row .= '<td>'.$item['SQMBan'].'</td>';
                                        $row .= '<td>'.$item['SQMTotal'].'</td>';
                                        $row .= '<td>'.$item['phantram'].'</td>';
                                        $row .= '<td>'.$item['tonkho'].'</td>';
                                        $row .= '<td>'.$item['SQMTonkho'].'</td>';
                                        $row .= '<td>'.$item['SQMDatthem'].'</td>';
                                        $row .= '<td>'.$item['SLDatthem'].'</td>';
                                        $row .= '</tr>';
                                        echo $row;
                                        $i++;
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
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
