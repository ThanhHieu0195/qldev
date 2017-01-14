<form id="f_del" class="popup" method="POST">
    <row>
        <label class="title"></label>
        <input type="hidden" name="id" id="id_del">
    </row>
    <row style="text-align: center;">
        <input type="submit" name="del" class="btn_submit" value="Xóa">
        <input type="button" name="exit" class="btn_exit" value="Thoát">
    </row>
</form>

<?php 
    $fadd_name_group = array('tag' => 'input', 'id' => 'fadd_name_group', "name" => "name_group", "type" => "text");
    $fadd_address = array('tag' => 'input', 'id' => 'fadd_address', "name" => "address", "type" => "text");
    $fadd_num_phone = array('tag' => 'input', 'id' => 'fadd_num_phone', "name" => "num_phone", "type" => "text");
    $fadd_id_group = array('tag' => 'input', 'id' => 'fadd_id_group', "name" => "id_group", "type" => "text");
    
    $label = array('Tên đội', 'Địa chỉ', 'Số điện thoại', 'Mã đội');
    $fields = array($fadd_name_group, $fadd_address, $fadd_num_phone, $fadd_id_group);
    $fm = '<tr> <th>%1$s</th> <td>%2$s</td> </tr>';
 ?>
 
 <form id="f_add" class="popup" method="POST">
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