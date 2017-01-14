
<?php 
	$_token = $_GET['token'];
	require_once "../models/ketquacongtac.php";
	$_result_work = new result_work();
	$params = array('kq.id', 'kq.macongviec', 'substr(cv.mota, 1, 50)', 'nv.hoten', 'kq.ngaynopbai', 'kq.giatien', 'kq.trangthai', 'kq.attachment', 'kq.ghichu', 'kq.nhanxet');
	$conditions = array('kq.id' => $_token);
	$otable = "kq 	inner join congvieccongtac cv on cv.id = kq.macongviec 
					inner join nhanvien nv on kq.manv = nv.manv";
	$result = $_result_work->getALL($params, $otable, $conditions, true);

	if ( count( $result ) > 0) {
		$_data = $result[0];
	}
 ?>
<?php 
    $title = "Cập nhật kết quả công việc";
 ?>

<!-- part_work_detail.php -->
 <?php 

	$_account = current_account();
	$_isadmin = is_admin($_account);
	$_ismanager = check_store_manager($_account, ROLE_MANAGER);
	
	$tb_id = array('tag'=>'span', 'innerHTML', 'value'=>$_data[1]);
	$tb_des = array('tag'=>'span', 'innerHTML', 'value'=>$_data[2].'...');
	$tb_name_epl = array('tag'=>'span', 'innerHTML', 'value'=>$_data[3]);
	$tb_date_finish = array('tag'=>'span', 'innerHTML', 'value'=>$_data[4]);
	$tb_cost = array('tag'=>'span', 'innerHTML', 'value'=>$_data[5]);
	/*----------  static  ----------*/

	$_status = array(1 => 'new', 2 => 'reviewing');
	if ($_isadmin) {
		$_status[3] = 'Complete'; 
		$_status[4] = 'Reject'; 
	}

	$status_option = "";
	foreach ($_status as $key => $value) {
		$fm = '<option value="%1$s" %3$s>%2$s</option>';
		if ( $key == $_data[6] ) {
			$status_option .= sprintf($fm, $key, $value, 'selected');
		} else {
			$status_option .= sprintf($fm, $key, $value, '');
		}
	}

	$tb_status = array('tag'=>'select', 'name'=>'status','innerHTML', 'value' => $status_option);
	/*----------  attachment  ----------*/
	
	if ( $_isadmin ) {
		$arr = split('<->', $_data[7]);
		$fm = '<a target="blank" href="%1$s">%2$s</a>';
		for ($i=0; $i < count($arr); $i++) { 
			$arr[$i] = sprintf( $fm, $arr[$i], isset(split('/', $arr[$i])[1])?split('/', $arr[$i])[1]:$arr[$i]  ) ;
		}
		$text = join('</br>', $arr);
		$tb_attachment = array('tag'=>'span', 'name'=>'attachment', 'innerHTML', 'value' => $text);
		$tb_information_attachment = array();
	} else {
		$tb_attachment = array('tag'=>'input', 'name'=>'attachment', 'type' => 'file', 'value' => '');
		$arr = split('<->', $_data[7]);
		$fm = '<a target="blank" href="%1$s">%2$s</a>';
		for ($i=0; $i < count($arr); $i++) { 
			$arr[$i] = sprintf( $fm, $arr[$i], isset(split('/', $arr[$i])[1])?split('/', $arr[$i])[1]:$arr[$i]  ) ;
		}
		$text = join('</br>', $arr);
		$tb_information_attachment = array('tag'=>'span', 'innerHTML', 'value' => $text);
	}

	$ip_o_attachment = array('tag'=>'input', 'name'=>'old_attachment', 'type' => 'hidden', 'value' => $_data[7]);
	$ip_cost = array('tag'=>'input', 'name'=>'cost', 'type' => 'hidden', 'value' => $_data[5]);

	/*----------  label  ----------*/

	$_labels = array('Mã công việc', 'Mô tả', 'Tên nhân viên', 'Ngày nộp bài', 'Giá tiền', 'Trạng thái', 'Attachment');
	
	if ( $_ismanager ) {
		$_labels[] = 'Nhận xét';
		$tb_other =  array('tag'=>'textarea', 'name' => 'comment', 'innerHTML', 'rows' => 5, 'cols' => 50, 'value' => $_data[9]);
	} else {
		$_labels[] = 'Ghi chú';
		$tb_other =  array('tag'=>'textarea', 'name' => 'note', 'innerHTML', 'rows' => 5, 'cols', 'value' => $_data[8]);
	}

	/*----------  submit  ----------*/
	
	$tb_submit = array('tag'=>'input', "class" => "button", 'name' => 'update-result-work','type' => 'submit', 'value' => 'submit');
	if ( $_data[6] == COMPLETED_WORK && !$_isadmin) {
		$tb_submit['disabled'] = ""; 
		$tb_status = array('tag'=>'span', 'innerHTML', 'style'=>'color:red', 'value'=>'Completed');
	} 

	if ( $_data[6] == REJECTED_WORK && !$_isadmin) {
		$tb_submit['disabled'] = ""; 
		$tb_status = array('tag'=>'span', 'innerHTML', 'style'=>'color:red', 'value'=>'Rejected');
	} 

	$_labels[] = 'Chức năng';
	$_fields = array($tb_id, $tb_des, $tb_name_epl, $tb_date_finish, $tb_cost, $tb_status, $tb_attachment, $tb_other, $tb_submit);

 ?>