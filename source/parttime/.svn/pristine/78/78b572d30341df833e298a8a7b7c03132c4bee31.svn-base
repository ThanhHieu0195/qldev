 <div class="content-box column-left" style="width:100%">
    <div class="content-box-header">
        <h3><?php echo $title; ?></h3>
    </div>
    <div class="content-box-content" >
        <div class="tab-content default-tab">
        <table>
	    	<?php 
	    		$fm = "<tr> <th>%s</th> <td>%s</td> </tr>";
	    		for ($i=0; $i < count( $_fields ); $i++) { 
                                //echo json_encode($_fields[$i]);
	    			echo sprintf( $fm, $_labels[$i], _render_html( $_fields[$i] ) );
	    		}
	    	 ?>
        </table>
        </div>
    </div>
</div>
          
