﻿// Kiem tra cac thong tin export
function checkValid() {
    var tungay = $("#tungay"),
        denngay = $("#denngay"),
        error_1 = $("#error-1"),
        error_2 = $("#error-2"),
        isValid = true;
    
    error_1.text("");
    error_2.text("");
    if(tungay.val() ==="") {
        isValid = false;
        error_1.text("* Chọn ngày");
    }
    if(denngay.val() ==="") {
        isValid = false;
        error_2.text("* Chọn ngày");
    }
    
    return isValid;
}

// Export bang doanh thu tung showroom theo khoang thoi gian ra file excel
function export2Excel() {
    var tungay = $("#tungay"),
        denngay = $("#denngay");
    var format = "../phpexcel/export2exel.php?do=export&table=task-completed-list&from={0}&to={1}";
    var url;

    if(checkValid()) {
        url = String.format(format, tungay.val(), denngay.val());
        window.location = url;
    }
}

// DOM load
$(function() {
    // datepicker
    var dates = $("#tungay, #denngay").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
        }
    });
    
    // submit event
    $("#task-completed-list").submit(function() {
        return checkValid();
    });
});