<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cart
 *
 * @author LuuBinh
 */
 
class Cart {

    var $_name = '';
    var $_data = NULL;
    
    protected function is_session_started()
    {
        if (function_exists('php_sapi_name')) {
            if ( php_sapi_name() !== 'cli' ) {
                if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                    return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
                } else {
                    return session_id() === '' ? FALSE : TRUE;
                }
            }
        }
        else {
            return session_id() === '' ? FALSE : TRUE;
        }
        return FALSE;
    }

    // Phuong thuc khoi tao
    public function  __construct($name)
    {
        $this->_name = $name;
        //if ($this->is_session_started() === FALSE ) {
        //    session_start();
        //}
    }

    // Register
    function register()
    {
        if (function_exists('session_register')) {
            session_register($this->_name);
        }
    }

    // Unregister
    function unregister()
    {
        if (function_exists('session_unregister')) {
            session_unregister($this->_name);
        }
    }

    // Clear all data in cart
    function clear()
    {
        //$this->_data = NULL;
        //$this->_set_data();
        unset ($this->_data);
        //unset ($_SESSION[$this->_name]);
        $this->_set_data();
    }

    // Count number of items in cart
    function count()
    {
        $this->_get_data();
        return count($this->_data);
    }

    // Get cart's data
    function _get_data()
    {
        if(isset ($_SESSION[$this->_name]))
            $this->_data = $_SESSION[$this->_name];
        else
            $this->_data = NULL;
    }

    // Set data to cart
    function _set_data()
    {
        $_SESSION[$this->_name] = $this->_data;
    }

    // Add an item in cart
    function add($masotranh, $makho, $soluong, $trangthai)
    {
        $this->_get_data();
        $item = array('masotranh' => $masotranh, 'makho' => $makho, 'soluong' => $soluong, 'trangthai' => $trangthai);
        if(count($this->_data) === 0)
        {
            $this->_data[] = $item;
        }
        else
        {
            $exists = FALSE;
            foreach ($this->_data as $value):
                if($value['masotranh'] === $masotranh
                   && $value['makho'] === $makho)
                {
                    $exists = TRUE;
                    break;
                }
            endforeach;
            if( ! $exists)
                $this->_data[] = $item;
        }
        $this->_set_data();
    }

    // Update an item in cart
    function update($masotranh, $makho, $soluong, $trangthai)
    {
        $this->_get_data();
        if(count($this->_data) > 0)
        {
            foreach ($this->_data as $key => $value):
                if($value['masotranh'] === $masotranh
                   && $value['makho'] === $makho)
                {
                    $this->_data[$key]['soluong'] = $soluong;
                    $this->_data[$key]['trangthai'] = $trangthai;
                    break;
                }
            endforeach;
        }
        $this->_set_data();
    }

    // Delete an item in cart
    function delete($masotranh, $makho)
    {
        $this->_get_data();
        if(count($this->_data) > 0)
        {
            foreach ($this->_data as $value):
                if($value['masotranh'] !== $masotranh
                   OR $value['makho'] !== $makho)
                {
                    $item = array('masotranh' => $value['masotranh'],
                                  'makho' => $value['makho'],
                                  'soluong' => $value['soluong'],
                                  'trangthai' => $value['trangthai']);
                    $array[] = $item;
                }
                else
                {
                    // Neu trang thai = chitietdonhang::$DAT_HANG => xoa trong bang dathang va bang tranh
                    if (!class_exists('chitietdonhang')) {
                        require_once '../models/chitietdonhang.php';
                    }
                    if($value['trangthai'] == chitietdonhang::$DAT_HANG)
                    {
                        $dh = new dathang();
                        $dh->xoa($masotranh);
                    }
                }
            endforeach;
            $this->_data = $array;
        }
        $this->_set_data();
    }

    // Get amount of to procdure item(s) : Dem so luong san pham dat hang
    function tp_amount()
    {
        $count = 0;
        $this->_get_data();
        if(count($this->_data) > 0)
        {
            foreach ($this->_data as $value):
                if($value['trangthai'] == chitietdonhang::$DAT_HANG)
                    $count++;
            endforeach;
        }
        return $count;
    }

    // Get amount of an item
    function _get_amount($masotranh, $makho)
    {
        $this->_get_data();
        if(count($this->_data) > 0)
        {
            foreach ($this->_data as $value):
                if($value['masotranh'] === $masotranh
                   && $value['makho'] === $makho)
                        return $value['soluong'];
            endforeach;
        }
        return 0;
    }
    
    // Get state of an item
    function _get_state($masotranh, $makho)
    {
        $this->_get_data();
        if(count($this->_data) > 0)
        {
            foreach ($this->_data as $value):
                if($value['masotranh'] === $masotranh
                   && $value['makho'] === $makho)
                        return $value['trangthai'];
            endforeach;
        }
        return '';
    }

    function detail_list_ASSEMBLY() {
        $result= array();
        $this->_get_data();
        if(count($this->_data) > 0)
        {
            $sql = "SELECT tranh.masotranh, chitietsanphammapping.machitiet, chitietsanpham.mota, chitietsanphammapping.soluong  FROM tranh 
                    left join chitietsanphammapping on chitietsanphammapping.masotranh = tranh.masotranh
                    left join chitietsanpham        on chitietsanpham.machitiet = chitietsanphammapping.machitiet
                    WHERE tranh.loai = '".TYPE_ITEM_ASSEMBLY."' AND tranh.masotranh in (";

            foreach ($this->_data as $value):
                $sql .= "'" . $value['masotranh'] . "', ";
            endforeach;
            $sql = substr_replace( $sql, "", -2 );
            $sql .= ")";
            $db = new database();
            $db->setQuery($sql);
            $arr = $db->loadAllRow();
            for ($i=0; $i <= count($arr); $i++) { 
                $row = $arr[$i];
                $result[ $row['masotranh'] ][] = $row;
            }

            $db->disconnect();
        }
        //debug($result);
        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
        return$result ;
    }
    // Get detail list of cart
    function detail_list()
    {
        $result = NULL;
        $this->_get_data();
        if(count($this->_data) > 0)
        {
            $sql = "SELECT tranh.masotranh,
                           tranh.tentranh,
                           tranh.giaban,
                           tranh.hinhanh,
                           tranh.maloai,
                           khohang.makho,
                           khohang.tenkho,
                           tranh.loai
                    FROM khohang, tranh";
            $sql .= " WHERE tranh.masotranh IN (";
            $and = " AND khohang.makho IN (";

            $makho = '';
            foreach ($this->_data as $value):
                $sql .= "'" . $value['masotranh'] . "', ";
                if($makho !== $value['makho'])
                    $and .= "'" . $value['makho'] . "', ";
                $makho = $value['makho'];
            endforeach;
            $sql = substr_replace( $sql, "", -2 );
            $and = substr_replace( $and, "", -2 );

            $sql .= ")";
            $and .= " )";
        
            $sql .= $and;

            $db = new database();
            $db->setQuery($sql);
            $array = $db->loadAllRow();
            $db->disconnect();
            foreach ($array as $value)
            {
                $amount = $this->_get_amount($value['masotranh'], $value['makho']);
                if($amount > 0)
                {
                    $item = array('masotranh' => $value['masotranh'],
                                  'tentranh' => $value['tentranh'],
                                  'giaban' => $value['giaban'],
                                  'soluong' => $amount,
                                  'thanhtien' => ($amount * $value['giaban']),
                                  'makho' => $value['makho'],
                                  'tenkho' => $value['tenkho'],
                                  'maloai' => $value['maloai'],
                                  'trangthai' => $this->_get_state($value['masotranh'], $value['makho']),
                                  'hinhanh' => $value['hinhanh'],
                                  'loai'      => $value['loai']);
                    $result[] = $item;
                }
            }
        }
        //debug($result);
        return $result;
    }
}
//-- REQ20120508_BinhLV_N
?>
