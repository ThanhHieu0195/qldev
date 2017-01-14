// Create loading icon
function createLoadingIcon() {
    return "<img alt=\"loading\" src=\"../resources/images/loading.gif\">";
}

// Refresh datatable
function refreshDatatable() {
    $('#example').dataTable()._fnAjaxUpdate();
}

// Enable/Disable an item
function enable(uid) {
    var ctrlId = "#enable_" + uid;
    var orgHtml = $(ctrlId).html();
    
    // Show loading
    $(ctrlId).html(createLoadingIcon());
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/finance_management_server.php",
        type: 'POST',
        data: String.format('enable_category={0}&uid={1}', 'true', uid),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                $(ctrlId).html(orgHtml);
                
                // Process data
                var json = jQuery.parseJSON(data);
                if (json.result == "success") {
                    if (json.enable == 1) {
                        $(ctrlId).html(String.format("<a title='Yes' href='javascript:enable(\"{0}\");'><img src='../resources/images/icons/tick.png' alt='' /></a></div>", uid));
                    } else {
                        $(ctrlId).html(String.format("<a title='No' href='javascript:enable(\"{0}\");'><img src='../resources/images/icons/publish_x.png' alt='' /></a></div>", uid));
                    }
                } else {
                    // Do nothing
                    $(ctrlId).html(orgHtml);
                }
            }
            catch(err) {
                //Handle errors here
                $(ctrlId).html(orgHtml);
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
        }
    });
}

// Create global UID
var guid = (function() {
    function s4() {
      return Math.floor((1 + Math.random()) * 0x10000)
                 .toString(16)
                 .substring(1);
    }
    return function() {
      return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
             s4() + '-' + s4() + s4() + s4();
    };
})();

// Add a new row
function addRow() {
    var rowId = guid();
    var html = "";
    
    html += String.format("<tr id='{0}'>", rowId);
    html += "    <td>";
    html += String.format("        <input name='item_id[]' type='hidden' value='{0}'>", "");
    html += "        <input name='item_name[]' class='text-input medium-input' style='width: 95% !important' type='text' value=''>";
    html += "    </td>";
    html += "    <td>";
    html += String.format("        <input type='checkbox' id='check_event_{0}' onclick='check_event(\"{1}\");' /><input name='item_enable[]' type='hidden' value='0' />", rowId, rowId);
    html += "    </td>";
    html += "    <td>";
    html += "         <a href='javascript:addRow()' title='Thêm dòng mới'><img src='../resources/images/icons/add.png' alt='Add'></a>";
    html += String.format("         <a href='javascript:removeRow(\"{0}\")' title='Xóa dòng này'><img src='../resources/images/icons/cross.png' alt='Delete'></a>", rowId);
    html += "    </td>";
    html += "</tr>";
    
    $("#items_list").append(html);
    
    disableAutocomplete();
}

// Clear a row
function clearRow(id) {
}

// Remove a row
function removeRow(id) {
    $('#' + id).closest('tr').remove();
}

// Set value 0/1 depends on 'checked' property
function check_event(id) {
    var ctrlId = '#check_event_' + id;
    var val = 0;

    if ($(ctrlId).is(":checked")) {
        val = 1;
    }
    $(ctrlId).parent().find('input[name="item_enable[]"]').val(val);
}

// Site:
// http://joekuan.wordpress.com/2009/06/12/ajax-a-simplified-version-of-file-upload-form-using-iframe/
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
             // var json = eval("("+ret+")");
             var json = $.parseJSON(ret);

             /* Process data in json ... */
             var htmText = '';
             switch (json.result) {
                 case "error":
                     showNotification("error", json.message);
                     break;
 
                 case "success":
                 case "warning":
                     var htmlText = json.message;
                     if (json.detail.length != 0) {
                         for (i = 0; i < json.detail.length; i++) {
                             htmlText += String.format(
                                             "<br />&nbsp;&nbsp;• Loại chi phí chi tiết \"<span class='orange'>{0}</span>\": {1}",
                                             json.detail[i].name,
                                             json.detail[i].error);
                         }
 
                         showNotification("attention ", htmlText);
                     } else {
                         showNotification("information ", htmlText);
                     }
 
                     break;
             }
         } catch (err) {
             // Handle errors here
             showNotification('error', err);
         }

         frame.document.getElementsByTagName("body")[0].innerHTML = '';
     }
 }
}

