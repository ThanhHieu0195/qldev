<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_FINANCE, F_ORDERS_CASHFLOW_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Đơn hàng đã thu tiền</title>
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
                        <h3>Thống kê đơn hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="get">
                                <div>
                                    <?php
                                    $month = isset($_GET['month']) ? $_GET['month'] : '';
                                    $year = isset($_GET['year']) ? $_GET['year'] : '';
                                    $type = isset($_GET['type']) ? $_GET['type'] : '';
                                    ?>
                                <table type="filter" class="bordered" id="items">
                                    <thead>
                                        <tr id="items_head">
                                            <th>Mã hóa đơn</th>
                                            <th>Tổng số tiền</th>
                                            <th>Tiền cọc</th>
                                            <th>Tiền đã thu</th>
                                            <th>Tiền dự kiến thu</th>
                                            <th>Ngày dự kiến thu</th>
                                            <th>Kiểm tra</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items_body">
                                <?php
                                require_once '../models/database.php';

                                $db = new database();
                                $sql = "SELECT d.madon as md, d.cashing_date as ngayphaithu, d.thanhtien as tongcong, d.duatruoc as tiencoc, IFNULL(o.money_amount,0) as dathu, d.conlai as phaithu, (case when (IFNULL(o.money_amount,0) + d.conlai = d.thanhtien) then 'Đúng' else 'Sai' end) as state from donhang AS d LEFT JOIN (select order_id, sum(money_amount) as money_amount  from orders_cashing_history group by order_id) as o ON o.order_id = d.madon WHERE (trangthai<>$type) AND (d.thanhtien >= 0) AND (d.approved = '1') AND (d.conlai >= 0) AND (MONTH(d.cashing_date)='".$month."') AND (YEAR(d.cashing_date)='".$year."') ORDER BY d.cashing_date ASC";
                                $db->setQuery($sql);
                                $arr = $db->loadAllRow();
                                if(is_array($arr)):
                                    foreach ($arr as $item):
                                        echo "<tr><td>".$item['md']."</td><td>".number_2_string($item['tongcong'])."</td><td>".number_2_string($item['tiencoc'])."</td><td>".number_2_string($item['dathu'])."</td><td>".number_2_string($item['phaithu'])."</td><td>".$item['ngayphaithu']."</td><td>".$item['state']."</td></tr>";
                                    endforeach;
                                endif;
                                ?>                                    
                                    </tbody>
                                </table>
                            </form>
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
