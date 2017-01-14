<?php
//++ REQ20120915_BinhLV_N

include_once 'database.php';
include_once 'helper.php';

class quan extends database {
    
    // Tim kiem quan theo tham so truyen vao
    function get_top($term, $limit)
    {
        // Ket qua default (khong tim thay)
        $output = array( 'quan' => '',
                         'ten' => ''
                       );
        
        // Danh sach cac cot tim kiem trong bang 'quan'
        $columns = array( 'tenquan' );
        
        // Tao cau lenh SQL dung de tim kiem
        $where = "";
        if ( isset($term) && $term != "" )
        {
            $where = "WHERE (";
            for ( $i=0, $len = count($columns); $i<$len ; $i++ )
            {
                $where .= "`" . $columns[$i] . "` LIKE '%" . $term . "%' OR ";
            }
            $where = substr_replace( $where, "", -3 );
            $where .= ')';
        }
        
        $order = "ORDER BY tenquan ASC";
        
        $limit = "LIMIT " . $limit;
        
        $sql = "
              SELECT id, tenquan
              FROM quan
              $where
              $order
              $limit
              ";
        
        // Lay du lieu tu database
        $this->setQuery($sql);
        $array = $this->loadAllRow();
        $this->disconnect();      
        
        if(is_array($array))
        {
            $output = array();
            foreach($array as $row)
            {
                array_push($output, array( 'quan' => $row['tenquan'], 
                                           'ten' => str_replace('_', ' ', $row['tenquan'])
                                         ));
            }
        }        
          
        return json_encode($output);
    }
}

//-- REQ20120915_BinhLV_N
?>