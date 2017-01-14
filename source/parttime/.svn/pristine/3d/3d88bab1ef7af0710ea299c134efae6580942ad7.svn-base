// Kiem tra cac thong tin export
function checkValid() {
    var tungay = $("#from_date"),
        denngay = $("#to_date"),
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

//Show loading
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

//Show notification message
//type: 'attention', 'success', 'error'
function showNotification(type, message) {
  var html = "";
  
  html += "<tr><td colspan='7'><div style='padding-top: 15px;'>";
  html += "<div class='notification " + type + " png_bg'>";
  html += "    <div>";
  html += message;
  html += "    </div>";
  html += "</div>";
  html += "</div></td></tr>";
  
  $('#items_body').html(html);
}

//Clear notification message
function clearNotification() {
  $('#items_body').html('');
}

// Statistic updated
function statisticUpdated() {
    // Get input data
    from_date = $('#from_date').val();
    to_date = $('#to_date').val();
    
    // Clear table body
    $('#items_body').html('');
    
    // Show loading
    showLoading();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/guest_development.php",
        type: 'POST',
        data: String.format('statistic_updated={0}&from_date={1}&to_date={2}', 'true', from_date, to_date),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                hideLoading();
                // Process data
                var json = jQuery.parseJSON(data);
                if(json.result == "success") {
                    if (json.items.length != 0) {
                        for (i = 0; i < json.items.length; i++) {
                            var d = json.items[i];
                            var htmlText = "";
                            
                            htmlText += String.format("<tr class='{0}'>", (i % 2 == 0) ? "alt-row" : "");
                            htmlText += String.format("<td><a class='blue-violet' href='javascript:'>{0}</a></td>", d.guest_name);
                            htmlText += String.format("<td>{0}</td>", d.address);
                            htmlText += String.format("<td>{0}</td>", d.telephone);
                            htmlText += String.format("<td>{0}</td>", d.mobile);
                            htmlText += String.format("<td>{0}</td>", d.email);
                            htmlText += String.format("<td><span class='blue-text'>{0}</span></td>", d.assign_to);
                            htmlText += String.format("<td><a target='_blank' title='Lịch sử liên hệ' href='../guest_development/contact.php?i={0}#history'><img src='../resources/images/icons/contact-16.png' alt=''></a></td>", 
                                                      d.guest_id);
                            htmlText += "</tr>";
                            
                            // Add to table
                            $('#items_body').append(htmlText);
                        }
                    }
                } else {
                    showNotification('error', json.message);
                }
            }
            catch(err) {
                //Handle errors here
                hideLoading();
                showNotification('error', err);
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
            hideLoading();
            showNotification('error', errorThrown);
        }
    });
}

// Statistic contacted
function statisticContacted() {
    // Get input data
    from_date = $('#from_date').val();
    to_date = $('#to_date').val();
    
    // Clear table body
    $('#items_body').html('');
    
    // Show loading
    showLoading();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/guest_development.php",
        type: 'POST',
        data: String.format('statistic_contacted={0}&from_date={1}&to_date={2}', 'true', from_date, to_date),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                hideLoading();
                // Process data
                var json = jQuery.parseJSON(data);
                if(json.result == "success") {
                    if (json.items.length != 0) {
                        for (i = 0; i < json.items.length; i++) {
                            var d = json.items[i];
                            var htmlText = "";
                            
                            htmlText += String.format("<tr class='{0}'>", (i % 2 == 0) ? "alt-row" : "");
                            htmlText += String.format("<td>{0}</td>", d.no);
                            htmlText += String.format("<td><span class='orange'>{0}</span></td></td>", d.employee_name);
                            htmlText += String.format("<td>{0}</td>", d.total_amount);
                            htmlText += String.format("<td>" +
                                                          "<a class='blue-text' id='view_detail_{0}' title='Xem danh sách khách hàng' href='javascript:statisticContactedDetail(\"{1}\", \"{2}\", \"{3}\");'>{4}</a>" +
                                                      "</td>", 
                                                      d.employee_id, d.from_date, d.to_date, d.employee_id, d.amount);
                            htmlText += String.format("<td>" +
                                                          "<a class='blue-text' id='orders_amount_{0}' title='Xem danh sách đơn hàng' href='javascript:showOrders(\"amount\", \"{1}\", \"{2}\", \"{3}\");'>{4}</a>" +
                                                      "</td>", 
                                                      d.employee_id, d.from_date, d.to_date, d.employee_id, d.payment_amount);
                            htmlText += String.format("<td>" +
                                                          "<a class='blue-text' id='orders_money_{0}' title='Xem danh sách đơn hàng' href='javascript:showOrders(\"money\", \"{1}\", \"{2}\", \"{3}\");'>{4}</a>" +
                                                      "</td>", 
                                                      d.employee_id, d.from_date, d.to_date, d.employee_id, d.payment_money);
                            htmlText += "</tr>";
                            
                            // Add to table
                            $('#items_body').append(htmlText);
                        }
                    }
                } else {
                    showNotification('error', json.message);
                }
            }
            catch(err) {
                //Handle errors here
                hideLoading();
                showNotification('error', err);
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
            hideLoading();
            showNotification('error', errorThrown);
        }
    });
}

