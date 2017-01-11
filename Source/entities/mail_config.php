<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class mail_config {
    public $host;
    public $user_name;
    public $password;
    public $timeout;
    public $from_name;
    public function mail_config() {
        $this->timeout = MAIL_DFT_TIMEOUT;
        $this->from_name = '';
    }
}