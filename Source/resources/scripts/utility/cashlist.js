/******************************************************************************
 *  EXPORT ĐƠN HÀNG
 *****************************************************************************/
//Kiem tra cac thong tin export
function checkValid() {
    var tungay = $("#tungay"),
        denngay = $("#denngay"),
        error_1 = $("#error-1"),
        error_2 = $("#error-2"),
        isValid = true;
    
    error_1.text("");
    error_2.text("");
    if(tungay.val() ==="") {
        isValid = false;
        error_1.text("* Chọn ngày");
    }
    if(denngay.val() ==="") {
        isValid = false;
        error_2.text("* Chọn ngày");
    }
    
    return isValid;
}


//Export file excel
function export2Excel() {
    //alert(type);
    var tungay = $("#tungay"),
        denngay = $("#denngay");
    var format = "../phpexcel/export2exel.php?do=export&table=cashinglist&from={0}&to={1}";
    var url;
    if(checkValid()) {
        url = String.format(format, tungay.val(), denngay.val());
        //window.location = url;
        var win = window.open(url, '_blank');
        win.focus();
    }
}

/******************************************************************************
 *  THU TIỀN ĐƠN HÀNG
 *****************************************************************************/
var CASHED_TYPE_PARTLY          = 0; // Thu 1 phần tiền
var CASHED_TYPE_TIEN_COC        = 1  // Thu tiền cọc
var CASHED_TYPE_TIEN_GIAO_HANG  = 2; // Thu tiền giao hàng
var CASHED_TYPE_ALL             = 3; // Thu tất cả tiền
var CASHED_TYPE_VAT             = 4; // Thu tất VAT

function createCashButton(ma_hd) {
    var htmlStr = String.format("<a href='javascript:showDialog(\"{0}\");' rel='modal' title='Thu tiền'>\
                       <img src='../resources/images/icons/user_16.png' alt='Add'>\
                   </a>", ma_hd);
    return htmlStr;
}

function resetCtrl() {
    $('#c_money_amount').show();
    $("#money_amount").removeAttr("readonly");
    $('#money_amount').val('');
    $('#cashing_type_partly').prop('checked', true);
    $('#detail_msg').html('');
}

function numFmt(nStr, sign){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + sign + '$2');
    return x1 + x2;
}

// Add new item to the token detail
function showDialog(ma_hd) {
    // Reset controls
    resetCtrl();

    $.getJSON('../ajaxserver/list_expenses_server.php', {action: 1, do:'get', madonhang:ma_hd}, function(json, textStatus) {
        json_Expenses = json;
        listNote = [];
        if (json.result == "success") {
            var data = json.data;
            for (var i = 0; i < data.length; i++) {
                var obj = data[i];
                listNote.push(obj.ghichu);
            }

            if (listNote.indexOf(TIENTHICONG) != -1) {
                $('#tienthicong').parent().parent().show();
                var p = listNote.indexOf(TIENTHICONG);
                var obj = data[p];
                var money  = obj.sotien;
                $('#tienthicong').html(money);
            } else {
                $('#tienthicong').parent().parent().hide();
            }

            if (listNote.indexOf(TIENCATTHAM) != -1) {
                $('#tiencattham').parent().parent().show();
                var p = listNote.indexOf(TIENCATTHAM);
                var obj = data[p];
                var money  = obj.sotien;
                $('#tiencattham').html(money);
            }else {
                $('#tiencattham').parent().parent().hide();
            }

            if (listNote.indexOf(PHUTHUGIAOHANG) != -1) {
                 $('#phuthugiaohang').parent().parent().show();
                var p = listNote.indexOf(PHUTHUGIAOHANG);
                var obj = data[p];
                var money  = obj.sotien;
                $('#phuthugiaohang').html(money);
            }else {
                $('#phuthugiaohang').parent().parent().hide();
            }

            if (listNote.indexOf(THUTIENGIUMKHACHSI) != -1) {
                 $('#thutiengiumkhachsi').parent().parent().show();
                var p = listNote.indexOf(THUTIENGIUMKHACHSI);
                var obj = data[p];
                var money  = obj.sotien;
                $('#thutiengiumkhachsi').html(money);
            }else {
                $('#thutiengiumkhachsi').parent().parent().hide();
            }
        }
    });
    // Set form values
    $("#order_id").val(ma_hd);
    $('#s_type_tien_coc').html(numFmt($('#tien_coc_' + ma_hd.replace(".", "\\.")).val(), '.'));
    if ($('#tien_vat_' + ma_hd.replace(".", "\\.")).val()>0) {
        $('#c_vat').show();
        $('#s_type_vat').html(numFmt($('#tien_vat_' + ma_hd.replace(".", "\\.")).val(), '.'));
    } else {
        $('#c_vat').hide();
    }
    $('#s_type_all').html(numFmt($('#tien_con_lai_' + ma_hd.replace(".", "\\.")).val(), '.'));


    // Show the dialog
    $('#cashing_dialog').bPopup({
        escClose: false,
        modalClose: false
    });
}

// Show detail notification message
// type: 'attention', 'success', 'error'
function showNotification(type, message) {
    var html = "";
    
    html += "<div class='notification " + type + " png_bg'>";
    html += "    <div>";
    html += message;
    html += "    </div>";
    html += "</div>";
    
    $('#detail_msg').html(html);
}

// Site: http://joekuan.wordpress.com/2009/06/12/ajax-a-simplified-version-of-file-upload-form-using-iframe/
function getFrameByName(name) {
  for (var i = 0; i < frames.length; i++)
    if (frames[i].name == name)
      return frames[i];
 
  return null;
}

