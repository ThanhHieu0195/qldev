<?php
require_once '../part/common_start_page.php';
require_once '../models/guestupload.php';
require_once '../models/nhanvien.php';
require_once '../models/khach.php';


$result = array(
        'result'   => 0,                // Error status
        'message'  => 'Upload failed.', // Message
        'detail'   => '',               // Detail message
        'progress' => ''                // Progress status (success/total)
    );

if (verify_access_right ( current_account (), F_GUEST_UPLOAD ))
{
    $kiemtraten = $_POST['ktten'];
    $manv = current_account();
    $file_name = sprintf('%s_%s', $manv, basename($_FILES['upload_scn']['name']));
    $target_filepath = sprintf("../%s/%s", EXCEL_FOLDER, $file_name);
    $guestupload = FALSE;
    
    // Upload file
    if($_FILES['upload_scn']['error'] > 0)
    {
        $result['message'] = 'Chưa chọn file Excel thích hợp';
    }
    else
    {
        if(move_uploaded_file($_FILES['upload_scn']['tmp_name'], $target_filepath))
        {
            $guestupload = TRUE;
            $result['message'] = 'Upload file successfull. File name = ' . $target_filepath;
        }
        else
        {
            $result['message'] = 'Không thực hiện save file ' . $target_filepath . ' được.';
        }
    }
    if($guestupload)
    {
        require_once '../phpexcel/ExcelReader/excel_reader2.php';
        // Get data from file and insert into database
        $data = new Spreadsheet_Excel_Reader($target_filepath, true, 'UTF-8');
        if(is_object($data) && $data->rowcount() >= 2)
        {
            // Them data vao table 'upload'
            $guestupload = new guestupload();
            $guestupload_id = create_uid();
            // Success status
            $result['result'] = 1;
            
            // Them data vao table 'upload_detail'
            $total = 0;  // dem so san pham trong file
            $success = 0; // so san pham them thanh cong
            $detail_message = '';
            $detail_format = ":br• Khách :boldopen :openspan class='price':close %s:closespan :close:boldclose: %s - hàng thứ: %s";
            
            for($row = 2; $row <= $data->rowcount(); $row++)
            {
                $no     = $data->val($row, 1);
                $hoten      = $data->val($row, 2);                            
                $dienthoai1  = preg_replace('/\s+/', '',$data->val($row, 3));                            
                $dienthoai2  = preg_replace('/\s+/', '',$data->val($row, 4));
                $dienthoai3  = preg_replace('/\s+/', '',$data->val($row, 5));
                $email      = $data->val($row, 6);                            
                $diachi     = $data->val($row, 7);                            
                $chiendich  = $data->val($row, 8);
                $tiemnang  = $data->val($row, 9);
                $nhomkhach  = $data->val($row, 10);
                $nhanvien   = $data->val($row, 11);                            
                $ghichu     = $data->val($row, 12);                           
                $continue   = TRUE;
                $dienthoai = array($dienthoai1, $dienthoai2, $dienthoai3);
                $khach_model = new khach();
                foreach ($dienthoai as $dt) {
                    if (strlen($dt)>7) {
                        if (! preg_match("/^[0-9]{7,11}$/", $dt)) {
                            $continue = FALSE;
                            $detail_message .= sprintf($detail_format, $hoten, "So dien thoai ". $dt ." khong hop le", $no);
                            break;
                        } 
                        if ($khach_model->get_makhach($dt)) {
                            $continue = FALSE;
                            $detail_message .= sprintf($detail_format, $hoten, "So dien thoai ". $dt ." da co trong hethong", $no);
                            break;
                        }
                    }
                }

                if (($continue) && (isset($email)) && (strlen($email)>2) && ($khach_model->get_makhachemail($email))) {
                    $continue = FALSE;
                    $detail_message .= sprintf($detail_format, $hoten, "Dia chi email ". $email ." da co trong hethong", $no);
                    break;
                }

                if (($continue) && ($kiemtraten==1)) {
                    $hotenkhach = $khach_model->get_hotenkhach($hoten);
                    if ($hotenkhach) {
                        $detail_message .= sprintf($detail_format, $hoten, "Khach hang trung ten '" . $hotenkhach . "'", $no);
                        $continue = FALSE;
                    }
                }

                // Vadilate san pham
                $makhach=NULL;
                if ($continue) {
                    $nhanvien_model = new nhanvien();
                    if (! $nhanvien_model->thong_tin_nhan_vien($nhanvien)) {
                        $continue = FALSE;
                        $detail_message .= sprintf($detail_format, $hoten, "Ma nhan vien ". $nhanvien ." khong ton tai", $no);
                    }
                    if (! $guestupload->validate_nhomkhach($nhomkhach)) {
                        $continue = FALSE;
                        $detail_message .= sprintf($detail_format, $hoten, "Nhom khach ". $nhomkhach ." khong ton tai", $no);
                    } 
                }
                if ($continue) {
                    $objup = $guestupload->add_new_guest($hoten, $dienthoai, $email, $diachi, $nhomkhach, $tiemnang);
                    if($objup) {
                        foreach ($dienthoai as $dt) {
                            if (strlen($dt)>6) {
                                $makhach = $khach_model->get_makhach($dt);
                                if ($makhach) {
                                    break;
                                }
                            }
                        }
                        if (($makhach) && ($continue)) {
                            if ($guestupload->add_new_guest_marketing($nhanvien, $makhach, $chiendich, 0, $ghichu)) {
                                $success++;
                            }
                            else {
                                $detail_message .= sprintf($detail_format, $hoten, "Loi cap nhat them khach", $no);
                            }
                        } else {
                            $detail_message .= sprintf($detail_format, $hoten, "Dien thoai khong dung dinh dang", $no);
                        }
                    } else {
                            $detail_message .= sprintf($detail_format, $hoten, $guestupload->getMessage());
                    }
                }
            }
            // Detail message
            if($detail_message != '')
                $result['detail'] = 'Không thể thêm khách: ' . $detail_message;
            // Thong bao progress status
            $result['progress'] = sprintf('Thực hiện upload thành công %d/%d khách.', $success, $total);
            // Delete upload when there are no product in detail
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
