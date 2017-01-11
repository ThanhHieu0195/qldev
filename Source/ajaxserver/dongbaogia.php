<?php
require_once '../models/helper.php';
require_once '../models/baogia.php';

// Request parameters
$baogiaid = (isset($_POST['id'])) ? $_POST['id'] : '';
$nguyennhan = (isset($_POST['nguyennhan'])) ? $_POST['nguyennhan'] : '';
$note = (isset($_POST['note'])) ? $_POST['note'] : '';

// Initial pagging data
$baogia = new baogia();
if ((! empty($baogiaid)) && (! empty($nguyennhan))) {
    $result = $baogia->close($baogiaid, $nguyennhan, $note);
}
if ($result) {
    $output = array (
            'result' => 200,
            'count' => 0
    );
} else {
    $output = array (
            'result' => 500,
            'count' => 0
    );
}
echo json_encode ( $output );
