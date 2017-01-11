// Kiem tra chon dung cu
function isChooseItem() {
    var choosed = false;

    $("#re-assign-list").find("input[type='checkbox']").each(function(index, e) {
        if($(e).attr("checked") == "checked") {
            choosed = choosed || true;
        }
    });

    return choosed;
}

// Kiem tra tinh hop le cua cac thong tin
function checkData() {    
    $("#error").text("");
    if(!isChooseItem()) {
        $("#error").text("* Chọn các dụng cụ muốn thực hiện!");
        
        return false;
    }
    
    return true;
}

// DOM load
$(function() {
    $("#re-assign-list").submit(function() {
        if(checkData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    })
})