// Site: http://joekuan.wordpress.com/2009/06/12/ajax-a-simplified-version-of-file-upload-form-using-iframe/
function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}

/* Same as the one defined in OpenJS */
function uploadDone(name) {
   var frame = getFrameByName(name);
   if (frame) {
     ret = frame.document.getElementsByTagName("body")[0].innerHTML;
 
     /* If we got JSON, try to inspect it and display the result */
     if (ret.length) {
       /* Convert from JSON to Javascript object */
       try {
            var json = eval("("+ret+")");
            /* Process data in json ... */
            var htmText = '';
            if(json.result == 0) {
                $('#upload_notification').addClass('error').removeClass('information');
                htmText = json.message;
            }
            else {
                $('#upload_notification').addClass('information').removeClass('error');
                var obj = { br : "<br />", boldopen : "<b>", boldclose : "</b>", openspan : "<span", close : ">", closespan: "</span" };
                var result = '';
                if(json.detail != '') {
                    result = json.detail.replace(/:(\w+)(\/|\b)/g, function(substring, match, nextMatch) {
                        return obj[match] + nextMatch;
                    });
                }
                htmText = "<span class='blue-violet'>" + json.progress + "</span><br />";
                htmText += result;
            }        
            $('#upload_notification').show();
            $('#upload_message').html(htmText);
       }
       catch(err) {
            //Handle errors here
            $('#upload_message').html(err);
       }
       /* Clear value of upload control */
       $('#upload_scn').val('');
     }
  }
}

// DOM load
$(function() {    
    $('#upload_notification').hide();
});