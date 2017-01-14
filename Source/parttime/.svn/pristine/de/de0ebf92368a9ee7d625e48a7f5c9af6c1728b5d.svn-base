var countId = 0;

function addRow() {
    countId++;
    $('#leave_days_list').append(
                                 '<tr><td>' + 
                                    '<input name="leave_days[]" class="text-input small-input date-picker" style="width: 150px !important" readonly type="text" value="">' + 
                                 '</td><td>' + 
                                    '<input name="leave_days_note[]" class="text-input medium-input" style="width: 95% !important" type="text" value="">' + 
                                 '</td><td>' + 
                                    '<a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>' + 
                                    //'<a id="clear_' + countId + '" href="javascript:clearRow(\'clear_' + countId + '\')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>' + 
                                    '<a id="remove_' + countId + '" href="javascript:removeRow(\'remove_' + countId + '\')" title="Xóa dòng này"><img src="../resources/images/icons/cross.png" alt="Delete"></a>' +
                                 '</td></tr>');
    $(".date-picker").datepicker({
        //minDate: +0,
        changeMonth: true,
        changeYear: true
    });
}

function clearRow(id) {
    $('#' + id).closest('tr').find("input[type='text']").each(function(index, e) {
        $(e).val('');
    });
}

function removeRow(id) {
    $('#' + id).closest('tr').remove();
}

// Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    $('.error_icon').hide();
    
    // Kho hàng chi nhánh: branch
    if($('#branch').val() == null || $('#branch').val() == "") {
        $('#error_branch').show();
        isValid = false;
    } else {
        $('#error_branch').hide();
        isValid = isValid && true;
    }
    
    // Từ ngày: from_date
    if($('#from_date').val().trim() == "") {
        $('#error_from_date').show();
        isValid = false;
    } else {
        $('#error_from_date').hide();
        isValid = isValid && true;
    }
    
    // Đến ngày: to_date
    if($('#to_date').val().trim() == "") {
        $('#error_to_date').show();
        isValid = false;
    } else {
        $('#error_to_date').hide();
        isValid = isValid && true;
    }
    
    if(!isValid)
        $('#attention').show();
    else
        $('#attention').hide();

    return isValid;
}

//Kiem tra tinh hop le cua cac thong tin lien quan nhan vien
function validateWorkerData() {
    
    // Danh sach nhan vien
    if($('#worker').val() == null || $('#worker').val() == "") {
        return false;
    }
    
    // Chon cac ngay lam viec
    var choosed = false;

    $("#add_new_worker").find("input[type='checkbox']").each(function(index, e) {
        if($(e).attr("checked") == "checked") {
            choosed = choosed || true;
        }
    });

    if(!choosed) {
        return false;
    }
    
    return true;
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
                     showNotification("information ", json.message);
                     break;
                     
                 case 2:
                     if(json.detail != '') {
                         htmText = json.detail.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#").replace(/P#/g, "%");
                     }
                     $('#demo').html(htmText);
                     $('#actions_panel').show();
                     break;
             }
        }
        catch(err) {
             //Handle errors here
             showNotification('error', err);
        }
      }
   }
 }

