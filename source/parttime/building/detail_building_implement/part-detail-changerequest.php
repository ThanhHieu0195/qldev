<?php
require_once "../models/duyetphatsinh.php";
$duyetphatsinh = new duyetphatsinh();

$data = $duyetphatsinh->phatsinhdaduyet($id);
?>
 <div class="content-box-content">
    <div class="tab-content default-tab">
        <div id="dt_example">
            <div id="container">
                <div class="detail-changerequest">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Hạng mục</th>
                                <th>Vật tư</th>
                                <th>Ngày yêu cầu</th>
                                <th>Lượng ban đầu</th>
                                <th>Lượng thay đổi</th>
                                <th>Người yêu cầu</th>
                                <th>Người duyệt</th>
                                <th>Trạng thái</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $format = '<tr> <td>%1$s</td> <td>%2$s</td> <td>%3$s</td> <td>%4$s</td>
                                        <td>%5$s</td> <td>%6$s</td> <td>%7$s</td> <td>%8$s</td> <td>%9$s</td> <td>%10$s</td> </tr>';
                        foreach ($data as $index => $arr) {
                            echo sprintf($format, $index+1, $arr['tenhangmuc'], $arr['tenvattu'], $arr['ngayyeucau'],
                                $arr['khoiluongbandau'], $arr['khoiluongthaydoi'], $arr['nhanvienyeucau'], $arr['nhanvienduyet'], $arr['trangthai']==0?'Chờ duyệt':'Đã duyệt', $arr['ghichu']);
                        }
                        ?>
                        </tbody>
                    </table>

                    <div style="padding-bottom: 10px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
