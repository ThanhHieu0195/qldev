<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trahang
 *
 // 
 * @author HieuThanh
 */
include_once 'database.php';
include_once 'helper.php';

class detail_material_category extends database {
    public $_NAMETABLE = 'chitietvattucongtrinh';
    public $_columns = array('soluongdutoan','soluongthucte','soluongphatsinh','giadutoan','giathucte','giaphatsinh','idnhacungcap','trangthai','ghichu');

    public $_idcongtrinh = 'idcongtrinh';
    public $_idhangmuc = 'idhangmuc';
    public $_idvattu = 'idvattu';
    public $_soluongdutoan = 'soluongdutoan';
    public $_soluongthucte = 'soluongthucte';
    public $_soluongphatsinh = 'soluongphatsinh';
    public $_giadutoan = 'giadutoan';
    public $_giathucte = 'giathucte';
    public $_giaphatsinh = 'giaphatsinh';
    public $_idnhacungcap = 'idnhacungcap';
    public $_trangthai = 'trangthai';
    public $_ghichu = 'ghichu';
    public $_id = 'id';

    public $_TOTAL_P = 10;
    // id_building, id_category, id_material, soluongdutoan, num, giadutoan, cost, id_product, status, note
    public function getDetail($conditions, $params) {
        $select = "*";
        if ( is_array($params) ) {
            $select = implode(", ", $params);
        }

        $where = mergeTostr($conditions, ' and ', ' = ');
        $sql = "select $select, (select giacao from vattuhangmucthicong where id=idvattu) as giacao from $this->_NAMETABLE where $where";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_array($result) ) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function takeLastId() {
        $sql = "select id from $this->_NAMETABLE order by id desc;";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_row($result);
        if ( count($row) > 0 ) {
            return $row[0];
        }
        return 0;
    }

    public function insert($params)
    {
        $id_building = isset($params['id_building'])?$params['id_building']:'';
        $id_category = isset($params['id_category'])?$params['id_category']:'';
        $id_material = isset($params['id_material'])?$params['id_material']:'';
        $id = isset($params['id'])?$params['id']:'';
        $soluongdutoan = isset($params['soluongdutoan'])?$params['soluongdutoan']:'';
        $soluongthucte = isset($params['soluongthucte'])?$params['soluongthucte']:'';
        $soluongphatsinh = isset($params['soluongphatsinh'])?$params['soluongphatsinh']:'';
        $giadutoan = isset($params['giadutoan'])?$params['giadutoan']:'';
        $giathucte = isset($params['giathucte'])?$params['giathucte']:'';
        $giaphatsinh = isset($params['giaphatsinh'])?$params['giaphatsinh']:'';
        $sql = "insert into $this->_NAMETABLE($this->_idcongtrinh, $this->_idhangmuc, $this->_idvattu, $this->_id, $this->_soluongdutoan, $this->_soluongthucte, $this->_soluongphatsinh, $this->_giadutoan, $this->_giathucte, $this->_giaphatsinh) values('$id_building', '$id_category','$id_material', '$id','$soluongdutoan', '$soluongthucte','$soluongphatsinh','$giadutoan','$giathucte','$giaphatsinh');";
        $this->setQuery($sql);

        // print_r($sql);
        $result = $this->query();
        if ($result) {
            return true;
        }  
        return false;
    }

    public function update($params, $conditions) {
        $where = "";
        $set = "";
        //error_log ("Add new" . json_encode($params) . json_encode($conditions), 3, '/var/log/phpdebug.log');
        foreach ($params as $key => $value) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= $key . ' = "' . $value . '"';
        }

        if ( count($conditions > 0) ) {
            $where = "where ".mergeTostr($conditions, 'and', '=', $this->_NAME_COLUMN);
        }  

        $sql = "UPDATE $this->_NAMETABLE set $set $where;";
        //error_log ("Add new" . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);

        // print_r($sql);
        $result = $this->query();
        if ($result) {
            return true;
        }  
        return false;
    }

    public function is_exists ($params)
    {   
        if ( count($params) >0 ) {
            $where = mergeTostr($params, 'and', '=', $this->_NAME_COLUMN);
            $sql = "SELECT * FROM $this->_NAMETABLE WHERE $where;";
            $this->setQuery($sql);
            $result = $this->query();
            $row = mysql_fetch_row($result);
            if ( !empty($row) ) {
                return true;
            }
        }
        return false;
    }

    function delete($params) {
        if ( count($params) > 0 ) {
            $where = mergeTostr($params, 'and', '=', $this->_NAME_COLUMN);
            $sql = "delete from $this->_NAMETABLE where $where";
            $this->setQuery($sql);
            $result = $this->query();
            return $result;
        }
    }

    public $_NAME_COLUMN = array('id_building'=>'idcongtrinh', 
                                'id_category'=>'idhangmuc',  
                                'id_material'=>'idvattu', 
                                'id'=>'id', 
                                'soluongdutoan'=>'soluongdutoan', 
                                'num'=>'soluongthucte',
                                'giadutoan'=>'giadutoan',
                                'cost'=>'giathucte',
                                'id_product'=>'idnhacungcap',
                                'status'=>'trangthai',
                                'note'=>'ghichu');
    // id_building, id_category, id_material, id, soluongdutoan, num, giadutoan, cost, id_product, status, note

}
// $model = new detail_material_category();
// echo $model->takeLastId();
?>
