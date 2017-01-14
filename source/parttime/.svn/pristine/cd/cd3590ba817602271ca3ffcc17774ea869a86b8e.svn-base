// finance_reference = <?php echo json_encode($finance_reference); ?>;
// finance_product = <?php echo json_encode($finance_product); ?>;
// finance_category = <?php echo json_encode($finance_category); ?>;

$(document).ready(function() {
     $('#checkdelall').click(function(event) {
        /* Act on the event */
        var checked = $('#checkdelall').is(':checked');;
        if (checked) {
            $('input[name=checkdel]').attr('checked', 'checked');
        } else {
            $('input[name=checkdel]').removeAttr('checked');
        }
    });

    function delrowlistchecked(arr) {
        for (var i = 0; i < arr.length; i++) {
            id = "#" + arr[i];
            $(id).remove();
        }
    }

    $('#btndel').click(function(event) {
        /* Act on the event */
        var arr_checked =  $('input[name=checkdel]:checked');
        arr_checked_length = arr_checked.length;
        listchecked = [];
        if (arr_checked_length > 0) {
            for (var i = 0; i < arr_checked.length; i++) {
                var obj = arr_checked[i];
                listchecked.push(obj.value);
                $.post('../ajaxserver/return_payment_list_server.php', {del_return_payment: '', list_return:listchecked}, function(data, textStatus, xhr) {
                    json = $.parseJSON(data);
                    if (json.result=1) {
                        delrowlistchecked(listchecked);
                         $('#example').dataTable().fnReloadAjax();
                    }
                });
            }
        } else {
            alert('Chưa có phiếu nào được chọn!');
        }
    });

    html_reference="";

    for (var i = 0; i < finance_reference.length; i++) {
        var obj = finance_reference[i];
        html_reference+=String.format("<option value='{0}'>{1}</option>", obj.reference_id, obj.name);
    }

    html_product="";
    for (var i = 0; i < finance_product.length; i++) {
        var obj = finance_product[i];
        html_product+=String.format("<option value='{0}'>{1}</option>", obj.product_id, obj.name);
    }

    html_category="";
    for (var i = 0; i < finance_category.length; i++) {
        var obj = finance_category[i];
        html_category+=String.format("<option value='{0}'>{1}</option>", obj.category_id, obj.name);
    }
    
    $('#reference_id').append(html_reference);
    $('#product_id').append(html_product);
    $('#category_id').append(html_category);
    $('#category_id').change(function(event) {
        /* Act on the event */
        var category_id = $('#category_id').val();
         $.ajax({
            url: "../ajaxserver/finance_server.php",
            type: 'POST',
            data: String.format('load_items_by_category={0}&category_id={1}', 'true', category_id),
            success: function (data, textStatus, jqXHR) {
                try {
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
                loading = false; 
            }
        });
    });

    var config = {
        '.chosen-select'           : {width:"150px"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"}
    };
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
});