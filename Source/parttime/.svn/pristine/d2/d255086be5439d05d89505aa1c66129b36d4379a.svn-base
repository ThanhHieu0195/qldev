<?php

/**
 * Description of dathang
 *
 * @author LuuBinh
 */
include_once 'database.php';
include_once 'helper.php';
include_once 'tranh.php';
include_once 'donhang.php';
include_once 'chitietdonhang.php';

//++ REQ20120508_BinhLV_N
class dathang extends database {

    public static $DEFAULT_IMAGE  = 'pic_images/DEFAULT.JPG'; // hinh anh mac dinh cua mot tranh dat
    public static $DEFAULT_MA_DON = 'INVALID';                // ma don hang mac dinh

    // Them mot san pham dat hang
    function them($masotranh, $tentranh, $maloai, $dai, $rong, $soluong, $giaban, $makho,
                  $matho, $ghichu, $nguoidat, $trangthai)
    {
        $result = TRUE;
        $this->_error = '';
        
        // Them vao bang tranh
        $tranh = new tranh();
        $result = $tranh->them($masotranh, $tentranh, $maloai, $dai, $rong, $giaban, $matho, $ghichu, dathang::$DEFAULT_IMAGE);
        $this->_error = $tranh->getMessage();
        // Them vao bang dathang
        if($result)
        {        
            $sql = "INSERT INTO dathang (masotranh, tentranh, maloai, dai, rong, soluong, giaban, makho, 
                                         matho, ghichu, hinhanh, madon, 
                                         nguoidat, ngaygiodat, trangthai
                                        )
                    VALUES
                    ('%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s', 
                     '%s'
                    )";
            $sql = sprintf($sql, $masotranh, $tentranh, $maloai, $dai, $rong, $soluong, $giaban, $makho,
                                 $matho, $ghichu, dathang::$DEFAULT_IMAGE, dathang::$DEFAULT_MA_DON, 
                                 $nguoidat, date("Y-m-d H:i:s"), chitietdonhang::$CAN_SAN_XUAT);
            $this->setQuery($sql);
            $result = $this->query();
            $this->disconnect();
        }
        
