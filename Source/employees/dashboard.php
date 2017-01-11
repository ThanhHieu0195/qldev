<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_NOTIFICATIONS, F_NOTIFICATIONS_DASHBOARD, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Dashboard</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" href="../resources/css/message.css" type="text/css" />
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
        </style>
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
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
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <!-- //-- REQ20120508_BinhLV_N -->
                <!-- Page Head -->
                <h2>Chào mừng <?php echo current_account(TENNV); ?></h2>
                <p id="page-intro">Chúc bạn một ngày làm việc vui vẻ!</p>
                
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), array(F_SETTINGS_ORDER_CONFIGURE, F_SETTINGS_MAIL_CONFIGURE, F_SETTINGS_TASK_CONFIGURE))): ?>
                        <li>
                            <a class="shortcut-button settings" title="Cấu hình các thông tin hệ thống" href="../settings/configure_menu.php">
                                <span class="png_bg">Settings</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_DECENTRALIZE_ROLE_GROUP)): ?>
                        <li>
                            <a class="shortcut-button user_preferences" title="Phân quyền truy cập trên hệ thống" href="../decentralize/role-group-list.php">
                                <span class="png_bg">Phân quyền</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="clear"></div>
                <!-- Thông tin công ty mới nhất -->
                <div class="content-box">
                    <div class="content-box-header">
                        <h3>Thông tin mới nhất từ công ty</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php
                                require_once '../models/news.php';
                                
                                // Get latest news detail
                                $model = new news();
                                $news = $model->get_latest();
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
                
                <!-- Start Dashboard items -->
                <?php 
                    require_once '../models/dask_board.php';
                    $model = new dask_board();
                    
                    $cssClass = array(0 => "column-left", 1 => "column-right");
                    // Group to display on dashboard
                    $groups = array(
                        G_TASK, G_EQUIPMENT, G_ORDERS, G_ITEMS, G_REWARDS_PENALTY, G_WORKING_CALENDAR, 
                        G_GUEST_DEVELOPMENT, G_FINANCE, G_CSKH
                    );
                    // Items list
                    $items = array();
                    $count = 0;
                    foreach ($groups as $g) {
                        $arr = $model->create_daskboard_content($g);
                        
                        if (! empty($arr['content'])) {
                            $items[] = array(
                                'css' => $cssClass[$count % 2], 
                                'title' => $arr['title'], 
                                'content' => $arr['content']);

                            $count++;
                        }
                    }
                    
                    foreach ($items as $d) {
                ?>
                        <div class="content-box <?php echo $d['css']; ?>">
                            <div class="content-box-header">
                                <h3><?php echo $d['title']; ?></h3>
                            </div>
                            <div class="content-box-content">
                                <div class="tab-content default-tab"><?php echo $d['content']; ?></div>
                            </div>
                        </div>
                <?php 
                        if ($d['css'] == $cssClass[1]) {
                        ?>
                            <div class="clear"></div>
                        <?php
                        }
                    }
                ?>
                <!-- End Dashboard items -->
                
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
