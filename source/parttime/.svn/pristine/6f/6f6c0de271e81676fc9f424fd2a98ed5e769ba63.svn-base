//++ REQ20120508_BinhLV_N
// Kiem tra chon san pham can chuyen kho
function isChooseItem() {
    var choosed = false;

    $("#itemofstore").find("input[type='checkbox']").each(function(index, e) {
        if($(e).attr("checked") == "checked") {
            choosed = choosed || true;
        }
    });

    return choosed;
}

// Kiem tra khoang gia tri cua mot so
function checkRange( n, min, max ) {
    if ( n - max > 0 || n - min < 0 ) {
        return false;
    }
    else {
        return true;
    }
}

// Kiem tra nhap so luong, khoang gia tri cua so luong
function validateAmount() {
    var isValid = true;
    var items = $("#itemofstore").find("input[type='checkbox']");
    if(items.length == 0)
        isValid = false;
    else {
        items.each(function(index, e) {
            if($(e).attr("checked") == "checked") {
                var i = $(e).attr('id').replace('masotranh', '#soluongchuyen');

                if( $(i).val() == "" || !(checkRange( $(i).val(), 1, $(i).attr('maxvalue') )) ) {
                    $(i).addClass('require_background');
                    isValid = isValid && false;
                }
                else {
                    $(i).removeClass('require_background');
                    isValid = isValid && true;
                }
            }
        });
    }

    return isValid;
}

// Kiem tra chon kho chuyen den
function isChooseStore() {
    if($("#to").val() == "") {
        $("#to").addClass("require_background");
        return false;
    }
    else {
        $("#to").removeClass("require_background");
        return true;
    }
}

// Kiem tra tinh hop le cua cac thong tin
function checkData() {
    $('#notification_msg').html('');
    
    var isValid = true;

    isValid = isValid && isChooseStore();
    isValid = isValid && isChooseItem();
    isValid = isValid && validateAmount();
    
    if(!isValid)
        $("#error").text("* Các thông tin chưa chính xác. Vui lòng kiểm tra lại!");
    else
        $("#error").text("");

    return isValid;
}

// Su kien khi click chon mot checkbox san pham
function createInput(ctrlId, maxValue) {
    var containerId = ctrlId.replace('masotranh', 'container');
    var input = "<input autocomplete='off' type='text' class='numeric'" +
                " id='" + ctrlId.replace('#masotranh', 'soluongchuyen') + "'" +
                " maxvalue='" + maxValue + "'" +
                " name='soluongchuyen[]' maxlength='5' />";
            
    if($(ctrlId).attr("checked") == "checked"
         && maxValue > 0) {
        $(containerId).html(input);
        $(".numeric").numeric();
    }
    else {
        $(containerId).html("");
    }
}

//Check range gia tri cua mot field
function checkAmountRange( o, n, min, max ) {
    if ( o.val() - max > 0 || o.val() - min < 0 ) {
        o.addClass( "ui-state-error" );
        return false;
    } else {
        return true;
    }
}

//Hien thi dialog xoa hang muc ton kho
function showDialog(masotranh, makho, tonkho) {
    // Thiet lap cac gia tri hidden tren form
    $("#masotranh").val(masotranh);
    $("#makho").val(makho);
    $("#tonkho").val(tonkho);
    if(tonkho == '1') {
        $("#soluong").attr('disabled', 'disabled');
        $("#soluong").val('1');
    }
    else {
        $("#soluong").removeAttr('disabled');
        $("#soluong").val('');
    }

    $("#require").text("*Nhập số lượng cần xóa trong khoảng [1, " + tonkho + "] ");
    // Hien thi dialog
    $( "#dialog-form" ).dialog( "open" );
}

//Update data table
function refreshDataTable() {
    $('#example').dataTable()._fnAjaxUpdate();
}

function showLoadingIcon() {
    var btnpane = $("div.ui-dialog-buttonpane");
    //prevent bad things if create is clicked multiple times
    var there = btnpane.find("#ajax-loader").size() > 0;
    if(!there) {
        $("#ajax-loader").clone(true).appendTo(btnpane).show();
    }
}

function hideLoadingIcon() {
    var btnpane = $("div.ui-dialog-buttonpane");
    btnpane.find("#ajax-loader").remove();
}

//Show notification message when processing swapping item(s)
function showPopupMessage(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    hideLoadingIcon();
    $('#dialog-form').dialog( "close" );
    $('#popup_msg').html(html);
    $('#popup').bPopup();
}

function updateAmount(product_id, store_id, amount) {
    // Loading
    showLoadingIcon();

    // Gửi yêu cầu ajax
    $.ajax({
        url : "../ajaxserver/items_swapping_server.php",
        type : 'POST',
        //contentType: "application/json; charset=utf-8",
        //dataType: "json",
        data : String.format('update_amount={0}&product_id={1}&store_id={2}&amount={3}', 'true', product_id, store_id, amount), 
        success : function(data, textStatus, jqXHR) {
            try {
                var json = jQuery.parseJSON(data);
                
                if (json.result == "error") {
                    showPopupMessage("error", json.message);
                } else {
                    if (json.result == "success" || json.result == "warning") {
                        // Update data table
                        refreshDataTable();
                        // Hide loading
                        hideLoadingIcon();
                        // Close the dialog
                        $('#dialog-form').dialog( "close" );
                        
                        if (json.result == "success") {
                            // Do nothing
                        } else {
                            // Show warning message
                            var htmlText = json.message;
                            
                            if (json.detail.length != 0) {
                                for (i = 0; i < json.detail.length; i++) {
                                    var d = json.detail[i];
                                    htmlText += String.format("<br />&nbsp;&nbsp;• <span class='orange'>{0}</span>: {1}", 
                                                               d.title, d.error);
                                }
                            }
                            
                            showPopupMessage("attention", htmlText);
                        }
                    }
                }
            }
            catch(err) {
                //Handle errors here
                showPopupMessage('error', err);
           }
        }, 
        timeout: 10000,      // timeout (in miliseconds)
        error: function(qXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                // request timed out, do whatever you need to do here
            }
            else {
                // some other error occurred
            }
            showPopupMessage("error", errorThrown);
        }
    });
}

// DOM load
$(function() {
    // Disable autocomplete
    //disableAutocomplete();
    
    // Numeric
    $(".numeric").numeric();
    
    // Dialog
    $( "#dialog-form" ).dialog({
        autoOpen: false,
        resizable: false,
        dialogClass: 'fixed-dialog',
        height: 200,
        width: 350,
        modal: true,
        buttons: {
            "Ok": function() {
                var bValid = true;

                bValid = bValid && checkAmountRange( $("#soluong"), "số lượng", 1, $("#tonkho").val() );

                if ( bValid ) {
                    // Lay cac tham so
                    var product_id = $("#masotranh").val(),
                        store_id = $("#makho").val(),
                        amount = $("#soluong").val();
                    // Update amount
                    updateAmount(product_id, store_id, amount);
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            $("#soluong").val( "" ).removeClass( "ui-state-error" );
        }
    });
});
//-- REQ20120508_BinhLV_N