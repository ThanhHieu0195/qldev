<?php 
    $option_group_category = "<option value=''> [  Tất cả ] </option>";
    $fm = '<option value="%1$s">%2$s</option>';
    foreach ($manhom as $mn) { 
        $option_group_category.=sprintf($fm, $mn['id'], $mn['mota']);
    }
    $fadd_group_category = array('tag' => 'select', "class" => "chosen",'innerHTML', 'id' => 'fadd_group_category', "name" => 'group_category', 'value' => $option_group_category);

    $option_category = "";
    for ($i=0; $i < count( $_list_category ); $i++) { 
        $value = $_list_category[$i];
        $option_category.=sprintf($fm, $value[0], $value[1]);
    }
    $fadd_idcategory = array('tag' => 'select', 'innerHTML', "class" => "chosen", 'id' => 'fadd_idcategory', "name" => "id_category", 'value' => $option_category);
    $fadd_cost = array('tag' => 'input', 'id' => 'fadd_cost', "name" => "cost", "type" => "text");
    
    $label = array('Nhóm hạng mục', 'Hạng mục', 'Giá tiền');
    $fields = array($fadd_group_category, $fadd_idcategory, $fadd_cost);
    $fm = '<tr> <th>%1$s</th> <td>%2$s</td> </tr>';
 ?>
 
 <form id="f_add" class="popup" method="POST" onsubmit="return checkvaluefadd();">
    <table>
        <?php 
        for ($i=0; $i < count($fields); $i++) :
            echo sprintf( $fm, $label[$i], _render_html($fields[$i]) );
        endfor;
         ?>
    </table>
    <row style="text-align: center;">
        <input type="submit" name="add" class="btn_submit" value="Thêm">
        <input type="button" name="exit" class="btn_exit" value="Thoát">
    </row>
</form>
