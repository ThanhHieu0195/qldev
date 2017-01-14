<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_EMPLOYEES, F_EMPLOYEES_STAFF_LIST, TRUE );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách thợ làm tranh</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#example').dataTable();
            } );
        </script>
    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

            <?php
            require_once '../part/menu.php';
            ?>

            <div id="main-content"> <!-- Main Content Section with everything -->
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <!-- //-- REQ20120508_BinhLV_N -->
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_ADD_STAFF)): ?>
                        <li>
                            <a class="shortcut-button new-page" href="addstaff.php">
                                <span class="png_bg">Thêm thợ</span>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul><!-- End .shortcut-buttons-set -->
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">

                        <h3>Danh sách thợ làm tranh</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th class="sorting_asc ui-state-default">Mã thợ</th>
                                                    <th class="sorting ui-state-default">Họ tên</th>
                                                    <th class="sorting ui-state-default">Điện thoại</th>
                                                    <th class="sorting ui-state-default">Địa chỉ</th>
                                                    <th class="sorting ui-state-default">Sửa</th>
                                                    <th class="sorting ui-state-default">Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require_once '../models/tho.php';
                                                $db = new tho();
                                                $array = $db->danh_sach_tho("");
                                                foreach ($array as $value) {
                                                ?>

                                                    <tr class="gradeA odd">
                                                        <td class=" sorting_1">
                                                            <a href="#"><?php echo $value['matho'] ?></a>
                                                        </td>
                                                        <td class="">
                                                            <span class="blue"><?php echo $value['hoten']; ?></span>
                                                        </td>
                                                        <td class=""><?php echo $value['dienthoai']; ?></td>
                                                        <td class=""><?php echo $value['diachi']; ?></td>
                                                        <td class="center">
                                                            <a href="staffdetail.php?item=<?php echo $value['matho'] ?>"
                                                               title="Edit">
                                                                <img src="../resources/images/icons/pencil.gif" alt="Edit" />
                                                            </a>
                                                        </td>
                                                        <td class="center">
                                                            <a href="delstaff.php?item=<?php echo $value['matho'] ?>"
                                                               onclick="return confirm('Bạn có chắc không?');"
                                                               title="Delete">
                                                                <img src="../resources/images/delete2.jpg" alt="Delete" />
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br />
                                        <br />
                                    </div>
                                </div>
                            </div>
                            <br />
                            <br />
                        </div> <!-- End #tab3 -->

                    </div> <!-- End .content-box-content -->

                </div> <!-- End .content-box -->

                <?php require_once '../part/footer.php'; ?>

            </div> <!-- End #main-content -->

        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
