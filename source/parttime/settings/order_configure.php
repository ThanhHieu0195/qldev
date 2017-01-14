<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SETTINGS_ORDER_CONFIGURE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <title>Cấu hình thông tin đặt hàng</title>      
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            tr.alt-row {
                background: none !important;
            }
        </style>
        <script type="text/javascript" charset="utf-8">
            function validate() {
                var valid = true;
                
                // Ma kho hang
                if($("#makho").val() == "") {
                    $("#makho").addClass("require_background");
                    valid = false;
                }
                else {
                    $("#makho").removeClass("require_background");
                }    
                // Ma tho
                if($("#matho").val() == "") {
                    $("#matho").addClass("require_background");
                    valid = false;
                }
                else {
                    $("#matho").removeClass("require_background");
                }
                // Hien thi thong bao
                if( ! valid)
                    $("#error").text("*Chọn các giá trị."); 
                else
                    $("#error").text("");
                
                return valid;  
            }
            
            // DOM load
            $(function() {
                $("#cofigure").submit(function() {
                    return validate();
                })
            })
        </script>
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
                            <a class="shortcut-button settings_orders current" href="../settings/order_configure.php">
                                <span class="png_bg">Thông tin đặt hàng</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_SETTINGS_MAIL_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_mail" href="../settings/mail_configure.php">
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
                        <h3>Cấu hình thông tin đặt hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="post" id="cofigure">
                                <?php
                                include_once '../models/database.php';
                                include_once '../models/khohang.php';
                                include_once '../models/config.php';
                                include_once '../config/constants.php';
                                
                                $submited = FALSE;
                                $message = '';
                                
                                if (isset($_POST['save'])) 
                                {
                                    if($_POST['makho'] != '' && $_POST['matho'] != '')
                                    {
                                        $submited = TRUE;
                                        // Lay cac thong tin cau hinh
                                        $makho     = $_POST['makho'];
                                        $matho     = $_POST['matho'];
                                        
                                        // Them constants vao bang config
                                        $config = new Config();
                                        $result = $config->add(DEFAULT_SHOWROOM, $makho);
                                        $message = $config->getMessage();
                                        $result = $result && $config->add(DEFAULT_THO, $matho);
                                        $message .= $config->getMessage();
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
                                       <?php echo(sprintf('Lỗi dặt cập nhật thông tin: %s.', $message)); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <table>                                                       
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
                                    <tbody>
                                        <?php
                                        $config = new Config();
                                        $makho = $config->get(DEFAULT_SHOWROOM);
                                        $matho = $config->get(DEFAULT_THO);
                                        ?>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Kho hàng mặc định</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td width="80%">
                                                <select name="makho" id="makho">
                                                    <option value=""></option>
                                                    <?php
                                                    $khohang = new khohang();
                                                    $array = $khohang->danh_sach();

                                                    //Duyet ket qua
                                                    foreach ($array as $value)
                                                    {
                                                        if($makho == $value['makho'])
                                                            echo "<option value='" . $value['makho'] . "' selected='selected'>" . $value['tenkho'] . "</option>";
                                                        else
                                                            echo "<option value='" . $value['makho'] . "'>" . $value['tenkho'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Thợ mặc định</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td width="80%">
                                                <select name="matho" id="matho">
                                                    <option value=""></option>
                                                    <?php
                                                    $db = new database();
                                                    $db->setQuery("SELECT matho, hoten FROM tho");
                                                    $array = $db->loadAllRow();

                                                    //Duyet ket qua
                                                    foreach ($array as $value)
                                                    {
                                                        if($matho == $value['matho'])    
                                                            echo "<option value='" . $value['matho'] . "' selected='selected'>" . $value['hoten'] . "</option>";
                                                        else
                                                            echo "<option value='" . $value['matho'] . "'>" . $value['hoten'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>                                      
                                    </tbody>
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