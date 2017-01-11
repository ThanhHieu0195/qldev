String.format = function(text) {
    if (arguments.length <= 1) {
        return text;
    }
    var tokenCount = arguments.length - 2;
    for (var token = 0; token <= tokenCount; token++) {
        text = text.replace(new RegExp("\\{" + token + "\\}", "gi"),
                arguments[token + 1]);
    }
    return text;
};

$(document).ready(function() {
	//load các key hợp lệ

	sendRequesttoServer("loadKeyValid");
	sendRequesttoServer("loadListDetail");
	sendRequesttoServer("loadinfo");

	var key_down="none";
	// chức năng màn hình chính
	$('.myFunc').hover(function() {
		/* Stuff to do when the mouse enters the element */
		$('img').click(function(event) {
		/* Act on the event */
		$('img').hide('1', function() {
			$('.tools').show('3000');
		});

	});
	}, function() {
		/* Stuff to do when the mouse leaves the element */
		$('.tools').hide('1', function(){
			$('img').show('3000');
		});
	});

	// chức năng với node
	$("#add").click(function(event) {
		var content = $("#addcontent").val();
		if (content == "") {
			content = "Không có mô tả";
		}
		if (content == "") {
			myHide(['add','over']);
		} else {
			var uid = $('#adduid').val();
			uid = uid.replace("#", "");
			var manv = $('#addmanv').val();
			sendRequesttoServer("addNode", {content:content, uid:uid, manv:manv});
		}

		myHide(['addbox']);
		return false;
	});
	$('#del').click(function(event) {
		var key = $('#delkey').val();
		var arr = $('canvas').getLayer(key).groups;
		sendRequesttoServer("delNode", {id:key, g:arr});
		myHide('delbox');
	});
	$("#move").click(function(event) {
		/* Act on the event */
		var key = $('#movekey').val();
		var uid = $('#movetouid').val();
		sendRequesttoServer("moveNode", {id:key, uid:uid});
		myHide(['movebox']);
	});

	$('#edit').click(function(event) {
		/* Act on the event */
		var key = $('#editkey').val();
		var content = $('#ectn').val();
		sendRequesttoServer("editNode", {id:key, content:content});
		myHide(['editbox']);
	});

	$('#searchInfoKey').click(function(event) {
		/* Act on the event */
		alert('chức năng chưa phát triển');
	});

	var stringSyn="";
	var numkeyd = 0;
	$('body').keydown(function(event) {
			if (key_down == "none") {
				stringSyn += event.originalEvent.key;
				showCsl(stringSyn);
				numkeyd ++;

				if (stringSyn == "Controlm") {
					key_down = "movechart";
					$("#over").show();
					stringSyn = "";
				}

				if (numkeyd > 2){
					numkeyd = 0;
					stringSyn = "";
				}
			}

			if (key_down == "movechart") {
				var key = event.originalEvent.key;
				switch (key) {
					case "ArrowUp":
					moveNodes(1,0,0,0);
					showCsl("up");
					break;
					case "ArrowDown":
					moveNodes(0,1,0,0);
					showCsl("down");
					break;
					case "ArrowLeft":
					moveNodes(0,0,1,0);
					showCsl("left");
					break;
					case "ArrowRight":
					moveNodes(0,0,0,1);
					showCsl("right");
					break;
					case "Escape":
					key_down = "none";
					$("#over").hide();
					break;
				}
			}
		});
});

function myHide(arr) {

		showCsl(arr);
		if (arr.indexOf("addbox") > -1) {
			$(".addbox").hide();
		}

		if (arr.indexOf("boxfunc") > -1) {
			$('.boxfunc').hide();
		}

		if (arr.indexOf("movebox") > -1) {
			$('.movebox').hide();
		}

		if (arr.indexOf("editbox") > -1) {
			$('.editbox').hide();
		}

		if (arr.indexOf("delbox") > -1) {
			$('.delbox').hide();
		}

		$("#over").hide();

		return false;
}
var load;
var flag = false;
function loading() {
	load = $('#loading').bPopup({escClose : false, modalClose : false});
}
function loaded() {
	load.close();
}