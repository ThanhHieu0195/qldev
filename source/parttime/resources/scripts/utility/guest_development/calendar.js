// Show loading
function showLoading() {
    var html = "";
    
    html += "<center><img src='../resources/images/loadig_big.gif' alt='loading' /></center>";
    
    // Set html content
    $('#notification_msg').html(html);
    
    // Show popup dialog
    $("#button_close_popup").hide();
    $("#popup").css("min-width", "50px");
    $('#popup').bPopup({
        escClose: false,
        modalClose: false
    });
}

// Hide loading
function hideLoading() {
    $('#popup').bPopup().close();
    $('#notification_msg').html('');
}

$(document).ready(function() {
        //initialize the calendar
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            firstDay: 1, // Monday
            dayNamesShort: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                         'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            titleFormat: {
                            month: 'MMMM - yyyy', // September - 2009
                            week: "MMM d yyyy", // Sep 13 2009
                            day: 'MMMM d yyyy'  // September 8 2009
                        },
            buttonText: {
                today:    'Hôm nay',
                month:    'Tháng',
                week:     'week',
                day:      'day'
            },
            //defaultDate: '2014-06-12',
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            loading: function(bool) { 
                if (bool) {
                    showLoading();
                } else {
                    hideLoading();
                } 
             },
            events: {
                url: '../ajaxserver/guest_development_events_feed.php',
                type: 'POST',
                error: function() {
                    if ( window.console && window.console.log ) {
                        // console is available
                        console.log ( 'There was an error while fetching events!' );
                    }
                }
            },
            eventRender: function(event, element) {
                element.tooltip({
                    delay: 50,
                    showURL: false,
                    bodyHandler: function() {
                        return $("<div></div>").html(event.description);
                    }
                });
            },
            eventClick: function(event) {
                // window.open(event.url, 'gcalevent', 'width=700,height=600'); // opens events in a popup window
                window.open(event.url, '_blank'); // opens events in a new tab
                
                return false;
            }
        });
    });
