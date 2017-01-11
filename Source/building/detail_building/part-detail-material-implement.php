 <?php 
    $data_material_category = array();
    foreach ($data_detail as $obj):
        $idrow = 0;
        $id_category = $obj['idhangmuc'];
        $name_category = $obj['tenhangmuc'];
        $idadd = $id_category;
        // lấy option vật tư
        require_once "../models/vattuhangmucthicong.php";
        $material_category = new material_category();
        $list_detail_material_category = $material_category->get_by_id_category($id_category);
        if (count($list_detail_material_category )>0):
        $row_name_material_category = "<option value=''></option>";
        $data_material_category[$id_category] = array("fm"=>"");
        
        $row_add_row_html = "<div class='catalogue-material'><input idadd='$idadd' type='button' onClick=\"addRowHtml('$id_category')\" value='PhatSinh' style='padding:3px 8px'/></div>";

        for ($i=0; $i < count($list_detail_material_category); $i++) { 
            $obj = $list_detail_material_category[$i];
            $material_category = $obj['tenvattu'];
            $data_material_category[$id_category][$obj['id']] = $obj['giacao'];
            $row_name_material_category .= "<option value='".$obj['id']."'>".$obj['tenvattu']." </option>";
        }

        $row_name_material_category = "<select class='name_material_category' disabled>$row_name_material_category</select>";

        //$row_expect_num = "<input class='expect_num' value='%s' type='text' placeholder='0' onkeyup='autoExpectNum($id_category, %s)'>";
        $row_expect_num = "<label class='expect_money'> %s </label>";
        $row_expect_money = "<label> %s </label>";
        $row_real_num = "<input class='real_num' value='%s' type='text' placeholder='0' name='soluongthucte' onkeyup='autoExpectNum($id_category, %s)'>";
        $row_auto_real_money = "<label class='auto_real_money'> %s </label>";
        $row_impl_num = "<label class='row_impl'> %s </label>";
        $row_impl_mon = "<label class='row_impl'> %s </label>";
        $row_price = "<label class='row_impl'> %s </label>";
        $row_status = "<label class='row_impl'> %s </label>";

        $row_add_row = "<div class='approved-hide'><input type='button' onClick=\"addRowMaterial('$id_category', '%s')\" value='Add' style='padding:3px 8px'/></div>";
        $row_remove_row_html = "<div class='approved-hide'><input type='button' onClick=\"row_remove_row_html('$id_category', '%s')\" value='Remove' style='padding:3px 8px'/></div>";
        $row_update_row = "<div class='approved-hide'><input type='button' onClick=\"updateRowMaterial('$id_category', '%s')\" name='update_material_button_".$id_category."_%s' value='Update' style='padding:3px 8px; display: none'/></div>";
        $row_del_row = "<div class='approved-hide'><input type='button' onClick=\"delRow('$id_category', '%s')\" value='Delete' style='padding:3px 8px'/></div>";
        
        $fm = "<tr idrow='%s' class='alt-row'> 
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s %s</td></tr>";
        $data_material_category[$id_category]['fm'] = sprintf($fm, '{0}', $row_name_material_category, sprintf($row_expect_num, '0'), sprintf($row_expect_money, '0'), sprintf($row_real_num, '0', '{0}'), sprintf($row_auto_real_money, '0'), sprintf($row_impl_num, '0'), sprintf($row_impl_mon, '0'), sprintf($row_price, '0'), sprintf($row_status, '0'), sprintf($row_add_row, '{0}'), sprintf($row_remove_row_html, '{0}'));

        require_once "../models/chitietvattucongtrinh.php";
        $detail_material_category = new detail_material_category();
        $list_detail_material_category = $detail_material_category->getDetail( array('idcongtrinh' => $id_building, 'idhangmuc' => $id_category), array('idvattu', 'id','soluongdutoan','giadutoan','soluongthucte','giathucte','soluongphatsinh','giaphatsinh','giamua','trangthai') );
        $list_id_material[$id_category] = array();

     ?>
    <div class="content-box column-left" style="width:100%">
        <div class="content-box-header content-box-header">
            <h3>Chi tiết vật tư hạng mục: <a name="<?php echo $name_category; ?>"><?php echo $name_category; ?></a></h3>
        </div>
        <div class="content-box-content clear">
            <div class="tab-content default-tab">
                <div id="dt_example">
                    <div id="container">
                        <div class="detail-category">
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" idcategory="<?php echo $id_category; ?>">
                                <thead>
                                    <tr> 
                                        <th>Tên </th>
                                        <th>Dự toán</th>
                                        <th>Dự toán(M)</th>
                                        <th>Thực tế</th>
                                        <th>Thực tế(M)</th>
                                        <th>Phát sinh</th>
                                        <th>Phát sinh(M)</th>
                                        <th>Mua</th>
                                        <th>Trạng thái</th>
                                        <th><?php echo $row_add_row_html; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        for ($i=0; $i < count($list_detail_material_category); $i++):
                                            $obj =$list_detail_material_category[$i];
                                            $idrow = $obj['id'];
                                            $id_material = $obj['idvattu'];
                                            $list_id_material[$id_category][] = $id_material;
                                            $status = array('Khởi tạo', 'Chờ mua', 'Chờ giao', 'Đã nhận');

                                            echo sprintf( $fm, $idrow, $row_name_material_category, sprintf( $row_expect_num, $obj['soluongdutoan'], $idrow), sprintf( $row_expect_money, number_2_string($obj['giadutoan'],'.')), sprintf( $row_real_num, $obj['soluongthucte'], $idrow), sprintf( $row_auto_real_money, number_2_string($obj['giathucte'],'.')), sprintf($row_impl_num, number_2_string($obj['soluongphatsinh'],'.')), sprintf($row_impl_mon, number_2_string($obj['giaphatsinh'],'.')), sprintf($row_price, number_2_string($obj['giamua'],'.')), sprintf($row_status, $status[$obj['trangthai']]), sprintf($row_update_row, $idrow, $idrow), sprintf($row_del_row, $idrow) );
                                            
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
                            <div style="padding-bottom: 10px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <?php endif; ?>
     <?php endforeach; ?>
