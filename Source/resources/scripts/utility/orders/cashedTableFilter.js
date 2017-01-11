// Filter table based on query
function doFiltering(table, q) {
  // q = $.trim(q); //trim white space
  q = q.replace(/(['"])/g,'\\$1');
  
  var tbody = table.find('tbody'); // cache the tbody element
  
  if (q==='') { // if the filtering query is blank
      // show all rows
      tbody.find('tr').removeClass('visible').show().addClass('visible');
  } else { // if the filter query is not blank
      tbody.find('tr').each(function() {
          ($(this).text().search(new RegExp(q, "i")) < 0) ? $(this).hide().removeClass('visible') : $(this).show().addClass('visible');
      });
  }
  
  /* Calculate money amount */
   var total_receipt = 0;
   tbody.find('tr').each(function() {
       if ($(this).hasClass('visible')) {
           v = parseInt($(this).find('input[name="money_value"]').val());
           if (! isNaN(v)) {
               total_receipt += v;
           }
       }
   });
   // Show the total money item(s)
   $this = $("#tbl_total_body").find("td");
   $this.eq(0).find("span").html((total_receipt).formatMoney(0, ',', '.'));
}

// DOM load
$(function() {
    var table = $('table[type="filter"]');
    var inputCtrl = $('input[type="search"]');
    
    inputCtrl.bind('input', function() {
        doFiltering(table, $(this).val());
    });
});