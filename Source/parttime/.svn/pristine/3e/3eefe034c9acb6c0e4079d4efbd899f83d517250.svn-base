<?php
require_once '../models/helper.php';
require_once '../models/tranh.php';
require_once '../models/paging.class.php';

// Request parameters
$data_length = (isset($_POST['data_length'])) ? $_POST['data_length'] : '5';
$data_filter = (isset($_POST['data_filter'])) ? $_POST['data_filter'] : '';
$current_page = (isset($_POST['current_page'])) ? $_POST['current_page'] : FALSE;

// Initial pagging data
$tranh = new tranh();
$paging = new paging();
$paging->assign('onclick="getData(\'[:page:]\'); return false;"', $tranh->count($data_filter), $data_length, $current_page );

// Get data from database
$query = $tranh->danh_sach_tim_kiem($data_filter, $paging->sql_limit());
if(is_array($query))
{
    $i = 1;
    foreach ($query as $row)
    {
        $class = ($i % 2 != 0) ? 'odd' : 'even';
        $data .= '<tr class="' . $class . '">' .
                         sprintf('<td class=""><a class="tooltip" src="%s" href="itemdetail.php?item=%s">%s</a></td>',
                                 '../' . $row['hinhanh'], $row['masotranh'], $row['masotranh']) .
                         sprintf('<td class=""><div name="tentranh">%s</div></td>', $row['tentranh']) .
                         sprintf('<td class=""><div name="tenloai">%s</div></td>', $row['tenloai']) .
                         sprintf('<td class=""><span class="price">%s</span></td>', number_2_string($row['giaban'])) .
        				 sprintf('<td style="width: 74px !important;" class="">%s</td>', $tranh->statistic_number($row['masotranh']));
        foreach ($row['tonkho'] as $ton_kho)
        {
            $id = 'Update' . trim($row['masotranh']) . trim($ton_kho['showroom']);
            $data .= sprintf('<td class="number"><label>%s</label><div class="hidden" name="tenkho">%s</div><div class="hidden" name="soluongtonkho">%s</div>',
                                 $ton_kho['soluong'], $ton_kho['tenkho'], $ton_kho['soluong']).
                             '<div class="link">' .
                                sprintf('<a id="%s" title="Sửa" href="javascript:showDialog(\'%s\', \'update\', \'%s\', \'%s\')"><img alt="Edit" height="16px" width="16px" src="../resources/images/icons/pencil.png" /></a>',
                                        $id, $id, $row['masotranh'], $ton_kho['showroom']).
                                sprintf('<a title="Xóa" href="javascript:deleteItem(\'delete\', \'%s\', \'%s\')">',
                                        $row['masotranh'], $ton_kho['showroom']).
                                    '<img alt="Delete" height="16px" width="16px" src="../resources/images/icons/cross.png" /></a>'.
                             '</div></td>';
        }   										        
        $data .= '</tr>';
        $i++;
    }
}

echo $data . '[:nhilong:]' . $paging->fetch();

/* End of file item_list_server.php */
/* Location: ./ajaxserver/item_list_server.php */