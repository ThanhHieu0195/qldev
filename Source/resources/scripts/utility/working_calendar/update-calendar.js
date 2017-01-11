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
                        htmText = json.detail.replace(/@/g, "<").replace(/#/g, ">");
                    }
                    $('#demo').html(htmText);
                    /*$('.display').dataTable({
                        "bProcessing": true,
                        "bPaginate": false,
                        "bSort": false,
                        "bFilter": false,
                        "bServerSide": false,
                        "bAutoWidth" : false,
                        "aoColumns": [
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' },
                            { sWidth: '20%' }
                        ],
                    });*/
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

// Kiem tra tinh hop le cua cac thong tin
function checkValid() {
    var tungay = $("#from"),
        denngay = $("#to"),
        error_1 = $("#error-1"),
        error_2 = $("#error-2"),
        isValid = true;
    
    error_1.text("");
    error_2.text("");
    if(tungay.val() ==="") {
        isValid = false;
        error_1.text("* Chọn ngày");
    }
    if(denngay.val() ==="") {
        isValid = false;
        error_2.text("* Chọn ngày");
    }
    
    return isValid;
}

// Clear form controls
function resetCtrl() {
    $("#error-1").text('');
    $("#error-2").text('');
    
    $("#from").val('');
    $("#to").val('');
}

// Show loading panel
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

//Load to store list
function loadStoreList(from_store, start_date, worker, day_of_week) {
    // Show loading
    $("#loading").show();
    $("#change_store").hide();
    $("#description_panel").hide();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/working_calendar_update_calendar.php",
        type: 'POST',
        data: String.format('load_store_list={0}&from_store={1}&start_date={2}&worker={3}&day_of_week={4}', 'true', from_store, start_date, worker, day_of_week),
        success: function (data, textStatus, jqXHR) {
            try {
                var obj = jQuery.parseJSON(data);
                
                if(obj.result == 1) {
                    // Hide loading
                    $("#loading").hide();
                    
                    // Set description information
                    $("#description_panel").show();
                    $("#worker_name_lbl").html(obj.info.employee);
                    $("#day_name_lbl").html(obj.info.date);
                    $("#branch_name_lbl").html(obj.info.branch_name);
                    
                    // Set values to store list
                    if (obj.items.length > 0) {
                        // Show action button
                        $("#change_store").show();
                        
                        for(i = 0; i < obj.items.length; i++) {
                            // Get a item
                            var g = obj.items[i];
                            
                            // Add row to list
                            $("#to_store").append(String.format("<option value='{0}'>{1}</option>", g.value, g.text));
                        }
                    }
                } else {
                    // Do nothing
                }
            }
            catch(err) {
                //Handle errors here
                showPoupMessage('error', err);
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
            showPoupMessage('error', errorThrown);
        }
    });
}

// Show dialog to change store
function changeStore(ctrl_id, week_id, worker, from_store, day_of_week, start_date) {
    // Set form data
    $("#week_id").val(week_id);
    $("#worker").val(worker);
    $("#from_store").val(from_store);
    $("#day_of_week").val(day_of_week);
    $("#start_date").val(start_date);
    
    // Reset to store list
    $("#to_store").html("<option value=''></option>");
    $("#worker_name_lbl").html("");
    $("#day_name_lbl").html("");
    $("#branch_name_lbl").html("");
    
    // Show popup dialog
    $("#update_dialog").css("min-width", "250px");
    $("#update_dialog").bPopup({
        escClose: false,
        modalClose: false
    });
    
    // Load store list
    loadStoreList(from_store, start_date, worker, day_of_week);
}

//Show notification message when processing swapping item(s)
function showPoupMessage(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    // Close dialog
    $("#update_dialog").bPopup().close();
    
    // Show the message popup
    $('#popup_notification_msg').html(html);
    $('#popup').bPopup();
}

// Event when changing store successfully
function changeStoreDone(name) {
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
             if (json.result == 1) {
                 // Close dialog
                 $("#update_dialog").bPopup().close();
                 
                 /* Refresh data of the calendar */
                 var htmText = '';
                 var row_id = '';
                 
                 // From store
                 htmText = '';
                 if(json.source != '') {
                     htmText = json.source.replace(/@/g, "<").replace(/#/g, ">");
                 }
                 row_id = String.format("#{0}_{1}", json.week_id, json.from_store);
                 $(row_id).find("td[col_name='" + json.day_of_week + "']").each(function(index, e) {
                     $(e).html(htmText);
                 });
                 
                 // To store
                 htmText = '';
                 if(json.destination != '') {
                     htmText = json.destination.replace(/@/g, "<").replace(/#/g, ">");
                 }
                 row_id = String.format("#{0}_{1}", json.week_id, json.to_store);
                 $(row_id).find("td[col_name='" + json.day_of_week + "']").each(function(index, e) {
                     $(e).html(htmText);
                 });
                 
             } else {
                 showPoupMessage("error", json.message);
             }
        }
        catch(err) {
             //Handle errors here
            showPoupMessage('error', err);
        }
        
        frame.document.getElementsByTagName("body")[0].innerHTML = '';
      }
   }
 }

// DOM load
$(function() {
    // Pre-submit event
    $("#calendar").submit(function() {
        showLoading();
        
        return true;
    });
    
    // datepicker
    var dates = $("#from, #to").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            /*var option = this.id == "tungay" ? "minDate" : "maxDate",
                instance = $( this ).data( "datepicker" ),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );*/
        }
    });
    
    // Checking before submission
    $('#view').click(function() {
        return checkValid();
    });
    $('#view_all').click(function() {
        resetCtrl();
        return true;
    });
    
    // Auto submission
    $("#calendar").submit();
})