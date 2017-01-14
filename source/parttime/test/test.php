<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Test model</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Script-Type"
	content="text/javascript; charset=utf-8" />
</head>
<body>
        <?php
        require_once '../part/common_start_page.php';
        ini_set ( 'display_errors', 1 );
        
        // require_once '../models/khach.php';
        
        // $model = new khach ();
        // debug($model->danh_sach_tong_hop(48));
        // //debug($model->danh_sach_column());
        // //debug($model->order_statistic($from, $to, TRUE, $fieldlist, $column_names));
        $last = '2015-05-22';
        //$last = '2015-05-25';
        $current = current_timestamp('Y-m-d');
        
        debug($last);
        debug($current);

        $last = strtotime($last);
        $current = strtotime($current);

        $t = $current - $last;
        $t = $t / (24 * 60 * 60);
        debug($t);
        ?>
    </body>
</html>
