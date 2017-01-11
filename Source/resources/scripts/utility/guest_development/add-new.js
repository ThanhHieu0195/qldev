// Kiem tra tinh hop le cua cac thong tin
function validateData(existing) {
    var isValid = true;
    $('.error_icon').hide();

    if (! existing) { /* Khach hang moi */
        // Ho ten
        if ($('#hoten').val().trim() == "") {
            $('#hoten').parent().find('.error_icon').show();
            isValid = false;
        } else {
            $('#hoten').parent().find('.error_icon').hide();
            isValid = isValid && true;
        }
        // Dia chi
        if ($('#diachi').val().trim() == "") {
            $('#diachi').parent().find('.error_icon').show();
            isValid = false;
        } else {
            $('#diachi').parent().find('.error_icon').hide();
            isValid = isValid && true;
        }
    } else { /* Khach hang da ton tai trong he thong */
        // Guest Id
        if ($('#guest_id').val().trim() == "") {
            $('#search_guest').parent().find('.error_icon').show();
            isValid = false;
        } else {
            $('#search_guest').parent().find('.error_icon').hide();
            isValid = isValid && true;
        }
    }
    // Ngay lien he tiep theo
    if ($('#next_schedule').val().trim() == "") {
        $('#next_schedule').parent().find('.error_icon').show();
        isValid = false;
    } else {
        $('#next_schedule').parent().find('.error_icon').hide();
        isValid = isValid && true;
    }

    if (!isValid)
        $('#attention').show();
    else
        $('#attention').hide();

    return isValid;
}

function addRow() {
    countId++;
    $('#events_days')
            .append(
                    '<tr><td>'
                            + '<input name="day[]" class="text-input small-input date-picker" style="width: 150px !important" readonly type="text" value="">'
                            + '</td><td>'
                            + '<input name="note[]" class="text-input medium-input" style="width: 95% !important" type="text" value="">'
                            + '</td><td style="text-align: center;">'
                            + '<input id="check_event_'
                            + countId
                            + '" type="checkbox" onclick="check_event(\'check_event_'
                            + countId
                            + '\');" /><input name="is_event[]" type="hidden" value="0" />'
                            + '</td><td>'
                            + '<a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>'
                            +
                            // '<a id="clear_' + countId + '"
                            // href="javascript:clearRow(\'clear_' + countId +
                            // '\')" title="Clear dòng này"><img
                            // src="../resources/images/icons/clear.png"
                            // alt="Clear"></a>' +
                            '<a id="remove_'
                            + countId
                            + '" href="javascript:removeRow(\'remove_'
                            + countId
                            + '\')" title="Xóa dòng này"><img src="../resources/images/icons/cross.png" alt="Delete"></a>'
                            + '</td></tr>');
    $(".date-picker").datepicker({
        // minDate: +0,
        changeMonth : true,
        changeYear : true
    });
}

function clearRow(id) {
    $('#' + id).closest('tr').find("input[type='text']").each(
            function(index, e) {
                $(e).val('');
            });
}

function removeRow(id) {
    $('#' + id).closest('tr').remove();
}

function check_event(id) {
    var ctrlId = '#' + id;
    var val = 0;

    if ($(ctrlId).is(":checked")) {
        val = 1;
    }
    $(ctrlId).parent().find('input[name="is_event[]"]').val(val);
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
                var htmText = '';
                switch (json.result) {
                    case "error":
                        showNotification("error", json.message);
                        break;
    
                    case "successb":
                        window.location="../view/store.php";
                        break;
                    case "success":
                        window.location="../guest_development/list-assigned.php";
                        break;
                    case "warning":
                        var htmlText = json.message;
                        if (json.detail.length != 0) {
                            for (i = 0; i < json.detail.length; i++) {
                                htmlText += String.format(
                                                "<br />&nbsp;&nbsp;• Ngày \"<span class='orange'>{0}</span>\": {1}",
                                                json.detail[i].day,
                                                json.detail[i].error);
                            }
    
                            showNotification("attention ", htmlText);
                        } else {
                            showNotification("information ", htmlText);
                        }
    
                        break;
                }
            } catch (err) {
                // Handle errors here
                showNotification('error', err);
            }

            frame.document.getElementsByTagName("body")[0].innerHTML = '';
        }
    }
}

// Reset form controls
function resetCtrl() {
    $('.error_icon').hide();
    $('#attention').hide();
    
    // Clear events days list
    $('#events_days tr').not(':first').each(function() {
        $(this).remove();
    });
    
    // Clear guest information
    $( "#tenkhach" ).html('?');
    $( "#makhach" ).html('?');
    $( "#nhomkhach" ).html('?');
    $( "#diachi" ).html('?');

    countId = 0;

    // Clear notification
    $('#notification_msg').html('');
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

// DOM load
$(function() {
    // Disable autocomplete
    disableAutocomplete();
    
    $('.error_icon').hide();
    $('#attention').hide();

    $(".date-picker").datepicker({
        minDate: +0,
        changeMonth : true,
        changeYear : true
    });

    // Add new
    $('#add_new').submit(function() {
        $('#notification_msg').html('');
        if (validateData(false)) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    });

    // Add from db
    $('#add_from_db').submit(function() {
        $('#notification_msg').html('');
        if (validateData(true)) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    });

    // Reset
    $('#reset').click(function() {
        resetCtrl();
        return true;
    });
});
