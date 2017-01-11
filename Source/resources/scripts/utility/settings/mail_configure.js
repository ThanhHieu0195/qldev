function validate() {
    var valid = true;

    // Host
    if ($("#host").val() == "") {
        $("#host").addClass("require_background");
        valid = false;
    } else {
        $("#host").removeClass("require_background");
    }
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
    // Time-out
    if ($("#timeout").val() == "" || eval($("#timeout").val()) <= 0) {
        $("#timeout").addClass("require_background");
        valid = false;
    } else {
        $("#timeout").removeClass("require_background");
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