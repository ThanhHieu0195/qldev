// Enable mot selector
function SetEnabled(selector) {
    $(selector).removeAttr("disabled");
}

// Disable mot selector
function SetDisabled(selector) {
    $(selector).attr("disabled", "disabled");
    // $(selector).attr("visible", "false");
}

String.format = function(text) {
    // check if there are two arguments in the arguments list
    if (arguments.length <= 1) {
        // if there are not 2 or more arguments there's nothing to replace
        // just return the original text
        return text;
    }
    // decrement to move to the second argument in the array
    var tokenCount = arguments.length - 2;
    for (var token = 0; token <= tokenCount; token++) {
        // iterate through the tokens and replace their placeholders from the
        // original text in order
        text = text.replace(new RegExp("\\{" + token + "\\}", "gi"),
                arguments[token + 1]);
    }
    return text;
};

function stripText(str, maxCount) {
    if (str.length <= maxCount) {
        return str;
    }

    return str.substring(0, maxCount) + " ...";
}

// Reload page
function ReloadPage() {
    location.reload();
};

// Disable autocomplete
function disableAutocomplete() {
    $("input").attr("autocomplete", "off");
}

Number.prototype.formatMoney = function(c, d, t) {
    var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "."
            : d, t = t == undefined ? "," : t, s = n < 0 ? "-" : "", i = parseInt(n = Math
            .abs(+n || 0).toFixed(c))
            + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "")
            + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
            + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

// DOM load
$(function() {
    // ID field
    $(".uid").alphanumeric({
        allow : "_"
    });
})