/*----------  function orther  ----------*/
function format_num(num) {
	return num = (num + '').replace(/[^0-9+\-Ee]/g, '');
}

function number2string(x) {
   return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}