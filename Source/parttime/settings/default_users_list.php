<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SETTINGS_DEFAULT_USER, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách default user</title>

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
                    "bServerSide": false,
                    "bPaginate": false,
                    "bSort": true,
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 1 ] },
                        { bSortable: false, aTargets: [ 1, 2] } // <-- gets columns and turns off sorting
                    ]
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
                    <?php if (verify_access_right(current_account(), F_SETTINGS_DEFAULT_USER)) : ?>
                        <li>
                            <a class="shortcut-button employee current" href="../settings/default_users_list.php">
                                <span class="png_bg">Danh sách default user</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button add-freelancer" href="../settings/default_users_add.php">
                                <span class="png_bg">Thêm default user mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->
                    <div class="content-box-header">
                        <h3>Danh sách default user</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Account</th>
                                                    <th>Enable</th>
                                                    <th>Danh sách showroom</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                require_once '../models/default_users.php';
                                                require_once '../models/default_users_stores.php';
                                                
                                                $users_model = new default_users();
                                                $stores_model = new default_users_stores();
                                                $users = $users_model->list_users(TRUE);
                                                foreach ($users as $u):
                                                    $stores = $stores_model->list_stores_by_account($u->account_id, TRUE);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <a title="Chi tiết" href="../settings/default_users_detail.php?i=<?php echo $u->account_id; ?>"><?php echo $u->account_id; ?></a>
                                                        </td>
                                                        <td>
                                                            <?php if ($u->enable): ?>
                                                                <img alt="tick_circle" src="../resources/images/icons/tick_circle.png" />
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            foreach ($stores['store_name'] as $s):
                                                            ?>
                                                                • <?php echo $s; ?><br />
                                                            <?php 
                                                            endforeach;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                                ?>
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