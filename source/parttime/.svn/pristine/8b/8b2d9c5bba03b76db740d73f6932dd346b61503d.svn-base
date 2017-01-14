// Enable/Disable next schedule date
function enableNextSchedule(enable) {
    if(!enable) {
        $("#next_schedule").attr("disabled", "disabled"); 
        $("#note").attr("disabled", "disabled"); 
        $("#schedule_control").hide();
    }
    else {
        $("#next_schedule").removeAttr("disabled"); 
        $("#note").removeAttr("disabled"); 
        $("#schedule_control").show();
    }
}

// Reset form controls
function resetCtrl(all) {
    // $('#next_schedule').val("");
    // $('#note').val("");
    // if (all) {
    //     $('#contact_content').val("");
    //     $('#cancelled').removeAttr("checked");
    // }
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
                // Refresh the page
                if (json.result == "success") {
                    $('#contact_content').val('');

                    var reload = json.reload;
                    if (reload == 1) {
                        // Reload page
                        ReloadPage();
                        return -1;
                    }
                }
                
                // Reset controls
                resetCtrl(true);
                
                // Show notification message
                var type = "error";
                if (json.result == "success") {
                    type = "information";
                }
                showNotification(type, json.message);
                
                // Update history items list
                if (json.data != "") {
                    var item = json.data;
                    
                    var htmlText = "";
                    htmlText += String.format("<div class='notification information png_bg'><div><span class='blue-violet'>{0}</span><br>{1}</div></div>", 
                                              item.title,
                                              item.content);
                    
                    // Add to items list
                    $('#history').append(htmlText);
                }
            } catch (err) {
                // Handle errors here
                // Reset controls
                resetCtrl(true);
                
                showNotification('error', err);
            }

            frame.document.getElementsByTagName("body")[0].innerHTML = '';
        }
    }
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

// Show history loading
function showHistoryLoading() {
    var html = "";
    
    html += "<center><img src='../resources/images/loadig_big.gif' alt='loading' /></center>";
    
    // Set html content
    $('#history').html(html);
}

// Hide history loading
function hideHistoryLoading() {
    // Set html content
    $('#history').html("");
}

// Show history loading message
function showHistoryNotification(type, message) {
    var html = "";

    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";

    $('#history').html(html);
}

function registerGuestEmail(email, name) {

    $.ajax({
        url: "../email/maillistfunction.php",
        type: 'POST',
        data: String.format('email={0}&name={1}&listid={2}',email,name,$('#listid').val()),
        success: function (data, textStatus, jqXHR) {
            var json = jQuery.parseJSON(data);
            if(json.result == 1) {
                $('#listid').prop("disabled", true);
                $('#listRegister').prop("hidden", true);
                showChangeScheduleNotification('info', 'Day ky email marketing thanh cong');
            } else {
                showChangeScheduleNotification('error', 'Dang ky khong thanh cong: ' + json.message);
            }
        }
    })
}


function queryGuestEmail(guestid) {

    $.ajax({
        url: "../email/maillistfunction.php",
        type: 'POST',
        data: String.format('guestid={0}',guestid),
        success: function (data, textStatus, jqXHR) {
            var json = jQuery.parseJSON(data);
            if(json.result == 1) {
                $('#listid').prop("disabled", false);
                $('#listid').prop("hidden", false);
                $('#listRegister').prop("hidden", false);
                $('#listRegisterLabel').prop("hidden", false);
                for (i = 0; i < json.items.length; i++) {
                    var d = json.items[i];
                     $('#listid').append("<option value='" + d.id + "'>" + d.name +  "</option>")
                }
            } else {
                $('#listid').prop("hidden", false);
                $('#listRegisterLabel').prop("hidden", false);
                $('#listRegisterLabel').text("Đã đăng ký vào danh sách");
                var d = json.items[0];
                $('#listid').append("<option value='" + d.id + "' selected>" + d.name +  "</option>")
            }
            
        }
    })
}

