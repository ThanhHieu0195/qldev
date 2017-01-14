/// <reference path="jquery.alphanumeric.js" />

// Kiem tra du lieu cua mot field bat buoc
function isEmpty(e) {
    if($(e).val() == "") {
        $(e).addClass("require-border");
        return false;
    }
    else {
        $(e).removeClass("require-border");
        return true;
    }
}

// Kiem tra gia tri cua mot field ( >=0 )
function checkRange(e) {
    if($(e).val() <= 0) {
        $(e).addClass("require-border");
        return false;
    }
    else {
        $(e).removeClass("require-border");
        return true;
    }
}

// Kiem tra tinh hop le cua cac du lieu
function checkData(update) {
    var isValid = true;
    var message = "";

    isValid = isValid && isEmpty("#masotranh");     // Kiem tra ma san pham
    isValid = isValid && isEmpty("#tentranh");      // Kiem tra ten san pham
    isValid = isValid && isEmpty("#maloai");        // Kiem tra loai san pham
    isValid = isValid && isEmpty("#soluong");       // Kiem tra so luong
    isValid = isValid && isEmpty("#giaban");        // Kiem tra gia ban
    if(update)
    {
        isValid = isValid && isEmpty("#makho");     // Kiem tra showroom
        isValid = isValid && isEmpty("#matho");     // Kiem tra tho lam tranh
        isValid = isValid && isEmpty("#trangthai"); // Kiem tra trang thai cua san pham
    }
    isValid = isValid && checkRange("#soluong");    // Kiem tra gia tri so luong
    isValid = isValid && checkRange("#giaban");     // Kiem tra gia tri gia ban
    
    if( ! isValid)
        $("#error").text("*Một số thông tin chưa đúng, vui lòng kiểm tra lại!");
    else
        $("#error").text("");
    
    return isValid;
}

// Kiem tra thong tin cua mot san pham them moi
function checkItemInfo() {
    var isValid = true;

    isValid = isValid && isEmpty("#masotranh");     // Kiem tra ma san pham
    isValid = isValid && isEmpty("#tentranh");      // Kiem tra ten san pham
    isValid = isValid && isEmpty("#maloai");        // Kiem tra loai san pham
    isValid = isValid && isEmpty("#soluong");       // Kiem tra so luong
    isValid = isValid && checkRange("#soluong");    // Kiem tra gia tri so luong
    isValid = isValid && isEmpty("#giaban");        // Kiem tra gia ban
    isValid = isValid && checkRange("#giaban");     // Kiem tra gia tri gia ban
    isValid = isValid && isEmpty("#makho");         // Kiem tra showroom
    isValid = isValid && isEmpty("#matho");         // Kiem tra tho lam tranh
    isValid = isValid && isEmpty("#hinhanh");       // Kiem tra hinh anh
    
    if( ! isValid)
        $("#error").text("*Một số thông tin chưa đúng, vui lòng kiểm tra lại!");
    else
        $("#error").text("");
    
    return isValid;
}

// DOM load
$(function() {
    // numeric
    $(".numeric").numeric();
        
    // submit
    $("#order-product").submit(function() {
        return checkData(false);
    });
    $("#tp-detail").submit(function() {
        return checkData(true);
    });
    // Form them mot san pham moi
    $("#add-product").submit(function() {
        return checkItemInfo();
    });
})