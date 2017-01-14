<?php
require_once '../part/common_start_page.php';
require_once '../models/helper.php';

$result = array(
        'result'   => 0,                // Error status
        'message'  => 'Upload failed.', // Message
        'detail'   => '',               // Detail message
        'progress' => ''                // Progress status (success/total)
    );

if (verify_access_right ( current_account (), F_IMPORT_RED_BILL ))
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
        require_once '../models/hoadondo.php';
        // Get data from file and insert into database
        $data = new Spreadsheet_Excel_Reader($target_filepath, true, 'UTF-8');
        $result['total'] = $data->rowcount();
        $detail_format = ":br• Mã hóa đơn: :boldopen :openspan class='price':close %s :closespan :close:boldclose - ngày xuất: %s giá trị: %s - %s";

        if(is_object($data) && $data->rowcount(0) >= 2) {
            $result['result'] = 1;
            $rb = new RedBill();   
            for ($i=2; $i <= $data->rowcount(); $i++) { 
                $id = create_uid();
                $madon = $data->val($i,1);
                $ngayxuat = $data->val($i,2);
                $giatri = $data->val($i,3);
                $kq = "thêm thất bại";

                $res = $rb->insert($id, $madon, $ngayxuat, $giatri);
                if ($res) {
                  $kq = "thêm thành công";
                }
                $result['detail'] .= sprintf($detail_format, $madon, $ngayxuat, $giatri, $kq);
            }
            $result['progress'] = "Thêm dữ liệu thành công";
        }
        
    } else {
            $result['progress'] = "Lỗi khi thêm dữ liệu";
    }
}

echo json_encode($result);

require_once '../part/common_end_page.php';
?>
