// Update data table
function updateDataTable() {
    $('#example').dataTable()._fnAjaxUpdate();
}

//Show notification message
//type: 'attention', 'success', 'error'
function showNotification(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    $('#notification_msg').html(html);
}

// Clear notification message
function clearNotification() {
    $('#notification_msg').html('');
}

// Show loading
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

// Delete a favourite item
function removeFavourite(guest_id) {
    // Show loading
    showLoading();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/guest_development.php",
        type: 'POST',
        data: String.format('remove_favourite={0}&guest_id={1}', 'true', guest_id),
        success: function (data, textStatus, jqXHR) {
            try {
                var obj = jQuery.parseJSON(data);
                
                if(obj.result == "success") {
                    // Refresh datatable
                    updateDataTable();
                } else {
                    //showNotification('error', obj.message);
                    hideLoading();
                }
            }
            catch(err) {
                //Handle errors here
                //showNotification('error', err);
                hideLoading();
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
            //showNotification('error', errorThrown);
            hideLoading();
        }
    });
}

$(document).ready(function() {
});