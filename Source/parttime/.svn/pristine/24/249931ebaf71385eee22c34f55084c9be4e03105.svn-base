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
            //var json = eval("("+ret+")");
            var json = $.parseJSON(ret);
            
            /* Process data in json ... */
            var htmText = '';
            
            $('#upload_notification').show();
            $("#upload_notification").removeAttr("style");
            
            if(json.result == 0) {
                $('#upload_notification').addClass('error').removeClass('information');
                htmText = json.message;
            }
            else {
                $('#upload_notification').addClass('information').removeClass('error');
                var result = '';
                if(json.detail != '') {
                    result = json.detail.replace(/@/g, "<").replace(/#/g, ">");
                }
                htmText = "<span class='blue-violet'>" + json.progress + "</span><br />";
                htmText += result;
                
                // Reload datatable
                if(json.refresh == 1) {
                    $('#example').dataTable()._fnAjaxUpdate();
                }
                
                // Reset form
                resetFormCtrl(eval(json.flag));
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

// Reset form
function resetFormCtrl(flag) {
    switch(flag) {
        case 0: // There are no item to process
            $(".check-all").removeAttr("checked");
            $('#action-panel').hide();
            break;
            
        case -1:
            // Do nothing
        break;
    }
}

// Kiem tra chon dung cu
function isChooseItem() {
    var choosed = false;

    $("#approve-leave-days-add").find("input[type='checkbox']").each(function(index, e) {
        if($(e).attr("checked") == "checked") {
            choosed = choosed || true;
        }
    });

    return choosed;
}

// Kiem tra tinh hop le cua cac thong tin
function checkData() {    
    $("#error").text("");
    if(!isChooseItem()) {
        $("#error").text("* Chọn các hạng mục cần thực hiện!");
        
        return false;
    }
    
    return true;
}

// DOM load
$(function() {
    $("#approve-leave-days-add").submit(function() {
        if(checkData()) {
            return confirm('Bạn có chắc không?');
        }
        return false;
    })
})