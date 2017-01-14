<?php
require_once '../entities/baogia_entity.php';
require_once '../entities/baogiadetail_entity.php';
include_once '../models/database.php';
include_once '../models/baogiadetail.php';
include_once '../models/donhang.php';
include_once '../models/helper.php';
class baogia extends database {
    
    // them khach hang moi
    function them_moi(baogia_entity $item) {
        $sql = "INSERT INTO baogia (id, ngaybaogia, ngayclose, manhanvien, ngaycapnhat, lastupdate, status, closereason) ";
        $sql .= "VALUES ('$item->id', '$item->ngaybaogia', '$item->ngayclose', '$item->manhanvien', '$item->ngaycapnhat', '$item->lastupdate', '$item->status', '$item->closereason')";
        $this->setQuery ( $sql );
        
        $result = $this->query ();
        $this->disconnect ();
        if ($result) {
            $baogiadetail = new baogiadetail();
            $h = new baogiadetail_entity ();
            $h->id = $item->id;
            $h->noidung = $item->lastupdate;
            $result = $baogiadetail->insert ( $h );
        }
        return $result;
    }


    function baogia_exist($id)
    {
        $result = TRUE;
        $sql = "SELECT * FROM baogia WHERE id = '{$id}'";
        $this->setQuery($sql);
        $r = $this->query();
        $row = mysql_fetch_array ( $r );
        $this->disconnect();
        if (! is_array($row)) {
            $result = FALSE;
        }
        return $result;
    }


    function status_baogia($id)
    {
        $result = TRUE;
        $sql = "SELECT status FROM baogia WHERE id = '{$id}' limit 1";
        $this->setQuery($sql);
        $r = $this->query();
        $row = mysql_fetch_array ( $r );
        $this->disconnect();
        if (! is_array($row)) {
            $result = 0;
        } else {
            $result = $row['status'];
        }
        return $result;
    }

    
    // Update
    function update($id, $lastupdate, $ngaycapnhat, $status) {
        $sql = "UPDATE baogia SET lastupdate='" . $lastupdate . "', ngaycapnhat='". $ngaycapnhat . "'"; 
        $donhang = new donhang();
        if ((!empty($donhang->lay_thong_tin_don_hang($id))) && ($this->status_baogia($id)==1)) {
            $status = 0;
            $ngaydong = date("Y-m-d");
            $sql .= " AND status=" . $status . " AND ngayclose='" . $ngaydong . "'";
        }
        $sql .= " WHERE id='" . $id . "'";
         error_log ("Update baogia " . $sql, 3, '/var/log/phpdebug.log');

        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();

        if ($result) {
            $baogiadetail = new baogiadetail();
            $h = new baogiadetail_entity ();
            $h->id = $id;
            $h->noidung = $lastupdate;
            $result = $baogiadetail->insert ( $h );
        }
        return $result;
    }

    // Update
    function close($id, $nguyennhan, $note) {
        $lastupdate = "Ngay " . date("Y-m-d") . " dong bao gia: " . $note;
        $sql = "UPDATE baogia SET lastupdate='" . $lastupdate . "', ngaycapnhat='". date("Y-m-d") . "'";
        $sql .= ", status=0, ngayclose='" . date("Y-m-d") . "', closereason='" . $nguyennhan . "'";
        $sql .= " WHERE id='" . $id . "'";
         error_log ("Update baogia " . $sql, 3, '/var/log/phpdebug.log');

        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();

        if ($result) {
            $baogiadetail = new baogiadetail();
            $h = new baogiadetail_entity ();
            $h->id = $id;
            $h->noidung = $lastupdate;
            $result = $baogiadetail->insert ( $h );
        }
        return $result;
    }
    
    // Get detail
    public function detail_by_id($id) {
        $sql = "SELECT * FROM `baogia` WHERE `id` = '{$id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new baogia_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }

    public function scan_and_close() {
        $sql = "update baogia as b inner join donhang as d on d.madon = b.id set b.ngayclose=d.ngaydat, b.status=0, b.closereason ='Thành đơn hàng'  where b.status=1";
        $this->setQuery ( $sql );

        $result = $this->query ();
        $this->disconnect (); 
        return $result;
    }


    function list_close_by_reason($startdate,$stopdate,$manv)
    {
        // Xoa cac hoa don co gia tien khong hop le
        $nv = '';
        if (! empty($manv)) {
            $nv = " AND b.manhanvien='" . $manv. "'";
        }
        $this->scan_and_close();
        $sql = "SELECT count(b.id) as soluong, b.closereason as nguyennhan FROM baogia as b LEFT JOIN nhanvien as n on n.manv=b.manhanvien WHERE b.status=0 AND b.ngayclose BETWEEN '{$startdate}' AND '{$stopdate}' " .$nv. " group by b.closereason order by soluong desc";
        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        return $result;
    }


    function list_by_state($status,$startdate,$stopdate,$manv)
    {
        // Xoa cac hoa don co gia tien khong hop le
        $nv = '';
        if (! empty($manv)) {
            $nv = " AND b.manhanvien='" . $manv. "'";
        }
        if ($status==0) {
            $type = " AND b.ngayclose ";
        } else {
            $type = " AND b.ngaybaogia ";
        }
        $this->scan_and_close();
        $sql = "SELECT b.id as id, b.ngaybaogia as ngaybaogia, IFNULL(b.ngayclose,'Đang mở') as ngayclose, n.hoten as hoten, b.ngaycapnhat as ngaycapnhat, b.status as trangthai, b.lastupdate as capnhat, b.closereason as nguyennhan FROM baogia as b LEFT JOIN nhanvien as n on n.manv=b.manhanvien WHERE b.status=" . $status . $type . " BETWEEN '{$startdate}' AND '{$stopdate}' " .$nv. " order by b.id, b.ngaybaogia";
        //error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        return $result;
    }
    
}

?>
