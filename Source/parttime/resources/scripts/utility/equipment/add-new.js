// Kiem tra tinh hop le cua cac thong tin
function validateData() {
    var isValid = true;
    $('.error_icon').hide();
    
    // Equiqment Id
    if($('#equipment_id').val().trim() == "") {
    	$('#error_equipment_id').show();
    	isValid = false;
    } else {
    	$('#error_equipment_id').hide();
    	isValid = isValid && true;
    }
    // Name
    if($('#name').val().trim() == "") {
    	$('#error_name').show();
    	isValid = false;
    } else {
    	$('#error_name').hide();
    	isValid = isValid && true;
    }
    // Status
    if($('#status').val().trim() == "") {
        $('#error_status').show();
        isValid = false;
    } else {
        $('#error_status').hide();
        isValid = isValid && true;
    }
    // Stored in
    if($('#stored_in').val() == null || $('#stored_in').val() == "") {
        $('#error_stored_in').show();
        isValid = false;
    } else {
        $('#error_stored_in').hide();
        isValid = isValid && true;
    }
    // Assign to
    if($('#assign_to').val() == null || $('#assign_to').val() == "") {
        $('#error_assign_to').show();
        isValid = false;
    } else {
        $('#error_assign_to').hide();
        isValid = isValid && true;
    }
    // Assign date
    if($('#assign_date').val().trim() == "") {
        $('#error_assign_date').show();
        isValid = false;
    } else {
        $('#error_assign_date').hide();
        isValid = isValid && true;
    }
    
    if(!isValid)
    	$('#attention').show();
    else
    	$('#attention').hide();

    return isValid;
}

// DOM load
$(function() {
    $('.error_icon').hide();
    $('#attention').hide();
    $("input").attr("autocomplete", "off");
    
    // datepicker
	$("#assign_date").datepicker({
        //minDate: +0,
        changeMonth: true,
        changeYear: true 
    });

    
    $('#add-new').submit(function() {
        if(validateData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    });
});