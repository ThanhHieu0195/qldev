
<?php 
/*----------  Sử lý ajax  ----------*/
	if ( !isset($_GET['action']) ) die;
    require_once '../config/constants.php';
	$action = $_GET['action'];
	$do = "ajaxserver.php";
	if ( isset($_REQUEST['do']) ) {
		$do = $_REQUEST['do'];
	}

	require_once $action."/".$do;
 ?>