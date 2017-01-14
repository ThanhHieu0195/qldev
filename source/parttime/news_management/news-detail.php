<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_NEWS, F_NEWS_VIEW, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Nội dung bài viết</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <link rel="stylesheet" href="../resources/css/message.css" type="text/css" />
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            #dt_example .sorting { background: #F6F6F6; }
            #dt_example table.display td { padding: 5px 5px 5px 5px !important; }
        </style>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                $('#message-content').find('table').each(function(index, e) {
                    $(e).attr('style', '');
                    $(e).attr('class', '').addClass('bordered');
                    
                });
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
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Nội dung bài viết</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php
                                require_once '../models/news.php';
                                
                                // Get input data
                                $news_id = (isset($_GET['i'])) ? $_GET['i'] : '';

                                // Get news detail
                                $model = new news();
                                $news = $model->detail($news_id);
                            ?>
                            <?php if ($news != NULL && $news->enable == BIT_TRUE): ?>
                                <div id="message-content">
                                    <span class="title"><?php echo $news->title; ?></span>
                                    <div>
                                        <span class="modified">(Cập nhật lúc <?php echo dbtime_2_systime($news->last_modified, 'H:i:s d/m/Y'); ?>)</span>
                                        <div style="height: 20px""></div>
                                    </div>
                                    <div><?php echo $news->content; ?></div>
                                </div>
                                <div style="height: 30px"></div>
                            <?php else: ?>
                                <div class="notification attention png_bg">
                                    <div>
                                        Nội dung bài viết không tồn tại hoặc hiện đang bị disable. Vui lòng liên hệ admin để được hỗ trợ!
                                    </div>
                                </div>
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