<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_FINANCE, F_INF_TK, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin thu/chi của từng tài khoản</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            .none{
                display: none;
            }
            .lb {
                font-weight: bold;
                padding: 10px 10px 10px 0px;
            }
            .fn {
                padding-top: 10px;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
    
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
         <script type="text/javascript" src="../resources/scripts/utility/orders/cashedTableFilter.js"></script>
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/orderdelivered.js"></script>
        <script type="text/javascript">
            function n2s(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            $(document).ready(function() {
                // tổng thu
                $('#revenue').click(function(event) {
                    /* Act on the event */
                    var tungay = $('#tungay').val();
                    var denngay = $('#denngay').val();

                    if (tungay != "" && denngay !="") {
                        $('#statistic > .from > img').addClass('none'); 
                        $('#statistic > .to > img').addClass('none'); 
                        window.open(String.format('information_tk.php?action=0&type=0&from={0}&to={1}', tungay, denngay));
                    } else {
                        if (tungay == "") {
                            $('#statistic > .from > img').removeClass('none'); 
                        }
                        if (denngay == "") {
                            $('#statistic > .to > img').removeClass('none'); 
                        }
                    }
                });

                $('#expenditure').click(function(event) {
                    /* Act on the event */
                    var tungay = $('#tungay').val();
                    var denngay = $('#denngay').val();

                    if (tungay != "" && denngay !="") {
                        $('#statistic > .from > img').addClass('none'); 
                        $('#statistic > .to > img').addClass('none'); 
                        window.open(String.format('information_tk.php?action=1&type=1&from={0}&to={1}', tungay, denngay));
                    } else {
                        if (tungay == "") {
                            $('#statistic > .from > img').removeClass('none'); 
                        }
                        if (denngay == "") {
                            $('#statistic > .to > img').removeClass('none'); 
                        }
                    }
                });

                // thống kê
                $('#staistic').click(function(event) {
                    var tungay = $('#tungay').val();
                    var denngay = $('#denngay').val();
                    if (tungay != "" && denngay !="") {
                        $.ajax({
                            url: '../ajaxserver/statistic_tk_server.php',
                            type: 'POST',
                            dataType: 'text',
                            data: {action: 'load', from:tungay, to:denngay},
                        })
                        .done(function(result) {
                            $('#statistic > .from > img').addClass('none'); 
                            $('#statistic > .to > img').addClass('none'); 
                            var json =  jQuery.parseJSON(result);
                            if (json.result == 1) {
                                var data = json.statistic;
                                var detail = json.detail_tk;
                                var html = "";
                                var fm = "<tr><td>{0}</td><td>{1}</td><td>{2}</td></tr>";

                                var arr_tk = [];
                                
                                for (var i = 0; i < data.length; i++) {
                                    var obj = data[i];
                                    if (typeof(arr_tk[obj.taikhoan]) === 'undefined') {
                                        arr_tk[obj.taikhoan] = [];
                                    }
                                    arr_tk[obj.taikhoan][obj.loai] = {tong:obj.tong, sl:obj.soluong};
                                }
                                for (var i = 0; i < detail.length; i++) {
                                    var matk = detail[i].taikhoan;
                                    var taikhoan = detail[i].mota;
                                    var tongthu = 0;
                                    var tongchi = 0;
                                    if (arr_tk[matk]) {
                                        if (arr_tk[matk]['0']){
                                            tongthu = n2s(arr_tk[matk]['0'].tong);
                                        } 

                                        if (arr_tk[matk]['1']){
                                            tongchi = n2s(arr_tk[matk]['1'].tong);
                                        } 
                                    }
                                    tongthu = String.format("<a href='information_tk.php?taikhoan={0}&from={1}&to={2}' target='_blank'>{3}</a>", detail[i].taikhoan, tungay, denngay, tongthu);

                                    tongchi = String.format("<a href='information_tk.php?taikhoan={0}&from={1}&to={2}' target='_blank'>{3}</a>", detail[i].taikhoan, tungay, denngay, tongchi);

                                    html += String.format(fm, taikhoan, tongthu, tongchi);
                                }
                                $("#example > tbody").html(html);
                                $('#example').removeClass('none');
                            } else {
                                alert(json.message);
                            }
                        });
                    } else {
                        if (tungay == "") {
                            $('#statistic > .from > img').removeClass('none'); 
                        }
                        if (denngay == "") {
                            $('#statistic > .to > img').removeClass('none'); 
                        }
                    }
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
                        <h3>Thông tin thu/chi của từng tài khoản</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="statistic" action="" method="POST">
                                <div class="from">
                                    <div class="lb">Từ ngày (yyyy-mm-dd):</div>
                                    <input id="tungay" name="tungay"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="<?php echo (isset($_REQUEST['tungay'])) ? $_REQUEST['tungay'] : '' ?>" 
                                           type="text" readonly="readonly" />
                                    <span id="error-1" style="color: red"></span> 
                                    <img class="none" src="../resources/images/icons/cross_circle.png" alt="Lỗi"/>
                                </div>
                                <div class="to">
                                    <div class="lb">Đến ngày (yyyy-mm-dd):</div>
                                    <input id="denngay" name="denngay"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="<?php echo (isset($_REQUEST['denngay'])) ? $_REQUEST['denngay'] : '' ?>"
                                           type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span> 
                                    <img class="none" src="../resources/images/icons/cross_circle.png" alt="Lỗi"/>
                                </div>
                                <div class="fn">
                                    <input class="button" type="button" id="staistic" name="staistic" value="Thống kê" />
                                </div>
                            </form>
                        </div>
                        <div>
                            <table cellpadding="0" cellspacing="0" border="0" class="none" id="example">
                                <thead>
                                    <tr>
                                        <th>Tên tài khoản</th>
                                        <th>Tổng thu</th>
                                        <th>Tổng chi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
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
