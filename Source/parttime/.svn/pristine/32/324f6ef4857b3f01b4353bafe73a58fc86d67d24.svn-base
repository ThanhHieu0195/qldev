<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, '', TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách sự kiện - liên hệ khách hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal !important; }
            .blue-violet { color: blueviolet; font-weight: normal !important; }
            .orange { color: #FF6600; font-weight: normal !important; }
            .bold { font-weight: bolder; }
        </style>
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                <?php 
                $start = (isset ( $_GET ['start'] )) ? $_GET ['start'] : '';
                ?>
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bSort": false,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/guest_development_calendar_detail_server.php?start=<?php echo $start; ?>",
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [4, 5] },
                        { bSortable: false, aTargets: [ 4, 5 ] } // <-- gets these column(s) and turns off sorting
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        if (aData[0] == 'header') {
                            $('td:eq(0)', nRow).html(String.format("<span class='price'>{0}</span>", aData[1])).removeClass('sorting_1').addClass('group');
                            $('td:eq(1)', nRow).html('').removeClass('sorting_1').addClass('group');
                            $('td:eq(2)', nRow).html('').removeClass('sorting_1').addClass('group');
                            $('td:eq(3)', nRow).html('').removeClass('sorting_1').addClass('group');
                            $('td:eq(4)', nRow).html('').removeClass('sorting_1').addClass('group');
                            $('td:eq(5)', nRow).html('').removeClass('sorting_1').addClass('group');
                        } else {
                            $('td:eq(0)', nRow).html(String.format("<a href='javascript:' id='div{0}'>{1}</a>", iDisplayIndex, aData[0]));
                            $('td:eq(1)', nRow).html(aData[1]);
                            $('td:eq(2)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[2]));
                            $('td:eq(3)', nRow).html(aData[3]);
                            if (aData[6] == 0) {
                                $('td:eq(4)', nRow).html("<img title='No' alt='no' src='../resources/images/icons/publish_x.png'>");
                            } else {
                                $('td:eq(4)', nRow).html("<img title='Yes' alt='yes' src='../resources/images/icons/tick.png'>");
                            }
                            $('td:eq(5)', nRow).html(String.format("<a title='Cập nhật thông tin khách hàng' href='../guest_development/edit.php?i={0}'><img src='../resources/images/icons/user-edit-16.png' alt='' /></a>", aData[4])
                                                     + String.format("&nbsp; <a target='_blank' title='Liên hệ khách hàng' href='../guest_development/contact.php?i={0}#history'><img src='../resources/images/icons/contact-16.png' alt='' /></a>", aData[4])
                                                    );
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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách sự kiện - liên hệ khách hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Họ tên khách hàng</th>
                                                    <th>Địa chỉ/Công ty</th>
                                                    <th>Nội dung sự kiện</th>
                                                    <th>Nhân viên phụ trách</th>
                                                    <th>Liên hệ</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div style="padding-bottom: 10px;"></div>
                                    </div>
                                </div>
                            </div>
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