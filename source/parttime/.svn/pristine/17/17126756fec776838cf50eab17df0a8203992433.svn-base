// del row
// list_provider

function delrow(id_row) {
	$('#id_del').val(id_row);
	show_popup_del('Bạn muốn xóa row với mã: ' + id_row);
};

function show_popup_del(title) {
	$('#f_del .title').html(title);
	fpopup = $('#f_del').bPopup({modalClose: false});
};

// edit row
function editrow(id_row) {
	var row = list_provider[id_row];
	if (row) {
		$('#fedit_id').val(row[0]);
		$('#fedit_title').html(row[0]);
		$('#fedit_name').val(row[1]);
		$('#fedit_address').val(row[2]);
		$('#fedit_num_phone').val(row[3]);
		$('#fedit_id_category').val(row[4][0]);
		$('#fedit_id_produce').val(row[5]);
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
		$('#fedit_id').val("");
		$('#fedit_title').html("");
		$('#fedit_name').val("");
		$('#fedit_address').val("");
		$('#fedit_num_phone').val("");
		$('#fedit_id_category').val("");
		$('#fedit_id_produce').val("");

		$('#fadd_name').val("");
		$('#fadd_address').val("");
		$('#fadd_num_phone').val("");
		$('#fadd_id_category').val("");
		$('#fadd_id_produce').val("");
		fpopup.close();
	});

	$('#fedit_num_phone, #fadd_num_phone').keyup(function(event) {
		/* Act on the event */
		var num_phone = $(this).val();
		$(this).val(format_num(num_phone));
	});
});
