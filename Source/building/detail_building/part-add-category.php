
<div id="f-addcategory" style="display: none; width: 50%; padding-left: 25%;" >
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
                                </select></td>
 				<td>
 				<select name="add_id_category" id="add_id_category">
	 				<option>----</option>
			 	</select></td>
			 	<td>
					<input type="submit" name="addcategory" value="Thêm">
			 	</td>
 			</tr>
 		</table>
 	</form>
</div>
