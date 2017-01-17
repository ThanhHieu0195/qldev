
<div id="f-randomcategory" style="display: none; width: 50%; padding-left: 25%;" >
 	<form method="post" action="">
 		<table>
 			<tr>
 				<td><label>Nhóm hạng mục</label></td>
                <td>
                    <select name="add_group_category" id="add_group_category">
                            <option>----</option>
                            <?php
                                    for ($i=0; $i < count($manhomhangmuc); $i++):
                                            $groupcata = $manhomhangmuc[$i];
                                            $idgroup = $groupcata['id'];
                                            $namegroup = $groupcata['mota'];
                                            if ( !in_array( $idgroup, $namegroup) ) {
                                                    $fm = "<option value='$idgroup'>$namegroup</option>";
                                                    echo "$fm";
                                            }
                                    endfor;
                             ?>
                    </select>
                </td>
 				<td>
 				<select name="add_id_category" id="add_id_category">
	 				<option value="">----</option>
			 	</select></td>
			 	<td>
                    <a class="button" href="javascript:showProcessCategoryDialog()" name="addcategory">Thêm</a>
			 	</td>
 			</tr>
 		</table>
 	</form>
</div>

<div class="child-randomcategory" id="f-addcategory" style="display: none; width: 50%; padding-left: 25%;" >
    <h3 class="title">Phát sinh hạng mục: <span></span>(thêm)</h3>
    <note></note>
    <form method="post" action="">
        <input type="hidden" name="idhangmuc">
        <input type="hidden" name="khoiluongconviechientai" value="0">
        <table>
            <tr>
                <td>Ngày yêu cầu</td>
                <td><span><?php echo current_timestamp('Y-m-d');?></span></td>
            </tr>
            <tr>
                <td>Khối lượng công việc phát sinh</td>
                <td><input type="text" name="khoiluongcongviecphatsinh" style="text-align: center"></td>
            </tr>
            <tr>
                <td>Nhân viên yêu cầu</td>
                <td><span><?php echo current_account();?></span></td>
            </tr>
            <tr>
                <td>Ghi chú</td>
                <td><textarea name="ghichu" id="" cols="30" rows="10"></textarea></td>
            </tr>
            <tr>
                <td> <input class="button" type="submit" name="addcategory" value="Thêm"></td>
            </tr>
        </table>
    </form>
</div>
