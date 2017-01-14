<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_COUPON_VERIFY, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Verify coupon</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css">
            #coupon_info, #coupon_used { width: 80% !important; }
            #coupon_info label, #coupon_used label { font-size: 15px !important; }
            #coupon_info span, #coupon_used span { font-size: 17px !important; }
            #coupon_used { display: none; }
            .name { color: blue; font-weight: bolder; }
            .ui-autocomplete-loading { background: white url('../resources/images/loading.gif') right center no-repeat !important; }
            #coupon_used a { color: blueviolet; }
            
            .close-button { color: #990000; font-size: 10.5px; position: absolute; right: 5px; top: 5px; }
            #add-form { display: none; }            
            #add-form label, #dialog-form input { display: block; }
            #add-form input.text { margin-bottom: 12px; width: 75%; padding: .4em; }
            #add-form label { font-weight: bold; font-size: 12px !important; }
            #add-form fieldset { padding: 0; border: 0; margin-top: 5px; }
            
            #dialog-form label, #dialog-form input { display: block; }
            #dialog-form input.text { margin-bottom: 12px; width: 75%; padding: .4em; }
            #dialog-form fieldset { padding: 0; border: 0; margin-top: 5px; }
            #dialog-form h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog { left: 30% !important; top: 30% !important; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
            #loading { display: none; }
            img { vertical-align: middle; }
        </style>
        
        <script type="text/javascript" src="../resources/scripts/utility/coupon-verify.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
            });
        </script>
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
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Verify coupon</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form method="post" action="">
                                <?php
                                require_once '../config/constants.php';
                                require_once '../models/coupon.php';
                                require_once '../models/coupon_assign.php';
                                require_once '../models/coupon_used.php';
                                require_once '../models/coupon_third_used.php';
                                require_once '../models/khach.php';
                                require_once '../models/nhanvien.php';
                                require_once '../models/khohang.php';
                                
                                if(isset($_POST['verify']))
                                {
                                    $coupon_code = $_POST['coupon'];
                                    $coupon = new coupon();
                                    $verify = $coupon->verify($coupon_code);
                                }
                                if(isset($_POST['used']))
                                {
                                    // debug($_POST);
                                    $coupon_used = new coupon_used();
                                    if($_POST['usedtype'] == '1')
                                        $data = array('used_by' => $_POST['makhachhangmoi']);
                                    else
                                        $data = array('used_by' => $_POST['makhachhang']);
                                    
                                    $coupon_used->update($_POST['couponcode'], $data);
                                    
                                    // Them vao bang 'third_used'
                                    if(($_POST['usedtype'] == '1') && ($_POST['assign_type'] != COUPON_ASSIGN_FREELANCER_NEW))
                                    {
                                        $third_used = new coupon_third_used();
                                        $third_used->add_new($_POST['couponcode'], $_POST['makhachhang'], $_POST['makhachhangmoi']);
                                    }
                                    
                                    header('location: ../view/store.php');
                                }
                                ?>
                                <?php if(isset($verify) && ! $verify['verify']): ?>
                                <div class="notification error png_bg" style="width: 50% !important;">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        <?php echo $verify['message']; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <fieldset>
                                    <p>
                                        <label for="coupon">Mã coupon (*)</label>
                                        <input type="text" id="coupon" name="coupon" class="text-input small-input" maxlength="50" />
                                        <br /><small>Coupon code</small>
                                    </p>
                                    <p>
                                        <input type="submit" class="button" id="verify" name="verify" value="Verify" />
                                    </p>
                                </fieldset>
                                <?php if(isset($verify) && $verify['verify']): ?>
                                <div style="padding-top: 20px">
                                    <?php
                                    // Them data vao trong bang 'coupon_used'
                                    $coupon_used = new coupon_used();
                                    $data = array('coupon_code' => $coupon_code, 'verify_by' => current_account());
                                    $coupon_used->add_new($data);

                                    // Cap nhat trang thai coupon
                                    $coupon = new coupon();
                                    $coupon->update_status($coupon_code, COUPON_STATUS_USED);
                                    
                                    // Lay thong tin assign cua coupon
                                    $coupon_assign = new coupon_assign();
                                    $assign_detail = $coupon_assign->assign_detail($coupon_code);
                                    
                                    // Lay thong tin khach hang duoc assign
                                    $khach = new khach();
                                    $guest = $khach->detail($assign_detail['assign_to']);
                                    
                                    // Thong tin cong tac vien duoc assign
                                    $nhanvien = new nhanvien();
                                    $freelancer = $nhanvien->detail_by_uid($assign_detail['assign_to']);
                                    
                                    $khohang = new khohang();
                                    
                                    // Dua gia tri coupon code vao session
                                    //session_register(COUPON_CODE);
                                    $_SESSION[COUPON_CODE] = $coupon_code;
                                    ?>
                                    <div id="coupon_info" class="notification information png_bg">
                                        <div>
                                            Thông tin coupon
                                        </div>
                                        <div>
                                            <label>Coupon code</label>
                                            <span class="price"><?php echo $coupon_code; ?></span>
                                            <input type="hidden" id="couponcode" name="couponcode" value="<?php echo $coupon_code; ?>" />
                                        </div>
                                        <div>
                                            <label>Nội dung coupon</label>
                                            <span class="price"><u><?php echo $assign_detail['content']; ?></u></span>
                                        </div>
                                        <div>
                                            <label>Hạn sử dụng</label>
                                            <span class="price"><?php echo date('d/m/Y', strtotime($assign_detail['expire_date'])); ?></span>
                                        </div>
                                        <!-- Guest -->
                                        <?php if(($verify['assign_type'] == COUPON_ASSIGN_GUEST_NEW) || ($verify['assign_type'] == COUPON_ASSIGN_GUEST_THIRD_USED)): ?>
                                            <div>
                                                <label>Khách hàng</label>
                                                <span class="price"><?php echo $guest['hoten']; ?></span>
                                            </div>
                                            <div>
                                                <label>Mã khách hàng</label>
                                                <span class="price"><?php echo $guest['makhach']; ?></span>
                                                <input type="hidden" id="makhachhang" name="makhachhang" value="<?php echo $guest['makhach']; ?>" />
                                            </div>
                                            <div>
                                                <label>Nhóm khách hàng</label>
                                                <span class="price"><?php echo $guest['tennhom']; ?></span>
                                            </div>
                                            <div>
                                                <label>Địa chỉ</label>
                                                <span class="price"><?php echo $guest['diachi']; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <!-- Freelancer -->
                                        <?php if($verify['assign_type'] == COUPON_ASSIGN_FREELANCER_NEW): ?>
                                            <div>
                                                <label>Cộng tác viên</label>
                                                <span class="price"><?php echo $freelancer['manv']; ?></span>
                                                <input type="hidden" id="freelancer" name="freelancer" value="<?php echo $freelancer['manv']; ?>" />
                                            </div>
                                            <div>
                                                <label>Họ tên</label>
                                                <span class="price"><?php echo $freelancer['hoten']; ?></span>
                                            </div>
                                            <div>
                                                <label>Chi nhánh</label>
                                                <span class="price"><?php echo $khohang->ten_kho($freelancer['macn']); ?></span>
                                            </div>
                                            <div>
                                                <label>Địa chỉ</label>
                                                <span class="price"><?php echo $freelancer['diachi']; ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Guest -->
                                <?php if(($verify['assign_type'] == COUPON_ASSIGN_GUEST_NEW) || ($verify['assign_type'] == COUPON_ASSIGN_GUEST_THIRD_USED)): ?>
                                    <div style="padding-top: 10px">
                                        <p>
                                            <label style="font-size: 15px;">Người sử dụng coupon:</label><br />
                                            <input type="radio" value="0" id="usedtype1" name="usedtype" checked="checked" onclick="showCouponUsed(false);" /> Khách hàng được assign<br />
                                            <input type="radio" value="1" id="usedtype2" name="usedtype" onclick="showCouponUsed(true);" /> Khách hàng khác
                                        </p>
                                    </div>
                                <?php endif; ?>
                                <!-- Freelancer -->
                                <?php if($verify['assign_type'] == COUPON_ASSIGN_FREELANCER_NEW): ?>
                                    <div style="padding-top: 10px">
                                        <p>
                                            <input type="radio" value="1" id="usedtype2" name="usedtype" checked="checked" /> Khách hàng sử dụng coupon:
                                            <input type="hidden" id="assign_type" name="assign_type" value="<?php echo $verify['assign_type']; ?>" />
                                        </p>
                                        <script type="text/javascript" charset="utf-8">
                                            $(function() {
                                                showCouponUsed(true);
                                            });
                                        </script>
                                    </div>
                                <?php endif; ?>
                                
                                <fieldset id="coupon_used">
                                    <label for="search_guest">Tìm khách hàng (*)</label>
                                    <input type="text" name="search_guest" id="search_guest" class="text-input medium-input" maxlength="50" />
                                    <!-- <div style="padding-bottom: 10px;"></div> -->
                                    <a id="add-button" title="Thêm khách hàng" href="javascript:showDialog();">
                                        <img alt="add" src="../resources/images/icons/add.png" />&nbsp;Thêm khách hàng
                                    </a>
                                    <script type="text/javascript">
                                        $( "#search_guest" ).autocomplete({
                                            minLength: 1,
                                            source: "../ajaxserver/autocomplete_server.php?type=abc",
                                            select: function( event, ui ) {
                                                $( "#search_guest" ).val('');
                                                   $( "#tenkhachhangmoi" ).html( ui.item.hoten );
                                                $( "#khachhangmoi" ).html( ui.item.makhach );
                                                $( "#makhachhangmoi" ).val( ui.item.makhach );
                                                $( "#nhomkhachhangmoi" ).html( ui.item.nhomkhach );
                                                $( "#diachimoi" ).html( ui.item.diachi );
    
                                                return false;
                                            }
                                        }).data( "autocomplete" )._renderItem = function( ul, item ) {
                                            return $( "<li></li>" )
                                                .data( "item.autocomplete", item )
                                                .append( "<a>" + "<span class='name'>" + item.hoten + "</span>" + "<br>" + item.diachi + "</a>" )
                                                .appendTo( ul );
                                        };
                                    </script>
                                    <div style="padding-bottom: 10px;"></div>
                                    <div id="add-form" class="notification attention png_bg">
                                        <a class="close-button" href="javascript:hideDialog();"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png">&nbsp;Đóng lại</a>
                                        <div>
                                            <fieldset>
                                                <label>Họ tên</label>
                                                <input type="text" name="add-hoten" id="add-hoten" class="text ui-widget-content ui-corner-all" maxlength="100" /><br />
                                                <label>Nhóm khách</label>
                                                <input type="text" id="search_guest_type" name="search_guest_type" class="text ui-widget-content ui-corner-all" />
                                                <input type="hidden" id="add-nhomkhach" name="add-nhomkhach" />
                                                <label>Số nhà, phường</label>
                                                <input type="text" name="add-diachi" id="add-diachi" class="text ui-widget-content ui-corner-all" />
                                                <label>Quận, huyện</label>
                                                <input type="text" name="add-huyen" id="add-huyen" class="text ui-widget-content ui-corner-all" />
                                                <input type="hidden" value="" name="add-quan" id="add-quan" /><br />
                                                <input type="radio" checked="checked" value="1" name="add-tinhthanh" id="add-tinhthanh1" />Thành phố Hồ Chí Minh<br />
                                                <input type="radio" value="0" name="add-tinhthanh" id="add-tinhthanh2" />Tỉnh, thành khác
                                                <input type="text" name="add-tinh" id="add-tinh" class="text ui-widget-content ui-corner-all" />
                                                <label>Điện thoại</label>
                                                <input type="text" name="add-dienthoai1" id="add-dienthoai1" class="text ui-widget-content ui-corner-all" />
                                                <input type="text" name="add-dienthoai2" id="add-dienthoai2" class="text ui-widget-content ui-corner-all" />
                                                <input type="text" name="add-dienthoai3" id="add-dienthoai3" class="text ui-widget-content ui-corner-all" /><br />
                                                <input type="checkbox" value="0" id="add-tiemnang" name="add-tiemnang" /> <b>Khách hàng tiềm năng</b>
                                                <div style="padding-bottom: 5px;"></div>
                                                <input type="button" id="add-new" name="add-new" value="Thêm" class="button" />
                                                <img id="loading" alt="loading" src="../resources/images/loading2.gif" />
                                           </fieldset>
                                       </div>
                                    </div>
                                    <div style="padding-bottom: 10px;"></div>
                                    <div class="notification information png_bg">
                                        <div>
                                            <label>Khách hàng</label>
                                            <span id="tenkhachhangmoi" class="price">?</span>
                                        </div>
                                        <div>
                                            <label>Mã khách hàng</label>
                                            <span id="khachhangmoi" class="price">?</span>
                                            <input type="hidden" id="makhachhangmoi" name="makhachhangmoi" value="" />
                                        </div>
                                        <div>
                                            <label>Nhóm khách hàng</label>
                                            <span id="nhomkhachhangmoi" class="price">?</span>
                                        </div>
                                        <div>
                                            <label>Địa chỉ</label>
                                            <span id="diachimoi" class="price">?</span>
                                        </div>
                                    </div> 
                                </fieldset>
                                <p>
                                    <input type="submit" id="used" name="used" value="Xác nhận" class="button" />
                                </p>
                                <?php endif; ?>
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
