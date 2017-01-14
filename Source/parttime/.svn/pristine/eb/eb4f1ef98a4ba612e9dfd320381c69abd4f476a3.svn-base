<?php
require_once '../part/common_start_page.php';
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once '../libs/PHPExcel/1.8.0/Classes/PHPExcel.php';

// Create new PHPExcel object
// $data = array("keys"=>array, values);
function export_excel($file_name, $header, $keys, $arr) {
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Nhi Long")
                                ->setLastModifiedBy("Nhi Long")
                                ->setTitle("Office 2003 Exported Document")
                                ->setSubject("Office 2003 Exported Document")
                                ->setDescription("Office 2003 document generated from system.")
                                ->setKeywords("office 2003 openxml php")
                                ->setCategory("Result file");

    try {
        
        $default_columns = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
        $columns = array();
        for ($i=0; $i < count($header) ; $i++) { 
            # code...
            $columns[] = $default_columns[$i];
        }
        
        // Add header data
        for ($i = 0; $i < count($header); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$columns[$i]}1", $header[$i]);
        }

        $tmp = count($columns) - 1;
        $objPHPExcel->getActiveSheet()->getStyle("{$columns[0]}1:{$columns[$tmp]}1")->getFont()->setBold(true);
        
        // Get data from database
        //     // Starting row index
        $index = 2;
        
        foreach ( $arr as $row) {
            // Add row data
            $obj = $objPHPExcel->setActiveSheetIndex(0);
            for ($i=0; $i < count($keys); $i++) { 
                $key = $keys[$i];;
                $obj->setCellValue("{$columns[$i]}{$index}", $row[$key]);
            }
            $index++;
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
        header ( "Content-Disposition: attachment;filename={$file_name}.xls" );
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
}

