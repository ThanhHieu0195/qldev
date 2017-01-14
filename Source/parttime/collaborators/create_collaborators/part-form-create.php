  <div class="content-box column-left" style="width:100%">
    <div class="content-box-header">
        <h3><?php echo $title; ?></h3>
    </div>
    <div class="content-box-content">
        <form method="POST" onsubmit="return submitfAdd()" enctype="multipart/form-data">
            <table id="t_create_building">
                <?php 
                for ($i=0; $i < count($fields); $i++):
                   $th = _render_html( array("tag"=>"label","innerHTML", "value"=>$labels[$i]) );
                   $td = _render_html($fields[$i]);
                   echo "<tr> <td>$th</td> <td>$td</td> <td></td> </tr>";                                    
                endfor;
                 ?>
            </table>
            <?php 
            echo "</br>";
            echo _render_html($add_job);
            echo " &nbsp; ";
            echo _render_html($reset);
             ?>
        </form>
    </div>
</div>