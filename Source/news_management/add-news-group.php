<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SYSTEM_ADMIN_NEWS_MANAGEMENT, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thêm nhóm tin</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css">
            #main-content tbody tr.alt-row { background: none; }
            .error_icon { display: none; }
        </style>
        
        <script type="text/javascript" src="../resources/scripts/utility/news_management/news_group.js"></script>
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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_SYSTEM_ADMIN_NEWS_MANAGEMENT)) : ?>
                        <li>
                            <a class="shortcut-button list" href="../news_management/news-group-list.php">
                                <span class="png_bg">Danh sách nhóm tin</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button add current" href="../news_management/add-news-group.php"">
                                <span class="png_bg">Thêm nhóm tin mới</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button new-page" href="../news_management/add-news.php"">
                                <span class="png_bg">Thêm bài viết mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thêm nhóm tin</h3>
                    </div>
                    <div class="content-box-content">
                        <?php require_once '../models/news_group.php'; ?>
                        
                        <div class="tab-content default-tab">
                            <form id="add-group" action="" method="post">
                                <?php
                                    if (isset($_POST["save"])) {
                                        $name = $_POST["name"];
                                        $note = $_POST["note"];
                                        $enable = (isset($_POST['enable']));
                                        
                                        $item = new news_group_entity();
                                        $item->name = $name;
                                        $item->note = $note;
                                        $item->enable = $enable;
                                        
                                        // Insert to database
                                        $model = new news_group();
                                        if ($model->insert($item)) {
                                            $result = TRUE;
                                            $message = "Thêm nhóm tin thành công.";
                                        }
                                        else {
                                            $result = FALSE;
                                            $message = "Lỗi: '{$model->getMessage()}'";
                                        }
                                    }
                                ?>
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
                                            <td width="15%">
                                                <label>Tên nhóm</label>
                                            </td>
                                            <td>
                                                <input id="name" name="name" class="text-input medium-input" maxlength="50" type="text" />
                                                <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Ghi chú (nếu có)</label>
                                            </td>
                                            <td>
                                                <textarea id="note" name="note" cols="79" rows="5"></textarea>
                                                <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="enable">Hiển thị trên menu chính</label>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="enable" checked="checked" alt=""> Enable
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <fieldset>
                                    <p>
                                        <input class="button" type="submit" name="save" value="Thêm nhóm tin" />
                                    </p>
                                </fieldset>
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