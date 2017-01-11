function number2string(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Kiem tra cac thong tin export
function checkValid() {
    var tungay = $("#tungay"),
        denngay = $("#denngay"),
        error_1 = $("#error-1"),
        error_2 = $("#error-2"),
        isValid = true;
    
    error_1.text("");
    error_2.text("");
    if(tungay.val() ==="") {
        isValid = false;
        error_1.text("* Chọn ngày");
    }
    if(denngay.val() ==="") {
        isValid = false;
        error_2.text("* Chọn ngày");
    }
    
    return isValid;
}

// Export file excel
function export2Excel(type) {
    //alert(type);
    var tungay = $("#tungay"),
        denngay = $("#denngay");
    var format = '';
    switch (type) {
        case '1':
            format = "../phpexcel/export2exel.php?do=export&table=orderdelivered&from={0}&to={1}";
            break;  
        case '20':
            format = "../phpexcel/export2exel.php?do=export&table=orderdelivered_sellers&from={0}&to={1}&type=0";
            break;
         case '21':
            format = "../phpexcel/export2exel.php?do=export&table=orderdelivered_sellers&from={0}&to={1}&type=1";
            break;
    }
    var url;
    if(checkValid()) {
        url = String.format(format, tungay.val(), denngay.val());
        //window.location = url;
        var win = window.open(url, '_blank');
        win.focus();
    }
}

// DOM load
$(function() {    
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
});

var loading = false; //to prevents multipal ajax loads
function showLoading() {
    var html = "";
    
    html += "<center><img src='../resources/images/loadig_big.gif' alt='loading' /></center>";
    
    // Set html content
    $('#popup_msg').html(html);
    
    // Show popup dialog
    $("#button_close_popup").hide();
    $("#popup").css("min-width", "50px");
    $('#popup').bPopup({
        escClose: false,
        modalClose: false
    });
}
function hideLoading() {
    $('#popup').bPopup().close();
    $('#popup_msg').html('');
}
//
function createLoadingIcon() {
    return "<img alt=\"loading\" src=\"../resources/images/loading.gif\">";
}
function showDetailDialog() {
    $('#detail_dialog').bPopup({
        escClose: false,
        modalClose: false
    });
}
function showDetailNotification(type, message) {
    var html = "";
    
    html += "<tr><td colspan='6'><div style='padding-top: 15px;'>";
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    html += "</div></td></tr>";
    
    $('#detail_items_body').html(html);
}
function summary(type) {
	 if(checkValid()){
    if (loading == false) {
        loading = true; //prevent further ajax loading
       
        // Get input data
        from_date = $('#tungay').val();
        to_date = $('#denngay').val();
        cashier = "";
        
        // Clear notification
        $('#process_msg').html('');
        
        // Hide the table(s)
        $('#dt_example').hide();
		  $('#sales').hide();
        $('#tbl_total').hide();
        
        // Clear table body
        $('#items_body').html('');
		 $('#sales_body').html('');
        
		 showLoading();
        // Hide the filter control
        $('#search_panel').hide();
		 $('#search_panel1').hide();
        
        // Show loading
        $('#loading').show();
       
        // Send AJAX request
      $.ajax({
            url: "../ajaxserver/orders_cashed_server.php",
            type: 'POST',
            data: String.format('sales_delivered={0}&from_date={1}&to_date={2}&cashier={3}&type={4}', 'true', from_date, to_date, cashier, type),
            success: function (data, textStatus, jqXHR) {
                try {
                    "use strict";
                    // Hide loading
                    $('#loading').hide();
					 hideLoading();
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                

                    if(json.result == "success") {
                        var doanhsotrahang = json.doanhsotrahang;

                        var trahang = [];
                        var donhang = [];
                        trahang['manv'] = [];
                        var total_tienlai = 0;

                        if (doanhsotrahang.length > 0) {
                            for (var i=0; i<doanhsotrahang.length; i++) {
                                trahang['manv'].push(doanhsotrahang[i]['manv']);
                                trahang[doanhsotrahang[i]['manv']] = {hoten: doanhsotrahang[i]['hoten'], doanhsotralai: doanhsotrahang[i]['doanhsotralai'], tlth:doanhsotrahang[i]['tlth']};
                            }
                        }
                        // Set token items
                        if (json.output_items.length > 0 || doanhsotrahang.length > 0) {
                            for (i = 0; i < json.output_items.length; i++) {
                                var d = json.output_items[i];
                                console.log(d);
                                var htmlText = "";
                                var css = (i % 2 == 0) ? "alt-row" : "";
                                
                                htmlText += String.format("<tr class={0}>", css);
                                htmlText += String.format("<td>{0}</td>", d.hoten);
                                htmlText += String.format("<td>{0}</td>", d.doanhthulansau);
                                htmlText += String.format("<td>{0}</td>", d.doanhthulandau);
								htmlText += String.format("<td>" +
                                                          "<a class='blue-text' id='orders_money_{0}' title='Xem danh sách đơn hàng' href='javascript:showOrders(\"money\", \"{1}\", \"{2}\", \"{3}\");'>{4}</a>" +
                                                      "</td>", 
                                                      d.manv, from_date, to_date, d.manv, d.doanhso);
                                var fm_lai = "";
                                if (trahang['manv'].indexOf(d.manv) != -1) {
                                    donhang.push(d.manv);

                                    var doanhsotralai = trahang[d.manv]['doanhsotralai'];
                                    var doanhso = d.ds;
                                    var doanhsodieuchinh = number2string(doanhso - doanhsotralai);

                                    var tienlaitrahang = trahang[d.manv]['tlth'];
                                    var tienlaihieuchinh = d.tldh - tlth;
                                    total_tienlai += tienlaihieuchinh;

                                    fm_lai = String.format("<td>{0}</td> <td>{1}</td>", tienlaitrahang, tienlaihieuchinh);

                                    htmlText += String.format("<td>" +
                                                          "<a class='blue-text' id='returns_money_{0}' title='Xem danh sách đơn hàng' href='javascript:showReturns(\"money\", \"{1}\", \"{2}\", \"{3}\");'>{4}</a>" +
                                                      "</td>", 
                                                      d.manv, from_date, to_date, d.manv, doanhsotralai);
                                    htmlText += String.format("<td>{0}</td>", doanhsodieuchinh);
                                } else {
                                    htmlText += String.format("<td>0</td>");
                                    htmlText += String.format("<td><a class='blue-text'>{0}</a></td>", d.doanhso);
                                    var tienlaihieuchinh = d.tienlaidonhang;
                                    total_tienlai += d.tldh;

                                    fm_lai = String.format("<td>0</td> <td>{0}</td>", tienlaihieuchinh);
                                }

								htmlText += String.format("<td>{0}</td>", d.soluongkhcu);
								htmlText += String.format("<td>{0}<input type='hidden' name='money_value' value='{1}' /></td>", d.soluongkhmoi, d.ds);
                                htmlText += String.format("<td>{0}</td>", d.tienlaidonhang);
                                htmlText += fm_lai;
                                htmlText += "</tr>";                                
                                // Add to table
                                $('#sales_body').append(htmlText);
                            }

                            for (var i = 0; i<trahang['manv'].length; i++) {
                                var manv = trahang['manv'][i];
                                if (donhang.indexOf(manv) == -1) {
                                    var htmlText = "";
                                    var css = (i % 2 == 0) ? "alt-row" : "";
                                    var dstl = number2string(trahang[manv]['doanhsotralai']);
                                    htmlText += String.format("<tr class={0}>", css);
                                    htmlText += String.format("<td>{0}</td>", trahang[manv]['hoten']);
                                    htmlText += String.format("<td>0</td>");
                                    htmlText += String.format("<td>0</td>");
                                    htmlText += String.format("<td><a class='blue-text'>0</a></td>");
                                    htmlText += String.format("<td>" +
                                                          "<a class='blue-text' id='returns_money_{0}' title='Xem danh sách đơn hàng' href='javascript:showReturns(\"money\", \"{1}\", \"{2}\", \"{3}\");'>{4}</a>" +
                                                      "</td>", 
                                                      manv, from_date, to_date, manv, dstl);
                                    htmlText += String.format("<td>-{0}</td>", dstl);
                                    htmlText += String.format("<td>0</td>");
                                    htmlText += String.format("<td>0</td>");
                                    var fm_lai = "<td>0</td> <td>{0}</td>  <td>{1}</td>";
                                    var tienlaitrahang = trahang[manv]['tlth'];
                                    var tienlaihieuchinh =  -trahang[manv]['tlth'];
                                    total_tienlai -= trahang[manv]['tlth'];

                                    htmlText += String.format(fm_lai, number2string(tienlaitrahang), number2string(tienlaihieuchinh));
                                    htmlText += "</tr>"; 
                                $('#sales_body').append(htmlText);
                                       
                                }
                            }
                            
                            // Show the filter control
                           
							$('#search_panel1').show();
                        } else {
                            var htmlText = String.format("<tr><td colspan='8'>{0}</td></tr>", "Không tìm thấy dữ liệu");
                            $('#sales_body').append(htmlText);
                        }
                        
                        // Show the total money item(s)
                       $this = $("#tbl_total_body").find("td");
                       $this.eq(0).find("span").html(json.total_receipt);
                       $('#tonglai').html(number2string(total_tienlai));
                       
                        // Show the table(s)
                        $('#sales').show();
                       $('#tbl_total').show();
                    } else {
                        showNotification('error', json.message);
						
                    }
                    
                    loading = false; 
                }
                catch(err) {
                    //Handle errors here
                    $('#loading').hide();
                     console.log('error', err);
                     hideLoading();
                    loading = false; 
               }
            },
            timeout: 15000,      // timeout (in miliseconds)
            error: function(qXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    // request timed out, do whatever you need to do here
                }
                else {
                    // some other error occurred
                }
                $('#loading').hide();
				
                showNotification('error', errorThrown);
                 hideLoading();
                loading = false; 
            }
        });
	}
	 }
}
function showReturns( type, from_date, to_date, employee_id) {
     $('#detail_items_head').html("<th>Mã phiếu trả</th>" +
                                "<th>Tiền trả</th>" +
                                "<th>Doanh số</th>" +
                                "<th>Ngày trả</th>" + 
                                "<th>Trạng thái</th>");
    $('#detail_items_body').html('');
    if (loading == false) {
        // loading = true;
        $.ajax({
            url: '../ajaxserver/orders_cashed_server.php',
            type: 'POST',
            dataType: 'json',
            data: {returndeliveredstatistic: 1, from_date:from_date, to_date:to_date, cashier:employee_id},
        })
        .done(function(result) {
            console.log(result['message']);
            if (result['result'] == "success") {
                // trả về mãng các item
                var arr = result['output_items'];
                var html = "";
                if (arr.length > 0) {
                    for (var i = 0; i < arr.length; i++) {
                        var css = (i % 2 == 0) ? "alt-row" : "";
                        html += String.format("<tr class={0}>", css);

                        html += String.format("<td>{0}</td>", arr[i]['maphieu']);
                        html += String.format("<td>{0}</td>", arr[i]['tien']);
                        html += String.format("<td>{0}</td>", arr[i]['tralai']);
                        html += String.format("<td>{0}</td>", arr[i]['ngaytra']);
                        html += "<td>đã xác nhận</td>"
                        html += "</tr>";
                    }
                    $('#detail_items_body').html(html);
                    showDetailDialog();
                } else {
                     showDetailNotification('error', result['message']);
                     showDetailDialog();
                }
                
            }
            loading = false;

        });
    }
}
function showOrders(type, from_date, to_date, employee_id) {
    var ctrlId = String.format('#orders_{0}_{1}', type, employee_id);
    var orgHtml = $(ctrlId).html();
    
    // Set table header
    $('#detail_items_head').html("<th>Mã hóa đơn</th>" +
                                "<th>Nhóm khách</th>" +
                                "<th>Tổng tiền</th>" +
                                "<th>Tiền giảm</th>" +
                                "<th>Phần trăm giảm</th>" + 
								"<th>Doanh số</th>" + 
								"<th>Khách mua lần</th>" + 
								"<th>Ngày giao</th>" + 
                                "<th>Trạng thái</th>");
    
    // Clear table body
    $('#detail_items_body').html('');
    
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Show loading icon
        $(ctrlId).html(createLoadingIcon());
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/orders_cashed_server.php",
            type: 'POST',
            data: String.format('orderdeliveredstatistic={0}&from_date={1}&to_date={2}&cashier={3}', 'true', from_date, to_date, employee_id),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $(ctrlId).html(orgHtml);
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        if (json.output_items.length > 0) {
                            for (i = 0; i < json.output_items.length; i++) {
                                var d = json.output_items[i];
                                console.log(d);
                                var htmlText = "";
                                var css = (i % 2 == 0) ? "alt-row" : "";
                                
                                htmlText += String.format("<tr class={0}>", css);
                                htmlText += String.format("<td><a href='../orders/orderdetail.php?item={0}'>{1}</a></td>", d.madon, d.madon);
							   // htmlText += String.format('<td>'+ '<a href="#" onClick="MyWindow=window.open('+"'../orders/orderdetail.php?item={0}'"+','+"'MyWindow'"+',width=800,height=200); return false;">{1}</a>'+'</td>', d.madon, d.madon);
                                htmlText += String.format("<td>{0}</td>", d.nhomkhach);
                                htmlText += String.format("<td>{0}</td>", d.tongtien);
                                htmlText += String.format("<td>{0}</td>", d.tiengiam);
                                htmlText += String.format("<td>{0}<input type='hidden' name='money_value' value='{1}' /></td>", d.phamtramgiam, d.doanhso);
								htmlText += String.format("<td>{0}</td>", d.doanhso);
							
                                htmlText += String.format("<td>{0}</td>", d.khachmualan);
								
                                htmlText += String.format("<td>{0}</td>", d.ngaygiao);
                                if(d.trangthai=='Chờ giao'){
                               		  htmlText += String.format("<td class='blue-violet' >{0}</td>", d.trangthai);
								}else{
									  htmlText += String.format("<td class='orange' >{0}</td>", d.trangthai);
								}
                                htmlText += "</tr>";
                                
                                // Add to table
                                $('#detail_items_body').append(htmlText);
                            }
							
                        }
                        
                        showDetailDialog();
                    } else {
                        showDetailNotification('error', json.message);
                        
                        showDetailDialog();
                    }
                    
                    loading = false; 
                }
                catch(err) {
                    //Handle errors here
                    $(ctrlId).html(orgHtml);
                    showDetailNotification('error', err);
                    
                    loading = false; 
               }
            },
            timeout: 15000,      // timeout (in miliseconds)
            error: function(qXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    // request timed out, do whatever you need to do here
                }
                else {
                    // some other error occurred
                }
                $(ctrlId).html(orgHtml);
                showDetailNotification('error', errorThrown);
                
                loading = false; 
            }
        });
    }
}
//
