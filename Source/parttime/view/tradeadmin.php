<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_TRADE_ADMIN, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Doanh số hàng ngày</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/trade.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $("input[type='text']").addClass("text-input small-input");
            } );
        </script>
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>        
        <style type="text/css">
            .blue-text {
                color: blue;
                font-weight: normal;
            }
            .bold {
                font-weight: bolder;
            }
            div#demo {
                overflow: auto !important;
                scrollbar-base-color:#ffeaff !important;
            }
        </style>
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
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_VIEW_TRADE)): ?>
                        <li>
                            <a target="search" class="shortcut-button new-page" href="trade.php">
                                <span class="png_bg">Cập nhật</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!-- End .content-box -->
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">

                        <h3>Tổng hợp doanh số hàng ngày</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">

                        <div class="tab-content default-tab">                            
                            <form id="trade-list" action="" method="post">                                
                                <div>
                                    <label>Showroom:</label>
                                    <select id="makho" name="makho">
                                        <option value="">[ - Chọn showroom - ]</option>
                                        <?php
                                           include_once '../models/database.php';
                                        require_once '../models/helper.php';
                                        
                                        $db = new database();
                                        $db->setQuery("SELECT * FROM khohang ORDER BY tenkho ASC");
                                        $array = $db->loadAllRow();
                                        foreach ($array as $value)
                                        {
                                        ?>
                                            <option value="<?php echo $value['makho'] ?>"
                                                    <?php echo ($value['makho'] == $_POST['makho']) ? "selected='selected'" : "" ?>
                                                    >
                                                <?php echo $value['tenkho'] ?>
                                            </option>
                                        <?php
                                        } 
                                        ?>
                                    </select>
                                    <span id="error-1" style="color: red"></span>                                    
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Từ ngày (yyyy-mm-dd):</label>
                                    <input id="tungay" name="tungay"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="<?php echo (isset($_POST['tungay'])) ? $_POST['tungay'] : '' ?>" 
                                           type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Đến ngày (yyyy-mm-dd):</label>
                                    <input id="denngay" name="denngay"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="<?php echo (isset($_POST['denngay'])) ? $_POST['denngay'] : '' ?>"
                                           type="text" readonly="readonly" />
                                    <span id="error-3" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <input class="button" type="submit" id="view" name="view" value="Thống kê" />
                                    <div style="height: 20px"></div>
                                </div>
                                
                                <?php
                                if(isset($_POST['view']))
                                {              
                                    require_once '../models/doanhthu.php';
                                    require_once '../models/khohang.php';
                                    require_once '../models/loaitranh.php';
                                    require_once '../models/helper.php';
                                    
                                    $makho = $_POST['makho'];
                                    $tungay = $_POST['tungay'];
                                    $denngay = $_POST['denngay'];
                                    
                                    $dt = new doanhthu();
                                    $array = $dt->tong_hop_doanh_thu($makho, $tungay, $denngay);
                                    $count = 0;
                                ?>
                                    <div>
                                        <span class="bold">Showroom</span>
                                        <span class="blue-text bold">
                                        <?
                                        $kh = new khohang();
                                        echo $kh->ten_kho($makho);
                                        ?>
                                        </span>
                                        <div style="height: 10px"></div>
                                        <span><?php echo(sprintf("Thống kê từ <span class='blue-text'>%s</span> đến <span class='blue-text'>%s</span>", $tungay, $denngay)) ?></span>
                                    </div>
                                    <div id="dt_example">
                                        <div id="container">
                                            <div id="demo">
                                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th class="sorting_asc ui-state-default">Ngày</th>
                                                            <?php
                                                            $db = new loaitranh();
                                                            $type_list = $db->danh_sach();
                                                            foreach($type_list as $type)
                                                            {
                                                                echo sprintf("<th class='ui-state-default'>%s</th>", $type['tenloai']);
                                                            }                                                  
                                                            ?>
                                                            <th class="sorting ui-state-default">Tổng số</th>
                                                            <th class="sorting ui-state-default">Người cập nhật</th>
                                                            <th class="sorting ui-state-default">Ngày giờ cập nhật</th>
                                                            <th class="sorting ui-state-default">Ghi chú</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if(count($array) > 0):
                                                            foreach ($array as $value)
                                                            {
                                                                $count++;
                                                                echo "<tr class=''>";
                                                                
                                                                // Ngay
                                                                echo "<td class=' sorting_1'>";
                                                                echo "<div style='width: 100px !important;'>";
                                                                echo sprintf("<span class='blue'>%s</span>", $value['ngay']);
                                                                echo "</div>";              
                                                                echo "</td>";
                                                                                                                                                                                                                                                                                                                              
                                                                //Danh sach cac loai san pham
                                                                foreach($type_list as $type)
                                                                {
                                                                    echo sprintf("<td class=''>%s</td>", number_2_string($value[$type['maloai']]['sotien']));
                                                                }
                                                                
                                                                // Tong so
                                                                echo sprintf("<td class=''>
                                                                                  <span class='price'>%s</span>
                                                                              </td>", number_2_string($value['tongso']));
                                                                
                                                                // Nguoi cap nhat
                                                                echo sprintf("<td class=''>%s</td>", $value['nguoicapnhat']);
                                                                
                                                                // Ngay gio cap nhat
                                                                echo "<td>";
                                                                echo sprintf("<div style='width: 100px !important;'>%s</div>", $value['ngaygiocapnhat']);
                                                                echo "</td>";
                                                                
                                                                // Ghi chu
                                                                echo "<td>";
                                                                echo sprintf("<div style='width: 200px !important;'>%s</div>", $value['ghichu']); 
                                                                echo "</td>"; 
                                                                
                                                                echo "</tr>";
                                                            }
                                                        endif;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                                <?php
                                                if($count > 0)
                                                {
                                                    $format = "../phpexcel/export2exel.php?do=export&table=showroom&id=%d&from=%s&to=%s"; 
                                                    $url = sprintf($format, $makho, $tungay, $denngay);
                                                ?>                                            
                                                    <div>
                                                        <div style="height: 20px;"></div>
                                                        <a href="<?php echo $url ?>"
                                                           target="_search" 
                                                           class="button" title="Export">Export ra file Excel</a>
                                                    </div>
                                                <?php 
                                                }
                                                ?>                                            
                                        </div>
                                    </div>
                                <?php
                                 } 
                                ?>
                                
                            </form>
                            <br />
                            <br />
                        </div> <!-- End #tab3 -->

                    </div> <!-- End .content-box-content -->

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