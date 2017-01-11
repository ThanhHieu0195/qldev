<?php 

  require_once '../part/common_start_page.php';
	$output = array();
	$output['result'] = 0;
	$output['data'] = array();
	if (isset($_GET['getcoupon'])) {
		if (isset($_GET['group_id'])) {
			require_once "../models/coupon.php";
			$group_id = $_GET['group_id'];
                        error_log ("Add new " . $group_id, 3, '/var/log/phpdebug.log');
			$model = new coupon();
			$list_coupon = $model->get_list_coupon_for_guest($group_id);
			if (count($list_coupon) >= 1) {
				$output['result'] = 1;
				$output['data'] = $list_coupon;
			} 
		}
	}

	if (isset($_POST['sendsms'])) {
       $smsnumber = $_POST['dienthoaisms'];
       $smsMessage = $_POST['smstemplate'];
       if ($smsnumber) {
           $url = "http://center.fibosms.com/service.asmx/SendMaskedSMS?clientNo=CL6409&clientPass=TMAnthai3&senderName=NhiLong.com&phoneNumber=" . $smsnumber;
           $ch = curl_init();
           $smsMessage=curl_escape($ch,$smsMessage);
           $url .= "&smsMessage=" . $smsMessage . "&smsGUID=1&serviceType=4929";
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_HEADER, 0);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           curl_setopt($ch, CURLOPT_TIMEOUT, '15');
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
           curl_setopt($ch, CURLOPT_VERBOSE, true);
           $result = curl_exec($ch);
                  
           $output['curl_exec'] = $result; 
           $output['url'] = $url;
          if (strpos($result, "Sending") > 0){ 
               $output['result'] = 1;
           } 
           
           curl_close($ch);
       }
   }

   if (isset($_POST['update'])) {
      $output['result'] = 1;

      if (isset($_POST['marketing'])) {
          $marketing = $_POST['marketing'];
          require_once "../models/marketing.php";
          $model = new marketing();
          $output['result'] = $output['result'] && $model->update($marketing[1], $marketing);
      }

      if (isset($_POST['coupon'])) {
          $coupon = $_POST['coupon'];
          require_once "../models/coupon.php";
          $model = new coupon();
          $output['result'] = $output['result'] && $model->update_status($coupon[0], $coupon[1]);
      }

      if (isset($_POST['guest_event'])) {
        require_once "../models/guest_events.php";
        $guest_event = $_POST['guest_event'];

        $item = new guest_events_entity();

        $item->guest_id = $guest_event[0];
        $item->note = $guest_event[1];
        $item->event_date = date('Y-m-d');
        $item->enable = BIT_TRUE;
        $item->is_event = BIT_FALSE;

        $model = new guest_events();

        $output['result'] = $output['result'] && $model->insert($item);
        if ($output['result']) {
            require_once "../models/guest_responsibility.php";
            $guest_responsibility_entity = new guest_responsibility_entity();
            $guest_responsibility = new guest_responsibility();

            if (empty($guest_responsibility->check_res_exists($guest_event[0]))) {
                $guest_responsibility_entity->guest_id = $guest_event[0];
                $guest_responsibility_entity->employee_id = current_account();
                $output['result'] = $output['result'] && $guest_responsibility->insert($guest_responsibility_entity);
            }

            require_once "../models/guest_development_history.php";
            $guest_development_history = new guest_development_history();
            $guest_development_history_entity = new guest_development_history_entity();
            $guest_development_history_entity->guest_id = $guest_event[0];
            $guest_development_history_entity->note = $guest_event[1];
            $guest_development_history_entity->employee_id = current_account();
            $output['result'] = $output['result'] && $guest_development_history->insert($guest_development_history_entity);
        }

      }
   }

	echo json_encode($output);
 ?>