        return $result;
    }
    
    // Chi tiet mot san pham dat hang
    function chi_tiet($masotranh)
    {
        $sql = "SELECT * FROM dathang WHERE masotranh = '%s'";
        $sql = sprintf($sql, $masotranh); 
                          
        $this->setQuery($sql);
        $result = mysql_fetch_assoc($this->query());
        $this->disconnect();
        
        return $result;
    }
    
    // Xoa mot san pham dat hang
    function xoa($masotranh)
    {
        $result = TRUE;
        $this->_error = '';        
        
        // Xoa trong bang dathang
        $sql = "DELETE FROM dathang WHERE masotranh = '%s'";
        $sql = sprintf($sql, $masotranh); 
                          
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        // Xoa trong bang tranh
        if($result)
        {
            $tranh = new tranh();
            $result = $tranh->xoa_tranh($masotranh);
            $this->_error = $tranh->getMessage();
        }
        
        return $result;
    }
    
    // Xoa cac tranh dat cua mot hoa don
    function xoa_tranh_dat_don_hang($madon)
    {
        // Lay danh sach san pham dat hang cua mot hoa don
        $sql = "SELECT masotranh FROM dathang WHERE madon = '%s'";
        $sql = sprintf($sql, $madon);                
        $this->setQuery($sql);
        $array = $this->loadAllRow();
        $this->disconnect();
        
        // Lan luot xoa cac san pham trong danh sach tren
        if(count($array) > 0)
        {
            foreach($array as $value)
            {
                $this->xoa($value['masotranh']);
            }
        }
    }
    
    // Xoa cac san pham dat hang khong hop le (khong thuoc don hang nao ca)
    function _xoa_tranh_dat_khong_hop_le()
    {
        $sql = "DELETE FROM dathang WHERE madon = '%s'";
        $sql = sprintf($sql, dathang::$DEFAULT_MA_DON);
                
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }
    
    // Cap nhat mot san pham dat hang
    function cap_nhat($masotranh, $tentranh, $maloai, $dai, $rong, $soluong, $giaban, $makho,
                      $matho, $ghichu, $hinhanh, $madon, $nguoidat, $ngaygiodat, $trangthai)
    {
        // 1. Cap nhat cac thong tin trong bang dathang va bang tranh
        // Cap nhat bang dathang
        $sql = "UPDATE dathang 
                SET
                    tentranh = '%s' , 
                    maloai = '%s' , 
                    dai = '%s' , 
                    rong = '%s' , 
                    soluong = '%s' , 
                    giaban = '%s' , 
                    makho = '%s' , 
                    matho = '%s' , 
                    ghichu = '%s' , 
                    hinhanh = '%s' , 
                    madon = '%s' , 
                    nguoidat = '%s' , 
                    ngaygiodat = '%s' , 
                    trangthai = '%s'
                WHERE masotranh = '%s'";
        $sql = sprintf($sql, $tentranh, $maloai, $dai, $rong, $soluong, $giaban, $makho, $matho,
                             $ghichu, $hinhanh, $madon, $nguoidat, $ngaygiodat, $trangthai, $masotranh);
        $this->setQuery($sql);
        $this->query();
        $this->disconnect();
        // Cap nhat bang tranh
        $tranh = new tranh();
        $tranh->cap_nhat_tranh($masotranh, $maloai, $tentranh, $dai, $rong, $giaban, $ghichu, $matho, $hinhanh);
        
        // 2. Cap nhat so luong + gia ban
        // Cap nhat bang chitietdonhang
        $ctdh = new chitietdonhang();
        $ctdh->cap_nhat($madon, $masotranh, $makho, $soluong, $giaban, $trangthai);
        // Cap nhat tien hoa don
        $donhang = new donhang();
        $donhang->cap_nhat_tien($madon);
        
        // 3. Cap nhat trang thai
        if($trangthai == chitietdonhang::$CHO_GIAO)  // hang dat da san xuat xong
        {
            // Xoa trong bang dathang
            $this->xoa($masotranh);
            // Them vao bang tonkho
            $tonkho = new tonkho();
            $tonkho->them($masotranh, $makho, $soluong);
        }        
    }
    
    // Cap nhat ma hoa don cua mot san pham dat hang
    function cap_nhat_ma_don($masotranh, $madon)
    {
        $sql = "UPDATE dathang 
                SET 
                    madon = '%s'
                WHERE masotranh = '%s'";
        $sql = sprintf($sql, $madon, $masotranh);
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        
        return $result;
    }
    
    // Danh sach ten tieng Viet cac cot cua danh sach san pham dat hang
    function danh_sach_column()
    {
        $result = array();
        $result[] = 'Mã sản phẩm';
        $result[] = 'Loại sản phẩm';
        $result[] = 'Số lượng';
        $result[] = 'Giá bán';
        $result[] = 'Showroom';
        $result[] = 'Mã hóa đơn';
        $result[] = 'Ngày giao';
        $result[] = 'Ghi chú';
        $result[] = 'Người đặt';
        $result[] = 'Ngày giờ đặt';
        $result[] = 'Trạng thái';
        
        return $result;
    }
    
    // Tao danh sach dat hang de export ra Excel
    function _create_array($data, $export = FALSE)
    {
        if( ! $export)
            return $data;
        else
        {
            foreach ($data as $value)
            {
                $item['Mã sản phẩm'] = $value['masotranh'];
                $item['Loại sản phẩm'] = $value['tenloai'];
                $item['Số lượng'] = $value['soluong'];
                $item['Giá bán'] = number_2_string($value['giaban'], '');
                $item['Showroom'] = $value['tenkho'];
                $item['Mã hóa đơn'] = $value['madon'];
                $item['Ngày giao'] = $value['ngaygiao'];
                $item['Ghi chú'] = $value['ghichu'];
                $item['Người đặt'] = $value['nguoidat'];
                $item['Ngày giờ đặt'] = $value['ngaygiodat'];
                switch($value['trangthai'])
                {
                    case chitietdonhang::$CAN_SAN_XUAT:
                        $item['Trạng thái'] = 'Cần sản xuất';
                    break;
                    
                    case chitietdonhang::$DANG_SAN_XUAT:
                        $item['Trạng thái'] = 'Đang sản xuất';
                    break;
                }
                       
                $result[] = $item;
            }
            return $result;
        }
    }
    
    // Danh sach san pham dat hang
    function danh_sach($export = FALSE)
    {
        $this->_xoa_tranh_dat_khong_hop_le();
        
        $sql = "SELECT dathang.masotranh,
                       loaitranh.tenloai,    
                       dathang.soluong,
                       dathang.giaban,
                       khohang.tenkho,
                       dathang.madon,
                       donhang.ngaygiao,
                       dathang.ghichu,
                       dathang.nguoidat,
                       dathang.ngaygiodat,
                       dathang.trangthai
                FROM dathang
                            INNER JOIN loaitranh ON dathang.maloai = loaitranh.maloai
                            INNER JOIN donhang ON dathang.madon = donhang.madon
                            INNER JOIN khohang ON dathang.makho = khohang.makho";
        
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        return $this->_create_array($result, $export);
    }
}
//-- REQ20120508_BinhLV_N
/* End of file dathang.php */
/* Location: ./models/dathang.php */