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

function showTemplateList(showed) {
    if(showed) {
        // Form controls
        createFromTemplate();
        // Datatable
        //$('#example').dataTable().fnClearTable();
        //$('#example').dataTable().fnDestroy();
        $('#example').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bPaginate": true,
            "bFilter": true,
            "bSort": true,
            "sAjaxSource": "../ajaxserver/template_list_server.php",
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], // <-- Page length options
            "aoColumnDefs": [
                { "sClass": "center", "aTargets": [ 0, 3 ] },
                { bSortable: false, aTargets: [ 0, 2, 3 ] } // <-- gets columns and turns off sorting
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                $('td:eq(0)', nRow).html(aData[0]);
                $('td:eq(1)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[1]));
                $('td:eq(2)', nRow).html(String.format("<span class=''>{0}</span>", aData[2]));
                $('td:eq(3)', nRow).html(String.format("<input type='radio' style='cursor: pointer;' name='template_select' onclick='selectTemplate(\"{0}\")' value='{1}' />", aData[3], aData[3]));
            }
        });
        // Hien thi dialog
        $("#template_panel").dialog("open");
    } else {
        // Form controls
        createNew();
    }
}

function selectTemplate(id) {
    // Do nothing
}

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
    // Assign to
    if($('#assign_to').val() == null || $('#assign_to').val() == "") {
        $('#error_assign_to').show();
        isValid = false;
    } else {
        $('#error_assign_to').hide();
        isValid = isValid && true;
    }
    // Deadline
    if($('#deadline').val() == null || $('#deadline').val() == "") {
        $('#error_deadline').show();
        isValid = false;
    } else {
        $('#error_deadline').hide();
        isValid = isValid && true;
    }
    // Repeat
    if($('#repeat_yes').is(":checked")) {
        // Repeat times
        if($('#repeat_times').val() == null 
                || $('#repeat_times').val() == "" 
                || eval($('#repeat_times').val()) == 0) {
            $('#error_repeat_times').show();
            isValid = false;
        } else {
            $('#error_repeat_times').hide();
            isValid = isValid && true;
        }
        // Repeat by weekly
        if($('#repeat_by_weekly').is(":checked")) {
            if($('#weekly').val() == "") {
                $('#error_weekly').show();
                isValid = false;
            } else {
                $('#error_weekly').hide();
                isValid = isValid && true;
            }
        }
        // Repeat by monthly
        if($('#repeat_by_monthly').is(":checked")) {
            if($('#monthly').val() == "") {
                $('#error_monthly').show();
                isValid = false;
            } else {
                $('#error_monthly').hide();
                isValid = isValid && true;
            }
        }
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
                     if (json.warning.length != 0) {
                         htmlText += "<br><span class='blue-violet'>Tuy nhiên có một số email thông báo công việc cho nhân viên chưa được gửi do lỗi như sau:</span>";
                         
                         for (i = 0; i < json.warning.length; i++) {
                             htmlText += String.format("<br />&nbsp;&nbsp;• Nhân viên <span class='orange'>{0}</span> - email <span class='orange'>{1}</span>: {2}", 
                                                       json.warning[i].name, 
                                                       json.warning[i].email, 
                                                       json.warning[i].error);
                         }
                     }
                     
                     showNotification("information ", htmlText);
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
    $('#assign_to').val(''); // Clear all selected values
    $('#assign_to').trigger("chosen:updated");
   
    $('#repeat_panel').hide();
    // Clear detail list
    $('#task_detail_list tr').not(':first').each(function() {
        $(this).remove();
    });
    
    $('#title').val('');
    $('#content').val('');
    $('#template_id').val('');
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

function createNew() {
    resetCtrl();
    
    //$('#title').removeAttr('readonly');
    $('#content').removeAttr('readonly');
    
    $('#task_detail_list').html(
            '<tr><td>' + 
               '<input name="detail_list[]" class="text-input medium-input" style="width: 95% !important" type="text" value="">' + 
            '</td><td>' + 
               '<a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a> ' + 
               '<a id="clear_0" href="javascript:clearRow(\'clear_0\')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>' +
            '</td></tr>');
    
    countId = 0;
}

function createFromTemplate() {
    //$('#title').attr('readonly', 'readonly');
    $('#content').attr('readonly', 'readonly');
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
    
    $('#detail_list_panel').hide();
    $('#repeat_panel').hide();
    $('#weekly').hide();
    $('.error_icon').hide();
    $('#attention').hide();
    showTemplateList(false);
    
    $('#has_detail').change(function() {
        if($(this).is(":checked"))
            $('#detail_list_panel').show();
        else
            $('#detail_list_panel').hide();
    });
    
    $('input[name=repeat]').click(function() {
        if($(this).val() == 1)
            $('#repeat_panel').show();
        else
            $('#repeat_panel').hide();
    });
    
    $('input[name=repeat_by]').click(function() {
        $('#weekly').hide();
        $('#monthly').hide();
        $('#error_weekly').hide();
        $('#error_monthly').hide();
        
        switch(eval($(this).val())) {
            case 2: // Weekly
                $('#weekly').show();
                break;
            case 3: // Monthly
                $('#monthly').show();
                break;
        }
    });
    
    $("#deadline").datepicker({
        minDate: +0,
        changeMonth: true,
        changeYear: true 
        });
    
    $("#repeat_times").numeric();
    $("#repeat_times").spinner({
        spin: function( event, ui ) {
            if ( ui.value < 1 ) {
              $( this ).spinner( "value", 1 );
              return false;
            } else if ( ui.value > 9999 ) {
              $( this ).spinner( "value", 9999 );
              return false;
            }
          }
        });
    
    $('#weekly').change(function() {
        if($(this).val() == "")
            $('#error_weekly').show();
        else
            $('#error_weekly').hide();
    });
    
    $('#reset').click(function() {
        createNew();
        
        return true;
    });
    
    $('#create_task').submit(function() {
        if(validateData()) {
            var checked = confirm('Bạn có chắc không?');
            if (checked) {
                showLoading();
            }
            
            return checked;
        }
        return false;
    });
    
    // Dialog
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );
    $("#template_panel").dialog({
        create: function(event, ui) {
        },
        closeOnEscape: false, // Disable close dialog with ESC key
        open: function(event, ui) { 
            $(".ui-dialog-titlebar-close", ui.dialog || ui).hide(); // Hide close button
        },
        dialogClass: 'fixed-dialog',
        autoOpen: false,
        height: 550,
        width: 800,
        modal: true,
        buttons: {
            Ok: function() {
                var template_id = '';
                $("#example").find("input[type='radio']").each(function(index, e) {
                    if($(e).attr("checked") == "checked") {
                        template_id = $(e).val();
                    }
                });
                // Load template
                if (template_id != "") {
                    loadTemplate(template_id);
                }
            },
            Cancel: function() {
                if ($('#template_id').val() != "") {
                } else {
                    $('#create_new').attr("checked", "checked");
                    createNew();
                }
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            $('#example').dataTable().fnDestroy();
        }
    });
});