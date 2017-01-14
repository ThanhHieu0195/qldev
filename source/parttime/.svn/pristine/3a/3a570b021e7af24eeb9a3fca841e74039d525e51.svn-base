<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_EQUIPMENT, F_EQUIPMENT_IMPORT_EXCEL, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thêm quản lý dụng cụ từ file Excel</title>
        <?php require_once '../part/cssjs.php'; ?>
        <script type="text/javascript" src="../resources/scripts/utility/equipment/import-excel.js"></script>
        <style type="text/css">
            .blue-violet { color: blueviolet; font-weight: normal; }
            img { vertical-align: middle; }
        </style>
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
                    <?php if (verify_access_right(current_account(), F_EQUIPMENT_ADD_NEW)): ?>
                        <li>
                            <a class="shortcut-button add" href="add-new.php">
                                <span class="png_bg">Tạo mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EQUIPMENT_IMPORT_EXCEL)): ?>
                        <li>
                            <a class="shortcut-button excel current" href="import-excel.php">
                                <span class="png_bg">Thêm từ Excel</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thêm quản lý dụng cụ từ file Excel</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="../ajaxserver/import_equipment_excel.php" method="post" enctype="multipart/form-data" target="hidden_upload">
                                <p>
                                    <img src="../resources/images/icons/attachment_16.png" alt="download" />
                                    <label>Download file Excel template <a href="../uploads/templates/Template_Import_Equipments.xls" style="color: blue !important;">tại đây</a>.</label>
                                    <br />
                                </p>
                                <p>
                                    <label>File Excel</label>
                                    <input type="file" id="upload_scn" name="upload_scn" lang="en" class="file_upload" />
                                    <br /><small>Vui lòng chọn file Excel thích hợp</small>
                                </p>
                                <p>
                                    <input class="button" type="submit" name="submit" value="Upload" />
                                </p>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                            </form>
                            <div class="clear"></div>
                            <div style="height: 20px"></div>
                            <div>
                                <div id="upload_notification" class="notification information png_bg">
                                    <div id="upload_message">
                                        Đã thực hiện thêm từ file.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 500px"></div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>