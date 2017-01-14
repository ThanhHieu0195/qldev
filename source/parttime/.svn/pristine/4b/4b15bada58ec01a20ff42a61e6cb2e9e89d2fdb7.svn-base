function validate() {
    var valid = true;

    // User name
    if ($("#user_name").val() == "") {
        $("#user_name").addClass("require_background");
        valid = false;
    } else {
        $("#user_name").removeClass("require_background");
    }
    // Password
    if ($("#password").val() == "") {
        $("#password").addClass("require_background");
        valid = false;
    } else {
        $("#password").removeClass("require_background");
    }

    // Hien thi thong bao
    if (!valid)
        $("#error").text("*Vui lòng nhập đầy đủ các thông tin.");
    else
        $("#error").text("");

    return valid;
}

// DOM load
$(function() {
    $("#timeout").numeric();

    $("#configure").submit(function() {
        return validate();
    });
});