<?php
require_once 'database.php';
require_once '../config/constants.php';
require_once '../models/tranh.php';
require_once '../models/tonkho.php';
require_once '../models/helper.php';
require_once '../models/import_export_history.php';

class guestupload extends database {

    function add_new_upload($id, $upload_by, $filename, $approved = 0)
    {
        $sql = "INSERT INTO upload(id, datetime, upload_by, filename, approved)
                VALUES('$id', CURRENT_TIMESTAMP(), '$upload_by', '$filename', $approved)";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        
        return $result;
    }
    
    function delete_upload($id)
    {
        $sql = "DELETE FROM upload WHERE id = '$id'";
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        
        return $result;
    }
    
    function get_file_path($id)
    {
        $this->setQuery("SELECT filename FROM upload WHERE id = '$id'");
        $result = $this->query();
        $row = mysql_fetch_array($result);
        $this->disconnect();
        
        if(is_array($row))
        {
            return sprintf("../%s/%s", EXCEL_FOLDER, $row['filename']);
        }
        
        return NULL;
    }
    
    function add_new_guest($hoten, $dienthoai, $email, $diachi, $nhomkhach, $tiemnang)
    {
        $s1 = '';
        $s2 = '';
        $i = 1;
        foreach ($dienthoai as $dt) {
            if (strlen($dt)>0) {
                error_log ($dt, 3, '/var/log/phpdebug.log');  
                $s1 .=  "dienthoai".strval($i) .", ";
                $i += 1;
                $s2 .= "'" . $dt . "', ";
            } 
        }
        $sql = "INSERT INTO khach(hoten, " . $s1 . " email, diachi, manhom, tiemnang)" . 
                "VALUES('$hoten', ". $s2 ." '$email', '$diachi', '$nhomkhach', '$tiemnang')"; 
        error_log ($sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }

    function get_guestid($dienthoai)
    {
        $sql = "SELECT makhach FROM khach WHERE dienthoai1='$dienthoai' LIMIT 1";
        //error_log ($sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        if(is_array($row))
            return $row[0];
        error_log ($sql, 3, '/var/log/phpdebug.log');
        return NULL;
    }


    function add_new_guest_marketing($manv, $makhach, $chiendich, $lienhe, $ghichu)
    {
        $sql = "INSERT INTO marketing (manv, makhach, chiendich, lienhe, ghichu)
                VALUES('$manv', '$makhach', '$chiendich', '$lienhe', '$ghichu')";

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }
    
    function delete_upload_detail($id)
    {
        $sql = "DELETE FROM upload_detail WHERE id = '$id'";
        
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
        return $result;
    }
    
    // Validate item
    // Ket qua tra ve ('result' => X, 'message' => Y)
    function validate_nhomkhach($tennhom)
    {
        $result = TRUE;
        $message = '';
        $nhomkhach = '';
        $sql = "SELECT * FROM nhomkhach WHERE manhom = $tennhom";
        $this->setQuery($sql);
        $r = $this->query();
        $row = mysql_fetch_array ( $r );
        $this->disconnect();
        if (! is_array($row)) {
            $result = FALSE;
        }
        return $result;
    }

}

/* End of file upload.php */
/* Location: ./models/upload.php */
