var token_id = '-1';
var product_id = '53b213f154da7';
var reference_id = '57bad3dc209ab';
var category_id = 'CP0015';
var item_id = '57cd50b464d68';

function phieuchi(id, madon, tientralai, manv, approve) {
   var data_addNew = [];
   var ngaylap = $.datepicker.formatDate('yy-mm-dd', new Date());
   $.ajax({
       url: '../ajaxserver/finance_server.php',
       type: 'POST',
       dataType: 'json',
       data: {create_new: 1, token_type: 1},
   })
   .done(function(result) {
       data_addNew = result;
       if (result['result']=='success') {
           token_id = data_addNew['token_id'];
           var note1 = 'khach tra lai hang lay tien, madon: <a href="../orders/orderdetail.php?item=' + madon + '" target="_blank">' + madon + '</a>, matrahang: <a href="../orders/returns-detail.php?i=' + id + '" target="_blank">' + id + '</a>';
           $.ajax({
               url: '../ajaxserver/finance_server.php',
               type: 'POST',
               dataType: 'json',
               data: {detail_update: true, token_type: 1, action:'add', uid:'', detail_token_id: token_id, reference_id:reference_id, product_id:product_id, category_id:category_id, item_id:item_id, perform_by:manv, money_amount:tientralai, note:note1, perform_date:ngaylap, finished_token:token_id},
           })
           .done(function(result) {
               // tạo phiếu chi thành công
               if (result['result'] != 'success') {
                   alert(result_themphieuchi['message']);
                   return false;
               } else {
                   if (approve) {
                       approvechi(token_id);
                   } else {
                       alert("Thao tac thanh cong !");
                   }
               }
           });
       }
   }); 
}

function approvechi(maphieuchi) {
   $.ajax({
       url: '../ajaxserver/process_trahang_server.php',
       type: 'POST',
       dataType: 'json',
       data: {action: 'approvechi', maphieuchi: maphieuchi},
   })
   .done(function(result) {
       if (result['result']) {
           alert("Thao tac thanh cong !");
       } else {
           alert("Thao tac that bai: " + result['message']);
       }
   });
}
