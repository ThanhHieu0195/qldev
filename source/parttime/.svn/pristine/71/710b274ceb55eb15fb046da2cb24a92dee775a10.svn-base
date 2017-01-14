<?php
$title = "Bảng Khoan";
$labels = array('Mã khoan', 'Mô tả', 'Chức năng');
$btn_add = array('tag' => 'input', 'class' => 'button', 'onclick' => 'show_form_add();', 'type' => 'button', 'value' => 'Add');
?>

<div class="content-box column-left" style="width:100%">
    <div class="content-box-header">
        <h3><?php echo $title; ?></h3>
    </div>
    <div class="content-box-content" >
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
                <?php echo _render_html( $btn_add ); ?>
            </div>
        </div>
    </div>
</div>
          
