<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_STORES, F_STORES_STORE_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách kho hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
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
                <?php if (verify_access_right(current_account(), F_STORES_ADD_STORE)): ?>
                    <ul class="shortcut-buttons-set">
                        <li>
                            <a class="shortcut-button new-page" href="addstore.php">
                                <span class="png_bg">Thêm kho hàng</span>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách kho hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Mã kho</th>
                                            <th>Tên kho</th>
                                            <th>Địa chỉ</th>
                                            <th>Hàng có sẵn trong kho</th>
                                            <th>Module sẵn trong kho</th>
                                            <?php if (verify_access_right(current_account(), F_STORES_STORE_MANAGEMENT)): ?>
                                                <th>Sửa thông tin kho</th>
                                                <th>Xóa</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once '../models/khohang.php';

                                        $db = new khohang();
                                        $array = $db->danh_sach_kho_hang();
                                        foreach ($array as $value) {
                                            echo "<tr>";
                                            echo "<td><span class='price'>" . $value['ma_kho_hang'] . "</span></td>";
                                            echo "<td>" . $value['tenkho'] . "</td>";
                                            echo "<td>" . $value['diachi'] . "</td>";
                                            echo "<td><a href='itemofstore.php?item=" . $value['ma_kho_hang'] . "'
                                                         title='Chi tiết'>
                                                            <img src='../resources/images/view.jpg' alt='View' />
                                                            <span class='blue'>" . $value['soluong'] . "</span>
                                                      </a></td>";
                                            echo "<td><a href='itemofstoremodule.php?item=" . $value['ma_kho_hang'] . "'
                                                         title='Chi tiết'>
                                                            <img src='../resources/images/view.jpg' alt='View' />
                                                            <span class='blue'>" . $value['soluongm'] . "</span>
                                                      </a></td>";
                                            if (verify_access_right(current_account(), F_STORES_STORE_MANAGEMENT)):
                                                echo "<td><a href='storedetail.php?item=" . $value['ma_kho_hang'] . "'
                                                            title='Edit'>
                                                                <img src='../resources/images/icons/pencil.gif' alt='Edit' /></a></td>";
                                                echo "<td><a href='delstore.php?item=" . $value['ma_kho_hang'] . "' " .
                                                "onclick=\"return confirm('Bạn có chắc không?');\"
                                                            title='Delete'>
                                                                <img src='../resources/images/delete2.jpg' alt='Delete' /></a></td>";
                                            endif;    
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                            <br />
                            <br />
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
