// Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    $('.error_icon').hide();
    
    // Content
    if($('#content').val().trim() == "") {
    	$('#error_content').show();
    	isValid = false;
    } else {
    	$('#error_content').hide();
    	isValid = isValid && true;
    }
    // Assign to
    if($('#assign_to').val() == null || $('#assign_to').val() == "") {
    	$('#error_assign_to').show();
    	isValid = false;
    } else {
    	$('#error_assign_to').hide();
    	isValid = isValid && true;
    }
    // Level
    if($('#level').val() == null || $('#level').val() == "") {
        $('#error_level').show();
        isValid = false;
    } else {
        $('#error_level').hide();
        isValid = isValid && true;
    }
    // Value
    if($('#value').val() == null || $('#value').val() == "") {
        $('#error_value').show();
        isValid = false;
    } else {
        if(isNaN(parseFloat($('#value').val()))) {
            $('#error_value').show();
            isValid = false;
        } else {
            $('#error_value').hide();
            isValid = isValid && true;
        }
    }
    
    if(!isValid)
    	$('#attention').show();
    else
    	$('#attention').hide();

    return isValid;
}

// DOM load
$(function() {
    $('.error_icon').hide();
    $('#attention').hide();
    $("input").attr("autocomplete", "off");
    
    $('#value').numeric({allow:"-"});
    
    $('#add-new').submit(function() {
        if(validateData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    });
});