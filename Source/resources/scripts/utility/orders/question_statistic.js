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

var loading = false; //to prevents multipal ajax loads

// Load items in token detail
function statistic() {
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Get input data
        var question_id = $('#question_id').val();
        if (question_id == "") {
            loading = false; 

            return;
        }
        
        // Clear notification
        $('#process_msg').html('');
        
        // Hide the table(s)
        $('#items').hide();
        $('#tbl_total').hide();
        
        // Clear table body
        $('#items_body').html('');
        
        // Show loading
        $('#loading').show();
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/orders_questions_statistic_server.php",
            type: 'POST',
            data: String.format('question_statistic={0}&question_id={1}', 'true', question_id),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $('#loading').hide();
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        
                        // Set token items
                        if (json.items.length > 0) {
                            for (i = 0; i < json.items.length; i++) {
                                var d = json.items[i];
                                var htmlText = "";
                                var css = (i % 2 == 0) ? "alt-row" : "";                                
                                
                                htmlText += String.format("<tr id='{0}' class={1}>", d.uid, css);
                                htmlText += String.format("<td>{0}</td>", d.no);
                                htmlText += String.format("<td>{0}</td>", d.option);
                                if (d.amount == "") {
                                    htmlText += "<td></td>";
                                }
                                else {
                                    htmlText += String.format("<td>{0}</td>", 
                                        String.format("<a class='orange' title='Danh sách hóa đơn' href='javascript:showOrdersByQuestionOption(\"{0}\");'>{1}</a>", 
                                                d.uid,
                                                d.amount));
                                }
                                htmlText += "</tr>";
                                
                                // Add to table
                                $('#items_body').append(htmlText);
                            }
                            
                        } else {
                            var htmlText = String.format("<tr><td colspan='9'>{0}</td></tr>", "Không tìm thấy dữ liệu");
                            $('#items_body').append(htmlText);
                        }

                        // Set total value(s)
                        $('#total_checked').html(json.total.checked);
                        var skipped = json.total.skipped;
                        if (skipped == 0) {
                            $('#total_skipped').html("-");
                        } else {
                            $('#total_skipped').html(String.format("<a class='orange' title='Danh sách hóa đơn' href='javascript:showSkippedOrders();'>{0}</a>", skipped));
                        }
                        
                        
                        // Show the table(s)
                        $('#items').show();
                        $('#tbl_total').show();
                    } else {
                        showNotification('error', json.message);
                    }
                    
                    loading = false; 
                }
                catch(err) {
                    //Handle errors here
                    $('#loading').hide();
                    showNotification('error', err);
                    
                    loading = false; 
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
                
                loading = false; 
            }
        });
    }
}

// DOM load
$(function() {
    disableAutocomplete();
});