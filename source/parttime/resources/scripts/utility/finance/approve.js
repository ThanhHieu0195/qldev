// Site: http://joekuan.wordpress.com/2009/06/12/ajax-a-simplified-version-of-file-upload-form-using-iframe/
function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}

// Same as the one defined in OpenJS
function approveDone(name) {
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
             if (json.result == "error") {
                 showNotification("error", json.message);
             } else {
                 // Hide items table
                 // $("#items").hide();
                 // $("#items").html("");
                 
                 // Hide report button
                 $("#action_panel").hide();
                 
                 // Show notification
                 showNotification("success", json.message);
             }
        }
        catch(err) {
             //Handle errors here
             showNotification('error', err);
        }
        
        frame.document.getElementsByTagName("body")[0].innerHTML = '';
      }
   }
 }

// Show notification message
// type: 'attention', 'success', 'error'
function showNotification(type, message) {
  var html = "";
  
  html += "<div class='notification " + type + " png_bg'>";
  html += "    <div>";
  html += message;
  html += "    </div>";
  html += "</div>";
  
  $('#process_msg').html(html);
}

// Load items in token detail
function loadTokenItems(token_id) {
    // Show loading
    $('#loading').show();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/finance_server.php",
        type: 'POST',
        data: String.format('load_token_items={0}&token_id={1}', 'true', token_id),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                $('#loading').hide();
                
                // Process data
                var json = jQuery.parseJSON(data);
                if(json.result == "success") {
                    // Set token Id value
                    $('#detail_token_id').val(token_id);
                    
                    // Set token items
                    if (json.token_items.length > 0) {
                        for (i = 0; i < json.token_items.length; i++) {
                            console.log(json);
                            var d = json.token_items[i];
                            var htmlText = "";
                            var css = (i % 2 == 0) ? "" : "";
                            
                            htmlText += String.format("<tr id='{0}' class={1}>", d.uid, css);
                            htmlText += String.format("<td>{0}</td>", d.reference);
                            htmlText += String.format("<td>{0}</td>", d.product);
                            if (d.madon) {
                                 htmlText += String.format("<td><a href='../orders/orderdetail.php?item={0}' target='_blank'>{1}</a></td>", d.madon, d.madon);
                            } else {
                                htmlText += String.format("<td>{0}</td>", "");
                            }
                            htmlText += String.format("<td>{0}</td>", d.category);
                            htmlText += String.format("<td>{0}</td>", d.item);
                            htmlText += String.format("<td>{0}</td>", d.perform_by);
                            htmlText += String.format("<td>{0}</td>", d.money_amount);
                            htmlText += String.format("<td>{0}</td>", d.mota);
                            htmlText += String.format("<td>{0}</td>", d.note);
                            htmlText += String.format("<td>{0}</td>", d.perform_date);
                            htmlText += String.format("<td>{0}</td>", 
                                    "<a href='javascript:addRow()' title='Thêm dòng mới'><img src='../resources/images/icons/add.png' alt='add'></a>" +
                                    String.format("<a id='edit_{0}' href='javascript:editRow(\"{1}\")' title='Cập nhật dòng này'><img src='../resources/images/icons/edit_16.png' alt='edit'></a>", d.uid, d.uid) +
                                    String.format("<a id='delete_{0}' href='javascript:removeRow(\"{1}\")' title='Xóa dòng này'><img src='../resources/images/icons/cross.png' alt='delete'></a>", d.uid, d.uid)
                                    );
                            htmlText += "</tr>";
                            
                            // Add to table
                            $('#items_body').append(htmlText);
                        }
                        
                        // Show the action buttons
                        if (json.enable_flag ==  1) {
                            $('#action_panel').show();
                        } else {
                            $('#action_panel').hide();
                        }
                    }
                    // Show the table
                    $('#items').show();
                    
                    // Set references
                    if (json.references.length != 0) {
                        for (i = 0; i < json.references.length; i++) {
                            var d = json.references[i];
                            
                            // Add to list
                            $('#reference_id').append(String.format("<option value='{0}'>{1}</option>", d.id, d.name));
                        }
                        $("#reference_id").trigger("chosen:updated");
                    }
                    
                    // Set products
                    if (json.products.length != 0) {
                        for (i = 0; i < json.products.length; i++) {
                            var d = json.products[i];
                            
                            // Add to list
                            $('#product_id').append(String.format("<option value='{0}'>{1}</option>", d.id, d.name));
                        }
                        $("#product_id").trigger("chosen:updated");
                    }
                    
                    // Set categories
                    if (json.categories.length != 0) {
                        for (i = 0; i < json.categories.length; i++) {
                            var d = json.categories[i];
                            
                            // Add to list
                            $('#category_id').append(String.format("<option value='{0}'>{1}</option>", d.id, d.name));
                        }
                        $("#category_id").trigger("chosen:updated");
                    }
                    
                    // Set performers
                    if (json.performers.length != 0) {
                        for (i = 0; i < json.performers.length; i++) {
                            var d = json.performers[i];
                            
                            // Add to list
                            $('#perform_by').append(String.format("<option value='{0}'>{1}</option>", d.id, d.name));
                        }
                        $("#perform_by").trigger("chosen:updated");
                    }
                    
                    // Set perform date
                    $("#perform_date").val(json.perform_date);
                    $("#today").val(json.perform_date);
                    
                } else {
                    showNotification('error', json.message);
                }
            }
            catch(err) {
                //Handle errors here
                $('#loading').hide();
                showNotification('error', err);
           }
        },
        timeout: 15000,      // timeout (in miliseconds)
        error: function(qXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                // request timed out, do whatever you need to do here
            }
            else {
                // some other error occurred
            }
            $('#loading').hide();
            showNotification('error', errorThrown);
        }
    });
}

// DOM load
$(function() {
    disableAutocomplete();
    
    // Load items of token
    loadTokenItems($('#token_id').val());
    
    // Submit event of 'token_form'
    $('#approve_form').submit(function() {
        // Show loading
        $("#process_msg").html($("#loading").html());
    });
});
