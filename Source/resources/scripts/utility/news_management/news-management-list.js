// Show loading
function showLoading() {
    var html = "";
    
    html += "<center><img src='../resources/images/loadig_big.gif' alt='loading' /></center>";
    
    // Set html content
    $('#notification_msg').html(html);
    
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
    $('#notification_msg').html('');
}

// Show notification message
function showNotification(type, message) {
    hideLoading();
    
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    // Set html content
    $('#notification_msg').html(html);
    
    // Show popup dialog
    $("#button_close_popup").show();
    $("#popup").css("min-width", "450px");
    $('#popup').bPopup({
        escClose: true,
        modalClose: true
    });
}

// Re-order an item
function reorder(news_id, action) {
    // Show loading
    showLoading();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/news_server.php",
        type: 'POST',
        data: String.format('re_order={0}&news_id={1}&action={2}', 'true', news_id, action),
        success: function (data, textStatus, jqXHR) {
            try {
                var obj = jQuery.parseJSON(data);
                
                if(obj.result == "success") {
                    // Refresh datatable
                    $('#example').dataTable()._fnAjaxUpdate();
                } else {
                    showNotification('error', obj.message);
                }
            }
            catch(err) {
                //Handle errors here
                showNotification('error', err);
           }
        },
        timeout: 10000,      // timeout (in miliseconds)
        error: function(qXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                // request timed out, do whatever you need to do here
            }
            else {
                // some other error occurred
            }
            showNotification('error', errorThrown);
        }
    });
}

// Change order an item
function saveorder(news_id, org_value) {
    // Get new order of item
    var ctrlId = "#order_" + news_id;
    var new_order = parseInt($(ctrlId).val());
    if (isNaN(new_order) || new_order <= 0) {
        $(ctrlId).val(org_value);
        
        return false;
    }
    
    // Show loading
    showLoading();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/news_server.php",
        type: 'POST',
        data: String.format('save_order={0}&news_id={1}&order={2}', 'true', news_id, new_order),
        success: function (data, textStatus, jqXHR) {
            try {
                var obj = jQuery.parseJSON(data);
                
                if(obj.result == "success") {
                    // Refresh datatable
                    $('#example').dataTable()._fnAjaxUpdate();
                } else if(obj.result == "warning") {
                    // Hide loading
                    hideLoading();
                } else {
                    showNotification('error', obj.message);
                }
            }
            catch(err) {
                //Handle errors here
                showNotification('error', err);
           }
        },
        timeout: 10000,      // timeout (in miliseconds)
        error: function(qXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                // request timed out, do whatever you need to do here
            }
            else {
                // some other error occurred
            }
            showNotification('error', errorThrown);
        }
    });
}

//DOM load
$(function() {
    $('#notification_msg').html('');
});