 /*
  * Finance type
 */
var FINANCE_RECEIPT = 0; // Thu
var FINANCE_PAYMENT = 1; // Chi
var FINANCE_BOTH = 101; // Thu & Chi

function getFinanceTypeName(type) {
    switch(type) {
        case FINANCE_RECEIPT: return "Thu";
        case FINANCE_PAYMENT: return "Chi";
        case FINANCE_BOTH: return "Thu & Chi";
        default: return "Unknown";
    }
}