<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_NEWS, F_NEWS_VIEW, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php 
            require_once '../models/news_group.php';
            require_once '../models/news.php';
                
            $group_id = (isset ( $_GET ['i'] )) ? $_GET ['i'] : '';
            $model = new news_group();
            $group = $model->detail($group_id);
            
            // Set user data to site function
            $user_data = array('news_group_id' => $group_id);
            set_site_function(get_site_function(KEY_GROUP), get_site_function(), $user_data);
        ?>
        <title><?php echo ($group != NULL) ? $group->name : "Danh sách bài viết" ?></title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/css/news_management/template.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../resources/css/news_management/cbdb-search-form.css" />
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>
                            <?php echo ($group != NULL) ? $group->name : "" ?>
                            <?php if ($group != NULL && $group->enable == BIT_TRUE): ?>
                                <a title="Tải danh sách toàn bộ bài viết" href="javascript:refresh()">
                                    <img src="../resources/images/icons/refresh_16.png" alt="synchronize" />
                                </a>
                            <?php endif; ?>
                        </h3>
                        <?php if ($group != NULL && $group->enable == BIT_TRUE): ?>
                            <form id="search-form" method="post" action="">
                                <?php 
                                    $keyword = "";
                                    if (isset($_POST['q_search'])) {
                                        $keyword = $_POST['q_search'];
                                    }
                                ?>
                              <input type="text" name="q_search" id="q_search" value="<?php echo $keyword; ?>" />
                              <input type="submit" value="Tìm kiếm" />
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php if ($group != NULL && $group->enable == BIT_TRUE): ?>
                                <table class="blog" width="100%" cellpadding="0" cellspacing="0">
                                    <tbody id="news_list">
                                    </tbody>
                                </table>
                                <center>
                                    <div id="loading" style="display: none;">
                                        <img src="../resources/images/loadig_big.gif" alt="" />
                                    </div>
                                </center>
                                <?php 
                                    // Number of items per page
                                    $items_per_page = 20;
                                    
                                    // Number of pages
                                    $news_model = new news();
                                    $total_groups = ceil($news_model->num_of_news($group->group_id, $keyword) / $items_per_page);
                                ?>
                                <script type="text/javascript" src="../resources/scripts/utility/news_management/news_list.js"></script>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        var track_load = 0; //total loaded record group(s)
                                        var loading  = false; //to prevents multipal ajax loads
                                        var total_groups = <?php echo $total_groups; ?>; //total record group(s)
                                        var items_per_page = <?php echo $items_per_page; ?>; //items per page

                                        function loadData() {
                                            if(track_load <= total_groups && loading==false) //there's more data to load
                                            {
                                                loading = true; //prevent further ajax loading
                                                $('#loading').show(); //show loading image
                                                
                                                //load data from the server using a HTTP POST request
                                                $.post(
                                                        '../ajaxserver/news_autoload_process.php', 
                                                        { 
                                                            'group_id' : '<?php echo $group->group_id; ?>', 
                                                            'group_no' : track_load, 
                                                            'items_per_group' : items_per_page, 
                                                            'key_word' : '<?php echo $keyword; ?>'
                                                        },
                                                        function(data) {
                                                            $("#news_list").append(data); //append received data into the element
        
                                                            //hide loading image
                                                            $('#loading').hide(); //hide loading image once data is received
                                                            
                                                            track_load++; //loaded group increment
                                                            loading = false; 
                                                        
                                                        }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                                                            
                                                            //alert(thrownError); //alert with HTTP error
                                                            $('#loading').hide(); //hide loading image
                                                            loading = false;
                                                        
                                                        });
                                                
                                            }
                                        }
                                        
                                        loadData(); //load first group
                                        
                                        $(window).scroll(function() { //detect page scroll
                                            
                                            if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
                                            {
                                                loadData();
                                            }
                                        });
                                    });
                                </script>
                            <?php else: ?>
                                <div class="notification attention png_bg">
                                    <div>
                                        Nhóm tin không tồn tại hoặc hiện đang bị disable. Vui lòng liên hệ admin để được hỗ trợ!
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
        <div style="display: none;" id="toTop"></div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>