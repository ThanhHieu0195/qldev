<script type="text/javascript" charset="utf-8">
    function is_checked() {
        var num = $('input[name="checkbox[]"]:checked').length;
        if (num > 0)
            return true;
        alert("Chưa có checkbox nào được chọn!");
        return false;
    }
    jQuery(document).ready(function($) {
        $('a[action="complete-premium"]').live('click', function(event) {
            var is_ok = confirm("Hoàn tất công việc!");
          if (is_ok == false) return false;
          var _this = $(this);
          var text_data = _this.attr('data');
          var arr = text_data.split(',');
          var data = {ACCESS_AJAX:1, MODEL: 'chitietphanbu', FUNCTION:'complete', DATA:{condition:{madonhang:arr[0], masotranh:arr[1], machitiet:arr[2]} } };
          var path = "../ajaxserver/ajax_model.php";
          $.ajax({
              url: path,
              type: 'POST',
              dataType: 'text',
              data: data,
          })
              .done(function(res) {
                  json = jQuery.parseJSON(res);
                  if ( json.result == true) {
                      data['MODEL']    = 'vansanxuat';
                      data['FUNCTION'] = 'insert';
                      $.post(path, data, function(data, textStatus, xhr) {
                          alert('Thao tác thành công!');
                          $('tr').has(_this).remove();
                      });
                  } else {
                      alert('Thao tác thất bại');
                  }
              });
        });
      var oTable = $('#t_detail').dataTable( {
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": "ajaxserver.php?action=danhsachchitietphanbudangsanxuat",
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
                      var _complete = "<a class=\"button\" action=\"complete-premium\" data=\"{0}\" href=\"javascript:void(0);\">Complete</a>";
                      _complete = String.format(_complete, varible);
                      $('td:eq(10)', nRow).html(_complete);
                  }
              }
          });
});
</script>
