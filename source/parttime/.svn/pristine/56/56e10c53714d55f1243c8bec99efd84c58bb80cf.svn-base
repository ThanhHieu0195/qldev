// dữ liệu thông tin nhân viên
var json = {};
// thông tin chi tiết của nhân viên
var listInfo = [];
// kích thước của rectagle
var h_rect, w_rect, w_canvas, h_canvas;
// danh sách root
var listRoot = [];
// vị trí vẽ node
var p_node = {x:0, y:0};
// 
var listColor = {'quản trị viên':'#8F1010', 'Quản Lý':'#623C0A'};

$(document).ready(function() {
	h_rect = 50;
	w_rect = 95;
	h_canvas = 1000;
	w_canvas = 1200;
	// Draw a green rectangle
	sendRequesttoServer("loadAllNodes");
});

// vẽ 1 node
function drawNode(node, x, y) {
	drawShape(node, x, y);
	var node_id = node.id;

	if (node.uid!=null) {
		var uid = getFormatKey(node.uid);

		var obj = getInfoNode(uid);
		showCsl(obj);

		addGroupsNode(getFormatKey(node_id), uid);

		var key_target = String.format("target{0}-{1}", obj.id, node_id);
		// position root
		var r = {x:obj.x, y:obj.y};
		// position node target
		var t = {x: x, y:y};
	

		if (r.y == t.y) {
			r.x+=w_rect/2;
			t.x-=w_rect/2;
		} else {
			r.y += h_rect/2;
			t.x -= w_rect/2;
		}

		drawTarget(key_target, r.x, r.y, t.x, t.y);
	}

	var node_children = getChild(node_id);
	showCsl(node_children);
	if (node_children.length > 0) {
		for (var i = 0; i < node_children.length; i++) {
			var _x = x + w_rect*2;
			var obj = getInfoId(node_children[i]);
			showCsl(obj);
			drawNode(obj, _x, p_node.y);
		}
	} else {
		p_node.y += h_rect*2;
	}
	return true;
}
// lấy danh sách node con
function getChild(id) {
	var listNode = [];
	for (var i = 0; i < json.data.length; i++) {
		var obj = json.data[i];
		if (obj.uid == id) {
			listNode.push(obj.id);
		}
	}
	return listNode;
}
// định dạng node
function getFormatKey(id) {
	// kiểm tra truyền vào có phải là key hay ko
	if (id.indexOf('#')==-1){
		id = String.format("#{0}", id);
	}
	return id;
}
function getFormatId(key) {
	return key.replace("#", ""); 
}

// lấy 1 thông tin nhân viên
function getInfoId(id) {
	for (var i = 0; i < json.data.length; i++) {
		var obj = json.data[i];
		if (obj.id == id) {
			return obj;
		}
	}
	return null;
}

// lấy thông tin node
function getInfoNode(id) {
	var key = getFormatKey(id);
	var obj = $('canvas').getLayer(key);
	if (obj) {
		return obj;
	} 
	return null;
}
// vẽ root
function drawRoot(node) {
	var key = getFormatKey(node.id); 
	if (checkKeyNode(key)) {
		var obj = getInfoNode(key);
		p_node.x = obj.x;
		p_node.y = obj.y;
	}

	if (rootNode.indexOf(key) == -1) {
		p_node.x = w_rect;
		p_node.y = 2*h_rect;
		rootNode.push(key);
		var level = rootNode.length;
		drawNode(node, p_node.x, p_node.y);
	}
	return rootNode;
}

function showCsl(text) {
	console.log(text);
}

// duy chuyển node
function moveNodes(u=0, d=0, l=0, r=0) {
showCsl('đang duy chuyển');
	var space_x = 0;
	var space_y = 0;

	if (u==1){
		space_y = -h_rect;
	}
	if (d==1){
		space_y = h_rect;
	}
	if (l==1){
		space_x = -w_rect;
	}
	if (r==1){
		space_x = w_rect;
	}

	var arr = $('canvas').getLayers();
	for (var i = 0; i < arr.length; i++) {
		var x = arr[i].x+space_x;
		var y = arr[i].y+space_y;
		$('canvas').setLayer(arr[i].name, {x:x, y:y});
	}
	$('canvas').drawLayers();

}

// 
function addGroupsNode(key, ukey) {
	var p = $('canvas').getLayer(ukey);
	if (p.groups.indexOf(key) == -1){
		$('canvas').setLayer(ukey, {add_groups:p.groups.push(key)});
		return true;
	}
	return false;
}

