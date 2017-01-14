<?php
require_once '../part/common_start_page.php';
// Authenticate
do_authenticate(G_MANAGER_BUILDING, F_LIST_GROUP_CONSTRUCTION, TRUE);
?>
<?php require_once "list_group_construction/process-request.php"; ?>
<?php require_once "list_group_construction/init.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Danh sách đội thi công</title>
    <?php require_once "list_group_construction/link.php"; ?>
    <?php require_once "list_group_construction/script.php"; ?>
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
            <!-- HT -->
            <?php require_once "list_group_construction/part-detail-list-group-construction.php"; ?>
            <?php require_once "list_group_construction/part-form-add.php"; ?>
            <?php require_once "list_group_construction/part-form-edit.php"; ?>
            <?php require_once "list_group_construction/part-form-del.php"; ?>
        </div>
    </body>
    </html>
    <?php 
    require_once '../part/common_end_page.php';
    ?>
