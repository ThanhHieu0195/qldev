// JavaScript Document

// This function formats numbers by adding commas
function numberFormat(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    return x1 + x2;
}

// This function removes non-numeric characters
function stripNonNumeric( str ){
    str += '';
    var rgx = /^\d|\.|-$/;
    var out = '';
    for( var i = 0; i < str.length; i++ ){
        if( rgx.test( str.charAt(i) ) ){
            if( !( ( str.charAt(i) == '.' && out.indexOf( '.' ) != -1 ) ||
                ( str.charAt(i) == '-' && out.length != 0 ) ) ){
                out += str.charAt(i);
            }
        }
    }
    return out;
}

//Lam tron so voi fix la so chu so phan thap phan
function roundNumber(dec,fix) {
	fixValue = parseFloat(Math.pow(10,fix));
	retValue = parseInt(Math.round(dec * fixValue)) / fixValue;
	return retValue;
}