<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "ajaxserver.php?action=kehoachsanxuatchitiet",
              "aoColumnDefs": [
                  { "sClass": "center", "aTargets": [0, 1, 2, 3, 4, 5, 6 ,7, 8, 9] }
              ],
              "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  console.log(aData);
                  var fm_edit = "<input type=\"button\" class=\"button\" value=\"edit\" onclick=\"show_form_edit('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}')\"/>";
                  var fm_del = "<input  type=\"button\" class=\"button\" value=\"del\" onclick=\"show_form_del('{0}')\"/>";
                  $('td:eq(1)', nRow).html( aData[1][1] );
                  if ( is_empty(aData[3]) ) {
                    aData[3] = '<?php echo IMAGE_EMPTY; ?>';
                  }
                  $('td:eq(3)', nRow).html( String.format('<a target="blank" href="{0}" id="div{1}">xem ảnh</a>', aData[3], iDisplayIndex) );
                  //$('td:eq(10)', nRow).html( String.format( fm_edit, aData[0], aData[1][0], aData[2], aData[3], aData[4], aData[5], aData[6], aData[7], aData[8]) +'&nbsp;'+ String.format( fm_del, aData[0]));
                
                oTable.$('#div' + iDisplayIndex).tooltip({
                  delay: 50,
                  showURL: false,
                  bodyHandler: function() {
                      return $("<img />").attr("src", aData[3]);
                  }
                });
              }
          });

});
</script>
