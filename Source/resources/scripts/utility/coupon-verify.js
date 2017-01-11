//++ REQ20120915_BinhLV_N
// Hien thi khung thong tin khach hang su dung
function showCouponUsed(showed) {
    if(showed == true)
        $('#coupon_used').show();
    else
        $('#coupon_used').hide();
}

// Xoa cac du lieu tren form
function clearFormData() {
    $("#add-hoten").val("").removeClass( "ui-state-error" );
    $("#search_guest_type").val("").removeClass( "ui-state-error" );
    $("#add-nhomkhach").val("").removeClass( "ui-state-error" );
    $("#add-diachi").val("").removeClass( "ui-state-error" );
    $("#add-huyen").val("").removeClass( "ui-state-error" );
    $("#add-quan").val("").removeClass( "ui-state-error" );
    $("#add-tinhthanh1").attr('checked', 'checked');
    $("#add-tinh").val("").removeClass( "ui-state-error" );
    $("#add-dienthoai1").val("").removeClass( "ui-state-error" );
    $("#add-dienthoai2").val("").removeClass( "ui-state-error" );
    $("#add-dienthoai3").val("").removeClass( "ui-state-error" );
}

// Kiem tra cac thong tin tren form
function validateData() {
    var valid = true;
    
    // Kiem tra ho ten
    if($("#add-hoten").val() == "") {
        $("#add-hoten").addClass( "ui-state-error" );
        valid = false;
    }
    else {
        $("#add-hoten").removeClass( "ui-state-error" );
    }
    
    // Kiem tra nhom khach
    if($("#add-nhomkhach").val() == "") {
        $("#search_guest_type").addClass( "ui-state-error" );
        valid = false;
    }
    else {
        $("#search_guest_type").removeClass( "ui-state-error" );
    }
    
    // Kiem tra dia chi
    if($("#add-diachi").val() == "") {
        $("#add-diachi").addClass( "ui-state-error" );
        valid = false;
    }
    else {
        $("#add-diachi").removeClass( "ui-state-error" );
    }
    
    // Kiem tra quan/huyen va tinh/thanh pho
    $("#add-tinh").removeClass( "ui-state-error" );
    if($('#add-tinhthanh1').is(':checked')) {  // Chon TP.HCM
        if($("#add-quan").val() == "") {
            $("#add-huyen").addClass( "ui-state-error" );
            valid = false;
        }
        else {
            $("#add-huyen").removeClass( "ui-state-error" );
        }
    }
    else {                                     // Chon tinh thanh khac
        // huyen
        if($("#add-huyen").val() == "") {
            $("#add-huyen").addClass( "ui-state-error" );
            valid = false;
        }
        else {
            $("#add-huyen").removeClass( "ui-state-error" );
        }
        // tinh
        if($("#add-tinh").val() == "") {
            $("#add-tinh").addClass( "ui-state-error" );
            valid = false;
        }
        else {
            $("#add-tinh").removeClass( "ui-state-error" );
        }
    }
    
    // Kiem tra so dien thoai
    if($("#add-dienthoai1").val() == "") {
        $("#add-dienthoai1").addClass( "ui-state-error" );
        valid = false;
    }
    else {
        $("#add-dienthoai1").removeClass( "ui-state-error" );
    }
    
    return valid;
}

// Show loading
function ShowLoaders() {
    $('#loading').show();
}

// Hide loading
function HideLoaders() {
    $('#loading').hide();
}

// Them mot khach hang moi
function addNewGuest() {
    $.ajax({
        url: '../ajaxserver/add_guest_server.php',
        type: 'POST',
        cache: false,
        data: {
            hoten: $("#add-hoten").val(),
            nhomkhach: $("#add-nhomkhach").val(),
            diachi: $("#add-diachi").val(),
            tinh: ($('#add-tinhthanh1').is(':checked')) ? 'TP.HCM' : $("#add-tinh").val(),
            huyen: ($('#add-tinhthanh1').is(':checked')) ? $("#add-quan").val().replace('_', ' ') : $("#add-huyen").val(),
            dienthoai1: $('#add-dienthoai1').val(),
            dienthoai2: $('#add-dienthoai2').val(),
            dienthoai3: $('#add-dienthoai3').val(),
            tiemnang: ($('#add-tiemnang').is(':checked')) ? 1 : 0
        },
        beforeSend: function() {
            ShowLoaders();
        },
        complete: function() {
            HideLoaders();
        },
        success: function(data, textStatus) {
            HideLoaders();
            
            var json = $.parseJSON(data);
            if(json.result == 1) {
                $( "#tenkhachhangmoi" ).html( json.hoten );
                $( "#khachhangmoi" ).html( json.makhach );
                $( "#makhachhangmoi" ).val( json.makhach );
                $( "#nhomkhachhangmoi" ).html( json.tennhom );
                $( "#diachimoi" ).html( json.diachi );
            }
            
            hideDialog();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            HideLoaders();
        }
    });    
}

// Hien thi dialog them khach hang moi
function showDialog() {
	clearFormData();
	$("#add-form").show();
}

// An dialog them khach hang moi
function hideDialog() {
	$("#add-form").hide();
}

// DOM load
$(function() {
	$("#add-form").hide();
	
	$("#add-new").click(function() {
		if(validateData()) {
            addNewGuest();
        }
	});
	
    // click 'verify' button
    $("#verify").click(function() {
        return ( ! ($("#coupon").val() == ""));
    });
    
    // click 'used' button
    $("#used").click(function() {
        if($('#usedtype2').is(':checked'))
            return ( ! ($("#makhachhangmoi").val() == ""));
    });
    
    // autocomplete
    $( "#add-huyen" ).autocomplete({
        minLength: 1,
        source: "../ajaxserver/autocomplete_server.php?type=district",
        select: function( event, ui ) {
            $( "#add-huyen" ).val( ui.item.ten );
            $( "#add-quan" ).val( ui.item.quan );

            return false;
        }
    }).data( "autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>" + "<span class='name'>" + item.ten + "</span>" + "</a>" )
            .appendTo( ul );
    };
    
    $( "#search_guest_type" ).autocomplete({
        minLength: 1,
        source: "../ajaxserver/autocomplete_server.php?type=guesttype",
        select: function( event, ui ) {
            $( "#search_guest_type" ).val( ui.item.tennhom );
            $( "#add-nhomkhach" ).val( ui.item.manhom );

            return false;
        }
    }).data( "autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>" + "<span class='name'>" + item.tennhom + "</span>" + "</a>" )
            .appendTo( ul );
    };
});
//-- REQ20120915_BinhLV_N