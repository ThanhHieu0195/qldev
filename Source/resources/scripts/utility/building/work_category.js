// del row
// work_category

function delrow(id_row) {
	$('#id_del').val(id_row);
	show_popup_del('Bạn muốn xóa row: ' + id_row);
};

function show_popup_del(title) {
	$('#f_del .title').html(title);
	fpopup = $('#f_del').bPopup({modalClose: false});
};

// edit row
function editrow(id_row) {
	var row = work_category[id_row];
	if (row) {
		$('#fedit_id').val(row.id);
		$('#fedit_title').html(row.id);
		$('#fedit_id_category').val(row.idhangmuc);
		$('#fedit_describe').val(row.motacongviec);
		$('#fedit_target_complete').val(row.tieuchihoanthanh);
		show_popup_edit();
	}
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