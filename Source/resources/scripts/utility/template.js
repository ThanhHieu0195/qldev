// Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    $('.error_icon').hide();
    // Title
    if($('#title').val().trim() == "") {
    	$('#error_title').show();
    	isValid = false;
    } else {
    	$('#error_title').hide();
    	isValid = isValid && true;
    }
    // Content
    if($('#content').val().trim() == "") {
    	$('#error_content').show();
    	isValid = false;
    } else {
    	$('#error_content').hide();
    	isValid = isValid && true;
    }
    // Has detail
    /*if($('#has_detail').is(":checked")) {
    	if($('#detail_list').val().trim() == "") {
        	$('#error_detail_list').show();
        	isValid = false;
        } else {
        	$('#error_detail_list').hide();
        	isValid = isValid && true;
        }
    }*/
    
    if(!isValid)
    	$('#attention').show();
    else
    	$('#attention').hide();

    return isValid;
}

function addRow() {
    countId++;
    $('#task_detail_list').append(
                                 '<tr><td>' + 
                                    '<input name="detail_list[]" class="text-input medium-input" style="width: 95% !important" type="text" value="">' + 
                                 '</td><td>' + 
                                    '<a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>' + 
                                    '<a id="remove_' + countId + '" href="javascript:removeRow(\'remove_' + countId + '\')" title="Xóa dòng này"><img src="../resources/images/icons/cross.png" alt="Delete"></a>' +
                                 '</td></tr>');
}

function clearRow(id) {
    $('#' + id).closest('tr').find("input[type='text']").each(function(index, e) {
        $(e).val('');
    });
}

function removeRow(id) {
    $('#' + id).closest('tr').remove();
}

//Site: http://joekuan.wordpress.com/2009/06/12/ajax-a-simplified-version-of-file-upload-form-using-iframe/
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
             switch(eval(json.result)) {
                 case 0:
                     showNotification("error", json.message);
                     break;
                     
                 case 1:
                     var htmlText = json.message;
                     if (json.detail.length != 0) {
                         
                         if (eval(json.flag) == 1) {
                             for (i = 0; i < json.detail.length; i++) {
                                 htmlText += String.format("<br />&nbsp;&nbsp;• <span class='orange'>{0}</span>: {1}", 
                                                           json.detail[i].content, 
                                                           json.detail[i].error);
                             }
                         } else {
                             for (i = 0; i < json.detail.length; i++) {
                                 htmlText += String.format("<br />&nbsp;&nbsp;• Nội dung \"<span class='orange'>{0}</span>\": {1}", 
                                                           json.detail[i].content, 
                                                           json.detail[i].error);
                             }
                         }
                         
                         showNotification("attention ", htmlText);
                     } else {
                         // 
                         showNotification("information ", htmlText);
                     }
                     
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
    // Clear detail list
    $('#task_detail_list tr').not(':first').each(function() {
        $(this).remove();
    });
    
    $('#title').val('');
    $('#content').val('');
}

 // Show notification message
function showNotification(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    $('#notification_msg').html(html);
}

//Reject plan calendar
function deleteTemplate(template_id) {
    if (!confirm('Bạn có chắc chắn muốn xóa mẫu này?')) {
        return;
    }
    
    var requestData = String.format('delete_template={0}&template_id={1}', 'true', template_id);
    var orgImg = $('#delete_template_' + template_id).html();
    var loadingImg = "<img src='../resources/images/loading.gif' alt='loading' />";
    
    // Show loading
    $('#delete_template_' + template_id).html(loadingImg);
    
    // Gửi yêu cầu ajax
    $.ajax({
        url : "../ajaxserver/task_create_task.php",
        type : 'POST',
        //contentType: "application/json; charset=utf-8",
        //dataType: "json",
        data : requestData,
        success : function(data, textStatus, jqXHR) {
            var obj = jQuery.parseJSON(data);
            
            if(obj.result == 1) {
                // Refresh datatable
                $('#example').dataTable()._fnAjaxUpdate();
            } else {
                $('#delete_template_' + template_id).html(orgImg);
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
            $('#delete_template_' + template_id).html(orgImg);
        }
    });

}

// DOM load
$(function() {
	
    //$('#detail_list_panel').hide();
    $('.error_icon').hide();
    $('#attention').hide();
    
    /*$('#has_detail').change(function() {
    	if($(this).is(":checked"))
    		$('#detail_list_panel').show();
    	else
    		$('#detail_list_panel').hide();
    });
    
    $('#has_detail').change();*/
    
    $('#create_template').submit(function() {
        if(validateData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    });
    
    // Update template
    $('#update_template').submit(function() {
        if(validateData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    });
    
    $('#reset').click(function() {
        resetCtrl();
        
        return true;
    });
});