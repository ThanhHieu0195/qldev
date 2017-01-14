<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST, F_GUEST_ADD_GUEST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thêm khách hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .name {
                color: blue;
                font-weight: bolder;
            }
            .ui-autocomplete-loading { background: white url('../resources/images/loading.gif') right center no-repeat !important; }
            .ui-combobox {
                position: relative;
                display: inline-block;
            }
            .ui-combobox-toggle {
                position: absolute;
                top: 0;
                bottom: 0;
                margin-left: -1px;
                padding: 0;
                /* adjust styles for IE 6/7 */
                *height: 1.7em;
                *top: 0.1em;
            }
            .ui-combobox-input {
                margin: 0;
                padding: 0.3em;
            }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript">
            // DOM load
            $(function() {    
                //++ REQ20120915_BinhLV_N
                // autocomplete
                $( "#huyen" ).autocomplete({
                    minLength: 1,
                    source: "../ajaxserver/autocomplete_server.php?type=district",
                    select: function( event, ui ) {
                        $( "#huyen" ).val( ui.item.ten );
                           $( "#quan" ).val( ui.item.quan );
        
                        return false;
                    }
                })
                .data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + "<span class='name'>" + item.ten + "</span>" + "</a>" )
                        .appendTo( ul );
                };

                $( "#search_guest_type" ).autocomplete({
                    minLength: 1,
                    source: "../ajaxserver/autocomplete_server.php?type=guesttype",
                    select: function( event, ui ) {
                        $( "#search_guest_type" ).val( ui.item.tennhom );
                        $( "#nhomkhach" ).val( ui.item.manhom );
        
                        return false;
                    }
                })
                .data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + "<span class='name'>" + item.tennhom + "</span>" + "</a>" )
                        .appendTo( ul );
                };
                //-- REQ20120915_BinhLV_N               
            });
        </script>
    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

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
                <div class="content-box column-left" style="width:100%">

                    <div class="content-box-header">

                        <h3>Thêm khách hàng mới</h3>

                    </div>

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                if (isset($_POST['submit'])) {
                                    $ok = 1;  //bien kiem tra tinh hop le cua du lieu

                                    $hoten = $_POST['hoten'];  //ho ten
                                    if (empty($hoten))
                                        $ok = 0;
                                    //echo $hoten . '; ';

                                    $nhomkhach = $_POST['nhomkhach'];  //nhom khach
                                    if (empty($nhomkhach))
                                        $ok = 0;
                                    //echo $nhomkhach . '; ';

                                    $diachi = $_POST['diachi'];  //so nha, phuong
                                    if (empty($diachi))
                                        $ok = 0;
                                    //echo $diachi . '; ';

                                    $tinhthanh = $_POST['tinhthanh'];  //TP.HCM/ tinh khac
                                    $tp = "TP.HCM";
                                    $quan = "Q9";
                                    if ($tinhthanh == 1) {
                                        $tp = "TP.HCM";
                                        $quan = $_POST['quan'];
                                        $quan = str_replace("_", " ", $quan);
                                    } else {
                                        $tp = $_POST['tinh'];
                                        $quan = $_POST['huyen'];
                                        if ($quan == '')
                                            $ok = 0;
                                    }
                                    //echo $quan . '; ';
                                    //echo $tp . '; ';

                                    $dienthoai1 = $_POST['dienthoai1'];
                                    //echo $dienthoai;
                                    $dienthoai2 = $_POST['dienthoai2'];
                                    $dienthoai3 = $_POST['dienthoai3'];
                                    $emailchinh = $_POST['emailchinh'];
                                    $emailphu = $_POST['emailphu'];
                                    
                                    //echo $dienthoai1 . '; ';;
                                    //echo $dienthoai2 . '; ';;
                                    //echo $dienthoai3 . '; ';;

                                    $tiemnang = $_POST['tiemnang'];
                                    //echo $tiemnang. '; ';

                                    //Neu tat ca du lieu hop le
                                    if ($ok == 1) {
                                        include_once '../models/khach.php';
                                        $guest = new khach();
                                        if ((!($guest->khach_exist($dienthoai1)))&&(!($guest->khach_exist($dienthoai2)))&&(!($guest->khach_exist($dienthoai3)))&&(!($guest->khach_exist_email($emailchinh)))) {
                                            $them_khach = $guest->them_khach($nhomkhach, $hoten, $diachi, $quan, $tp, $tiemnang, $dienthoai1, $dienthoai2, $dienthoai3, $emailchinh, $emailphu);
                                            //them khach hang thanh cong
                                            if ($them_khach) {
                                                //echo $guest->_sql . '<br />';
                                                echo '<center><span class="input-notification success png_bg">Thêm khách hàng thành công</span><br /><br /></center>';
                                            } else {
                                                echo '<center><span class="input-notification error png_bg">' . $guest->getMessage() . '</span></center>';
                                            }
                                        } else {
                                            echo '<center><span class="input-notification error png_bg">Khách đã có trong hệ thống</span><br /><br /></center>';
                                        }
                                    } else {  //Neu co du lieu khong hop le
                                        echo '<center><span class="input-notification error png_bg">Vui lòng  nhập đúng và đầy đủ các thông tin</span><br /><br /></center>';
                                    }
                                }
                                ?>
                                <table>                                                       
                                    <tfoot>                                        
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="submit" value="Thêm khách hàng" />
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>

                                    <tbody>                                        
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Họ tên</span>
                                            </td>
                                            <td width="80%">
                                                <span id="sprytextfield1">
                                                    <input class="text-input small-input" type="text" id="hoten" name="hoten" />
                                                    <span class="textfieldRequiredMsg">Nhập họ tên.</span></span> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Nhóm khách</span>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="search_guest_type" id="search_guest_type" />
                                                <input type="hidden" name="nhomkhach" id="nhomkhach" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Số nhà, phường</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input medium-input" type="text" id="diachi" name="diachi" />
                                                    <span class="textfieldRequiredMsg">Nhập số nhà, phường.</span></span> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Quận, huyện</span>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="huyen" id="huyen" />
                                                <input type="hidden" id="quan" name="quan" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tỉnh, thành</span>
                                            </td>
                                            <td>
                                                <input type="radio" id="tinhthanh1" name="tinhthanh" value="1" checked="checked" onclick="return showselect('tinhthanh1');" />Thành phố Hồ Chí Minh<br />
                                                <input type="radio" id="tinhthanh2" name="tinhthanh"  value="0" onclick="return showselect('tinhthanh2');" /> Tỉnh, thành khác
                                                <input class="text-input small-input" type="text" id="tinh" name="tinh" style="visibility: hidden" />
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td>
                                                <span class="bold">Email chính (marketing)</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" id="emailchinh" name="emailchinh" />
                                                    <span class="textfieldRequiredMsg">Nhập email</span></span><span id="sprytextfield4">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Email phụ</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input medium-input" type="text" id="emailphu" name="emailphu" />
                                                    <span class="textfieldRequiredMsg">Nhập email</span></span><span id="sprytextfield4">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Điện thoại</span></td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" id="dienthoai1" name="dienthoai1" />
                                                    <span class="textfieldRequiredMsg">Nhập số điện thoại 1.</span></span><span id="sprytextfield4">
                                                    <input class="text-input small-input" type="text" id="dienthoai2" name="dienthoai2" />
                                                    <span class="textfieldRequiredMsg">Nhập số điện thoại 2.</span></span><span id="sprytextfield5">
                                                    <input class="text-input small-input" type="text" id="dienthoai3" name="dienthoai3" />
                                                    <span class="textfieldRequiredMsg">Nhập số điện thoại 3.</span></span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tiềm năng</span>
                                            </td>
                                            <td>
                                                <input type="radio" name="tiemnang" value="0" checked="checked" />Không<br />
                                                <input type="radio" name="tiemnang"  value="1" />Có                                            </td>
                                        </tr>                                        

                                    </tbody>
                                </table>
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
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
            //var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
            //var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
            //-->
        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
