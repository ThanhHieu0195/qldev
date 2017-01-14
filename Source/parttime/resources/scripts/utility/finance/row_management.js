/* Script file for row management: add, edit, delete */

// Kiem tra cac thong tin cua chi tiet thu/chi
function checkValid() {
    var isValid = true;
    $('.error_icon').hide();
    
    if ($('#reference_id').val().trim() == "") {
        $('#reference_id').parent().find('.error_icon').show();
        isValid = false;
    } else {
        $('#reference_id').parent().find('.error_icon').hide();
        isValid = isValid && true;
    }
   
    if ($('#product_id').val().trim() == "") {
        $('#product_id').parent().find('.error_icon').show();
        isValid = false;
    } else {
        $('#product_id').parent().find('.error_icon').hide();
        isValid = isValid && true;
    }
    
    if ($('#category_id').val().trim() == "") {
        $('#category_id').parent().find('.error_icon').show();
        isValid = false;
    } else {
        $('#category_id').parent().find('.error_icon').hide();
        isValid = isValid && true;
    }
    
    if ($('#item_id').val().trim() == "") {
        $('#item_id').parent().find('.error_icon').show();
        isValid = false;
    } else {
        $('#item_id').parent().find('.error_icon').hide();
        isValid = isValid && true;
    }
    
    if ($('#perform_by').val().trim() == "") {
        $('#perform_by').parent().find('.error_icon').show();
        isValid = false;
    } else {
        $('#perform_by').parent().find('.error_icon').hide();
        isValid = isValid && true;
    }
    
    if ($('#money_amount').val().trim() == "") {
        $('#money_amount').parent().find('.error_icon').show();
        isValid = false;
    } else {
        var num = parseInt($('#money_amount').val());
        if (isNaN(num) || num <= 0) {
            $('#money_amount').parent().find('.error_icon').show();
            isValid = false;
        } else {
            $('#money_amount').parent().find('.error_icon').hide();
            isValid = isValid && true;
        }
    }

    if ($('#taikhoan').val().trim() == "") {
        $('#taikhoan').parent().find('.error_icon').show();
        isValid = false;
    } else {
        $('#taikhoan').parent().find('.error_icon').hide();
        isValid = isValid && true;
    }
    
    return isValid;
}

// Create loading icon
function createLoadingIcon() {
    return "<img alt=\"loading\" src=\"../resources/images/loading.gif\">";
}

// Site: http://joekuan.wordpress.com/2009/06/12/ajax-a-simplified-version-of-file-upload-form-using-iframe/
function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}

