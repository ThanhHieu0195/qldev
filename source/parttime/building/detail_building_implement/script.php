 <link rel="stylesheet" href="../resources/chosen/chosen.css">  
 <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>   
 <script type="text/javascript">
        function changeNotification(text, f=false) {
            if (f) {
                $('#sts_notifi span').css('color', '#FF0000');    
            } else{
                $('#sts_notifi span').css('color', '#FF8400');    
            }
            $('#sts_notifi span').html(text);
        }
        /*----------  trừ 2 ngày  ----------*/
        function subDate(d1, d2) {
            var d1 = new Date(d1); //"now"
            var d2 = new Date(d2)  // some date
            var diff = d1-d2;
            return diff;
        }

        /*----------  Kiểm tra hợp lệ của ngày bắt đầy và dự đoán hoàn thành  ----------*/
        function checkConditionDate(startdate, stopdate) {
            var batdau = $('input[name="'+startdate+'"]').val();
            var ketthuc = $('input[name="'+stopdate+'"]').val();
            if (subDate(ketthuc, batdau) >= 0) {
                return true;
            }
            alert('ISSUE: Ngày bắt đầu lớn hơn ngày hoàn thành');
            return false;
        }
      
        /*-----------Date calculation ------------------------------*/
        function dateCalculation(token, datex, startname, stopname) {
            var date2 = $('input[name="' + startname +token+'"]').datepicker('getDate', '+1d');
            date2.setDate(date2.getDate()+parseInt(datex));
            $('input[name="' + stopname +token+'"]').datepicker('setDate', date2);
            $('input[name="button-category'+token+'"]').show();
        }
   
        /*-----------Show nut update ------------------------------*/
        function showUpdateButton(token) {
            $('input[name="button-category'+token+'"]').show();
        }

        /*-----------Show nut update ------------------------------*/
        function hideUpdateButton(token) {
            $('input[name="button-category'+token+'"]').hide();
        }

        /*-----------Show nut update ------------------------------*/
        function showUpdateButtonMaterial(cata,row) {
            $('input[name="update_material_button_'+cata+'_'+row+'"]').show();
        }

        /*-----------Show nut update ------------------------------*/
        function hideUpdateButtonMaterial(cata,row) {
            $('input[name="update_material_button_'+cata+'_'+row+'"]').hide();
        }

        /*----------  Tính dự đoán chi phí tự động  ----------*/
        function calautoExpectMoney(token, source, dest) {
            var num = $('input[name="'+source+token+'"]').val();
            var dongia = $('input[name="'+source+token+'"]').attr('dongia');
            var price = parseInt(num)*parseInt(dongia);
            console.log(num + "  " + dest);
            if (price) {
                $('input[name="'+dest+token+'"]').val( number2string(price) );
            } else {
                $('input[name="'+dest+token+'"]').val(0);
            }
            showUpdateButton(token);
        }

        function approvedCongTrinh(id_building) {
            if (confirm('Bạn đã hoàn tất cập nhật dự toán ?')) {
		var path = "../ajaxserver/update_detail_building_server.php";
		var data_update_category = {
		    "method":'update-approve-congtrinh',
		    "id_building": id_building
		};
		$.post(path, data_update_category, function(data, textStatus, xhr) {
		    if (data=="1") {
                        window.location = "../building/list_building.php";
		    } else {
			alert('Có lỗi xảy ra trong quá trình cập nhật');
		    }
		});
            }
        }

        function updateCategory(token) {
            var id_category = token;
            var columns = ['ngaybatdau', 'ngayketthuc'];
            var conditions = {'idcongtrinh':id_building,'idhangmuc':token};
            var ngaybatdau = $('inpt[name="ngaybatdau'+token+'"]').val();
            var ngayketthuc = $('input[name="ngayketthuc'+token+'"]').val();
            if (subDate(ngayketthuc, ngaybatdau) < 0) {
                alert('Ngày bắt đầu và kết thúc không hợp lệ');
                return;
            }
            var path = "../ajaxserver/update_detail_building_server.php";
            var test = {};
            for (var i = 0, len = columns.length; i < len; i++) {
                col = columns[i];
                tmp = $('input[name="'+col+token+'"]').val();
                if (tmp !== undefined) {
                    if ((col=='khoiluongthucte')&&(tmp==0)) {
                        alert('Khối lượng thi công phải lớn hơn 0!');
                        return;
                    }
                    test[col] = tmp;
                }
            }

            var data_update_category = {
                "method":'update-category', 
                "params": test,
                "conditions": conditions 
            };

            $.post(path, data_update_category, function(data, textStatus, xhr) {
                    var data_update_real_money = {"method":"update-real-money", "token": id_building};
                    updateRealMoney(path, data_update_real_money, true, token);
                   
            });
        }


        function deleteCategory(token) {
            if (confirm('Bạn có chắc là muốn xóa hạng mục này ?')) {
                var conditions = {"idcongtrinh": id_building, "idhangmuc": token};
                var path = "../ajaxserver/update_detail_building_server.php";
		var data_delete_category = {
		    "method":'delete-category',
		    "conditions": conditions
		};

		$.post(path, data_delete_category, function(data, textStatus, xhr) {
			var data_update_real_money = {"method":"update-real-money", "token": id_building};
			updateRealMoney(path, data_update_real_money, true, token);

		});
             }
        }

        function updateRealMoney(path, data_update_real_money, reload = false, token) {
             $.post(path, data_update_real_money, function(data, textStatus, xhr) {
                if(reload) {
                    window.location = "";
                } else {
                    json = jQuery.parseJSON(data);
                    if (json['money_real'] != -1) {
                        var money_real = json['money_real'];
                        $('#cost_real').html("Giá dự toán: " + number2string(money_real));
                        hideUpdateButton(token);
                    }
                }
            });
        }

        function autoExpectNum(token, idrow) {
            var parent = String.format('table[idcategory={0}] tr[idrow={1}]', token, idrow);
            var id_material_category = $(parent + " .name_material_category").val();
            var pricehight = data_material_category[token][id_material_category];
            var num = $(parent + " .soluongthucte").val();
            pricehight = parseFloat(pricehight);
            num = parseInt(format_num(num));
            if (num) {
                val = pricehight*num;
            } else {
                val = 0;
            }
            $(parent + " .auto_expect_money").html(number2string(val));
            showUpdateButtonMaterial(token, idrow);
        }

        function autoExpectNumUnit(token, idrow) {
            var parent = String.format('table[idcategory={0}] tr[idrow={1}]', token, idrow);
            var id_material_category = $(parent + " .name_material_category").val();
            var pricehight = data_material_category[token][id_material_category];
            pricehight = parseFloat(pricehight);
            $(parent + " .dongiavattu").html(number2string(pricehight));
            $(parent + " .soluongthucte").attr("readonly", false); 
        }

