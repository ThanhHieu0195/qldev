<?php
//++ REQ20120508_BinhLV_M
if(isset ($_GET['url']))
    $location = 'location: view/login.php?url=' . urlencode($_GET['url']);
else
    $location = 'location: view/login.php';
header($location);
exit();
//-- REQ20120508_BinhLV_M
?>