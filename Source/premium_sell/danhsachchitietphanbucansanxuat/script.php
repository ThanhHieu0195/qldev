<script type="text/javascript" charset="utf-8">
    function is_checked() {
        var num = $('input[name="checkbox[]"]:checked').length;
        if (num > 0)
            return true;
        alert("Chưa có checkbox nào được chọn!");
        return false;
    }
    jQuery(document).ready(function($) {

      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "ajaxserver.php?action=danhsachchitietphanbucansanxuat",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  if (aData[0] != '') {
                      $(nRow).css('color','red');
                      $(nRow).css('font-style','italic');
                      $('td:eq(0)', nRow).html('');
                      $('td:eq(1)', nRow).html(aData[0]);
                      $('td:eq(2)', nRow).html('');
                      $('td:eq(3)', nRow).html('');
                      $('td:eq(4)', nRow).html('');
                      $('td:eq(5)', nRow).html('');
                      $('td:eq(6)', nRow).html('');
                      $('td:eq(7)', nRow).html('');
                      $('td:eq(8)', nRow).html('');
                      $('td:eq(9)', nRow).html('');
                      $('td:eq(10)', nRow).html('');
                  } else {
                      $('td:eq(0)', nRow).html(aData[1]);
                      $('td:eq(1)', nRow).html(aData[2]);
                      $('td:eq(2)', nRow).html(aData[3]);
                      $('td:eq(3)', nRow).html(aData[4]);
                      $('td:eq(4)', nRow).html(aData[5]);
                      $('td:eq(5)', nRow).html(aData[6]);
                      $('td:eq(6)', nRow).html(aData[7]);
                      $('td:eq(7)', nRow).html(aData[8]);
                      $('td:eq(8)', nRow).html(aData[9]);
                      $('td:eq(9)', nRow).html(aData[10]);
                      var varible =  aData[1] +','+aData[2]+','+aData[3];
                      var _checkbox = "<input type='checkbox' name='checkbox[]' value='"+varible+"'/>";
                      $('td:eq(10)', nRow).html(_checkbox);
                  }
              }
          });
});
</script>
