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
function editrow(id_row, name, group_category, describe, construction_date, expect_cost) {
	$('#fedit_id').val(id_row);
	$('#fedit_name').val(name);
	$('#fedit_group_category').val(group_category);
	$('#fedit_describe').val(describe);
	$('#fedit_construction_date').val(construction_date);
	$('#fedit_expect_cost').val(expect_cost);
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
	$('#fedit_construction_date, #fedit_expect_cost, #fadd_construction_date, #fadd_expect_cost').keyup(function(event) {
		var val = $(this).val();
		val = format_num(val);
		val = number2string(val);
		$(this).val(val);
	});
	$('input[name="exit"]').click(function(event) {
		$('#id_del').val("");
		$('#f_del .title').html("");

		$('#fedit_id').val("");
		$('#fedit_title').html("");
		$('#fedit_describe').val("");

		$('#fadd_describe').val("");
		$('#fadd_construction_date').val("");
		$('#fadd_expect_cost').val("");
		fpopup.close();
	});
});
