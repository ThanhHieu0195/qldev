function showOrderListDialog(masotranh) {
    // Thiet lap cac gia tri hidden tren form
    $("#item").val(masotranh);      // mã sản phẩm
    
    $('#example2').dataTable().fnClearTable();
	$('#example2').dataTable().fnDestroy();
    
    $('#example2').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bPaginate": false,
        "bFilter": false,
        "bSort": false,
        "sAjaxSource": "../ajaxserver/products_orders_server.php?masotranh=" + masotranh,
        "aoColumnDefs": [
            { "sClass": "center", "aTargets": [ 2, 3 ] }
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            $('td:eq(0)', nRow).html("<a title='Thông tin đơn hàng' target='_blank' href='../orders/orderdetail.php?item=" + aData[0] + "'>" + aData[0] + "</a>");
            $('td:eq(1)', nRow).html("<label style='color:blue;'>" + aData[3] + "</label>");
            $('td:eq(2)', nRow).html(aData[1]);
            $('td:eq(3)', nRow).html("<label style='color:#ff6600;'>" + aData[2] + "</label>");
        }
    });
    
    // Hien thi dialog
    $("#bill-dialog").dialog("open");
}

$(function() {
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
    $("#bill-dialog").dialog({
    	create: function(event, ui) {
    		
    	},
    	dialogClass: 'fixed-dialog',
        autoOpen: false,
        height: 500,
        width: 800,
        modal: true,
        buttons: {
        	Ok: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
        	$('#example2').dataTable().fnClearTable();
        	$('#example2').dataTable().fnDestroy();
        }
    });
});