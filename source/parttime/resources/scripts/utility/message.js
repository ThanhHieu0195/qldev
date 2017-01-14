function checkValid() {
    var isValid = true;

    $(".error").hide();

    if ($("#tieude").val() == "") {
        $("#tieude").parent().find(".error").show();
        isValid = false;
    }
    
//    alert($("#noidung").val());
//    if ($("#noidung").val() == "") {
//        $("#noidung").parent().find(".error").show();
//        isValid = false;
//    }

    return isValid;
}

// DOM load
$(function() {
    // tinymce
    tinymce.init({selector:'textarea'});
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
    $("#add-message").submit(function() {
        return checkValid();
    });
    $("#edit-message").submit(function() {
        return checkValid();
    });
});