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
    
    $('#notification_msg').html(html);
}

// Update data table
function updateDataTable() {
    $('#example').dataTable()._fnAjaxUpdate();
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
                             if(d.product == "") {
                                 htmlText += String.format("<br />&nbsp;&nbsp;• <span class='orange'>{0}</span>", 
                                         d.error);
                             } else {
                                 htmlText += String.format("<br />&nbsp;&nbsp;• Sản phẩm <span class='orange'>{0}</span> - Số lượng chuyển <span class='orange'>{1}</span>: {2}", 
                                                           d.product, 
                                                           d.amount, 
                                                           d.error);
                             }
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
        }
        
        frame.document.getElementsByTagName("body")[0].innerHTML = '';
      }
   }
 }
 
//Reset form controls
function resetCtrl() {
}

// Show notification message
// type: 'attention', 'success', 'error'
function showNotification(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    $('#notification_msg').html(html);
}

function loadTemplate(id) {
    if (id != '') {
        // Loading
        showLoadingIcon();

        // Gửi yêu cầu ajax
        $.ajax({
            url : "../ajaxserver/task_create_task.php",
            type : 'POST',
            //contentType: "application/json; charset=utf-8",
            //dataType: "json",
            data : String.format('load_template={0}&template_id={1}', 'true', id), 
            success : function(data, textStatus, jqXHR) {
                var obj = jQuery.parseJSON(data);
                
                if(obj.result == 1) {
                    var detail = obj.detail[0];
                    // Set values
                    $('#title').val(obj.title);
                    $('#content').val(obj.content);
                    $('#task_detail_list').html('');
                    if (obj.detail.length > 0) {
                        for(i = 0; i < obj.detail.length; i++) {
                            $('#task_detail_list').append(
                                    '<tr><td>' + 
                                       String.format('<input name="detail_list[]" class="text-input medium-input" style="width: 100% !important" type="text" value="{0}">', obj.detail[i]) + 
                                    '</td><td></td></tr>');
                        }
                        $('#task_detail_list').find('input[type="text"]').attr('readonly', 'readonly');
                    }
                    $('#template_id').val(id);
                    
                    hideLoadingIcon();
                    
                    // Close the dialog
                    $('#template_panel').dialog( "close" );
                } else {
                    alert(obj.message);
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
                alert(errorThrown);
            }
        });
    }

}

function showLoadingIcon() {
    var btnpane = $("div.ui-dialog-buttonpane");
    //prevent bad things if create is clicked multiple times
    var there = btnpane.find("#ajax-loader").size() > 0;
    if(!there) {
        $("#ajax-loader").clone(true).appendTo(btnpane).show();
    }
}

function hideLoadingIcon() {
    var btnpane = $("div.ui-dialog-buttonpane");
    btnpane.find("#ajax-loader").remove();
}

// DOM load
$(function() {
    $('#attention').hide();
    
    $('#itemofstore').submit(function() {
        if(checkData()) {
            showLoading();
            
            return true;
        }
        
        return false;
    });
});