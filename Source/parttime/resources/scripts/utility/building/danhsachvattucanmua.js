var oTable; // Datatables

function getAjaxSource() {
    return String.format("../ajaxserver/vattucanmua_server.php?nhomkhach={0}", 
                        $('#nhomkhach').val()
            );
}

function refreshData() {
    if (oTable != null && oTable !== undefined) {
        oTable.fnReloadAjax(getAjaxSource());
    }
}

//Export file excel
function export2Excel() {
    //alert(type);
    var nhomkhach = $("#nhomkhach");
    var format = "../phpexcel/export2exel.php?do=export&table=danhsachkhachhang&nhomkhach={0}";
    var url;
    {
        url = String.format(format, nhomkhach.val());
        //window.location = url;
        var win = window.open(url, '_blank');
        win.focus();
    }
}

$(function() {
                oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "iDisplayLength": 50,
                    "sAjaxSource": getAjaxSource(),
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 0, 1, 2, 3, 4, 5, 6 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        console.log(aData);
                        $('td:eq(0)', nRow).html("<a title='Sửa thông tin' href='../guest/guestdetail.php?item=" + aData[0] + "'>" + aData[0] + "</a>");
                        $('td:eq(1)', nRow).html("<span style='color:blue;'>" + aData[1] + "</span>");
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html(aData[4]);
                        $('td:eq(5)', nRow).html(aData[5]);
                        $('td:eq(6)', nRow).html(aData[6]);
                        $('td:eq(7)', nRow).html(aData[7]);
                        $('td:eq(8)', nRow).html("<a title='Xóa khách hàng này' onclick='return confirm(\"Bạn có chắc không?\");'" +
                                                 "   href='delguest.php?item=" + aData[0] + "'>" +
                                                 "    <img alt='Delete' src='../resources/images/delete2.jpg'></a>");
                    }
                });
            });
