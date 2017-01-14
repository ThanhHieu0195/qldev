<?php
//++ REQ20120915_BinhLV_N
$type = isset($_GET['type']) ? $_GET['type'] : '';
$term = isset($_GET['term']) ? $_GET['term'] : '';

switch($type)
{
    default:
    case 'guest':
        require_once '../models/khach.php';
        
        $db = new khach();
        echo $db->get_top($term, 10, false);
    break;
    
    case 'district':
        require_once '../models/quan.php';
        
        $db = new quan();
        echo $db->get_top($term, 10);
    break;
    
    case 'guesttype':
    	require_once '../models/nhomkhach.php';
    
    	$db = new nhomkhach();
    	echo $db->get_top($term, 10);
    	break;
    	
    case 'task':
        require_once '../models/task_template.php';
    
        $db = new task_template();
        echo $db->get_top($term, 10);
        break;

    case 'guest_development':
        require_once '../models/khach.php';
        
        $db = new khach();
        echo $db->get_top($term, 5, false);
    break;
}
//-- REQ20120915_BinhLV_N
?>