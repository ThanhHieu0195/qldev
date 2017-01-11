<?php
require_once '../entities/mail_config.php';
require_once '../part/error_reporting.php';
require_once '../models/config.php';
require_once '../models/database.php';
require_once '../libs/PHPMailer/class.phpmailer.php';
class mail_helper {
    private $config;
    private $mail;
    public $ErrorInfo;
    public function mail_helper() {
        // Get mail settings
        $model = new Config ();
        $this->config = new mail_config ();
        
        $this->config->host = $model->get ( MAIL_HOST );
        $this->config->user_name = $model->get ( MAIL_UID );
        $this->config->password = $model->get ( MAIL_PWD );
        $this->config->timeout = $model->get ( MAIL_TIMEOUT );
        $this->config->from_name = $model->get ( MAIL_FROMNAME );
        
        // Create new mailer
        unset($this->mail);
        $this->mail = $this->createMailer ();
    }
    private function createMailer() {
        // Create new mailer class
        $mail = new PHPMailer ();
        
        $mail->IsSMTP (); // set mailer to use SMTP
		
		//$mail->SMTPSecure = "ssl";
        $mail->Host = $this->config->host; // specify main and backup server
		//$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        $mail->Port       = 25;
		//$mail->SMTPDebug  = 2;
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = $this->config->user_name; // SMTP username
        $mail->Password = $this->config->password; // SMTP password
        $mail->Timeout = $this->config->timeout; // SMTP server timeout in seconds.
        $mail->MailerDebug = false; // Mailer class debugging on or off.
        $mail->Priority = 1; // set email priority to 'High'
        $mail->CharSet = 'utf-8'; // sets the CharSet of the message to 'utf-8'
        
        $mail->From = $this->config->user_name;
        $mail->FromName = $this->config->from_name;
        
        $mail->WordWrap = 80; // set word wrap (in characters)
        $mail->IsHTML ( true ); // set email format to HTML
                                
        // debug($mail);
        return $mail;
    }
    // Send mail with specificed data
    // Format: 'to' => array('email' =>, 'name' =>), 'body' =>
    public function Send($data, $subject = '') {
        if (! isset ( $this->mail )) {
           $this->mail = $this->createMailer ();
        }
        
        $this->mail->ClearAddresses ();
        if (empty($subject))
            $this->mail->Subject = sprintf ( "Thong bao cong viec moi #%s", uniqid ( '', false ) );
        else
            $this->mail->Subject = $subject;
        $this->mail->AddAddress ( $data ['to'] ['email'], $data ['to'] ['name'] );
        $this->mail->Body = $data ['body'];
        $result = $this->mail->Send ();
        $this->ErrorInfo = $this->mail->ErrorInfo;
        print_r($this->ErrorInfo);
        
        return $result;
    }
	 public function Send_new_customer($data, $subject = '') {
        if (! isset ( $this->mail )) {
           $this->mail = $this->createMailer ();
        }
        
        $this->mail->ClearAddresses ();
        if (empty($subject))
            $this->mail->Subject = sprintf ( "Thong bao cong viec moi #%s", uniqid ( '', false ) );
        else
            $this->mail->Subject = $subject;
        $this->mail->AddAddress ( $data ['to'] ['email'], $data ['to'] ['name'] );
		foreach($data ['toarray'] as $email => $name)
{
   		 $this->mail->AddAddress($email, $name);
}
        $this->mail->Body = $data ['body'];
        
        $result = $this->mail->Send ();
        $this->ErrorInfo = $this->mail->ErrorInfo;
        
        return $result;
    }
}
/* End of file */
