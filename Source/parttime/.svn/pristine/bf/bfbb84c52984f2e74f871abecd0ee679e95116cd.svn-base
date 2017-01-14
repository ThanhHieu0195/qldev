<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "ajaxserver.php?action=danhsachsanphammodule",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                var img = '<a href="../{0}" target="blank"><img src="../{0}" style="height:100px;"/></a>';
                var chitiet = '<a target="blank" href="chitietsanphammapping.php?token='+aData[0]+'">chi tiết<a/>';
                  $('td:eq(7)', nRow).html( String.format(img, aData[7]) );
                  $('td:eq(8)', nRow).html( chitiet );
              }
          });

});
</script>
