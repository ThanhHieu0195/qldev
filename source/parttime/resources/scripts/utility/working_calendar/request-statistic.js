
jQuery(document).ready(function($) {
  if (list_all_employee.length > 0) {
      for (var i = 0; i < list_all_employee.length; i++) {
          var employee_id = list_all_employee[i];
          var obj = {};
          if (listData[employee_id]) {
              obj =  listData[employee_id];
          } else {
            obj['EMPLOYEE_ID'] = employee_id;
            obj['DAY_REQUEST'] = 0;
          }
          var fm = "<tr> <td><a href='../employees/employeedetail.php?item={0}'>{0}</a></td> <td><a href='#' onClick=\"detail_request('{0}')\">{1}<a></td> <td><input type='checkbox' value='{0}' name='listcheck[]'/></td></tr>";
          var html = String.format(fm, obj['EMPLOYEE_ID'], obj['DAY_REQUEST']);
          $('#tstatistic > tbody').append(html);     
      }
  } else {
    $('#btnexport, #btnreset').remove();
  }

  $('#tstatistic').dataTable({
    "bSort" : false
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
});

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

function detail_request(employee_id) {
  if (listDetail[employee_id]) {
    $('#dform > table > tbody').html("");
    var arr = listDetail[employee_id];
    var fm = "<tr> <td>{0}</td> <td>{1}</td> </tr>";
    var html = ""
    for (var i = 0; i < arr.length; i++) {
       var obj = arr[i];
       html += String.format(fm, obj['DATE'], obj['DAY_REQUEST']);
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