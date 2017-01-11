<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SETTINGS_TASK_CONFIGURE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Trọng số cho điểm</title>
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
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
        </style>
        
        <script type="text/javascript" src="../resources/scripts/utility/task_configuration.js"></script>
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
                    <?php if (verify_access_right(current_account(), F_SETTINGS_ORDER_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_orders" href="../settings/order_configure.php">
                                <span class="png_bg">Thông tin đặt hàng</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_SETTINGS_MAIL_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_mail" href="../settings/mail_configure.php">
                                <span class="png_bg">Thông tin gửi mail</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_SETTINGS_TASK_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_task current" href="../settings/task_configure.php">
                                <span class="png_bg">Trọng số cho điểm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Trọng số cho điểm</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form id="result_item_form" method="post" action="">
                                <?php
                                require_once '../models/task_result_category.php';
                                require_once '../models/task_result_item.php';
                                require_once '../models/task_result_rate.php';
                                
                                unset($manv);
                                
                                if(isset($_POST['submit'])) {
                                    $manv = $_POST['employee'];
                                	$item = $_POST['item'];
                                	$rate = $_POST['rate'];
                                	$model = new task_result_rate();
                                	$entity = new task_result_rate_entity();
                                	$entity->manv = $manv;
                                	$done = TRUE;
                                	
                                	for($i = 0; $i < count($item); $i++) {
                                		$entity->item_id = $item[$i];
                                		$entity->rate = $rate[$i];
                                		if(!$model->insert($entity)) {
                                            if(!$model->update($entity)) {
                                			$done = FALSE;
                                			$message = $model->getMessage();
                                			break;
                                			}
                                		}
                                	}
                                }
                                
                                if(!isset($manv) && isset($_POST['view'])) {
                                    $manv = $_POST['manv'];
                                }
                                ?>
                                <?php if(isset($done) && $done): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Thực hiện thao tác thành công!
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if(isset($done) && ! $done): ?>
                                <div class="notification error png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Lỗi: <?php echo $message; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <div>
                                                <label>Nhân viên:</label>
                                                <select name="manv" id="manv">
                                                    <option value=""></option>
                                                    <?php 
                                                    require_once '../models/nhanvien.php';
                                                    
                                                    $nhanvien = new nhanvien();
                                                    $arr = $nhanvien->employee_list();
                                                    if(is_array($arr)):
                                                        foreach ($arr as $item):
                                                            if($item['manv'] == $manv)
                                                            {
                                                                echo "<option selected value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                                $tmp = $item['manv'];
                                                            }
                                                            else
                                                                echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                                <input class="button" type="submit" id="view" name="view" value="Xem">
                                                <div style="height: 25px"></div>
                                            </div>
                                            <?php if (isset($manv)): ?>
                                            <?php
                                            $nv = new nhanvien();
                                            $tennv = $nv->thong_tin_nhan_vien($manv);
                                            $tennv = (is_array($tennv)) ? $tennv['hoten'] : '';
                                            ?>
                                            <h5><span class="orange"><?php echo $tennv; ?></span></h5>
                                            <input type="hidden" name="employee" value="<?php echo $manv; ?>" />
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
<!--                                                 <thead> -->
<!--                                                     <tr> -->
<!--                                                         <th>STT</th> -->
<!--                                                         <th>Hạng mục</th> -->
<!--                                                         <th>Trọng số</th> -->
<!--                                                     </tr> -->
<!--                                                 </thead> -->
                                                <tbody>
                                                <?php
                                                $category_model = new task_result_category();
                                                $arr = $category_model->get_all();
                                                if($arr != NULL)
                                                {
                                                    $item_model = new task_result_item();
                                                    $rate_model = new task_result_rate();
                                                    foreach ($arr as $c)
                                                    {
                                                        echo "<tr>";
                                                        echo "<td colspan='3' class='group'><span class='blue-text'>{$c->category_name}</span></td>";
                                                        echo "</tr>";
                                                        $rate_list = $rate_model->detail_list($c->category_id, $manv);
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
                                                                echo "<input type='text' name='rate[]' class='numeric' style='width: 50px !important' maxlength='4' value='{$i->rate}' />";
                                                                echo"</td>";
                                                                echo "</tr>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $item_list = $item_model->detail_list($c->category_id);
                                                            $count = 0;
                                                            foreach ($item_list as $i)
                                                            {
                                                                ++$count;
                                                                echo "<tr>";
                                                                echo "<td>{$count}</td>";
                                                                echo "<td>";
                                                                echo "<input type='hidden' name='item[]' value='{$i->item_id}' />";
                                                                echo "{$i->item_name}";
                                                                echo "</td>";
                                                                echo "<td>";
                                                                echo "<input type='text' name='rate[]' class='numeric' style='width: 50px !important' maxlength='4' value='' />";
                                                                echo"</td>";
                                                                echo "</tr>";
                                                            }
                                                        }
                                                	}
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <p>
                                                <input type="submit" class="button" value="Update"
                                                       name="submit" id="submit">
                                                <span id="attention" style="color: red;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                            </p>
                                            <div class="clear"></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>