// Same as the one defined in OpenJS
function cashedDone(name) {
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
             if (json.result == "success") {
                 // Close the detail dialog
                 $('#cashing_dialog').bPopup().close();

                 var order_id = $('#order_id').val();
                 if (!(json.cashed==null && json.remain == null && json.total ==null)){
                        $('#cased_money_' + order_id.replace(".", "\\.")).html(json.cashed);
                        $('#remain_money_' + order_id.replace(".", "\\.")).html(json.remain);
                        $('#tien_con_lai_' + order_id.replace(".", "\\.")).val(json.total);
                 }
                 if (json.vat) {
                        $('#tien_vat_' + order_id.replace(".", "\\.")).val(0);
                 }
            
             } else {
                 showNotification("error", json.message);
             }

             $("#detail_update").show();
        }
        catch(err) {
             //Handle errors here
             showNotification('error', err);
        }
        
        frame.document.getElementsByTagName("body")[0].innerHTML = '';
      }
   }
 }

/******************************************************************************
 *  DOM load
 *****************************************************************************/
 var oTable; // Datatables

function getAjaxSource() {
    return String.format("../ajaxserver/cash_list_server.php?cho_giao={0}&da_giao={1}", 
                        $('#check_cho_giao').is(':checked'), 
                        $('#check_da_giao').is(':checked')
            );
}

function refreshData() {
    if (oTable != null && oTable !== undefined) {
        oTable.fnReloadAjax(getAjaxSource());
    }
}


$(function() {
    disableAutocomplete();

    $("#detail_form").submit(function() {
        $("#detail_update").hide();
        return true;
    });
    
    // numeric
    $(".numeric").numeric();

    // Checkbox
    $('input[name="cashing_type"]').click(function() {
        var order_id = $('#order_id').val();
        var type = $(this).val();

        $('#detail_msg').html('');

        //alert(order_id);
        //alert(type);
        if (type == CASHED_TYPE_PARTLY) {
            $('#money_amount').val('');
            $("#money_amount").removeAttr("readonly");
            $("#c_money_amount").show();
        }
        else 
        {
            $("#c_money_amount").hide();

            if (type == CASHED_TYPE_TIEN_COC) {
                //alert($('#tien_coc_' + order_id).val());
                $('#money_amount').val($('#tien_coc_' + order_id.replace(".", "\\.")).val());
                $("#money_amount").attr("readonly", true);
            }
            else if (type == CASHED_TYPE_ALL) {
                //alert($('#remain_money_' + order_id).val());
                $('#money_amount').val($('#tien_con_lai_' + order_id.replace(".", "\\.")).val());
                $("#money_amount").attr("readonly", true);
            } else if (type == CASHED_TYPE_VAT) {
                //alert($('#tien_vat_' + order_id.replace(".", "\\.")).val());
                $('#money_amount').val($('#tien_vat_' + order_id.replace(".", "\\.")).val());
                $("#money_amount").attr("readonly", true);
            } else if (type == CASHED_TYPE_TIENTHICONG) {
                var money = $('#tienthicong').html();
                $('#money_amount').val(money);
            } else if (type == CASHED_TYPE_TIENCATTHAM) {
                var money = $('#tiencattham').html();
                $('#money_amount').val(money);
            } else if (type == CASHED_TYPE_PHUTHUGIAOHANG) {
                var money = $('#phuthugiaohang').html();
                $('#money_amount').val(money);
            } else if (type == CASHED_TYPE_THUTIENGIUMKHACHSI) {
                var money = $('#thutiengiumkhachsi').html();
                $('#money_amount').val(money);
            }
        }
    });

    // datepicker
    var dates = $("#tungay, #denngay").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            /*var option = this.id == "tungay" ? "minDate" : "maxDate",
                instance = $( this ).data( "datepicker" ),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );*/
        }
    });
    
    // Datatable
    var i = 0;
    oTable = $('#example').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": getAjaxSource(),
        "aaSortingFixed": [[3,'asc']],
        //"aaSorting": [[ 3, "asc" ]],
        "bSort": false,
        //"bJQueryUI": true,
        "aoColumnDefs": [
            { "sClass": "center", "aTargets": [3] }
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            //console.log(nRow);
            $(nRow).removeClass('odd');
            if(aData[0] == '')
            {
                $(nRow).html(String.format("<td colspan='10' class='group'>{0}</td>", aData[3]));
            }
            else
            {
                $('td:eq(0)', nRow).html("<a href='../orders/orderdetail.php?item=" + aData[0] + "' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>");
                $('td:eq(1)', nRow).html(aData[1]);
                $('td:eq(2)', nRow).html(aData[12]);
                $('td:eq(3)', nRow).html(aData[2]);
                $('td:eq(4)', nRow).html(aData[3]);
                $('td:eq(5)', nRow).html(String.format("<span id=cased_money_{0}>{1}</span>\
                                                        <input type='hidden' id='tien_coc_{2}' value='{3}' />", 
                                                        aData[0], aData[4], 
                                                        aData[0], aData[7]
                                                        ));
                $('td:eq(6)', nRow).html(String.format("<span id=remain_money_{0}>{1}</span>\
                                                        <input type='hidden' id='tien_con_lai_{2}' value='{3}' />\
                                                        <input type='hidden' id='tien_vat_{4}' value='{5}' />",
                                                        aData[0], aData[5], 
                                                        aData[0], aData[13],
                                                        aData[0], aData[14] 
                                                        ));
                $('td:eq(7)', nRow).html(aData[6]);
                $('td:eq(8)', nRow).html(aData[11]);
                $('td:eq(9)', nRow).html(createCashButton(aData[0]));

                /* Tooltip */
                oTable.$('#div' + iDisplayIndex).tooltip({
                    delay: 50,
                    showURL: false,
                    bodyHandler: function() {
                        return $("<div></div>").html(aData[10]);
                    }
                });
            }
        }
    });
});
