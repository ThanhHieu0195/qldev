<?php
require_once "../models/vattuhangmucthicong.php";
require_once "../models/chitietvattucongtrinh.php";
$data_material_category = array();
foreach ($data_detail as $obj):
    $idrow = 0;
    $id_category = $obj['idhangmuc'];
    $name_category = $obj['tenhangmuc'];
    $idadd = $id_category;
    // lấy option vật tư
    $material_category = new material_category();
    $list_detail_material_category = $material_category->get_by_id_category($id_category);
    if (count($list_detail_material_category) > 0):
        $row_name_material_category = "<option value=''></option>";
        $data_material_category[$id_category] = array("fm" => "");
        $trangthaihangmuc = $chitiethangmuccongtrinh->laygiatri(array('idcongtrinh' => $id, 'idhangmuc' => $id_category), array('trangthai') );

        $row_add_row_html = '';
        if ( isset($trangthaihangmuc[0]['trangthai']) && $trangthaihangmuc[0]['trangthai'] <= 4) {
            $row_add_row_html = "<input idadd='$idadd' class='button' type='button' open='1' onClick=\"show_form_add_material('$id_category')\" value='Phát sinh' style='padding:3px 8px'/>";
        }

        for ($i = 0; $i < count($list_detail_material_category); $i++) {
            $obj = $list_detail_material_category[$i];
            $material_category = $obj['tenvattu'];
            $data_material_category[$id_category][$obj['id']] = $obj['giacao'];
            $option_material_category .= "<option value='" . $obj['id'] . "'>" . $obj['tenvattu'] . " </option>";
        }

        $row_name_material_category = "<select class='name_material_category' disabled onchange='autoExpectNumUnit($id_category, %s)'>$option_material_category</select>";
        $row_soluongdutoan = "<label>%s</label>";
        $row_soluongthucte = "<label>%s</label>";
        $row_soluongphatsinh = "<label>%s</label>";
        $row_giadutoan = "<label> %s </label>";
        $row_giaphatsinh = "<label> %s </label>";
        $row_dongiavattu = "<label>%s</label>";
        $row_add_row = "<input type='button' onClick=\"addRowMaterial('$id_category', '%s')\" value='Phát sinh' style='padding:3px 8px'/>";

        $fm = "<tr idrow='%s' class='alt-row'> 
		    <td>%s</td>
		    <td>%s</td>
		    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
		    <td>%s</td>
		    <td>%s %s</td></tr>";
        $data_material_category[$id_category]['fm'] = sprintf($fm, '{0}', sprintf($row_name_material_category, '{0}'), sprintf($row_dongiavattu, '0'), sprintf($row_soluongdutoan, '0'),
            sprintf($row_soluongthucte, '0'), sprintf($row_soluongphatsinh, '0'), sprintf($row_giadutoan, 0), sprintf($row_giaphatsinh, 0), sprintf($row_add_row, '{0}'), sprintf($row_remove_row_html, '{0}'));

        $detail_material_category = new detail_material_category();
        $list_detail_material_category = $detail_material_category->getDetail(array('idcongtrinh' => $id_building, 'idhangmuc' => $id_category), array('idvattu', 'id', 'soluongdutoan', 'soluongthucte', 'soluongphatsinh', 'dongiavattu'));
        $list_id_material[$id_category] = array();
        ?>
        <div class="content-box column-left" style="width:100%">
            <div class="content-box-header content-box-header">
                <h3>Chi tiết vật tư hạng mục: <a name="<?php echo $name_category; ?>"><?php echo $name_category; ?></a>
                </h3>
            </div>
            <div class="content-box-content clear">
                <div class="tab-content default-tab">
                    <div id="dt_example">
                        <div id="container">
                            <div class="detail-category">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example"
                                       idcategory="<?php echo $id_category; ?>">
                                    <thead>
                                    <tr>
                                        <th>Tên vật tư</th>
                                        <th>Đơn giá</th>
                                        <th>SL DT</th>
                                        <th>SL TT</th>
                                        <th>SL PS</th>
                                        <th>Giá TT</th>
                                        <th>Giá PS</th>
                                        <th><?php echo $row_add_row_html; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    for ($i = 0; $i < count($list_detail_material_category); $i++):
                                        $obj = $list_detail_material_category[$i];
                                        $idrow = $obj['id'];
                                        $id_material = $obj['idvattu'];
                                        $list_id_material[$id_category][] = $id_material;
                                        $dongiavattu = number_2_string($obj['dongiavattu']);
                                        $giadutoan = $obj['soluongthucte'] * $obj['dongiavattu'];
                                        $giaphatsinh = $obj['soluongphatsinh'] * $obj['dongiavattu'];

                                        echo sprintf($fm, $idrow, sprintf($row_name_material_category, $idrow), sprintf($row_dongiavattu, $dongiavattu), sprintf($row_soluongdutoan, $obj['soluongdutoan']),
                                            sprintf($row_soluongthucte, $obj['soluongthucte']), sprintf($row_soluongphatsinh, $obj['soluongphatsinh']), sprintf($row_giadutoan, number_2_string($giadutoan, '.')),
                                            sprintf($row_giaphatsinh, number_2_string($giaphatsinh, '.')), sprintf($row_update_row, $idrow, $idrow), sprintf($row_del_row, $idrow));

                                        $script = " <script type=\"text/javascript\">
							      $(document).ready(function() {
								  $(\"table[idcategory='$id_category'] tr[idrow='$idrow'] select option[value='$id_material']\").attr('selected', 'selected');
							      });
							  </script>";
                                        echo $script;
                                    endfor;
                                    ?>
                                    </tbody>


                                </table>
                                <form action="" status="0" method="post" name="themvattu_<?php echo $id_category; ?>" style="display: none;width: 500px;
                                                                                                                            left: 25%;
                                                                                                                            position: relative;
                                                                                                                            margin: 20px 0px;">
                                    <input type="hidden" name="idhangmuc" value="<?php echo $id_category;?>">
                                    <h3 style="    text-align: center; color:blue;">Phát sinh vật tư</h3>
                                    <table>
                                        <tr>
                                            <td>Ngày yêu cầu</td>
                                            <td><span><?php echo current_timestamp() ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>Chọn vật tư</td>
                                            <td>
                                                <select name="vattu">
                                                    <?php echo $option_material_category; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nhân viên yêu cầu</td>
                                            <td><span><?php echo current_account(); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>Số lượng phát sinh</td>
                                            <td><input type="number" name="soluongphatsinh"></td>
                                        </tr>
                                        <tr>
                                            <td>Ghi chú</td>
                                            <td><textarea name="ghichu" cols="30" rows="10"></textarea></td>
                                        </tr>
                                    </table>
                                    <input type="submit" name="themvattu" class="button" onclick="return confirm('Vật tư sẽ được thêm?');" value="Xác nhận" style="margin: 10px 0px;">
                                </form>
                                <div style="padding-bottom: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
