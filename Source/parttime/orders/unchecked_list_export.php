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
do_authenticate(G_ORDERS, F_ORDERS_UNCHECKED_LIST, TRUE);

require_once '../models/database.php';

/**
 * Include PHPExcel
 */
require_once '../libs/PHPExcel/1.8.0/Classes/PHPExcel.php';

// Get data to export
function getExportedData() {
    $db = new database();
    $trangthai = 1; // Da giao
    $approved = 1; // Da approve
    $sql = "SELECT donhang.madon, khach.hoten, nhomkhach.tennhom, 
                   donhang.ngaydat, donhang.ngaygiao, donhang.thanhtien, 
                   khach.dienthoai1, khach.dienthoai2
            FROM donhang INNER JOIN khach ON donhang.makhach = khach.makhach 
                       INNER JOIN nhomkhach ON khach.manhom = nhomkhach.manhom
            WHERE (trangthai = '{$trangthai}') AND (checked = '0') AND (approved = '{$approved}')
            ORDER BY donhang.ngaygiao ASC ";

    $db->setQuery($sql);
    $arr = $db->loadAllRow();
    $db->disconnect();

    //debug($arr); exit();

    return $arr;
}

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
    $columns = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
    $header = array('Mã hóa đơn', 'Khách hàng', 'Nhóm khách', 'Điện thoại 1', 'Điện thoại 2', 'Ngày đặt', 'Ngày giao', 'Thành tiền');
    
    $file_name = "Don-hang-cho-kiem-tra";
    
    // Add header data
    for ($i = 0; $i < count($header); $i++) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$columns[$i]}1", $header[$i]);
    }
    $tmp = count($columns) - 1;
    $objPHPExcel->getActiveSheet()->getStyle("{$columns[0]}1:{$columns[$tmp]}1")->getFont()->setBold(true);
    
    // Get data from database
    $arr = getExportedData();
    if (is_array ( $arr ) && count ( $arr ) > 0) {
        // Starting row index
        $index = 2;
    
        foreach ( $arr as $row ) {
            // Add row data
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValueExplicit("{$columns[0]}{$index}", $row ['madon'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue("{$columns[1]}{$index}", $row ['hoten'])
                        ->setCellValue("{$columns[2]}{$index}", $row ['nhomkhach'])
                        ->setCellValueExplicit("{$columns[3]}{$index}", $row ['dienthoai1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit("{$columns[4]}{$index}", $row ['dienthoai2'], PHPExcel_Cell_DataType::TYPE_STRING)                        
                        ->setCellValueExplicit("{$columns[5]}{$index}", dbtime_2_systime($row ['ngaydat'], 'd/m/Y'), PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit("{$columns[6]}{$index}", dbtime_2_systime($row ['ngaygiao'], 'd/m/Y'), PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit("{$columns[7]}{$index}", number_format($row ['thanhtien'], 0, ",", ""), PHPExcel_Cell_DataType::TYPE_NUMERIC);
    
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