    <script src="../resources/scripts/SIPml-api.js" type="text/javascript"> </script>
    <script type="text/javascript">
            var ext = "<?php echo $_SESSION["ext"]; ?>";
            if (ext.length > 0) {
            var IP = "115.79.57.172";
            //var IP = "192.168.1.200";
            var sipStack;
            var eventsListener = function(e){
                if(e.type == 'started'){
                    login();
                }
                else if(e.type == 'i_new_message'){ // incoming new SIP MESSAGE (SMS-like)
                    acceptMessage(e);
                }
                else if(e.type == 'i_new_call'){ // incoming audio/video call
                    acceptCall(e);
                }
            }
            
            function createSipStack(){
                sipStack = new SIPml.Stack({
                        realm: IP, // mandatory: domain name
                        impi: ext, // mandatory: authorization name (IMS Private Identity)
                        impu: 'sip:' + ext + '@' + IP, // mandatory: valid SIP Uri (IMS Public Identity)
                        password: '1234ab', // optional
                        display_name: 'Test', // optional
                        enable_rtcweb_breaker: false, // optional
                        outbound_proxy_url: 'udp://' + IP + ':5060', // optional
                        events_listener: { events: '*', listener: eventsListener }, // optional: '*' means all events
                        sip_headers: [ // optional
                                { name: 'User-Agent', value: 'IM-client/OMA1.0 sipML5-v1.0.0.0' },
                                { name: 'Organization', value: 'Nhilong.com' }
                        ]
                    }
                );
            }

            var readyCallback = function(e){
                createSipStack(); // see next section
            };
            var errorCallback = function(e){
                console.error('Failed to initialize the engine: ' + e.message);
            }
            SIPml.init(readyCallback, errorCallback);
            sipStack.start();
            var registerSession;
            var login = function(){
                registerSession = sipStack.newSession('register', {
                    events_listener: { events: '*', listener: eventsListener } // optional: '*' means all events
                });
                registerSession.register();
            }
            var acceptCall = function(e){
                var callerID = e.newSession.o_session.o_uri_from.s_user_name;
                if (callerID.length > 8) {
                    console.log(callerID);
                    window.open("http://thamthonhiky.net/hethongdev/popup/makhach.php?phone=" + callerID, '_blank');
                }
            }
            }
    </script>
