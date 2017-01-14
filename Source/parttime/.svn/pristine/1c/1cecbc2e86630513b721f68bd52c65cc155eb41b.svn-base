<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tonkho
 *
 * @author LuuBinh
 */
//++ REQ20120508_BinhLV_N
include_once 'database.php';
require_once 'helper.php';
require_once 'import_export_history.php';
require_once 'khohang.php';

class tonkho extends database {

    // Them hang muc ton kho moi
    function them($masotranh, $makho, $soluong)
    {
        $sql = "INSERT INTO tonkho (masotranh, makho, soluong)
                VALUES('%s', %d, %d)";
        $sql = sprintf($sql, $masotranh, $makho, $soluong);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        
        return $result;
    }

    // Cap nhat hang muc ton kho da co
    function cap_nhat_so_luong($masotranh, $makho, $soluong, $add=TRUE)
    {
        if($add)
        {
            $sql = "UPDATE tonkho
                      SET soluong = soluong + %d
                    WHERE masotranh = '%s' AND makho = %d";
        }
        else
        {
            $sql = "UPDATE tonkho
                      SET soluong = %d
                    WHERE masotranh = '%s' AND makho = %d";
        }
        $sql = sprintf($sql, $soluong, $masotranh, $makho);

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();

        return $result;
    }
    
    // Lay so luong ton kho cua mot mat hang
    function so_luong_ton_kho($masotranh, $makho)
    {
        $sql = "SELECT soluong FROM tonkho WHERE masotranh = '%s' AND makho = %d";
        $sql = sprintf($sql, $masotranh, $makho);
           
        $this->setQuery($sql); 
        $row = mysql_fetch_object($this->query());
        if($row)
            return $row->soluong;
        else return 0;
    }
    
    function is_exist($masotranh, $makho)
    {
        $sql = "SELECT soluong FROM tonkho WHERE masotranh = '%s' AND makho = %d";
        $sql = sprintf($sql, $masotranh, $makho);
           
        $this->setQuery($sql); 
        $row = mysql_fetch_object($this->query());
        if($row)
            return TRUE;
        return FALSE;
    }
    
    // Xoa mot hang muc ton kho
    function xoa($masotranh, $makho, $soluong = NULL)
    {
        if($soluong == NULL)
        {
            $sql = "DELETE FROM tonkho WHERE masotranh = '%s' AND makho = %d";
            $sql = sprintf($sql, $masotranh, $makho);
    
            $this->setQuery($sql);
            $result = $this->query();
            $this->disconnect();
            
            return $result;
        }
        else
        {
            if($this->so_luong_ton_kho($masotranh, $makho) >= $soluong)
                return $this->cap_nhat_so_luong($masotranh, $makho, -$soluong);
        }

        //return $result;
    }
    
    // Xoa cac hang muc ton kho co so luong = 0
    function xoa_hang_muc_het_so_luong()
    {
        $sql = "DELETE FROM tonkho WHERE soluong <= 0";
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        
        return $result;
    }
    
    //++ REQ20120915_BinhLV_N
    // Thong ke so luong san pham trong toan kho (tong cac chi nhanh)
    function thong_ke_so_luong_ton_kho()
    {
        $sql = "SELECT masotranh, SUM(soluong) AS soluong
                FROM tonkho
                GROUP BY masotranh
                ORDER BY masotranh";
        
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        
        return $result;
    }
    
    // Tim gia tri mot phan tu trong mang theo key
    function _search_item($array, $key)
    {
    	$result = FALSE;
    
    	if (is_array($array))
    	{
    	    foreach ($array as $row)
    	    {
    		    if ($row['masotranh'] == $key)
    			    return $row['soluong'];
    	    }
    	}
    
    	return $result;
    }
    
    // Danh sach ten cot cua bang thong ke chenh lech
    function danh_sach_column_chenh_lech()
    {    
    	$result = array();    	
    	$result[] = 'Mã sản phẩm';
    	$result[] = 'Tên sản phẩm';
    	$result[] = 'Loại sản phẩm';
    	$result[] = 'Tổng số lượng trong kho';
    	$result[] = 'Tổng số lượng cần cung cấp';
    	$result[] = 'Số lượng cần sản xuất thêm';
    
    	return $result;
    }
    
    // Thong ke so luong chenh lech giua so luong ton kho va so luong can cung cap
    function thong_ke_so_luong_chenh_lech()
    {
        require_once 'chitietdonhang.php';
        
    	$result = array();
    	$ton_kho = $this->thong_ke_so_luong_ton_kho();
    	$ctdh = new chitietdonhang();
    	$dat_mua = $ctdh->thong_ke_so_luong_can();
    	
    	foreach ($dat_mua as $row)
    	{
    		if($count = $this->_search_item($ton_kho, $row['masotranh']))
    		{
    		    if($value > $count)
    		    {
    			    $item = array( 'masotranh' => $row['masotranh'] . ' ',  
    			                   'tentranh' => $row['tentranh'],
    			                   'loaitranh' => $row['tenloai'],
    			                   'soluongton' => $count,
    			                   'soluongmua' => $row['soluong'],
    			                   'soluongcan' => ($row['soluong'] - $count),
    			                   'hinhanh' => $row['hinhanh'],
    			                 );
    		        array_push($result, $item);
    		    }
    		}
    	}
    
    	return $result;
    }
    
    // Thong ke so luong o cac showroom cua mot san pham
    function so_luong_o_showroom($masotranh)
    {    
    	$sql = "SELECT makho AS showroom,
    	               tenkho,
                       IFNULL((SELECT soluong FROM tonkho WHERE makho = showroom AND masotranh = '$masotranh'), 0) AS soluong
                FROM khohang
                ORDER BY tenkho
    	        ";
    	$this->setQuery($sql);
    	$result = $this->loadAllRow();
    	$this->disconnect();    	
    
    	return $result;
    }


    // Thong ke so luong o cac showroom cua mot san pham
    function so_luong_o_showrooms($masotranh, $listkho)
    {
        $khohang = join("','",$listkho);
        $sql = "SELECT sum(soluong) AS soluong FROM tonkho WHERE makho IN ('$khohang') AND masotranh='$masotranh' limit 1";
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        return $result[0];
    }

    //-- REQ20120915_BinhLV_N
}
//-- REQ20120508_BinhLV_N
?>
