<?php

require_once 'database.php';

class orders_cashing_history extends database {
    // @author: HieuThanh
    // hàm tính tổng money_amount theo order_id
    function SumAmount_by_Order_Id($order_id) {
        $sql = "SELECT SUM(money_amount)AS Sum_Amount FROM `orders_cashing_history` WHERE order_id = '%s'; ";
        $sql = sprintf($sql, $order_id);
        $this-> setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array($result);
        $this->disconnect();
        return $row['Sum_Amount'];
    }



    function add_new($order_id, $cashed_by, $cashing_type, $money_amount)
    {
        $content = "";
        switch ($cashing_type) 
        {
            case CASHED_TYPE_PARTLY:
                $content = "Thu 1 phần tiền";
                break;
            
            case CASHED_TYPE_TIEN_COC:
                $content = "Thu tiền cọc";
                break;

            case CASHED_TYPE_TIEN_GIAO_HANG:
                $content = "Thu tiền giao hàng";
                break;

            case CASHED_TYPE_ALL:
                $content = "Thu tất cả tiền";
                break;

            case CASHED_TYPE_TIENTHICONG:
                $content = "Thu tiền thi công";
                break;

            case CASHED_TYPE_TIENCATTHAM:
                $content = "Thu tiền cắt thảm";
                break;

            case CASHED_TYPE_PHUTHUGIAOHANG:
                $content = "Thu phụ thu giao hàng";
                break;

            case CASHED_TYPE_THUTIENGIUMKHACHSI:
                $content = "Thu thu tiền giùm khách sĩ";
                break;

            default:
                break;
        }

        $sql = "INSERT INTO orders_cashing_history(uid, order_id, cashed_date, cashed_by, money_amount, content, cashed_type)
                VALUES('%s', '%s', CURRENT_DATE(), '%s', '%s', '%s', '%s')";
        $sql = sprintf($sql, uniqid('', true), $order_id, $cashed_by, $money_amount, $content, $cashing_type);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
}

/* End of file orders_cashing_history.php */
/* Location: ./models/orders_cashing_history.php */
