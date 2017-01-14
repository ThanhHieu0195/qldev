<?php
require_once '../part/common_start_page.php';
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );
require_once '../libs/PHPExcel/1.8.0/Classes/PHPExcel.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_BAOGIA, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Danh sách khách hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600 !important; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
            
            /* Scroll bar */
            div#detail_dialog_content { max-height: 450px; }
            div#detail_dialog_content { overflow: auto; scrollbar-base-color:#ffeaff; }
        </style>
        
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js" charset="UTF-8"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/fnReloadAjax.js" charset="UTF-8"></script>
                <script>
$(document).ready(function() {
  $("#khocheckall").change(function(){
    if(this.checked){
      $(".cs-khohang").each(function(){
        this.checked=true;
      })              
    }else{
      $(".cs-khohang").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".cs-khohang").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".cs-khohang").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#khocheckall").prop("checked", true); }     
    }
    else {
      $("#khocheckall").prop("checked", false);
    }
  });
  $("#loaicheckall").change(function(){
    if(this.checked){
      $(".cs-maloai").each(function(){
        this.checked=true;
      })
    }else{
      $(".cs-maloai").each(function(){
        this.checked=false;
      })
    }
  });

  $(".cs-maloai").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".cs-maloai").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })
      if(isAllChecked == 0){ $("#loaicheckall").prop("checked", true); }
    }
    else {
      $("#loaicheckall").prop("checked", false);
    }
  });

  $("#maucheckall").change(function(){
    if(this.checked){
      $(".cs-tongmau").each(function(){
        this.checked=true;
      })
    }else{
      $(".cs-tongmau").each(function(){
        this.checked=false;
      })
    }
  });

  $(".cs-tongmau").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".cs-tongmau").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })
      if(isAllChecked == 0){ $("#maucheckall").prop("checked", true); }
    }
    else {
      $("#maucheckall").prop("checked", false);
    }
  });

  $("#hoacheckall").change(function(){
    if(this.checked){
      $(".cs-hoavan").each(function(){
        this.checked=true;
      })
    }else{
      $(".cs-hoavan").each(function(){
        this.checked=false;
      })
    }
  });

  $(".cs-hoavan").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".cs-hoavan").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })
      if(isAllChecked == 0){ $("#hoacheckall").prop("checked", true); }
    }
    else {
      $("#hoacheckall").prop("checked", false);
    }
  });

});
                </script>
    </head>
    <body>
        <div id="body-wrapper">
            <?php
            require_once '../part/menu.php';
            ?>
            <div id="main-content">
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Lập bảng báo giá sản phẩm</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <form id="baogia" action="baogia.php" method="post">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Chọn kho hàng</th>
                                            <th>Dòng sản phẩm</th>
                                            <th>Chiều dài (cm)</th>
                                            <th>Chiều ngang (cm)</th>
                                            <th>Tông màu</th>
                                            <th>Hoa văn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr> <td>
                                            <input type="checkbox" id="khocheckall">Check All<br/>
                                            <?php 
                                            require_once '../models/database.php';
                                            
                                            $db = new database();
                                            $db->setQuery("SELECT makho, tenkho FROM khohang WHERE makho>0 ORDER by tenkho ASC");
                                            $arr = $db->loadAllRow();
                                            if(is_array($arr)):
                                                foreach ($arr as $item):
                                                    echo "<input class='cs-khohang' type='checkbox' name='khohang_group[]' value=\"{$item['makho']}\">{$item['tenkho']}<br/>";
                                                endforeach;
                                            endif;
                                            ?>
                                      </td> <td>
                                            <input type="checkbox" id="loaicheckall">Check All<br/>
                                            <?php
                                            require_once '../models/database.php';

                                            $db = new database();
                                            $db->setQuery("SELECT maloai, tenloai FROM loaitranh WHERE maloai>0 ORDER BY tenloai ASC");
                                            $arr = $db->loadAllRow();
                                            if(is_array($arr)):
                                                foreach ($arr as $item):
                                                    echo "<input class='cs-maloai' type='checkbox' name='maloai_group[]' value=\"{$item['maloai']}\">{$item['tenloai']}<br/>";
                                                endforeach;
                                            endif;
                                            ?>                                        
                                       </td> <td>
                                        Từ:<input id="daimin" name="daimin" style="width:50px;"/> Đến:<input id="daimax" name="daimax" style="width:50px;" /> 
                                       </td> <td>
                                        Từ:<input id="rongmin" name="rongmin" style="width:50px;"/> Đến:<input id="rongmax" name="rongmax" style="width:50px;" />
                                       </td> <td>
                                            <input type="checkbox" id="maucheckall">Check All<br/>
                                            <?php
                                            require_once '../models/database.php';

                                            $db = new database();
                                            $db->setQuery("SELECT distinct(tongmau) FROM tranh WHERE tongmau IS NOT NULL ORDER BY tongmau ASC");
                                            $arr = $db->loadAllRow();
                                            if(is_array($arr)):
                                                foreach ($arr as $item):
                                                    echo "<input class='cs-tongmau' type='checkbox' name='tongmau_group[]'  value=\"{$item['tongmau']}\">{$item['tongmau']}<br/>";
                                                endforeach;
                                            endif;
                                            ?>
                                       </td> <td>
                                            <input type="checkbox" id="hoacheckall">Check All<br/>
                                            <?php
                                            require_once '../models/database.php';

                                            $db = new database();
                                            $db->setQuery("SELECT distinct(hoavan) FROM tranh WHERE hoavan IS NOT NULL ORDER BY hoavan ASC");
                                            $arr = $db->loadAllRow();
                                            if(is_array($arr)):
                                                foreach ($arr as $item):
                                                    echo "<input class='cs-hoavan' type='checkbox' name='hoavan_group[]' value=\"{$item['hoavan']}\">{$item['hoavan']}<br/>";
                                                endforeach;
                                            endif;
                                            ?>
                                       </td> </tr>
                                </table>
                                </div>
                                <div>
                                <button type="submit" name="baogia" value="Lập báo giá"> Lập báo giá </button>
                                </div>
                            </div>
                            </form>
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_POST['baogia'])) {
                    $khohang = $_POST['khohang_group'];
                    $maloai = $_POST['maloai_group'];
                    $tongmau = $_POST['tongmau_group'];
                    $hoavan = $_POST['hoavan_group'];
                    for ($i=0; $i<count($hoavan); $i++) {
                        echo $hoavan[$i]."<br />";
                    }
                    $daimax = $_POST['daimax'];
                    $daimin = $_POST['daimin'];
                    $rongmax = $_POST['rongmax'];
                    $rongmin = $_POST['rongmin'];
                    require_once '../models/database.php';
                    require_once '../models/tranh.php';
                    $tranhdb = new tranh();
                    $query = $tranhdb->danh_sach_san_pham_export_excel($khohang, $tongmau, $hoavan, $maloai, $daimin, $daimax, $rongmin, $rongmax);
try {
    ini_set('memory_limit', '-1');
    // Read the template file
    $inputFileType = 'Excel5';
    $inputFileName = "../uploads/templates/Template_baogia.xls";
    $objReader = PHPExcel_IOFactory::createReader ( $inputFileType );
    $objPHPExcel = $objReader->load ( $inputFileName );

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex ( 0 );
   
    // Get input data
    $tranhdb = new tranh();
    $detail = $tranhdb->danh_sach_san_pham_export_excel($khohang, $tongmau, $hoavan, $maloai, $daimin, $daimax, $rongmin, $rongmax);

    if (is_array ( $detail )) {

        /* General information */
        $generalCol = "E";

        /* Constants in template */
        $startIndx = 10; // Starting row index
        $spacingNum = 1; // Spacing to total (the number of rows which above the total row)

        /* Detail information */
        $count = 0;
        $rowIndx = $startIndx;
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('My Image');
        $objDrawing->setDescription('The Image that I am inserting');
        $objDrawing->setPath('/var/www/html/hethongdev/uploads/templates/logo.jpg');
        $objDrawing->setCoordinates("D1");
        $objDrawing->setResizeProportional(true);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        

        foreach ( $detail as $d ) {
            if ($d ['soluong'] > 0) {
            // Add row data to file
            $objPHPExcel->getActiveSheet ()->setCellValue ( "A{$rowIndx}", ++ $count );
            $objPHPExcel->getActiveSheet ()->setCellValue ( "B{$rowIndx}", $d ['masotranh'] ); // Ma hang
            $objPHPExcel->getActiveSheet ()->setCellValue ( "C{$rowIndx}", $d ['tentranh'] ); // Kich thuoc
            //$objPHPExcel->getActiveSheet ()->setCellValue ( "D{$rowIndx}", $d ['hinhanh'] ); // Ten hang
            // Add picture
            if (file_exists('/var/www/html/hethong/' . $d ['hinhanh'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('My Image');
            $objDrawing->setDescription('The Image that I am inserting');
            $objDrawing->setPath('/var/www/html/hethong/' . $d ['hinhanh']);
            $objDrawing->setCoordinates("D{$rowIndx}");
            $objDrawing->setResizeProportional(true);
            $objDrawing->setHeight(160);
            $offsetX =240 - $objDrawing->getWidth();
            $objDrawing->setOffsetX($offsetX);
            //$objDrawing->setWidtht(160, 160);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            } else {
            $objPHPExcel->getActiveSheet ()->setCellValue ( "D{$rowIndx}", 'Hinh khong ton tai' . $d ['hinhanh'] ); // Ten hang
            }
            $objPHPExcel->getActiveSheet ()->setCellValue ( "E{$rowIndx}", $d ['tongmau'] ); // So luong
            $objPHPExcel->getActiveSheet ()->setCellValue ( "F{$rowIndx}", $d ['hoavan'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "G{$rowIndx}", $d ['dai'] . 'x' .$d ['rong'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "H{$rowIndx}", $d ['donvi'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "I{$rowIndx}", $d ['giaban'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "J{$rowIndx}", $d ['soluong'] ); // Don gia

            if ($count < count ( $detail )) {
                $rowIndx ++;
                // Insert a new row after '$rowIndx' index
                $objPHPExcel->getActiveSheet ()->insertNewRowBefore ( $rowIndx, 1 );
            }
            }
        }

        /* Set cells style */
        $styleArray = array (
                'alignment' => array (
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
        );
        $objPHPExcel->getActiveSheet ()->getStyle ( "B{$startIndx}:D{$rowIndx}" )->applyFromArray ( $styleArray );

        $styleArray = array (
                'alignment' => array (
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
        );
        $objPHPExcel->getActiveSheet ()->getStyle ( "B{$startIndx}:H{$rowIndx}" )->applyFromArray ( $styleArray );

    }

    // Redirect output to a client's web browser (Excel5)
    ob_clean();
    header ( 'Content-Type: application/vnd.ms-excel' );
    header ( "Content-Disposition: attachment;filename='Bang bao gia.xls'" );
    header ( 'Cache-Control: max-age=0' );
    // If you're serving to IE 9, then the following may be needed
    header ( 'Cache-Control: max-age=1' );
    header('Content-Type: text/html; charset=UTF-8');
    header("Content-type: application/octetstream");

    // If you're serving to IE over SSL, then the following may be needed
    header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
    header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
    header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
    header ( 'Pragma: public' ); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
    $objWriter->save ( 'php://output' );
    exit ();
} catch ( Exception $e ) {
    debug ( $e->getMessage () );
}
                }
                ?>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
