<?php
require_once '../part/common_start_page.php';
require_once '../models/equipment.php';

$result = array(
        'result'   => 0,                // Error status
        'message'  => 'Upload failed.', // Message
        'detail'   => '',               // Detail message
        'progress' => ''                // Progress status (success/total)
    );

if (verify_access_right ( current_account (), F_EQUIPMENT_IMPORT_EXCEL ))
{
    $manv = current_account();
    $file_name = sprintf('%s_%s', $manv, basename($_FILES['upload_scn']['name']));
    $target_filepath = sprintf("../%s/%s", UPLOAD_EQUIQMENT_FOLDER, $file_name);
    $upload = FALSE;
    
    // Upload file
    if($_FILES['upload_scn']['error'] > 0)
    {
        $result['message'] = 'Chưa chọn file Excel thích hợp';
    }
    else
    {
        if(move_uploaded_file($_FILES['upload_scn']['tmp_name'], $target_filepath))
        {
            $upload = TRUE;
            $result['message'] = 'Upload file successfull. File name = ' . $target_filepath;
        }
        else
        {
            $result['message'] = 'Không thực hiện save file ' . $target_filepath . ' được.';
        }
    }
    if($upload)
    {
        require_once '../phpexcel/ExcelReader/excel_reader2.php';
        
        // Index of 'Full_Import' sheet.
        $sheet = 4;
        
        // Get data from file and insert into database
        $data = new Spreadsheet_Excel_Reader($target_filepath, false, 'UTF-8');
        if(is_object($data) && $data->rowcount($sheet) >= 2)
        {
            try
            {
                // Them data vao table 'equipment'
                $model = new equipment();
                
                // Success status
                $result['result'] = 1;
                    
                $total = 0;  // dem so item trong file
                $success = 0; // so item them thanh cong
                $detail_message = '';
                $detail_format = ":br• Dụng cụ :boldopen :openspan class='price':close %s:closespan :openspan class='price':close (Row: %s):closespan :close:boldclose: %s";
                    
                for($row = 2; $row <= $data->rowcount(); $row++)
                {
                    $item = new equipment_entity();
                    $item->equipment_id = $data->val($row, 1, $sheet);                 // ma dung cu
                    $item->name         = $data->val($row, 2, $sheet);                 // ten dung cu
                    $item->status       = $data->val($row, 3, $sheet);                 // trang thai
                    $item->stored_in    = $data->val($row, 4, $sheet);                 // noi de (kho hang/chi nhanh)
                    $item->assign_to    = $data->val($row, 5, $sheet);                 // nguoi chiu trach nhiem
                    $item->assign_date  = $data->val($row, 6, $sheet);                 // ngay ban giao
                    
                    // Truong hop ton tai item de them
                    if($item->equipment_id != '')
                    {
                        // Tong so item
                        $total++;

                        // Vadilate item
                        $obj = equipment::validate_item($item);
                        if($obj->result)
                        {
                            if($model->insert($item))
                            {
                                $success++; // so item them thanh cong
                            }
                            else
                            {
                                $detail_message .= sprintf($detail_format, $item->equipment_id, $row, $model->getMessage());
                                //$detail_message .= sprintf($detail_format, $row, $model->getMessage());
                            }
                        }
                        else
                        {
                            $detail_message .= sprintf($detail_format, $item->equipment_id, $row, $obj->message);
                            //$detail_message .= sprintf($detail_format, $row, $obj->message);
                        }
                    }
                }
                    
                // Detail message
                if($detail_message != '')
                    $result['detail'] = 'Các dụng cụ bị lỗi bao gồm:' . $detail_message;
                // Thong bao progress status
                $result['progress'] = sprintf('Thực hiện upload thành công %d/%d dụng cụ.', $success, $total);
                
                // Delete upload when there are no product in detail
                if($success == 0)
                {
                    // Delete the file
                    unlink($target_filepath);
                }
            }
            catch(Exception $e)
            {
                $result['message'] = $e->getMessage();
                // Delete the file
                unlink($target_filepath);
            }
        }
        else
        {
            $result['message'] = 'File data không hợp lệ.';
            // Delete the file
            unlink($target_filepath);
        }
    }
}

echo json_encode($result);

require_once '../part/common_end_page.php';
?>