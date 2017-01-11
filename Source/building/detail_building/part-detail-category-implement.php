 <div class="content-box-content">
    <div class="tab-content default-tab">
        <div id="dt_example">
            <div id="container">
                <div class="detail-category">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên hạng mục</th>
                                <th>Nhóm</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Dự toán</th>
                                <th>Dự toán(M)</th>
                                <th>Thực tế</th>
                                <th>Thực tế(M)</th>
                                <th>Phát sinh</th>
                                <th>Phát sinh(M)</th>
                                <th>Giá vốn(M)</th>
                                <th>Status</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            /*----------  danh sach id catogory  ----------*/
                           $list_category_id = array();
                           $i=1; 
                           foreach ($data_detail as $obj):
                                $token = $obj['idhangmuc'];
                                $list_category_id[] = $token;
                                $ngaydefault = $obj['songaythicong'];
                                $name_category = $obj['tenhangmuc'];
                                $name_category2 = $obj['tenhangmuc'] . " (".$ngaydefault." ngay)";
                                $date_start = "<input type='text' class='ngaybatdau' name='ngaybatdau$token' onchange='dateCalculation(\"$token\", \"$ngaydefault\")' value='".$obj['ngaybatdau']."'>";
                                $date_expect_complete = "<input type='text' class='ngaydukienketthuc' name='ngaydukienketthuc$token' onchange='showUpdateButton(\"$token\")' value='".$obj['ngaydukienketthuc']."'>";
                                $khoiluongdutoan = $obj['khoiluongdutoan'];
                                $chiphidutoan = number_2_string($obj['dudoanchiphibandau']);
                                $khoiluongthucte = $obj['khoiluongthucte'];
                                $chiphithucte = $obj['chiphithucte'];
                                $group_category = $obj['nhom'];
                                $khoiluongphatsinh = number_2_string($obj['khoiluongphatsinh']);
                                $chiphiphatsinh = number_2_string($obj['chiphiphatsinh']);
                                $chiphithucte = number_2_string($obj['chiphithucte']);
                                $trangthai= '<input class="button-category" type="button" value="' . $obj['mota'] . '">';
                                $priceunit = $obj['dongiathdutoan'];
                                $giavon = $obj['giavon'];
                                $function = "<input class='button-category approved-hide' type='button' name='button-category".$token."' onclick='updateCategory(\"$token\")' value='Capnhat' style='display: none;'>";
                                //$function .= '<a href="#'.$name_category.'"><input class="button-category" type="button" value="PhatSinh"></a>';
                                $row = "<tr id='row_$token'> <td>$i</th><td>$name_category2</td><td>$group_category</td> <td>$date_start</td> <td>$date_expect_complete</td>";
                                $row .= "<td>$khoiluongdutoan</td> <td>$chiphidutoan</td> <td>$khoiluongthucte</td><td>$chiphithucte</td>";
                                $row .= "<td>$khoiluongphatsinh</td> <td>$chiphiphatsinh</td><td>$giavon</td><td>$trangthai</td><td>$function</td> </tr>";
                                echo $row;
                                $i++;
                            endforeach;
                         ?>
                        </tbody>
                    </table>

                    <div style="padding-bottom: 10px;"></div>
                </div>
                <div class="approved-hide"><input class="button-category" type="button" name="show-form-category" value="Thêm hạng mục"></div>
                <div class="approved-hide"><input class="button-category" type="button" name="hide-form-category" value="Đóng lại" style="display: none;"></div>

            </div>
        </div>
    </div>
</div>