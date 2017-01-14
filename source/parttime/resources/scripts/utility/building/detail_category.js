function delrow(id_row, table) {
	$('#id_del').val(id_row);
	$('#f_del_table').val(table);
	show_popup_del('Bạn muốn xóa id_row: ' + id_row);
};

function show_popup_del(title) {
	$('#f_del .title').html(title);
	fpopup = $('#f_del').bPopup({modalClose: false});
};

$(document).ready(function() {
	$('input[name="exit"]').click(function(event) {
		$('#id_del').val("");
		$('#f_del_table').val("");
		$('#f_del .title').html("");
		fpopup.close();
	});

});