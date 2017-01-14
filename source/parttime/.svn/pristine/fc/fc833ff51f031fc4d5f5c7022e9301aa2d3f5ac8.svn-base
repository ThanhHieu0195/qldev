<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "ajaxserver.php?action=chitietsanpham",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2, 3, 4, 5, 6 ,7, 8] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  var fm_edit = "<input type=\"button\" class=\"button\" value=\"edit\" onclick=\"show_form_edit('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}')\"/>";
                  var fm_del = "<input  type=\"button\" class=\"button\" value=\"del\" onclick=\"show_form_del('{0}')\"/>";
                  $('td:eq(1)', nRow).html( aData[1][1] );
                  if ( is_empty(aData[3]) ) {
                    aData[3] = '<?php echo IMAGE_EMPTY; ?>';
                  }
                  $('td:eq(3)', nRow).html( String.format('<a target="blank" href="{0}" id="div{1}">xem ảnh</a>', aData[3], iDisplayIndex) );
                  $('td:eq(8)', nRow).html( String.format( fm_edit, aData[0], aData[1][0], aData[2], aData[3], aData[4], aData[5], aData[6], aData[7], aData[8]) +'&nbsp;'+ String.format( fm_del, aData[0]));
                
                oTable.$('#div' + iDisplayIndex).tooltip({
                  delay: 50,
                  showURL: false,
                  bodyHandler: function() {
                      return $("<img />").attr("src", aData[3]);
                  }
                });
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

function show_form_edit(machitiet, maloai, mota, hinhanh, mausac, dai, rong, cao) {
  $('#edit-form input[name="machitiet"]').val(machitiet);
  $('#edit-form input[name="old_machitiet"]').val(machitiet);
  $('#edit-form input[name="maloai"]').val(maloai);
  $('#edit-form textarea[name="mota"]').val(mota);
  $('#edit-form input[name="mausac"]').val(mausac);
  $('#edit-form input[name="dai"]').val(dai);
  $('#edit-form input[name="rong"]').val(rong);
  $('#edit-form input[name="cao"]').val(cao);

  popup_form = $('#edit-form').bPopup({
     modalClose: false,
    position: [450, 0]
  });
}

function show_form_del(machitiet) {
  $('#del-form input[name="machitiet"]').val(maloai);
  popup_form = $('#del-form').bPopup(); 
}
function checkvalueAdd() {
  var machitiet = $('#add-form input[name = "machitiet"]').val();
  if ( is_empty(machitiet) ) {
    $('#add-form input[name = "machitiet"]').parent().css('color', 'red').append('&nbsp;<span class="notify">is empty</span>');
    return false;
  } 
}
</script>
