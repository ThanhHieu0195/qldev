$(document).ready(function() {
    $("#request_day").datepicker({
        minDate: +0,
        changeMonth: true,
        changeYear: true
    });

    // 
    for (var i = 0; i < listemployee.length; i++) {
        var employee = listemployee[i];
        var html = String.format('<option value="{0}">{0}</option>', employee, employee);
        $('#request_employee').append(html);   
    }

    $('#request_employee').chosen({disable_search_threshold: 2});
    $('#request_day_number').chosen({disable_search_threshold: 2});
    $('#addrequest').click(function(event) {
        return checkValue();
    });

    $('#request_day_number').keypress(function(event) {
        if((event.which < 46
        || event.which > 59) && event.which != 8) {
            event.preventDefault();
        } // prevent if not number/dot

        if(event.which == 46
        && $(this).val().indexOf('.') != -1) {
            event.preventDefault(); 
        } // prevent if already dot
    });

    $('#request_employee').change(function(event) {
        console.log('changed');
        /* Act on the event */
        var employee_id = $('#request_employee').val();
        if (employee_id == "") {
            $('#r_max_num_leave').hide(200);
        } else {
            var path = "../ajaxserver/working_calendar_server.php/?max_leave&employee_id="+employee_id;
            $.get(path, function(data) {
                json = jQuery.parseJSON(data);
                if (json.result == 1) {
                    var maxleave = parseFloat(json.max_leave);
                    $('#max_num_leave').val(maxleave);

                    var valleave = 0.5;
                    html = "";
                    fm = "<option value='{0}'>{0}</option>";
                    html += String.format(fm, "");
                    while (valleave <= 3) {
                        html += String.format(fm, valleave);  
                        valleave+=0.5;
                    }
                    $('#request_day_number').html(html);
                    $("#request_day_number").trigger("chosen:updated");
                    $('#r_max_num_leave').show(200);
                }
            });
        }
    });
    //loaddatatable();
});


function checkValue() {
    var manager = $('#request_employee').val();
    var day = $('#request_day').val();
    var number = $('#request_day_number').val();
    var note = $('#request_days_note').val();

    var is_check = true;

    if (manager == "") {
        is_check = false;
        $('#request_day_error').show();
    } else {
        $('#request_day_error').hide();
    }

    if (day == "") {
        is_check = false;
        $('#request_employee_error').show();
    } else {
        $('#request_employee_error').hide();
    }

    if (number == "") {
        is_check = false;
        $('#request_day_number_error').show();
    } else {
        $('#request_day_number_error').hide();
    }

    return is_check;
}

function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}

function uploadDone(name) {
   var frame = getFrameByName(name);
   if (frame) {
     ret = frame.document.getElementsByTagName("body")[0].innerHTML;
 
     /* If we got JSON, try to inspect it and display the result */
     if (ret.length) {
       /* Convert from JSON to Javascript object */
       try {
            //var json = eval("("+ret+")");
            var json = $.parseJSON(ret);
            
            /* Process data in json ... */
            var htmText = '';
            console.log(json);
            $('#upload_notification').show();
            $("#upload_notification").removeAttr("style");
            
            if(json.result == 0) {
                $('#upload_notification').addClass('error').removeClass('information');
                htmText = json.message;
            }
            else {
                $('#upload_notification').addClass('information').removeClass('error');
                htmText = json.message;
            }        
            $('#upload_notification').show();
            $('#upload_message').html(htmText);
       }
       catch(err) {
            //Handle errors here
            $('#upload_message').html(err);
       }
       /* Clear value of upload control */
       $('#upload_scn').val('');
     }
  }
}

function loaddatatable() {
    // list_leave
    var html = "";
    var fm = "<tr> <td>{0}</td> <td>{1}</td> <td>{2}</td> <td>{3}</td> <td>{4}</td> <td>{5}</td> </tr>";
    for (var i = 0; i < list_leave.length; i++) {
        var obj = list_leave[i];
        var trangthai = "đang chờ duyệt";
        if (obj.trangthai == 1) {
            trangthai = "đã duyệt";
        } else
        if(obj.trangthai == -1) {
             trangthai = "từ chối";
        }

        html += String.format(fm, obj.ngaylap, obj.ngaynghi, obj.songaynghi, obj.manv, obj.ghichu, trangthai);
    }
    $('#tleave > tbody').html(html);

    //list_request
    var html = "";
    var fm = "<tr> <td>{0}</td> <td>{1}</td> <td>{2}</td> <td>{3}</td> <td>{4}</td> <td>{5}</td> </tr>";
    for (var i = 0; i < list_request.length; i++) {
        var obj = list_request[i];
        var trangthai = "<a class='button' target='blank' href='list-approve-request.php' >xác nhận</a>";
        if (obj.trangthai == 1) {
            trangthai = "đã duyệt";
        } else
        if(obj.trangthai == -1) {
             trangthai = "đã từ chối";
        }

        html += String.format(fm, obj.ngaylap, obj.ngaylamthem, obj.songay, obj.manv, obj.ghichu, trangthai);
    }
    $('#trequest > tbody').html(html); 
}
