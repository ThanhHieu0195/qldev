<?php
    $res = array('message'=> '', 'result' => 0);
    if ( !isset($_REQUEST['ACCESS_AJAX']) || !isset($_REQUEST['MODEL']) || !isset($_REQUEST['FUNCTION']) ) die;
    $access_ajax = $_REQUEST['ACCESS_AJAX'];
    $model       = $_REQUEST['MODEL'];
    $file        = '../models/'.$model.'.php';
    $function    = $_REQUEST['FUNCTION'];
    $data        = $_REQUEST['DATA'];
    if ( !file_exists($file) ) {
        echo "File không tồn tại: ".$file;
        die;
    }
    require_once $file;
    if ( !class_exists($model) ) {
        echo "class không tồn tại: ".$model;
        die;
    }
    $class = new $model();
    $function_Ajax   = $function.'_Ajax';
    if ( !method_exists($class, $function_Ajax) ) {
        echo "function không tồn tại: ".$function;
        die;
    }
extract($data);
    $result          =  $class->{$function_Ajax}();
    $message         =  'Đã thực hiện function: %1$s của model: %2$s';
    $res['result']   = $result;
    $res['message']  = sprintf($message, $function, $model);
    echo json_encode($res);
?>