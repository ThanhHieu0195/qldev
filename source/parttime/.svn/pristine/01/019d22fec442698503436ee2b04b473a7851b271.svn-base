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
                                    $lent = count($labels);
                                    for ($i=0; $i < $lent - 1; $i++):
                                        echo _render_html( array("tag"=>"th","innerHTML", "value"=>$labels[$i]) );
                                    endfor; 
                                    echo _render_html( array("tag"=>"th","innerHTML", 'style' => 'width: 200px', "value"=>$labels[$lent - 1]) );
                                 ?>
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
    </div>
</div>
          
