// Create enable/disable button
function createButtonCtrl(role_id, enable) {
    var html = "";
    if(enable == 0) {
        html = String.format("<div id='enable_{0}'><a href='javascript:' onclick='enableRole(\"{1}\", {2})' title='Enable nhóm quyền này'> " +
                              "<img src='../resources/images/icons/user-male-add.png' alt='action' /></a></div>", role_id, role_id, 1);
    } else {
        html = String.format("<div id='enable_{0}'><a href='javascript:' onclick='enableRole(\"{1}\", {2})' title='Disable nhóm quyền này'> " +
                             "<img src='../resources/images/icons/user-male-delete.png' alt='action' /></a></div>", role_id, role_id, 0);
    }
    
    return html;
}

// Update enable/disable image icon
function updateImageIcon(ctrlId, enable) {
    if(enable == 0) {
        $(ctrlId).attr('src', '../resources/images/icons/user-male-delete.png');
        $(ctrlId).attr('title', 'Nhóm quyền đang disable');
    } else {
        $(ctrlId).attr('src', '../resources/images/icons/user-male-add.png');
        $(ctrlId).attr('title', 'Nhóm quyền đang enable');
    }
}


// Loading image
function createLoadingIcon() {
    return "<img alt=\"loading\" src=\"../resources/images/loading.gif\">";
}

// Thuc hien enable/disable nhom quyen
function enableRole(role_id, enable) {
    var imgCtrlId = "#status_" + role_id;
    var btnCtrlId = "#enable_" + role_id;
    var originalHtml = $(btnCtrlId).html();
    
    // Show loading
    $(btnCtrlId).html(createLoadingIcon());
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/account_role_group_server.php",
        type: 'POST',
        data: String.format('enable_role={0}&role_id={1}&enable={2}', 'true', role_id, enable),
        success: function (data, textStatus, jqXHR) {
            try {
                var obj = jQuery.parseJSON(data);
                switch(eval(obj.result)) {
                    case 1:  // Success
                        updateImageIcon(imgCtrlId, enable);
                        $(btnCtrlId).html(createButtonCtrl(role_id, enable));
                        break;
                    default:
                        $(btnCtrlId).html(originalHtml);
                }
            }
            catch(err) {
                //Handle errors here
                $(btnCtrlId).html(originalHtml);
           }
        },
        timeout: 5000,      // timeout (in miliseconds)
        error: function(qXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                // request timed out, do whatever you need to do here
            }
            else {
                // some other error occurred
            }
            $(btnCtrlId).html(originalHtml);
        }
    });
}

//Show loading panel
function showLoading() {
    var html = "";
    
    html += "<div id='example_wrapper' class='dataTables_wrapper' role='grid'>";
    html += "    <div id='example_processing' class='dataTables_processing' style='visibility: visible;'>";
    html += "        <img src='../resources/images/loading54.gif' alt='loading' />";
    html += "        Processing...";
    html += "    </div>";
    html += "    <div style='padding-bottom: 50px;'></div>";
    html += "</div>";
    
    return html;
}

//Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    $('.error_icon').hide();
    
    // Role Id
    if($('#role_id').val().trim() == "") {
        $('#error_role_id').show();
        isValid = false;
    } else {
        $('#error_role_id').hide();
        isValid = isValid && true;
    }
    
    // Role name
    if($('#role_name').val().trim() == "") {
        $('#error_role_name').show();
        isValid = false;
    } else {
        $('#error_role_name').hide();
        isValid = isValid && true;
    }
    
    if(!isValid)
        $('#attention').show();
    else
        $('#attention').hide();

    return isValid;
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
        
        var msgCtrlId = "#notification_msg";
        
        /* Convert from JSON to Javascript object */
        try {
             //var json = eval("("+ret+")");
             var json = $.parseJSON(ret);
             
             /* Process data in json ... */
             var htmText = '';
             switch(eval(json.result)) {
                 case 0:
                     $(msgCtrlId).html(showNotification("error", json.message));
                     break;
                     
                 case 1:
                     var htmlText = json.message;
                     if (json.warning.length != 0) {
                         htmlText += "<br><span class='blue-violet'>Tuy nhiên có một số quyền truy cập trên các chức năng chưa được thêm vào database do lỗi như sau:</span>";
                         
                         for (i = 0; i < json.warning.length; i++) {
                             htmlText += String.format("<br />&nbsp;&nbsp;• Function <span class='orange'>{0}</span>: {1}", 
                                                       json.warning[i].function_id, 
                                                       json.warning[i].error);
                         }
                     }
                     
                     $(msgCtrlId).html(showNotification("information ", htmlText));
                     break;
             }
        }
        catch(err) {
             //Handle errors here
            $(msgCtrlId).html(showNotification('error', err));
        }
        
        frame.document.getElementsByTagName("body")[0].innerHTML = '';
      }
   }
 }
 
