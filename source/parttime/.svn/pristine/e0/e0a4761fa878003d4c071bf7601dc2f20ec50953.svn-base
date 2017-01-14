<?php
require_once '../part/common_start_page.php';

// Get input data
$type = (isset($_GET['type'])) ? $_GET['type'] : 'employee';
if($type != 'freelancer') {
    $type = 'employee';
}

// Authenticate
if ($type == 'employee') { // Employee
    do_authenticate(G_EMPLOYEES, F_EMPLOYEES_EMPLOYEE_LIST, TRUE);
} else { // Freelancer
    do_authenticate(G_EMPLOYEES, F_EMPLOYEES_FREELANCER_LIST, TRUE);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php if($type == 'employee'): ?>
            <title>Danh sách nhân viên</title>
        <?php else: ?>
            <title>Danh sách cộng tác viên</title>
        <?php endif; ?>

        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var i = 0;
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": false,
                    "sAjaxSource": "../ajaxserver/employee_list_server.php?type=<?php echo $type; ?>",
                    "bSort": true,
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5 ] },
                        { bSortable: false, aTargets: [ 2, 3, 4, 5] } // <-- gets columns and turns off sorting
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                            if (eval(aData[5]) == 1) {
                                $('td:eq(0)', nRow).html("<img src='../resources/images/icons/user-male-add.png' alt='enable' title='Tài khoản đang enable' /> <a href='employeedetail.php?item=" + aData[0] + "&type=<?php echo $type; ?>" + "&uid=" + aData[6] + "' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>");
                            } else {
                                $('td:eq(0)', nRow).html("<img src='../resources/images/icons/user-male-delete.png' alt='disable' title='Tài khoản đang disable' /> <a href='employeedetail.php?item=" + aData[0] + "&type=<?php echo $type; ?>" + "&uid=" + aData[6] + "' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>");
                            }
                            $('td:eq(1)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[1] + "</label>");
                            $('td:eq(2)', nRow).html(aData[2]);
                            $('td:eq(3)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[3] + "</label>");
                            
                            <?php if($type == 'employee'): ?>
                                $('td:eq(4)', nRow).html(aData[4]);
                                if (eval(aData[5]) == 0) {
                                    $('td:eq(5)', nRow).html(String.format("<a href=delemployee.php?item={0}&type={1}&enable={2} title='Enable tài khoản này'><img src='../resources/images/icons/user-male-add.png' alt='enable' /></a>", 
                                                                        aData[0], '<?php echo $type; ?>', 1));
                                } else {
                                    $('td:eq(5)', nRow).html(String.format("<a href=delemployee.php?item={0}&type={1}&enable={2} title='Disable tài khoản này'><img src='../resources/images/icons/user-male-delete.png' alt='disable' /></a>", 
                                                                        aData[0], '<?php echo $type; ?>', 0));
                                }
                            <?php else: ?>
                                $('td:eq(4)', nRow).html(aData[4]);
                                if (eval(aData[5]) == 0) {
                                    $('td:eq(5)', nRow).html(String.format("<a title='Assign coupon mới' href='../coupon/coupon-assign-freelancer.php?assign_to={0}'><img alt='Assign' src='../resources/images/icons/add.png'></a> ", aData[0]) + 
                                                             String.format("<a href=delemployee.php?item={0}&type={1}&enable={2} title='Enable tài khoản này'><img src='../resources/images/icons/user-male-add.png' alt='enable' /></a>", 
                                                                            aData[0], '<?php echo $type; ?>', 1));
                                } else {
                                    $('td:eq(5)', nRow).html(String.format("<a title='Assign coupon mới' href='../coupon/coupon-assign-freelancer.php?assign_to={0}'><img alt='Assign' src='../resources/images/icons/add.png'></a> ", aData[0]) + 
                                                             String.format("<a href=delemployee.php?item={0}&type={1}&enable={2} title='Disable tài khoản này'><img src='../resources/images/icons/user-male-delete.png' alt='disable' /></a>", 
                                                                            aData[0], '<?php echo $type; ?>', 0));
                                }
                            <?php endif; ?>
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
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_EMPLOYEE_LIST)) : ?>
                        <li>
                            <a class="shortcut-button employee <?php echo ($type == 'employee') ? "current" : "" ?>" href="employee.php?type=employee">
                                <span class="png_bg">Danh sách nhân viên</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_FREELANCER_LIST)) : ?>
                        <li>
                            <a class="shortcut-button freelancer <?php echo ($type == 'freelancer') ? "current" : "" ?>" href="employee.php?type=freelancer">
                                <span class="png_bg">Danh sách cộng tác viên</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_ADD_EMPLOYEE)) : ?>
                        <li>
                            <a class="shortcut-button add-employee" href="addemployee.php">
                                <span class="png_bg">Thêm nhân viên mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_ADD_FREELANCER)) : ?>
                        <li>
                            <a class="shortcut-button add-freelancer" href="addemployee.php?t=freelancer">
                                <span class="png_bg">Thêm cộng tác viên</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->
                    <div class="content-box-header">
                        <?php if($type == 'employee'): ?>
                            <h3>Danh sách nhân viên</h3>
                        <?php else: ?>
                            <h3>Danh sách cộng tác viên</h3>
                        <?php endif; ?>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <?php if($type == 'employee'): ?>
                                                        <th>Mã nhân viên</th>
                                                    <?php else: ?>
                                                        <th>Mã cộng tác viên</th>
                                                    <?php endif; ?>
                                                    
                                                    <th>Họ tên</th>
                                                    <th>Điện thoại</th>
                                                    <th>Chi nhánh</th>
                                                    
                                                    <?php if($type == 'employee'): ?>
                                                        <th>Địa chỉ</th>
                                                    <?php else: ?>
                                                        <th>Coupon</th>
                                                    <?php endif; ?>
                                                    
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