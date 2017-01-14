<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_TASK, '', TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chi tiết công việc</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder !important; }
            img { vertical-align: middle; }
            #main-content tbody tr.alt-row { background: none; }
            #dt_example span { font-weight: normal !important; }
            form select { -moz-border-radius: 0px; -webkit-border-radius: 0px; border-radius: 0px; }
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
                
                <?php if (verify_access_right(current_account(), F_TASK_LIST_ALL)): ?>
                    <div class="clear"></div>
                    <ul class="shortcut-buttons-set">
                        <li>
                            <a class="shortcut-button on-going" href="ongoing-list.php">
                                <span class="png_bg">Đang thực hiện</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button finished" href="finished-list.php">
                                <span class="png_bg">Chờ đánh giá</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button unevaluated" href="unevaluated-list.php">
                                <span class="png_bg">Chờ cho điểm</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button completed" href="completed-list.php">
                                <span class="png_bg">Xong toàn bộ</span>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
                
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Chi tiết công việc</h3>
                    </div>
                    <div class="content-box-content">
                        <form id="task-detail" action="" method="post">
                            <?php
                            require_once '../models/task.php';
                            require_once '../models/task_detail.php';
                            require_once '../models/task_result.php';
                            
                            // Update data
                            if(isset($_POST['submit'])) {
                                //debug($_POST);
                            
                                $task_model = new task();
                                $item = $task_model->detail($_POST['task_id']);
                                //debug($item);
                                $item->deadline = $_POST['deadline'];
                                // Assign to
                                if (isset($_POST['assign_to']) && $_POST['assign_to'] != "") {
                                    $item->assign_to = $_POST['assign_to'];
                                }
                                // Rank
                                if($_POST['is_check_rank'] == 1) {
                                    $item->rank = $_POST['rank'];
                                    $item->comment = $_POST['comment'];
                                }
                                // Finished
                                if(isset($_POST['is_finished'])) {
                                    $item->is_finished = BIT_TRUE;
                                    $item->finished_date = current_timestamp();
                                }
                                // Checked (Chấm điểm)
                                if($_POST['is_check_result'] == 1) {
                                    $item->checked = BIT_TRUE;
                                }
                                
                                //debug($item);
                                
                                // Update task data
                                $task_model->update($item);
                                $task_model->refresh_status($item->task_id);
                            
                                // Task detail list
                                $detail_model = new task_detail();
                                if(isset($_POST['is_check_checked'])) {
                                    $uid = $_POST['uid'];
                                    foreach ($uid as $id) {
                                        if(isset($_POST['checked_' . $id])) {
                                            $d = new task_detail_entity();
                                            $d->uid = $id;
                                            $d->checked = BIT_TRUE;
                                
                                            $detail_model->update($d);
                                        }
                                    }
                                }
                                
                                // Task result
                                if($_POST['is_check_result'] == 1) {
                                    $result_model = new task_result();
                                	$list = $_POST['item'];
                                	$result = $_POST['result'];
                                	$n = 0;
                                	
                                	for ($i = 0; $i < count($list); $i++) {
                                	    $r = new task_result_entity();
                                	    $r->task_id = $item->task_id;
                                	    $r->item_id = $list[$i];
                                	    $r->result = $result[$i];
                                	    
                                	    if($result_model->insert($r)) { 
                                            $n++;
                                        };
                                	}
                                	
                                	if($n == 0) {
                                        // Update task data
                                        $item->checked = BIT_FALSE;
                                        $task_model->update($item);
                                	}
                                }
                            }
                            
                            // Get data and display
                            $task_id = (isset($_GET['i'])) ? $_GET['i'] : '';
                            $task_model = new task();
                            $task_model->refresh_status();
                            $item = $task_model->detail($task_id);
                            $manv = current_account();
                            
                            $access = TRUE;
                            if($item != NULL) {
                                // Công việc không liên quan đến user hiện tại
                                if(! verify_access_right(current_account(), F_TASK_LIST_ALL) && $item->created_by != $manv && $item->assign_to != $manv) {
                                	$access = FALSE;
                                }
                                // Công việc đã đánh giá/cho điểm
                                //elseif($item->rank != TASK_RANK_NONE || $item->checked == BIT_TRUE) {
                                //    $access = FALSE;
                                //}
                            } else {
                            	$access = FALSE;
                            }
                            ?>
                            <?php if($access): ?>
                            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="15%">
                                            <span class="bold">Tiêu đề</span>
                                        </td>
                                        <td width="85%">
                                            <span class="blue"><?php echo $item->title; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Nội dung</span>
                                        </td>
                                        <td>
                                            <span class="price"><?php echo $item->content; ?></span>
                                        </td>
                                    </tr>
                                    <?php if($item->has_detail ==  BIT_TRUE): ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th width="10%">STT</th>
                                                        <th>Nội dung</th>
                                                        <th width="20%">Đã hoàn thành</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $detail_model = new task_detail();
                                                $arr = $detail_model->detail_list($item->task_id);

                                                if(is_array($arr)) {
                                                    $count = 0;
                                                    foreach ($arr as $d) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="uid[]" value="<?php echo $d->uid; ?>" />
                                                                <?php echo $d->no; ?>
                                                            </td>
                                                            <td><?php echo $d->content; ?></td>
                                                            <td style="text-align: center;">
                                                                <?php if($d->checked == BIT_TRUE) { ?>
                                                                    <img src="../resources/images/icons/tick_circle.png" alt="" />
                                                                    <!-- <input type="hidden" name="checked[]" value="<?php //echo $d->checked; ?>" />  -->
                                                                <?php } else if($item->assign_to == $manv) { $count++; ?>
                                                                    <input type="checkbox" name="checked_<?php echo $d->uid; ?>" />
                                                                <?php } else { ?>
                                                                    <!-- <input type="hidden" name="checked[]" value="<?php //echo $d->checked; ?>" /> -->
                                                                    <input type="checkbox" disabled="true" />
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    <input type="hidden" name="is_check_checked" id="is_check_checked" 
                                                       value="<?php if($item->assign_to == $manv && $count != 0) { echo '1'; } else echo '0'; ?>" />
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <div style="padding: 15px !important"></div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>
                                            <span class="bold">Ngày tạo</span>
                                        </td>
                                        <td>
                                            <span class=""><i><?php echo $item->created_date; ?></i></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Người tạo</span>
                                        </td>
                                        <?php 
                                        $nv = new nhanvien();
                                        $tennv = $nv->thong_tin_nhan_vien($item->created_by);
                                        $tennv = (is_array($tennv)) ? $tennv['hoten'] : '';
                                        ?>
                                        <td>
                                            <span class=""><i><?php echo $tennv; ?></i></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Người thực hiện</span>
                                        </td>
                                        <?php if (verify_access_right(current_account(), F_TASK_DETAIL) && $item->is_finished == BIT_FALSE) {
                                            $tennv = $nv->thong_tin_nhan_vien($item->assign_to);
                                            $tennv = (is_array($tennv)) ? $tennv['hoten'] : '';
                                        ?>
                                        <td>
                                            <select name="assign_to" id="assign_to">
                                                <option value=""></option>
                                                <?php
                                                $nv = new nhanvien();
                                                $arr = $nv->employee_list();
                                                if(is_array($arr)):
                                                    foreach ($arr as $r):
                                                        if ($r['manv'] == $item->assign_to) {
                                                            echo "<option selected value=\"{$r['manv']}\">{$r['hoten']}</option>";
                                                        } else {
                                                            echo "<option value=\"{$r['manv']}\">{$r['hoten']}</option>";
                                                        }
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </td>
                                        <?php } else {
                                            $tennv = $nv->thong_tin_nhan_vien($item->assign_to);
                                            $tennv = (is_array($tennv)) ? $tennv['hoten'] : '';
                                        ?>
                                        <td>
                                            <span class="blue"><?php echo $tennv; ?></span>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">Thời hạn hoàn thành</span>
                                        </td>
                                        <td>
                                            <input type="text" name="deadline" id="deadline" class="text-input small-input" readonly="readonly" value="<?php echo $item->deadline; ?>" />
                                        </td>
                                        <?php if(verify_access_right(current_account(), F_TASK_DETAIL) && $item->is_finished == BIT_FALSE): ?>
                                            <script type="text/javascript" charset="utf-8">
                                            $(function() {
                                                $("#deadline").datepicker({
                                                    minDate: +0,
                                                    changeMonth: true,
                                                    changeYear: true 
                                                    });
                                            });
                                            </script>
                                        <?php endif; ?>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="bold">File đính kèm</span>
                                            
                                        </td>
                                        <?php if ($item->attachment != "") { ?>
                                        <td>
                                            <img alt="attachment" src="../resources/images/icons/attachment_16.png" />
                                            <?php 
                                            $info = new SplFileInfo($item->attachment);
                                            ?>
                                            <a href="<?php echo $item->attachment; ?>" title="attachment"><?php echo $info->getFilename(); ?></a>
                                        </td>
                                        <?php } else { ?>
                                        <td>
                                            <img alt="attachment" src="../resources/images/icons/no_16.png" />
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td><span class="bold">Trạng thái</span></td>
                                        <td>
                                            <?php
                                            $t = '';
                                            $c = '';
                                            switch ($item->status) {
                                            	case TASK_STATUS_NEW: $t = 'Mới'; $c = 'tag belize'; break;
                                            	case TASK_STATUS_EXPIRED: $t = 'Quá hạn'; $c = 'tag pomegranate'; break;
                                            	case TASK_STATUS_FINISHED: $t = 'Hoàn thành đúng hạn'; $c = 'tag turquoise'; break;
                                            	case TASK_STATUS_FINISHED_LATE: $t = 'Hoàn thành quá hạn'; $c = 'tag orange'; break;
                                            }
                                             ?>
                                            <div class="box_content_player"><span class="<?php echo $c; ?>"><?php echo $t; ?></span></div>
                                        </td>
                                    </tr>
                                    <?php if($item->is_finished == BIT_TRUE): ?>
                                    <tr>
                                        <td>
                                            <span class="bold">Ngày thực hiện</span>
                                        </td>
                                        <td>
                                            <span class="blue"><?php echo $item->finished_date; ?></span>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($item->rank != TASK_RANK_NONE) { ?>
                                    <tr>
                                        <td><span class="bold">Xếp hạng</span></td>
                                        <td>
                                            <?php for($i = 0; $i < $item->rank; $i++): ?>
                                            <img src="../resources/images/icons/star_16.png" alt="rank" />
                                            <?php endfor; ?>
                                            <?php
                                            $t = '';
                                            switch ($item->rank) {
                                            	case TASK_RANK_WEAK: $t = 'Yếu'; break;
                                            	case TASK_RANK_AVERAGE: $t = 'Trung bình'; break;
                                            	case TASK_RANK_GOOD: $t = 'Khá'; break;
                                            	case TASK_RANK_VERY_GOOD: $t = 'Tốt'; break;
                                            	case TASK_RANK_EXCELLENT: $t = 'Rất tốt'; break;
                                            }
                                            ?>
                                            &nbsp; <i><?php echo $t; ?></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="bold">Nhận xét</span></td>
                                        <td>
                                            <?php if($item->comment != ""): ?>
                                            <div class="notification information png_bg">
                                                <div><?php echo $item->comment; ?></div>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        <input type="hidden" name="is_check_rank" id="is_check_rank" value="0" />
                                    </tr>
                                    <?php } else if($item->created_by == $manv && $item->is_finished == BIT_TRUE) { ?>
                                    <tr>
                                        <td><span class="bold">Xếp hạng</span></td>
                                        <td>
                                            <select id="rank" name="rank">
                                                <option value="<?php echo TASK_RANK_NONE ; ?>">---</option>
                                                <option value="<?php echo TASK_RANK_WEAK ; ?>">Yếu</option>
                                                <option value="<?php echo TASK_RANK_AVERAGE ; ?>">Trung bình</option>
                                                <option value="<?php echo TASK_RANK_GOOD ; ?>">Khá</option>
                                                <option value="<?php echo TASK_RANK_VERY_GOOD ; ?>">Tốt</option>
                                                <option value="<?php echo TASK_RANK_EXCELLENT ; ?>">Rất tốt</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="bold">Nhận xét</span></td>
                                        <td><textarea id="comment" name="comment" rows="5" cols="10"></textarea><td>
                                        <input type="hidden" name="is_check_rank" id="is_check_rank" value="1" />
                                    </tr>
                                    <?php } else { ?>
                                    <input type="hidden" name="is_check_rank" id="is_check_rank" value="0" />
                                    <?php } ?>
                                    <?php if($item->assign_to == $manv && $item->is_finished == BIT_FALSE): ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="checkbox" name="is_finished" /><span><i></>Check vào đây để đánh dấu thực hiện xong công việc</i></span>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php 
                                    require_once '../models/task_result_category.php';
                                    require_once '../models/task_result_item.php';
                                    require_once '../models/task_result_rate.php';
                                    require_once '../models/task_result.php';
                                    ?>
                                    <?php if(verify_access_right(current_account(), F_TASK_LIST_ALL) 
                                                && $item->is_finished == BIT_TRUE 
                                                && $item->rank != TASK_RANK_NONE
                                                && $item->checked == BIT_FALSE) { ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="is_check_result" id="is_check_result" value="1" />
                                            <span class="bold">Đánh giá</span>
                                        </td>
                                        <td>
                                        <div id="dt_example">
                                            <div id="container">
                                                <div id="demo">
                                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
                                                            <thead>
                                                                 <tr>
                                                                     <th>STT</th>
                                                                     <th>Hạng mục</th>
                                                                     <th>Trọng số</th>
                                                                     <th>Điểm số</th>
                                                                 </tr>
                                                             </thead>
                                                            <tbody>
                                                            <?php
                                                            $category_model = new task_result_category();
                                                            $arr = $category_model->get_all();
                                                            if($arr != NULL)
                                                            {
                                                                $rate_model = new task_result_rate();
                                                                foreach ($arr as $c)
                                                                {
                                                                    echo "<tr>";
                                                                    echo "<td colspan='4' class='group'><span class='blue-text'>{$c->category_name}</span></td>";
                                                                    echo "</tr>";
                                                                    $rate_list = $rate_model->detail_list($c->category_id, $item->assign_to);
                                                                    if ($rate_list != NULL)
                                                                    {
                                                                        $count = 0;
                                                                        foreach ($rate_list as $i)
                                                                        {
                                                                            ++$count;
                                                                            echo "<tr>";
                                                                            echo "<td>{$count}</td>";
                                                                            echo "<td>";
                                                                            echo "<input type='hidden' name='item[]' value='{$i->item_id}' />";
                                                                            echo "{$i->item_name}";
                                                                            echo "</td>";
                                                                            echo "<td>";
                                                                            echo "<span class='orange'>{$i->rate}</span>";
                                                                            echo "</td>";
                                                                            echo "<td>";
                                                                        ?>
                                                                            <select id="result" name="result[]">
                                                                                <option value="<?php echo TASK_RESULT_NA ; ?>" selected="selected">NA</option>
                                                                                <?php for($i = -3; $i <= 3; $i++): ?>
                                                                                <option value="<?php echo $i ; ?>"><?php echo $i; ?></option>
                                                                                <?php endfor; ?>
                                                                            </select>
                                                                        <?php
                                                                            echo "</td>";
                                                                            echo "</tr>";
                                                                        }
                                                                    }
                                                            	}
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } else if ($item->is_finished == BIT_TRUE 
                                                     && $item->rank != TASK_RANK_NONE
                                                     && $item->checked == BIT_TRUE) { ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="is_check_result" id="is_check_result" value="0" />
                                            <span class="bold">Đánh giá</span>
                                        </td>
                                        <td>
                                        <div id="dt_example">
                                            <div id="container">
                                                <div id="demo">
                                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
                                                            <thead>
                                                                 <tr>
                                                                     <th>STT</th>
                                                                     <th>Hạng mục</th>
                                                                     <th>Trọng số</th>
                                                                     <th>Điểm số</th>
                                                                 </tr>
                                                             </thead>
                                                            <tbody>
                                                            <?php
                                                            $total = array('result' => 0, 'rate' => 0);
                                                            
                                                            $category_model = new task_result_category();
                                                            $arr = $category_model->get_all();
                                                            if($arr != NULL)
                                                            {
                                                                $result_model = new task_result();
                                                                foreach ($arr as $c)
                                                                {
                                                                    echo "<tr>";
                                                                    echo "<td colspan='4' class='group'><span class='blue-text'>{$c->category_name}</span></td>";
                                                                    echo "</tr>";
                                                                    $result_list = $result_model->detail_by_task($item->task_id, $c->category_id, $item->assign_to);
                                                                    if ($result_list != NULL)
                                                                    {
                                                                        $count = 0;
                                                                        foreach ($result_list as $i)
                                                                        {
                                                                            ++$count;
                                                                            echo "<tr>";
                                                                            echo "<td>{$count}</td>";
                                                                            echo "<td>";
                                                                            echo "<input type='hidden' name='item[]' value='{$i->item_id}' />";
                                                                            echo "{$i->item_name}";
                                                                            echo "</td>";
                                                                            echo "<td>";
                                                                            echo "<span class='orange'>{$i->rate}</span>";
                                                                            echo "</td>";
                                                                            $r = ($i->result == TASK_RESULT_NA) ? "NA" : $i->result;
                                                                            echo "<td><span class='blue-violet'>{$r}</span></td>";
                                                                            echo "</tr>";
                                                                            
                                                                            if ($i->result != TASK_RESULT_NA) {
                                                                                $total['result'] += $i->rate * $i->result;
                                                                                $total['rate'] += $i->rate;
                                                                            }
                                                                        }
                                                                    }
                                                            	}
                                                            }
                                                            ?>
                                                            <tr><td colspan="4"></td></tr>
                                                            <tr><td colspan="4"></td></tr>
                                                            <tr>
                                                                <td colspan="3" class="group"><span class="blue-text"><i>Tổng điểm</i></span></td>
                                                                <td class="group"><label class="bold"><?php echo $total['result']; ?></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="group"><span class="blue-text"><i>Trung bình</i></span></td>
                                                                <td class="group"><label class="bold"><?php echo round ($total['result']/$total['rate'], 2); ?></label></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php
                                // Check trạng thái active/inactive của button 'Cập nhật'
                                $active = TRUE;
                                
                                // Công việc chưa hoàn thành
                                if ($active) {
                                    if ($item->is_finished == BIT_FALSE
                                    && $item->assign_to != $manv
                                    && $item->created_by == $manv
                                    && (! verify_access_right(current_account(), F_TASK_DETAIL))) {
                                        $active = FALSE;
                                    }
                                }
                                
                                // Công việc đã hoàn thành
                                if ($active) {
                                    if ($item->is_finished == BIT_TRUE
                                            && $item->assign_to == $manv
                                            && $item->created_by != $manv
                                            && (! verify_access_right(current_account(), F_TASK_DETAIL))) {
                                    	$active = FALSE;
                                    }
                                }
                                
                                // Công việc đã xếp hạng
                                if ($active) {
                                    if ($item->rank != TASK_RANK_NONE
                                            && $item->created_by == $manv
                                            && (! verify_access_right(current_account(), F_TASK_DETAIL))) {
                                        $active = FALSE;
                                    }
                                }
                                
                                // Công việc đã chấm điểm
                                if ($active) {
                                    if ($item->checked == BIT_TRUE) {
                                        $active = FALSE;
                                    }
                                }
                                ?>
                                <?php if ($active): ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <div class="bulk-actions align-left">
                                                <input type="submit" class="button" value="Update" name="submit" />
                                                <span id="attention" style="color: red; display: none;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                            </div>
                                            <div class="clear"></div>
                                        </td>
                                    </tr>
                                </tfoot>
                                <?php endif; ?>
                            </table>
                             <?php endif; ?>
                        </form>
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