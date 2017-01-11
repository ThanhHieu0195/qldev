<?php
require_once '../part/common_start_page.php';
require_once '../models/upload.php';

$output = array();

if(verify_access_right(current_account(), F_ITEMS_UPLOAD))
{
    $item = $_REQUEST['item'];
    
    $upload = new upload();
    $output['result'] = ($upload->delete_upload_detail($item)) ? 1 : 0;
    $output['message'] = 'Thực hiện xóa item upload';
}
else
{
    $output['message'] = 'Không có quyền xóa item upload';
    $output['result'] = 0;
}

echo json_encode($output);

require_once '../part/common_end_page.php';

/* End of file upload_detail_server.php */
/* Location: ./ajaxserver/upload_detail_server.php */