<?php
require_once '../part/common_start_page.php';
require_once '../models/upload.php';

$result = array(
        'result'   => 0,                // Error status
        'message'  => 'Upload failed.', // Message
        'detail'   => '',               // Detail message
        'progress' => ''                // Progress status (success/total)
    );

if (verify_access_right ( current_account (), F_ITEMS_AUTO_UPLOAD ))
{
    $manv = current_account();
    $file_name = sprintf('%s_%s', $manv, basename($_FILES['upload_scn']['name']));
    $target_filepath = sprintf("../%s/%s", EXCEL_FOLDER, $file_name);
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
        // Get data from file and insert into database
        $data = new Spreadsheet_Excel_Reader($target_filepath, false, 'UTF-8');
        if(is_object($data) && $data->rowcount() >= 2)
        {
            try
            {
                // Them data vao table 'upload'
                $upload = new upload();
                $upload_id = create_uid();
                if($upload->add_new_upload($upload_id, $manv, $file_name))
                {
                    // Success status
                    $result['result'] = 1;
                    
                    // Them data vao table 'upload_detail'
                    $total = 0;  // dem so san pham trong file
                    $success = 0; // so san pham them thanh cong
                    $detail_message = '';
                    $detail_format = ":br• Sản phẩm :boldopen :openspan class='price':close %s:closespan :close:boldclose: %s";
                    
                    for($row = 2; $row <= $data->rowcount(); $row++)
                    {
                        $masotranh = $data->val($row, 1);                            // ma so san pham
                        $tentranh  = $data->val($row, 2);                            // ten tranh
                        $maloai    = $data->val($row, 3);                            // ma loai
                        $cao       = $data->val($row, 4);                            // cao
                        $dai       = $data->val($row, 5);                            // chieu dai
                        $rong      = $data->val($row, 6);                            // chieu rong
                        $giavon    = $data->val($row, 7);                            // gia ban
                        $giaban    = $data->val($row, 8);                            // gia ban
                        $matho     = $data->val($row, 9);                            // ma tho san pham
                        $ghichu    = $data->val($row, 10);                            // ghi chu
                        $hinhanh   = sprintf('%s/%s', IMAGE_FOLDER, $data->val($row, 11));  // hinh anh
                        $tongmau   = $data->val($row, 12);                            // ma kho
                        $hoavan    = $data->val($row, 13);                           // so luong
                        $makho     = $data->val($row, 14);                            // ma kho
                        $soluong   = $data->val($row, 15);                           // so luong
                        $loai      = $data->val($row, 16);                           // so luong
                        // Change format number
                        $giaban = str_replace(',', '', $giaban);
                        $giaban = str_replace('.', '', $giaban);
                        $giavon = str_replace(',', '', $giaban);
                        $giavon = str_replace('.', '', $giaban);
                        
                        if($masotranh != '')
                        {
                            $total++;  // tong san pham
                            // Vadilate san pham
                            $obj = upload::validate_item($masotranh, $giaban, $soluong);
                            if($obj->result)
                            {
                                if($upload->add_new_upload_detail($masotranh, $upload_id, $tentranh, $maloai, $cao, $dai, 
                                       $rong, $giavon, $giaban, $matho, $ghichu, $hinhanh, $tongmau, $hoavan, $makho, $soluong, $loai))
                                {
                                    $success++; // so san pham them thanh cong
                                }
                                else
                                {
                                    $detail_message .= sprintf($detail_format, $masotranh, $upload->getMessage());
                                }
                            }
                            else
                            {
                                $detail_message .= sprintf($detail_format, $masotranh, $obj->message);
                            }
                        }
                    }
                    
                    // Detail message
                    if($detail_message != '')
                        $result['detail'] = 'Các sản phẩm bị lỗi bao gồm:' . $detail_message;
                    // Thong bao progress status
                    $result['progress'] = sprintf('Thực hiện upload thành công %d/%d sản phẩm.', $success, $total);
                    // Delete upload when there are no product in detail
                    if($success == 0)
                    {
                        $upload->delete_upload($upload_id);
                        // Delete the file
                        unlink($target_filepath);
                    }
                }
                else
                {
                    $result['message'] = $upload->getMessage();
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
