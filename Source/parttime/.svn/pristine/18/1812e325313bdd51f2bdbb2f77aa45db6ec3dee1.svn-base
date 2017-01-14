<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_TASK, F_TASK_TEMPLATE_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cập nhật công việc mẫu</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/template.js"></script>
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
                        <a class="shortcut-button add" href="template.php">
                            <span class="png_bg">Thêm template</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button list" href="template-list.php">
                            <span class="png_bg">Danh sách template</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Cập nhật công việc mẫu</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <?php 
                            require_once '../models/task_template.php';
                            require_once '../models/task_template_detail.php';
                            
                            // DB model
                            $template_model = new task_template();
                            
                            // Get plan detail
                            $i = (isset($_GET['i'])) ? $_GET['i'] : '';
                            $template = $template_model->detail($i);
                            
                            if ($template != NULL) {
                                //debug($plan);
                            ?>
                            <form id="update_template" action="../ajaxserver/task_create_task.php" method="post" target="hidden_upload">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <input type="hidden" id="template_id" name="template_id" value="<?php echo $template->template_id; ?>" />
                                                <label for="title">Tiêu đề (*)</label>
                                            </td>
                                            <td>
                                                <input type="text" name="title" id="title" class="text-input medium-input" maxlength="100"
                                                       value="<?php echo $template->title; ?>" />
                                                <span class="error_icon input-notification error png_bg" id="error_title" title="Nhập dữ liệu"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="content">Nội dung (*)</label>
                                            </td>
                                            <td>
                                                <textarea name="content" id="content" rows="5" cols="10"><?php echo $template->content; ?></textarea>
                                                <span class="error_icon input-notification error png_bg" id="error_content" title="Nhập dữ liệu"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>Danh sách công việc nhỏ cần thực hiện (nếu có):</label></td>
                                            <td>
                                                <?php 
                                                $detail_model = new task_template_detail();
                                                $arr = $detail_model->detail_list($template->template_id);
                                                
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
                                        <input type="submit" class="button" value="Cập nhật mẫu" name="update_template" />
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