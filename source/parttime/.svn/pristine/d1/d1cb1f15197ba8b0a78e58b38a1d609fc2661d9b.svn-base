
jQuery(document).ready(function($) {
  if (list_all_data.length > 0) {
      for (var i = 0; i < list_all_data.length; i++) {
          var obj = list_all_data[i];
          if (listData[obj['EMPLOYEE_ID']]) {
              obj =  listData[obj['EMPLOYEE_ID']];
          } else {
              obj['DAY_LEAVE'] = 0;
          }
          var fm = "<tr> <td><a href='../employees/employeedetail.php?item={0}'>{0}</a></td> <td><a href='#' onClick=\"detail_leave('{0}')\">{1}<a></td> <td>{2}</td> <td><input type='checkbox' value='{0}' name='listcheck[]'/></td></tr>";
          var html = String.format(fm, obj['EMPLOYEE_ID'], obj['DAY_LEAVE'], obj['DAY_LEAVE_MAX']);
          $('#tstatistic > tbody').append(html);     
      }
  } else {
    $('#btnexport, #btnreset').remove();
  }

  $('#tstatistic').dataTable({
    "bSort" : false,
    "iDisplayLength": 50
  });
  $('#btnexport').click(function(event) {
      /* Act on the event */
      var obj = $('input[type=checkbox]:checked');
      if (obj.length == 0) {
          alert('Chưa có checkbox nào được chọn');
          return false;
      }
      return true;
  });
  // sự kiện click nút reset
  $('#btnreset').click(function(event) {
      /* Act on the event */
      var obj = $('input[type=checkbox]:checked');
      if (obj.length == 0) {
          alert('Chưa có checkbox nào được chọn');
          return false;
      }

      if (checkValueReset()) {
        flag_reset = false;
        return true;
      }
      return false;
  });

  // su kiên click trong form reset
  $('#b_reset').click(function(event) {
    /* Act on the event */
    var max_leave = $('#v_reset').val();
    if (max_leave != "") {
        $('#max_num_leave').val(max_leave);
        flag_reset = true;
        rform.close();
        $('#btnreset').click();
    }
  });
  // Nhập float 
   $('#v_reset').keypress(function(event) {
        if((event.which < 46
        || event.which > 59) && event.which != 8) {
            event.preventDefault();
        } // prevent if not number/dot

        if(event.which == 46
        && $(this).val().indexOf('.') != -1) {
            event.preventDefault(); 
        } // prevent if already dot
    });

});

flag_reset = false;
// kiểm tra form reset
function checkValueReset() {
  if (flag_reset == false) {
      rform = $('#rform').bPopup();
      return false;
  }
  return true;
}
function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}
// Sự kiện khi thao tác với server hoàn thanh
function uploadDone(name) {
   var frame = getFrameByName(name);
   if (frame) {
     ret = frame.document.getElementsByTagName("body")[0].innerHTML;
 
     /* If we got JSON, try to inspect it and display the result */
     if (ret.length) {
       /* Convert from JSON to Javascript object */
       try {
            //var json = eval("("+ret+")");
            json = $.parseJSON(ret);
            if (json.result == 2) {
                  window.location="";
            }
       }
       catch(err) {
            //Handle errors here
       }
     }
  }
}

function detail_leave(employee_id) {
  if (listDetail[employee_id]) {
    $('#dform > table > tbody').html("");
    var arr = listDetail[employee_id];
    var fm = "<tr> <td>{0}</td> <td>{1}</td> </tr>";
    var html = ""
    for (var i = 0; i < arr.length; i++) {
       var obj = arr[i];
       html += String.format(fm, obj['DATE'], obj['DAY_LEAVE']);
    }
    $('#dform > table > tbody').html(html);
    $('#dform').bPopup();
  }
}

$('#dform > img').click(function(event) {
  /* Act on the event */
  $('#dform').bPopup().close();
});

$('#allchecked').click(function(event) {
  /* Act on the event */
  var obj = $('input[name="listcheck[]"]');
  var checked = $('#allchecked')[0].checked;
  for (var i = 0; i < obj.length; i++) {
    obj[i].checked = checked;
  }
});
