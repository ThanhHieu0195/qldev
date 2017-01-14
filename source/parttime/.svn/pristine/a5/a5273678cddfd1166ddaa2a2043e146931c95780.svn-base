// del row
function delrow(id_row) {
	$('#id_del').val(id_row);
	show_popup_del('Bạn muốn xóa row: ' + id_row);
};

function show_popup_del(title) {
	$('#f_del .title').html(title);
	fpopup = $('#f_del').bPopup({modalClose: false});
};

// edit row
function editrow(id_row, describe) {
	$('#fedit_id').val(id_row);
	$('#fedit_title').html(id_row);
	$('#fedit_describe').val(describe);
	show_popup_edit();
};

function show_popup_edit() {
	fpopup = $('#f_edit').bPopup({modalClose: false});
};
// add row 

function addrow() {
	show_popup_add();
};

function show_popup_add() {
	fpopup = $('#f_add').bPopup({modalClose: false});
};

$(document).ready(function() {
	$('input[name="exit"]').click(function(event) {
		$('#id_del').val("");
		$('#f_del .title').html("");

		$('#fedit_id').val("");
		$('#fedit_title').html("");
		$('#fedit_describe').val("");

		$('#fadd_describe').val("");
		fpopup.close();
	});
});