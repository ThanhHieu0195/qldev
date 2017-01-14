<script type="text/javascript" charset="utf-8">
    var list_group_construction = {};
    $(function() {
        var oTable = $('#example').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "../ajaxserver/list_group_construction_server.php",
            "aoColumnDefs": [
            { "sClass": "center", "aTargets": [ 0, 1, 2, 3, 4, 5] }
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                list_group_construction[aData[0]] = aData;
                $('td:eq(0)', nRow).html(aData[0]);
                $('td:eq(1)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[1] + "</label>");
                $('td:eq(2)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[2] + "</label>");
                $('td:eq(3)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[3] + "</label>");
                $('td:eq(4)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[4] + "</label>");
                $('td:eq(5)', nRow).html("<a target='blank' href ='detail_list_group_construction.php?token="+aData[0]+"'> Chi tiết </a>");
                $('td:eq(6)', nRow).html('<input class="editrow" type="button" value="edit" onclick="editrow(\''+aData[0]+'\')"> <input class="delrow" type="button" value="del" onclick="delrow(\''+aData[0]+'\')">');
            }
        });
    });
</script>