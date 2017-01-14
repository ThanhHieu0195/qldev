<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_FINANCE, F_ORDERS_CASHFLOW_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Đơn hàng</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
    </head><body>
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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Đơn hàng chờ giao</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <table type="filter" class="bordered" id="items">
                                <thead>
                                    <tr id="items_head">
                                    <th>Loại</th>
                                    <?php 
                                    $currM = date('m');
                                    $currY = date('Y');
                                    for ($i=1;$i<=12;$i++) {
                                        echo "<th> Tháng $currM-$currY </th>";
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
                                <tbody id="items_body">
                                <?php
                                function Display(array $arr, $name, $name2, $type) {
                                 $currM = date('m');
                                 $currY = date('Y');
                                 echo "<tr><td>$name2</td>";
                                 for ($i=1;$i<=12;$i++) {
                                    $match = false;
                                    foreach ($arr as $item):
                                      if (($item['M']==$currM) && ($item['Y']==$currY)) {
                                        echo '<td> <a href="../finance/cashflowdetail.php?month='.$currM.'&year='.$currY.'&type='.$type.'" target="blank">' . number_2_string($item[$name]) . '</a> </td>';
                                        $match=true;
                                      }
                                    endforeach;
                                    if (! $match) {
                                      echo "<td>0</td>";
                                    }
                                    if ($currM<12) {
                                        $currM++;
                                    } else {
                                        $currM=1;
                                        $currY++;
                                    }
                                 }
                                 echo "</tr>";
                                }
                                require_once '../models/database.php';

                                $db = new database();
                                $db->setQuery("SELECT MONTH(cashing_date) as M, YEAR(cashing_date) as Y, DATE_FORMAT(d.cashing_date, '%m-%Y') AS Month, SUM(d.thanhtien) as TongCong, SUM(d.duatruoc) as DatCoc, SUM(d.conlai) as PhaiThu, SUM(o.money_amount) as DaThu from donhang AS d LEFT JOIN (select order_id, sum(money_amount) as money_amount from  orders_cashing_history group by order_id) as o ON o.order_id = d.madon WHERE (trangthai=0) AND (d.thanhtien >= 0) AND (d.approved = '1') AND (d.conlai >= 0) AND MONTH(d.cashing_date)>=MONTH(NOW()) AND YEAR(d.cashing_date)>=YEAR(NOW()) GROUP BY DATE_FORMAT(d.cashing_date, '%m-%Y') ORDER BY d.cashing_date ASC");
                                $arr = $db->loadAllRow();
                                if(is_array($arr)):
                                  Display($arr, 'TongCong', 'Tổng tiền',1);
                                  Display($arr, 'DatCoc', 'Tiền cọc',1);
                                  Display($arr, 'DaThu', 'Tiền đã thu',1);
                                  Display($arr, 'PhaiThu', 'Dự kiến thu',1);
                                endif;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Đơn hàng đã giao</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <table type="filter" class="bordered" id="items">
                                <thead>
                                    <tr id="items_head">
                                    <th>Loại</th>
                                    <?php
                                    $currM = date('m');
                                    $currY = date('Y');
                                    for ($i=1;$i<=12;$i++) {
                                        echo "<th> Tháng $currM-$currY </th>";
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
                                <?php
                                require_once '../models/database.php';

                                $db = new database();
                                $db->setQuery("SELECT MONTH(cashing_date) as M, YEAR(cashing_date) as Y, DATE_FORMAT(d.cashing_date, '%m-%Y') AS Month, SUM(d.thanhtien) as TongCong, SUM(d.duatruoc) as DatCoc, SUM(d.conlai) as PhaiThu, SUM(o.money_amount) as DaThu from donhang AS d LEFT JOIN (select order_id, sum(money_amount) as money_amount from  orders_cashing_history group by order_id) as o ON o.order_id = d.madon WHERE (trangthai=1) AND (d.thanhtien >= 0) AND (d.approved = '1') AND (d.conlai >= 0) AND MONTH(d.cashing_date)>=MONTH(NOW()) AND YEAR(d.cashing_date)>=YEAR(NOW()) GROUP BY DATE_FORMAT(d.cashing_date, '%m-%Y') ORDER BY d.cashing_date ASC");
                                $arr = $db->loadAllRow();
                                if(is_array($arr)):
                                  Display($arr, 'TongCong', 'Tổng tiền',0);
                                  Display($arr, 'DatCoc', 'Tiền cọc',0);
                                  Display($arr, 'DaThu', 'Tiền đã thu',0);
                                  Display($arr, 'PhaiThu', 'Dự kiến thu',0);
                                endif;
                                ?>
                                <tbody id="items_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Tổng hợp</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <table type="filter" class="bordered" id="items">
                                <thead>
                                    <tr id="items_head">
                                    <th>Loại</th>
                                    <?php
                                    $currM = date('m');
                                    $currY = date('Y');
                                    for ($i=1;$i<=12;$i++) {
                                        echo "<th> Tháng $currM-$currY </th>";
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
                                <?php
                                require_once '../models/database.php';

                                $db = new database();
                                $db->setQuery("SELECT MONTH(cashing_date) as M, YEAR(cashing_date) as Y, DATE_FORMAT(d.cashing_date, '%m-%Y') AS Month, SUM(d.thanhtien) as TongCong, SUM(d.duatruoc) as DatCoc, SUM(d.conlai) as PhaiThu, SUM(o.money_amount) as DaThu from donhang AS d LEFT JOIN (select order_id, sum(money_amount) as money_amount from  orders_cashing_history group by order_id) as o ON o.order_id = d.madon WHERE (d.thanhtien >= 0) AND (d.approved = '1') AND (d.conlai >= 0) AND MONTH(d.cashing_date)>=MONTH(NOW()) AND YEAR(d.cashing_date)>=YEAR(NOW()) GROUP BY DATE_FORMAT(d.cashing_date, '%m-%Y') ORDER BY d.cashing_date ASC");
                                $arr = $db->loadAllRow();
                                if(is_array($arr)):
                                  Display($arr, 'TongCong', 'Tổng tiền',9);
                                  Display($arr, 'DatCoc', 'Tiền cọc',9);
                                  Display($arr, 'DaThu', 'Tiền đã thu',9);
                                  Display($arr, 'PhaiThu', 'Dự kiến thu',9);
                                endif;
                                ?>
                                <tbody id="items_body">
                                </tbody>
                            </table>
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
