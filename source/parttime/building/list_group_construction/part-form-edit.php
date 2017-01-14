
<?php 
    $fedit_name_group = array('tag' => 'input', 'id' => 'fedit_name_group', "name" => "name_group", "type" => "text");
    $fedit_address = array('tag' => 'input', 'id' => 'fedit_address', "name" => "address", "type" => "text");
    $fedit_num_phone = array('tag' => 'input', 'id' => 'fedit_num_phone', "name" => "num_phone", "type" => "text");
    $fedit_id_group = array('tag' => 'input', 'id' => 'fedit_id_group', "name" => "id_group", "type" => "text");
    $fedit_title = array('tag' => 'span', 'id' => 'fedit_title', "name" => "fedit_title", 'innerHTML');
    
    $fedit_id = array('tag' => 'input', 'id' => 'fedit_id', "name" => "id", "type" => "hidden");

    $label = array('Mã', 'Tên đội', 'Địa chỉ', 'Số điện thoại', 'Mã đội');
    $fields = array($fedit_title, $fedit_name_group, $fedit_address, $fedit_num_phone, $fedit_id_group);
    $fm = '<tr> <th>%1$s</th> <td>%2$s</td> </tr>';
 ?>

 <form id="f_edit" class="popup" method="POST">
    <?php echo _render_html( $fedit_id ); ?>
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