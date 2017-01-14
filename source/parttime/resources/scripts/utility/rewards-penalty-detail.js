// Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    $('.error_icon').hide();
    
    // Value
    if($('#rewards_value').val() == null || $('#rewards_value').val() == "") {
        $('#error_rewards_value').show();
        isValid = false;
    } else {
        if(isNaN(parseFloat($('#rewards_value').val()))) {
            $('#error_rewards_value').show();
            isValid = false;
        } else {
            $('#error_rewards_value').hide();
            isValid = isValid && true;
        }
    }

    return isValid;
}

// DOM load
$(function() {
    $('.error_icon').hide();
    $("input").attr("autocomplete", "off");
    
    $('#rewards_value').numeric({allow:"-"});
    
    $('#approve').click(function() {
        if(validateData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    });
    
    $('#reject').click(function() {
        return confirm('Bạn có chắc không?');
    });
});