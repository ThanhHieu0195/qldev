var oTable; // Datatables

function getAjaxSource() {
    return String.format("../ajaxserver/guest_list_new.php?nhomkhach={0}", 
                        $('#nhomkhach').val()
            );
}

function refreshData() {
    if (oTable != null && oTable !== undefined) {
        oTable.fnReloadAjax(getAjaxSource());
    }
}

$(function() {
                oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": getAjaxSource(),
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 0, 8 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html("<a title='Sửa thông tin' href='../guest/guestdetail.php?item=" + aData[0] + "'>" + aData[0] + "</a>");
                        $('td:eq(1)', nRow).html("<span style='color:blue;'>" + aData[1] + "</span>");
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html(aData[4]);
                        $('td:eq(5)', nRow).html(aData[5]);
                        $('td:eq(6)', nRow).html(aData[6]);
                        $('td:eq(7)', nRow).html("<a title='Liên hệ khách hàng này' " +
                                                 "   href='contact.php?i=" + aData[7] + "'>" +
                                                 "    <img alt='Call' src='../resources/images/icons/contact-16.png'></a>");
          		$('td:eq(8)', nRow).html("<a title='Xóa khách hàng này' onclick='return confirm(\"Bạn có chắc không?\");'" +
                                                 "   href='delguest_new.php?item=" + aData[8] + "'>" +
                                                 "    <img alt='Call' src='../resources/images/delete2.jpg'></a>");						 
                    }
                });
            });
