<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"> -->
<!-- <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script type="text/javascript" charset="utf-8">
    data_category = {};
   jQuery(document).ready(function($) {
        var _id = '<?php echo $_id; ?>';
        var oTable = $('#example').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "../ajaxserver/detail_list_group_construction_server.php?token="+_id,
            "aoColumnDefs": [
            { "sClass": "center", "aTargets": [ 0, 1, 2] }
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                data_category[aData[1][0]] = aData; 
                $('td:eq(0)', nRow).html(aData[1][1]);
                $('td:eq(1)', nRow).html("<label style='text-align: center; color: blue;'>" + number2string(aData[2]) + "</label>");
                 $('td:eq(2)', nRow).html('<input class="editrow" type="button" value="edit" onclick="editrow(\''+aData[1][0]+'\')"> <input class="delrow" type="button" value="del" onclick="delrow(\''+aData[1][0]+'\')">');
            }
        });
        $('.chosen').chosen();
        $('#fadd_group_category').change(function(event) {
            var val = $('#fadd_group_category').val();
            var path = "ajaxserver.php?action=detail_list_group_construction&do=getlistcategory&group_category="+val;
            $.get(path, function(data) {
                var json = $.parseJSON(data);
                if (json.result == 1) {
                    data = json.data;
                    var fm = "<option value='{0}'>{1}</option>";
                    var html = "";
                    for (var i = 0; i < data.length; i++) {
                        var obj = data[i];
                        html += String.format(fm, obj[0], obj[1]);
                    }
                    $('#fadd_idcategory').html(html);
                    $('#fadd_idcategory').trigger('chosen:updated');
                }
            });
        });

        $('#fedit_group_category').change(function(event) {
            var val = $('#fedit_group_category').val();
            var path = "ajaxserver.php?action=detail_list_group_construction&do=getlistcategory&group_category="+val;
            $.get(path, function(data) {
                var json = $.parseJSON(data);
                if (json.result == 1) {
                    data = json.data;
                    var fm = "<option value='{0}'>{1}</option>";
                    var html = "";
                    for (var i = 0; i < data.length; i++) {
                        var obj = data[i];
                        html += String.format(fm, obj[0], obj[1]);
                    }
                    $('#fedit_idcategory').html(html);
                    $('#fedit_idcategory').trigger('chosen:updated');
                }
            });
        });

        $('input[name="exit"]').click(function(event) {
            $('#fadd_cost').val("");
            fpopup.close();
        });
        $('#fadd_cost, #fedit_cost').keyup(function(event) {
            var price = $(this).val();
            $(this).val(number2string(format_num(price)));
        });

        $('#fedit_num_phone, #fadd_num_phone').keyup(function(event) {
            var num_phone = $(this).val();
            $(this).val(format_num(num_phone));
        });
   });

   function checkvaluefadd() {
        var cost = $('#fadd_cost').val();
        if (cost == '') {
            return false;
        } 
        return true;
   }

   function checkvaluefedit() {
        var cost = $('#fedit_cost').val();
        if (cost == '') {
            return false;
        } 
        return true;
   }
   // 
   function addrow() {
        show_popup_add();
    };

    function show_popup_add() {
        fpopup = $('#f_add').bPopup({modalClose: false});
    };
    // 
    function delrow(id_row) {
        $('#id_del').val(id_row);
        show_popup_del('Bạn muốn xóa row: ' + id_row);
    };

    function show_popup_del(title) {
        $('#f_del .title').html(title);
        fpopup = $('#f_del').bPopup({modalClose: false});
    };
    /*----------  edit row  ----------*/
    
    function editrow(id_row) {
        var row = data_category[id_row];
        if (row) {
            $('#fedit_id').val(id_row);
            $('#fedit_idcategory').val(row[1][0]);
            $('#fedit_idcategory').trigger('chosen:updated');
            $('#fedit_cost').val(row[2]);
            show_popup_edit();
        }
    };

    function show_popup_edit() {
        fpopup = $('#f_edit').bPopup({modalClose: false});
    };
</script>