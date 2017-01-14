<?php

require_once 'database.php';
require_once 'helper.php';

class import_export_history extends database {

    public static $TYPE_IMPORT = 1;
    public static $TYPE_EXPORT  = 0;
    
    public static $STATUS_DISABLE = 0;
    public static $STATUS_ENABLE  = 1;
    
    public static $MSG_SELL       = 'Xuất bán cho hóa đơn.';
    public static $MSG_DELIVERY   = 'Giao hàng theo hóa đơn.';
    public static $MSG_ADD_ITEM   = 'Nhập hàng vào kho.';
    public static $MSG_ADD_EXCEL  = 'Nhập hàng vào kho (từ file Excel).';
    
    public static $MSG_SWAP_ITEMS = "Chuyển hàng đến showroom: %s (Phiếu chuyển: %s)";
    public static $MSG_DELIVERY_SWAPPING_ITEM = "Nhận hàng chuyển đến từ showroom: %s (Phiếu chuyển: %s)";
    public static $MSG_SWAP_ITEMS_TMP = "Đang chuyển: Chuyển hàng đến showroom: %s (Phiếu chuyển: %s)";
    public static $MSG_DELIVERY_SWAPPING_ITEM_TMP = "Đang chuyển: Nhận hàng chuyển đến từ showroom: %s (Phiếu chuyển: %s)";
    
    public static $MSG_AMOUNT_MANAGEMENT_DELETE = "Xóa %d/%d sản phẩm trong kho hàng";
    
    // Get enable status
    function _get_enable_status($enable)
    {
        $enable = ($enable == FALSE) ? import_export_history::$STATUS_DISABLE : import_export_history::$STATUS_ENABLE;
        
        return $enable;
    }

    // Them mot lich su nhap/xuat vao trong database
    function add_new($doer, $product_id, $store_id, $amount, $bill_code, $type, $content, $enable = FALSE)
    {
        $enable = $this->_get_enable_status($enable);
        
        if($bill_code != NULL)
        {
            $sql = "INSERT INTO import_export_history(id, datetime, doer, product_id, store_id, amount, bill_code, type, content, enable)
                    VALUES('%s', CURRENT_TIMESTAMP(), '%s', '%s', %d, %d, '%s', %d, '%s', %d)";
            $sql = sprintf($sql, uniqid('', true), $doer, $product_id, $store_id, $amount, $bill_code, $type, $content, $enable);
        }
        else
        {
            $sql = "INSERT INTO import_export_history(id, datetime, doer, product_id, store_id, amount, type, content, enable)
                    VALUES('%s', CURRENT_TIMESTAMP(), '%s', '%s', %d, %d, %d, '%s', %d)";
            $sql = sprintf($sql, uniqid('', true), $doer, $product_id, $store_id, $amount, $type, $content, $enable);
        }
        
        //echo $sql;
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Set enable status
    function set_enable($enable = FALSE, $bill_code = NULL)
    {
        $enable = $this->_get_enable_status($enable);
        
        $where_condition = "";
        if($bill_code != NULL)
            $where_condition = sprintf("WHERE bill_code = '%s'", $bill_code);
        
        $sql = "UPDATE import_export_history SET enable = %d $where_condition";
        $sql = sprintf($sql, $enable);
    
        //echo $sql;
    
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Thong ke lich su nhap/xuat hang
    function history_list($from, $to, $showroom = -1, $export = FALSE, &$field_list = NULL, &$column_name = NULL)
    {     
        $status = import_export_history::$STATUS_ENABLE;
        $sql = "SELECT i.datetime, n.hoten, i.product_id, t.tentranh, k.tenkho, i.amount, i.bill_code, i.type, i.content
                FROM   import_export_history i
                           INNER JOIN nhanvien n ON i.doer = n.manv
                           INNER JOIN tranh t ON i.product_id = t.masotranh
                           INNER JOIN khohang k ON i.store_id = k.makho
                WHERE (i.enable = $status) AND (DATE(i.datetime) BETWEEN '$from' AND '$to')";
        if($showroom != -1)
            $sql .= " AND (i.store_id = '$showroom') ";
        $sql .= "ORDER BY i.datetime DESC";
        
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        
        $ouput = NULL;
        if(is_array($result))
        {
            if($export)
            {
                $field_list = array('date', 'time', 'hoten', 'product_id', 'tentranh', 'tenkho', 'amount', 'bill_code', 'type', 'content');
                $column_name = array('Ngày', 'Giờ', 'Nhân viên', 'Mã sản phẩm', 'Tên sản phẩm', 'Showroom', 'Số lượng', 'Hóa đơn', 'Loại', 'Nội dung');
            }
            
            /* Format for date time */
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date_format = 'd/m/Y';
            $time_format = 'H:i:s';
            
            $ouput = array();
            foreach ($result as $row)
            {
                $datetime = strtotime($row['datetime']);
                $date = date($date_format, $datetime);
                $time = date($time_format, $datetime);;
                
                if( ! $export)
                {
                    $item = array('date' => $date,
                                  'time' => $time,
                                  'hoten' => $row['hoten'],
                                  'product_id' => $row['product_id'],
                                  'tentranh' => $row['tentranh'],
                                  'tenkho' => $row['tenkho'],
                                  'amount' => $row['amount'] . ' ',
                                  'bill_code' => $row['bill_code'] . ' ',
                                  'type' => ($row['type'] == import_export_history::$TYPE_IMPORT) ? 'Nhập' : 'Xuất',
                                  'content' => $row['content']
                                  );
                    array_push($ouput, $item);
                }
                else
                {
                    $item = array('date' => $date,
                                  'time' => $time,
                                  'hoten' => $row['hoten'],
                                  'product_id' => $row['product_id'],
                                  'tentranh' => $row['tentranh'],
                                  'tenkho' => $row['tenkho'],
                                  'amount' => $row['amount'] . ' ',
                                  'bill_code' => $row['bill_code'] . ' ',
                                  'type' => ($row['type'] == import_export_history::$TYPE_IMPORT) ? 'Nhập' : 'Xuất',
                                  'content' => $row['content']
                                  );
                    array_push($ouput, $item);
                }
            }
        }

        return $ouput;
    }
}

/* End of file import_export_history.php */
/* Location: ./models/import_export_history.php */
