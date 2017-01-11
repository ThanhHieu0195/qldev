<?php
require_once '../part/common_start_page.php';
// Authenticate
do_authenticate(MANAGER_PREMIUM, F_PREMIUM_MAVAN, TRUE);
require_once "mavan/lib.php";
require_once "mavan/process_request.php";
require_once "mavan/init.php";
$title = "Ván";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $title; ?></title>
     <?php
        require_once "mavan/link.php";
        require_once "mavan/style.php";
        require_once "mavan/script.php";
    ?>
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

            <?php require_once "mavan/part_table_detail.php"; ?>
            <?php require_once "mavan/part_form_add.php"; ?>
            <?php require_once "mavan/part_form_edit.php"; ?>
        </div>
    </body>
    </html>
    <?php 
    require_once '../part/common_end_page.php';
    ?>
