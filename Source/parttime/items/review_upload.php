<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_UPLOAD, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Duyệt file upload</title>
        <?php require_once '../part/cssjs.php'; ?>

        <script type="text/javascript" src="../resources/stickytooltip/stickytooltip.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/stickytooltip/stickytooltip.css" />
        <style type="text/css">
            .blue-violet { color: blueviolet; font-weight: normal; }
        </style>
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
                    <?php if (verify_access_right(current_account(), F_ITEMS_UPLOAD)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="upload.php">
                                <span class="png_bg">Quản lý upload sản phẩm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Duyệt file upload</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php
                            $do = (isset($_GET['do'])) ? $_GET['do'] : NULL;
                            $upload_id = (isset($_GET['item'])) ? $_GET['item'] : NULL;
                            
                            if($do != NULL && $upload_id != NULL)
                            {
                                require_once '../models/upload.php';
                                
                                $upload = new upload();
                                switch($do)
                                {
                                    case 'approve':  // approve
                                        $result = $upload->approve($upload_id);
                                        break;

                                    case 'reject':  // reject
                                        $result = $upload->reject($upload_id);
                                        break;
                                }
                            }
                            ?>
                            <?php if(isset($result) && is_object($result)): 
                                  $class = ($result->result) ? 'information' : 'error';
                            ?>
                            <div>
                                <div id="notification" class="notification <?php echo $class; ?> png_bg">
                                    <div id="message">
                                    <?php if(isset($result->progress) && $result->result == TRUE): ?>
                                        <span class="blue-violet"><?php echo $result->progress; ?></span>
                                        <?php if($result->detail != '') echo '<br />' . $result->detail; ?>
                                    <?php else: ?>
                                        <?php echo $result->message; ?>
                                    <?php endif; ?>
                                    </div>
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