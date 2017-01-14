<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SYSTEM_ADMIN_NEWS_MANAGEMENT, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cập nhật bài viết</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css">
            #main-content tbody tr.alt-row { background: none; }
            .error_icon { display: none; }
            img { vertical-align: middle; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
        </style>
        </style>
        
        <script src="../resources/tinymce/4.0.28/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/news_management/create_news.js"></script>
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
                            <a class="shortcut-button add" href="../news_management/add-news-group.php"">
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
                        <h3>Cập nhật bài viết</h3>
                    </div>
                    <div class="content-box-content">
                        <?php 
                            require_once '../models/news.php';
                            require_once '../models/news_group.php';
                            
                            // Get input data
                            $news_id = (isset($_GET['i'])) ? $_GET['i'] : "";
                            
                            $news_model = new news();
                            $news = $news_model->detail($news_id);
                        ?>
                        <div class="tab-content default-tab" >
                            <?php if ($news != NULL): ?>
                                <form id="edit-news" action="" method="post">
                                    <?php
                                        if (isset($_POST["save"])) {
                                            $news_id = $_POST['news_id'];
                                            $title = $_POST["title"];
                                            $group_id = $_POST["group_id"];
                                            $summary = $_POST["summary"];
                                            $content = $_POST["content"];
                                            $enable = (isset($_POST['enable']));
                                            
                                            if (empty($title) || empty($content)) {
                                                $result = FALSE;
                                                $message = "Vui lòng nhập tiêu đề và nội dung bài viết!";
                                            } else {
                                                // Get news detail
                                                $item = $news_model->detail($news_id);
                                                if ($item != NULL) {
                                                    $old_group_id = $item->group_id;
                                                    
                                                    $item->title = $title;
                                                    $item->group_id = $group_id;
                                                    $item->summary = $summary;
                                                    $item->content = $content;
                                                    $item->enable = $enable;
                                                    $item->last_modified = current_timestamp();
                                                
                                                    // Insert to database
                                                    if ($news_model->update($item, $old_group_id)) {
                                                        $result = TRUE;
                                                        $message = "Thực hiện thao tác thành công.";
                                                    }
                                                    else {
                                                        $result = FALSE;
                                                        $message = "Lỗi: '{$news_model->getMessage()}'";
                                                    }
                                                } else {
                                                    $result = FALSE;
                                                    $message = "Không tìm thấy thông tin chi tiết bài viết '{$news_id}'";
                                                }
                                                
                                                if ($result) {
                                                    $news = $news_model->detail($news_id);
                                                }
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
                                                    <label>Tiêu đề</label>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="news_id" value="<?php echo $news->news_id; ?>" />
                                                    <input id="title" name="title" class="text-input medium-input" style="width: 350px !important" type="text" 
                                                           value="<?php echo $news->title; ?>" />
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <?php 
                                                $news_group_model = new news_group();
                                                $arr = $news_group_model->list_group(TRUE);
                                            ?>
                                            <tr>
                                                <td>
                                                    <label>Nhóm tin</label>
                                                </td>
                                                <td>
                                                    <select id="group_id" name="group_id">
                                                        <option value=""></option>
                                                        <?php 
                                                            if ($arr != NULL):
                                                                foreach ($arr as $z):
                                                        ?>
                                                                <option <?php echo ($news->group_id == $z->group_id) ? "selected='selected'" : "" ?> value="<?php echo $z->group_id; ?>"><?php echo $z->name; ?></option>
                                                        <?php
                                                                endforeach;
                                                            endif; 
                                                        ?>
                                                    </select>
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Ngày giờ tạo</label>
                                                </td>
                                                <td>
                                                    <span class="blue-text bold"><?php echo dbtime_2_systime($news->created_date, 'H:i:s d/m/Y'); ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Ngày giờ cập nhật</label>
                                                </td>
                                                <td>
                                                    <span class="orange bold"><?php echo dbtime_2_systime($news->last_modified, 'H:i:s d/m/Y'); ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Mô tả chung (nếu có)</label>
                                                </td>
                                                <td>
                                                    <textarea id="summary" name="summary" cols="79" rows="5"><?php echo $news->summary; ?></textarea>
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Nội dung</label>
                                                </td>
                                                <td>
                                                    <textarea class="editor" id="content" name="content" cols="79" rows="20"><?php echo $news->content; ?></textarea>
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr class="alt-row">
                                                <td>
                                                    <label for="enable">Hiển thị trên danh sách của nhóm tin</label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="enable" <?php echo ($news->enable == BIT_TRUE) ? "checked='checked'" : "" ?> alt="" > Enable
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <fieldset>
                                        <p>
                                            <input class="button" type="submit" id="save" name="save" value="Cập nhật" />
                                            <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" title="Một số thông tin chưa đúng" />
                                        </p>
                                    </fieldset>
                                </form>
                            <?php endif; ?>
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