<div id="sidebar">
    <div id="sidebar-wrapper">

        <h1 id="sidebar-title"><a href="#">Admin</a></h1>

        <img id="logo" width="221px" height="40px" src="../resources/images/nhilong.png" alt="Admin logo" />
        
        <div id="profile-links">
            Xin chào, <a href="../user/info.php"><?php echo current_account(TENNV); ?></a>
            <br />
            <br />
            <a href="../user/changepassword.php" title="Đổi mật khẩu">Đổi mật khẩu</a> | <a href="../view/logout.php" class="logout" title="Thoát ra">Thoát ra</a>
        </div>

        <?php 
            // Get function list of current account
            $arr = function_list_of_account(current_account());
        ?>
        <ul id="main-nav">
            <?php if (in_array(G_NOTIFICATIONS, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_NOTIFICATIONS); ?>" href="#">Dashboard</a>
                    <ul>
                        <?php if (in_array(F_NOTIFICATIONS_DASHBOARD, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_NOTIFICATIONS_DASHBOARD); ?>" href="../employees/dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_NEWS, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_NEWS); ?>" href="#">Thông tin công ty</a>
                    <ul>
                        <?php 
                            require_once '../models/news_group.php';
                            
                            // Get data from database
                            $model = new news_group();
                            $tmp = $model->list_group();
                            $groups = array();
                            
                            // Create group list data
                            if ($tmp != NULL) {
                                /* Use for getting css class of current menu item */
                                $news_group_id = '';
                                $user_data = get_site_function(KEY_USER_DATA);
                                if (is_array($user_data) && isset($user_data['news_group_id'])) {
                                    $news_group_id = $user_data['news_group_id'];
                                }
                                // Create group list with css data
                                foreach ($tmp as $z) {
                                    $groups[] = array('css' => ($z->group_id == $news_group_id) ? get_item_css(F_NEWS_VIEW, FALSE) : '', 
                                                      'title' => ($z->note != "") ? $z->note : $z->name, 
                                                      'group_id' => $z->group_id, 
                                                      'name' => $z->name);
                                }
                            }
                            // Create menu items
                            if (count($groups) > 0) {
                                foreach ($groups as $g):
                        ?>
                                <li><a class="<?php echo $g['css']; ?>" href="../news_management/news-list.php?i=<?php echo $g['group_id']; ?>" title="<?php echo $g['title']; ?>"><?php echo $g['name']; ?></a></li>
                        <?php
                                endforeach;
                            }
                        ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_VIEW, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_VIEW); ?>" href="#">Bán hàng</a>
                    <ul>
                        <?php if (in_array(F_VIEW_COUPON_VERIFY, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_VIEW_COUPON_VERIFY); ?>" href="../view/coupon-verify.php">Verify coupon</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_VIEW_STORE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_VIEW_STORE); ?>" href="../view/store.php">Hàng có sẵn trong kho</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_VIEW_ORDER, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_VIEW_ORDER); ?>" href="../view/order.php">Đặt hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_VIEW_CART, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_VIEW_CART); ?>" href="../view/cart.php">Xem giỏ hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_VIEW_TRADE_ADMIN, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_VIEW_TRADE_ADMIN); ?>" href="../view/tradeadmin.php">Doanh thu hàng ngày</a></li>
                        <?php elseif (in_array(F_VIEW_TRADE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_VIEW_TRADE); ?>" href="../view/trade.php">Doanh thu hàng ngày</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_GUEST_DEVELOPMENT, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_GUEST_DEVELOPMENT); ?>" href="#">Phát triển khách hàng</a>
                    <ul>
                        <?php 
                            if (in_array(F_GUEST_DEVELOPMENT_ADD_NEW, $arr[KEY_FUNCTION]) 
                                || in_array(F_GUEST_DEVELOPMENT_ADD_FROM_DB, $arr[KEY_FUNCTION])):
                                    $functions = array(F_GUEST_DEVELOPMENT_ADD_NEW, F_GUEST_DEVELOPMENT_ADD_FROM_DB);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../guest_development/add-new.php">Thêm khách hàng cần phát triển</a></li>
                        <?php endif; ?>
                        
                        <?php if (in_array(F_GUEST_DEVELOPMENT_EVENTS, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GUEST_DEVELOPMENT_EVENTS); ?>" href="../guest_development/calendar.php">Lịch sự kiện - liên hệ</a></li>
                        <?php endif; ?>

                        
                        <?php 
                            if (in_array(F_GUEST_DEVELOPMENT_LIST_ASSIGNED, $arr[KEY_FUNCTION]) 
                                || in_array(F_GUEST_DEVELOPMENT_LIST_ALL, $arr[KEY_FUNCTION]) 
                                || in_array(F_GUEST_DEVELOPMENT_LIST_CANCELLED, $arr[KEY_FUNCTION]) 
                                || in_array(F_GUEST_DEVELOPMENT_LIST_FAVOURITE, $arr[KEY_FUNCTION]) 
                               ):
                                    $functions = array(F_GUEST_DEVELOPMENT_LIST_ASSIGNED, F_GUEST_DEVELOPMENT_LIST_ALL, F_GUEST_DEVELOPMENT_LIST_CANCELLED, F_GUEST_DEVELOPMENT_LIST_FAVOURITE);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../guest_development/list-menu.php">Danh sách</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            if (in_array(F_GUEST_DEVELOPMENT_STATISTIC_UPDATED, $arr[KEY_FUNCTION]) 
                                || in_array(F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED, $arr[KEY_FUNCTION]) 
                               ):
                                    $functions = array(F_GUEST_DEVELOPMENT_STATISTIC_UPDATED, F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../guest_development/statistic-menu.php">Thống kê</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_FINANCE, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_FINANCE); ?>" href="#">Quản lý tài chính</a>
                    <ul>
                        <?php 
                            if (in_array(F_FINANCE_CREATE_RECEIPT, $arr[KEY_FUNCTION]) 
                                || in_array(F_FINANCE_CREATE_PAYMENT, $arr[KEY_FUNCTION])):
                                    $functions = array(F_FINANCE_CREATE_RECEIPT, F_FINANCE_CREATE_PAYMENT);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../finance/create-menu.php">Tạo phiếu thu - chi</a></li>
                        <?php endif; ?>
                        
                        <?php if (in_array(F_FINANCE_APPROVE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_FINANCE_APPROVE); ?>" href="../finance/approve-list.php">Approve</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_FINANCE_STATISTIC, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_FINANCE_STATISTIC); ?>" href="../finance/statistic.php">Thống kê</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_COUPON, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_COUPON); ?>" href="#">Coupon</a>
                    <ul>
                        <?php if (in_array(F_COUPON_GROUP, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_GROUP); ?>" href="../coupon/coupon-group-list.php">Nhóm coupon</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_GENERATE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_GENERATE); ?>" href="../coupon/coupon-generate.php">Generate coupon</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_ASSIGN_GROUP, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_ASSIGN_GROUP); ?>" href="../coupon/assign-group.php">Assign theo nhóm khách</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_ASSIGN_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_ASSIGN_LIST); ?>" href="../coupon/assign-list.php">Tổng hợp danh sách assign</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_THIRD_USED, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_THIRD_USED); ?>" href="../coupon/third-used-list.php">Coupon giới thiệu</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_USED_STATISTIC, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_USED_STATISTIC); ?>" href="../coupon/used-statistic.php">Thống kê sử dụng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_FREELANCER_STATISTIC_ALL, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_FREELANCER_STATISTIC_ALL); ?>" href="../coupon/freelancer-statistic-list.php">Tổng hợp doanh thu cộng tác viên</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_FREELANCER_ASSIGN, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_FREELANCER_ASSIGN); ?>" href="../coupon/freelancer-assign-list.php">Danh sách chờ sử dụng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_FREELANCER_USED, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_FREELANCER_USED); ?>" href="../coupon/freelancer-assign-list-used.php">Danh sách đã sử dụng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_FREELANCER_EXPIRED, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_FREELANCER_EXPIRED); ?>" href="../coupon/freelancer-assign-list-expired.php">Danh sách hết hạn</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_COUPON_FREELANCER_STATISTIC, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COUPON_FREELANCER_STATISTIC); ?>" href="../coupon/freelancer-statistic.php">Tổng hợp doanh thu</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_ORDERS, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_ORDERS); ?>" href="#">Đơn hàng</a>
                    <ul>
                        <?php if (in_array(F_ORDERS_RESERVATION_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_RESERVATION_LIST); ?>" href="../orders/reservationlist.php">Duyệt thông tin đơn hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ORDERS_ORDER_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_ORDER_LIST); ?>" href="../orders/orderlist.php">Đơn hàng chờ giao</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ORDERS_CASH_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_CASH_LIST); ?>" href="../orders/cashlist.php">Đơn hàng chờ thu tiền</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ORDERS_CASHED_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_CASHED_LIST); ?>" href="../orders/cashed_list.php">Đơn hàng đã thu tiền</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            if (in_array(F_ORDERS_SUPPORT_LIST, $arr[KEY_FUNCTION]) 
                                || in_array(F_ORDERS_SPECIAL_LIST, $arr[KEY_FUNCTION])):
                                    $functions = array(F_ORDERS_SUPPORT_LIST, F_ORDERS_SPECIAL_LIST);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../orders/support_menu.php">Chăm sóc khách hàng</a></li>
                        <?php endif; ?>

                        <?php 
                            if (in_array(F_ORDERS_UNCHECKED_LIST, $arr[KEY_FUNCTION]) 
                                || in_array(F_ORDERS_CHECKED_LIST, $arr[KEY_FUNCTION])):
                                    $functions = array(F_ORDERS_UNCHECKED_LIST, F_ORDERS_CHECKED_LIST);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../orders/check_menu.php">Hậu mãi đơn hàng</a></li>
                        <?php endif; ?>
                        
                        <?php if (in_array(F_ORDERS_ORDER_DELIVERED, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_ORDER_DELIVERED); ?>" href="../orders/orderdelivered.php">Đơn hàng đã giao</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ORDERS_TP, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_TP); ?>" href="../items/tp.php">Sản phẩm cần sản xuất</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ORDERS_DIFFERENCE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_DIFFERENCE); ?>" href="../items/difference.php">Thống kê chênh lệch số lượng</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_ITEMS, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_ITEMS); ?>" href="#">Quản lý sản phẩm</a>
                    <ul>
                        <?php if (in_array(F_ITEMS_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ITEMS_LIST); ?>" href="../items/list.php">Danh sách sản phẩm</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ITEMS_ADD, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ITEMS_ADD); ?>" href="../items/add.php">Thêm sản phẩm</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ITEMS_AUTO_UPLOAD, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ITEMS_AUTO_UPLOAD); ?>" href="../items/autoupload.php">Thêm sản phẩm từ file Excel</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ITEMS_UPLOAD, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ITEMS_UPLOAD); ?>" href="../items/upload.php">Quản lý upload</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ITEMS_TYPE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ITEMS_TYPE); ?>" href="../items/type.php">Loại sản phẩm</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ITEMS_HISTORY, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ITEMS_HISTORY); ?>" href="../items/history.php">Nhật ký nhập xuất hàng</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_EMPLOYEES, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_EMPLOYEES); ?>" href="#">Quản lý nhân viên - thợ</a>
                    <ul>
                        <?php if (in_array(F_EMPLOYEES_ADD_EMPLOYEE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_EMPLOYEES_ADD_EMPLOYEE); ?>" href="../employees/addemployee.php">Thêm nhân viên</a></li>
                        <?php elseif (in_array(F_EMPLOYEES_ADD_FREELANCER, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_EMPLOYEES_ADD_FREELANCER); ?>" href="../employees/addemployee.php?t=freelancer">Thêm cộng tác viên</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_EMPLOYEES_EMPLOYEE_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_EMPLOYEES_EMPLOYEE_LIST); ?>" href="../employees/employee.php">Danh sách nhân viên</a></li>
                        <?php elseif (in_array(F_EMPLOYEES_FREELANCER_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_EMPLOYEES_FREELANCER_LIST) ?>" href="../employees/employee.php?type=freelancer">Danh sách cộng tác viên</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_EMPLOYEES_EMPLOYEE_GROUP, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_EMPLOYEES_EMPLOYEE_GROUP); ?>" href="../employees/employee_group_list.php">Nhóm nhân viên</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_EMPLOYEES_ADD_STAFF, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_EMPLOYEES_ADD_STAFF); ?>" href="../employees/addstaff.php">Thêm thợ làm tranh</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_EMPLOYEES_STAFF_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_EMPLOYEES_STAFF_LIST); ?>" href="../employees/staff.php">Danh sách thợ làm tranh</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_STORES, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_STORES); ?>" href="#">Kho hàng - Chi nhánh</a>
                    <ul>
                        <?php if (in_array(F_STORES_STORE_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_STORES_STORE_LIST); ?>" href="../stores/storelist.php">Danh sách kho hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_STORES_ADD_STORE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_STORES_ADD_STORE); ?>" href="../stores/addstore.php">Thêm kho hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_STORES_SWAP, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_STORES_SWAP); ?>" href="../stores/ingoing-list.php">Quản lý chuyển hàng</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_GUEST, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_GUEST); ?>" href="#">Khách hàng</a>
                    <ul>
                        <?php if (in_array(F_GUEST_ADD_GUEST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GUEST_ADD_GUEST); ?>" href="../guest/addguest.php">Thêm khách hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_GUEST_GUEST_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GUEST_GUEST_LIST); ?>" href="../guest/guestlist.php">Danh sách khách hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_GUEST_GUEST_GROUP, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GUEST_GUEST_GROUP); ?>" href="../guest/group.php">Nhóm khách hàng</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_REPORT, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_REPORT); ?>" href="#">Tổng hợp doanh số</a>
                    <ul>
                        <?php if (in_array(F_REPORT_RPT_BY_GUEST_GROUP, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_REPORT_RPT_BY_GUEST_GROUP); ?>" href="../report/rptbyguestgroup.php">Theo nhóm khách hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_REPORT_RPT_BY_STORE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_REPORT_RPT_BY_STORE); ?>" href="../report/rptbystore.php">Theo kho hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_REPORT_RPT_BY_WORKER, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_REPORT_RPT_BY_WORKER); ?>" href="../report/rptbyworker.php">Theo thợ làm sản phẩm</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_REPORT_RPT_BY_DISTRICT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_REPORT_RPT_BY_DISTRICT); ?>" href="../report/rptbydistrict.php">Theo quận</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_REPORT_RPT_BY_EMPLOYEE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_REPORT_RPT_BY_EMPLOYEE); ?>" href="../report/rptbyemployee.php">Theo nhân viên bán hàng</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_TASK, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_TASK); ?>" href="#">Quản lý công việc</a>
                    <ul>
                        <?php if (in_array(F_TASK_TEMPLATE_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_TASK_TEMPLATE_LIST); ?>" href="../task/template-list.php">Template</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_TASK_CREATE_TASK, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_TASK_CREATE_TASK); ?>" href="../task/create-task.php">Tạo công việc</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_TASK_MY_FINISHED, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_TASK_MY_FINISHED); ?>" href="../task/my-finished-list.php">Công việc đã được đánh giá</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_TASK_LIST_ALL, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_TASK_LIST_ALL); ?>" href="../task/ongoing-list.php">Danh sách</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_TASK_STATISTIC, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_TASK_STATISTIC); ?>" href="../task/statistic-list.php">Thống kê</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_REWARDS_PENALTY, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_REWARDS_PENALTY); ?>" href="#">Ghi nhận và đóng góp</a>
                    <ul>
                        <?php if (in_array(F_REWARDS_PENALTY_ADD_NEW, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_REWARDS_PENALTY_ADD_NEW); ?>" href="../rewards_penalty/add-new.php">Tạo ghi nhận mới</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            if (in_array(F_REWARDS_PENALTY_CREATED_LIST, $arr[KEY_FUNCTION]) 
                                || in_array(F_REWARDS_PENALTY_ASSIGNED_LIST, $arr[KEY_FUNCTION])
                                || in_array(F_REWARDS_PENALTY_UNAPPROVED_LIST, $arr[KEY_FUNCTION])):
                                    $functions = array(F_REWARDS_PENALTY_CREATED_LIST, F_REWARDS_PENALTY_ASSIGNED_LIST, F_REWARDS_PENALTY_UNAPPROVED_LIST);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../rewards_penalty/list-menu.php">Danh sách</a></li>
                        <?php endif; ?>
                        
                        <?php if (in_array(F_REWARDS_PENALTY_STATISTIC_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_REWARDS_PENALTY_STATISTIC_LIST); ?>" href="../rewards_penalty/statistic-list.php">Thống kê</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_EQUIPMENT, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_EQUIPMENT); ?>" href="#">Quản lý dụng cụ</a>
                    <ul>
                        <?php 
                            if (in_array(F_EQUIPMENT_ADD_NEW, $arr[KEY_FUNCTION]) 
                                || in_array(F_EQUIPMENT_IMPORT_EXCEL, $arr[KEY_FUNCTION])):
                                    $functions = array(F_EQUIPMENT_ADD_NEW, F_EQUIPMENT_IMPORT_EXCEL);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../equipment/add-menu.php">Tạo bàn giao mới</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            if (in_array(F_EQUIPMENT_ASSIGNED_LIST, $arr[KEY_FUNCTION]) 
                                || in_array(F_EQUIPMENT_LIST_ALL, $arr[KEY_FUNCTION])):
                                    $functions = array(F_EQUIPMENT_ASSIGNED_LIST, F_EQUIPMENT_LIST_ALL);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../equipment/list-menu.php">Danh sách</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if (in_array(G_WORKING_CALENDAR, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_WORKING_CALENDAR); ?>" href="#">Quản lý lịch làm việc</a>
                    <ul>
                        <?php if (in_array(F_WORKING_CALENDAR_ADD_NEW, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_WORKING_CALENDAR_ADD_NEW); ?>" href="../working_calendar/add-new.php">Sắp xếp lịch</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            if (in_array(F_WORKING_CALENDAR_APPROVE_CALENDAR, $arr[KEY_FUNCTION]) 
                                OR in_array(F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD, $arr[KEY_FUNCTION]) 
                                OR in_array(F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_CHANGE, $arr[KEY_FUNCTION]) ):
                                    $functions = array(F_WORKING_CALENDAR_APPROVE_CALENDAR, F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD, F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_CHANGE);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../working_calendar/approve-menu.php">Approve</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            if (in_array(F_WORKING_CALENDAR_LEAVE_DAYS, $arr[KEY_FUNCTION]) 
                                OR in_array(F_WORKING_CALENDAR_LEAVE_DAYS_STATISTIC, $arr[KEY_FUNCTION]) ):
                                    $functions = array(F_WORKING_CALENDAR_LEAVE_DAYS, F_WORKING_CALENDAR_LEAVE_DAYS_STATISTIC);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../working_calendar/leave-days-menu.php">Lịch nghỉ phép</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            if (in_array(F_WORKING_CALENDAR_CALENDAR, $arr[KEY_FUNCTION]) 
                                OR in_array(F_WORKING_CALENDAR_UPDATE_CALENDAR, $arr[KEY_FUNCTION]) ):
                                    $functions = array(F_WORKING_CALENDAR_CALENDAR, F_WORKING_CALENDAR_UPDATE_CALENDAR);
                        ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../working_calendar/calendar-menu.php">Lịch làm việc</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <!-- Quản trị hệ thống -->
            <?php if (in_array(G_SYSTEM_ADMIN, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_SYSTEM_ADMIN); ?>" href="#">Quản trị hệ thống</a>
                    <ul>
                        <?php 
                            if (in_array(F_SETTINGS_ORDER_CONFIGURE, $arr[KEY_FUNCTION]) 
                                OR in_array(F_SETTINGS_MAIL_CONFIGURE, $arr[KEY_FUNCTION]) 
                                OR in_array(F_SETTINGS_TASK_CONFIGURE, $arr[KEY_FUNCTION]) 
                               ):
                                   $functions = array(F_SETTINGS_ORDER_CONFIGURE, 
                                                      F_SETTINGS_MAIL_CONFIGURE, 
                                                      F_SETTINGS_TASK_CONFIGURE
                                                     );
                            ?>
                            <li><a class="<?php get_item_css($functions); ?>" href="../settings/configure_menu.php">Settings</a></li>
                        <?php endif; ?>
                        
                        <?php if (in_array(F_SETTINGS_DEFAULT_USER, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_SETTINGS_DEFAULT_USER); ?>" href="../settings/default_users_list.php">Default user</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_DECENTRALIZE_ROLE_GROUP, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_DECENTRALIZE_ROLE_GROUP); ?>" href="../decentralize/role-group-list.php">Phân quyền</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_SYSTEM_ADMIN_NEWS_MANAGEMENT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_SYSTEM_ADMIN_NEWS_MANAGEMENT); ?>" href="../news_management/news-group-list.php">Quản lý thông tin công ty</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_SYSTEM_ADMIN_FINANCE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_SYSTEM_ADMIN_FINANCE); ?>" href="../finance/management-menu.php">Quản lý tài chính</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ORDERS_QUESTIONS_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_QUESTIONS_LIST); ?>" href="../orders/question.php">Quản lý câu hỏi đơn hàng</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div> 
