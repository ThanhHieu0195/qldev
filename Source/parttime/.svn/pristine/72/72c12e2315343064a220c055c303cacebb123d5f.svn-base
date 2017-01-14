<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_ASSIGN_GROUP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Assign coupon theo nhóm khách</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <style type="text/css">
            form select { padding: 3px; }
        </style>
        
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Assign coupon theo nhóm khách</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <?php
                            require_once '../config/constants.php';
                            require_once '../models/coupon_group.php';
                            require_once '../models/coupon.php';
                            require_once '../models/nhomkhach.php';                            
                            ?>
                            <form method="post" action="" id="coupon_generate">
                                <?php
                                if(isset($_POST['assign']))
                                {
                                    $nhomkhach = $_POST['nhomkhach'];
                                    $group_id = $_POST['group_id'];
                                    $coupon = new coupon();
                                    $done = 0;
                                    
                                    // debug($nhomkhach);
                                    // debug($group_id);
                                    
                                    for($i=0, $count=count($nhomkhach); $i<$count; $i++)
                                    {
                                        if(isset($group_id[$i]) && $group_id[$i] != '')
                                        {
                                            // echo 'Nhomkhach=' . $nhomkhach[$i] . '; ' . $group_id[$i] . '<br />';
                                            $done +=  $coupon->assign_guest_group($nhomkhach[$i], $group_id[$i]);
                                        }
                                    }
                                }
                                ?>
                                <div id="attention" class="notification attention png_bg">
				                    <div>
					                    Vui lòng chọn đầy đủ thông tin cần assign. Đối với các nhóm khách không muốn assign thì chỉ cần không chọn nhóm coupon.
					                    <br /><b><i>Lưu ý:</i></b> các nhóm coupon có số lượng coupon có sẵn ít hơn số khách trong một nhóm khách sẽ không xuất hiện trong danh sách
					                    nhóm coupon tương ứng của nhóm khách đó.
				                    </div>
			                    </div>
			                    <?php if(isset($done)): ?>
                                <div class="notification success png_bg">
				                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
				                    <div>
					                    Thực hiện assign thành công <b><?php echo $done; ?></b> coupon.
				                    </div>
			                    </div>
			                    <?php endif; ?>
                                <fieldset>
                                    <div id="dt_example">
                                    	<div id="container">
                                    		<div id="demo">
                                    			<div role="grid" class="dataTables_wrapper" id="example_wrapper">
                                    				<table cellspacing="0" cellpadding="0" border="0" id="example"
                                    					class="display dataTable" aria-describedby="example_info">
                                    					<thead>
                                    						<tr role="row">
                                    						    <th class="center sorting" role="columnheader" tabindex="0"
                                    								aria-controls="example" rowspan="1" colspan="1"
                                    								style="width: 122px;"
                                    								aria-label="Action: activate to sort column ascending">STT</th>
                                    							<th class="sorting" role="columnheader" tabindex="0"
                                    								aria-controls="example" rowspan="1" colspan="1"
                                    								style="width: 159px;" aria-sort="ascending"
                                    								aria-label="Mã nhóm: activate to sort column descending">Nhóm
                                    								khách</th>
                                    							<th class="sorting" role="columnheader" tabindex="0"
                                    								aria-controls="example" rowspan="1" colspan="1"
                                    								style="width: 278px;"
                                    								aria-label="Nội dung: activate to sort column ascending">Số lượng khách</th>
                                    							<th class="sorting" role="columnheader" tabindex="0"
                                    								aria-controls="example" rowspan="1" colspan="1"
                                    								style="width: 278px;"
                                    								aria-label="Ghi chú: activate to sort column ascending">Nhóm coupon</th>
                                    						</tr>
                                    					</thead>
                                    					<tbody role="alert" aria-live="polite" aria-relevant="all">
                                    					<?php
                                    					$nhom_khach = new nhomkhach();
                                    					$array = $nhom_khach->danh_sach_tong_hop();
                                    					
                                    					if(is_array($array)):
                                    					    $coupon_group = new coupon_group();
                                    					    $list = $coupon_group->general_list();
                                    					    $i = 0;
                                    					    foreach ($array as $row):
                                    					        $i ++;
                                    					?>
                                    						<tr class="<?php echo ($i % 2 == 0) ? 'even' : 'odd'; ?>">
                                    						    <td class=" center">
                                    						        <?php echo $i; ?>
                                    						        <input type="hidden" value="<?php echo $row['manhom']; ?>" name="nhomkhach[]" />
                                    						    </td>
                                    							<td class=" "><a><?php echo $row['tennhom']; ?></a></td>
                                    							<td class=" "><?php echo $row['soluong']; ?></td>
                                    							<td class=" ">
                                    							    <select name="group_id[]">
                                    							        <option value=""></option>
                                        							    <?php
                                        							    foreach ($list as $item)
                                        							    {
                                        							        if($item['amount'] >= $row['soluong'])
                                        							        {
                                        							            echo sprintf('<option value="%s">%s (%d coupon)</option>', $item['group_id'], $item['content'], $item['amount']);
                                        							        }
                                        							    }
                                        							    ?>
                                    							    </select>
                                    							</td>
                                    						</tr>
                                    					<?php
                                    					    endforeach;    
                                                        endif; 
                                                        ?>
                                    					</tbody>
                                    				</table>
                                    			</div>
                                    			<div style="padding-bottom: 10px;"></div>
                                    		</div>
                                    	</div>
                                    </div>
                                    <p>
                                        <input type="submit" class="button" value="Assign" name="assign">
                                    </p>
                                </fieldset>
                                <div class="clear"></div>
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