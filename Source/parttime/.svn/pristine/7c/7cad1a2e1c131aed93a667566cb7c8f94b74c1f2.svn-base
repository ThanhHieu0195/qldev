<div class="information_category">
    <?php 
        echo "<label> Tên công trình: ".$data_building->tencongtrinh."</label>";
        echo "<label> Địa chỉ: ".$data_building->diachi."</label>";
        echo "<label> Tên khách: ".$data_building->hoten."</label>";
        echo "<label> Số điện thoại: ".$data_building->dienthoai1."</label>";
        echo "<label id='cost'> Giá dự toán: ".number_2_string($data_building->giatridutoan)."</label>";
        echo "<label id='cost_real'> Giá trị thực tế: ".number_2_string($data_building->giatrithucte)."</label>";
        echo "<label id='cost_over'> Giá trị phát sinh: ".number_2_string($data_building->giatriphatsinh)."</label>";
        require_once "../models/trangthaicongtrinh.php";
        $status = new status_building();
        $upper = $status->getupper($data_building->trangthai);
     ?>
        <!-- <label id="sts_notifi"><span></span></label> -->
</div>
<div style="padding: 10px 0px;">
     Ngày khởi công dự kiến: <input name="date_start" class="text-input small-input" style="width: 150px !important;background: transparent;" type="text" readonly="readonly" style="background: #f0f0f0" />
     Ngày hoàn thành dự kiến: <input name="date_expect_complete" class="text-input small-input" style="width: 150px !important; background: transparent;" type="text" readonly="readonly" />
     Đổi trạng thái sang: <input id='approved' type='button' onClick="approvedCongTrinh('<?php echo $data_building->id ?>')" value='<?php echo $upper ?>' style='padding:3px 8px'/>
</div>
