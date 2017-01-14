<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SYSTEM_ADMIN_FINANCE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cập nhật loại chi phí</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/finance/category.js"></script>
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
                    <?php if (verify_access_right(current_account(), F_SYSTEM_ADMIN_FINANCE)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="../finance/reference-list.php">
                                <span class="png_bg">Quản lý số tham chiếu</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button list" href="../finance/product-list.php">
                                <span class="png_bg">Quản lý sản phẩm</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button switch" href="../finance/category-list.php">
                                <span class="png_bg">Quản lý loại chi phí</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Cập nhật loại chi phí</h3>
                    </div>
                    <div class="content-box-content">
                        <?php require_once '../models/finance_category.php'; ?>
                        
                        <div class="tab-content default-tab" style="display: block;">
                            <?php 
                                $category_id = (isset($_GET['i'])) ? $_GET['i'] : '';
                                
                                // Get detail of category
                                $model = new finance_category();
                                $category = $model->detail($category_id);
                            ?>
                            <?php if ($category != NULL): ?>
                                <form id="frm-update-category" action="../ajaxserver/finance_management_server.php" method="post" target="hidden_upload">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td width="20%">
                                                    <label>Mã loại chi phí (*)</label>
                                                </td>
                                                <td>
                                                    <input id="category_id" name="category_id" class="alphanumeric text-input small-input" maxlength="50" type="text" readonly="readonly" value="<?php echo $category->category_id; ?>" />
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Tên loại chi phí (*)</label>
                                                </td>
                                                <td>
                                                    <input id="category_name" name="category_name" class="text-input medium-input" type="text" value="<?php echo $category->name; ?>" />
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Loại phiếu sử dụng (*)</label>
                                                </td>
                                                <td>
                                                    <select name="used_type" id="used_type">
                                                        <?php 
                                                            $types = array(FINANCE_BOTH, FINANCE_RECEIPT, FINANCE_PAYMENT);
                                                            foreach ($types as $t):
                                                        ?>
                                                                <option value="<?php echo $t; ?>" <?php echo ($t == $category->used_type) ? "selected='selected'" : ""; ?> ><?php echo get_finance_type_name($t); ?></option>
                                                        <?php
                                                            endforeach;
                                                        ?>
                                                    </select>
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="category_enable">Enable</label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="category_enable" <?php echo ($category->enable == BIT_TRUE) ? "checked='checked'" : "" ?> alt=""> Yes
                                                </td>
                                            </tr>
                                            <script type="text/javascript" charset="utf-8">
                                                var countId = 0;

                                                $(function() {
                                                    loadItemByCategory('<?php echo $category->category_id; ?>');
                                                });
                                            </script>
                                            <tr>
                                                <td><label>Danh sách loại chi phí chi tiết:</label></td>
                                                <td>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th><label>Loại chi phí chi tiết</label></th>
                                                                <th width="20%">Enable</th>
                                                                <th width="10%">
                                                                    <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="items_list">
                                                        </tbody>
                                                    </table>
                                                    <div id="loading" style="display: none;">
                                                        <center>
                                                            <img src="../resources/images/loadig_big.gif" alt="">
                                                        </center>
                                                    </div>
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
                                            <input type="submit" class="button" value="Cập nhật loại chi phí" name="update_category" />
    <!--                                         <input type="reset" class="button" value="Làm lại" id="reset" name="reset"> -->
                                        </p>
                                    </fieldset>
                                    <div id="notification_msg">
                                    </div>
                                    <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                            style="width:0;height:0;border:0px solid #fff">
                                    </iframe>
                                    <div class="clear"></div>
                                </form>
                            <?php endif; ?>
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