<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($) {
		$('.datepicker').datepicker({
			minDate: new Date()
		});
		
		$('#show-popup-accept').click(function(event) {
			$('#popup-accept').bPopup();
		});
	});

	function checkSubmitAcceptPopup() {
		var date_complete = $('input[name="date_complete"]').val();
		if ( is_empty(date_complete) ) {
			return false;
		}
		return true;
	}
</script>