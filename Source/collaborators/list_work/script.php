<script type="text/javascript" charset="utf-8">
list_status = ['Chờ nhận', 'Đã đóng' ];
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "../ajaxserver/list_work_server.php",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [1, 2, 3,  4] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  $('td:eq(0)', nRow).html( aData[1].substr(0, 50) + ' ...' );
                  $('td:eq(1)', nRow).html( aData[2] );
                  $('td:eq(2)', nRow).html( number2string(aData[3]) );
                  $('td:eq(3)', nRow).html( list_status[aData[4]] );
                  $('td:eq(4)', nRow).html( String.format("<a target=\"_blank\" href=\"work_detail.php?token={0}\">Chi tiết</a>", aData[0]) );
              }
          });
});
</script>
