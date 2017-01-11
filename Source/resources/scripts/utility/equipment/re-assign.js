// Kiem tra chon dung cu
function isChooseItem() {
    var choosed = false;

    $("#re-assign").find("input[type='checkbox']").each(function(index, e) {
        if($(e).attr("checked") == "checked") {
            choosed = choosed || true;
        }
    });

    return choosed;
}

// Kiem tra noi de/nguoi chiu trach nhiem
function isChooseDestination() {
    if($("#stored_in_new").val() == "" && $("#assign_to_new").val() == "") {
        $("#stored_in_new").addClass("require_background");
        $("#assign_to_new").addClass("require_background");
        return false;
    }
    else {
        $("#stored_in_new").removeClass("require_background");
        $("#assign_to_new").removeClass("require_background");
        return true;
    }
}

// Kiem tra tinh hop le cua cac thong tin
function checkData() {    
    $("#error").text("");
    if(!isChooseItem()) {
        $("#error").text("* Chọn các dụng cụ muốn chuyển!");
        
        return false;
    }
    
    $("#error").text("");
    if(!isChooseDestination()) {
        $("#error").text("* Chọn nơi để/người chịu trách nhiệm muốn chuyển đến!");
        
        return false;
    }
    
    return true;
}

// DOM load
$(function() {
    $("#re-assign").submit(function() {
        if(checkData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    })
})