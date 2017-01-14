<?php $_sub_title = "danh sách hạng mục"; ?>
<div class="information_category">
    <?php 
    for ($i=0; $i < count($_fields_main); $i++) { 
        $obj = $_fields_main[$i];
        echo _render_html($obj);
    }
     ?>
</div>
<div class="content-box column-left" style="width:100%">
    <div class="content-box-header">
        <h3><?php echo $_sub_title; ?></h3>
    </div>
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <div id="dt_example">
                <div id="container">
                    <div id="demo">
                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                            <thead>
                                <tr>
                                    <th>tên hạng mục</th>
                                    <th>giá tiền</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div style="padding-bottom: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <input type="button" onclick="addrow()" value="Thêm" class="addrow">
    </div>
</div>