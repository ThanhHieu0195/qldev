<?php
require_once '../part/common_start_page.php';

// Authenticate
//do_authenticate(G_VIEW, F_VIEW_QLBAOGIA, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Quản lý báo giá</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            #dialog-form label, #dialog-form input { display: block; }
            #dialog-form input.text { margin-bottom: 12px; width: 95%; padding: .4em; }
            #dialog-form fieldset { padding: 0; border: 0; margin-top: 25px; }
            #dialog-form h1 { font-size: 1.2em; margin: .6em 0; }
            #loading { display: none; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
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
                <div class="clear"></div>
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Kho hàng triển lãm<h3>
                    </div>
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Ma don</th>
                                                    <th>Ngay giao</th>
                                                    <th>Gio giao</th>
                                                    <th>Ho ten</th>
                                                    <th>Nhom khach</th>
                                                    <th>Dia chi</th>
                                                    <th>Quan</td>
                                                    <th>TP</th>
                                                    <th>DT1</th>
                                                    <th>DT2</th>
                                                    <th>DT3</th>
                                                    <th>MK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                <?php
                                require_once '../models/database.php';
                                $db = new database();
                                $sql = "select d.madon as md, d.ngaygiao as ng, d.giogiao as gg, k.makhach as mk, n.tennhom as nk, k.hoten as ht, k.diachi as dc, k.quan as qu, k.tp as tp, k.dienthoai1 as dt1, k.dienthoai2 as dt2, k.dienthoai3 as dt3 from donhang as d inner join khach as k on k.makhach=d.makhach inner join nhomkhach as n on n.manhom = k.manhom where d.ngaygiao>='2016-09-01' and d.ngaygiao<='2016-09-30' and d.trangthai=0 order by ngaygiao, tp, quan, hoten";
                                $db->setQuery($sql);
                                $arri = $db->loadAllRow();
                                if(is_array($arri)):
                                    foreach ($arri as $itemi):
                                            $row = '<tr>';
                                            $row .= '<td>'.$itemi['md'].'</td>'.'<td>'.$itemi['ng'].'</td>'.'<td>'.$itemi['gg'].'</td>';
                                            $row .= '<td>'.$itemi['ht'].'</td><td>'.$itemi['nk'].'</td><td>'.$itemi['dc'].'</td><td>' . $itemi['qu'] . '</td>';
                                            $row .= '<td>'.$itemi['tp'].'</td><td>'.$itemi['dt1'].'</td><td>'.$itemi['dt2'].'</td><td>'.$itemi['dt3'].'</td>';
                                            $row .= '<td>'.$itemi['mk'].'</td></tr>';
                                            echo $row;
                                    endforeach; 
                                endif;
                                ?>
                                            </tbody>
                                        </table>
                                        <div style="padding-bottom: 10px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <div id="dialog-form" title="Đóng báo giá">
            <!--<form action="" method="post" onsubmit="return false;"> -->
                <fieldset>
                    <p class="validateTips">Nhập nguyên nhân đóng:</p>
                    <input type="hidden" id="mabaogia" value="" />                  
                    <select id="listnguyennhan" class="select ui-widget-content ui-corner-all">
                        <option value="Do giá cao">Do giá cao</option>
                        <option value="Do mẫu không phù hợp">Do mẫu không phù hợp</option>
                        <option value="Do không thể đáp ứng thời gian giao hàng">Do không thể đáp ứng thời gian giao hàng</option>
                        <option value="Do nguồn gốc xuất xứ">Do nguồn gốc xuất xứ</option>
                        <option value="Do chất lượng sản phẩm">Do chất lượng sản phẩm</option>
                        <option value="Thành đơn hàng">Thành đơn hàng</option>
                        <option value="khac">Do nguyên nhân khác</option>
                    </select>
                    <label for="name">Nguyên nhân khác:</label>
                    <input type="textarea" name="nguyennhankhac" id="nguyennhankhac" class="text ui-widget-content ui-corner-all" maxlength="255" row="3" cols="100" />
                    <img id="loading" alt="loading" src="../resources/images/loading2.gif" />
                </fieldset>
            <!--</form> -->
       </div>
        <script type="text/javascript" charset="utf-8">
            function showDialog(mabaogia) {
                // Thiet lap cac gia tri hidden tren form
                $("#mabaogia").val(mabaogia);
                $(".validateTips").text("Nhập nguyên nhân đóng:");
                // Hien thi dialg
                $( "#dialog-form" ).dialog( "open" );
            }
            var nguyennhan = $( "#nguyennhankhac" ),
                allFields = $( [] ).add( nguyennhan ),
                tips = $( ".validateTips" );
            function updateTips( t ) {
                tips
                    .text( t )
                    .addClass( "ui-state-highlight" );
                setTimeout(function() {
                    tips.removeClass( "ui-state-highlight", 1500 );
                }, 500 );
            }
            function checkRange(o) {
                if (!o.val().length) {
                    o.addClass( "ui-state-error" );
                    updateTips( "Vui lòng điền vào nguyên nhân khác" );
                    return false;
                } else {
                    return true;
                }
            }
            function checkDonhang(o) {
                if (!o.val().length) {
                    o.addClass( "ui-state-error" );
                    updateTips( "Vui lòng điền mã đơn hàng" );
                    return false;
                } else {
                    return true;
                }
            }
            $( "#dialog-form" ).dialog({
                autoOpen: false,
                height: 250,
                width: 350,
                position: { my: 'top', at: 'top+150' },
                modal: true,
                buttons: {
                    "Ok": function() {
                        var bValid = true;
                        allFields.removeClass( "ui-state-error" );
                        mabaogia = $("#mabaogia").val();
                        listnguyennhan = $("#listnguyennhan").val();
                        nguyennhankhac = $("#nguyennhankhac").val();
                        if (listnguyennhan==="khac") {
                           bValid = bValid && checkRange(nguyennhan);
                           listnguyennhan = $("#nguyennhankhac").val();
                        } else {
                           if (listnguyennhan==="Thành đơn hàng") {
                              bValid = bValid && checkDonhang(nguyennhan); 
                           }
                        }
                        if ( bValid ) {
                            // Ham ajax
                            $( "#loading" ).show();
                            $.ajax({
                                url: '../ajaxserver/dongbaogia.php',
                                type: 'POST',
                                data: 'id=' + mabaogia + '&nguyennhan=' + listnguyennhan + '&note=' + nguyennhankhac,
                                success: function (data, textStatus, jqXHR) {
                                    var json = $.parseJSON(data);
                                    if(json.result == 200) {
                                        window.location.reload();
                                    }

                                    $( "#loading" ).hide();
                                    $( "#dialog-form" ).dialog( "close" );
                                }
                            });
                        }
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                },
                close: function() {
                    allFields.val( "" ).removeClass( "ui-state-error" );
                }
            });
          </script>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
