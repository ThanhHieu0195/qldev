<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_SALE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thanh toán</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .ui-autocomplete-loading { background: white url('../resources/images/loading.gif') right center no-repeat !important; }
            .close-button { color: #990000; font-size: 10.5px; position: absolute; right: 5px; top: 5px; }
            #add-form { display: none; }
            #add-form label, #dialog-form input { display: block; }
            #add-form input.text { margin-bottom: 12px; width: 75%; padding: .4em; }
            #add-form label { font-weight: bold; font-size: 12px !important; }
            #add-form fieldset { padding: 0; border: 0; margin-top: 5px; }
            #loading { display: none; }
            img { vertical-align: middle; }
            #themkhachmoi { /*color: red; }
            #pay-form tbody tr.alt-row { background: none; }*/
        </style>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/add-guest.js"></script>
        <script type="text/javascript">
            // DOM load
            function validatecb(name) {
                if (!$("input[name='cb_"+name+"']").is(':checked')) {
                    $("input[name='"+name+"']").val(0);
                    $("input[name='"+name+"']").attr('readonly', true);
                } else {
                    $("input[name='"+name+"']").attr('readonly', false);
                }
            }
            $(function() {
                // numeric
                $("input[name='cb_tienthicong']").change(function() {
                   validatecb('tienthicong');
                });
                $("input[name='cb_tiencattham']").change(function() {
                   validatecb('tiencattham');
                });
                $("input[name='cb_phuthugiaohang']").change(function() {
                   validatecb('phuthugiaohang');
                });
                $("input[name='cb_thutiengiumkhacsi']").change(function() {
                   validatecb('thutiengiumkhacsi');
                });
                $('#tienthicong').numeric();
                $('#tiencattham').numeric();
                $('#phuthugiaohang').numeric();
                $('#thutiengiumkhacsi').numeric();

                $("#tiengiam").numeric({allow:"."});
                $("#duatruoc").numeric();
                $("#search_guest").numeric();
                $("#add-dienthoai1").numeric();
                $("#add-dienthoai2").numeric();
                $("#add-dienthoai3").numeric();
                
                // datepicker
                $("#ngaygiao").datepicker({
                    minDate: +0,
                    changeMonth: true,
                    changeYear: true
                });

                // datepicker
                $("#cashing_date").datepicker({
                    //minDate: +0,
                    changeMonth: true,
                    changeYear: true
                });
                
                //++ REQ20120915_BinhLV_N
                // autocomplete
                var ctrl = $( "#search_guest" ).autocomplete({
                    minLength: 1,
                    source: "../ajaxserver/autocomplete_server.php?type=abc",
                    select: function( event, ui ) {
                        $( "#search_guest" ).val();

                        $( "#tenkhach" ).html( ui.item.hoten );
                        $( "#makhach" ).html( ui.item.makhach );
                        $( "#hotenkhach" ).val( ui.item.makhach );
                        $( "#nhomkhach" ).html( ui.item.nhomkhach );
                        $( "#diachi" ).html( ui.item.diachi );
        
                        return false;
                    }
                }).data( "autocomplete" );
                ctrl. _response = function( content ) {
                    $("#themkhachmoi").hide();
                    if ( !this.options.disabled && content && content.length ) {
                        content = this._normalize( content );
                        this._suggest( content );
                        this._trigger( "open" );
                    } else {
                        $("#themkhachmoi").show();
                        this.close();
                    }
                    this.pending--;
                    if ( !this.pending ) {
                        this.element.removeClass( "ui-autocomplete-loading" );
                    }
                };
                ctrl. _renderItem = function( ul, item ) {
                    return $( "<li></li>" )
                            .data( "item.autocomplete", item )
                            .append( "<a>" + "<span class='name'>" + item.hoten + "</span>" + "<br>" + item.diachi + "</a>" )
                            .appendTo( ul );
                };
                //-- REQ20120915_BinhLV_N               
            });
        </script>
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
                <?php include_once '../part/divcart.php'; ?>
                <div class="clear"></div>
                <div class="notification attention png_bg">
                    <div>
                        Đề nghị điền đầy đủ thông tin khách hàng, các thông tin thanh toán trước khi lưu hóa đơn lên hệ thống.
                    </div>
                </div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách hàng đặt mua</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">                            
                            <?php
                            require_once '../config/constants.php';
                            require_once '../models/cart.php';
                            require_once '../models/helper.php';
                            require_once '../models/coupon_used.php';
                            require_once '../models/khach.php';

                            $cart = new Cart(CART_NAME);
                            $cart->register();
                            $_SESSION['phanbu']=false;
                            if ($cart->count() === 0)
                            {
                                header('location: ../view/cart.php');
                                exit();
                            }
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã sản phẩm</th>
                                        <th>Showroom</th>
                                        <th>Đơn giá(VNĐ)</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total = 0;
                                        $no = 0;
                                        $array = $cart->detail_list();
                                        if($array !== NULL):
                                            foreach ($array as $key => $value):
                                                $no++;
                                                $total += $value['thanhtien'];
                                                if ($value['loai'] == 2) {
                                                    $_SESSION['phanbu'] = true;
                                                }
                                        ?>
                                                <tr>
                                                    <td>
                                                        <span><?php echo $no; ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:"><?php echo $value['masotranh']; ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $value['tenkho']; ?>
                                                    </td>
                                                    <td class="price">
                                                        <?php echo number_2_string($value['giaban']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value['soluong']; ?>
                                                    </td>
                                                    <td class="price">
                                                        <?php echo str_replace(',', '.', number_format($value['thanhtien'])); ?>
                                                    </td>
                                                </tr>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td style="font-weight: bold; font-size: 15px;">Tổng tiền</td>
                                        <td class="price"><?php echo number_format($total, 0) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php 
                    $list_assembly = $cart->detail_list_ASSEMBLY();
                ?>
                 <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Chi tiết sản phẩm lắp ghép</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">                            
                            <table>
                                <thead>
                                    <th>Sản phẩm</th>
                                    <th>Mã chi tiết</th>
                                    <th>Tên chi tiết</th>
                                    <th>Số lượng chi tiết</th>
                                </thead>
                                <tbody>
                                    <?php 
                                    //debug(json_encode($list_assembly));
                                    $format = '<tr><td>%1$s</td> <td>%2$s</td> <td>%3$s</td> <td>%4$s</td></tr>';
                                    foreach ($list_assembly as $key1 => $arr1) {
                                        //echo sprintf($format, $key1, '', '');
                                        foreach ($arr1 as $arr) {
                                            $tmp = "";
                                            $array = $cart->detail_list();
                                            foreach ($array as $key => $value):
                                                if ($value['masotranh']==$key1) {
                                                    $tmp = $value['soluong']; 
                                                    break;
                                                }
                                            endforeach;
                                            if ($key1) {
                                                echo sprintf($format, $key1, $arr['machitiet'], $arr['mota'], $arr['soluong']*$tmp);
                                            }
                                        }
                                    }
                                     ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin đơn hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                                    
                            <form id="pay-form" action="bill.php" method="post" enctype="multipart/form-data">
                                <?php
                                if(isset($_SESSION[COUPON_CODE]))
                                {
                                    $coupon_code = $_SESSION[COUPON_CODE];
                                }
                                if(isset($_SESSION["ordernumber"]))
                                {
                                    $makhach = $_SESSION["ordernumber"];
                                }
                                ?>

                                <table>                                                       
                                    <tbody>
                                        <!-- //++ REQ20120915_BinhLV_N -->
                                        <!-- Khong su dung coupon -->
                                        <?php if(( ! isset($coupon_code)) && (! isset($makhach))): ?>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Tìm khách hàng</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td width="80%">
                                                <input type="text" class="text-input small-input" name="search_guest" id="search_guest" />
                                                <small><i>(Nhập số điện thoại khách hàng)</i></small>                                                
                                                <!-- BEGIN ADD GUEST -->
                                                <div style="padding-bottom: 10px;"></div>
                                                <a id="themkhachmoi" title="Thêm khách hàng" style="display: none;" href="javascript:showDialog();"><img src="../resources/images/icons/user_16.png" alt="add"> Thêm khách hàng mới</a>
                                                <div style="padding-bottom: 5px;"></div>
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
                                                
                                                <!-- BEGIN ADD GUEST -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Khách hàng</span>
                                            </td>
                                            <td>
                                                <span class="price" id="tenkhach">?</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Mã khách hàng</span>
                                            </td>
                                            <td>
                                                <span class="price" id="makhach">?</span>
                                                <input type="hidden" name="hotenkhach" id="hotenkhach" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Nhóm khách hàng</span>
                                            </td>
                                            <td>
                                                <span class="price" id="nhomkhach">?</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Địa chỉ</span>
                                            </td>
                                            <td>
                                                <span class="price" id="diachi">?</span>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        
                                        <!-- Co su dung coupon -->
                                        <?php
                                        if(isset($coupon_code)):
                                            // Lay thong tin used cua coupon
                                            $coupon_used = new coupon_used();
                                            $used_detail = $coupon_used->used_detail(array('coupon_code' => $coupon_code), $coupon_code);
                                            
                                            // Lay thong tin khach hang duoc assign
                                            $khach = new khach();
                                            $guest = $khach->detail($used_detail['used_by']);
                                            
                                            if(is_array($used_detail) && is_array($guest)):
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="bold">Khách hàng</span>
                                                </td>
                                                <td>
                                                    <span class="price" id="tenkhach"><?php echo $guest['hoten']; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Mã khách hàng</span>
                                                </td>
                                                <td>
                                                    <span class="price" id="makhach"><?php echo $guest['makhach']; ?></span>
                                                    <input type="hidden" name="hotenkhach" id="hotenkhach" value="<?php echo $guest['makhach']; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Nhóm khách hàng</span>
                                                </td>
                                                <td>
                                                    <span class="price" id="nhomkhach"><?php echo $guest['tennhom']; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Địa chỉ</span>
                                                </td>
                                                <td>
                                                    <span class="price" id="diachi"><?php echo $guest['diachi']; ?></span>
                                                </td>
                                            </tr>
                                        <?php
                                            endif;
                                        endif;
                                        ?>
                                        <!-- Khach mua truc tiep -->
                                        <?php
                                        if(isset($makhach)):
                                            // Lay thong tin khach hang duoc assign
                                            $khach = new khach();
                                            $guest = $khach->detail($makhach);
                                            if(is_array($guest)):
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="bold">Khách hàng</span>
                                                </td>
                                                <td>
                                                    <span class="price" id="tenkhach"><?php echo $guest['hoten']; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Mã khách hàng</span>
                                                </td>
                                                <td>
                                                    <span class="price" id="makhach"><?php echo $guest['makhach']; ?></span>
                                                    <input type="hidden" name="hotenkhach" id="hotenkhach" value="<?php echo $guest['makhach']; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Nhóm khách hàng</span>
                                                </td>
                                                <td>
                                                    <span class="price" id="nhomkhach"><?php echo $guest['tennhom']; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Địa chỉ</span>
                                                </td>
                                                <td>
                                                    <span class="price" id="diachi"><?php echo $guest['diachi']; ?></span>
                                                </td>
                                            </tr>
                                        <?php
                                            endif;
                                        endif;
                                        ?>
                                        
                                        <tr>
                                            <td>
                                                <span class="bold">Tổng tiền phải trả(VNĐ)</span>
                                            </td>
                                            <td>
                                                <!-- <span class="price" id="tongtien"><?php echo number_format($total, 0) ?></span> -->
                                                <input class="text-input small-input" readonly type="text" id="tongtien" name="tongtien" value="<?php echo number_format($total, 0) ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                                <div class="notification attention png_bg">
                                                    <div>
                                                        Nếu tiền giảm tính theo % thì chỉ nhập số % vào thôi. Ví dụ: 0.5(thay cho 0.5 %); 1(thay cho 1%)
                                                        <br />Nếu nhập số tiền giảm thì nhập theo dạng 100000 tương ứng với số tiền giảm 100 000 VNĐ
                                                        <br />Bấm nút
                                                        <a href="javascript:void(0);" title="Tính" onclick="pay();">  <!-- define in pay.js -->
                                                            <img src="../resources/images/icons/calculate.jpg" alt="Tính" />
                                                        </a>
                                                        để tính thành tiền
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php if(isset($used_detail) && is_array($used_detail) && is_array($guest)): ?>
                                        <tr>
                                            <td>
                                                <span class="bold">Coupon</span>
                                            </td>
                                            <td>
                                                <span class="price" id="coupon_content"><u><?php echo $used_detail['content']; ?></u></span>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td>
                                                <span class="bold">Tiền giảm</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="checkboxpercent" id="checkboxpercent" checked="checked" />Theo %
                                                <input class="text-input small-input" type="text" id="tiengiam" name="tiengiam" value="0" autocomplete="off" />
                                                <span class="input-notification error png_bg" id="error" style="visibility: hidden">Error message</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <!-- define in pay.js -->
                                                <input type="button" class="button" title="Tính" onclick="pay();" value="Thành tiền" />
                                            </td>
                                            <td>
                                                <!-- <span class="price" id="thanhtien">?</span> -->
                                                <input class="text-input small-input" readonly type="text" id="thanhtien" name="thanhtien" value="?"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tiền cọc (Đưa trước)</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text-input small-input" type="text" id="duatruoc" name="duatruoc" onblur=" return left();" onkeyup="return left();" autocomplete="off" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tiền giao hàng (Còn lại)</span>
                                            </td>
                                            <td>
                                                <!-- <span class="price" id="conlai">?</span> -->
                                                <input class="text-input small-input" readonly type="text" id="conlai" name="conlai" value="?"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Mã hóa đơn</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="12" class="text-input small-input" type="text" id="mahoadon" name="mahoadon" bilautocomplete="off" title="Chỉ dùng các ký tự A-Zz-z0-9_ cho mã đơn"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ghi chú</span>                                            </td>
                                            <td>
                                                <textarea class="text-input medium-input" id="ghichu" name="ghichu"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Người bán</span>
                                            </td>
                                            <td>
                                                <small>Chọn nhóm nhân viên:</small>
                                                <select name="groups[]" id="groups" data-placeholder=" " class="chosen-select" multiple style="width:350px;" tabindex="4">
                                                    <option value=""></option>
                                                    <?php 
                                                    require_once '../models/employee_group.php';
                                                    
                                                    $group_model = new employee_group();
                                                    $groups = $group_model->list_group();
                                                    if(is_array($groups)):
                                                        foreach ($groups as $g):
                                                            echo "<option value=\"{$g->group_id}\">{$g->group_name}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                                <div style="padding: 10px;"></div>
                                                <small>Chọn nhân viên:</small>
                                                <select name="members[]" id="members" data-placeholder=" " class="chosen-select" multiple style="width:350px;" tabindex="4">
                                                    <option value=""></option>
                                                    <?php 
                                                    require_once '../models/nhanvien.php';
                                                    
                                                    $nhanvien = new nhanvien();
                                                    $arr = $nhanvien->employee_list();
                                                    if(is_array($arr)):
                                                        foreach ($arr as $item):
                                                            echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <?php
                                            $checkbox = "<input type='checkbox' hidden name='checkboxngaygiao' checked id='checkboxngaygiao' %s />";
                                            $input = "<input name='ngaygiao' value='' type='text' id='ngaygiao' class='text-input small-input'
                                                             readonly='' style='%s' />";
                                            
                                            if($cart->tp_amount() == 0) // don hang khong co san pham hang
                                            {
                                                $checkbox = sprintf($checkbox, "onchange='return chonngaygiao(this);'");
                                                $input = sprintf($input, "display: block;");
                                            }
                                            else
                                            {
                                                $checkbox = sprintf($checkbox, "checked='checked' onclick='return false;'");
                                                $input = sprintf($input, "display: block;");
                                            }
                                            ?>
                                            <td>
                                                <?php echo $checkbox ?>
                                                <span class="bold">Hẹn ngày giao</span>
                                                <?php if($cart->tp_amount() !== 0) echo "<span class='require'>*</span>" ?>
                                            </td>
                                            <td>
                                                <?php echo $input ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <?php
                                            $input = '<select name="giogiao" id="giogiao" class="text-input small-input"> <option value="23" selected="selected">23:00:00</option>';
                                            for ($i=8;$i<=22;$i++) {
                                                $input .= '<option value="'.$i.'">'.$i.':00:00</option>';
                                            }
                                            $input .= '</select>';
                                            ?>
                                            <td>
                                                <span class="bold">Giờ giao hàng (0-24)</span>
                                            </td>
                                            <td>
                                                <?php echo $input ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ngày cần phải thu tiền</span>
                                            </td>
                                            <td>
                                                <input name="cashing_date" type="text" id="cashing_date" class="text-input small-input"
                                                       readonly="readonly" />
                                                <img src="../resources/images/icons/clear.png" alt="delete" onclick="clearCashingDate();" title="Xóa">
                                                <br /><small><i>(Để trống nếu lấy theo ngày giao hàng)</i></small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Hóa đơn đỏ</span>
                                            </td>
                                            <td>
                                                <input maxlength="11" class="text-input small-input" type="text" placeholder="0" id="hoadondo" name="hoadondo" autocomplete="off" />
                                            </td>
                                        </tr>

                                         <tr>
                                            <td>
                                                <span class="bold">Giá trị hóa đơn đỏ</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" placeholder="0" id="giatrihoadondo" name="giatrihoadondo" autocomplete="off" />
                                            </td>
                                        </tr>
                                        <!-- tiền thi công -->
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="cb_tienthicong" name="cb_tienthicong" /><span class="bold">Thu tiền thi công</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" placeholder="0" id="tienthicong" name="tienthicong" autocomplete="off" readonly/>
                                            </td>
                                        </tr>
                                         <!-- Tiền cắt thảm-->
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="cb_tiencattham" name="cb_tiencattham" /><span class="bold">Thu tiền cắt thảm</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" placeholder="0" id="tiencattham" name="tiencattham" autocomplete="off" readonly/>
                                            </td>
                                        </tr>
                                         <!-- Phụ thu giao hàng-->
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="cb_phuthugiaohang" name="cb_phuthugiaohang" /><span class="bold">Thu phụ thu giao hàng</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" placeholder="0" id="phuthugiaohang" name="phuthugiaohang" autocomplete="off" readonly/>
                                            </td>
                                        </tr>
                                         <!-- Thu tiền giùm khách sĩ -->
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="cb_thutiengiumkhacsi" name="cb_thutiengiumkhacsi" /><span class="bold">Thu tiền giùm khách sĩ</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" placeholder="0" id="thutiengiumkhacsi" name="thutiengiumkhacsi" autocomplete="off" readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>File đính kèm:</td>
                                            <td><input type="file" name="attach"></td>
                                        </tr>

                                        <!-- //-- REQ20120915_BinhLV_N -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="save" value="Lưu hóa đơn" />
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                                <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                                <script type="text/javascript">
                                    var config = {
                                      '.chosen-select'           : {},
                                      '.chosen-select-deselect'  : {allow_single_deselect:true},
                                      '.chosen-select-no-single' : {disable_search_threshold:10},
                                      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                                      '.chosen-select-width'     : {width:"95%"}
                                    };
                                    for (var selector in config) {
                                      $(selector).chosen(config[selector]);
                                    }
                                </script>
                            </form>
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
        <div id="dialog-message" title="Thông báo">
            <p>
                <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
                Vui lòng kiểm tra lại các thông tin cần thiết trên hóa đơn.
            </p>
        </div>
    </body>
</html>               
<?php 
require_once '../part/common_end_page.php';
?>