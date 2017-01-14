 <form id="f_add" class="popup" method="POST">
    <table>
       <tr>
            <th>Tên đội</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>hạng mục</th>
            <th>Mã đội</th>
            <th>Đơn giá</th>
        </tr>
        <tr>
            <td><input id="fadd_name_group" name="name_group" type="text"></td>
            <td><input id="fadd_address" name="address" type="text"></td>
            <td><input id="fadd_num_phone" name="num_phone" type="text"></td>
            <td>
                <select id="fadd_id_category" name="id_category">
                    <option value=""></option>
                    <?php 
                        for ($i=0; $i < count($list_category_building); $i++) { 
                            $obj = $list_category_building[$i];
                            $id = $obj['id'];
                            $name = $obj['tenhangmuc'];
                            $echo = "<option value='$id'>$name</option>";
                            echo $echo;
                        }
                     ?>
                </select>
            </td>
            <td><input id="fadd_id_group" name="id_group" type="text"></td>
            <td><input id="fadd_cost" name="cost" type="text"></td>
        </tr>
    </table>
    <row style="text-align: center;">
        <input type="submit" name="add" class="btn_submit" value="Thêm">
        <input type="button" name="exit" class="btn_exit" value="Thoát">
    </row>
</form>