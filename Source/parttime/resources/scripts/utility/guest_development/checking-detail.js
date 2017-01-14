// Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    $('.error_icon').hide();

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

// DOM load
$(function() {
    // Disable autocomplete
    disableAutocomplete();

    $('#attention').hide();
    
    $(".date-picker").datepicker({
        minDate: +0,
        changeMonth : true,
        changeYear : true
    });

    // Add new
    $('#checking_detail').submit(function() {
        $('#notification_msg').html('');
        if (validateData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    });


});