//Reset form controls
function resetCtrl() {
     $('.error_icon').hide();
     
     // Clear events days list
     $('#items_list tr').not(':first').each(function() {
         $(this).remove();
     });
    
     // Clear notification
     $('#notification_msg').html('');
}

//Show notification message
function showNotification(type, message) {
     var html = "";
    
     html += "<div class='notification " + type + " png_bg'>";
     html += "    <div>";
     html += message;
     html += "    </div>";
     html += "</div>";
    
     $('#notification_msg').html(html);
}

var loading  = false; //to prevents multipal ajax loads

//Load sub items of a category
function loadItemByCategory(category_id) {
    // Clear items list
    $("#items_list").html("");
    
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Show loading icon
        $('#loading').show();
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/finance_management_server.php",
            type: 'POST',
            data: String.format('load_items_by_category={0}&category_id={1}', 'true', category_id),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $('#loading').hide();
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        // Set items
                        if (json.items.length != 0) {
                            for (i = 0; i < json.items.length; i++) {
                                var d = json.items[i];
                                
                                // Add to list (in table)
                                var rowId = d.id;
                                var html = "";
                                
                                html += String.format("<tr id='{0}'>", rowId);
                                html += "    <td>";
                                html += String.format("        <input name='item_id[]' type='hidden' value='{0}'>", d.id);
                                html += String.format("        <input name='item_name[]' class='text-input medium-input' style='width: 95% !important' type='text' value='{0}'>", d.name);
                                html += "    </td>";
                                html += "    <td>";
                                html += String.format("        <input type='checkbox' id='check_event_{0}' onclick='check_event(\"{1}\");' {2} /><input name='item_enable[]' type='hidden' value='{3}' />", 
                                                               rowId, 
                                                               rowId, 
                                                               (d.enable == 1) ? "checked='checked'" : "",
                                                               d.enable);
                                html += "    </td>";
                                html += "    <td>";
                                html += "         <a href='javascript:addRow()' title='Thêm dòng mới'><img src='../resources/images/icons/add.png' alt='Add'></a>";
                                // html += String.format("         <a href='javascript:removeRow(\"{0}\")' title='Xóa dòng này'><img src='../resources/images/icons/cross.png' alt='Delete'></a>", rowId);
                                html += "    </td>";
                                html += "</tr>";
                                
                                $("#items_list").append(html);
                                
                                disableAutocomplete();
                            }
                        }
                    } else {
                        // Do nothing
                    }
                    
                    loading = false; 
                }
                catch(err) {
                    //Handle errors here
                    $('#loading').hide();
                    
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
                
                loading = false; 
            }
        });
    }
}

// Validate data
function checkValid() {
    var isValid = true;

    $(".error_icon").hide();

    if ($("#category_id").val() == "") {
        $("#category_id").parent().find(".error_icon").show();
        isValid = false;
    }
    
    if ($("#category_name").val() == "") {
        $("#category_name").parent().find(".error_icon").show();
        isValid = false;
    }

    return isValid;
}

// DOM load
$(function() {
    disableAutocomplete();
    
    // Allow only alphanumeric characters 
    $('.alphanumeric').alphanumeric();
    
    // Reset
    $('#reset').click(function() {
        resetCtrl();
        return true;
    });
    
    // form submit
    $("#frm-add-category").submit(function() {
        return checkValid();
    });
    $("#frm-update-category").submit(function() {
        return checkValid();
    });
});