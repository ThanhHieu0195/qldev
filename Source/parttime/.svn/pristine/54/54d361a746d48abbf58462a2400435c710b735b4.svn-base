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

var loading_status  = false; //to prevents multipal ajax loads

// Show orders list
function showOrdersByQuestionOption(option_id) {
    var ctrlId = String.format('#orders_{0}', option_id);
    // var orgHtml = $(ctrlId).html();
    
    // Set table header
    $('#detail_items_head').html(
                                "<th>STT</th>" +
                                "<th>Mã hóa đơn</th>" +
                                "<th>Thành tiền</th>" +
                                "<th>Khách hàng</th>" +
                                "<th>Ngày mua</th>" +
                                "<th>Ngày giao</th>" + 
                                "<th>Trạng thái</th>");
    
    // Clear table body
    $('#detail_items_body').html('');
    
    if (loading_status == false) {
        loading_status = true; //prevent further ajax loading
        
        // Show loading icon
        // $(ctrlId).html(createLoadingIcon());
        showLoading();
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/orders_questions_statistic_server.php",
            type: 'POST',
            data: String.format('show_orders_by_question_option={0}&option_id={1}', 'true', option_id),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    // $(ctrlId).html(orgHtml);
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
                                htmlText += String.format("<td><a target='_blank' class='blue-text' title='Chi tiết đánh giá đơn hàng' href='../orders/checking_detail.php?item={0}'>{1}</a></td>", d.order_id, d.order_id);
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
                    
                    loading_status = false; 
                }
                catch(err) {
                    //Handle errors here
                    // $(ctrlId).html(orgHtml);
                    hideLoading();
                    showDetailNotification('error', err);
                    
                    loading_status = false; 
               }
            },
            timeout: 30000,      // timeout (in miliseconds)
            error: function(qXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    // request timed out, do whatever you need to do here
                }
                else {
                    // some other error occurred
                }
                // $(ctrlId).html(orgHtml);
                hideLoading();
                showDetailNotification('error', errorThrown);
                
                loading_status = false; 
            }
        });
    }
}

// Show skipped orders list
function showSkippedOrders() {
    var ctrlId = String.format('#orders_{0}', "");
    // var orgHtml = $(ctrlId).html();
    
    // Set table header
    $('#detail_items_head').html(
                                "<th>STT</th>" +
                                "<th>Mã hóa đơn</th>" +
                                "<th>Thành tiền</th>" +
                                "<th>Khách hàng</th>" +
                                "<th>Ngày mua</th>" +
                                "<th>Ngày giao</th>" + 
                                "<th>Trạng thái</th>");
    
    // Clear table body
    $('#detail_items_body').html('');
    
    if (loading_status == false) {
        loading_status = true; //prevent further ajax loading
        
        // Show loading icon
        // $(ctrlId).html(createLoadingIcon());
        showLoading();
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/orders_questions_statistic_server.php",
            type: 'POST',
            data: String.format('show_skipped_orders={0}', 'true'),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    // $(ctrlId).html(orgHtml);
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
                                htmlText += String.format("<td><a target='_blank' class='blue-text' title='Chi tiết đánh giá đơn hàng' href='../orders/orderdetail.php?item={0}'>{1}</a></td>", d.order_id, d.order_id);
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
                    
                    loading_status = false; 
                }
                catch(err) {
                    //Handle errors here
                    // $(ctrlId).html(orgHtml);
                    hideLoading();
                    showDetailNotification('error', err);
                    
                    loading_status = false; 
               }
            },
            timeout: 30000,      // timeout (in miliseconds)
            error: function(qXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    // request timed out, do whatever you need to do here
                }
                else {
                    // some other error occurred
                }
                // $(ctrlId).html(orgHtml);
                hideLoading();
                showDetailNotification('error', errorThrown);
                
                loading_status = false; 
            }
        });
    }
}

// DOM load
$(function() {
});