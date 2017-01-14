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
        from_date = $('#from_date').val();
        to_date = $('#to_date').val();
        cashier = $('#cashier').val();
        
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
            url: "../ajaxserver/orders_cashed_server.php",
            type: 'POST',
            data: String.format('statistic={0}&from_date={1}&to_date={2}&cashier={3}', 'true', from_date, to_date, cashier),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $('#loading').hide();
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        
                        // Set token items
                        if (json.output_items.length > 0) {
                            for (i = 0; i < json.output_items.length; i++) {
                                var d = json.output_items[i];
                                console.log(d);
                                var htmlText = "";
                                var css = (i % 2 == 0) ? "alt-row" : "";
                                
                                htmlText += String.format("<tr class={0}>", css);
                                htmlText += String.format("<td><a href='../orders/orderdetail.php?item={0}'>{1}</a></td>", d.madon, d.madon);
                                htmlText += String.format("<td>{0}</td>", d.khachhang);
                                htmlText += String.format("<td>{0}</td>", d.nhomkhach);
                                htmlText += String.format("<td>{0}</td>", d.tongtien);
                                htmlText += String.format("<td>{0}<input type='hidden' name='money_value' value='{1}' /></td>", d.sotiendathu, d.cashed_money);
                                htmlText += String.format("<td>{0}</td>", d.nguoithu);
                                htmlText += String.format("<td>{0}</td>", d.ngaythu);
                                htmlText += String.format("<td>{0}</td>", d.noidung);
                                htmlText += "</tr>";
                                
                                // Add to table
                                $('#items_body').append(htmlText);
                            }
                            
                            // Show the filter control
                            $('#search_panel').show();
                        } else {
                            var htmlText = String.format("<tr><td colspan='8'>{0}</td></tr>", "Không tìm thấy dữ liệu");
                            $('#items_body').append(htmlText);
                        }
                        
                        // Show the total money item(s)
                       $this = $("#tbl_total_body").find("td");
                       $this.eq(0).find("span").html(json.total_receipt);
                        
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

//Export data to Excel
function exportExcel() {
    // Get input data
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var cashier = $('#cashier').val();
    // Create URL
    var url = "";
    url = String.format("../orders/cashed_list_export.php?from={0}&to={1}&cashier={2}", from_date, to_date, cashier);
    
    window.open(url, '_blank'); // opens URL in a new tab
}

// DOM load
$(function() {
    disableAutocomplete();
    
    // datepicker
    var dates = $("#from_date, #to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
    });
});