//        function addRowHtml(id_category) {
//            var parent = String.format('table[idcategory="{0}"] tbody', id_category);
//            var fm = data_material_category[id_category]['fm'];
//
//            var data = {"method":"take-id-detail-material-category"};
//            $.post(path, data, function(data, textStatus, xhr) {
//                json = jQuery.parseJSON(data);
//                var idrow = parseInt(json.result) + 1;
//
//                idrow = createNewIdRow(idrow);
//                fm = String.format(fm, idrow);
//                $(parent).append(fm.replace('disabled',''));
//                $('input[idadd="'+id_category+'"]').prop("disabled", true);
//            });
//        }

        function show_form_add_material(idhangmuc) {
            var name_form = "form[name=\"themvattu_"+idhangmuc+"\"]";
            var name_button_clicked = "input[idadd='"+idhangmuc+"']";
            var status = $(name_form).attr('status');
            status = parseInt(status);
            if (status == 0) {
                $(name_form).show(500);
                $(name_button_clicked).val('Ẩn');
            } else {
                $(name_form).hide(500);
                $(name_button_clicked).val('Phát sinh');

            }
            $(name_form).attr('status', 1-status);
        }

        function createNewIdRow(id_last) {
            var num = $('tr[idrow="+id_last+" ]').length;
            return parseInt(id_last) + num;
        }
        function delRow(id_category, id_row) {
            if (confirm('Bạn muốn xóa hàng này ?')) {
		var parent = String.format('table[idcategory={0}] tbody', id_category);
		var _idrow = String.format(parent+" tr[idrow={0}]", id_row);

		var data = {"method":"del-detail-material-category",
					"params":{'id':id_row}};
		$.post(path, data, function(data, textStatus, xhr) {
		    json = jQuery.parseJSON(data);
		    if (json.result) {
			alert('Xóa thành công!');
			
			var data_update_real_money = {"method":"update-real-money", "token": id_building};
			updateRealMoney(path,  data_update_real_money);
			$(_idrow).remove(); 
		    } else {
			  alert('Xóa thất bại!');
		    }
		});
            }
        }

        function row_remove_row_html(id_category, id_row) {
            var parent = String.format('table[idcategory={0}] tbody', id_category);
            var _idrow = String.format(parent+" tr[idrow={0}]", id_row);
            $('input[idadd="'+id_category+'"]').prop("disabled", false);
            $(_idrow).remove(); 
        }
        

        function updateRowMaterial(id_category, id_row) {
            var data_material_category = {"method":"update-detail-material-category",
                                        "params":{},
                                        "conditions":{}};
            var path = "../ajaxserver/update_detail_building_server.php";
            var id_material = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('select').val();
            var soluongthucte = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('.soluongthucte').val();
            var conditions = {"id":id_row,"idcongtrinh":id_building, "idhangmuc":id_category, "idvattu":id_material};
            var params = {"soluongthucte":soluongthucte};
            data_material_category['params'] = params;
            data_material_category['conditions'] = conditions;
            if (id_building != "" && id_category != "" && id_material!= "") {
                $.post(path, data_material_category, function(data, textStatus, xhr) {
                    // cập nhật chi tiết hạng mục
                    json = jQuery.parseJSON(data);
                    if ( json.result == true) {
                        var data_update_real_money = {"method":"update-real-money", "token": id_building};
                        updateRealMoney(path, data_update_real_money);
                        alert('Cập nhật thành công!');
                        hideUpdateButtonMaterial(id_category, id_row);
                    }
                });
            } else {
                alert('Thông số rỗng');
            }
        }

        function addRowMaterial(id_category, id_row) {
            var data_material_category = {"method":"insert-detail-material-category",
                                        "params":{}};
            var path = "../ajaxserver/update_detail_building_server.php";
            var id_material = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('select').val();
            var soluongthucte = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('.soluongthucte').val();
            var dongiavattu = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('.dongiavattu').html();
            dongiavattu = format_num(dongiavattu);
            if (soluongthucte==0) {
                alert('Số lượng không hợp lệ');
                return;
            }
            var params = [id_row, id_building, id_category, id_material, dongiavattu, '0', soluongthucte, '0', '', '', '', '', ''];
            data_material_category['params'] = params;
             
            if (id_building != "" && id_category != "" && id_material!= "") {
                $.post(path, data_material_category, function(data, textStatus, xhr) {
                    json = jQuery.parseJSON(data);
                    if ( json.result == true ) {
                        var data_update_real_money = {"method":"update-real-money", "token": id_building};
                        updateRealMoney(path, data_update_real_money);
                        var btn_update = "<input type=\"button\" onclick=\"updateRowMaterial('{0}', '{1}')\" value=\"Update\" style=\"padding:3px 8px; display:none\">";
                        var btn_del = "<input type=\"button\" onclick=\"delRow('{0}', '{1}')\" value=\"Delete\" style=\"padding:3px 8px\">";
                        btn_update = String.format(btn_update, id_category, id_row);
                        btn_del = String.format(btn_del, id_category, id_row);
                        $("tr[idrow="+id_row+"] td").last().html(btn_update+btn_del);
                        $('input[idadd="'+id_category+'"]').prop("disabled", false);
                        alert('Thêm thành công');
                        $(".name_material_category").prop('disabled', 'disabled');
                    }
                });
            } else {
                alert('Thông số rỗng');
            }
        }

        var id_building = '<?php echo $id; ?>';
        var path = "../ajaxserver/update_detail_building_server.php";

        $(document).ready(function() {
            var status = <?php echo json_encode($status); ?>;
            //if (status>=1) {
            //    $('.approved-hide').hide();
            //}
            /*----------  Thiết lập datepicker  ----------*/
            $('input[name="ngaykhoicong"]').datepicker({ 
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateupdate) {
                    if (checkConditionDate("ngaykhoicong","ngaydukienhoanthanh")) {
                        var path = "../ajaxserver/update_detail_building_server.php?method={0}&token={1}&dateupdate={2}";
                        path = String.format(path, 'update-date-start', id_building, dateupdate);
                        $.get(path, function(data) {
                            
                        });
                    }
                }
             }); 
            $('input[name="ngaykhoicong"]').datepicker('setDate', '<?php echo $data_building->ngaykhoicong; ?>');
            $('input[name="ngaydukienhoanthanh"]').datepicker({ 
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateupdate) {
                    if (checkConditionDate("ngaykhoicong","ngaydukienhoanthanh")) {
                        var path = "../ajaxserver/update_detail_building_server.php?method={0}&token={1}&dateupdate={2}";
                        path = String.format(path, 'update-date-expect-complete', id_building, dateupdate);
                        $.get(path, function(data) {
                            
                        });
                    }
                }
             }); 
            $('input[name="ngaydukienhoanthanh"]').datepicker('setDate', '<?php echo $data_building->ngaydukienhoanthanh; ?>');

            $('.ngaypicker').datepicker();

            // $('#f-addcategory').bPopup();
            $('input[name="show-form-category"]').click(function(event) {
                $('input[name="show-form-category"]').hide();
                $('input[name="hide-form-category"]').show();
                $('#f-randomcategory').show();
            });
             $('input[name="hide-form-category"]').click(function(event) {
                $('input[name="show-form-category"]').show();
                $('input[name="hide-form-category"]').hide();
                $('#f-randomcategory').hide();
                $('.child-randomcategory').hide();
             });
             
            $("select[name='add_id_category']").chosen();
            $('#add_group_category').change(function(event) {
                var val = $('#add_group_category').val();
                var path = "ajaxserver.php?action=detail_list_group_construction&do=getlistcategory&group_category="+val;
                $.get(path, function(data) {
                    var json = $.parseJSON(data);
                    if (json.result == 1) {
                        data = json.data;
                        var fm = "<option value='{0}'>{1}</option>";
                        var html = "";
                        for (var i = 0; i < data.length; i++) {
                            var obj = data[i];
                            html += String.format(fm, obj[0], obj[1]);
                        }
                        $('#add_id_category').html(html);
                        $('#add_id_category').trigger('chosen:updated');
                    }
                });
            });

        });

        /*----------  cập nhật expectmoney  ----------*/
        function formatExpectMoney(token) {
            var expect_money = $('input[name="expect_money_category'+token+'"]').val();
            expect_money = format_num(expect_money);
            expect_money = number2string(expect_money);
            $('input[name="expect_money_category'+token+'"]').val(expect_money);
        }

        function showProcessCategoryDialog() {
            var idhangmuc = $('#f-randomcategory select[name="add_id_category"]').val();
            if ( idhangmuc != '' ) {
                $('#f-randomcategory').hide();
                var tenhangmuc  = $('#f-randomcategory select[name="add_id_category"] option[value="'+idhangmuc+'"]').html();
                $('.child-randomcategory .title span').html(tenhangmuc);
                $('.child-randomcategory input[name="idhangmuc"]').val(idhangmuc);
//                insert
                if ( list_category_id.indexOf(idhangmuc) == -1 ) {
                    $('#f-addcategory note').css('color', 'blue').html('Hạng mục chưa tồn tại');
                    $('#f-addcategory input[name="khoiluongcongviechientai"]').val(0);
                    $('#f-addcategory').show();
                }
//                update
                else {
                    $('#f-addcategory note').css('color', 'blue').html('Hạng mục đã tồn tại');
                    $('#f-addcategory input[name="khoiluongcongviechientai"]').val(arr_detail[idhangmuc].khoiluongthucte);
                    if ( arr_detail[idhangmuc].trangthai > 4 ) {
                        $('#f-addcategory note').css('color', 'red').html('Hạng mục đã hoàn thành');
                        $('#f-addcategory input[name="addcategory"] ').remove();
                    }
                    $('#f-addcategory').show();
                }
            }
        }
    </script>
