<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SMS_TEMPLATE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tạo template sms</title>
        <?php require_once '../part/cssjs.php'; ?>
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
                    <li>
                        <a class="shortcut-button add current" href="../sms/smstemplate.php">
                            <span class="png_bg">Thêm sms template</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin câu hỏi</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form id="create_template" action="smstemplate.php" method="post">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="20%">                            
                                                <label for="content">Loại SMS (*)</label>
                                            </td>
                                            <td>
	                    			 <select name="smstype">
						  <option value="Hậu mãi đơn hàng">Hậu mãi đơn hàng</option>
						  <option value="Mời dự triễn lãm">Mời dự triễn lãm</option>
						  <option value="Thông tin khuyến mãi">Thông tin khuyến mãi</option>
                                                  <option value="Hậu mãi đơn hàng có coupon">Hậu mãi đơn hàng có coupon</option>
                                                  <option value="Gửi mã giảm giá cho khách mới" >Gửi mã giảm giá cho khách mới</option>
						</select> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>Nội dung SMS:</label></td>
                                            <td>
                                                <textarea name="smstemplate" class="text-input medium-input" style="width: 95% !important" type="text"> %Tenkhachhang% %Mahoadon% %Macoupon% </textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left"></div>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="clear"></div>
                                <fieldset>
                                    <p>
                                        <input type="submit" name="submit" class="button" value="Tạo sms" name="create_sms" />
                                    </p>
                                </fieldset>
                                <div class="clear"></div>
                            </form>
                            <div style="height: 20px"></div>
                            <table cellpadding="1" cellspacing="1" border="3" class="display" id="example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Loại tin nhắn</th>
                                        <th>Nội dung tin nhắn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                require_once '../models/sms_model.php';
                                require_once '../entities/sms_entity.php';
                                $sms = new sms_model();
                                if (isset($_POST['submit'])) {
                                    $smstype = $_POST['smstype'];
                                    $smstemplate = $_POST['smstemplate'];
                                    $smsentity = new sms_entity();
                                    if ($sms->sms_exist($smstype)) { 
                                        $sms->update($smstype, $smstemplate);
                                    } else {
                                        $smsentity->smstype = $smstype;
                                        $smsentity->smstemplate = $smstemplate;
                                        $sms->insert($smsentity);
                                    } 
                                }
                                $list_sms = $sms->results_list();
                                if(is_array($list_sms)) {
                                    foreach ($list_sms as $message) {
                                    echo '<tr><td>'.$message->id.'</td><td>'.$message->smstype.'</td><td>'.$message->smstemplate.'</td></tr>';
                                    }
                                }
                                ?>
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
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
