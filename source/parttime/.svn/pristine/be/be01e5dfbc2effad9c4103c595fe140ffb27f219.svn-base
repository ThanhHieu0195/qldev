<?php
require_once '../part/common_start_page.php';
// Authenticate
do_authenticate(G_MANAGER_BUILDING_1, F_LIST_BUILDING_REAL_DATA, TRUE);
require_once "detail_building/init.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Chi tiết hạng mục</title>
    <?php require_once '../part/cssjs.php'; ?>
    <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
    <!-- jQuery.bPopup -->
    <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
    <!--  -->
    <script type="text/javascript" src="../resources/scripts/utility/building/function-support.js"></script>
    <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
    <?php require_once "detail_building/script-implement.php"; ?>
</head>
<body>
<div id="body-wrapper">
    <?php
    require_once '../part/menu.php';
    ?>
    <div id="main-content" style="display: table">
        <noscript>
            <div class="notification error png_bg">
                <div>
                    Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                </div>
            </div>
        </noscript>

        <!-- information category -->
        <?php require_once "detail_building/part-infomation-category.php"; ?>

        <div class="content-box column-left" style="width:100%">
            <div class="content-box-header">
                <h3>Chi tiết các hạng mục</h3>
            </div>
            <!-- detail category -->
            
            <?php require_once "detail_building/part-detail-category-realdata.php"; ?>
           
            <!-- form add -->
            <?php require_once "detail_building/part-add-category.php"; ?>
        </div>

        <!-- detail material -->
        <?php require_once "detail_building/part-detail-material-realdata.php"; ?>
      
    </div>
</body>
<!-- style -->
<?php require_once "detail_building/style.php"; ?>
<script type="text/javascript">
    data_material_category = <?php echo json_encode($data_material_category) ?>;
    list_id_material = <?php echo json_encode($list_id_material) ?>;
</script>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
