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
                                <th>DK bắt đầu</th>
                                <th>DK kết thúc</th>
                                <th>Bắt đầu</th>
                                <th>Kết thúc</th>
                                <th>KL DT</th>
                                <th>KL TT</th>
                                <th>KL PS</th>
                                <th>Đơn giá</th>
                                <th>Thực tế</th>
                                <th>Phát sinh</th>
                                <th>Ghi chú</th>
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
                                $songaythicong = $obj['songaythicong'];
                                $tenhangmuc = $obj['tenhangmuc'];
                                $tenhangmuc2 = '<a href="#'.$tenhangmuc.'">' . $obj['tenhangmuc'] . " (".$songaythicong." ngay)" . '</a>' ; 
                                $ngaydukienbatdau = "<label>" . $obj['ngaydukienbatdau'] . "</label>";
                                $ngaydukienketthuc = "<label>" . $obj['ngaydukienketthuc'] . "</label>";
                                $ngaybatdau = "<input type='text' class='ngaypicker' name='ngaybatdau$token' onchange='dateCalculation(\"$token\", \"$songaythicong\", \"ngaybatdau\", \"ngayketthuc\")' value='".$obj['ngaybatdau']."'>";
                                $ngayketthuc = "<input type='text' class='ngaypicker' name='ngayketthuc$token' onchange='showUpdateButton(\"$token\")' value='".$obj['ngayketthuc']."'>";
                                $thucte = number_2_string($obj['khoiluongthucte']*$obj['dongiathdutoan']); 
                                $phatsinh = number_2_string($obj['khoiluongphatsinh']*$obj['dongiathdutoan']);
                                $khoiluongdutoan = "<label>" . $obj['khoiluongdutoan'] . "</label>"; 
                                $khoiluongthucte = "<label>" . $obj['khoiluongthucte'] . "</label>";
                                $khoiluongphatsinh = "<label>" . $obj['khoiluongphatsinh'] . "</label>";
                                $dudoanchiphibandau = "<label>". $thucte ."</label>";
                                $dudoanchiphiphatsinh = "<label>". $phatsinh ."</label>";
                                $ghichu = "<label>".$obj['ghichu']."</label>";
                                $dongiathdutoan = number_2_string($obj['dongiathdutoan']);
                                $group_category = $obj['nhom'];
                                $function = "<div class='approved-hide'><input class='button-category approved-hide' type='button' name='button-category".$token."' onclick='updateCategory(\"$token\")' value='Update' style='display: none;'></div>";
                                for ($j=0;$j<count($trangthaiall);$j++){
                                    if ($trangthaiall[$j][0]==$obj['trangthai']) {
                                        $function .= '<input class="button-category" type="button" value="'.$trangthaiall[$j+1][1].'"></a>';
                                        break;
                                    }
                                }
                                $row = "<tr id='row_$token'> <td class='index'>$i</td>
                                        <td>$tenhangmuc2</td><td>$group_category</td>
                                        <td>$ngaydukienbatdau</td> <td>$ngaydukienketthuc</td> <td>$ngaybatdau</td> <td>$ngayketthuc</td> 
                                        <td>$khoiluongdutoan</td> <td>$khoiluongthucte</td> <td>$khoiluongphatsinh</td><td>$dongiathdutoan</td>
                                        <td>$dudoanchiphibandau</td><td>$dudoanchiphiphatsinh</td> <td>$ghichu</td><td>$function</td> </tr>";
                                echo $row;
                                $i++;
                            endforeach;
                         ?>
                        </tbody>
                    </table>
                    <div style="padding-bottom: 10px;"></div>
                </div>
                <div class="approved-hide"><input class="button-category" type="button" name="show-form-category" value="Phát sinh hạng mục"></div>
                <div class="approved-hide"><input class="button-category" type="button" name="hide-form-category" value="Đóng lại" style="display: none;"></div>

            </div>
        </div>
    </div>
</div>
