// Enable mot selector
function SetEnabled(selector) {
    $(selector).removeAttr("disabled");
}

// Disable mot selector
function SetDisabled(selector) {
    $(selector).attr("disabled", "disabled");
    //$(selector).attr("visible", "false");
}

String.format = function(text) {
    //check if there are two arguments in the arguments list
    if ( arguments.length <= 1 ) {
        //if there are not 2 or more arguments there's nothing to replace
        //just return the original text
        return text;
    }
    //decrement to move to the second argument in the array
    var tokenCount = arguments.length - 2;
    for( var token = 0; token <= tokenCount; token++ ) {
        //iterate through the tokens and replace their placeholders from the original text in order
        text = text.replace( new RegExp( "\\{" + token + "\\}", "gi" ),
                                                arguments[ token + 1 ] );
    }
    return text;
};

// Reload page
function ReloadPage() {
   location.reload();
};

// Disable autocomplete
function disableAutocomplete() {
    $("input").attr("autocomplete", "off");
}

// DOM load
$(function() {
    // ID field
    $(".uid").alphanumeric({allow:"_"});
})