//Reset form controls
function resetCtrl() {
    $('#role_id').val('');
    $('#role_name').val('');
    
    $('#function_list').find('input[type="checkbox"]').each(function() {
        $(this).removeAttr('checked');
    });
}

 // Show notification message
function showNotification(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    return html;
}

//Load function list
function loadFunctions(role_id) {
    var ctrlId = "#function_list";
    
    // Show loading
    $(ctrlId).html(showLoading());
    $('#control_panel').hide();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/account_role_group_server.php",
        type: 'POST',
        data: String.format('load_functions={0}&role_id={1}', 'true', role_id),
        success: function (data, textStatus, jqXHR) {
            try {
                var obj = jQuery.parseJSON(data);
                
                if(obj.result == 1) {
                    //var detail = obj.detail[0];
                    // Clear loading
                    $(ctrlId).html("");
                    
                    // Set values
                    if (obj.detail.length > 0) {
                        
                        $(ctrlId).html("<input type='checkbox' alt='check-all' id='check-all' onclick='checkAll(\"#check-all\");' title='Chọn/Bỏ chọn tất cả các chức năng' />");
                        
                        $(ctrlId).append("<hr />");
                        
                        for(i = 0; i < obj.detail.length; i++) {
                            // Get a group
                            var g = obj.detail[i];
                            
                            // Create group tile
                            $(ctrlId).append(String.format("<p><label class=''>{0}</label><br />", g.group_name));
                            
                            // Create check boxes for functions
                            for(j = 0; j < g.functions.length; j++) {
                                var f = g.functions[j];
                                $(ctrlId).append(String.format("&nbsp;&nbsp;<input type='checkbox' name='function[]' title='{0}' value='{1}' {2} />{3}", 
                                                                f.note, f.function_id, (f.checked == 1) ? "checked='checked'" : "", f.function_name));
                            }
                            
                            // Close a group title
                            $(ctrlId).append("</p><div class='clear'></div>");
                        }
                        $(ctrlId).append("<hr />");
                    }
                    
                    // Tooltip
                    $('input[type="checkbox"]').tooltip();
                    
                    // Show/Hide action panel
                    if (obj.flag == 1) {
                        $('#control_panel').show();
                    } else {
                        $('#control_panel').hide();
                    }
                    
                } else {
                    $(ctrlId).html(showNotification('error', obj.message));
                }
            }
            catch(err) {
                //Handle errors here
                $(ctrlId).html(showNotification('error', err));
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
            $(ctrlId).html(showNotification('error', errorThrown));
        }
    });
}

// Check all check box controls
function checkAll(ctrlId) {
    if($(ctrlId).attr("checked") == "checked") {
        $('#function_list').find('input[type="checkbox"]').each(function() {
            $(this).attr('checked', 'checked');
        });
    } else {
        $('#function_list').find('input[type="checkbox"]').each(function() {
            $(this).removeAttr('checked');
        });
    }
}

//DOM load
$(function() {
    
    // Error icons
    $('.error_icon').hide();
    $('#attention').hide();
    
    // Reset form
    $('#reset').click(function() {
        resetCtrl();
    });
    
    // Pre-submit events
    $('#create_role').submit(function() {
        if(validateData()) {
            if (confirm("Bạn có chắc không?")) {
                $("#notification_msg").html(showLoading());
                
                return true;
            }
            return false;
        }
        
        return false;
    });
    
    loadFunctions($('#role_id').val());
});