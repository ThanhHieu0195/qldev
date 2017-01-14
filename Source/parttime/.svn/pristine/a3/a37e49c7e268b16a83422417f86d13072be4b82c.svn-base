<script type="text/javascript" charset="utf-8">
list_status = ['', 'Mới', 'Chờ duyệt', 'Hoàn thành', 'Từ chối' ];
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "../ajaxserver/list_result_work_server.php?account=<?php echo $account; ?>",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2, 3, 4, 5, 6] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  $('td:eq(0)', nRow).html( String.format("<a target=\"_blank\" href=\"work_detail.php?token={0}\">{0}</a>", aData[1]) );
                  $('td:eq(1)', nRow).html( aData[2].substr(0, 50) );
                  $('td:eq(2)', nRow).html( aData[3] );
                  $('td:eq(3)', nRow).html( aData[4] );
                  $('td:eq(4)', nRow).html( aData[5]);
                  $('td:eq(5)', nRow).html( list_status[aData[6]] );
                  $('td:eq(6)', nRow).html( String.format("<a target=\"_blank\" href=\"update_result_work.php?token={0}\">Cập nhật</a>", aData[0]) );
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
