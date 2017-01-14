//++ REQ20120915_BinhLV_N
// Kiem tra chon nhom coupnon
function isChooseItem() {
    var choosed = false;

    $("#coupon_generate").find("input[type='checkbox']").each(function(index, e) {
        if($(e).attr("checked") == "checked") {
            choosed = choosed || true;
        }
    });

    return choosed;
}

// Kiem tra nhap so luong, khoang gia tri cua so luong
function validateAmount() {
    var isValid = true;
    var items = $("#coupon_generate").find("input[type='checkbox']");
    if(items.length == 0)
        isValid = false;
    else {
        items.each(function(index, e) {
            if($(e).attr("checked") == "checked") {
                var i = $(e).attr('id').replace('groupid', '#amount');

                if( $(i).val() == "" ) {
                    isValid = isValid && false;
                }
                else {
                    isValid = isValid && true;
                }
            }
        });
    }

    return isValid;
}

// Kiem tra nhap chieu dai coupon
function isInputLength() {
    if($("#coupon_length").val() == "" || $("#coupon_length").val() < 3 || $("#coupon_length").val() > 50) {
        $('#coupon_length').addClass('ui-state-error');
        return false;
    }
    else {
        $('#coupon_length').removeClass('ui-state-error');
        return true;
    }
}

// Kiem tra thoi han su dung cua coupon
function checkCouponExpired() {
    if($("#coupon_expired").val() == "" || $("#coupon_expired").val() < 1) {
        $('#coupon_expired').addClass('ui-state-error');
        return false;
    }
    else {
        $('#coupon_expired').removeClass('ui-state-error');
        return true;
    }
}

// Kiem tra chon loai han su dung cho coupon
function checkCouponType() {
    if($("#expire_type").val() == "") {
        $('#expire_type').addClass('ui-state-error');
        return false;
    }
    else {
        $('#expire_type').removeClass('ui-state-error');
        return true;
    }
}

// Kiem tra tinh hop le cua cac thong tin
function checkData() {
    var isValid = true;

    /*isValid = isValid && isInputLength();
    isValid = isValid && isChooseItem();
    isValid = isValid && validateAmount();
    isValid = isValid && checkCouponExpired();
    isValid = isValid && checkCouponType();*/
    
    if(!isInputLength()) {
        isValid = false;
    }
    if(!isChooseItem()) {
        isValid = false;
    }
    if(!validateAmount()) {
        isValid = false;
    }
    if(!checkCouponExpired()) {
        isValid = false;
    }
    if(!checkCouponType()) {
        isValid = false;
    }
    
    if(!isValid)
    	$('#attention').show();
    else
    	$('#attention').hide();

    return isValid;
}

// Su kien khi click chon mot checkbox san pham
function createInput(ctrlId) {
    var containerId = ctrlId.replace('groupid', 'container');
    var input = "<input type='text' class='numeric'" +
                " id='" + ctrlId.replace('#groupid', 'amount') + "'" +
                " name='amount[]' maxlength='5' />";
            
    if($(ctrlId).attr("checked") == "checked") {
        $(containerId).html(input);
        $(".numeric").numeric();
    }
    else {
        $(containerId).html("");
    }
}

// DOM load
$(function() {
    $("#coupon_generate").submit(function() {
        return checkData();
    })
    
    $('#attention').hide();
    
    /*$("#coupon_expired").datepicker({
        minDate: +0,
        changeMonth: true,
        changeYear: true 
        });*/
    $('#coupon_expired').numeric();
})
//-- REQ20120915_BinhLV_N