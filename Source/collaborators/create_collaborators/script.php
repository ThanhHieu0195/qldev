<script type="text/javascript" charset="utf-8">
  jQuery(document).ready(function($) {
      $('textarea[name="description"]').val('');
  		$('input[name="date_complete"]').datepicker({
  			minDate: new Date()
  		});
  		$('input[name="cost"]').numeric();
  		$('input[name="cost"]').keyup(function(event) {
  			var val = $('input[name="cost"]').val();
  			val = format_num(val);
  			val = number2string(val)
  			$('input[name="cost"]').val(val);
  		});
  });

  function submitfAdd() {
    var describe = $('textarea[name="description"]').val();
    var date_complete = $('input[name="date_complete"]').val();
    var cost = $('input[name="cost"]').val();
    var result = true;
    if ( is_empty(describe) ) {
      addClass('textarea', 'describe', 'input_error');
      result = false;
    }

    if ( is_empty(date_complete) ) {
      addClass('input', 'date_complete', 'input_error');
      result = false;
    }

    if ( is_empty(cost) ) {
  		addClass('input', 'cost', 'input_error');
  		result = false;
  	}
  	return result;
  }

  // support orther
  function addClass(tag, name, nameclass) {
  		var fm = "{0}[name={1}]";
  		var _this = String.format(fm, tag, name);
  		$(_this).addClass(nameclass);
  }
</script>