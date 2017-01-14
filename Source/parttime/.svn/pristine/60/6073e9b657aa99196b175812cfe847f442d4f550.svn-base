// Show message dialog
function showMessage(message) {
	$("#message").text(message);
	$("#dialog-message").dialog("open");
}

//++ REQ20120508_BinhLV_N
// Lay danh sach ma loai san pham
function getTypeList(makho) {
    var array = '';
    var items = $("#order-example").find("input[name='loai" + makho + "[]']");
    items.each(function(i, e) {
        array += $(e).val();
        if(i < items.length - 1)
            array += '|';
        });
    //alert(array);
    return array;
}

// Lay danh sach so tien nhap vao
function getMoneyList(makho) {
    var array = '';
    var items = $("#order-example").find("input[name='sotien" + makho + "[]']");
    items.each(function(i, e) {
        array += $(e).val();
        if(i < items.length - 1)
            array += '|';
        });
    //alert(array);
    return array;
}
//-- REQ20120508_BinhLV_N

//++ REQ20120508_BinhLV_M
// Cap nhat doanh thu
function updateTrade(maso, makho) {
	var ngay = $("#date"),
	    nguoicapnhat = $("#nguoicapnhat" + makho),
	    ngaygiocapnhat = $("#ngaygiocapnhat" + makho),
	    tongso = $("#tongso" + makho);
		ghichu = $("#ghichu" + makho);
	    loading = $("#loading" + makho);
	 
	loading.show();   	
	// Gui yeu cau Ajax
	var format = 'maso={0}&ngay={1}&makho={2}&ghichu={3}&loaisanpham={4}&sotien={5}';
	var request = String.format(format, maso,
                                        ngay.text(), 
									    makho,
									    ghichu.val(),
                                        getTypeList(makho),
                                        getMoneyList(makho)
                               );
    //alert(request);
    $.ajax({
        url: '../ajaxserver/trade_server.php',
        type: 'POST',
        data: request,
        success: function (data, textStatus, jqXHR) {
    		// data = '{ "result":%d , "message":"%s", "nguoicapnhat":"%s", "ngaygiocapnhat":"%s", "tongso":%f }';
    		var obj = jQuery.parseJSON(data);
    		if(obj.result == 1) {
    			//showMessage("Cập nhật thành công!");
    			nguoicapnhat.text(obj.nguoicapnhat);
    			ngaygiocapnhat.hide();
    			ngaygiocapnhat.text(obj.ngaygiocapnhat);
    			ngaygiocapnhat.show("fast");
    			tongso.text(obj.tongso);
    		}
    		else {
    			showMessage(obj.message);
    		}
            loading.hide("slow");  
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	showMessage(String.format("{0}: {1}", textStatus, errorThrown));
        	//showMessage(String.format("{0}: {1}", textStatus, jqXHR.responseText));
        	loading.hide();
        }
    });
}
//-- REQ20120508_BinhLV_M

// Kiem tra cac thong tin export
function checkValid() {
	var makho = $("#makho"),
    	tungay = $("#tungay"),
    	denngay = $("#denngay"),
    	error_1 = $("#error-1"),
    	error_2 = $("#error-2"),
    	error_3 = $("#error-3"),
    	isValid = true;
	
	error_1.text("");
	error_2.text("");
	error_3.text("");
	if(makho.val() ==="") {
		isValid = false;
		error_1.text("* Chọn showroom");
	}
	if(tungay.val() ==="") {
		isValid = false;
		error_2.text("* Chọn ngày");
	}
	if(denngay.val() ==="") {
		isValid = false;
		error_3.text("* Chọn ngày");
	}
	
	return isValid;
}

// Export bang doanh thu tung showroom theo khoang thoi gian ra file excel
function export2Excel2() {
	var makho = $("#makho"),
	    tungay = $("#tungay"),
        denngay = $("#denngay");
	var format = "../phpexcel/export2exel.php?do=export&table=showroom&id={0}&from={1}&to={2}";
	var url;
	if(checkValid()) {
		url = String.format(format, makho.val(), 
									tungay.val(), 
									denngay.val());
		window.location = url;
	}
}

//Export bang doanh thu tung showroom theo khoang thoi gian ra file excel
function export2Excel(id) {
	var makho = $("#makho" + id).val(),
	    tungay = $("#tungay" + id).val(),
        denngay = $("#denngay" + id).val();
	var format = "../phpexcel/export2exel.php?do=export&table=showroom&id={0}&from={1}&to={2}";
	var url = String.format(format, makho, 
									tungay, 
									denngay);
	window.open(url, '_search');
}

// DOM load
$(function() {
	// numeric
	$(".numeric").numeric();
	
	// datepicker
	var dates = $("#tungay, #denngay").datepicker({
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			/*var option = this.id == "tungay" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );*/
		}
	});
	$(".datepicker").datepicker({
		changeMonth: true,
		changeYear: true
	});
	
	// dialog
	$( "#dialog-message" ).dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		buttons: {
			OK: function() {
				$(this).dialog("close");
			}
		}
	});
	
	// submit event
	$("#trade-list").submit(function() {
		return checkValid();
	});
});