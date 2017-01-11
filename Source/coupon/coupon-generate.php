<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_GENERATE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Generate coupon</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <style type="text/css">
            .ui-state-error { padding: .3em; }
        </style>

        
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/coupon.js"></script>
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
                        <h3>Generate coupon</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <?php
                            require_once '../config/constants.php';
                            require_once '../models/coupon_group.php';
                            require_once '../models/coupon.php';
                            ?>
                            <form method="post" action="" id="coupon_generate">
                                <?php
                                if(isset($_POST['generate']))
                                {
                                    $coupon = new coupon();
                                    $length = $_POST['coupon_length'];
                                    $group_id = $_POST['groupid'];
                                    $amount = $_POST['amount'];
                                    $expire_time = sprintf('%d%s', 
                                            $_POST['coupon_expired'], 
                                            $_POST['expire_type']);
                                    $done = 0;
                                    
                                    for($i = 0, $count = count($group_id); $i < $count; $i++)
                                    {
                                        for($j = 0; $j < $amount[$i]; $j++)
                                        {
                                            if($coupon->add_new($coupon->generate_code($length), $group_id[$i], $expire_time))
                                                $done++;
                                        }
                                    }
                                }
                                ?>
                                <div id="attention" class="notification attention png_bg">
                                    <div>
                                        Vui lòng điền đúng và đầy đủ thông tin cần generate.
                                    </div>
                                </div>
                                <?php if(isset($done)): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Thực hiện generate thành công <b><?php echo $done; ?></b> coupon.
                                    </div>
                                </div>
                                <?php endif; ?>
                                <fieldset>
                                    <p>
                                        <label for="coupon_length">Chiều dài của coupon (*)</label>
                                        <input type="text" name="coupon_length" id="coupon_length" class="text-input small-input" maxlength="50" />
                                        <br /><small>Số ký tự trong mỗi coupon code (tối thiểu: 3; tối đa: 50)</small>
                                    </p>
                                    <p>
                                        <label for="coupon_expired">Thời hạn sử dụng (1, 2, 3, ...) (*)</label>
                                        <input id="coupon_expired" name="coupon_expired"
                                           class="text-input small-input" style="width: 150px !important" 
                                           type="text" />
                                        <label for="expire_type">Đơn vị (ngày/tháng/năm) (*)</label>
                                        <select name="expire_type" id="expire_type">
                                            <option value=""></option>
                                            <option value="d">Ngày</option>
                                            <option value="m">Tháng</option>
                                            <option value="y">Năm</option>
                                        </select>
                                        <br /><small>Hạn sử dụng của mỗi coupon. Ví dụ: 10 ngày, 2 tháng, 1 năm, ...</small>
                                    </p>
                                    <div id="dt_example">
                                        <div id="container">
                                            <div id="demo">
                                                <i>Để đảm bảo tốc độ chương trình, mỗi lần generate chỉ nên generate tối đa khoảng 500-1000 coupon một lúc.</i>
                                                <div style="padding-bottom: 10px;"></div>
                                                <div role="grid" class="dataTables_wrapper" id="example_wrapper">
                                                    <table cellspacing="0" cellpadding="0" border="0" id="example"
                                                        class="display dataTable" aria-describedby="example_info">
                                                        <thead>
                                                            <tr role="row">
                                                                <th class="center sorting" role="columnheader" tabindex="0"
                                                                    aria-controls="example" rowspan="1" colspan="1"
                                                                    style="width: 122px;"
                                                                    aria-label="Action: activate to sort column ascending">Chọn</th>
                                                                <th class="sorting" role="columnheader" tabindex="0"
                                                                    aria-controls="example" rowspan="1" colspan="1"
                                                                    style="width: 159px;" aria-sort="ascending"
                                                                    aria-label="Mã nhóm: activate to sort column descending">Nhóm
                                                                    coupon</th>
                                                                <th class="sorting" role="columnheader" tabindex="0"
                                                                    aria-controls="example" rowspan="1" colspan="1"
                                                                    style="width: 278px;"
                                                                    aria-label="Nội dung: activate to sort column ascending">Nội
                                                                    dung nhóm coupon</th>
                                                                <th class="sorting" role="columnheader" tabindex="0"
                                                                    aria-controls="example" rowspan="1" colspan="1"
                                                                    style="width: 278px;"
                                                                    aria-label="Ghi chú: activate to sort column ascending">Số
                                                                    lượng generate</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                                                        <?php
                                                        $coupon_group = new coupon_group();
                                                        $array = $coupon_group->get_list();
                                                        if(is_array($array)):
                                                            $i = 0;
                                                            foreach ($array as $row):
                                                                $i ++;
                                                        ?>
                                                            <tr class="<?php echo ($i % 2 == 0) ? 'even' : 'odd'; ?>">
                                                                <td class=" center">
                                                                    <input type="checkbox" onclick="return createInput('#groupid<?php echo $i?>');"
                                                                           value="<?php echo $row['group_id']; ?>" name="groupid[]" id="groupid<?php echo $i; ?>" />
                                                                </td>
                                                                <td class=" center"><a><?php echo $row['group_id']; ?></a></td>
                                                                <td class=" "><?php echo $row['content']; ?></td>
                                                                <td class=" " id="container<?php echo $i; ?>" class=""></td>
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
                                        <input type="submit" class="button" value="Generate" name="generate">
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