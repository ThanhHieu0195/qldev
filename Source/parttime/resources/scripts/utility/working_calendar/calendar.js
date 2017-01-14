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