<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_TRADE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cập nhật doanh số hàng ngày</title>
        <?php 
        require_once '../part/cssjs.php';
        require_once '../models/nhanvien.php'; 
        require_once '../config/constants.php';
        require_once '../models/helper.php';
        ?>
        
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/trade.js"></script>
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <style type="text/css">
            .loading {
                display: none;
            }
            #dt_example .sorting {
                background: #F6F6F6;
            }
            #dt_example table.display td {
                padding: 5px 5px 5px 5px !important;
            }
            .blue-text {
                color: blue;
                font-weight: normal;
            }
            .bold {
                font-weight: bolder;
            }
            div#scroll {
                height: 350px !important;
                overflow: auto !important;
                scrollbar-base-color:#ffeaff !important;
            }
        </style>
        <?php 
        if (verify_access_right(current_account(), F_VIEW_TRADE_DATE)) {
        ?>
            <script type="text/javascript">
                $(function() {
                    $("#ngay").datepicker({
                            changeMonth: true,
                            changeYear: true
                    });
                });
            </script>
        <?php
        }
        ?>
    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

            <?php
            require_once '../part/menu.php';
            ?>

            <div id="main-content"> <!-- Main Content Section with everything -->
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="clear"></div>
                <!-- End .content-box -->
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->
                    <div class="content-box-header">
                        <h3>Cập nhật doanh số hàng ngày</h3>
                    </div> <!-- End .content-box-header -->
                    
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <form action="" method="post">
                                    <?php
                                    require_once '../models/doanhthu.php';
                                    require_once '../models/loaitranh.php';

                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    $ngay =  date("Y-m-d");
                                    if(isset($_POST['view']))
                                    {
                                        if (isset($_POST['ngay']))
                                            $ngay = $_POST['ngay'];
                                    }
                                    $dt = new doanhthu();
                                    $dt->tao_bang_doanh_thu($ngay);
                                    ?>
                                    <div>
                                        <label>Ngày (yyyy-mm-dd):</label>
                                        <input id="ngay" name="ngay"
                                               class="text-input small-input" style="width: 150px !important" 
                                               type="text" readonly="readonly" value="<?php echo $ngay ?>" />
                                        <div style="height: 20px"></div>
                                    </div>
                                    <div>
                                        <?php 
                                        if (verify_access_right(current_account(), F_VIEW_TRADE_DATE))
                                        {
                                        ?>
                                              <input class="button" type="submit" id="view" name="view" value="Tổng hợp" />
                                              <div style="height: 20px"></div>
                                          <?php 
                                        }
                                          ?>
                                          <span><?php echo(sprintf("Bảng doanh thu ngày <span id='date' class='blue-text'>%s</span>", $ngay)) ?></span>
                                          <div style="height: 10px"></div>
                                    </div>
                                    
                                    <div id="scroll">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="order-example">
                                            <thead>
                                                <tr>
                                                    <th class="ui-state-default">Showroom</th>                                                                                                        
                                                    <?php
                                                    $db = new loaitranh();
                                                    $type_list = $db->danh_sach();
                                                    foreach($type_list as $type)
                                                    {
                                                        echo sprintf("<th class='ui-state-default'>%s</th>", $type['tenloai']);
                                                    }                                                    
                                                    ?>
                                                    <th class=" ui-state-default">Tổng số</th>
                                                    <th class="ui-state-default">Người cập nhật</th>
                                                    <th class=" ui-state-default">Ghi chú</th>
                                                    <th class=" ui-state-default">Cập nhật</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                
                                                <?php
                                                $dt = new doanhthu();
                                                $array = $dt->bang_doanh_thu($ngay);
                                                
                                                foreach ($array as $value)
                                                {
                                                    $makho = $value['makho'];
                                                    
                                                    echo "<tr>";
                                                    
                                                    // Ten show room
                                                    echo "<td>";
                                                    echo "<div style='width: 150px !important;'>";                                                    
                                                    echo sprintf("<label class='price'>%s</label>", $value['tenkho']);
                                                    echo "</div>";
                                                    echo "</td>";                                                    
                                                    
                                                    //Danh sach cac loai san pham
                                                    foreach($type_list as $type)
                                                    {
                                                        echo "<td>";
                                                        echo sprintf("<input name='loai%s[]' type='hidden' value='%s' />", $makho, $type['maloai']);
                                                        echo sprintf("<small>%s</small><br /><input name='sotien%s[]'
                                                                              class='numeric text-input small-input' style='width: 100px !important' 
                                                                             type='text' value='%s' />", $type['tenloai'], $makho, ($value[$type['maloai']]['sotien'] == 0)? '' : number_2_string($value[$type['maloai']]['sotien'], ''));
                                                        echo "</td>";
                                                    }
                                                    
                                                    //Tong so
                                                    echo "<td>";
                                                    echo "<div style='width: 80px !important;'>";
                                                    echo sprintf("<label id='tongso%s' style='font-weight: normal'>%s</label>", $makho, number_2_string($value['tongso']));
                                                    echo "</div>";
                                                    echo "</td>";
                                                    
                                                    // Nguoi cap nhat, ngay gio cap nhat
                                                    echo "<td>";
                                                    echo "<div style='width: 150px !important;'>";
                                                     echo sprintf("<label id='nguoicapnhat%s' style='color: blue; font-weight: normal'>%s</label>", $makho, $value['nguoicapnhat']);
                                                    echo "<br />";
                                                    echo sprintf("<label id='ngaygiocapnhat%s' style='font-weight: normal'>%s</label>", $makho, $value['ngaygiocapnhat']);
                                                       echo "</div>";
                                                    echo "</td>";
                                                    
                                                    //Ghi chu
                                                    echo "<td style='width:300px !important;'>";
                                                       echo sprintf("<small>Ghi chú</small><br /><textarea id='ghichu%s'
                                                                             class='text-input medium-input' rows='5'
                                                                            style='width: 250px !important;'>%s</textarea>", $makho, $value['ghichu']);
                                                       echo "</td>";
                                                    
                                                    //Cap nhat
                                                    echo "<td style='text-align: center'>";
                                                    //echo "<div style='width: 100px !important;'>";
                                                    echo sprintf("<a href='javascript:updateTrade(\"%s\", \"%s\");' title='Bấm vào đây để lưu'>
                                                                         <img height='27px' width='27px'
                                                                           src='../resources/images/icon_save.jpg' alt='update' />
                                                                 </a>", $value['maso'], $makho);
                                                    echo sprintf("<img id='loading%s' class='loading' src='../resources/images/loading2.gif' alt='loading' />", $makho);
                                                    //echo "</div>";
                                                    echo "</td>";
                                                    
                                                    echo "</tr>";
                                                }
                                                ?>                                                                                   
                                            </tbody>
                                        </table>
                                    </div>
                                 </form> 
                                <br />
                                <br />
                            </div>
                        </div>
                    </div>                      
                </div> <!-- End .content-box -->

                <?php require_once '../part/footer.php'; ?>

            </div> <!-- End #main-content -->

        </div>
        <!-- Dialog thông báo -->
        <div id="dialog-message" title="Thông báo">
            <p class="align-left">
                <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
                <span id="message">Your files have downloaded successfully into the My Downloads folder.</span>
            </p>
        </div>         
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>