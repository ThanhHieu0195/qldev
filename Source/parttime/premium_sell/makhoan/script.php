<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "ajaxserver.php?action=makhoan",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  var fm_edit = "<input type=\"button\" class=\"button\" value=\"edit\" onclick=\"show_form_edit('{0}', '{1}')\"/>";
                  var fm_del = "<input  type=\"button\" class=\"button\" value=\"del\" onclick=\"show_form_del('{0}')\"/>";
                 $('td:eq(2)', nRow).html( String.format( fm_edit, aData[0], aData[1] )  +'&nbsp;'+ String.format( fm_del, aData[0]) );
              }
          });

      $('.render_popup_form .exit').click(function(event) {
          popup_form.bPopup().close();
      });

      $('.chosen').chosen();
});
function show_form_add() {
   $('#add-form .notify').remove();
   $('#add-form textarea[name="mota"]').val('');
  popup_form = $('#add-form').bPopup(); 
}

function show_form_edit(makhoan, mota) {
  $('#edit-form input[name="makhoan"]').val(makhoan);
  $('#edit-form input[name="makhoancu"]').val(makhoan);
  $('#edit-form input[name="mota"]').val(mota);

  popup_form = $('#edit-form').bPopup({
     modalClose: false,
    position: [450, 0]
  });
}

function show_form_del(makhoan) {
    var r = confirm("Xóa phiếu: " + makhoan);
    if (r==true) {
        window.location = "?action=del&makhoan="+makhoan;
    }
}
function checkvalueAdd() {
    var makhoan = $('#add-form input[name = "makhoan"]').val();
    var mota = $('#add-form input[name = "mota"]').val();
    check = true;
    if ( is_empty(makhoan) ) {
        $('#add-form input[name = "makhoan"]').parent().css('color', 'red').append('&nbsp;<span class="notify">is empty</span>');
        check = false;
    }

    if ( is_empty(mota) ) {
        $('#add-form input[name = "mota"]').parent().css('color', 'red').append('&nbsp;<span class="notify">is empty</span>');
        check =  false;
    }
    return check;
}
</script>
