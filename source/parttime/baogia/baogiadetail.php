<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_QLBAOGIA, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chi tiết báo giá</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            .bordered tbody tr.alt-row { background: #f3f3f3 !important; }
            /* Scroll bar */
            div#detail_dialog_content { max-height: 450px; }
            div#detail_dialog_content { overflow: auto; scrollbar-base-color:#ffeaff; }
            .highlight-red{
                background-color: red;
                color: red;
            }
            .highlight-yellow{
                background-color: yellow;
                color: yellow;
            }
            .highlight-green{
                background-color: green;
                color: green;
            }
        </style>
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />



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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <!--<li>
                        <a class="shortcut-button add" href="../guest_development/add-new.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button list" href="../guest_development/add-from-db.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển từ hệ thống</span>
                        </a>
                    </li>-->
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Chi tiết báo giá</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                        <?php 
                        require_once '../models/baogiadetail.php';
                        
                        // Get input data
                        $baogiaid = (isset($_GET['baogiaid'])) ? $_GET['baogiaid'] : '';
                        // DB models
                        $baogia = new baogiadetail();
                        $baogiachitiet = $baogia->list_all_baogiaid($baogiaid);
                        ?>
                        <table class="bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày</th>
                                    <th>Ghi chú</th>
                            </thead>
                            <tbody>
                                <?php 
                                if ($baogiachitiet != NULL):
                                    $i = 0;
                                    $css = array('0' => 'alt-row', '1' => '');
                                    
                                    foreach ($baogiachitiet as $t):
                                ?>
                                    <tr class="<?php echo $css[(++$i) % 2]  ?>">
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <span class="orange"><?php echo dbtime_2_systime($t->ngaygionote, 'Y-m-d'); ?></span>
                                        </td>
                                        <td>
                                            <?php echo $t->noidung; ?>
                                        </td>
                                    </tr>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
