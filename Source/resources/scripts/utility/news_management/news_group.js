function checkValid() {
    var isValid = true;

    $(".error_icon").hide();

    if ($("#name").val() == "") {
        $("#name").parent().find(".error_icon").show();
        isValid = false;
    }

//    if ($("#note").val() == "") {
//        $("#note").parent().find(".error").show();
//        isValid = false;
//    }

    return isValid;
}

// DOM load
$(function() {
    // Disable autocomplete
    disableAutocomplete();
    
    // form submit
    $("#add-group").submit(function() {
        return checkValid();
    });
    $("#edit-group").submit(function() {
        return checkValid();
    });
});