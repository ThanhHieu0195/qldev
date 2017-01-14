// Kiem tra cac thong tin export
function checkValid() {
    var tungay = $("#tungay"),
        denngay = $("#denngay"),
        showroom = $("#showroom"),
        error_1 = $("#error-1"),
        error_2 = $("#error-2"),
        error_3 = $("#error-3"),
        isValid = true;
    
    error_1.text("");
    error_2.text("");
    error_3.text("");
    if(tungay.val() ==="") {
        isValid = false;
        error_1.text("* Chọn ngày");
    }
    if(denngay.val() ==="") {
        isValid = false;
        error_2.text("* Chọn ngày");
    }
    if(showroom.val() ==="") {
        isValid = false;
        error_3.text("* Chọn showroom");
    }
    
    return isValid;
}

// Export bang doanh thu tung showroom theo khoang thoi gian ra file excel
function export2Excel() {
    var tungay = $("#tungay"),
        denngay = $("#denngay"),
        showroom = $("#showroom");
    var format = "../phpexcel/export2exel.php?do=export&table=import_export&from={0}&to={1}&showroom={2}";
    var url;
    if(checkValid()) {
        url = String.format(format, tungay.val(), denngay.val(), showroom.val());
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
            /*var option = this.id == "tungay" ? "minDate" : "maxDate",
                instance = $( this ).data( "datepicker" ),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );*/
        }
    });
    
    // submit event
    $("#history-list").submit(function() {
        return checkValid();
    });
});