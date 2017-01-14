//Lay thong tin khach hang
function getGuestInfo() {
    var makhach = $("#hotenkhach").val();
    if(makhach == "") {
        $("#makhach").text("");
        $("#nhomkhach").text("");
        $("#diachi").text("");
    }
    else {
        // Ham ajax
        $( "#loading" ).show();
        $.ajax({
            url: '../models/getguest.php',
            type: 'POST',
            data: 'makhach=' + makhach,
            success: function (data, textStatus, jqXHR) {
                var json = $.parseJSON(data);
                if(json.status == 200) {
                    $("#makhach").text(json.makhach);
                    $("#nhomkhach").text(json.nhomkhach);
                    $("#diachi").text(json.diachi);
                }
                $( "#loading" ).hide();
            }
        });
    }
}

function clearCashingDate() {
    $('#cashing_date').val('');
}

//Hien thi khung nhap ngay hen giao hang
function chonngaygiao(ctrl)
{
    if($(ctrl).attr("checked") == "checked") {
        $("#ngaygiao").show();
        return true;
    }
    else {
        $("#ngaygiao").hide();
        return false;
    }
}

// Ham tinh tien
function pay() {
    var error = document.getElementById("error");  //thong bao loi
    var thanhtien = 0;  //thanh tien
    var checkbox = document.getElementById("checkboxpercent");  //phan tram

    //var tongtien=document.getElementById("tongtien").innerHTML;  //tong tien
    var tongtien = document.getElementById("tongtien").value;  //tong tien
    tongtien = stripNonNumeric(tongtien);
    //alert(tongtien);

    var txttiengiam = document.getElementById("tiengiam");  //tien giam
    var tiengiam = txttiengiam.value;

    //Thong bao loi
    error.style.visibility = "visible";

    //Kiem tra nhap tien giam
    if(tiengiam == "") {
        //alert("Nhập vào số tiền giảm");
        error.innerHTML = "Nhập vào số tiền giảm";
        //document.getElementById("thanhtien").innerHTML="?";
        document.getElementById("thanhtien").value = "?";
        txttiengiam.focus();
        return;
    }
    if(isNaN(tiengiam)) {
        error.innerHTML = "Giá trị nhập vào không đúng định dạng";
        //document.getElementById("thanhtien").innerHTML="?";
        document.getElementById("thanhtien").value = "?";
        txttiengiam.focus();
        return;
    }
    //Kiem tra mien gia tri
    tiengiam = stripNonNumeric(tiengiam);  //doi ra so
    //alert(tiengiam);
    if(checkbox.checked) {
        if(tiengiam < 0 || tiengiam > 100) {
            //alert("So % tien giam nam trong khoang [0, 100]");
            error.innerHTML = "Số % tiền giảm phải nằm trong khoảng [0, 100]";
            document.getElementById("thanhtien").value = "?";
            txttiengiam.focus();
            return;
        }
    }
    else {
        if(tiengiam < 0) {
            error.innerHTML = "Số tiền giảm không được nhỏ hơn 0";
            txttiengiam.focus();
        return;
        }
        else if(eval(tiengiam-tongtien) > 0) {
            //alert("Số tiền giảm không được lớn hơn tống số tiền phải trả");
            error.innerHTML = "Số tiền giảm không được lớn hơn tống số tiền phải trả";
            txttiengiam.focus();
            return;
        }
    }
    //alert(tiengiam);

    //Neu tinh theo phan tram
    if(checkbox.checked) {
        thanhtien = tongtien *(1 - tiengiam/100);
    }
    else
        thanhtien = tongtien-tiengiam;

    //Hien thi ket qua
    error.style.visibility = "hidden";
    //document.getElementById("thanhtien").innerHTML=numberFormat(roundNumber(thanhtien,0));
    document.getElementById("thanhtien").value = numberFormat(roundNumber(thanhtien, 0));

    //thanhtien=document.getElementById("thanhtien").innerHTML;
    //alert(stripNonNumeric(thanhtien));
}

function left() {
    if($("#thanhtien").val() == "?" || $("#duatruoc").val() == "") {
        $("#conlai").val("?");
    }
    else {
        var thanhtien = stripNonNumeric($("#thanhtien").val());
        var duatruoc = $("#duatruoc").val();
        $("#conlai").val(numberFormat(thanhtien - duatruoc));
    }
}

function checkData() {
    var isValid = true;
    var message = "";

    // Tinh thanh tien
    pay();

    // Kiem tra ten khach hang
    if($("#hotenkhach").val() == "") {
        isValid = false;
    }
    // Kiem tra thanh tien
    if($("#thanhtien").val() == "?") {
        isValid = false;
    }
    // Kiem tra gia tri con lai
    if($("#conlai").val() == "?") {
        isValid = false;
    }
    // Kiem tra ma hoa don
    if($("#mahoadon").val() == "") {
        isValid = false;
    }
    // Kiem tra ngay giao neu hen cho giao
    if($("#checkboxngaygiao").attr("checked") == "checked") {
        if($("#ngaygiao").val() == "") {
            isValid = false;
        }
    }
    // Kiem tra nhom nhan vien, nhan vien
    var checkGroup = true;
    var checkMember = true;
    if($('#groups').val() == null || $('#groups').val() == "") { // Nhom nhan vien
        checkGroup = false;
    }
    if($('#members').val() == null || $('#members').val() == "") { // Nhan vien
        checkMember = false;
    }
    if ((!checkGroup) && (!checkMember)) {
        isValid = false;
    }
    
    // Display message dialogue and return result
    if(!isValid) {
        showMessageDialog();
    }
    return isValid;
}

// Show dialog
function showMessageDialog() {
    $( "#dialog-message" ).dialog( "open" );
}

// DOM load
$(function() {
    $("#pay-form").submit(function() {
        return checkData();
    });

    $( "#dialog-message" ).dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Ok: function() {
                $( this ).dialog( "close" );
            }
        }
    });

    $("#form-cthd").submit(function() {
        pay();
        //return true;
    });
})