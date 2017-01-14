<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_TYPE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Loại sản phẩm</title>
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

                        <h3>Loại sản phẩm</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="../items/addtype.php" method="post">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Mã loại</th>
                                            <th>Tên loại</th>
                                            <th>Đơn vị tính</th>
                                            <th>% Giá sĩ</th>
                                            <th>% Giá lẻ</th>
                                            <th>Sửa</th>
                                            <th>Xóa</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                        include_once '../models/database.php';

                                        //Tên tranh
                                        $db = new database();
                                        $db->setQuery("SELECT * FROM loaitranh");
                                        $array = $db->loadAllRow();
                                        foreach ($array as $value) {
                                            echo "<tr>";
                                            echo "<td><span class='price'>" . $value['maloai'] . "</span></td>";
                                            echo "<td>" . $value['tenloai'] . "</td>";
                                            echo "<td>" . $value['donvi'] . "</td>";
                                            echo "<td>" . $value['giasi'] . "</td>";
                                            echo "<td>" . $value['giale'] . "</td>";
                                            echo "<td><a href='typedetail.php?item=" . $value['maloai'] . "'
                                                        title='Edit'>
                                                            <img src='../resources/images/icons/pencil.gif' alt='Edit' /></a></td>";
                                            echo "<td><a href='deltype.php?item=" . $value['maloai'] . "' " .
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
                                <p>
                                <span class="bold">Tên loại</span>
                                    <span id="sprytextfield1">
                                        <input class="text-input small-input" type="text" name="tenloai" id="tenloai" />
                                        <span class="textfieldRequiredMsg">Nhập tên loại.</span>
                                    </span>
                                </p>
                                <p>
                                    <span class="bold">Đơn vị tính</span>
                                    <span id="sprytextfield2">
                                        <input class="text-input small-input" type="text" name="donvi" id="donvi" />
                                        <span class="textfieldRequiredMsg">Nhập đơn vị tính.</span>
                                    </span>
                                </p>
                                <p>
                                    <span class="bold">% Giá sĩ</span>
                                    <span id="sprytextfield2">
                                        <input class="text-input small-input" type="text" name="giasi" id="giasi" />
                                        <span class="textfieldRequiredMsg">Nhập % Giá sĩ</span>
                                    </span>
                                </p>
                                <p>
                                    <span class="bold">% Giá lẻ</span>
                                    <span id="sprytextfield2">
                                        <input class="text-input small-input" type="text" name="giale" id="giale" />
                                        <span class="textfieldRequiredMsg">Nhập % Giá lẻ</span>
                                    </span>
                                </p>
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
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            //-->
        </script>

    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
