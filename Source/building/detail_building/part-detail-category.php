 <div class="content-box-content">
    <div class="tab-content default-tab">
        <div id="dt_example">
            <div id="container">
                <div class="detail-category">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th class="index">STT</th>
                                <th>Tên hạng mục</th>
                                <th>Nhóm</th>
                                <th class="date">Ngày bắt đầu</th>
                                <th class="date">Ngày kết thúc</th>
                                <th class="num">Khối lượng</th>
                                <th class="num">Đơn giá</th>
                                <th class="num">Dự toán</th>
                                <th class="text">Ghi chú</th>
                                <th class="num">Chức năng</th>
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
                                $ngaydukienbatdau = "<input type='text' class='ngaypicker' name='ngaydukienbatdau$token' onchange='dateCalculation(\"$token\", \"$songaythicong\", \"ngaydukienbatdau\", \"ngaydukienketthuc\")' value='".$obj['ngaydukienbatdau']."'>";
                                $ngaydukienketthuc = "<input type='text' class='ngaypicker' name='ngaydukienketthuc$token' onchange='showUpdateButton(\"$token\")' value='".$obj['ngaydukienketthuc']."'>";
                                $auto_money = $obj['khoiluongdutoan']*$obj['dongiathdutoan']; 
                                $khoiluongdutoan = "<input type='text' value='".$obj['khoiluongdutoan']."' name='khoiluongdutoan".$token."' placeholder='0' dongia='".$obj['dongiathdutoan']
                                                   ."' onkeyup='calautoExpectMoney(\"".$token."\",\"khoiluongdutoan\", \"dudoanchiphibandau\" )'>";
                                $dudoanchiphibandau = "<input type='text' name='dudoanchiphibandau".$token."' onkeyup='formatExpectMoney(\"$token\")' value='".number_2_string($auto_money)."'>";
                                $ghichu = "<input type='text' class='ghichu' name='ghichu$token' onkeyup='showUpdateButton(\"$token\")' value='".$obj['ghichu']."'>";
                                $dongiathdutoan = number_2_string($obj['dongiathdutoan']);
                                $group_category = $obj['nhom'];
                                $function = "<div class='approved-hide'><input class='button-category approved-hide' type='button' name='button-category".$token."' onclick='updateCategory(\"$token\")' value='Update' style='display: none;'></div>";
                                $function .= "<input class='button-category' type='button' value='Delete' onclick='deleteCategory(\"$token\")'>";
                                $row = "<tr id='row_$token'> <td class='index'>$i</td>
                                        <td>$tenhangmuc2</td><td>$group_category</td>
                                        <td>$ngaydukienbatdau</td> <td>$ngaydukienketthuc</td>
                                        <td>$khoiluongdutoan</td> <td>$dongiathdutoan</td>
                                        <td>$dudoanchiphibandau</td> <td>$ghichu</td><td>$function</td> </tr>";
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
