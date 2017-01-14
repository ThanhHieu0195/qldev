rootNode = [];
function sendRequesttoServer(action, ctx=null){
	var result;
	switch (action) {
		case "loadAllNodes":
			loading();
			$.ajax({
				url: '../ajaxserver/view_chart_server.php',
				type: 'POST',
				dataType: 'text',
				data: {action:"load"},
			})
			.done(function(responce) {
				result = jQuery.parseJSON(responce);
				json = result;
				rootNode = [];

				flag = false;
				if (json['result'] == "success") {
					var data = json.data;
					var obj = data[0];
					resetCanvas();
					showCsl('root: ' + drawRoot(obj));
					loaded();
				}		
			});
			break;
		case "loadKeyValid":
			$.ajax({
				url: '../ajaxserver/view_chart_server.php',
				type: 'POST',
				dataType: 'text',
				data: {action: 'loadkeyvalid'},
			})
			.done(function(responce) {
				var result = jQuery.parseJSON(responce);
				if (result['result'] == "success") {
					var listKeyValid = result.data;
					var html = "";
					for (var i = 0; i < listKeyValid.length; i++) {
						html += "<option value='manv'>hoten</option>";
						html = html.replace("manv", listKeyValid[i].manv);
						html = html.replace("hoten", listKeyValid[i].hoten);
					}
					$('#addmanv').html(html);
				}
			});
		break;
		case "moveNode":
		loading();
		ctx.id = getFormatId(ctx.id); 
		ctx.uid = getFormatId(ctx.uid); 
		$.ajax({
			url: '../ajaxserver/view_chart_server.php',
			type: 'POST',
			dataType: 'text',
			data: {action: 'move', obj:ctx},
		})
		.done(function(responce) {
			loaded();
			var result = jQuery.parseJSON(responce);
			if (result['result'] == "success") {
				$('canvas').removeLayers().drawLayers();
				sendRequesttoServer("loadKeyValid");
				sendRequesttoServer("loadAllNodes");
			}
		});
		break;
		case "editNode":
		loading()
		ctx.id = getFormatId(ctx.id); 
		showCsl(ctx);
		$.ajax({
			url: '../ajaxserver/view_chart_server.php',
			type: 'POST',
			dataType: 'text',
			data: {action: 'edit', obj:ctx},
		})
		.done(function(responce) {
			loaded();
			var result = jQuery.parseJSON(responce);
			if (result['result'] == "success") {
				$('canvas').removeLayers().drawLayers();
				sendRequesttoServer("loadKeyValid");
				sendRequesttoServer("loadAllNodes");
			}
		});
		break;
		case "addNode":
			loading();
			$.ajax({
				url: '../ajaxserver/view_chart_server.php',
				type: 'POST',
				dataType: 'text',
				data: {action: 'add', obj:ctx},
			})
			.done(function(responce) {
				loaded();
				var result = jQuery.parseJSON(responce);
				if (result['result'] == "success") {
					sendRequesttoServer("loadKeyValid");
					sendRequesttoServer("loadAllNodes");
				}
			});
		break;
		case "loadinfo":
		$.ajax({
			url: '../ajaxserver/view_chart_server.php',
			type: 'POST',
			dataType: 'text',
			data: {action: 'loadinfo'},
		})
		.done(function(responce) {
			var result = jQuery.parseJSON(responce);
			if (result['result'] == "success") {
				var data = result['data'];
				for (var i = 0; i < data.length; i++) {
					listInfo[data[i].manv] = data[i];
				}
			}
		});

		break;

		case "loadListDetail":
		$.ajax({
			url: '../ajaxserver/view_chart_server.php',
			type: 'POST',
			dataType: 'text',
			data: {action: 'loadlistdetail'},
		})
		.done(function(responce) {
			var result = jQuery.parseJSON(responce);
			if (result['result'] == "success") {
				var data = result["data"]; 
				var html = "";
				for (var i = 0; i < data.length; i++) {
					html += "<option value='id'>mota</option>";
					html = html.replace("id", data[i].mota);
					html = html.replace("mota", data[i].mota);
				}
				$('#addcontent').html(html);
				$('#ectn').html(html);
			}
		});
		break;

		case "delNode":
		loading();
		ctx.id = getFormatId(ctx.id);
		for (var i = 0; i < ctx.g.length; i++) {
		  	ctx.g[i] = getFormatId(ctx.g[i]);
		 } 

		$.ajax({
			url: '../ajaxserver/view_chart_server.php',
			type:'POST',
			dataType: 'text',
			data: {action: 'delnode', obj:ctx},
		})
		.done(function(responce) {
			loaded();
			var result = jQuery.parseJSON(responce);
			if (result['result'] == "success") {
				$('canvas').removeLayers().drawLayers();
				sendRequesttoServer("loadKeyValid");
				sendRequesttoServer("loadAllNodes");
			}
		});
		break;
	}
}