// Same as the one defined in OpenJS
function updateDetailDone(name) {
    var frame = getFrameByName(name);
    if (frame) {
      ret = frame.document.getElementsByTagName("body")[0].innerHTML;
  
      /* If we got JSON, try to inspect it and display the result */
      if (ret.length) {
        /* Convert from JSON to Javascript object */
        try {
            // Hide loading
            $("#detail_update_loading").hide();
            
            // Hide the action button
            $('#detail_update').show();
            
            // Hide close button of dialog
            $('#detail_dialog').find('.b-close').show();
            
             //var json = eval("("+ret+")");
             var json = $.parseJSON(ret);
             
             /* Process data in json ... */
             if (json.result == "error") {
                 showDetailNotification("error", json.message);
             } else {
                 if (json.token_items.length > 0) {
                     if (json.action == "add") {
                         // Add new row to the table
                         var d = json.token_items[0];
                         var htmlText = "";
                         
                         htmlText += String.format("<tr id='{0}'>", d.uid);
                         htmlText += String.format("<td>{0}</td>", d.reference);
                         htmlText += String.format("<td><a href='../orders/orderdetail.php?item={0}' target='_blank'>{1}</a></td>", d.madon, d.madon);
                         htmlText += String.format("<td>{0}</td>", d.product);
                         htmlText += String.format("<td>{0}</td>", d.category);
                         htmlText += String.format("<td>{0}</td>", d.item);
                         htmlText += String.format("<td>{0}</td>", d.performer);
                         htmlText += String.format("<td>{0}</td>", d.money_amount);
                        var valtaikhoan = "";
                        for (var j = 0; j < detail_taikhoan.length; j++) {
                            if (detail_taikhoan[j]['taikhoan'] == d.taikhoan){
                              valtaikhoan = detail_taikhoan[j]['mota'];
                            }
                        }
                         htmlText += String.format("<td>{0}</td>", valtaikhoan);
                         htmlText += String.format("<td>{0}</td>", d.note);
                         htmlText += String.format("<td>{0}</td>", d.perform_date);
                         htmlText += String.format("<td>{0}</td>", 
                                 "<a href='javascript:addRow()' title='Thêm dòng mới'><img src='../resources/images/icons/add.png' alt='add'></a>" );
                         htmlText += "</tr>";
                         
                         // Add to table
                         $('#items_body').append(htmlText);
                         
                         // Highlight updated row
                         var rowCtrlId = '#' + d.uid;
                         var orgColor = $(rowCtrlId).css('background');
                         $(rowCtrlId).css('background', 'lightgreen');
                         // Set interval to clear automatically
                         setTimeout(function() {
                             $(rowCtrlId).css('background', orgColor);
                         }, 1000);
                         
                         // Reset controls for adding a new row
                         resetCtrl(false);
                         
                     } else {
                         // Update the data row
                         var d = json.token_items[0];
                         
                         // Update data in row
                         var rowCtrlId = '#' + d.uid;
                         
                         $this = $(rowCtrlId).find("td");
                         $this.eq(0).html(d.reference);
                         $this.eq(1).html(String.format("<td><a href='../orders/orderdetail.php?item={0}' target='_blank'>{1}</a></td>", d.madon, d.madon));
                         $this.eq(2).html(d.product);
                         $this.eq(3).html(d.category);
                         $this.eq(4).html(d.item);
                         $this.eq(5).html(d.performer);
                         $this.eq(6).html(d.money_amount);
                        var valtaikhoan = "";
                        for (var j = 0; j < detail_taikhoan.length; j++) {
                            if (detail_taikhoan[j]['taikhoan'] == d.taikhoan){
                              valtaikhoan = detail_taikhoan[j]['mota'];
                            }
                        }
                         $this.eq(7).html(valtaikhoan);
                         $this.eq(8).html(d.note);
                         $this.eq(9).html(d.perform_date);
                         
                         // Highlight updated row
                         var orgColor = $(rowCtrlId).css('background');
                         $(rowCtrlId).css('background', 'yellow');
                         // Set interval to clear automatically
                         setTimeout(function() {
                             $(rowCtrlId).css('background', orgColor);
                         }, 1000);
                         
                         // Close the detail dialog
                         $('#detail_dialog').bPopup().close();
                     }
                 }
                 
                 // Update total items of the token (if any)
                 if (typeof json.total_items !== 'undefined') {
                     $("#token_total_items").html(json.total_items);
                 }
                 // Update total money of the token (if any)
                 if (typeof json.total_money !== 'undefined') {
                     $("#token_total_money").html(json.total_money);
                 }
                 
                 // Show the action button(s)
                 $('#action_panel').show();
             }
        }
        catch(err) {
             //Handle errors here
            
             // Hide loading
             $("#detail_update_loading").hide();
             
             // Hide the action button
             $('#detail_update').show();
             
             // Hide close button of dialog
             $('#detail_dialog').find('.b-close').show();
             
             showDetailNotification('error', err);
        }
        
        frame.document.getElementsByTagName("body")[0].innerHTML = '';
      }
   }
 }

// Add new item to the token detail
function addRow() {
    // Reset controls
    resetCtrl();
    // Set the dialog title
    $("#detail_dialog_title").html("Thêm chi tiết phiếu " + typeName);
    // Set the action
    $("#action").val("add");
    // Show the dialog
    showDetailDialog();
}

// Edit an item to the token detail
function editRow(uid) {
    /* Get information of item in database */
    var ctrlId = "#edit_" + uid;
    var orgHtml = $(ctrlId).html();
    
    // Show loading
    $(ctrlId).html(createLoadingIcon());
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/finance_server.php",
        type: 'POST',
        data: String.format('get_token_detail_item={0}&uid={1}', 'true', uid),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                $(ctrlId).html(orgHtml);
                
                // Process data
                var json = jQuery.parseJSON(data);
                if (json.result == "success") {
                    // Get the token detail item
                    if (json.token_items.length > 0) {
                        // Reset controls
                        resetCtrl();
                        
                        var d = json.token_items[0];
                        
                        // Set reference
                        $("#reference_id").val(d.reference_id);
                        $("#reference_id").trigger("chosen:updated");

                        // set madon
                        $('#madon').val(d.madon);
                        $('#madon').trigger("chosen:updated");
                        
                        // Set product
                        $("#product_id").val(d.product_id);
                        $("#product_id").trigger("chosen:updated");
                        
                        // Set category
                        $("#category_id").val(d.category_id);
                        $("#category_id").trigger("chosen:updated");
                        
                        // Set item
                        if (json.items.length != 0) {
                            for (i = 0; i < json.items.length; i++) {
                                var t = json.items[i];
                                
                                // Add to list
                                $('#item_id').append(String.format("<option value='{0}'>{1}</option>", t.id, t.name));
                            }
                        }
                        $("#item_id").val(d.item_id);
                        $("#item_id").trigger("chosen:updated");
                        
                        // Set performer
                        $("#perform_by").val(d.perform_by);
                        $("#perform_by").trigger("chosen:updated");
                        
                        // Set others data
                        $("#uid").val(uid);
                        $("#money_amount").val(d.money_amount);

                        $('#taikhoan').val(d.taikhoan);

                        $("#note").val(d.note);
                        $("#perform_date").val(d.perform_date);
                        
                        // Set the dialog title
                        $("#detail_dialog_title").html("Sửa chi tiết phiếu " + typeName);
                        // Set the action
                        $("#action").val("edit");
                        // Show the dialog
                        showDetailDialog();
                    }
                } else {
                    // Do nothing
                }
            }
            catch(err) {
                //Handle errors here
                $(ctrlId).html(orgHtml);
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
            $(ctrlId).html(orgHtml);
        }
    });
}