// Export data to Excel
function exportExcel(type) {
    // Get input data
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    // Create URL
    var url = "";
    url = String.format("../guest_development/statistic-export.php?type={0}&from={1}&to={2}", type, from_date, to_date);
    
    window.open(url, '_blank'); // opens URL in a new tab
}

// Show detail dialog
function showDetailDialog() {
    $('#detail_dialog').bPopup({
        escClose: false,
        modalClose: false
    });
}

//Show detail notification message
//type: 'attention', 'success', 'error'
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

// Create loading icon
function createLoadingIcon() {
    return "<img alt=\"loading\" src=\"../resources/images/loading.gif\">";
}

var loading  = false; //to prevents multipal ajax loads

// Statistic contacted detail
function statisticContactedDetail(from_date, to_date, employee_id) {
    var ctrlId = '#view_detail_' + employee_id;
    var orgHtml = $(ctrlId).html();
    
    // Set table header
    $('#detail_items_head').html("<th>Họ tên</th>" +
                                "<th>Địa chỉ/Công ty</th>" +
                                "<th>Điện thoại</th>" +
                                "<th>Di động</th>" +
                                "<th>Email</th>" +
                                "<th>Actions</th>");
    
    // Clear table body
    $('#detail_items_body').html('');
    
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Show loading icon
        $(ctrlId).html(createLoadingIcon());
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/guest_development.php",
            type: 'POST',
            data: String.format('statistic_contacted_detail={0}&from_date={1}&to_date={2}&employee_id={3}', 'true', from_date, to_date, employee_id),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $(ctrlId).html(orgHtml);
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        if (json.items.length != 0) {
                            for (i = 0; i < json.items.length; i++) {
                                var d = json.items[i];
                                var htmlText = "";
                                
                                htmlText += String.format("<tr class='{0}'>", (i % 2 == 0) ? "alt-row" : "");
                                htmlText += String.format("<td><a class='blue-violet' href='javascript:'>{0}</a></td>", d.guest_name);
                                htmlText += String.format("<td>{0}</td>", d.address);
                                htmlText += String.format("<td>{0}</td>", d.telephone);
                                htmlText += String.format("<td>{0}</td>", d.mobile);
                                htmlText += String.format("<td>{0}</td>", d.email);
                                //htmlText += String.format("<td><span class='blue-text'>{0}</span></td>", d.assign_to);
                                htmlText += String.format("<td><a target='_blank' title='Lịch sử liên hệ' href='../guest_development/contact.php?i={0}#history'><img src='../resources/images/icons/contact-16.png' alt=''></a></td>", 
                                                          d.guest_id);
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

// Show orders list
function showOrders(type, from_date, to_date, employee_id) {
    var ctrlId = String.format('#orders_{0}_{1}', type, employee_id);
    var orgHtml = $(ctrlId).html();
    
    // Set table header
    $('#detail_items_head').html("<th>Mã hóa đơn</th>" +
                                "<th>Thành tiền</th>" +
                                "<th>Khách hàng</th>" +
                                "<th>Ngày mua</th>" +
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
            url: "../ajaxserver/guest_development.php",
            type: 'POST',
            data: String.format('show_orders={0}&from_date={1}&to_date={2}&employee_id={3}', 'true', from_date, to_date, employee_id),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $(ctrlId).html(orgHtml);
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        if (json.items.length != 0) {
                            for (i = 0; i < json.items.length; i++) {
                                var d = json.items[i];
                                var htmlText = "";
                                
                                htmlText += String.format("<tr class='{0}'>", (i % 2 == 0) ? "alt-row" : "");
                                htmlText += String.format("<td><a target='_blank' class='blue-text' title='Chi tiết đơn hàng' href='../orders/orderdetail.php?item={0}'>{1}</a></td>", d.order_id, d.order_id);
                                htmlText += String.format("<td><span class='orange'>{0}</span></td>", d.money);
                                htmlText += String.format("<td>{0}</td>", d.guest_name);
                                htmlText += String.format("<td>{0}</td>", d.created_date);
                                htmlText += String.format("<td>{0}</td>", d.delivery_date);
                                htmlText += String.format("<td><div class='box_content_player'><span class='{0}'>{1}</span></div></td>", d.status.css, d.status.text);
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

// DOM load
$(function() {
    // datepicker
    var dates = $("#from_date, #to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
    });
});