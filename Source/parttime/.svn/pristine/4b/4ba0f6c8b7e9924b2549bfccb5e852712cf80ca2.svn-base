// Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    var items = $("#example1").find("input[type='text']");
    if(items.length == 0)
        isValid = false;
    else {
        items.each(function(index, e) {
            if($(e).val() == "" || eval($(e).val()) == 0) {
                $(e).parent().find('.error_icon').show();
                isValid = isValid && false;
            } else {
                $(e).parent().find('.error_icon').hide();
                isValid = isValid && true;
            }
        });
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
    
    $('.numeric').numeric();
    $("input").attr("autocomplete", "off");
    
    $('#submit').click(function() {
        return validateData();
    });
    
    $('#view').click(function() {
        return ($('#manv').val() != '');
    });
});