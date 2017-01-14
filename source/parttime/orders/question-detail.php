<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_ORDERS_QUESTIONS_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cập nhật câu hỏi kiểm tra hóa đơn</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/orders/question.js"></script>
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
                    <li>
                        <a class="shortcut-button add" href="../orders/question.php">
                            <span class="png_bg">Thêm câu hỏi</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button list" href="../orders/question-list.php">
                            <span class="png_bg">Danh sách câu hỏi</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Cập nhật câu hỏi kiểm tra hóa đơn</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <?php 
                            require_once '../models/orders_question.php';
                            require_once '../models/orders_question_option.php';
                            
                            // DB model
                            $question_model = new orders_question();
                            
                            // Get plan detail
                            $i = (isset($_GET['i'])) ? $_GET['i'] : '';
                            $question = $question_model->detail($i);
                            
                            if ($question != NULL) {
                                //debug($plan);
                            ?>
                            <form id="update_template" action="../ajaxserver/orders_create_question.php" method="post" target="hidden_upload">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <input type="hidden" id="question_id" name="question_id" value="<?php echo $question->question_id; ?>" />
                                                <label for="content">Nội dung (*)</label>
                                            </td>
                                            <td>
                                                <input type="text" name="content" id="content" class="text-input medium-input" maxlength="200"
                                                       value="<?php echo $question->content; ?>" />
                                                <span class="error_icon input-notification error png_bg" id="error_title" title="Nhập dữ liệu"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>Enable:</label></td>
                                            <td>
                                                <input type="checkbox" name="enable" id="enable" <?php echo ($question->enable == BIT_TRUE) ? "checked='checked'" : ""; ?> />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>Danh sách các lựa chọn:</label></td>
                                            <td>
                                                <?php 
                                                $option_model = new orders_question_option();
                                                $arr = $option_model->option_list($question->question_id);
                                                
                                                if ($arr == NULL) {
                                                ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="task_detail_list">
                                                        <tr>
                                                            <td>
                                                                <input name="detail_list[]" class="text-input medium-input" style="width: 95% !important" type="text" value="">
                                                            </td>
                                                            <td>
                                                                 <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                                 <a id="clear_0" href="javascript:clearRow('clear_0')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <script type="text/javascript" charset="utf-8">
                                                    var countId = 0;
                                                </script>
                                                <?php } else { ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="task_detail_list">
                                                        <?php 
                                                        $i = 0;
                                                        
                                                        foreach ($arr as $t):
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <input name="detail_list[]" class="text-input medium-input" style="width: 95% !important" type="text" value="<?php echo $t->content; ?>">
                                                                </td>
                                                                <?php if ($i == 0) { ?>
                                                                <td>
                                                                     <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                                     <a id="clear_<?php echo $i; ?>" href="javascript:clearRow('clear_<?php echo $i; ?>')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>
                                                                </td>
                                                                <?php } else { ?>
                                                                <td>
                                                                     <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                                     <a id="remove_<?php echo $i; ?>" href="javascript:removeRow('remove_<?php echo $i; ?>')" title="Xóa dòng này"><img src="../resources/images/icons/cross.png" alt="Delete"></a>
                                                                </td>
                                                                <?php } ?>
                                                            </tr>
                                                        <?php 
                                                        $i++;
                                                        endforeach; 
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <script type="text/javascript" charset="utf-8">
                                                    var countId = <?php echo (count($arr) - 1); ?>;
                                                </script>
                                                <?php } ?>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left"></div>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="clear"></div>
                                <fieldset>
                                    <p>
                                        <input type="submit" class="button" value="Cập nhật" name="update_question" />
                                        <span id="attention" style="color: red;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                    </p>
                                </fieldset>
                                <div id="notification_msg">
                                </div>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                                <div class="clear"></div>
                            </form>
                            <?php } else { ?>
                            <?php } ?>
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