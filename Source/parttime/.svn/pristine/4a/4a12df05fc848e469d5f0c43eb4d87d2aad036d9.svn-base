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
    
    // Nhân viên: worker
    if($('#worker').val() == null || $('#worker').val() == "") {
        $('#error_worker').show();
        isValid = false;
    } else {
        $('#error_worker').hide();
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
       /* Convert from JSON to Javascript object */
       try {
            //var json = eval("("+ret+")");
            var json = $.parseJSON(ret);
            
            /* Process data in json ... */
            var htmText = '';
            
            $('#upload_notification').show();
            $("#upload_notification").removeAttr("style");
            // Update
            if (getActionName() == 'update') {
                htmText = json.message;
                
                if(json.result == 0) {
                    $('#upload_notification').addClass('error').removeClass('information');
                    if(json.detail != '') {
                        htmText += json.detail.replace(/@/g, "<").replace(/#/g, ">");
                    }
                }
                else {
                    $('#upload_notification').addClass('information').removeClass('error');
                }
                
                $('#upload_notification').show();
                $('#upload_message').html(htmText);
            }
            // Reject
            if (getActionName() == 'reject') {
                htmText = json.message;
                
                if(json.result == 0) {
                    $('#upload_notification').addClass('error').removeClass('information');
                    if(json.detail != '') {
                        htmText += json.detail.replace(/@/g, "<").replace(/#/g, ">");
                    }
                    
                    $('#upload_notification').show();
                    $('#upload_message').html(htmText);
                }
                else {
                    //$('#upload_notification').addClass('information').removeClass('error');
                    var url = '../working_calendar/approve-calendar.php';
                    window.location = url;
                }
            }
            // Approve
            if (getActionName() == 'approve') {
                if(json.result == 0) {
                    $('#upload_notification').addClass('error').removeClass('information');
                    
                    htmText = json.message;
                    if(json.detail != '') {
                        htmText += json.detail.replace(/@/g, "<").replace(/#/g, ">");
                    }
                    
                    $('#upload_notification').show();
                    $('#upload_message').html(htmText);
                }
                else {
                    if(json.detail != '') {
                        $('#upload_notification').addClass('information').removeClass('error');
                        
                        htmText = String.format("<span class='blue-violet'>{0}</span><br />", json.message);
                        htmText += json.detail.replace(/@/g, "<").replace(/#/g, ">");
                        
                        $('#upload_notification').show();
                        $('#upload_message').html(htmText);
                    } else {
                        var url = '../working_calendar/approve-calendar.php';
                        window.location = url;
                    }
                }
            }
       }
       catch(err) {
           //Handle errors here
           $('#upload_notification').addClass('error').removeClass('information').html(err);
       }
     }
  }
}

// Reset form controls
function resetCtrl() {
    // Clear 'branch' list
    $('#branch').val(''); // Clear all selected values
    $('#branch').trigger("chosen:updated");
    
    // Clear 'worker' list
    $('#worker').val(''); // Clear all selected values
    $('#worker').trigger("chosen:updated");
    
    // Clear leave days list
    $('#leave_days_list tr').not(':first').each(function() {
        $(this).remove();
    });
}

function setActionName(name) {
    $('#action').val(name);
}

function getActionName() {
    return $('#action').val();
}

// DOM load
$(function() {    
    //$('#upload_notification').hide();
    
    // Update action name
    $('#update').click(function() {
        setActionName('update');
    });
    $('#approve').click(function() {
        setActionName('approve');
    });
    $('#reject').click(function() {
        setActionName('reject');
    });
    
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
            return confirm('Bạn có chắc không?');
        }
        return false;
    });
});