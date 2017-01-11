<?php
require_once '../part/common_start_page.php';
require_once '../models/donhang.php';

$output = array (
        "result" => 'error',
        "message" => 'Thực hiện thao tác thất bại',
        "items" => array(),
        "summary" => array () 
);

if (verify_access_right ( current_account (), F_ORDERS_CASH_STATISTIC )) {
    $from = $_REQUEST ['from'];
    $to = $_REQUEST ['to'];
    
    $donhang = new donhang ();
    $data = $donhang->cash_statistic ( $from, $to );
    
    if (is_array($data) && count($data) > 0)
    {
        $output['result'] = 'success';
        $output['message'] = sprintf("Found %d items", count($data) - 1);
        //debug($data);
        $items = array();
        for ($i = 0; $i < count($data) - 1; $i++)
        {
            $row = $data[$i];
            //debug($row);
            $items[] = array(
                                'ngay'           => dbtime_2_systime($row['ngay']), 
                                'ngay_fmt'       => dbtime_2_systime($row['ngay'], 'd/m/Y'), 
                                'tien_coc'       => number_2_string($row['tien_coc'], '.'), 
                                'tien_giao_hang' => number_2_string($row['tien_giao_hang'], '.'), 
                                'tien_khac'      => number_2_string($row['tien_khac'], '.'), 
                                'tong'           => number_2_string($row['tong'], '.')
                            );
        }
        //debug($items);
        $output['items'] = $items;

        $row = $data[count($data) - 1];
        $output['summary'] = array(
                                'ngay'           => 'Tổng cộng', 
                                'ngay_fmt'       => dbtime_2_systime($row['ngay'], 'd/m/Y'), 
                                'tien_coc'       => number_2_string($row['tien_coc'], '.'), 
                                'tien_giao_hang' => number_2_string($row['tien_giao_hang'], '.'), 
                                'tien_khac'      => number_2_string($row['tien_khac'], '.'), 
                                'tong'           => number_2_string($row['tong'], '.')
                            );
    }
    else
    {
        $output['message'] = "Không tìm thấy dữ liệu";
    }
}

echo json_encode ( $output );

require_once '../part/common_end_page.php';

/* End of file cash_statistic_server.php */
/* Location: ./ajaxserver/cash_statistic_server.php */