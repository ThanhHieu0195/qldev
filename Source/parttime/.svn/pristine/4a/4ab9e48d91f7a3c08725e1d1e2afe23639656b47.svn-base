<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_GROUP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Nhóm coupon</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <script type="text/javascript" charset="utf-8">
            $(function() {                
            });
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
                <ul class="shortcut-buttons-set">
                    <li><a class="shortcut-button upload-image" href="coupon-group-list.php"><span class="png_bg">
                                Nhóm coupon
                            </span></a></li>
                    <li><a class="shortcut-button new-page current" href="coupon-group.php"><span class="png_bg">
                                Thêm nhóm mới
                            </span></a></li>
                </ul>
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin nhóm coupon</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form method="post" action="">
                                <?php
                                require_once '../models/coupon_group.php';
                                require_once '../models/helper.php';
                                
                                $coupon_group = new coupon_group();
                                
                                $action = (isset($_GET['action'])) ? $_GET['action'] : 'add';                                
                                switch ($action)
                                {
                                    case 'update':
                                        // Update                                        
                                        if(isset($_POST['submit']))
                                        {
                                            $group_id = $_POST['group_id'];
                                            $content = $_POST['group_content'];
                                            $description = $_POST['group_description'];
                                        
                                            if($group_id != '' && $content != '')
                                            {
                                                $done = $coupon_group->update($group_id, $content, $description);
                                            }
                                        }
                                        
                                        // Detail
                                        $group_id = (isset($_GET['groupid'])) ? $_GET['groupid'] : '';
                                        $array = $coupon_group->detail($group_id);
                                        
                                        break;
                                        
                                    case 'delete':
                                        if(isset($_GET['groupid']))
                                        {
                                            $group_id = $_GET['groupid'];
                                            $coupon_group->delete($group_id);
                                        }
                                        header('location: ../coupon/coupon-group-list.php');
                                        exit();
                                        
                                        break;
                                       
                                    default:
                                        if(isset($_POST['submit']))
                                        {                                           
                                            $group_id = $_POST['group_id'];
                                            $content = $_POST['group_content'];
                                            $description = $_POST['group_description'];
                                            
                                            if($group_id != '' && $content != '')
                                            {
                                                $done = $coupon_group->add_new($group_id, $content, $description);
                                            }
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
                                        Lỗi: <?php echo $coupon_group->getMessage(); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <fieldset>
                                    <p>
                                        <label for="group_id">Mã nhóm coupon (*)</label>
                                        <input type="text" name="group_id" id="group_id" class="text-input small-input uid" maxlength="10"
                                               <?php if($action == 'update'): ?>
                                               readonly="readonly" value="<?php if (isset($array)) echo $array['group_id']; ?>"
                                               <?php endif; ?>
                                               />
                                        <br /><small>Mã nhóm coupon (tối đa 10 ký tự và chỉ cho phép nhập các ký tự: <?php echo VALIDATE_UID; ?>)</small>
                                    </p>
                                    <p>
                                        <label for="group_content">Nội dung (*)</label>
                                        <input type="text" name="group_content" id="group_content" class="text-input medium-input" maxlength="100"
                                               <?php if($action == 'update'): ?>
                                               value="<?php if (isset($array)) echo $array['content']; ?>"
                                               <?php endif; ?>
                                               />
                                        <br /><small>Nội dung của nhóm coupon</small>
                                    </p>
                                    <p>
                                        <label for="group_description">Ghi chú</label>
                                        <textarea name="group_description" id="group_description" rows="5" cols="10"><?php if(($action == 'update') && isset($array)) echo $array['content']; ?></textarea>
                                        <br /><small>Phần ghi chú về nhóm coupon</small>
                                    </p>
                                    <p>
                                        <input type="submit" class="button" value="<?php echo (($action == 'update') ? 'Cập nhật' : 'Thêm'); ?>"
                                               name="submit">
                                    </p>
                                </fieldset>
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