// Load contact history items
function loadHistory(guest_id) {
    // Show loading
    showHistoryLoading();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/guest_development.php",
        type: 'POST',
        data: String.format('load_history={0}&guest_id={1}', 'true', guest_id),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                hideHistoryLoading();
                // Process data
                var json = jQuery.parseJSON(data);
                if(json.result == "success") {
                    if (json.items.length != 0) {
                        for (i = 0; i < json.items.length; i++) {
                            var d = json.items[i];
                            
                            var htmlText = "";
                            htmlText += String.format("<div class='notification information png_bg'><div><span class='blue-violet'>{0}</span><br>{1}</div></div>", 
                                                      d.title,
                                                      d.content);
                            
                            // Add to items list
                            $('#history').append(htmlText);
                        }
                    }
                } else {
                    showHistoryNotification('error', json.message);
                }
            }
            catch(err) {
                //Handle errors here
                hideHistoryLoading();
                showHistoryNotification('error', err);
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
            hideHistoryLoading();
            showHistoryNotification('error', errorThrown);
        }
    });
}

// Show change date loading
function showChangeScheduleLoading() {
    $("#save_new_schedule").hide();
    $("#save_loading").show();
}

// Hide change date loading
function hideChangeScheduleLoading() {
    $("#save_new_schedule").show();
    $("#save_loading").hide();
}

// Show change date loading message
function showChangeScheduleNotification(type, message) {
    alert(message);
    $("#change_schedule").val("");
}

// Change contact schedule
function saveNewSchedule() {
    // Show loading
    showChangeScheduleLoading();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/guest_development.php",
        type: 'POST',
        data: String.format('change_contact_schedule={0}&guest_id={1}&last_schedule_date={2}&last_schedule_id={3}&next_schedule={4}', 
                            'true', 
                            $('#guest_id').val(), 
                            $('#last_schedule_date').val(),
                            $('#last_schedule_id').val(),
                            $('#change_schedule').val()
                            ),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                hideChangeScheduleLoading();
                // Process data
                var json = jQuery.parseJSON(data);
                if(json.result == "success") {
                    var reload = json.reload;
                    if (reload == 1) {
                        // Reload page
                        ReloadPage();
                        return -1;
                    }
                } else {
                    showChangeScheduleNotification('error', json.message);
                }
            }
            catch(err) {
                //Handle errors here
                hideChangeScheduleLoading();
                showChangeScheduleNotification('error', err);
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
            hideChangeScheduleLoading();
            showChangeScheduleNotification('error', errorThrown);
        }
    });
}

var globalResult = [];

function queryCalendar(m, y, callback) { 
  start = new Date(y,m,1);
  end = new Date(y,m+1,0);
  var Start = $.datepicker.formatDate('yy-mm-dd', start);
  var End = $.datepicker.formatDate('yy-mm-dd', end);

   var data = {'start': Start, 'end': End};
   $.ajax({
       url: '../ajaxserver/guest_development_events_datepicker.php',
       type: 'POST',
       dataType: 'text',
       data: data,
       async:false,
       success: function(result) {
           globalResult = result;
           callback(result);
       }
   });
}

function loadPageVar (sVar) {
  return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(sVar).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
}

function validateRegister() {
    if (! $('#listid').is(':disabled')) {
        var c = confirm("Khach chua dang ky email marketing, ban co muon tiep tuc ?");
        return c;
    } else {
        return true;
    }
}
// DOM load
$(function() {
    // Disable autocomplete
    $('#listid').prop("disabled", true);
    $('#listid').prop("hidden", true);
    $('#listRegister').prop("hidden", true);
    $('#listRegisterLabel').prop("hidden", true);
    disableAutocomplete();
    var gid = loadPageVar("i");
    queryGuestEmail(gid);
    $(".date-picker").datepicker({
        minDate: 0,
        changeMonth : true,
        changeYear : true,
        firstDay: 1,
        dayNamesMin: ['C', 'H', 'B', 'T', 'N', 'S', 'B'],
        monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        dateFormat: "yy-mm-dd",
        beforeShowDay: highlightDays, 
        beforeShow: function() {
            var d = new Date();
            var m = d.getMonth(); //current month
            var y = d.getFullYear(); //current year
            queryCalendar(m, y, function(result) {
            });
        },
        onChangeMonthYear: function(y, m) {
            queryCalendar(m-1, y, function(result) {
            });
        }
    });


    $("#cancelled").click(function() {
        enableNextSchedule(!$(this).is(":checked"));
    });
    
    // Load history items
    loadHistory($('#guest_id').val());
});


function highlightDays(date) {
    var arr = JSON.parse(globalResult);
    var match = false;
    var datef = $.datepicker.formatDate('yy-mm-dd', date);
    for (var i = 0, len = arr.length; i < len; i++) {
        if (arr[i].start === datef) {              
            return [true, "highlight-" + arr[i].color, "Co " + arr[i].total + " hen!"];
            break;
        }
    }
    return [true, "", ""];
} 

