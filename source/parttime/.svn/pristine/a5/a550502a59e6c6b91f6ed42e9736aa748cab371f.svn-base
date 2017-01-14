<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */
    $maloai=$_POST['maloai'];
    $startday = $_POST['startday'];
    $endday = $_POST['endday'];
    $type = $_POST['type'];
    //error_log ("add from db" . $type, 3, '/var/log/phpdebug.log');

    $output = array(
                "kichthuot" => array(),
                "tongmau" => array(),
                "hoavan" => array()
        );
    require_once '../models/database.php';
    $db = new database();
    if ($type==1) {
        $sql = "SELECT IFNULL(sum(c.soluong),0) AS total, t.dai as dai, t.rong as rong FROM donhang AS d LEFT JOIN (SELECT soluong, madon, masotranh FROM chitietdonhang GROUP BY madon, masotranh) as c ON d.madon = c.madon LEFT JOIN tranh AS t ON t.masotranh = c.masotranh WHERE t.maloai=".$maloai." AND d.ngaydat>='$startday' AND d.ngaydat<='$endday' GROUP BY t.dai, t.rong ORDER BY t.dai ASC";
    } else {
        $sql = "SELECT IFNULL(sum(k.soluong),0) AS total, t.dai as dai, t.rong as rong FROM tranh as t left join tonkho as k on k.masotranh = t.masotranh where t.maloai=".$maloai." group by t.dai, t.rong";
    }
    $db->setQuery($sql);
    $arr = $db->loadAllRow(); 
    $row = array();
    if(is_array($arr)):
        foreach ($arr as $item):
            $test = array('key' => $item['dai'].'x'.$item['rong'], 'value'=> $item['total']);
            array_push($row, $test);
        endforeach;
    $output['kichthuot'] = $row;
    endif;
    if ($type==1) {
        $sql = "SELECT IFNULL(sum(c.soluong),0) AS total, IFNULL(t.tongmau, 'Chua biet') as mau FROM donhang AS d LEFT JOIN (SELECT soluong, madon, masotranh FROM chitietdonhang GROUP BY madon, masotranh) as c ON d.madon = c.madon LEFT JOIN tranh AS t ON t.masotranh = c.masotranh WHERE t.maloai=".$maloai." AND d.ngaydat>='$startday' AND d.ngaydat<='$endday' GROUP BY t.tongmau ORDER BY tongmau ASC";
    } else {
        $sql = "SELECT IFNULL(sum(k.soluong),0) AS total, IFNULL(t.tongmau, 'Chua biet') as mau FROM tranh as t left join tonkho as k on k.masotranh = t.masotranh where t.maloai=".$maloai." group by t.tongmau";
    }
    $db->setQuery($sql);
    $arr = $db->loadAllRow(); 
    $row = array();
    if(is_array($arr)):
        foreach ($arr as $item):
            $test = array('key' => $item['mau'], 'value' => $item['total']);
            array_push($row, $test);
        endforeach;
    $output['tongmau'] = $row;
    endif;
    if ($type==1) {
        $sql = "SELECT IFNULL(sum(c.soluong),0) AS total, IFNULL(t.hoavan,'Chua biet') as hoa FROM donhang AS d LEFT JOIN (SELECT soluong, madon, masotranh FROM chitietdonhang GROUP BY madon, masotranh) as c ON d.madon = c.madon LEFT JOIN tranh AS t ON t.masotranh = c.masotranh WHERE t.maloai=".$maloai." AND d.ngaydat>='$startday' AND d.ngaydat<='$endday' GROUP BY t.hoavan ORDER BY t.hoavan ASC";
    } else {
        $sql = "SELECT IFNULL(sum(k.soluong),0) AS total, IFNULL(t.hoavan,'Chua biet') as hoa FROM tranh as t left join tonkho as k on k.masotranh = t.masotranh where t.maloai=".$maloai." group by t.hoavan";
    }
    $db->setQuery($sql);
    $arr = $db->loadAllRow();
    $row = array();
    if(is_array($arr)):
        foreach ($arr as $item):
            $test = array('key' => $item['hoa'], 'value' => $item['total']);
            array_push($row, $test);
        endforeach;
    $output['hoavan'] = $row;
    endif;    

    echo json_encode( $output , JSON_UNESCAPED_UNICODE);
?>
