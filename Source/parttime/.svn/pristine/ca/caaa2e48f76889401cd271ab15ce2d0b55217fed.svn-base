<?php
require_once '../email/emailapp.php';
require_once '../models/khach.php';
$result = array(
        'result'   => 0,                // Error status
        'message'  => 'Upload failed.', // Message
        'items' => []                // Progress status (success/total)
    );
$app = new MyApp();
$email = $_POST['email'];
$name = $_POST['name'];
$listid = $_POST['listid'];
$guestid = $_POST['guestid'];
$subscriber = array(
    'email' => $email,
    'name'  => $name
);
//$app->addSubscriber($subscriber, $listid);
if (($listid) && ($email)) {
    //error_log ("HUANNNN " . $listid, 3, '/var/log/phpdebug.log');
    //echo json_encode($result);
    $tmp = $app->addSubscriber($subscriber, $listid);
    if ($tmp==1) {
        $result['result'] = 1;
        $result['message'] = 'success';
    } else {
        $result['result'] = 0;
        $result['message'] = $tmp;
    }
} else { 
    if ($guestid) {
        $khach_model = new khach ();
        $emailk = $khach_model->get_email($guestid);
        $Femail = $app->findSubscriber($emailk);
        $arr = [];
        $Flist = $app->findAllList();
        if ($Femail) {
            //$regex = "/lists\\\/([0-9]*)\\\/subscribers/";
            //preg_match_all($regex, json_encode($Femail->self_link), $matches);
            //error_log ("HUANNNN " . json_encode($Femail->self_link) . $matches[1], 3, '/var/log/phpdebug.log');
            $result['result'] = 0;
            $result['message'] = 'Email da dang ky voi he thong Marketing: ' . $Femail->email;
            foreach ($Flist as $l) {
                if (strpos(json_encode($Femail->self_link), strval($l->id))) {
                    array_push($arr, array('id' => $l->id, 'name' => $l->name));
                }
            }
            $result['items'] = $arr;
        } else {
            $result['result'] = 1;
            foreach ($Flist as $l) {
                array_push($arr, array('id' => $l->id, 'name' => $l->name));
            }
            $result['items'] = $arr;
        }
    }
}
echo json_encode($result);
?>
