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
        data: String.format('enable_reference={0}&uid={1}', 'true', uid),
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

// Validate data
function checkValid() {
    var isValid = true;

    $(".error_icon").hide();

    if ($("#reference_id").val() == "") {
        $("#reference_id").parent().find(".error_icon").show();
        isValid = false;
    }
    
    if ($("#name").val() == "") {
        $("#name").parent().find(".error_icon").show();
        isValid = false;
    }

    return isValid;
}

// DOM load
$(function() {
    disableAutocomplete();
    
    // form submit
    $("#add-reference").submit(function() {
        return checkValid();
    });
    $("#edit-reference").submit(function() {
        return checkValid();
    });
});