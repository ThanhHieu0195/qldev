<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_DECENTRALIZE_ROLE_GROUP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thêm nhóm quyền</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .ui-autocomplete-loading {
                background: white url('../resources/images/loading.gif') right center no-repeat !important;
            }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            .fixed-dialog{ top: 8% !important; left: 20% !important; }
            table.dataTable { margin: 0 auto; clear: both; width: 100% !important;}
            .ui-dialog-titlebar-close { visibility: hidden; }
            #dt_example span { font-weight: normal !important; }
            img { vertical-align: middle; }
            #notification_msg span { font-size: 13px; }
            td p label { color: blue; }
            #example_wrapper { vertical-align: middle; }
        </style>
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/decentralize/role-group.js"></script>
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
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_DECENTRALIZE_ROLE_GROUP)) : ?>
                        <li>
                            <a class="shortcut-button freelancer" href="../decentralize/role-group-list.php">
                                <span class="png_bg">Danh sách nhóm quyền</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button add-freelancer current" href="../decentralize/add-role-group.php"">
                                <span class="png_bg">Thêm nhóm quyền</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->
                    <div class="content-box-header">
                        <h3>Thêm nhóm quyền</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="create_role" action="../ajaxserver/account_role_group_server.php" method="post" target="hidden_upload">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <label for="role_id">Mã nhóm quyền (*)</label>
                                            </td>
                                            <td>
                                                <input type="text" name="role_id" id="role_id" class="text-input small-input uid" maxlength="50" value="" />
                                                <i>(tối đa 50 ký tự và chỉ cho phép nhập các ký tự: <?php echo VALIDATE_UID; ?>)</i>
                                                <span class="error_icon input-notification error png_bg" id="error_role_id" title="Nhập dữ liệu"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="role_name">Tên nhóm quyền (*)</label>
                                            </td>
                                            <td>
                                                <input type="text" name="role_name" id="role_name" class="text-input medium-input" maxlength="100" value="" />
                                                <span class="error_icon input-notification error png_bg" id="error_role_name" title="Nhập dữ liệu"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="role_name">Trạng thái</label>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="enable" checked="checked" /> Enable
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>Quyền truy cập trên các chức năng:</label></td>
                                            <td id="function_list">
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
                                <fieldset id="control_panel" style="display: none;">
                                    <p>
                                        <input type="submit" class="button" value="Tạo nhóm quyền" name="create_role">
                                        <input type="reset" class="button" value="Làm lại" id="reset" name="reset">
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