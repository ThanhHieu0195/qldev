// Update data table
function updateDataTable() {
    $('.check-all').removeAttr("checked");
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

// Site: http://joekuan.wordpress.com/2009/06/12/ajax-a-simplified-version-of-file-upload-form-using-iframe/
function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}

/* Same as the one defined in OpenJS */
function uploadDone(name) {
    var frame = getFrameByName(name);
    if (frame) {
      ret = frame.document.getElementsByTagName("body")[0].innerHTML;
  
      /* If we got JSON, try to inspect it and display the result */
      if (ret.length) {
        /* Convert from JSON to Javascript object */
        try {
             //var json = eval("("+ret+")");
             var json = $.parseJSON(ret);
             
             /* Process data in json ... */
             var htmText = '';
             switch(json.result) {
                 case "error":
                     showNotification("error", json.message);
                     hideLoading();
                     break;
                     
                 case "success":
                     showNotification("information", json.message);
                     
                     // Update data table
                     updateDataTable();
                     break;
                     
                 case "warning":
                     var htmlText = json.message;
                     
                     if (json.detail.length != 0) {
                         for (i = 0; i < json.detail.length; i++) {
                             var d = json.detail[i];
                             
                             htmlText += String.format("<br />&nbsp;&nbsp;• Khách hàng <span class='orange'>{0}</span>: {1}", 
                                                     d.guest_id, 
                                                     d.error);
                         }
                     }
                     
                     showNotification("attention", htmlText);
                     
                     // Update data table
                     updateDataTable();
                     break;
             }
        }
        catch(err) {
             //Handle errors here
             showNotification('error', err);
             hideLoading();
        }
        
        frame.document.getElementsByTagName("body")[0].innerHTML = '';
      }
   }
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

// Check if user select guest(s) or not
function isChooseItem() {
    var choosed = false;

    $("#list_all").find("input[type='checkbox']").each(function(index, e) {
        if($(e).attr("checked") == "checked") {
            choosed = choosed || true;
        }
    });

    return choosed;
}

// Add guests to favourites
function addFavourites() {
    if (!isChooseItem()) {
        var message = "Vui lòng chọn các khách hàng muốn thực hiện thao tác!";
        showNotification('error', message);
        
        return false;
    }
    
    // Clear the notification message
    clearNotification();
    
    // Submit the form
    $("#list_all_action").val("add_favourites");
    $('#list_all').submit();
    
    return true;
}

//Add guests to favourites
function reAssign() {
    if (!isChooseItem()) {
        var message = "Vui lòng chọn các khách hàng muốn thực hiện thao tác!";
        showNotification('error', message);
        
        return false;
    }
    
    if($("#assign_to").val() == "") {
        var message = "Vui lòng chọn nhân viên chịu trách nhiệm theo dõi!";
        showNotification('error', message);
        
        return false;
    }
    
    // Clear the notification message
    clearNotification();
    
    // Submit the form
    $("#list_all_action").val("re_assign");
    $('#list_all').submit();
    
    return true;
}

$(document).ready(function() {
    //showLoading();
    $('#list_all').submit(function() {
        showLoading();
    });
});