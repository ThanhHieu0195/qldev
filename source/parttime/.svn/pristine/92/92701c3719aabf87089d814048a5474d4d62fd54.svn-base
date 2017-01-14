 <div class="informations">
     <?php 
   		$label_main = array( "Mã số tranh: ".$data['masotranh'], "Tên tranh: ".$data['tentranh'], "Mã loại: ".$data['maloai'], "Dài: ".$data['dai'], "Cao: ".$data['cao'], "Màu sắc: ".$data['mausac'], $data['hinhanh'] );

        $fm = '<span>%s</span>';
        $length = count($label_main);
        for ($i=0; $i < $length-1; $i++) { 
            echo sprintf( $fm, $label_main[$i] ).NONE_SPACE;
        }
        echo sprintf( '<span><a target="blank" href="../%s">Xem ảnh</a></span>', $label_main[$length-1] );
      ?>
 </div>