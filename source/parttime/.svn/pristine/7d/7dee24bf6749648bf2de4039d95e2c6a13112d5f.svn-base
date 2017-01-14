function number2string(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function showDialog(ma_hd, madon, money, amount, type, note) {
// Reset controls
//    console.log(amount);
    $('#f_type').val(type);
    $("#f_id").val(ma_hd);
    $("#donhangid").val(madon);
    $("#amount").val(amount);
    $('#money_amount').val(money);
    $('#moneyr').text(number2string(money));
    $('#note').val(note);
// Show the dialog
    $('#cashing_dialog').bPopup({
        escClose: false,
        modalClose: false
    });
}

function createCashButton(ma_hd, ma_dh, money, amount, type, note) {
    var htmlStr = String.format("<a href='javascript:showDialog(\"{0}\",\"{1}\",\"{2}\",\"{3}\",\"{4}\",\"{5}\");' rel='modal' title='Trả tiền'>\
           <img src='../resources/images/icons/user_16.png' alt='Add'>\
       </a>", ma_hd, ma_dh, money, amount, type, note);
    return htmlStr;
}

function cashedDone() {
    var obj = $('#hidden_worker')[0];
    text = obj.contentDocument.firstChild.innerText;
    try {
         var json = $.parseJSON(text);
         /* Process data in json ... */
         if (json.result == "success") {
             // Close the detail dialog
             $('#cashing_dialog').bPopup().close();

             // cập nhật table
             var row_del = String.format("#{0}", $('#f_id').val());
             $(row_del).remove();
             // thông báo
             var type =  $('#floai').val();
             var smg = $('#msg_success').html() + String.format("Phiếu chi {0} đã được được tạo thành công", json.maphieuchi);
             $('#msg_success').html(smg);
             $('#msg_error').hide('fast', function() {
                 $('#msg_success').show(400);
             });

         } else {
             showNotification("error", json.message);

         }

    }
    catch(err) {
         //Handle errors here
         showNotification('error', err);
    }

    obj.contentDocument.firstChild.innerHTML = '';
 }

function showNotification(type, message) {
    var html = "";

    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";

    $('#notification_msg').html(html);
}
