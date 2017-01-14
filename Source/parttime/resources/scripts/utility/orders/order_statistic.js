// Show notification message
// type: 'attention', 'success', 'error'
function showNotification(type, message) {
  var html = "";
  
  html += "<div class='notification " + type + " png_bg'>";
  html += "    <div>";
  html += message;
  html += "    </div>";
  html += "</div>";
  
  $('#process_msg').html(html);
}

var loading = false; //to prevents multipal ajax loads

//
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

// Hide loading
function hideLoading() {
    $('#popup').bPopup().close();
    $('#popup_msg').html('');
}
// Statistic data
function statistic() {
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Get input data
        from_date = $('#from_date').val();
        to_date = $('#to_date').val();
        cashier = $('#cashier').val();
        
        // Clear notification
        $('#process_msg').html('');
        
        // Hide the table(s)
        $('#items').hide();
		  $('#sales').hide();
        $('#tbl_total').hide();
        
        // Clear table body
        $('#items_body').html('');
		 $('#sales_body').html('');
        
        // Hide the filter control
        $('#search_panel').hide();
		 $('#search_panel1').hide();
        
        // Show loading
        $('#loading').show();
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/orders_cashed_server.php",
            type: 'POST',
            data: String.format('orderstatistic={0}&from_date={1}&to_date={2}&cashier={3}', 'true', from_date, to_date, cashier),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $('#loading').hide();
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        
                        // Set token items
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
                                htmlText += String.format("<td>{0}<input type='hidden' name='money_value' value='{1}' /></td>", d.phamtramgiam, d.ds);
								htmlText += String.format("<td>{0}</td>", d.doanhso);
								htmlText += String.format("<td>{0}</td>", d.tennhanvien);
                                htmlText += String.format("<td>{0}</td>", d.khachmualan);
								
                                htmlText += String.format("<td>{0}</td>", d.ngaydat);
								if(d.trangthai=='Chờ giao'){
                               		  htmlText += String.format("<td class='blue-violet' >{0}</td>", d.trangthai);
								}else{
									  htmlText += String.format("<td class='orange' >{0}</td>", d.trangthai);
								}
                                htmlText += "</tr>";
                                
                                // Add to table
                                $('#items_body').append(htmlText);
                            }
                            
                            // Show the filter control
                            $('#search_panel').show();
                        } else {
                            var htmlText = String.format("<tr><td colspan='8'>{0}</td></tr>", "Không tìm thấy dữ liệu");
                            $('#items_body').append(htmlText);
                        }
                        
                        // Show the total money item(s)
                       $this = $("#tbl_total_body").find("td");
                       $this.eq(0).find("span").html(json.total_receipt);
                        
                        // Show the table(s)
                        $('#items').show();
                       $('#tbl_total').show();
                    } else {
                        showNotification('error', json.message);
                    }
                    
                    loading = false; 
                }
                catch(err) {
                    //Handle errors here
                    $('#loading').hide();
                    showNotification('error', err);
                    
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
                
                loading = false; 
            }
        });
    }
}
//
function summary() {
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Get input data
        from_date = $('#from_date').val();
        to_date = $('#to_date').val();
        cashier = $('#cashier').val();
        
        // Clear notification
        $('#process_msg').html('');
        
        // Hide the table(s)
        $('#items').hide();
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
            data: String.format('sales={0}&from_date={1}&to_date={2}&cashier={3}', 'true', from_date, to_date, cashier),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $('#loading').hide();
					 hideLoading();
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        
                        // Set token items
                        if (json.output_items.length > 0) {
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
								htmlText += String.format("<td>{0}</td>", d.soluongkhcu);
								htmlText += String.format("<td>{0}<input type='hidden' name='money_value' value='{1}' /></td>", d.soluongkhmoi, d.ds);
                                htmlText += "</tr>";
                                
                                // Add to table
                                $('#sales_body').append(htmlText);
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
                    showNotification('error', err);
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
//
function createLoadingIcon() {
    return "<img alt=\"loading\" src=\"../resources/images/loading.gif\">";
}
// Show orders list
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
								"<th>Ngày đặt</th>" + 
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
            data: String.format('orderstatistic={0}&from_date={1}&to_date={2}&cashier={3}', 'true', from_date, to_date, employee_id),
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
                                htmlText += String.format("<td>{0}<input type='hidden' name='money_value' value='{1}' /></td>", d.phamtramgiam, d.ds);
								htmlText += String.format("<td>{0}</td>", d.doanhso);
							
                                htmlText += String.format("<td>{0}</td>", d.khachmualan);
								
                                htmlText += String.format("<td>{0}</td>", d.ngaydat);
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
function showDetailDialog() {
    $('#detail_dialog').bPopup({
        escClose: false,
        modalClose: false
    });
}
//
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
//Export data to Excel
function exportExcel() {
    // Get input data
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var cashier = $('#cashier').val();
    // Create URL
    var url = "";
    url = String.format("../orders/order_filter_export.php?from={0}&to={1}&cashier={2}", from_date, to_date, cashier);
    
    window.open(url, '_blank'); // opens URL in a new tab
}

// DOM load
$(function() {
    disableAutocomplete();
    
    // datepicker
    var dates = $("#from_date, #to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
    });
});