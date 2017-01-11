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
        
        $row_add_row_html = "<div class='approved-hide'><input idadd='$idadd' type='button' onClick=\"addRowHtml('$id_category')\" value='Add' style='padding:3px 8px'/></div>";

        for ($i=0; $i < count($list_detail_material_category); $i++) { 
            $obj = $list_detail_material_category[$i];
            $material_category = $obj['tenvattu'];
            $data_material_category[$id_category][$obj['id']] = $obj['giacao'];
            $row_name_material_category .= "<option value='".$obj['id']."'>".$obj['tenvattu']." </option>";
        }

        $row_name_material_category = "<select class='name_material_category' disabled onchange='autoExpectNumUnit($id_category, %s)'>$row_name_material_category</select>";

        $row_expect_num = "<input class='expect_num' value='%s' type='text' placeholder='0' onkeyup='autoExpectNum($id_category, %s)' %s>";

        $row_auto_expect_money = "<label class='auto_expect_money'> %s </label>";
        $row_auto_expect_money_unit = "<label class='auto_expect_money_unit'> %s </label>";

        $row_add_row = "<div class='approved-hide'><input type='button' onClick=\"addRowMaterial('$id_category', '%s')\" value='Add' style='padding:3px 8px'/></div>";
        $row_remove_row_html = "<div class='approved-hide'><input type='button' onClick=\"row_remove_row_html('$id_category', '%s')\" value='Remove' style='padding:3px 8px'/></div>";
        $row_update_row = "<div class='approved-hide'><input type='button' onClick=\"updateRowMaterial('$id_category', '%s')\" name='update_material_button_".$id_category."_%s' value='Update' style='padding:3px 8px; display: none'/></div>";
        $row_del_row = "<div class='approved-hide'><input type='button' onClick=\"delRow('$id_category', '%s')\" value='Delete' style='padding:3px 8px'/></div>";
        
        $fm = "<tr idrow='%s' class='alt-row'> 
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s %s</td></tr>";
        $data_material_category[$id_category]['fm'] = sprintf($fm, '{0}', sprintf($row_name_material_category, '{0}'), sprintf($row_auto_expect_money_unit, '0'), sprintf($row_expect_num, '0', '{0}', 'readonly'), sprintf($row_auto_expect_money, 0), sprintf($row_add_row, '{0}'), sprintf($row_remove_row_html, '{0}'));

        require_once "../models/chitietvattucongtrinh.php";
        $detail_material_category = new detail_material_category();
        $list_detail_material_category = $detail_material_category->getDetail( array('idcongtrinh' => $id_building, 'idhangmuc' => $id_category), array('idvattu', 'id','soluongdutoan','giadutoan') );
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
                                        <th>Tên vật tư</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng dự toán</th>
                                        <th>Giá dự toán</th>
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
                                            $giacao = $obj['giacao'];

                                            echo sprintf( $fm, $idrow, sprintf($row_name_material_category, $idrow), sprintf($row_auto_expect_money_unit, $giacao), sprintf( $row_expect_num, $obj['soluongdutoan'], $idrow, ''), sprintf( $row_auto_expect_money, number_2_string($obj['giadutoan'],'.')), sprintf($row_update_row, $idrow, $idrow), sprintf($row_del_row, $idrow) );
                                            
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
