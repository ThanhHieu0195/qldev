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
        function checkConditionDate() {
            var date_start = $('input[name="date_start"]').val();
            var date_expect_complete = $('input[name="date_expect_complete"]').val();
            if (subDate(date_expect_complete, date_start) >= 0) {
                return true;
            }
            alert('ISSUE: Ngày bắt đầu lớn hơn ngày hoàn thành');
            return false;
        }
      
        /*-----------Date calculation ------------------------------*/
        function dateCalculation(token, datex) {
            var date2 = $('input[name="ngaybatdau'+token+'"]').datepicker('getDate', '+1d');
            date2.setDate(date2.getDate()+parseInt(datex));
            $('input[name="ngaydukienketthuc'+token+'"]').datepicker('setDate', date2);
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
        function calautoExpectMoney(token) {
            var num = $('input[name="khoiluongthucte'+token+'"]').val();
            var price_expect = $('input[name="khoiluongthucte'+token+'"]').attr('price_expect');
            var price = parseInt(num)*parseInt(price_expect);
            if (price) {
                $('input[name="chiphithucte'+token+'"]').val( number2string(price) );
            } else {
                $('input[name="chiphithucte'+token+'"]').val(0);
            }
            showUpdateButton(token);
        }

        function approvedCongTrinh(id_building) {
            var path = "../ajaxserver/update_detail_building_server.php";
            var data_update_category = {
                "method":'update-approve-congtrinh',
                "id_building": id_building
            };
            //console.log(data_update_category);
            $.post(path, data_update_category, function(data, textStatus, xhr) {
                console.log(data);
                if (data=="1") {
                    location.reload();
                } else {
                    alert('Khong the duyet cong trinh');
                }
            });
        }

        function updateCategory(token) {
            var columns = ['ngaybatdau', 'ngaydukienketthuc', 'ngayketthuc', 'iddoithicong', 'dongiathicong', 'dongiadutoan', 'khoiluongdutoan', 'khoiluongthucte', 'khoiluongphatsinh', 'dudoanchiphibandau', 'chiphithucte', 'tiendachi', 'trangthai', 'ghichu', 'danhgiahoanthien', 'khoiluongthicong'];
            var date_start = $('input[name="ngaybatdau'+token+'"]').val();
            var date_expect_complete = $('input[name="ngaydukienketthuc'+token+'"]').val();
            var expect_money = $('input[name="dudoanchiphibandau'+token+'"]').val();
            var khoiluongdutoan = $('input[name="khoiluongdutoan'+token+'"]').val();
            khoiluongdutoan = format_num(khoiluongdutoan);
            expect_money = format_num(expect_money);
            if (subDate(date_expect_complete, date_start) < 0) {
                alert('Ngày bắt đầu và kết thúc không hợp lệ');
                return;
            }
            var path = "../ajaxserver/update_detail_building_server.php";
            var id_category = token;
            var test = {'id_building':id_building,'id_category':token};
            for (var i = 0, len = columns.length; i < len; i++) {
                col = columns[i];
                tmp = $('input[name="'+col+token+'"]').val();
                if (tmp !== undefined) {
                    if (col=='dudoanchiphibandau' || col=='chiphithucte' || col=='tiendachi') {
                        tmp = format_num(tmp);
                    }
                    test[col] = tmp;
                }
            }
            parm = {'id_building':id_building};

            var data_update_category = {
                "method":'update-category', 
                "params": test
            };

            $.post(path, data_update_category, function(data, textStatus, xhr) {
                    var data_update_expect_money = {"method":"update-real-money", "token": id_building};
                    updateRealMoney(path, data_update_expect_money, token);
                   
            });
        }

        function updateRealMoney(path, data_update_expect_money, reload = false, token) {
             $.post(path, data_update_expect_money, function(data, textStatus, xhr) {
                if(reload) {
                    window.location = "";
                } else {
                    json = jQuery.parseJSON(data);
                    if (json['money_real'] != -1) {
                        var money_real = json['money_real'];
                        $('#cost_real').html("Giá thực tế : " + number2string(money_real));
                        hideUpdateButton(token);
                    }
                }
            });
        }

        function autoExpectNum(token, idrow) {
            var parent = String.format('table[idcategory={0}] tr[idrow={1}]', token, idrow);
            var id_material_category = $(parent + " .name_material_category").val();
            var pricehight = data_material_category[token][id_material_category];
            var num = $(parent + " .real_num").val();
            pricehight = parseFloat(pricehight);
            num = parseInt(format_num(num));
            if (num) {
                val = pricehight*num;
            } else {
                val = 0;
            }
            $(parent + " .auto_real_money").html(number2string(val));
            showUpdateButtonMaterial(token, idrow);
        }

        function addRowHtml(id_category) {
            var parent = String.format('table[idcategory="{0}"] tbody', id_category);
            var fm = data_material_category[id_category]['fm'];

            var data = {"method":"take-id-detail-material-category"};
            $.post(path, data, function(data, textStatus, xhr) {
                json = jQuery.parseJSON(data);
                var idrow = parseInt(json.result) + 1;

                idrow = createNewIdRow(idrow);
                fm = String.format(fm, idrow);
                $(parent).append(fm.replace('disabled',''));
                $('input[idadd="'+id_category+'"]').prop("disabled", true);
            });
        }
  
        function createNewIdRow(id_last) {
            var num = $('tr[idrow="+id_last+" ]').length;
            return parseInt(id_last) + num;
        }
        function delRow(id_category, id_row) {
            var parent = String.format('table[idcategory={0}] tbody', id_category);
            var _idrow = String.format(parent+" tr[idrow={0}]", id_row);

            var data = {"method":"del-detail-material-category",
                                    "params":{'id':id_row}};
            $.post(path, data, function(data, textStatus, xhr) {
                json = jQuery.parseJSON(data);
                if (json.result) {
                    alert('Xóa thành công!');
                    
                    var data_update_expect_money = {"method":"update-real-money", "token": id_building};
                    updateRealMoney(path,  data_update_expect_money);
                    $(_idrow).remove(); 
                } else {
                      alert('Xóa thất bại!');
                }
            });

        }

        function row_remove_row_html(id_category, id_row) {
            var parent = String.format('table[idcategory={0}] tbody', id_category);
            var _idrow = String.format(parent+" tr[idrow={0}]", id_row);
            $('input[idadd="'+id_category+'"]').prop("disabled", false);
            $(_idrow).remove(); 
        }
        

        function updateRowMaterial(id_category, id_row) {
            var data_material_category = {"method":"update-detail-material-category",
                                        "params":{}};
            var path = "../ajaxserver/update_detail_building_server.php";

            var id_material = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('select').val();
            var real_num = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('.real_num').val();
            var expect_cost = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('.auto_real_money').html();
            expect_cost = format_num(expect_cost);

            var obj = {"id":id_row,"id_building":id_building, "id_category":id_category, "id_material":id_material};
            obj["soluongthucte"] = real_num;
            obj["giathucte"] = expect_cost;
            data_material_category['params'] = obj;

            if (obj.id_building != "" && obj.id_category != "" && obj.id_material!= "") {
                $.post(path, data_material_category, function(data, textStatus, xhr) {
                    // cập nhật chi tiết hạng mục
                    json = jQuery.parseJSON(data);
                    if ( json.result == true) {
                        var data_update_expect_money = {"method":"update-real-money", "token": id_building};
                        updateRealMoney(path, data_update_expect_money);
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
            var real_num = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('.real_num').val();
            var expect_cost = $('table[idcategory = '+id_category+'] tbody tr[idrow='+id_row+']').find('.auto_real_money').html();
            expect_cost = format_num(expect_cost);

            var obj = {"id":id_row,"id_building":id_building, "id_category":id_category, "id_material":id_material};
            obj["soluongthucte"] = real_num;
            obj["giathucte"] = expect_cost;
            data_material_category['params'] = obj;

            if (obj.id_building != "" && obj.id_category != "" && obj.id_material!= "") {
                $.post(path, data_material_category, function(data, textStatus, xhr) {
                    json = jQuery.parseJSON(data);
                    if ( json.result == true ) {
                        var data_update_expect_money = {"method":"update-real-money", "token": id_building};
                        updateRealMoney(path, data_update_expect_money);
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
            if (status==3) {
                $('.approved-hide').hide();
            }
            /*----------  Thiết lập datepicker  ----------*/
            $('input[name="date_start"]').datepicker({ 
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateupdate) {
                    if (checkConditionDate()) {
                        var path = "../ajaxserver/update_detail_building_server.php?method={0}&token={1}&dateupdate={2}";
                        path = String.format(path, 'update-date-start', id_building, dateupdate);
                        $.get(path, function(data) {
                            
                        });
                    }
                }
             }); 
            $('input[name="date_start"]').datepicker('setDate', '<?php echo $data_building->ngaykhoicong; ?>');
            $('input[name="date_expect_complete"]').datepicker({ 
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateupdate) {
                    if (checkConditionDate()) {
                        var path = "../ajaxserver/update_detail_building_server.php?method={0}&token={1}&dateupdate={2}";
                        path = String.format(path, 'update-date-expect-complete', id_building, dateupdate);
                        $.get(path, function(data) {
                            
                        });
                    }
                }
             }); 
            $('input[name="date_expect_complete"]').datepicker('setDate', '<?php echo $data_building->ngaydukienhoanthanh; ?>');

            $('.ngaybatdau').datepicker();
            $('.ngaydukienketthuc').datepicker();
            // $('#f-addcategory').bPopup();
            $('input[name="show-form-category"]').click(function(event) {
                $('input[name="show-form-category"]').hide();
                $('input[name="hide-form-category"]').show();
                $('#f-addcategory').show();
            });
             $('input[name="hide-form-category"]').click(function(event) {
                $('input[name="show-form-category"]').show();
                $('input[name="hide-form-category"]').hide();
                $('#f-addcategory').hide();
             });
             
            $("select[name='add_id_category']").chosen();

        });

        /*----------  cập nhật expectmoney  ----------*/
        function formatExpectMoney(token) {
            var expect_money = $('input[name="expect_money_category'+token+'"]').val();
            expect_money = format_num(expect_money);
            expect_money = number2string(expect_money);
            $('input[name="expect_money_category'+token+'"]').val(expect_money);
        }
    </script>
