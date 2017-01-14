<?php
require_once '../part/common_start_page.php';

// Authenticate
// do_authenticate(G_ORDERS, F_BILL_VOUCHERS, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Phiếu giao chứng từ</title>
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
            #themkhachmoi { /*color: red;*/ }
            #pay-form tbody tr.alt-row { background: none; }
            #notification {
                display: none;
                background-color: #FFFFFF;
                padding: 10px 20px;
                width: 200px;
                height: 100px;
                text-align: center;
            }
            #notification > .header {
                color: #000000;
                text-shadow: 2px 2px 1px;
                font-weight: bold;
                font-size: 30pt;
            }
            #notification > p {
                color: #FF0000;
            }
            .none {
                display: none;
            }
        </style>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/add-guest.js"></script>

        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />

        <script type="text/javascript">
            // DOM load
            $(function() {
                // numeric
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
                <?php 
                    require_once '../config/constants.php';
                    require_once '../models/cart.php';
                    
                    $cart = new Cart(CART_NAME);
                    $result = $cart->count();
                 ?>
                <div class="clear"></div>
                  
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin giao chứng từ</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                                    
                            <form id="pay-form" action="vouchers.php" method="post">
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
                                            <input type="hidden" name="action" id="action"/>
                                            <input type="hidden" name="maphieu" id="maphieu"/>
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
                                     
                                    <!--  -->
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
                                                <span class="bold">Ngày giao</span>
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
                                                <span class="bold">Giờ giao (0-24)</span>
                                            </td>
                                            <td>
                                                <?php echo $input ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span class="bold">Ghi chú</span>
                                            </td>
                                             <td>
                                                <textarea name="note" id="note" cols="10" rows="3"></textarea>
                                            </td>
                                        </tr>
                                        <!-- //-- REQ20120915_BinhLV_N -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="save" id="save" value="Lưu hóa đơn" />
                                                    <input class="button none" type="submit" name="approve" id="approve" value="giao chứng từ" />
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div id="notification">
                                    <div class="header">Thông báo</div>
                                    <p></p>
                                </div>

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

                                    <?php 
                                        // chức năng thêm và cập nhật
                                        if (verify_access_right(current_account(), F_BILL_VOUCHERS)) {
                                            if (isset($_POST['action'])) {
                                                require_once "../models/vouchers.php";
                                                $action = $_REQUEST['action'];
                                                if ($action == 'accept') {
                                                    $maphieu = $_REQUEST['maphieu'];
                                                    $model = new voucher();
                                                    $result = $model->accept($maphieu);
                                                    if ($result) {
                                                        $message = "thao tác thành công";
                                                    } else {
                                                        $message = "thao tác thất bại";
                                                    }
                                                    $_GET['item'] = $maphieu;
                                                    echo "alert('".$message."');";
                                                } else {
                                                    $ngaygiao = $_REQUEST['ngaygiao'];
                                                    $giogiao = $_REQUEST['giogiao'].":00:00";
                                                    $makhach = $_REQUEST['hotenkhach'];;
                                                    $ghichu = $_REQUEST['note'];
                                                    $trangthai = BIT_FALSE;
                                                    $manhanvien = current_account();

                                                    $model = new voucher();
                                                    if ($action == "UPDATE") {
                                                        $maphieu = $_REQUEST['maphieu'];
                                                        $result = $model->update($maphieu, $ngaygiao, $giogiao, $makhach, $ghichu, $trangthai, $manhanvien); 
                                                    } else {
                                                        $maphieu = create_uid(FALSE);
                                                        $result = $model->insert($maphieu, $ngaygiao, $giogiao, $makhach, $ghichu, $trangthai, $manhanvien); 
                                                    }

                                                    if ($result) {
                                                        $message = "Thao tác thành công";
                                                    } else {
                                                        $message = "Thao tác thất bại thất bại";
                                                    }
                                                    $_GET['item'] = $maphieu;
                                                    echo "alert('".$message."');";
                                                }
                                                // echo "$('#notification').bPopup();";
                                            }    
                                        }

                                        // lấy thông tin
                                        if (isset($_GET['item'])) {
                                            require_once "../models/vouchers.php";
                                            require_once "../models/khach.php";

                                            $item = $_GET['item'];
                                            $model = new voucher();

                                            $data = $model->get($item);
                                            $guest = new khach();
                                            $information_guest = $guest->thong_tin_khach_hang($data['makhach']);
                                            $hours = array_shift(explode(':', $data['giogiao']));
                                            if (isset($information_guest)) {
                                                $info = "$('#tenkhach').html('".$information_guest['hoten']."')
                                                $('#makhach').html('".$information_guest['makhach']."');
                                                $('#hotenkhach').val('".$information_guest['makhach']."');
                                                $('#nhomkhach').html('".$information_guest['tennhom']."');
                                                $('#diachi').html('".$information_guest['diachi']."');
                                                $('#ngaygiao').val('".$data['ngaygiao']."');
                                                $('#giogiao').val('".$hours."');
                                                $('#note').val('".$data['ghichu']."');
                                                $('#action').val('UPDATE');
                                                $('#maphieu').val('".$data['maphieu']."');
                                                ";

                                                if (verify_access_right(current_account(), F_BILL_VOUCHERS)) {
                                                    if ($data['trangthai'] != '0') {
                                                        $info.="$('#save').remove();";
                                                    }
                                                    if ($data['trangthai'] == '0') {
                                                         $info.="$('#approve').show('100', function() {
                                                                     $('#approve').click(function(event) {
                                                                         /* Act on the event */
                                                                         $('#action').val('accept');
                                                                     });
                                                                 });";
                                                    }
                                                } else {
                                                     $info.="$('#save').remove();";
                                                }
                                                
                                                echo $info;
                                            }
                                        }
                                     ?>

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
