// del row
// material_category

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
	var row = material_category[id_row];
	if (row) {
		$('#fedit_id').val(row[0]);
		$('#fedit_title').html(row[0]);
		$('#fedit_id_category').val(row[1][0]);
		$('#fedit_name_material').val(row[2]);
                $('#fedit_spec').val(row[3]);
		$('#fedit_price_high').val(row[4]);
		$('#fedit_price_low').val(row[5]);
		$('#fedit_unit').val(row[6][0]);
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
		$('#fedit_id_category').val("");
		$('#fedit_name_material').val("");
                $('#fedit_spec').val("");
		$('#fedit_price_high').val("");
		$('#fedit_price_low').val("");
		$('#fedit_unit').val("");

		$('#fadd_id_category').val("");
		$('#fadd_name_material').val("");
                $('#fadd_spec').val("");
		$('#fadd_price_high').val("");
		$('#fadd_price_low').val("");
		$('#addt_unit').val("");
		fpopup.close();
	});

	$('#fedit_price_high, #fedit_price_low, #fadd_price_low, #fadd_price_high').keyup(function(event) {
		var price = $(this).val();
		$(this).val(number2string(format_num(price)));
	});

});
