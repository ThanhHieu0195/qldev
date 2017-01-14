<?php
//++ REQ20120915_BinhLV_N
require_once '../config/constants.php';

if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT)
    {
        case 'development':
            ini_set('display_errors', 1);
        break;
    
        case 'testing':
        case 'production':
            ini_set('display_errors', 0);
        break;

        default:
            exit('The application environment is not set correctly.');
    }
}
//-- REQ20120915_BinhLV_N
?>