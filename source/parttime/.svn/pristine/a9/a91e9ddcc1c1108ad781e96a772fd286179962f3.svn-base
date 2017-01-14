function checkValid() {
    var isValid = true;

    $(".error_icon").hide();

    if ($("#title").val() == "") {
        $("#title").parent().find(".error_icon").show();
        isValid = false;
    }
    
    if ($("#group_id").val() == "") {
        $("#group_id").parent().find(".error_icon").show();
        isValid = false;
    }
    
    if(! isValid) {
        $("#save").parent().find(".error_icon").show();
    }

    return isValid;
}

// DOM load
$(function() {
    // Disable autocomplete
    disableAutocomplete();
    
    // tinymce
    tinymce.init({selector:'.editor'});
    //    tinymce
    //            .init({
    //                selector : "textarea",
    //                plugins : [
    //                        "advlist autolink lists link image charmap print preview anchor",
    //                        "searchreplace visualblocks code fullscreen",
    //                        "insertdatetime media table contextmenu paste " ], /*
    //                                                                             * Missing:
    //                                                                             * 'moxiemanager'
    //                                                                             * plugin
    //                                                                             */
    //                toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    //            });

    // form submit
    $("#add-news").submit(function() {
        return checkValid();
    });
    $("#edit-news").submit(function() {
        return checkValid();
    });
});