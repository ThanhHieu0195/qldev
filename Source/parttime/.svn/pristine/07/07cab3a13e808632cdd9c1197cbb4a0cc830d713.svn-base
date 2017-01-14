<?php 
    $fedit_old_idcategory = array('tag'=>'input', 'type' => 'hidden', 'id' => 'fedit_id', 'name' => 'id');

    $fedit_group_category = array('tag' => 'select', "class" => "chosen",'innerHTML', 'id' => 'fedit_group_category', "name" => 'group_category', 'value' => $option_group_category);

    $fedit_idcategory = array('tag' => 'select', 'innerHTML', "class" => "chosen", 'id' => 'fedit_idcategory', "name" => "id_category", 'value' => $option_category);
    $fedit_cost = array('tag' => 'input', 'id' => 'fedit_cost', "name" => "cost", "type" => "text");
    
    $label = array('Nhóm hạng mục', 'Hạng mục', 'Giá tiền');
    $fields = array($fedit_group_category, $fedit_idcategory, $fedit_cost);
    $fm = '<tr> <th>%1$s</th> <td>%2$s</td> </tr>';
 ?>
 
 <form id="f_edit" class="popup" method="POST" onsubmit="return checkvaluefedit();">
    <?php  echo _render_html( $fedit_old_idcategory ); ?>
    <table>
        <?php 
        for ($i=0; $i < count($fields); $i++) :
            echo sprintf( $fm, $label[$i], _render_html($fields[$i]) );
        endfor;
         ?>
    </table>
    <row style="text-align: center;">
        <input type="submit" name="update" class="btn_submit" value="Cập nhật">
        <input type="button" name="exit" class="btn_exit" value="Thoát">
    </row>
</form>