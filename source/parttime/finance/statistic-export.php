<?php
require_once '../part/common_start_page.php';
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Get input data
$from_date = (isset ( $_GET ['from'] )) ? $_GET ['from'] : "";
$to_date = (isset ( $_GET ['to'] )) ? $_GET ['to'] : "";

// Authenticate
do_authenticate ( G_FINANCE, F_FINANCE_STATISTIC, TRUE );

require_once '../models/finance_token.php';
require_once '../models/finance_token_detail.php';

/**
 * Include PHPExcel
 */
require_once '../libs/PHPExcel/1.8.0/Classes/PHPExcel.php';

try {
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
    
    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Nhi Long")
                                ->setLastModifiedBy("Nhi Long")
                                ->setTitle("Office 2003 Exported Document")
                                ->setSubject("Office 2003 Exported Document")
                                ->setDescription("Office 2003 document generated from system.")
                                ->setKeywords("office 2003 openxml php")
                                ->setCategory("Result file");
    
    // Set the file name
    $file_name = "Export";
    
    /* Processing */
    $columns = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
    $header = array('Số tham chiếu', 'Sản phẩm', 'Loại chi phí', 'Loại chi phí chi tiết', 'Người thu/chi', 'Số tiền', 'Ghi chú', 'Ngày thu/chi', 'Loại');
    
    $file_name = "Thong-ke-thu-chi";
    
    // Add header data
    for ($i = 0; $i < count($header); $i++) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$columns[$i]}1", $header[$i]);
    }
    $tmp = count($columns) - 1;
    $objPHPExcel->getActiveSheet()->getStyle("{$columns[0]}1:{$columns[$tmp]}1")->getFont()->setBold(true);
    
    // Get data from database
    $detail_model = new finance_token_detail ();
    $arr = $detail_model->statistic ( $from_date, $to_date );
    if (is_array ( $arr ) && count ( $arr ) > 0) {
        // Starting row index
        $index = 2;
    
        foreach ( $arr as $row ) {
            // Add row data
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("{$columns[0]}{$index}", $row ['reference'])
                        ->setCellValue("{$columns[1]}{$index}", $row ['product'])
                        ->setCellValue("{$columns[2]}{$index}", $row ['category'])
                        ->setCellValue("{$columns[3]}{$index}", $row ['item'])
                        ->setCellValue("{$columns[4]}{$index}", $row ['performer'])
                        ->setCellValueExplicit("{$columns[5]}{$index}", number_format($row ['money_amount'], 0, ",", ""), PHPExcel_Cell_DataType::TYPE_NUMERIC)
                        ->setCellValueExplicit("{$columns[6]}{$index}", $row ['note'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit("{$columns[7]}{$index}", dbtime_2_systime($row ['perform_date'], 'd/m/Y'), PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue("{$columns[8]}{$index}", finance_token::$financeTokenTypeArr[$row ['token_type']]['text']);
    
            $index++;
        }
    }
    // Auto adjust column's width
    foreach($columns as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
    }
    
    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Export');
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    ob_end_clean();
    ob_start();
    
    // Redirect output to a client's web browser (Excel5)
    header ( 'Content-Type: application/vnd.ms-excel' );
    header ( "Content-Disposition: attachment;filename='{$file_name}.xls'" );
    header ( 'Cache-Control: max-age=0' );
    // If you're serving to IE 9, then the following may be needed
    header ( 'Cache-Control: max-age=1' );
    
    // If you're serving to IE over SSL, then the following may be needed
    header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
    header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
    header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
    header ( 'Pragma: public' ); // HTTP/1.0
    
    $objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
    $objWriter->save ( 'php://output' );
    exit ();
} catch ( Exception $e ) {
    debug ( $e->getMessage() );
}
