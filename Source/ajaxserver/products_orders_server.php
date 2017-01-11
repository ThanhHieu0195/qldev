<?php
require_once '../part/common_start_page.php';
require_once '../models/chitietdonhang.php';

$output = array(
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => array()
    );

if (verify_access_right(current_account(), F_VIEW_SALE))
{
    $masotranh = $_REQUEST['masotranh'];
    $status = chitietdonhang::$CHO_GIAO;
    
    $db = new database();
    $sql = "SELECT c.madon, SUM(c.soluong) AS soluong, d.ngaygiao, k.hoten
            FROM chitietdonhang c INNER JOIN donhang d ON c.madon = d.madon 
                      INNER JOIN khach k ON d.makhach = k.makhach
            WHERE c.masotranh = '{$masotranh}' AND c.trangthai = {$status}
            GROUP BY c.madon
            ORDER BY d.ngaygiao";
    $db->setQuery($sql);
    $result = $db->loadAllRow();
    $db->disconnect();
    
    if(is_array($result))
    {
        $data = array();
        foreach($result as $row)
        {
            $item = array();
            $item[] = $row['madon'];
            $item[] = $row['soluong'];
            $item[] = $row['ngaygiao'];
            $item[] = $row['hoten'];
            
            $data[] = $item;
        }
        
        $output['iTotalRecords'] = count($data);
        $output['iTotalDisplayRecords'] = count($data);
        $output['aaData'] = $data;
    }
}

echo json_encode($output);

require_once '../part/common_end_page.php';

/* End of file products_orders_server.php */
/* Location: ./ajaxserver/products_orders_server.php */