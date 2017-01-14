<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_STORE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Hàng có sẵn trong kho</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <style type="text/css">
            #dialog-form label, #dialog-form input { display: block; }
            #dialog-form input.text { margin-bottom: 12px; width: 95%; padding: .4em; }
            #dialog-form fieldset { padding: 0; border: 0; margin-top: 25px; }
            #dialog-form h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog { left: 40% !important; top: 40% !important; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
            #loading { display: none; }
            img { vertical-align: middle; }
            /*.fixed-dialog{ top: 50px !important; left: 150px !important; }*/
            .fixed-dialog{ top: 8% !important; left: 20% !important; }
            table.dataTable { margin: 0 auto; clear: both; width: 100% !important;}
        </style>

        <?php
        require_once '../config/constants.php';
        require_once '../models/helper.php';
        require_once '../models/nhanvien.php';
        ?>

        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/view_store.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bSort": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/server_processing.php",
                <?php if (verify_access_right(current_account(), F_VIEW_SALE)): ?>
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5, 8 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        console.log(aData);
                        if (aData[8] == <?php echo TYPE_ITEM_ASSEMBLY; ?>) {
                            var event = "showDialog('" + aData[0] + "', '" + aData[7] + "', '" + "1000" + "', '" + aData[8] + "');";
                        } else {
                            var event = "showDialog('" + aData[0] + "', '" + aData[7] + "', '" + aData[5] + "', '" + aData[8] + "');";
                        }
                        var link = "<a title='Thêm vào giỏ hàng' href=\"javascript:" + event + "\"><img alt='add' src='../resources/images/icons/add_24.png' /></a>";
                        $('td:eq(0)', nRow).html( "<a href='javascript:' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>" );
                        $('td:eq(7)', nRow).html(aData[9]);
                        if((aData[5] > 0) && (aData[4]!='khach_tra_hang') && (aData[4]!='hang_dang_chuyen'))
                            $('td:eq(8)', nRow).html(link);
                        else
                            $('td:eq(8)', nRow).html('-');
                        /* Gia ban san pham */
                        var html = "<span class='price'>" + aData[3] + "</span>";
                        $('td:eq(3)', nRow).html(html);
                        var loai = 'Sản xuất';

                        if (aData[8] == <?php echo TYPE_ITEM_ASSEMBLY; ?>) {
                            loai = 'Lắp ráp';
                        }
                        if (aData[8] == <?php echo TYPE_ITEM_PREMIUM; ?>) {
                            loai = 'Phần bù';
                        }

                        $('td:eq(6)', nRow).html(loai);
                        /* Tooltip */
                        oTable.$('#div' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<img />").attr("src", "../" + aData[6]);
                            }
                        });
                    }
                <?php else: ?>
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html( "<a href='javascript:' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>" );
                        /* Gia ban san pham */
                        var html = "<span class='price'>" + aData[3] + "</span>";
                        $('td:eq(3)', nRow).html(html);

                        /* Tooltip */
                        oTable.$('#div' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<img />").attr("src", "../" + aData[6]);
                            }
                        });
                    }
                <?php endif; ?>
                });
            } );
        </script>
        <script type="text/javascript" charset="utf-8">
            function showDialog(masotranh, makho, tonkho, loai) {
                // Thiet lap cac gia tri hidden tren form
                if (loai == <?php echo TYPE_ITEM_PREMIUM; ?>) {
                    console.log('vo');
                    $("#dialog-form-2 input[name='masotranh']").val(masotranh);
                    $("#dialog-form-2 input[name='makho']").val(makho);
                    $("#dialog-form-2 input[name='tonkho']").val(tonkho);
                    $( "#dialog-form-2" ).dialog( "open" );
                } else {
                    $("#masotranh").val(masotranh);
                    $("#makho").val(makho);
                    $("#tonkho").val(tonkho);
                    if(tonkho == '1' || loai == <?php echo TYPE_ITEM_ASSEMBLY; ?>) {
                        //$("#soluong").attr('disabled', 'disabled');
                        $("#soluong").val('1');
                    }
                    else {
                        //$("#soluong").removeAttr('disabled');
                        $("#soluong").val('1');
                    }

                    $(".validateTips").text("Nhập số lượng bán.");
                    // Hien thi dialog
                    $( "#dialog-form" ).dialog( "open" );
                }
            }

            $(function() {
                $("#soluong").numeric();

                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $( "#dialog:ui-dialog" ).dialog( "destroy" );

                var amount = $( "#soluong" ),
                    allFields = $( [] ).add( amount ),
                    tips = $( ".validateTips" );

                function updateTips( t ) {
                    tips
                        .text( t )
                        .addClass( "ui-state-highlight" );
                    setTimeout(function() {
                        tips.removeClass( "ui-state-highlight", 1500 );
                    }, 500 );
                }

                function checkRange( o, n, min, max ) {
                    if ( o.val() - max > 0 || o.val() - min < 0 ) {
                        o.addClass( "ui-state-error" );
                        updateTips( "Giá trị của " + n + " phải nằm trong khoảng [" +
                            min + ", " + max + "]" );
                        return false;
                    } else {
                        return true;
                    }
                }

                $( "#dialog-form" ).dialog({
                    autoOpen: false,
                    height: 250,
                    width: 350,
                    modal: true,
                    buttons: {
                        "Ok": function() {
                            var bValid = true;
                            allFields.removeClass( "ui-state-error" );

                            bValid = bValid && checkRange( amount, "số lượng", 1, $("#tonkho").val() );

                            if ( bValid ) {
                                // Lay cac tham so
                                masotranh = $("#masotranh").val();
                                makho = $("#makho").val();
                                soluong = $("#soluong").val();

                                // Ham ajax
                                $( "#loading" ).show();
                                $.ajax({
                                    url: '../models/addcart.php',
                                    type: 'POST',
                                    data: 'masotranh=' + masotranh + '&makho=' + makho + '&soluong=' + soluong,
                                    success: function (data, textStatus, jqXHR) {
                                        var json = $.parseJSON(data);
                                        if(json.result == 200) {
                                            $("#cart").text(json.count);
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

                $( "#dialog-form-2" ).dialog({
                    autoOpen: false,
                    height: 250,
                    width: 350,
                    modal: true,
                    buttons: {
                        "Ok": function() {
                            bValid = true;
                            if ( bValid ) {
                                masotranh = $("#dialog-form-2 input[name='masotranh']").val();
                                makho = $("#dialog-form-2 input[name='makho']").val();
                                soluong = $("#dialog-form-2 span").html();
                                // Ham ajax
                                $( "#loading" ).show();
                                $.ajax({
                                    url: '../models/addcart.php',
                                    type: 'POST',
                                    data: 'masotranh=' + masotranh + '&makho=' + makho + '&soluong=' + soluong,
                                    success: function (data, textStatus, jqXHR) {
                                        var json = $.parseJSON(data);
                                        if(json.result == 200) {
                                            $("#cart").text(json.count);
                                        }

                                        $( "#loading" ).hide();
                                        $( "#dialog-form-2" ).dialog( "close" );
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

                $('#dialog-form-2 input[name="chieudai"], #dialog-form-2 input[name="chieurong"]').keyup(function(event){
                    var chieudai    = $('#dialog-form-2 input[name="chieudai"]').val();
                    var chieurong   = $('#dialog-form-2  input[name="chieurong"]').val();
                    chieudai = parseFloat(chieudai);
                    chieurong = parseFloat(chieurong);
                    var soluong = 0;
                    soluong = chieudai*chieurong/10000.00;
                    soluong = soluong.toFixed(2);
                    if ( soluong == "NaN" ) {
                        soluong = 0;
                    }
                    $('#dialog-form-2 .validateTips span').html(soluong);
                });
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

                <?php if (verify_access_right(current_account(), array(F_VIEW_SALE, F_VIEW_CART))): ?>
                    <?php include_once '../part/divcart.php'; ?>
                <?php endif; ?>

                <!--<ul class="shortcut-buttons-set">
                    <li><a class="shortcut-button add-event" href="queue.php"><span class="png_bg">
                                Tranh chờ giao
                            </span></a></li>
                    <li><a class="shortcut-button new-page" href="order.php"><span class="png_bg">
                                Đặt tranh
                            </span></a></li>
                </ul>-->
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách sản phẩm có sẵn trong kho</h3>
                    </div>
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <?php
                                require_once '../models/tonkho.php';
                                
                                // Xoa cac mat hang ton kho het so luong
                                $tonkho = new tonkho();
                                $tonkho->xoa_hang_muc_het_so_luong();
                                ?>
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã sản phẩm</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Loại sản phẩm</th>
                                            <th>Giá bán</th>
                                            <th>Thuộc kho hàng</th>
                                            <th>Tồn kho</th>
                                            <th>loai</th>
                                            <?php if (verify_access_right(current_account(), F_VIEW_SALE)): ?>
                                                <th>Số lượng tổng</th>
                                                <th>Thêm</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <br />
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
        <!-- Dialog -->
        <div id="dialog-form" title="Số lượng">
            <p class="validateTips">Nhập số lượng bán.</p>
            <!--<form action="" method="post" onsubmit="return false;"> -->
                <fieldset>
                    <label for="name">Số lượng</label>
                    <input type="hidden" id="masotranh" value="" />
                    <input type="hidden" id="makho" value="" />
                    <input type="hidden" id="tonkho" value="" />
                    <input type="text" name="soluong" id="soluong" class="text ui-widget-content ui-corner-all" maxlength="5" />
                    <img id="loading" alt="loading" src="../resources/images/loading2.gif" />
                </fieldset>
            <!--</form> -->
       </div>

        <!-- Dialog-2 -->
        <div id="dialog-form-2" title="Số lượng (m2)">
            <p class="validateTips">Nhập chiều dài và rộng để tính số lượng theo: <span style="color: blue;"></span> (m2)</p>
            <!--<form action="" method="post" onsubmit="return false;"> -->
            <input type="hidden" name="masotranh" value="" />
            <input type="hidden" name="makho" value="" />
            <input type="hidden" name="tonkho" value="" />
            <fieldset>
                <p>Chiều dài (cm)</p>
                <input type="text"   name="chieudai" class="text ui-widget-content ui-corner-all" maxlength="5" />
                <p>Chiều rộng (cm)</p>
                <input type="text"   name="chieurong" class="text ui-widget-content ui-corner-all" maxlength="5" />
                <img id="loading" alt="loading" src="../resources/images/loading2.gif" />
            </fieldset>
            <!--</form> -->
        </div>


       <div id="bill-dialog" title="Danh sách đơn hàng">
        <div id="dt_example">
            <div id="container">
                <div id="demo">
                	<input type="hidden" id="item" name="item" value="" />
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
                        <thead>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Họ tên khách hàng</th>
                                <th>Số lượng</th>
                                <th>Ngày giao</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
