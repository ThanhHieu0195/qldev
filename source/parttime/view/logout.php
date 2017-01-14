<?php
require_once '../part/common_start_page.php';

// Clear the session
session_unset();
session_destroy();

// Redirect to login page
redirect("../index.php");

require_once '../part/common_end_page.php';
?>
