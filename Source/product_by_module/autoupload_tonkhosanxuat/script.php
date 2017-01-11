<script type="text/javascript">
  function uploadDone(name) {
     json = $('iframe[name="hidden_upload"]').contents().find( "body" ).html();
     if (json != "") {
        json = $.parseJSON(json);
         var htmText = '';
          if(json.result == 0) {
              $('#upload_notification').addClass('error').removeClass('information');
              htmText = json.message;
          }
          else {
              $('#upload_notification').addClass('information').removeClass('error');
              htmText = json.message;
          }        
          $('#upload_notification').show();
          $('#upload_message').html(htmText);
     }
  }
</script>