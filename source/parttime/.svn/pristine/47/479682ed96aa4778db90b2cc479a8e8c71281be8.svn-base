function refresh() {
    $("#q_search").val("");
    
    $("#search-form").submit();
}

// DOM load
$(function() {
    // Disable autocomplete
    disableAutocomplete();
    
    // form submit
    $("#search-form").submit(function() {
        return true;
    });
    
  //Scroll to top
    $(window).scroll(function() {
        if(jQuery(this).scrollTop() != 0) {
            jQuery('#toTop').fadeIn();  
        } else {
            jQuery('#toTop').fadeOut();
        }
    });
    
    $('#toTop').click(function() {
        jQuery('body,html').animate({scrollTop:0},800);
    }); 
});