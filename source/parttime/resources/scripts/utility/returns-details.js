var trahang, chitiet;
var chitietmasotranh =[];
var chitietsoluong =[];
var token_id = '-1';
var  swap_uid = '-1';
var product_id = '53b213f154da7';
var reference_id = '57bad3dc209ab';
var category_id = 'CP0015';
var item_id = '57cd50b464d68';
var tukho ='33';
var denkho = '33';

$.urlParam = function(name, url) {
    if (!url) {
     url = window.location.href;
    }
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(url);
    if (!results) { 
        return undefined;
    }
    return results[1] || undefined;
}

function smg(action = "success") {
    if (action == "success") {
        $('#msg_error').hide('fast', function() {
           $('#msg_success').show(100);
        });
    } else {
        $('#msg_success').hide('fast', function() {
           $('#msg_error').show(100);
        });
    }
}
$(document).ready(function() {
    var id = $.urlParam('i'); 
    $.ajax({
        url: '../ajaxserver/returns_detail_server.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'load', trahang:1, chitiettrahang:1, id:id},
    })
    .done(function(result) {
        trahang = result['trahang'][0];
        chitiet = result['chitiettrahang'];

        if (chitiet.length==0) {
             $('#action_panel').css('display', 'none');                  
        }
        for (var i = 0; i < chitiet.length; i++) {
            chitietmasotranh.push(chitiet[i]['masotranh']);
            chitietsoluong.push(chitiet[i]['soluong']);
        }
    });

    // load data for table
    $.ajax({
        url: '../ajaxserver/return_detail_items_server.php',
        type: 'POST',
        dataType: 'json',
        data: {id: id},
    })
    .done(function(result) {
        var data = result['data'];
        console.log(data);
        var html ="";
        var approved = false;
        for (var i = 0; i < data.length; i++) {
            var id = data[i]['id'];
            var madon = data[i]['madon'];
            var masotranh = data[i]['masotranh'];
            var soluong = data[i]['soluong'];
            var giaban = data[i]['giaban'];
            if (data[i]['trangthai']==1) { approved=true;}
            var tr = "<tr><td>id</td><td>madon</td><td>masotranh</td><td>soluong</td><td>giaban</td></tr>";
            tr = tr.replace("id", id);
            tr = tr.replace("madon", madon);
            tr = tr.replace("masotranh", masotranh);
            tr = tr.replace("soluong", soluong);
            tr = tr.replace("giaban", giaban);
            html+= tr;
        }
        if (approved==false) {
            $('#action_panel').css('display', 'block');
        }
        $('#items_body').append(html);
    });

     $('#delete_result').click(function(event) {
          $('#action_panel').css('display', 'none');
          /* Act on the event */
          $.ajax({
                url: '../ajaxserver/process_trahang_server.php',
                type: 'POST',
                dataType: 'json',
                data: {action: 'delete', trahang:1, chitiettrahang:1,id:id},
            })
            .done(function() {
                $('#items_body').html("");
                console.log("success approved");
                alert('thao tác thành công!');                    
            });
            return false;
     });

     // 
    $('#reject_result').click(function(event) {
      $('#action_panel').css('display', 'none');
         /* Act on the event */
      $.ajax({
            url: '../ajaxserver/process_trahang_server.php',
            type: 'POST',
            dataType: 'json',
            data: {action: 'update', reject:1,  id:id},
        })
        .done(function() {
            console.log("success approved");
        });
        $('#items_body').html("");
        alert('thao tác thành công!');                    

        return false;
    });

    // approve phiếu trả hàng
    $('#approve_result').click(function(event) {
        $('#action_panel').css('display', 'none');
        var data_addNew = [];
        var flag = false;
        // xét token_id cho phieu tra hang
        token_id = trahang['maphieuchi']; 

        if (token_id == "0") {
              token_id = "1";
        }
         // su li chitietphan bu
        var data = {ACCESS_AJAX:1, MODEL: 'chitietphanbu', FUNCTION:'return', DATA:{madonhang:trahang['madon'], masotranh:chitietmasotranh } };
        var path = "../ajaxserver/ajax_model.php";
        $.ajax({
            url: path,
            type: 'POST',
            dataType: 'text',
            data: data,
        })
        .done(function(res) {
            json = jQuery.parseJSON(res);
            if ( json.result == true) {
            }
        });
         // tạo phiếu chuyển kho
        if (trahang['maphieuchuyenkho'] == '0') {
            denkho = trahang['makho'];
             // nhập hàng vào kho khách hàng chuyển
            $.ajax({
                url: '../ajaxserver/process_trahang_server.php',
                type: 'POST',
                dataType: 'json',
                data: {action:'add', tonkho:1, masotranh:chitietmasotranh, machuyenkho:tukho, soluong:chitietsoluong},
            })
            .done(function(result) {
                console.log("thêm hàng vào kho thành công");
                if (result['result']) {
                // tạo phiếu chuyển 
                    $.ajax({
                        url: '../ajaxserver/items_swapping_server.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {swap_items: 1, masotranh:chitietmasotranh, soluongchuyen:chitietsoluong, from:tukho, to:denkho},
                    })
                    .done(function(result_swapping) {

                        if (result_swapping['result']=='success') {
                            swap_uid = result_swapping['swap_uid'];
                            console.log(result_swapping['message']);
                            swap_note = "Khách trả hàng đơn hàng " + trahang['madon'];
                            // appoved phiếu chuyển kho
                             $.ajax({
                                url: '../ajaxserver/items_swapping_server.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {report_swapping: 1, action:'accept', swap_uid:swap_uid, swap_note:swap_note},
                            }) .done(function(result_report_swapping) {
                                $.ajax({
                                    url: '../ajaxserver/items_swapping_server.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {swap_uid:swap_uid, report_shipping:1, action:'delivery'},
                                }) .done(function(result_report_shipping) { 
                                    console.log(result_report_shipping['message']);
                                    if (result_report_shipping['result'] == "success") {
                                        $.ajax({
                                            url: '../ajaxserver/process_trahang_server.php',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {action: 'update', trahang:1, chitiettrahang:1,id:id,maphieuchuyenkho:swap_uid, maphieuchi:token_id, approve:'1'},
                                        })
                                        .done(function(result_update) {
                                            console.log("approve phiếu thành công");

                                            if (result_update['result']) {
                                                // cập nhật số lượng hàng trong đơn hàng
                                                $.ajax({
                                                    url: '../ajaxserver/process_trahang_server.php',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {action: 'update', chitietdonhang:1, madon:trahang['madon'], masotranh:chitietmasotranh, soluong:chitietsoluong, doanhsotru:1, id:id},
                                                })
                                                .done(function(result) {
                                                    console.log("cập nhật số lượng hàng thành công");
                                                    console.log(result)
                                                    if (result['result']) {
                                                        smg();
                                                    } else {
                                                        smg("error");
                                                    }
                                                });
                                            } else {
                                                smg("error");
                                            }
                                        });
                                    } else {
                                        smg("error");
                                    }
                                });

                            });
                           
                        } else {
                            smg("error");
                        }
                    });
                } else {
                    smg("error");
                }
            });
        } else {     
            // Không tạo phiếu chuyển kho
            // cập nhật phiếu trả hàng đã approve
            $.ajax({
                   url: '../ajaxserver/process_trahang_server.php',
                   type: 'POST',
                   dataType: 'json',
                   data: {action: 'update', chitiettrahang:1, trahang:1, id:id, maphieuchuyenkho:'-1', maphieuchi:token_id, approve:'1'},
            })
            .done(function(result) {
                console.log('tạo phiếu chuyển kho thành công');
                 if (result['result']) {
                      // cập nhật số lượng hàng trong đơn hàng
                      $.ajax({
                          url: '../ajaxserver/process_trahang_server.php',
                          type: 'POST',
                          dataType: 'json',
                          data: {action: 'update', chitietdonhang:1, madon:trahang['madon'], masotranh:chitietmasotranh, soluong:chitietsoluong, doanhsotru:1, id:id},
                      })
                      .done(function(result) {
                          console.log('cập nhật số lượng đơn hàng');
                          if (result['result']) {
                            smg();
                          } else {
                            smg("error");
                          }
                      });
                  } else {
                    smg("error");
                  }
            });                    
        }
        return false;
      });
});