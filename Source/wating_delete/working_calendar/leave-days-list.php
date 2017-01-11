<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_WORKING_CALENDAR_LEAVE_DAYS, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Lịch nghỉ phép</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            img { vertical-align: middle; }
            .text { padding: .4em; }
            .small-padding { padding: 1px !important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
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
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_LEAVE_DAYS)): ?>
                        <li>
                            <a class="shortcut-button on-going current" href="../working_calendar/leave-days-list.php">
                                <span class="png_bg">Lịch nghỉ phép</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button add" href="../working_calendar/leave-days-add.php">
                                <span class="png_bg">Xin nghỉ thêm</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button switch" href="../working_calendar/leave-days-change.php">
                                <span class="png_bg">Dời ngày nghỉ</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_LEAVE_DAYS_STATISTIC)): ?>
                        <li>
                            <a class="shortcut-button sum" href="../working_calendar/leave-days-statistic.php">
                                <span class="png_bg">Thống kê</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Lịch nghỉ phép (sắp tới)</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php 
                            require_once '../models/working_calendar.php';
                            
                            $model = new working_calendar();
                            $list = $model->leave_days_by_account(current_account());
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                       <th>STT</th>
                                       <th>Ngày</th>
                                       <th>Ghi chú</th>
                                       <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if (is_array($list)):
                                        $count = 0;
                                        foreach ($list as $item):
                                            $count++;
                                    ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td>
                                                    <span class="blue-text bold"><?php echo dbtime_2_systime($item->working_date, 'd-m-Y'); ?></span>
                                                </td>
                                                <td>
                                                    <span class="orange bold"><?php echo $item->note; ?></span>
                                                </td>
                                                <td>
                                                    <!-- Icons 
                                                     <a href="#" title="Edit"><img src="../resources/images/icons/pencil.png" alt="Edit"></a>
                                                     <a href="#" title="Delete"><img src="../resources/images/icons/cross.png" alt="Delete"></a> 
                                                     <a href="#" title="Edit Meta"><img src="../resources/images/icons/hammer_screwdriver.png" alt="Edit Meta"></a>
                                                     -->
                                                </td>
                                            </tr>
                                    <?php 
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            <div class="clear"></div>
                                        </td>
                                    </tr>
                                </tfoot>
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