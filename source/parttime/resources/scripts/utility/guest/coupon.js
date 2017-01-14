$('#group_couppon').change(function(event) {
	/* Act on the event */
	var value_group_coupon = $('#group_couppon').val();
	var html = "<option value=''>----</option>";
	var fm = "<option value='{0}'>{0}</option>"
	if (value_group_coupon == "") {
		$('#id_coupon').html(html);
	} else {
		var path = "../ajaxserver/coupon_guest.php?getcoupon&group_id=" + value_group_coupon;
		$.get(path, function(data) {

			json_coupon = jQuery.parseJSON(data);
			if (json_coupon.result == 1) {
				var adata = json_coupon.data;
				for (var i = 0; i < adata.length; i++) {

					var obj = adata[i];
					html += String.format(fm, obj.coupon_code);
				}
			}
			$('#id_coupon').html(html);
		});
	}

	changesmstemplate();

});

function reset_form_coupon() {
	$('#telephone_coupon').val('');
	$('#group_couppon').val('');
	$('#id_coupon').val('');
	$('#smstemplate').val('');
}
$('#closecouponform').click(function(event) {
	/* Act on the event */
	reset_form_coupon();
	f_coupon.close();
});

$('#id_coupon').change(function(event) {
	changesmstemplate();
});
$('#telephone_coupon').change(function(event) {
	changesmstemplate();
});
function changesmstemplate() {
	var coupon_code = $('#id_coupon').val();

	var value_group_coupon = $('#group_couppon').val();

	var percent = $('#group_couppon > option[value='+value_group_coupon+']').html()

	var value_group_coupon = $('#group_couppon').val();
	var telephone_coupon = $('#telephone_coupon').val();

	var NgayexpireCoupon;
	var adata = json_coupon.data;
	for (var i = 0; i < adata.length; i++) {
		var obj = adata[i];
		if (obj.coupon_code == coupon_code) {
			console.log(obj);
			var generate_date = new Date(obj.generate_date);
			var expire_time = obj.expire_time;
			generate_date.setTime(generate_date.getTime() + parseInt(expire_time)*24*60*60*1000);
			NgayexpireCoupon = generate_date.getFullYear() + "-" + (generate_date.getMonth()+1) + "-" + generate_date.getDate();
		}
	}

	if (coupon_code != "" && value_group_coupon != "" && telephone_coupon != "" ) {

		SMSTEMPLATE = guest_smstemplate[0];
		SMSTEMPLATE = SMSTEMPLATE.replace("%Macoupon%", coupon_code); 

		SMSTEMPLATE = SMSTEMPLATE.replace("%Tenkhachhang%", guest.hoten); 
		SMSTEMPLATE = SMSTEMPLATE.replace("%Tenkhachhang%", guest.hoten);

		SMSTEMPLATE = SMSTEMPLATE.replace("%phantram%", percent); 
		SMSTEMPLATE = SMSTEMPLATE.replace("%NgayexpireCoupon%", NgayexpireCoupon); 
		$('#smstemplate').val(SMSTEMPLATE);
	} else {
		$('#smstemplate').val("");
	}
}

$('#coupon').click(function(event) {
	/* Act on the event */
	f_coupon = $('#f_coupon').bPopup({ modalClose: false});
});

$('#sendcoupon').click(function(event) {
	/* Act on the event */
	var smstemplate = $('#smstemplate').val()
	var telephone_coupon = $('#telephone_coupon').val();
	var coupon_code = $('#id_coupon').val();
	if ( telephone_coupon != "" && smstemplate != "") {
		// $('#f_coupon').bPopup().close();
		$.post('../ajaxserver/coupon_guest.php', {sendsms: '', dienthoaisms:telephone_coupon, smstemplate: smstemplate}, function(data, textStatus, xhr) {
			json_sendsms = $.parseJSON(data);
			// gửi tin nhắn cho khách hàng thành công
			json_sendsms.result = 1;
			if (json_sendsms.result == 1) {
				// guest_maketing
				var obj = guest_maketing[0];
				var manv = obj.manv;
				var makhach = obj.makhach;
				var chiendich = obj.chiendich;
				var lienhe = 1;
				var ghichu = "Đã gui coupon " + coupon_code;
				marketing = [manv, makhach, chiendich, lienhe, ghichu];

				// coupon_code;
				var status = 'A';
				coupon = [coupon_code, status];

				guest_event = [guest_id, ghichu];
				$.post('../ajaxserver/coupon_guest.php', {update: '', marketing:marketing, coupon:coupon, guest_event:guest_event}, function(data, textStatus, xhr) {
					json_update = $.parseJSON(data);
					if (json_update.result == 1) {
						alert('Gửi coupon cho khách hàng thành công! Mã coupon: ' +  coupon_code);
						window.location = "";
					}
				});
			}
		});
	}
});