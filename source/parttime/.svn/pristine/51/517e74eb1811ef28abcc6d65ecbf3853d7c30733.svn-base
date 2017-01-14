//Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    $('.error_icon').hide();
    
    if($('#group_name').val().trim() == "") {
        $('#error_group_name').show();
        isValid = false;
    } else {
        $('#error_group_name').hide();
        isValid = isValid && true;
    }
    
    if($('#members_list').val() == null || $('#members_list').val() == "") {
        $('#error_members_list').show();
        isValid = false;
    } else {
        $('#error_members_list').hide();
        isValid = isValid && true;
    }
    
    if(!isValid)
        $('#attention').show();
    else
        $('#attention').hide();

    return isValid;
}

//DOM load
$(function() {
    
    // Error icons
    $('.error_icon').hide();
    $('#attention').hide();
    
    // Pre-submit events
    $('#create_group').submit(function() {
        if(validateData()) {
            return true;
        }
        
        return false;
    });
});