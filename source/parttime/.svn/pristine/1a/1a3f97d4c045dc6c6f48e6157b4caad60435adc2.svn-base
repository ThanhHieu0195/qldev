
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

var loading  = false; //to prevents multipal ajax loads

// Show orders list
function showOrdersByGuest(maloai, tungay, denngay, type) {
    var ctrlId = String.format('#orders_{0}', maloai);
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
    
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Show loading icon
        // $(ctrlId).html(createLoadingIcon());
        showLoading();
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/thongkedetail.php",
            type: 'POST',
            data: String.format('show_orders_by_guest={0}&maloai={1}&startday={2}&endday={3}&type={4}', 'true', maloai, tungay, denngay, type),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    // $(ctrlId).html(orgHtml);
                    hideLoading();
                    if (type==1) {
                       text = "Lượng bán";
                    } else {
                       text = "Lượng tồn";
                    }
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                    var htmlText1 = String.format("<th>Kích thước</th>");
                    var htmlText2 = "";
                    htmlText2 += String.format("<tr><td>"+text+"</td>");
                    $.each(json.kichthuot, function (index, value) {
                       htmlText1 += String.format("<th>{0}</th>", value.key);
                       htmlText2 += String.format("<td>{0}</td>", value.value);
                    });
                    htmlText2 += String.format("</tr>");
                    // Add to table
                    $('#detail_size_head').html(htmlText1);
                    $('#detail_size_body').html(htmlText2);
                    htmlText1 = String.format("<th>Màu sắc</th>");
                    htmlText2 = "";
                    htmlText2 += String.format("<tr><td>"+text+"</td>");
                    $.each(json.tongmau, function (index, value) {
                       htmlText1 += String.format("<th>{0}</th>", value.key);
                       htmlText2 += String.format("<td>{0}</td>", value.value);
                    });
                    htmlText2 += String.format("</tr>");
                    // Add to table
                    $('#detail_color_head').html(htmlText1);
                    $('#detail_color_body').html(htmlText2);
                    htmlText1 = String.format("<th>Thiết kế</th>");
                    htmlText2 = "";
                    htmlText2 += String.format("<tr><td>"+text+"</td>");
                    $.each(json.hoavan, function (index, value) {
                       htmlText1 += String.format("<th>{0}</th>", value.key);
                       htmlText2 += String.format("<td>{0}</td>", value.value);
                    });
                    htmlText2 += String.format("</tr>");
                    // Add to table
                    $('#detail_design_head').html(htmlText1);
                    $('#detail_design_body').html(htmlText2);
                    
                    loading = false; 
                }
                catch(err) {
                    //Handle errors here
                    // $(ctrlId).html(orgHtml);
                    hideLoading();
                    showDetailNotification('error', err);
                    
                    loading = false; 
               }
               showDetailDialog();
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
                
                loading = false; 
            }
        });
    }
}

// DOM load
$(function() {
});
