<?php
    require_once "../config/constants.php";
    require_once "../models/helper.php";
    require_once "../models/account_helper.php";
    if ( !function_exists('uploadFile') ) {
        function uploadFile($file, $file_name='', $target_filepath='') {
            $result = array(
                'result'   => 0,                // Error status
                'message'  => 'Upload failed.', // Message
                'location' => ''
            );

            if ( empty($file) ) {
                return $result;
            }

            if ( empty($file_name) ) {
                $id_random = create_uid(false);
                $manv = current_account();
                $file_name = sprintf('%s_%s_%s', $manv, $id_random, basename($file['name']) );
            }

            if ( empty($target_filepath) ) {
                $target_filepath = DIR_UPLOAD_DEFAULT;
            }
            $target_filepath = $target_filepath."/".$file_name;


            if($file['error'] > 0)
            {
                $result['message'] = 'Chưa chọn file thích hợp';
            }
            else
            {
                if(move_uploaded_file($file['tmp_name'], $target_filepath))
                {
                    $result['result'] = TRUE;
                    $result['message'] = 'Upload file successfull.';
                    $result['location'] = $target_filepath;
                }
                else
                {
                    $result['message'] = 'Không thực hiện save file ' . $target_filepath . ' được.';
                }
            }
            return $result;
        }
    }

    if ( !function_exists('loadDatafromExcel') ) {
        function loadDatafromExcel($target_filepath, $total_row) {
            require_once '../phpexcel/ExcelReader/excel_reader2.php';
            $result = array( 'result' => 0, 'message' => '', 'data' => array() );
            $data = new Spreadsheet_Excel_Reader($target_filepath, false, 'UTF-8');
            if(is_object($data) && $data->rowcount() >= 2)
            {
                try
                {
                    $result['result'] = 1;
                    $data_result = array();
                    for($row = 2; $row <= $data->rowcount(); $row++)
                    {
                        $data_row = array();
                        for ($i=1; $i <= $total_row; $i++) {
                            $data_row[] = $data->val($row, $i);
                        }
                        $data_result[] = $data_row;
                    }
                    $result['data'] = $data_result;

                }
                catch(Exception $e)
                {
                    $result['message'] = $e->getMessage();
                    unlink($target_filepath);
                }
            }
            else
            {
                $result['message'] = 'File data không hợp lệ.';
                unlink($target_filepath);
            }
            return $result;
        }
    }
