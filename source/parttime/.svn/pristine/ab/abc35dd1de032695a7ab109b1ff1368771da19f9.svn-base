<?php
$title = "Danh sách chi tiết phần bù cần sản xuất";
$labels = array('Mã đơn hàng', 'Mã số tranh', 'Mã chi tiết', 'Dài', 'Rộng', 'Cao', 'Dán chỉ', 'Mã khoan', 'Mã văn', 'Số lượng', 'Chức năng');
$btn_product = array('tag' => 'input', 'class' => 'button', 'onclick' => 'return confirm("sản xuất các chi tiết đã chọn")&&is_checked();', 'type' => 'submit', 'value' => 'Sản xuất');
?>

<div class="content-box column-left" style="width:100%">
    <div class="content-box-header">
        <h3><?php echo $title; ?></h3>
    </div>
    <div class="content-box-content" >
        <form action="danhsachchitietphanbucansanxuat.php?action=submit" method="POST">
        <div class="tab-content default-tab">
            <div id="dt_example">
                <div id="container">
                    <div class="detail-category">
                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="t_detail">
                            <thead>
                                <tr>
                                <?php 
                                    for ($i=0; $i < count($labels); $i++):
                                        echo _render_html( array("tag"=>"th","innerHTML", "value"=>$labels[$i]) );;
                                    endfor; 
                                 ?>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div style="padding-bottom: 10px;"></div>
                    </div>
                </div>
                <?php echo _render_html( $btn_product ); ?>
            </div>
        </div>
        </form>
    </div>
</div>
          
