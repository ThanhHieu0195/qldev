$(document).ready(function() {
    for (var i = 0; i < listData.length; i++) {
        var obj = listData[i];
        if (obj.trangthai >= -1 && obj.trangthai <= 1 && (filter_employee_id == "" || filter_employee_id == obj.manv)) {
            var fm = "<tr id={0}> <td class='manv'><a href='../employees/employeedetail.php?item={1}'>{1}</a></td> <td class='ngaynghi'>{2}</td> <td class='songaynghi'>{3}</td> <td class='lido'>{4}</td>  <td class='trangthai'>{5}</td> </tr>";
            var status = "đã nhận";
            if (obj.trangthai == 0) {
                status = String.format('<input type="button" class="button" value="xác nhận" name="action" onClick="approve(\'{0}\');"> <input type="button" class="button" value="từ chối" name="action" onClick="reject(\'{0}\');">', obj.id);
            }

            if (obj.trangthai == -1) {
                status = "từ chối";
            }
            var html = String.format(fm, obj.id, obj.manv, obj.ngaylamthem, obj.songay, obj.ghichu, status);
            $('#tapprove > tbody').append(html);     
        }
    }

    $('#tapprove').dataTable({
         "aaSorting": [[4,'asc']],
    });
});

function approve(id) {
    $.post('../ajaxserver/working_calendar_request_server.php', {id: id, processrequest:"", action:"approve"}, function(data, textStatus, xhr) {
        json = jQuery.parseJSON(data);
        if (json.result == 1) {
            id = String.format("#{0} > .trangthai", id);
            $(id).html("đã nhận");
        }
    });
}

 function reject(id) {
    $.post('../ajaxserver/working_calendar_request_server.php', {id: id, processrequest:"", action:"reject"}, function(data, textStatus, xhr) {
        json = jQuery.parseJSON(data);
        if (json.result == -1) {
            id = String.format("#{0} > .trangthai", id);
            $(id).html("từ chối");
        }
    });
}