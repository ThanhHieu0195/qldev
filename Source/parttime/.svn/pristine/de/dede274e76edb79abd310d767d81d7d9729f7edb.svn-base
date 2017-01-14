var AJAX_PENDING_TIMER;
var AJAX_IS_RUNNING = false;

function ShowLoaders() {
	$('#example_processing').css('visibility', 'visible');
}

function HideLoaders() {
	$('#example_processing').css('visibility', 'hidden');
}

/* Show diaglog */
function showDialog(id, action, masotranh, makho) {
	// Thiet lap cac gia tri tren form
	$('#action').val(action);
	$('#masotranh').text(masotranh);
	$('#makho').val(makho);
	$('#soluong').val('');

	var ctrl = $('#' + id).parent().parent().parent();
	$('#tentranh').text($(ctrl).find('div[name="tentranh"]').text());
	$('#loaitranh').text($(ctrl).find('div[name="tenloai"]').text());
	ctrl = $('#' + id).parent().parent();
	$('#tenkho').text($(ctrl).find('div[name="tenkho"]').text());
	$('#soluongtonkho').text($(ctrl).find('div[name="soluongtonkho"]').text());

	// Hien thi label so luong
	if (action == 'update') {
		$('#title').text('Số lượng mới');
	} else {
	}

	// Hien thi dialog
	$("#dialog-form").dialog("open");
}

/* Delete an item */
function deleteItem(action, masotranh, makho) {
	if(confirm('Bạn có chắc chắn muốn xóa không?')) {
		$.ajax({
	        url: '../items/management.php',
	        type: 'POST',
	        cache: false,
	        data: {
	        	action: action,
	        	masotranh: masotranh,
	        	makho: makho
			},
			beforeSend: function() {
				ShowLoaders();
			},
			complete: function() {
				HideLoaders();
			},
			success: function(data, textStatus) {
				HideLoaders();
				
				getData(-1);
	        },
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				HideLoaders();
	        }
	    });
	}
}

/* Get data from server */
function getData(currentPage) {
	
	if(AJAX_IS_RUNNING == true) {
		return;
	}
	
	AJAX_IS_RUNNING = true;
	
	var page;
	switch(currentPage) {
		case -1:	
			page = $('.paging_this_page').text();
			break;
	
		case 0:	
			page = 1;
			break;
			
		default:
			page = currentPage;
	}
	
	$.ajax({
        url: '../ajaxserver/item_list_server.php',
        type: 'POST',
        cache: false,
        data: {
        	data_length: $('#data_length').val(),
        	data_filter: $('#data_filter').val(),
        	current_page: page
		},
		beforeSend: function() {
			// Before send request
			// Show the loader
			AJAX_IS_RUNNING = true;
			ShowLoaders();
		},
		complete: function() {
			// When Sent request
			// Hide the loader
			AJAX_IS_RUNNING = false;
			HideLoaders();
		},
		success: function(data, textStatus) {
			AJAX_IS_RUNNING = false;
			HideLoaders();
			//alert(data);
			
			array = data.split('[:nhilong:]');
        	$('#item_list').html(array[0]);
        	$('#pagging_info').html(array[1]);
        	
        	// show/hide inline menu
        	$('.number').mouseover(function() {
        		$(this).find('.link').show();
        	}).mouseout(function() {
        		$(this).find('.link').hide();
        	});
        	
        	// tooltip
        	$('.tooltip').tooltip({
        		delay : 50,
        		showURL : false,
        		bodyHandler : function() {
        			return $("<img />").attr("src", $(this).attr('src'));
        		}
        	});
        },
        // We're gonna hide everything when get error
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			AJAX_IS_RUNNING = false;
			HideLoaders();
        }
    });
}

/* DOM load */
$(function() {
	// dialog
	$("#dialog-form").dialog({
				autoOpen : false,
				height : 350,
				width : 415,
				modal : true,
				buttons : {
					"Ok" : function() {
						if ($('#soluong').val() != '') {
							$(this).dialog("close");
							
							$.ajax({
						        url: '../items/management.php',
						        type: 'POST',
						        cache: false,
						        data: {
						        	action: $('#action').val(),
						        	masotranh: $('#masotranh').text(),
						        	makho: $('#makho').val(),
						        	soluong: $('#soluong').val()
								},
								beforeSend: function() {
									ShowLoaders();
								},
								complete: function() {
									HideLoaders();
								},
								success: function(data, textStatus) {
									HideLoaders();									
									getData(-1);
						        },
								error: function(XMLHttpRequest, textStatus, errorThrown) {
									HideLoaders();
						        }
						    });							
						} else {
							$('#soluong').focus();
						}
					},
					Cancel : function() {
						$(this).dialog("close");
					}
				},
				close : function() {

				}
			});
	
	// key up event
	$('#data_filter').keyup(function() {
		//clearTimeout(AJAX_PENDING_TIMER);
		//AJAX_PENDING_TIMER = setTimeout("getData()", 300);
		getData(0);	
	});
	
	// chang data_length
	$('#data_length').change(function() {
		getData(0);
	});
	
	// get data
	getData(0);
});