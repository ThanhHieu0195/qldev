
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
function showNotification(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    $('#notification_msg').html(html);
}
function isChooseItem() {
    var choosed = false;

    $("#contact").find("input[type='checkbox']").each(function(index, e) {
        if($(e).attr("checked") == "checked") {
            choosed = choosed || true;
        }
    });

    return choosed;
}
function clearNotification() {
    $('#notification_msg').html('');
}
function addFavourites() {
   
    
    // Clear the notification message
    clearNotification();
    
    // Submit the form
    $("#list_all_action").val("add_favourites");
    $('#contact').submit();
    
    return true;
}

function unFollow() {
  
   
    // Clear the notification message
    clearNotification();
   
    // Submit the form
    $("#list_all_action").val("unfollow");
    $('#contact').submit();
   
    return true;
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
function showOrdersByGuest(guest_id) {
    var ctrlId = String.format('#orders_{0}', guest_id);
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
            url: "../ajaxserver/guest_development.php",
            type: 'POST',
            data: String.format('show_orders_by_guest={0}&guest_id={1}', 'true', guest_id),
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
                    // $(ctrlId).html(orgHtml);
                    hideLoading();
                    showDetailNotification('error', err);
                    
                    loading = false; 
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
                
                loading = false; 
            }
        });
    }
}

// DOM load
$(function() {
});
