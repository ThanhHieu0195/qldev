<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "ajaxserver.php?action=chitietsanphammapping&token=<?php echo $_token; ?>",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2, 3] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  console.log(aData);
                  var fm_edit = "<input type=\"button\" class=\"button\" value=\"edit\" onclick=\"show_form_edit('{0}', '{1}', '{2}')\"/>";
                  var fm_del = "<input  type=\"button\" class=\"button\" value=\"del\" onclick=\"show_form_del('{0}')\"/>";

                  $('td:eq(0)', nRow).html( aData[0] );
                  $('td:eq(1)', nRow).html( aData[2] );
                  $('td:eq(2)', nRow).html( aData[3] );
                  $('td:eq(3)', nRow).html( String.format( fm_edit, aData[1][0], aData[1][1],aData[2]) +'&nbsp;'+ String.format( fm_del, aData[1][0]));
              }
          });

      $('.render_popup_form .exit').click(function(event) {
          popup_form.bPopup().close();
      });

     $('.number-input').numeric(); 
});
function show_form_add() {
  popup_form = $('#add-form').bPopup(); 
}

function show_form_edit(machitiet, mota, soluong) {
  $('#edit-form span[name="machitiet"]').html(mota);
  $('#edit-form input[name="old_machitiet"]').val(machitiet);
  $('#edit-form input[name="soluong"]').val(soluong);
  popup_form = $('#edit-form').bPopup(); 
}

function show_form_del(machitiet) {
  $('#del-form input[name="machitiet"]').val(machitiet);
  popup_form = $('#del-form').bPopup(); 
}
</script>
