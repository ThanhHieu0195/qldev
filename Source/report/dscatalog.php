<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, F_GUEST_DEVELOPMENT_CATALOG, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Đơn hàng</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <script type="text/javascript">
            function n2s(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            function themkhachvip(objButton) {
                makhach = objButton.value
                $.ajax({
                    url: '../ajaxserver/themkhachvip.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {makhach: makhach},
                })
                .done(function(json) {
                    console.log(json);
                    if (json.result == 1) {
                        $('#khach_'+makhach).html("");
                        alert(json.message);
                    } else {
                        alert(json.message);
                    }
                });
            };
        </script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
    </head><body>
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
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách gửi catalog</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <table type="filter" class="bordered" id="items">
                                <thead>
                                    <tr id="items_head">
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Địa chỉ</th>
                                    <th>ĐT1</th>
                                    <th>ĐT2</th>
                                    <th>ĐT3</th>
                                    <th>Nhóm khách</th>
                                    <th>Nhân viên</th>
                                    <th>Doanh số</th>
                                    <th>Cập nhật</th>
                                    </tr>
                                </thead>
                                <tbody id="items_body">
                                <?php
                                require_once '../models/database.php';

                                $db = new database();
                                $acc = current_account ();
                                if (! verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_CATALOG )) {
                                    $employee_id = current_account ();
                                    $sWhere = " and n.manv='" . $employee_id . "'";
                                };
                                $sql = " 
select k.hoten as hoten, CONCAT_WS(', ', k.diachi, k.quan, k.tp) as diachi, k.dienthoai1 as dt1, k.dienthoai2 as dt2, k.dienthoai3 as dt3, nk.tennhom as nhomkhach, IFNULL(n.hoten,'') as tennv, k.makhach as makhach, IFNULL(kg.makhach,'') as vip, SUM(d.thanhtien) as total
from khach k inner join nhomkhach nk on nk.manhom = k.manhom
left join guest_responsibility g on g.guest_id = k.makhach
LEFT JOIN nhanvien n ON n.manv = g.employee_id
left join donhang d on d.makhach = k.makhach
inner join khachguicatalog kg on kg.makhach = k.makhach
where k.manhom in (42,68,45,23) and k.development<2 $sWhere 
group by makhach
order by total desc;
                                    ";
                                $db->setQuery($sql);
                                $arr = $db->loadAllRow();
                                if(is_array($arr)):
                                    $i=1;
                                    foreach ($arr as $item):
                                    $row = "<tr>";
                                    $row .= "<td>".$i."</td>";
                                    $row .= "<td>".$item['hoten']."</td>";
                                    $row .= "<td>".$item['diachi']."</td>";
                                    if ($item['dt1']) { 
                                        $row .= "<td><button type='button' onclick='f1(this);' value='". $item['dt1'] . "'>" . $item['dt1'] . "</button></td>";
                                    } else {$row .= "<td></td>";}
                                    if ($item['dt2']) {
                                        $row .= "<td><button type='button' onclick='f1(this);' value='". $item['dt2'] . "'>" . $item['dt2'] . "</button></td>";
                                    } else {$row .= "<td></td>";}
                                    if ($item['dt3']) {
                                        $row .= "<td><button type='button' onclick='f1(this);' value='". $item['dt3'] . "'>" . $item['dt3'] . "</button></td>";
                                    } else {$row .= "<td></td>";}
                                    $row .= "<td>".$item['nhomkhach']."</td>";
                                    $row .= "<td>".$item['tennv']."</td>";
                                    $row .= "<td>".$item['total']."</td>";
                                    $row .= "<td><a href='../guest/guestdetail.php?item=".$item['makhach']."' target='_blank'>Cập nhật</a></td>";
                                    $row .= "</tr>";
                                    echo $row;
                                    $i++;
                                    endforeach;
                                endif;
                                ?>
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