function drawTarget(key, x1, y1, x2, y2){
	$('canvas').drawLine({
	  layer:true,
	  name:key,
	  strokeStyle: '#000',
	  strokeWkeyth: 4,
	  rounded: true,
	  startArrow: true,
	  arrowRadius: 15,
	  arrowAngle: 90,
	  x1: x2, y1: y2,
	  x2: x1, y2: y1
	});
}

function checkKeyNode(key) {
	var arr = $('canvas').getLayer(key);
	if (arr) {
		return true;
	}
	return false;
}

function getColorByLevel(l) {
	return listColor[l];
}

function drawShape(node, x, y) {
	showCsl('draw node:' + node.id);
	var _key = getFormatKey(node.id);
	var color = "#000E93";
	if (getColorByLevel(node.mota)) {
		showCsl("color");
		color = getColorByLevel(node.mota);
	} 

	$('canvas').drawRect({
		layer:true, name:_key, text:node.manv, fillStyle: color, x: x, y: y, height:h_rect, width:w_rect,
		mouseover: function(layer) {
			$(this).animateLayer(layer, {fillStyle:'#F30B0B'}, 100);

			showCsl("mouseover");	
			showCsl('key: ' + _key);

			$('.info').css({
				top: layer.y - 1.5*h_rect,
				left: layer.x + 2*w_rect
			});

			$('.info').show(100, function(){
				var obj = listInfo[node.manv];
				$('.info > p.iname').html("Họ tên: " + obj.hoten);
				$('.info > p.iid').html("Mã nv: " + obj.manv);
				$('.info > p.ictn').html("Chức vụ: " + node.mota);

				if (node.uid == null)
					$('.info > p.iuid').html("Không bị quản lý");
				else {
					var key_parent = getFormatKey(node.uid);
					var umanv = $('canvas').getLayer(key_parent).text;
					$('.info > p.iuid').html("Quản lý bởi: " + umanv);
				}
			});
		},
		mouseout: function(layer) {
			showCsl('moverout');
			$(this).animateLayer(layer, {fillStyle:color}, 100);
			$('.info').hide(100);
		},
		click:function(layer) {
			$('#over').show(0, function() {

				$('.boxfunc').show('1000', function() {
					// sự kiện click thêm
					$('.boxfunc > #fadd').click(function(event) {
						/* Act on the event */
						$('.boxfunc').hide(0);
						$('.addbox').show('400', function() {
							var id = json.data.length;
							id = json.data[id-1].id; 
							id = parseInt(id) +1;
							key = getFormatKey(id+"");
							$('#addkey').val(key);
							$("#adduid").val(layer.name);
						});
					});

					// sự kiện movenode
					$('.boxfunc > #fmove').click(function(event) {
						/* Act on the event */
						$('.boxfunc').hide(0);
						// lấy key uid
						var pkey = getFormatKey(node.uid+"");

						$('.movebox').show('400', function() {
							var key = getFormatKey(node.id+"");
							var data = json.data;
							var html = "";

							for (var i = 0; i < data.length; i++) {
								var id = data[i].id;
								if (id != node.id){
									html += "<option value='key'>manv</option>";
									html = html.replace("key", getFormatKey(id));	
									html = html.replace("manv", data[i].manv);
								}
							}
							$('#movekey').val(key);
							$("#moveuid").val(pkey);
							$('#movetouid').html(html);							
						});
				
					});
					// editbox
					$('.boxfunc > #fedit').click(function(event) {
						/* Act on the event */
						$('.boxfunc').hide(0);
						$('.editbox').show('400', function() {
							$('#ectn').val(node.mota);	
							$('#editkey').val(getFormatKey(node.id));					
						});
				
					});

					$('.boxfunc > #fdelete').click(function(event) {
						/* Act on the event */
						$('.boxfunc').hide(0);
						$('.delbox').show('400', function() {
							var key = getFormatKey(node.id);
							$('#delkey').val(key);	
							var groups = $('canvas').getLayer(key).groups;
							var html = "";
							for (var i = 0; i < groups.length; i++) {
								var obj = $('canvas').getLayer(groups[i]);
								if (obj) {
									html += String.format("<option value='{0}'>{0}</option>", obj.text) 
								}
							}
							$('#delkeys').html(html);			
						});
				
					});

					// sự kiện click thoát
					$('.boxfunc > #fexit').click(function(event) {
						$('.boxfunc').hide(0, function() {
							$('#over').hide();
						});
					});

				});;
			});
		}
	});
	// vẽ chữ
	$('canvas').drawText({
		layer:true, name:_key+"_text",
		fillStyle: '#FFFFFF',
		  strokeWkeyth: 2,
		  x: x, y: y,
		  fontSize: 16,
		  fontFamily: 'Verdana, sans-serif',
		  text: node.manv
	});
}

function resetCanvas() {
	$('canvas').removeLayers().drawLayers();
}
