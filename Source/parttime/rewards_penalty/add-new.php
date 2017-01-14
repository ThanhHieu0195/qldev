<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_REWARDS_PENALTY, F_REWARDS_PENALTY_ADD_NEW, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tạo ghi nhận và đóng góp</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .ui-autocomplete-loading {
                background: white url('../resources/images/loading.gif') right center no-repeat !important;
            }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/add-new-rewards-penalty.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin ghi nhận và đóng góp</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form id="add-new" method="post" action="">
                                <?php
                                require_once '../models/rewards_penalty.php';
                                
                                if(isset($_POST['submit'])) {
                                    $item = new rewards_penalty_entity();
                                    $item->created_date = current_timestamp();
                                    $item->content = trim($_POST['content']);
                                    $item->created_by = current_account();
                                    $item->assign_to = $_POST['assign_to'];
                                    $item->rewards_level = $_POST['level'];
                                    $item->rewards_value = floatval ($_POST['value']);
                                    if (verify_access_right(current_account(), F_REWARDS_PENALTY_UNAPPROVED_LIST)) {
                                    	$item->approved = BIT_TRUE;
                                    }
                                    
                                    //debug($item);
                                    $model = new rewards_penalty();
                                    if ($model->insert($item)) {
                                    	$done = TRUE;
                                    } else {
                                        $done = FALSE;
                                        $message = $model->getMessage();
                                    }
                                }
                                ?>
                                <?php if(isset($done) && $done): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Thực hiện thao tác thành công!
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if(isset($done) && ! $done): ?>
                                <div class="notification error png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Lỗi: <?php echo $message; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <fieldset>
                                    <p>
                                        <label for="content">Nội dung (*)</label>
                                        <textarea name="content" id="content" rows="5" cols="10"></textarea>
                                        <span class="error_icon input-notification error png_bg" id="error_content" title="Nhập dữ liệu"></span>
                                        <br /><small>Nội dung khen thưởng/kỷ luật.</small>
                                    </p>
                                    <p>
                                        <label for="assign_to">Người bị/được ghi nhận (*)</label>
                                        <select name="assign_to" id="assign_to" data-placeholder=" " class="chosen-select" style="width:350px;" tabindex="4">
                                            <option value=""></option>
                                            <?php 
                                            require_once '../models/nhanvien.php';
                                            
                                            $nhanvien = new nhanvien();
                                            $arr = $nhanvien->employee_list();
                                            if(is_array($arr)):
                                                foreach ($arr as $item):
                                                    echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                        <span class="error_icon input-notification error png_bg" id="error_assign_to" title="Nhập dữ liệu"></span>
                                        <br><small>Người bị/được ghi nhận.</small>
                                    </p>
                                    <p>
                                        <label>Mức độ quan trọng (*):</label>
                                        <select name="level" id="level">
                                            <option value=""></option>
                                            <?php 
                                            for ($i = 1; $i <= 5; $i++):
                                                echo "<option value=\"{$i}\">{$i}</option>";
                                            endfor;
                                            ?>
                                        </select>
                                        <span class="error_icon input-notification error png_bg" id="error_level" title="Nhập dữ liệu"></span>
                                        <br><small>1 đến 5 – 5 là cực kỳ nghiêm trọng.</small>
                                    <p>
                                    <p>
                                        <label>Mức độ mất mát hoặc đóng góp – qui ra tiền (*):</label>
                                        <input id="value" name="value" class="text-input small-input" style="width: 150px !important" type="text" value="">
                                        <span class="error_icon input-notification error png_bg" id="error_value" title="Nhập dữ liệu"></span>
                                        <br><small>Nếu mất mát thì ghi số âm, đóng góp cho công ty thì ghi số dương, nếu những cái đó không có ảnh hưởng thì ghi là 0.</small>
                                    <p>
                                    <p>
                                        <input type="submit" class="button" value="Tạo"
                                               name="submit">
                                        <span id="attention" style="color: red; display: none">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                    </p>
                                </fieldset>
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
                                <div class="clear"></div>
                            </form>
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