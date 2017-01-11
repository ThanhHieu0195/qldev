<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_REPORT, F_REPORT_RPT_BY_GUEST_GROUP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tổng hợp theo nhóm khách</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .bold { font-weight: bolder; }
            div#demo { margin: 20px auto !important; overflow: auto; scrollbar-base-color:#ffeaff; }
        </style>
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
                        <h3>Tổng hợp theo nhóm khách</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php require_once 'rpt_part_monthyear.php'; ?>
                                
                                <?php
                                    require_once '../models/donhang.php';
                                
                                    if(isset($_POST['view'])): 
                                        $year = $_POST["year"];
                                ?>
                                    <div id="dt_example">
                                        <div id="container">
                                            <div id="demo">
                                                <div>
                                                    &nbsp;<img src="../resources/images/icons/calendar_16.png" alt="calendar"> Doanh số năm <label class="price bold"><?php echo $year; ?></label>
                                                </div>
                                                <table class="bordered" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th width="28%">Tên nhóm khách</th>
                                                            <th width="6%">T1</th>
                                                            <th width="6%">T2</th>
                                                            <th width="6%">T3</th>
                                                            <th width="6%">T4</th>
                                                            <th width="6%">T5</th>
                                                            <th width="6%">T6</th>
                                                            <th width="6%">T7</th>
                                                            <th width="6%">T8</th>
                                                            <th width="6%">T9</th>
                                                            <th width="6%">T10</th>
                                                            <th width="6%">T11</th>
                                                            <th width="6%">T12</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $db = new database();
                                                        $db->setQuery("SELECT * FROM nhomkhach ORDER BY tennhom ASC");
                                                        $array = $db->loadAllRow();
                                                        
                                                        foreach ($array as $row) {
                                                            $dh = new donhang();
                                                            $revenue = $dh->tong_hop_theo_nhom_khach($row['manhom'], $year);
                                                            echo "<tr>";
                                                            echo sprintf("<td class='blue-text'>%s</td>", $row['tennhom']);
                                                            foreach ($revenue as $value) {
                                                                //$value = 100000000;
                                                                echo sprintf("<td>%s</td>", number_format($value, 0, '', '.'));
                                                            }
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 20px;"></div>
                                <?php endif; ?>
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