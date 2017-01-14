<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_REWARDS_PENALTY, array(F_REWARDS_PENALTY_UNAPPROVED_LIST, F_REWARDS_PENALTY_ASSIGNED_LIST), TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chi tiết ghi nhận và đóng góp</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder !important; }
            img { vertical-align: middle; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/rewards-penalty-detail.js"></script>
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
                    <?php if (verify_access_right(current_account(), F_REWARDS_PENALTY_CREATED_LIST)): ?>
                        <li>
                            <a class="shortcut-button finished" href="created-list.php">
                                <span class="png_bg">Bạn đã tạo</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_REWARDS_PENALTY_ASSIGNED_LIST)): ?>
                        <li>
                            <a class="shortcut-button unevaluated" href="assigned-list.php">
                                <span class="png_bg">Ghi nhận về bạn</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_REWARDS_PENALTY_UNAPPROVED_LIST)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="unapproved-list.php">
                                <span class="png_bg">Cần approve</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Chi tiết ghi nhận và đóng góp</h3>
                    </div>
                    <div class="content-box-content">
                        <form id="rewards-detail" action="" method="post">
                            <?php
                            require_once '../models/rewards_penalty.php';
                            
                            // Approve
                            if(isset($_POST['approve'])) {
                                //debug($_POST);
                                
                                $model = new rewards_penalty();
                                
                                $item = $model->detail($_POST['rewards_uid']);
                                $item->rewards_value = $_POST['rewards_value'];
                                $item->approved = BIT_TRUE;
                                $item->feedback = $_POST['feedback'];
                                
                                $model->update($item);
                                
                                header("location: ../rewards_penalty/unapproved-list.php");
                                exit();
                            }
                            // Reject
                            if(isset($_POST['reject'])) {
                                //debug($_POST);
                                
                                $model = new rewards_penalty();
                                
                                $model->delete($_POST['rewards_uid']);
                                
                                header("location: ../rewards_penalty/unapproved-list.php");
                                exit();
                            }
                            // Update
                            if(isset($_POST['update'])) {
                                //debug($_POST);
                            
                                $model = new rewards_penalty();
                            
                                $item = $model->detail($_POST['rewards_uid']);
                                $item->feedback = $_POST['feedback'];
                            
                                if ($model->update($item)) {
                                    $result = TRUE;
                                    $message = "Thực hiện thao tác thành công.";
                                } else {
                                    $result = FALSE;
                                    $message = $model->getMessage ();
                                }
                            
                                //header("location: ../rewards_penalty/assigned-list.php");
                                //exit();
                            }
                            
                            // Get data and display
                            $rewards_uid = (isset($_GET['i'])) ? $_GET['i'] : '';
                            $model = new rewards_penalty();
                            $item = $model->detail($rewards_uid);
                            //debug($item);
                            $manv = current_account();
                            
                            $access = 0;
                            if ($item != NULL) {
                                // Item chua approce
                                if($item->approved == BIT_FALSE && verify_access_right(current_account(), F_REWARDS_PENALTY_UNAPPROVED_LIST)) {
                                    $access = 1;
                                }
                                
                                // Item assign cho user hien tai
                                if ($item->approved == BIT_TRUE && $item->assign_to == current_account()) {
                                    $access = 2;
                                }
                            }
                            ?>
                            <?php if ($access != 0): ?>
                                <?php if(isset($result) && $result): ?>
                                    <div class="notification information png_bg">
                                        <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close"></a>
                                        <div><?php echo $message; ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($result) && ! $result): ?>
                                    <div class="notification error png_bg">
                                        <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close"></a>
                                        <div><?php echo $message; ?></div>
                                    </div>
                                <?php endif; ?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 30%">
                                                <span class="bold">Nội dung sự kiện</span>
                                            </td>
                                            <td>
                                                <input type="hidden" name="rewards_uid" value="<?php echo $rewards_uid; ?>" />
                                                <span class="blue-text"><?php echo $item->content; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ngày tạo</span>
                                            </td>
                                            <td>
                                                <span><?php echo $item->created_date; ?></span>
                                            </td>
                                        </tr>
                                        <?php 
                                            $nv = new nhanvien();
                                        ?>
                                        <?php if ($access == 1): ?>
                                            <tr>
                                                <td>
                                                    <span class="bold">Người ghi nhận</span>
                                                </td>
                                                <?php 
                                                $tennv = $nv->thong_tin_nhan_vien($item->created_by);
                                                $tennv = (is_array($tennv)) ? $tennv['hoten'] : '';
                                                ?>
                                                <td>
                                                    <span class="bold"><?php echo $tennv; ?></span>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td>
                                                <span class="bold">Người bị/được ghi nhận</span>
                                            </td>
                                            <?php 
                                            $tennv = $nv->thong_tin_nhan_vien($item->assign_to);
                                            $tennv = (is_array($tennv)) ? $tennv['hoten'] : '';
                                            ?>
                                            <td>
                                                <span class="price"><?php echo $tennv; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Mức độ quan trọng</span>
                                            </td>
                                            <td>
                                                <span class="blue-violet"><?php echo $item->rewards_level; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Mức độ mất mát hoặc đóng góp</span>
                                            </td>
                                            <td>
                                                <?php if ($access == 1): ?>
                                                    <input type="text" name="rewards_value" id="rewards_value" class="text-input small-input" value="<?php echo $item->rewards_value; ?>" />
                                                    <span class="error_icon input-notification error png_bg" id="error_rewards_value" title="Giá trị không hợp lệ"></span>
                                                <?php else: ?>
                                                    <span class=""><?php echo $item->rewards_value; ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Phản hồi</span>
                                            </td>
                                            <td>
                                                <textarea id="feedback" name="feedback"><?php echo $item->feedback; ?></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                </div>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="clear"></div>
                                <fieldset>
                                    <?php if ($access == 1): ?>
                                        <p>
                                            <input type="submit" class="button" value="Approve" title="Update & Approve" name="approve" id="approve" />
                                            <input type="submit" class="button" value="Reject" title="Reject" name="reject" id="reject" />
                                        </p>
                                    <?php else: ?>
                                        <p>
                                            <input type="submit" class="button" value="Update" title="Update" name="update" id="update" />
                                        </p>
                                    <?php endif; ?>
                                </fieldset>
                             <?php endif; ?>
                        </form>
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