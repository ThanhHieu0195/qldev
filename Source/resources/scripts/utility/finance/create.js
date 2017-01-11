// Site: http://joekuan.wordpress.com/2009/06/12/ajax-a-simplified-version-of-file-upload-form-using-iframe/
var detail_taikhoan = [];
// var detail_taikhoan = [{id: 'vcb', val:"VCB"}, {id: 'vtb', val:"VTB"}, {id: 'scb', val:"SCB"}, {id: 'tienmat', val:"Tiền mặt"}];

function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}

// Same as the one defined in OpenJS
function reportDone(name) {
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
                 $("#items").hide();
                 $("#items").html("");
                 
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


// Create new token
function createNewToken(token_type) {
    // Show loading
    $('#loading').show();
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/finance_server.php",
        type: 'POST',
        data: String.format('create_new={0}&token_type={1}', 'true', token_type),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                $('#loading').hide();
                
                // Process data
                var json = jQuery.parseJSON(data);
                if(json.result == "success") {
                    // Set token Id value
                    $('#token_id').val(json.token_id);
                    $('#detail_token_id').val(json.token_id);
                    detail_taikhoan = json.detail_tk;
                    // Set token items
                    if (json.token_items.length > 0) {
                        for (i = 0; i < json.token_items.length; i++) {
                            var d = json.token_items[i];
                            var htmlText = "";
                            
                            htmlText += String.format("<tr id='{0}'>", d.uid);
                            htmlText += String.format("<td>{0}</td>", d.reference);
                            htmlText += String.format("<td><a href='../orders/orderdetail.php?item={0}' target='_blank'>{1}</a></td>", d.madon, d.madon);
                            htmlText += String.format("<td>{0}</td>", d.product);
                            htmlText += String.format("<td>{0}</td>", d.category);
                            htmlText += String.format("<td>{0}</td>", d.item);
                            htmlText += String.format("<td>{0}</td>", d.perform_by);
                            htmlText += String.format("<td>{0}</td>", d.money_amount);
                            // set value taikhoan
                            var valtaikhoan = "";
                            for (var j = 0; j < detail_taikhoan.length; j++) {
                                if (detail_taikhoan[j]['taikhoan'] == d.taikhoan){
                                  valtaikhoan = detail_taikhoan[j]['mota'];
                                }
                            }
                            htmlText += String.format("<td>{0}</td>", valtaikhoan);
                            // htmlText += String.format("<td>{0}</td>", d.taikhoan);

                            htmlText += String.format("<td>{0}</td>", d.note);
                            htmlText += String.format("<td>{0}</td>", d.perform_date);
                            htmlText += String.format("<td>{0}</td>", 
                                    "<a href='javascript:addRow()' title='Thêm dòng mới'><img src='../resources/images/icons/add.png' alt='add'></a>" 
                                    );
                            htmlText += "</tr>";
                            
                            // Add to table
                            $('#items_body').append(htmlText);
                        }
                        
                        // Show the report button
                        $('#action_panel').show();
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
                    // set taikhoan
                    for (var i = 0; i < detail_taikhoan.length; i++) {
                        $('#taikhoan').append(String.format("<option value='{0}'>{1}</option>", detail_taikhoan[i]['taikhoan'], detail_taikhoan[i]['mota']));
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
    // Create new token
    createNewToken($('#token_type').val());
    
    // Submit event of 'token_form'
    $('#token_form').submit(function() {
        // Show loading
        $("#process_msg").html($("#loading").html());
    });
});
