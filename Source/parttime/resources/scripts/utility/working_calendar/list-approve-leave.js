function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}

function uploadDone(name) {
   var frame = getFrameByName(name);
   if (frame) {
     ret = frame.document.getElementsByTagName("body")[0].innerHTML;
 
     /* If we got JSON, try to inspect it and display the result */
     if (ret.length) {
       /* Convert from JSON to Javascript object */
       try {
            //var json = eval("("+ret+")");
            json = $.parseJSON(ret);
            console.log(json);
            if (json.result == 1 || json.result == -1) {
                var id = json.id+"";
                var row = String.format("#{0} > .trangthai", id);
                if (json.result == 1)
                    $(row).html('approved');
                else 
                    $(row).html('rejected');
            } else {
                alert('Thao tác thất bại')
            }
       }
       catch(err) {
            //Handle errors here
       }
     }
  }
}