<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST, F_GUEST_GUEST_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách khách hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600 !important; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
            
            /* Scroll bar */
            div#detail_dialog_content { max-height: 450px; }
            div#detail_dialog_content { overflow: auto; scrollbar-base-color:#ffeaff; }
        </style>
        
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/fnReloadAjax.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/guest/statistic.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/guest/list.js"></script>
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
                        <h3>Danh sách khách hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        Hiển thị theo nhóm khách: 
                                        <select name="nhomkhach" id="nhomkhach" onchange="refreshData();" data-placeholder=" " class="chosen-select" style="width:350px;" tabindex="4">
                                            <option value="-1">-- Tất cả --</option>
                                            <?php 
                                            require_once '../models/database.php';
                                            
                                            $db = new database();
                                            $db->setQuery("SELECT manhom, tennhom FROM nhomkhach ORDER BY tennhom");
                                            $arr = $db->loadAllRow();
                                            if(is_array($arr)):
                                                foreach ($arr as $item):
                                                    echo "<option value=\"{$item['manhom']}\">{$item['tennhom']}</option>";
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                        <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                                          <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                                          <script type="text/javascript">
                                            var config = {
                                              '.chosen-select'           : {},
                                              '.chosen-select-deselect'  : {allow_single_deselect:true},
                                              '.chosen-select-no-single' : {disable_search_threshold:10},
                                              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                                              '.chosen-select-width'     : {width:"95%"}
                                            };
                                            for (var selector in config) {
                                              $(selector).chosen(config[selector]);
                                            }
                                          </script>
                                        <div style="height: 20px"></div>
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Họ tên</th>
                                                    <th>Nhóm khách</th>
                                                    <th>Địa chỉ</th>
                                                    <th>Điện thoại</th>
                                                    <th>Tiềm năng</th>
                                                    <th>Doanh số</th>
                                                    <th>Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <br />
                                        <br />    
                                        <div class="bulk-actions align-left">
                                            <input class="button" type="button" id="export" name="export" value="Export danh sách khách hàng" 
                                                   onclick="return export2Excel();">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
                <div id="detail_dialog" class="bMulti2" style="display: none">
                    <span class="button_popup b-close"><span>X</span></span>
                    <div id="detail_dialog_content">
                        <table class="bordered" id="detail_items">
                            <thead>
                                <tr id="detail_items_head">
                                </tr>
                            </thead>
                            <tbody id="detail_items_body">
                            </tbody>
                        </table>
                    </div>
                 </div>
                 <div id="popup" style="display: none">
                    <div id="popup_msg"></div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
