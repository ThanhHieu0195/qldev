<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
require_once '../models/database.php';
require_once '../models/task.php';
require_once '../models/equipment_assign.php';
require_once '../models/donhang.php';
require_once '../models/upload.php';
require_once '../models/working_plan.php';
require_once '../models/guest_events.php';
require_once '../models/finance_token.php';
require_once '../models/trahang.php';
require_once '../models/orders_question_result.php';

// Class
class dask_board extends database {
    
    // Dem so luong cong viec theo tung loai cua mot account
    // Ket qua tra ve: assign_to_me => X, assign_by_me => Y, assign_by_me_finished => Z
    public function task_count_by_account($account) {
        $output = array (
                'assign_to_me' => 0,
                'assign_by_me' => 0,
                'assign_by_me_finished' => 0 
        );
        
        // assign_to_me
        $is_finished = BIT_FALSE;
        $sql = "SELECT COUNT(`task_id`) AS num FROM `task`
        WHERE (`assign_to` = '{$account}') AND (`is_finished` = {$is_finished}) ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['assign_to_me'] = $array ['num'];
        }
        
        // assign_by_me
        $is_finished = BIT_FALSE;
        $sql = "SELECT COUNT(`task_id`) AS num FROM `task`
        WHERE (created_by = '{$account}') AND (assign_to <> '{$account}') AND (is_finished = {$is_finished}) ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['assign_by_me'] = $array ['num'];
        }
        
        // assign_by_me_finished
        $is_finished = BIT_TRUE;
        $rank = TASK_RANK_NONE;
        $sql = "SELECT COUNT(`task_id`) AS num FROM `task`
        WHERE(created_by = '{$account}') AND (is_finished = {$is_finished}) AND (rank = {$rank}) ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['assign_by_me_finished'] = $array ['num'];
        }
        
        return ( object ) $output;
    }
    
    // Dem so luong dung cu duoc doi tu nguoi nay sang nguoi khac can approve
    public function equipment_assign_count_of_reassign($assign_to) {
        $status = EQUIPMENT_NEW;
        $sql = "SELECT COUNT(uid) AS num FROM `equipment_assign` WHERE (assign_to_new = '{$assign_to}') AND (status = '{$status}') ;";
        // debug($sql);
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            return $array ['num'];
        }
        
        return 0;
    }
    
    // Dem so luong don hang can approve
    // Ket qua tra ve: total => X, order => Y, delivered => Z
    public function donhang_count_of_unapprove() {
        $output = array (
                'total' => 0,
                'order' => 0,
                'delivered' => 0 
        );
        
        // order
        $approved = donhang::$UNAPPROVED;
        $trangthai = donhang::$CHO_GIAO;
        $sql = "SELECT COUNT(`madon`) AS num FROM `donhang`
        WHERE (`trangthai` = {$trangthai}) AND (`approved` = {$approved}) ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['order'] = $array ['num'];
        }
        
        // order
        $approved = donhang::$UNAPPROVED;
        $trangthai = donhang::$DA_GIAO;
        $sql = "SELECT COUNT(`madon`) AS num FROM `donhang`
        WHERE (`trangthai` = {$trangthai}) AND (`approved` = {$approved}) ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['delivered'] = $array ['num'];
        }
        
        $output ['total'] = $output ['order'] + $output ['delivered'];
        return ( object ) $output;
    }
    
    // Dem so luong don hang can cham soc dac biet
    // Ket qua tra ve: total => X
    public function donhang_count_of_special() {
        $output = array (
                'total' => 0 
        );
        
        // total
        $where = sprintf ( " (support = '%s') AND (approved = '%s')", donhang::$SUPPORT_MONITOR, donhang::$APPROVED );
        $sql = "SELECT COUNT(`madon`) AS num FROM `donhang`
                WHERE {$where} ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['total'] = $array ['num'];
        }
        
        return ( object ) $output;
    }
    
    // Dem so luong file/san pham can approve
    // Ket qua tra ve: files => X, items => Y
    public function upload_count_of_unapprove() {
        $output = array (
                'files' => 0,
                'items' => 0 
        );
        
        // files
        $approved = BIT_FALSE;
        $sql = "SELECT COUNT(`id`) AS num FROM `upload`
        WHERE (`approved` = {$approved}) ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['files'] = $array ['num'];
        }
        
        // items
        $sql = "SELECT COUNT(`id`) AS num FROM `upload_detail` ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['items'] = $array ['num'];
        }
        
        return ( object ) $output;
    }
    
    // Dem so luong ghi nhan/dong gop theo tung loai cua mot account
    // Ket qua tra ve: created => X, assigned => Y
    public function rewards_penalty_count_by_account($account, $top_days = 0) {
        $output = array (
                'created' => 0,
                'assigned' => 0 
        );
        
        // created
        $approved = BIT_TRUE;
        $sql = "SELECT COUNT(`rewards_uid`) AS num FROM `rewards_penalty` 
	            WHERE (approved = {$approved}) AND (created_by = '{$account}') ";
        if ($top_days > 0) {
            $sql .= " AND (DATEDIFF(CURRENT_TIMESTAMP(), created_date) <= {$top_days})";
        }
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['created'] = $array ['num'];
        }
        
        // assigned
        $approved = BIT_TRUE;
        $sql = "SELECT COUNT(`rewards_uid`) AS num FROM `rewards_penalty` 
	            WHERE (approved = {$approved}) AND (assign_to = '{$account}') ";
        if ($top_days > 0) {
            $sql .= " AND (DATEDIFF(CURRENT_TIMESTAMP(), created_date) <= {$top_days})";
        }
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['assigned'] = $array ['num'];
        }
        
        return ( object ) $output;
    }
    
    // Dem so luong ghi nhan/dong gop can approve
    public function rewards_penalty_count_for_unapprove() {
        $count = 0;
        
        $approved = BIT_FALSE;
        $sql = "SELECT COUNT(`rewards_uid`) AS num FROM `rewards_penalty` WHERE (approved = {$approved})";
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $count = $array ['num'];
        }
        
        return $count;
    }
    
    // Dem so luong lich lam viec/request nghi phep can approve
    public function working_calendar_count_for_unapprove() {
        $output = array (
                'plan' => 0,
                'leave_days_add' => 0,
                'leave_days_change' => 0 
        );
        
        $plan_model = new working_plan ();
        $plan_model->delete_empty_plans ();
        
        // plan
        $approved = BIT_FALSE;
        $sql = "SELECT COUNT(`plan_uid`) AS num FROM `working_plan` WHERE (approved = '{$approved}')";
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['plan'] = $array ['num'];
        }
        
        // leave_days_add
        $approved = BIT_FALSE;
        $sql = "SELECT COUNT(`uid`) AS num FROM `working_leave_days` WHERE (approved = '{$approved}') AND (old_date IS NULL)";
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['leave_days_add'] = $array ['num'];
        }
        
        // leave_days_change
        $approved = BIT_FALSE;
        $sql = "SELECT COUNT(`uid`) AS num FROM `working_leave_days` WHERE (approved = '{$approved}') AND (old_date IS NOT NULL)";
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['leave_days_change'] = $array ['num'];
        }
        
        $this->disconnect ();
        
        return $output;
    }
    
    // Dem so luong phieu chuyen kho can xu ly
    public function count_ingoing_swapping($account, $status = SWAPPING_NEW) {
        $output = array (
                'total' => 0 
        );
        
        // Additional condition
        $additional = "";
        if (! is_admin ( $account )) {
            $nv = new nhanvien ();
            $obj = $nv->detail ( current_account () );
            $to_store = ($obj != NULL) ? $obj->macn : "";
            
            $additional = " AND (to_store = '{$to_store}')";
        } else {
            $created_by = current_account ();
            $additional = " AND (created_by <> '{$created_by}')";
        }
        
        // total
        $sql = "SELECT COUNT(`swap_uid`) AS num FROM `items_swapping` WHERE (`status` = '{$status}') $additional";
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['total'] = $array ['num'];
        }
        
        $this->disconnect ();
        
        return ( object ) $output;
    }
    
    // Create daskboard content
    public function create_daskboard_content($group) {
        $title = '';
        $content = '';
        $account = current_account ();
        
        // Processing
        switch ($group) {
            case G_TASK : // Quản lý công việc
                if (verify_access_right ( $account, G_TASK, KEY_GROUP )) {
                    // Title
                    $title = "Quản lý công việc";
                    // Content
                    $obj = $this->task_count_by_account ( $account );
                    $content = "<p>
                                Danh sách công việc của bạn gồm có:<br />
                                &nbsp;&nbsp;<b>•</b> <span style='color: blue'><b>{$obj->assign_to_me}</b></span> công việc bạn được giao<br />
                                &nbsp;&nbsp;<b>•</b> <span style='color: #ff6600'><b>{$obj->assign_by_me}</b></span> công việc bạn đang giao cho người khác làm<br />
                                &nbsp;&nbsp;<b>•</b> <span style='color: blueviolet'><b>{$obj->assign_by_me_finished}</b></span> công việc bạn đã giao cho người khác và họ đã làm xong – cần đánh giá<br />
                                <small><a target='_blank' href='../task/task-list.php' class='remove-link' title='Danh sách công việc'>Xem chi tiết</a></small>
                            </p>";
                }
                break;
            
            case G_EQUIPMENT : // Quản lý dụng cụ
                if (verify_access_right ( $account, F_EQUIPMENT_ASSIGNED_LIST )) {
                    // Title
                    $title = "Quản lý dụng cụ";
                    // Content
                    $count = $this->equipment_assign_count_of_reassign ( $account );
                    if ($count != 0) {
                        $content = "<p>
                                    Bạn vừa mới được phân công chịu trách nhiệm <b style='color: blue;'>{$count}</b> dụng cụ mới. Vui lòng kiểm tra và xác nhận các dụng cụ này!
                                    <small><a target='_blank' href='../equipment/re-assign-list.php' class='remove-link' title='Dụng cụ mới nhận'>Xem chi tiết</a></small>
                                </p>";
                    } else {
                        $content = "<p>
                                    Không có dụng cụ mới được phân công.
                                    <br />Xem danh sách các dụng cụ do bạn chịu trách nhiệm <small><a target='_blank' href='../equipment/assigned-list.php' class='remove-link' title='Danh sách dụng cụ giao cho bạn'>tại đây</a></small>.
                                </p>";
                    }
                }
                break;
            
            case G_ORDERS : // Đơn hàng
                if (verify_access_right ( $account, array (
                        F_ORDERS_RESERVATION_LIST,
                        F_ORDERS_SPECIAL_LIST 
                ) )) {
                    $t = "";
                    $z = "";
                    // Title
                    $title = "Đơn hàng";
                    
                    if (verify_access_right ( $account, F_ORDERS_RESERVATION_LIST )) {
                        $obj = $this->donhang_count_of_unapprove ();
                        if ($obj->total > 0) {
                            $t = "<p>
                                        Có tất cả <b style='color: blue;'>{$obj->total}</b> đơn hàng cần approve, trong đó:<br />
                                        &nbsp;&nbsp;<b>•</b> <span style='color: #ff6600'><b>{$obj->order}</b></span> đơn hàng có trạng thái chờ giao<br />
                                        &nbsp;&nbsp;<b>•</b> <span style='color: blueviolet'><b>{$obj->delivered}</b></span> đơn hàng có trạng thái đã giao<br />
                                        <small><a target='_blank' href='../orders/reservationlist.php' class='remove-link' title='Duyệt thông tin đơn hàng'>Xem chi tiết</a></small>
                                    </p>";
                        } else {
                            $t = "<p>
                                        Không có đơn hàng cần approve.
                                    </p>";
                        }
                    }
                    
                    if (verify_access_right ( $account, F_ORDERS_SPECIAL_LIST )) {
                         
                        $obj = $this->donhang_count_of_special ();
                        if ($obj->total > 0) {
                            $z = "<p>
                                    Có tất cả <b style='color: blue;'>{$obj->total}</b> đơn hàng cần theo dõi đặc biệt
                                    <small><a target='_blank' href='../orders/special_list.php' class='remove-link' title='Đơn hàng cần theo dõi đặc biệt'>Xem chi tiết</a></small>
                                </p>";
                        } else {
                            $z = "<p>
                                    Không có đơn hàng đơn hàng cần theo dõi đặc biệt.
                                  </p>";
                        }
                    }

                    if (verify_access_right ( $account, F_RETURN_APPROVE )) {
                        $th = new trahang();
                        $num = $th->dashboard();
                        if ($num > 0) {
                            $r = "<p>
                                     Có tất cả <b style='color: blue;'>{$num}</b> phiếu trả hàng cần approve
                                    <small><a target='_blank' href='../orders/return_approve_list.php' class='remove-link' title='Phiếu trả hàng cần approve'>Xem chi tiết</a></small>
                                </p>";
                        } else {
                            $r = "<p>
                                    Không có phiếu trả hàng cần approve.
                                  </p>";
                        }
                    }
                    
                    // Content
                    $content = $t . $z . $r;
                }
                break;
            
            case G_ITEMS : // Quản lý sản phẩm - Quản lý chuyển hàng
                $t = "";
                $z = "";
                // Title
                $title = "Quản lý sản phẩm";
                
                if (verify_access_right ( $account, F_ITEMS_UPLOAD )) {
                    // Content
                    $obj = $this->upload_count_of_unapprove ();
                    if ($obj->files > 0) {
                        $t = "<p>
                                        Có tất cả <b style='color: blue;'>{$obj->files}</b> file (gồm có <b style='color: blue;'>{$obj->items}</b> sản phẩm) được upload cần approve.
                                        <small><a target='_blank' href='../items/upload.php' class='remove-link' title='Quản lý upload sản phẩm'>Chi tiết</a></small>
                                    </p>";
                    } else {
                        $t = "<p>
                                        Không có sản phẩm mới upload cần approve.
                                    </p>";
                    }
                }
                
                if (verify_access_right ( $account, F_STORES_SWAP )) {
                    $obj = $this->count_ingoing_swapping ( $account );
                    
                    if ($obj->total > 0) {
                        $z = "<p>
                                Có tất cả <b style='color: blue;'>{$obj->total}</b> phiếu chuyển hàng đến đang chờ xử lý.
                                <small><a target='_blank' href='../stores/ingoing-list.php' class='remove-link' title='Danh sách phiếu chuyển hàng đến'>Chi tiết</a></small>
                              </p>";
                    } else {
                        $z = "<p>
                                Không có phiếu chuyển hàng đến cần xử lý.
                              </p>";
                    }
                }
                
                // Content
                $content = $t . $z;
                break;
            
            case G_REWARDS_PENALTY : // Ghi nhận và đóng góp
                if (verify_access_right ( $account, G_REWARDS_PENALTY, KEY_GROUP )) {
                    $t = "";
                    $z = "";
                    // Title
                    $title = "Ghi nhận và đóng góp";
                    
                    // Items counting
                    $top_days = REWARDS_PENALTY_TOP_DAYS;
                    $obj = $this->rewards_penalty_count_by_account ( $account, $top_days );
                    
                    $t = "<p>
                            Trong vòng {$top_days} ngày vừa qua, có tất cả:<br />
                            &nbsp;&nbsp;<b>•</b> <span style='color: #ff6600'><b>{$obj->created}</b></span> ghi nhận/đóng góp do bạn tạo ra";
                    // Created link
                    if ($obj->created > 0) {
                        $t .= "<small><a target='_blank' href='../rewards_penalty/created-list.php?top_days={$top_days}' class='remove-link' title='Ghi nhận bạn đã tạo'>Xem</a></small>";
                    }
                    $t .= "<br />
                            &nbsp;&nbsp;<b>•</b> <span style='color: blueviolet'><b>{$obj->assigned}</b></span> ghi nhận/đóng góp về bạn";
                    // Assigned link
                    if ($obj->assigned > 0) {
                        $t .= "<small><a target='_blank' href='../rewards_penalty/assigned-list.php?top_days={$top_days}' class='remove-link' title='Ghi nhận về bạn'> Xem</a></small>";
                    }
                    $t .= "</p>";
                    
                    // Un-approved list
                    if (verify_access_right ( $account, F_REWARDS_PENALTY_UNAPPROVED_LIST )) {
                        $count = $this->rewards_penalty_count_for_unapprove ();
                        
                        if ($count > 0) {
                            $z = "<p>
                                    Có tất cả <b style='color: blue;'>{$count}</b> ghi nhận/đóng góp được tạo mới.
                                    <small><a target='_blank' href='../rewards_penalty/unapproved-list.php' class='remove-link' title='Approve ghi nhận/đóng góp'>Approve</a></small>
                                   </p>";
                        } else {
                            $z = "<p>
                                    Không có ghi nhận/đóng góp cần approve.
                                  </p>";
                        }
                    }
                    
                    // Content
                    $content = $t . $z;
                }
                break;
            
            case G_WORKING_CALENDAR : // Quản lý lịch làm việc
                $t = "";
                $z = "";
                
                // View calendar
                if (verify_access_right ( $account, F_WORKING_CALENDAR_CALENDAR )) {
                    $z = "<p>
                            <img src='../resources/images/icons/calendar_16.png' alt='calendar'>
                            Xem lịch làm việc mới nhất <small><a target='_blank' href='../working_calendar/calendar.php' class='remove-link' title='Lịch làm việc'>tại đây</a></small>
                          </p>";
                }
                
                // Approve count
                if (verify_access_right ( $account, array (
                        F_WORKING_CALENDAR_APPROVE_CALENDAR,
                        F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD,
                        F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_CHANGE 
                ) )) {
                    $obj = $this->working_calendar_count_for_unapprove ();
                    
                    if ($obj ['plan'] > 0 || $obj ['leave_days_add'] > 0 || $obj ['leave_days_change'] > 0) {
                        $t = "<p>
                                    Có tất cả:<br />";
                        // Approve calendar
                        if ($obj ['plan'] > 0 && verify_access_right ( $account, F_WORKING_CALENDAR_APPROVE_CALENDAR )) {
                            $t .= "&nbsp;&nbsp;<b>•</b> <span style='color: blue'><b>{$obj['plan']}</b></span> lịch làm việc được tạo mới <small><a target='_blank' href='../working_calendar/approve-calendar.php' class='remove-link' title='Approve lịch làm việc'>Approve</a></small><br />";
                        }
                        // Approve leave days
                        if ($obj ['leave_days_add'] > 0 && verify_access_right ( $account, F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD )) {
                            $t .= "&nbsp;&nbsp;<b>•</b> <span style='color: #ff6600'><b>{$obj['leave_days_add']}</b></span> request xin nghỉ thêm <small><a target='_blank' href='../working_calendar/approve-leave-days-add.php' class='remove-link' title='Approve xin nghỉ thêm'>Approve</a></small><br />";
                        }
                        // Approve leave days change
                        if ($obj ['leave_days_change'] > 0 && verify_access_right ( $account, F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_CHANGE )) {
                            $t .= "&nbsp;&nbsp;<b>•</b> <span style='color: blueviolet'><b>{$obj['leave_days_change']}</b></span> request dời ngày nghỉ <small><a target='_blank' href='../working_calendar/approve-leave-days-change.php' class='remove-link' title='Approve dời ngày nghỉ'>Approve</a></small><br />";
                        }
                        $t .= "</p>";
                    } else {
                        $t = "<p>
                                Không có dữ liệu/request cần approve.
                              </p>";
                    }
                }
                
                if (! empty ( $t ) && ! empty ( $z )) {
                    // Title
                    $title = "Quản lý lịch làm việc";
                    
                    // Content
                    $content = $t . $z;
                }
                break;
            
            case G_GUEST_DEVELOPMENT : // Phát triển khách hàng
                if (verify_access_right ( $account, G_GUEST_DEVELOPMENT, KEY_GROUP )) {
                    // Title
                    $title = "Phát triển khách hàng";
                    
                    /* Content */
                    // Get input data
                    $format = 'Y-m-d';
                    $start = current_timestamp ( $format );
                    $end = current_timestamp ( $format );
                    
                    // DB model
                    $events_model = new guest_events ();
                    
                    // Get list event by time
                    $employee_id = '';
                    if (! verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_LIST_ALL )) {
                        $employee_id = $account;
                    }
                    $list = $events_model->statistic_amount_by_time ( $start, $end, $employee_id );
                    if (is_array ( $list ) && count ( $list ) > 0) {
                        
                        // Get all events
                        if (empty ( $employee_id )) {
                            $content = "<p>Danh sách số lượng khách cần liên hệ hôm nay gồm có:<br>";
                            
                            foreach ( $list as $items ) {
                                foreach ( $items ['employees'] as $e ) {
                                    $total = count ( $e ['guests'] );
                                    
                                    $content .= "&nbsp;&nbsp;<b>•</b> <span style='color: blue'><b>{$e ['name']}</b></span>: <span style='color: #ff6600'><b>{$total}</b></span> khách hàng<br />";
                                }
                            }
                            
                            $content .= "</p>";
                        } else { // Get events by employee
                            foreach ( $list as $items ) {
                                foreach ( $items ['employees'] as $e ) {
                                    $total = count ( $e ['guests'] );
                                    
                                    $content = "<p>Hôm nay bạn cần liên hệ với <span style='color: blue'><b>{$total}</b></span> khách hàng</p>";
                                }
                            }
                        }
                    } else {
                        $content = "Không có khách hàng cần liên hệ.";
                    }
                    
                    $content .= "<p>
                                    <img src='../resources/images/icons/calendar_16.png' alt='calendar'>
                                    Xem lịch sự kiện - liên hệ khách hàng <small><a target='_blank' href='../guest_development/calendar.php' class='remove-link' title='Lịch sự kiện - liên hệ khách hàng'>tại đây</a></small>
                                </p>";
                }
                break;
            
            case G_FINANCE : // Quản lý tài chính
                $t = "";
                $z = "";
                // Title
                $title = "Quản lý tài chính";
                
                // Content
                if (verify_access_right ( $account, F_FINANCE_APPROVE )) {
                    $model = new finance_token ();
                    $count = $model->count_for_unapproved ();
                    
                    if ($count > 0) {
                        $content = "<p>
                                        Có tất cả <b style='color: blue;'>{$count}</b> phiếu thu/chi cần approve.
                                        <small><a target='_blank' href='../finance/approve-list.php' class='remove-link' title='Danh sách phiếu thu/chi cần approve'>Chi tiết</a></small>
                                    </p>";
                    } else {
                        $content = "<p>
                                        Không có phiếu thu/chi cần approve.
                                    </p>";
                    }
                }
                break;

            case G_CSKH : // Thong ke cau hoi
                // Title
                $Question = array();
                $title = "Chăm sóc khách hàng:";
                $model = new orders_question_result();
                $month = current_timestamp ( 'm' );
                $year = current_timestamp ( 'Y' );
                $cskh = $model->dashboard_cskh($year, $month);
                if (is_array($cskh)) {
                foreach ( $cskh as $row ) {
                    if (! (in_array($row['question'], $Question))) {
                        array_push($Question, $row['question']);
                    }
                }
                $content = "<p>";
                $ind = 1;
                foreach ($Question as $q) {
                    $content .= $ind . ". " . $q . ":<br>";
                    $ind++;
                    //$content.= '<table style="width:100%"><tr>';
                    //for ($m=1; $m<$month; $m++) {
                    //    $content.= '<th> T' . $m . '</th>';
                    //}
                    //$content.= '</tr></table>';
                    //for ($m=1; $m<$month; $m++) {
                    foreach ($cskh as $row) {
                        if (strcmp($row['question'],$q)==0) { // && ($row['month']==$m)) {
                            $content.="&nbsp;&nbsp;&nbsp;<b>•</b> " . $row['answer'] . ":  <b style='color: blue;'>" . $row['total']  . "</b><br>";
                        }
                    }
                    //}
                }
                } else {
                    $content = "Chưa có thống kê";
                }
                break;

        }
        
        // Output result
        return array (
                'title' => $title,
                'content' => $content 
        );
    }
}

/* End of file */