// Delete an item to the token detail
function removeRow(uid) {
    var ctrlId = "#delete_" + uid;
    var orgHtml = $(ctrlId).html();
    
    // Show loading
    $(ctrlId).html(createLoadingIcon());
    
    // Send AJAX request
    $.ajax({
        url: "../ajaxserver/finance_server.php",
        type: 'POST',
        data: String.format('delete_token_detail_item={0}&uid={1}', 'true', uid),
        success: function (data, textStatus, jqXHR) {
            try {
                // Hide loading
                $(ctrlId).html(orgHtml);
                
                // Process data
                var json = jQuery.parseJSON(data);
                if (json.result == "success") {
                    
                    if (json.enable_flag == 1) {
                        // Show the action button(s)
                        $('#action_panel').show();
                    } else {
                        // Hide the action button(s)
                        $('#action_panel').hide();
                    }
                    
                    // Remove row from table
                    var tr = $(ctrlId).closest('tr');
                    tr.css("background-color", "#FF3700");
                    tr.fadeOut(400, function(){
                        tr.remove();
                    });
                    // return false;
                    
                    // Update total items of the token (if any)
                    if (typeof json.total_items !== 'undefined') {
                        $("#token_total_items").html(json.total_items);
                    }
                    // Update total money of the token (if any)
                    if (typeof json.total_money !== 'undefined') {
                        $("#token_total_money").html(json.total_money);
                    }
                    
                } else {
                    // Do nothing
                }
            }
            catch(err) {
                //Handle errors here
                $(ctrlId).html(orgHtml);
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
            $(ctrlId).html(orgHtml);
        }
    });
}

// Reset controls in detail dialog
function resetCtrl(all_items) {
    all_items = typeof all_items !== 'undefined' ? all_items : true;
    // alert('all_items: ' + all_items);
    
    $('.error_icon').hide();
    $('#detail_msg').html("");
    
    $("#reference_id").val("");
    $("#reference_id").trigger("chosen:updated");

    $("#madon").val("");
    $("#madon").trigger("chosen:updated");
    
    $("#product_id").val("");
    $("#product_id").trigger("chosen:updated");
    
    $("#category_id").val("");
    $("#category_id").trigger("chosen:updated");
    
    $("#item_id").val("");
    $("#item_id").trigger("chosen:updated");
    
    $("#perform_by").val("");
    $("#perform_by").trigger("chosen:updated");
    
    if (all_items) {
        $("#uid").val("");
        $("#action").val("");
    }
    
    $("#money_amount").val("");
    $("#taikhoan").val("");
    $("#note").val("");
    $("#perform_date").val($("#today").val());
}

// Show detail dialog
function showDetailDialog() {
    $('#detail_dialog').bPopup({
        escClose: false,
        modalClose: false
    });
}

// Show detail notification message
// type: 'attention', 'success', 'error'
function showDetailNotification(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    $('#detail_msg').html(html);
}

var loading  = false; //to prevents multipal ajax loads

// Load sub items of a category
function loadItemByCategory(category_id) {
    // Clear items list
    $("#item_id").val("");
    $("#item_id").html("<option value=''></option>");
    $("#item_id").trigger("chosen:updated");
    
    if (loading == false) {
        loading = true; //prevent further ajax loading
        
        // Show loading icon
        $('#category_loading').show();
        
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/finance_server.php",
            type: 'POST',
            data: String.format('load_items_by_category={0}&category_id={1}', 'true', category_id),
            success: function (data, textStatus, jqXHR) {
                try {
                    // Hide loading
                    $('#category_loading').hide();
                    
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        // Set items
                        if (json.items.length != 0) {
                            for (i = 0; i < json.items.length; i++) {
                                var d = json.items[i];
                                
                                // Add to list
                                $('#item_id').append(String.format("<option value='{0}'>{1}</option>", d.id, d.name));
                            }
                            $("#item_id").trigger("chosen:updated");
                        }
                    } else {
                        // Do nothing
                    }
                    
                    loading = false; 
                }
                catch(err) {
                    //Handle errors here
                    $('#category_loading').hide();
                    
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
                $('#category_loading').hide();
                
                loading = false; 
            }
        });
    }
}

// DOM load
$(function() {
    disableAutocomplete();
    
    // numeric
    $(".numeric").numeric();
    
    // datepicker
    $(".datetime").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
    });
    
    // Load items by category
    $("#category_id").chosen().change(function() {
        loadItemByCategory($(this).val());
    });
    
    // Submit event of 'detail_form'
    $('#detail_form').submit(function() {
        if (checkValid()) {
            // Show loading
            $("#detail_update_loading").show();
            
            // Hide the action button
            $('#detail_update').hide();
            
            // Hide close button of dialog
            $('#detail_dialog').find('.b-close').hide();
            
            return true;
        }
        
        return false;
    });
});
