<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "ajaxserver.php?action=loaichitietsanpham",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  var fm_edit = "<input type=\"button\" class=\"button\" value=\"edit\" onclick=\"show_form_edit('{0}', '{1}')\"/>";
                  var fm_del = "<input  type=\"button\" class=\"button\" value=\"del\" onclick=\"show_form_del('{0}')\"/>";
                  $('td:eq(0)', nRow).html( aData[0] );
                  $('td:eq(1)', nRow).html( aData[1] );
                  $('td:eq(2)', nRow).html( String.format( fm_edit, aData[0], aData[1]) +'&nbsp;'+ String.format( fm_del, aData[0]));
              }
          });

      $('.render_popup_form .exit').click(function(event) {
          popup_form.bPopup().close();
      });
});
function show_form_add() {
  popup_form = $('#add-form').bPopup(); 
}

function show_form_edit(maloai, mota) {
  $('#edit-form input[name="maloai"]').val(maloai);
  $('#edit-form input[name="old_maloai"]').val(maloai);
  $('#edit-form textarea[name="mota"]').val(mota);
  popup_form = $('#edit-form').bPopup(); 
}

function show_form_del(maloai) {
  $('#del-form input[name="maloai"]').val(maloai);
  popup_form = $('#del-form').bPopup(); 
}
</script>
