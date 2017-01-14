 <div class="content-box column-left" style="width:100%">
    <div class="content-box-header">
        <h3><?php echo $title; ?></h3>
    </div>
    <div class="content-box-content" >
        <div class="tab-content default-tab">
        <form method="post" action="" id="f-detail" enctype="multipart/form-data"> 
        <table>
	    	<?php 
	    		$fm = "<tr> <th>%s</th> <td>%s</td> </tr>";
	    		for ($i=0; $i < count( $_fields ); $i++) { 
                    if ( $_labels[$i] == 'Attachment') {
                        echo sprintf( $fm, $_labels[$i], _render_html( $_fields[$i] )._render_html($tb_information_attachment) );
                    } else {
                        echo sprintf( $fm, $_labels[$i], _render_html( $_fields[$i] ) );
                    }
	    		}
	    	 ?>
        </table>
        <?php echo _render_html($ip_o_attachment); ?>
        <?php echo _render_html($ip_cost); ?>
        </form>
        </div>
    </div>
</div>
          
