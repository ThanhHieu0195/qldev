<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST, F_GUEST_GUEST_GROUP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Nhóm khách hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
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
                
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">

                        <h3>Nhóm khách hàng</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="../guest/addgroup.php" method="post">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Mã nhóm</th>
                                            <th>Tên nhóm</th>
                                            <th>Sửa</th>
                                            <th>Xóa</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                        include_once '../models/database.php';

                                        //Tên tranh
                                        $db = new database();
                                        $db->setQuery("SELECT * FROM nhomkhach");
                                        $array = $db->loadAllRow();
                                        foreach ($array as $value) {
                                            echo "<tr>";
                                            echo "<td><span class='price'>" . $value['manhom'] . "</span></td>";
                                            echo "<td>" . $value['tennhom'] . "</td>";
                                            echo "<td><a href='groupdetail.php?item=" . $value['manhom'] . "'
                                                        title='Edit'>
                                                            <img src='../resources/images/icons/pencil.gif' alt='Edit' /></a></td>";
                                            echo "<td><a href='delgroup.php?item=" . $value['manhom'] . "' " .
                                            "onclick=\"return confirm('Bạn có chắc không?');\"
                                                        title='Delete'>
                                                            <img src='../resources/images/delete2.jpg' alt='Delete' /></a></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br />
                                <br />
                                <span class="bold">Tên nhóm khách</span>
                                <span id="sprytextfield1">
                                    <input class="text-input small-input" type="text" name="tennhom" id="tennhom" />
                                    <span class="textfieldRequiredMsg">Nhập tên nhóm khách.</span>
                                </span>
                                <br />
                                <input class="button" type="submit" name="submit" value="Thêm" />
                            </form>
                            <br />
                            <br />
                        </div> <!-- End #tab3 -->

                    </div> <!-- End .content-box-content -->

                </div> <!-- End .content-box -->

                <?php require_once '../part/footer.php'; ?>

            </div> <!-- End #main-content -->
        </div>
        <script type="text/javascript">
            <!--
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            //-->
        </script>

    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>