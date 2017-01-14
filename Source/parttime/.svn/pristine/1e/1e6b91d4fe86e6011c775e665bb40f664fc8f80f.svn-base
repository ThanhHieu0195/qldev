<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SETTINGS_MAIL_CONFIGURE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cấu hình thông tin gửi mail</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            tr.alt-row { background: none !important; }
        </style>
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/settings/mail_configure.js"></script>
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
                    <?php if (verify_access_right(current_account(), F_SETTINGS_ORDER_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_orders" href="../settings/order_configure.php">
                                <span class="png_bg">Thông tin đặt hàng</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_SETTINGS_MAIL_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_mail current" href="../settings/mail_configure.php">
                                <span class="png_bg">Thông tin gửi mail</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_SETTINGS_TASK_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_task" href="../settings/task_configure.php">
                                <span class="png_bg">Trọng số cho điểm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Cấu hình thông tin gửi mail</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="post" id="configure">
                                <?php
                                require_once '../entities/mail_config.php';
                                require_once '../models/config.php';
                                
                                $submited = FALSE;
                                $message = '';
                                $format = '<br /> %s';
                                
                                if (isset ( $_POST ['save'] )) {
                                    $submited = TRUE;
                                    $result = TRUE;
                                    
                                    // Lay cac thong tin cau hinh
                                    $item = new mail_config ();
                                    $item->host = $_POST['host'];
                                    $item->user_name = $_POST['user_name'];
                                    $item->password = $_POST['password'];
                                    $item->timeout = $_POST['timeout'];
                                    $item->from_name = $_POST['from_name'];
                                    
                                    // Them constants vao bang config
                                    $config = new Config ();
                                    if (! $config->add ( MAIL_HOST, $item->host )) {
                                        $result = FALSE;
                                        $message .= sprintf ( $format, $config->getMessage () );
                                    }
                                    if (! $config->add ( MAIL_UID, $item->user_name )) {
                                        $result = FALSE;
                                        $message .= sprintf ( $format, $config->getMessage () );
                                    }
                                    if (! $config->add ( MAIL_PWD, $item->password )) {
                                        $result = FALSE;
                                        $message .= sprintf ( $format, $config->getMessage () );
                                    }
                                    if (! $config->add ( MAIL_TIMEOUT, $item->timeout )) {
                                        $result = FALSE;
                                        $message .= sprintf ( $format, $config->getMessage () );
                                    }
                                    if (! $config->add ( MAIL_FROMNAME, $item->from_name )) {
                                        $result = FALSE;
                                        $message .= sprintf ( $format, $config->getMessage () );
                                    }
                                }
                                ?>
                                <?php if($submited && $result): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#">
                                        <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" />
                                    </a>
                                    <div>
                                       <?php echo 'Cập nhật thông tin thành công.'; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if($submited && ( ! $result)): ?>
                                <div class="notification error png_bg">
                                    <a class="close" href="#">
                                        <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" >
                                    </a>
                                    <div>
                                       <?php echo(sprintf('Lỗi cập nhật thông tin: %s.', $message)); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <table>
                                    <tbody>
                                        <?php
                                        $config = new Config();
                                        $item = new mail_config();
                                        
                                        $item->host = $config->get(MAIL_HOST);
                                        $item->user_name = $config->get(MAIL_UID);
                                        $item->password = $config->get(MAIL_PWD);
                                        $item->timeout = $config->get(MAIL_TIMEOUT);
                                        $item->from_name = $config->get(MAIL_FROMNAME);
                                        ?>
                                        <tr>
                                            <td width="30%">
                                                <span class="bold">Host</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="host" id="host" value="<?php echo $item->host; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">User name</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="user_name" id="user_name" value="<?php echo $item->user_name; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Password</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="password" id="password" value="<?php echo $item->password; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Time-out gửi mail qua SMTP (giây)</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="timeout" id="timeout" value="<?php echo $item->timeout; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tên hiển thị ở mục người gửi (From's name)</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input class="text-input medium-input" maxlength="200" type="text" name="from_name" id="from_name" value="<?php echo $item->from_name; ?>" />
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="save" value="Cập nhật" />
                                                    <span id="error" style="padding-left: 20px" class="require"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                            <br />
                            <br />
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