<?php
require_once '../part/common_start_page.php';
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Get input data
$type = (isset ( $_GET ['type'] )) ? $_GET ['type'] : "";
$from_date = (isset ( $_GET ['from'] )) ? $_GET ['from'] : "";
$to_date = (isset ( $_GET ['to'] )) ? $_GET ['to'] : "";
// Correct the type
$types_arr = array (
        'updated',
        'contacted' 
);
if (! in_array ( $type, $types_arr )) {
    $type = 'updated';
}
$func = ($type == 'updated') ? F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED : F_GUEST_DEVELOPMENT_STATISTIC_UPDATED;

// Authenticate
do_authenticate ( G_GUEST_DEVELOPMENT, $func, TRUE );

require_once '../models/guest_events.php';
require_once '../models/guest_development_history.php';

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
    
    switch ($type) {
        case "updated":
            $columns = array('A', 'B', 'C', 'D', 'E', 'F');
            $header = array('Họ tên', 'Địa chỉ/Công ty', 'Điện thoại', 'Di động', 'Email', 'Người phụ trách');
            
            $file_name = "Danh-sach-KH-duoc-update";
            
            // Add header data
            for ($i = 0; $i < count($header); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$columns[$i]}1", $header[$i]);
            }
            $objPHPExcel->getActiveSheet()->getStyle("{$columns[0]}1:{$columns[5]}1")->getFont()->setBold(true);
            
            // Get data from database
            $history_model = new guest_development_history();
            $arr = $history_model->statistic_updated ( $from_date, $to_date );
            if (is_array ( $arr ) && count ( $arr ) > 0) {
                // Starting row index
                $index = 2;
                
                foreach ( $arr as $row ) {
                    // Add row data
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue("{$columns[0]}{$index}", $row ['hoten'])
                                ->setCellValue("{$columns[1]}{$index}", $row ['diachi'])
                                //->setCellValue("{$columns[2]}{$index}", "{$row ['dienthoai1']} ")
                               // ->setCellValueExplicit("{$columns[2]}{$index}", $row ['dienthoai1'], PHPExcel_Cell_DataType::TYPE_STRING)
                                //->setCellValue("{$columns[3]}{$index}", "{$row ['dienthoai2']} ")
                                //->setCellValueExplicit("{$columns[3]}{$index}", $row ['dienthoai2'], PHPExcel_Cell_DataType::TYPE_STRING)
                                //->setCellValue("{$columns[4]}{$index}", $row ['email'])
                                ->setCellValue("{$columns[5]}{$index}", $row ['tennv']);
                    
                    $index++;
                }
                
                // Auto adjust column's width
                foreach($columns as $columnID) {
                    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                                ->setAutoSize(true);
                }
            }
            
            break;
            
        case "contacted";
            $columns = array('A', 'B', 'C', 'D', 'E', 'F');
            $header = array('STT', 'Nhân viên', 'Tổng số khách cần liên hệ', 'Số khách hàng đã liên hệ', 'Số khách phát sinh doanh số', 'Doanh số phát sinh');
            
            $file_name = "Danh-sach-so-luong-KH-da-lien-he";
            
            // Add header data
            for ($i = 0; $i < count($header); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$columns[$i]}1", $header[$i]);
            }
            $tmp = count($header) - 1;
            $objPHPExcel->getActiveSheet()->getStyle("{$columns[0]}1:{$columns[$tmp]}1")->getFont()->setBold(true);
            
            // DB models
            $events_model = new guest_events();
            
            // Get data from database
            $history_model = new guest_development_history();
            $arr = $history_model->statistic_contacted ( $from_date, $to_date );
            if (is_array ( $arr ) && count ( $arr ) > 0) {
                // Starting row index
                $index = 2;
                $i = 1; // Index of item
            
                foreach ( $arr as $key => $row ) {
                    $total_amount = $events_model->count_need_contacting($key, $from_date, $to_date);
                    
                    // Add row data
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValueExplicit("{$columns[0]}{$index}", $i, PHPExcel_Cell_DataType::TYPE_NUMERIC)
                                ->setCellValueExplicit("{$columns[1]}{$index}", $row ['employee_name'], PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValueExplicit("{$columns[2]}{$index}", $total_amount, PHPExcel_Cell_DataType::TYPE_NUMERIC)
                                ->setCellValueExplicit("{$columns[3]}{$index}", count( $row ['guests'] ), PHPExcel_Cell_DataType::TYPE_NUMERIC)
                                ->setCellValueExplicit("{$columns[4]}{$index}", $row ['payment_amount'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
                                ->setCellValueExplicit("{$columns[5]}{$index}", $row ['payment_money'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            
                    $index++;
                    $i++;
                }
            }
            
            // Auto adjust column's width
            foreach($columns as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            }
            
            break;
    }
    
    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Export');
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    
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
