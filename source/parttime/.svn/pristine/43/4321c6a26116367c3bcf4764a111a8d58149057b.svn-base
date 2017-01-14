// Loading image
function createLoadingIcon() {   
    return "<img alt=\"loading\" src=\"../resources/images/loading.gif\">";
}

function showDialog(madon, masotranh, soluong, uid) {
    var ctrlId = "#" + uid;
    var originalHtml = $(ctrlId).html();
    $(ctrlId).html(createLoadingIcon());

    // Thiet lap cac gia tri hidden tren form
    $("#order").val(madon);         // mã hóa đơn
    $("#item").val(masotranh);      // mã sản phẩm
    $("#amount").val(soluong);      // số lượng sản phẩm đặt mua
    $("#uid").val(uid);             // uid
    $("#store").val("");            // showroom giao hàng
    $("#store").removeClass("ui-state-error");
    
    $.getJSON('../ajaxserver/delivery_server.php', { "masotranh": masotranh, "soluong": soluong })
        .done(function( json ) {
            if(json.result == 1) {
                $("#store").html("<option value=''></option>");
                
                $.each(json.data , function(index, rec) {
                    $("#store").append("<option value='" + rec.makho + "'>" + rec.tenkho + "</option>");
                });
            }
            
            // Hien thi dialog
            $("#delivery-dialog").dialog("open");
            
            $(ctrlId).html(originalHtml);
        })
        .fail(function() {
        });
}

function checkStorevalue() {
    if($("#store").val() == "") {
        $("#store").addClass("ui-state-error");
        return false;
    }
    else {
        $("#store").removeClass("ui-state-error");
        return true;
    }
}

function disablePayUpdating() {
    $('#checkboxpercent').attr('onclick', 'return false;');
    $('#checkboxpercent').attr('onkeydown', 'return false;');

    $("#tiengiam").attr("readonly", true);
    $("#duatruoc").attr("readonly", true);
}

$(function() {
    // submit
    $("#form-cthd").submit(function() {
        pay();
    });

    $("#delivery-form").submit(function() {
        return checkStorevalue();
    });

    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    $("#delivery-dialog").dialog({
        autoOpen: false,
        height: 155,
        width: 350,
        modal: true,
        buttons: {
            "Ok": function() {
                $("#delivery-form").submit();
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });
});