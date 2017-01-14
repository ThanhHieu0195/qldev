function createDeleteButton(item) {  
    var id = "upload_" + item;
    var onClick = "deleteItem('" + item + "', '" + id + "')";
    var html = "<input onclick=\"" + onClick + "\" class=\"button\" type=\"button\" value=\"Xóa\">";
    html = "<div id=\"" + id + "\">" + html + "</div>";
    
    return html;
}

// Them dau tick da thu tien
function createTickIcon() {   
    return "<img alt=\"tick_circle\" src=\"../resources/images/icons/tick_circle.png\">";
}

// Loading image
function createLoadingIcon() {   
    return "<img alt=\"loading\" src=\"../resources/images/loading.gif\">";
}

function deleteItem(item, id) {
    id = "#" + id;
    var originalHtml = $(id).html();
    $(id).html(createLoadingIcon());
    //$('#example_processing').css('visibility', 'visible');
    
    // Gửi yêu cầu ajax thu tiền
    $.ajax({
        url: "../ajaxserver/upload_detail_server.php",
        type: 'POST',
        data: 'item=' + item,  // item=xxx
        success: function (data, textStatus, jqXHR) {
            var obj = jQuery.parseJSON(data);
            //alert(eval(obj.result));
            switch(eval(obj.result))
            {
                case 1:  // Thu tien giao hang
                    $(id).html(createTickIcon());
                    break;
                default:
                    $(id).html(originalHtml);
            }
            //$('#example_processing').css('visibility', 'hidden');
        }
    });
}