function addWorkerDone(name) {
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
             switch(eval(json.result)) {
                 case 1:
                     var detail = json.detail[0];
                     var row_id = '#' + detail.row;
                     
                     $(row_id).find("td[col_name='mon']").each(function(index, e) {
                         $(e).html($(e).html() + detail.mon.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                     });
                     $(row_id).find("td[col_name='tue']").each(function(index, e) {
                         $(e).html($(e).html() + detail.tue.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                     });
                     $(row_id).find("td[col_name='wed']").each(function(index, e) {
                         $(e).html($(e).html() + detail.wed.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                     });
                     $(row_id).find("td[col_name='thu']").each(function(index, e) {
                         $(e).html($(e).html() + detail.thu.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                     });
                     $(row_id).find("td[col_name='fri']").each(function(index, e) {
                         $(e).html($(e).html() + detail.fri.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                     });
                     $(row_id).find("td[col_name='sat']").each(function(index, e) {
                         $(e).html($(e).html() + detail.sat.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                     });
                     $(row_id).find("td[col_name='sun']").each(function(index, e) {
                         $(e).html($(e).html() + detail.sun.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                     });
                     
                     // Close dialog
                     jQuery(document).trigger('close.facebox');
                     
                     break;
                     
                 default:
                     // Close dialog
                     jQuery(document).trigger('close.facebox');
                     break;
             }
        }
        catch(err) {
            //Handle errors here
            // Close dialog
            jQuery(document).trigger('close.facebox');
        }
        
        frame.document.getElementsByTagName("body")[0].innerHTML = '';
      }
   }
 }

function deleteWorker(ctrl_id, row_id, cal_uid, plan_uid, wday, date, branch) {
    var orgImg = $('#' + ctrl_id).find("img").attr('src');
    $('#' + ctrl_id).find("img").attr('src', '../resources/images/loading.gif');
    
    // Gửi yêu cầu ajax thu tiền
    $.ajax({
        url : "../ajaxserver/working_calendar_add_new.php",
        type : 'POST',
        //contentType: "application/json; charset=utf-8",
        //dataType: "json",
        data : String.format('delete_workers={0}&row_id={1}&cal_uid={2}&plan_uid={3}&wday={4}&date={5}&branch={6}', 'true', row_id, cal_uid, plan_uid, wday, date, branch), 
        success : function(data, textStatus, jqXHR) {
            var obj = jQuery.parseJSON(data);
            
            if(obj.result == 1) {
                var detail = obj.detail;
                row_id = '#' + row_id;
                
                switch(wday) {
                    case 'mon':
                        $(row_id).find("td[col_name='mon']").each(function(index, e) {
                            $(e).html(detail.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                        });
                        break;
                        
                    case 'tue':
                        $(row_id).find("td[col_name='tue']").each(function(index, e) {
                            $(e).html(detail.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                        });
                        break;
                        
                    case 'wed':
                        $(row_id).find("td[col_name='wed']").each(function(index, e) {
                            $(e).html(detail.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                        });
                        break;
                        
                    case 'thu':
                        $(row_id).find("td[col_name='thu']").each(function(index, e) {
                            $(e).html(detail.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                        });
                        break;
                        
                    case 'fri':
                        $(row_id).find("td[col_name='fri']").each(function(index, e) {
                            $(e).html(detail.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                        });
                        break;
                        
                    case 'sat':
                        $(row_id).find("td[col_name='sat']").each(function(index, e) {
                            $(e).html(detail.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                        });
                        break;
                        
                    case 'sun':
                        $(row_id).find("td[col_name='sun']").each(function(index, e) {
                            $(e).html(detail.replace(/@/g, "<").replace(/#/g, ">").replace(/%/g, "#"));
                        });
                        break;
                }
            } else {
                $('#' + ctrl_id).find("img").attr('src', orgImg);
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
            $('#' + ctrl_id).find("img").attr('src', orgImg);
        }
    });

}

// Reject plan calendar
function approvePlan(action, plan_uid) {
    var requestData = '';
    switch(action) {
        case 'approve':
            requestData = String.format('approve={0}&plan_uid={1}', 'true', plan_uid);
            break;
            
        case 'reject':
            requestData = String.format('reject={0}&plan_uid={1}', 'true', plan_uid);
            break;
    }
    
    // Show loading
    $('#actions_loading').show();
    
    // Gửi yêu cầu ajax thu tiền
    $.ajax({
        url : "../ajaxserver/working_calendar_add_new.php",
        type : 'POST',
        //contentType: "application/json; charset=utf-8",
        //dataType: "json",
        data : requestData,
        success : function(data, textStatus, jqXHR) {
            $('#actions_loading').hide();
            
            var obj = jQuery.parseJSON(data);
            if(obj.result == 1) {
                var url = '../working_calendar/approve-calendar.php';
                window.location = url;
            } else {
                showNotification('error', obj.message);
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
            $('#actions_loading').hide();
        }
    });

}

// Reset form controls
function resetCtrl() {
    // Clear 'branch' list
    $('#branch').val(''); // Clear all selected values
    $('#branch').trigger("chosen:updated");
}

//Show loading panel
function showLoading() {
    var html = "";
    
    html += "<div id='example_wrapper' class='dataTables_wrapper' role='grid'>";
    html += "    <div id='example_processing' class='dataTables_processing' style='visibility: visible;'>";
    html += "        <img src='../resources/images/loading54.gif' alt='loading' />";
    html += "        Processing...";
    html += "    </div>";
    html += "    <div class='clear'></div>";
    html += "</div>";
    
    $('#demo').html(html);
}

// Show notification message
function showNotification(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    $('#demo').html(html);
}

function setInputData(plan_uid, week_description, branch, branch_name, start_date, row_id) {
    //alert(s);
    $('#week_description').text(week_description);
    $('#dest_branch').val(branch);
    $('#branch_name').text(branch_name);
    $('#start_date').val(start_date);
    $('#dest_plan_uid').val(plan_uid);
    $('#row_id').val(row_id);
}

// DOM load
$(function() {
    // Reset
    $('#reset').click(function() {
        resetCtrl();
        
        return true;
    });
    
    // datepicker
    var dates = $("#from_date, #to_date").datepicker({
        //minDate: +0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            /*var option = this.id == "from_date" ? "minDate" : "maxDate",
                instance = $( this ).data( "datepicker" ),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );*/
        }
    });
    
    $(".date-picker").datepicker({
        //minDate: +0,
        changeMonth: true,
        changeYear: true
    });
    
    $('#add_new_calendar').submit(function() {
        if(validateData()) {
            var check = true;
            //var check = confirm('Bạn có chắc không?');
            
            if(check) {
                showLoading();
            }
            return check;
        }
        return false;
    });
    
    var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
          };
          for (var selector in config) {
            $(selector).chosen(config[selector]);
          }
    
    $('#add_new_worker').submit(function() {
        alert('zzzz');
        if(validateWorkerData()) {
            return true;
        }
        return false;
    });
    
    // Request get plan detail
    $('#plan_detail').submit(function() {
        showLoading();
        return true;
    });
    $('#plan_detail').submit();
});