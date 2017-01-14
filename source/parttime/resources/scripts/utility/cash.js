function validateData() {
        var from = $("#from"),
            to = $("#to"),
            error_1 = $("#error-1"),
            error_2 = $("#error-2"),
            isValid = true;
    
    error_1.text("");
    error_2.text("");
    if(from.val() ==="") {
        isValid = false;
        error_1.text("* Chọn ngày");
    }
    if(to.val() ==="") {
        isValid = false;
        error_2.text("* Chọn ngày");
    }
    
    return isValid;
}

// Export ra file excel
function export2Excel() {
    var from = $("#from"),
        to = $("#to");
    var format = "../phpexcel/export2exel.php?do=export&table=cash_statistic&from={0}&to={1}";
    var url;
    if(validateData()) {
        url = String.format(format, from.val(), to.val());
        window.location = url;
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

var loading = false; //to prevents multipal ajax loads

// Statistic data
function statistic() {
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Get input data
        from_date = $('#from').val();
        to_date = $('#to').val();
        
        // Clear notification
        $('#process_msg').html('');
        
        // Hide the table(s)
        $('#items').hide();
        $('#tbl_total').hide();
        
        // Clear table body
        $('#items_body').html('');
        
        // Hide the filter control
        $('#search_panel').hide();
        
        // Show loading
        $('#loading').show();
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/cash_statistic_server.php",
            type: 'POST',
            data: String.format('from={0}&to={1}', from_date, to_date),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $('#loading').hide();
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        
                        // Set items
                        if (json.items.length > 0) {
                            for (i = 0; i < json.items.length; i++) {
                                var d = json.items[i];
                                var htmlText = "";
                                var css = (i % 2 == 0) ? "alt-row" : "";
                                
                                htmlText += String.format("<tr class={0}>", css);
                                htmlText += String.format("<td><span class='price'>{0}</span></td>", d.ngay_fmt);
                                htmlText += String.format("<td>{0}</td>", d.tien_coc);
                                htmlText += String.format("<td>{0}</td>", d.tien_giao_hang);
                                htmlText += String.format("<td>{0}</td>", d.tien_khac);
                                htmlText += String.format("<td><a target='_blank' href='../orders/cashed_list.php?filter=true&from={0}&to={1}'>{2}</a></td>", d.ngay, d.ngay, d.tong);
                                htmlText += "</tr>";
                                
                                // Add to table
                                $('#items_body').append(htmlText);
                            }
                            // Summary row
                            var d = json.summary;
                            var htmlText = "";
                            var css = (i % 2 == 0) ? "alt-row" : "";
                                
                            htmlText += String.format("<tr class={0}>", css);
                            htmlText += String.format("<td><span class='price'>{0}</span></td>", d.ngay);
                            htmlText += String.format("<td>{0}</td>", d.tien_coc);
                            htmlText += String.format("<td>{0}</td>", d.tien_giao_hang);
                            htmlText += String.format("<td>{0}</td>", d.tien_khac);
                            htmlText += String.format("<td><a target='_blank' href='../orders/cashed_list.php?filter=true&from={0}&to={1}'>{2}</a></td>", from_date, to_date, d.tong);
                            htmlText += "</tr>";

                            $('#items_body').append(htmlText);
                            
                            // Show the filter control
                            $('#search_panel').show();
                        } else {
                            var htmlText = String.format("<tr><td colspan='5'>{0}</td></tr>", "Không tìm thấy dữ liệu");
                            $('#items_body').append(htmlText);
                        }
                        
                        // Show the total money item(s)
//                        $this = $("#tbl_total_body").find("td");
//                        $this.eq(0).find("span").html(json.total_receipt);
//                        $this.eq(1).find("span").html(json.total_payment);
//                        $this.eq(2).find("span").html(json.total_difference);
                        
                        // Show the table(s)
                        $('#items').show();
//                        $('#tbl_total').show();
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
    // datepicker
    $("#from, #to").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
    });
});