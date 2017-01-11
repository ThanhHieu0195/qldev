function format_num(num) {
	return num = (num + '').replace(/[^0-9+\-Ee]/g, '');
}

function number2string(x) {
   return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function is_all_empty(params) {
	for (var i = 0; i < params.length; i++) {
		if ( !is_empty(params[i]) ) {
			return false;
		}
	}
	return true;
}

function is_empty(param) {
	if (param == "") {
		return true;
	}
	return false;
}
