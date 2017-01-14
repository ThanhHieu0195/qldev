<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "../ajaxserver/list_approve_server.php",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2, 3, 4, 5] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  $('td:eq(0)', nRow).html( String.format("<a target=\"_blank\" href=\"work_detail.php?token={0}\">{0}</a>", aData[1]) );
                  $('td:eq(1)', nRow).html( aData[2].substr(0, 50) );
                  $('td:eq(2)', nRow).html( aData[3] );
                  $('td:eq(3)', nRow).html( aData[4] );
                  $('td:eq(4)', nRow).html( String.format("<a target=\"_blank\" href=\"../employees/employeedetail.php?item={0}\">{0}</a>", aData[5]) );
                  var btn_approve = "<input type='button' class='button' name='approve-work' value='approve' onclick='approve({0}, {1})'/>";
                  var btn_reject = "<input type='button' class='button' name='reject-work' value='reject' onclick='reject({0})'/>";
                  $('td:eq(5)', nRow).html( String.format(btn_approve, aData[0], aData[1]) + " &nbsp;" +String.format(btn_reject, aData[0]) );
              }
          });
});

function approve(id, idcongviec) {
  path = "../ajaxserver/list_approve_process_server.php";
  $.post(path, {'id': id, 'idcongviec': idcongviec, 'action':'approve'}, function(data, textStatus, xhr) {
      json = $.parseJSON(data);
      if (json.result == 1) {
        alert("Thao tác thành công!");
        window.location = "";
      } else {
        alert("Thao tác thất bại!");
      }
  }); 
}

function reject(id) {
  path = "../ajaxserver/list_approve_process_server.php";
  $.post(path, {'id': id, 'action':'reject'}, function(data, textStatus, xhr) {
      json = $.parseJSON(data);
      if (json.result == 1) {
        alert("Thao tác thành công!");
        window.location = "";
      } else {
        alert("Thao tác thất bại!");
      }
  }); 
}
</script>