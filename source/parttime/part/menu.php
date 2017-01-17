<script src="../resources/scripts/socket.io.js"></script>
<script>
function call_ringing(data){
    var number = data.split(":");
    var ext = "<?php echo $_SESSION["ext"]; ?>";
    console.log(number[0] + ':' + number[1]);
    if ((ext.length > 0) && (number[0].length > 8) && (number[1] === ext)){
        window.open("http://ql.nhilong.com/popup/makhach.php?phone=" + number[0], '_blank');
    }
}
var socket = io.connect('http://115.79.57.172:3000');
socket.on('ringing', function (data) {
        call_ringing(data);
});
function f1(objButton){
   var ext = "<?php echo $_SESSION["ext"]; ?>";
   socket.emit('call',ext + ':' + objButton.value);
   console.log(ext + ':' + objButton.value);
   alert("Vui lòng nhấc máy khi điện thoại đổ chuông để gọi cho khách hàng !");
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
                        <?php if (in_array(F_VIEW_BAOGIA, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_VIEW_BAOGIA); ?>" href="../view/baogia.php">Báo giá</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_VIEW_QLBAOGIA, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_VIEW_QLBAOGIA); ?>" href="../baogia/baogiamo.php">Quản lý báo giá</a></li>
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
                        <?php if (in_array(F_GUEST_DEVELOPMENT_POOL, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GUEST_DEVELOPMENT_POOL); ?>" href="../guest_development/guestlistnew.php">Khách hàng mới</a></li>
                        <?php endif; ?>
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
                        <?php if (in_array(F_GUEST_DEVELOPMENT_REVENUE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GUEST_DEVELOPMENT_REVENUE); ?>" href="../report/topguestcatalog.php">Thống kê doanh số</a></lii>
                        <?php endif; ?>
                        <?php if (in_array(F_GUEST_DEVELOPMENT_CATALOG, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GUEST_DEVELOPMENT_CATALOG); ?>" href="../report/dscatalog.php">Danh sách gửi catalog</a></lii>
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
                        <?php if (in_array(F_EXPENSES_APPROVE, $arr[KEY_FUNCTION])): ?>
                             <li><a class="<?php get_item_css(F_EXPENSES_APPROVE); ?>" href="../orders/expenses_approve.php">Danh sách khoản chi cần approve</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ORDERS_CASHFLOW_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_CASHFLOW_LIST); ?>" href="../finance/cashflow.php">Dòng tiền</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_RETURN_WAITING, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_RETURN_WAITING); ?>" href="../orders/return_payment_list.php">Danh sách các khoản cần chi</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_IMPORT_RED_BILL, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_IMPORT_RED_BILL); ?>" href="../finance/import_red_bill.php">Thêm hóa đơn đỏ từ file excel</a></li>
                        <?php endif; ?>
                        
                         <?php if (in_array(F_INF_TK, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_INF_TK); ?>" href="../finance/information_account.php">Thông tin thu/chi của tài khoản</a></li>
                        <?php endif; ?>

                        <?php if (in_array(F_FINANCE_STATISTIC, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_FINANCE_STATISTIC); ?>" href="../finance/statistic.php">Thống kê</a></li>
                        <?php endif; ?>

                        <?php if (in_array(F_STATISTIC_VAT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_STATISTIC_VAT); ?>" href="../finance/statistic_vat.php">Thống kê VAT</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_REQUEST_EXPENSES, $arr[KEY_FUNCTION])): ?>
                             <li><a class="<?php get_item_css(F_REQUEST_EXPENSES); ?>" href="../orders/request_expenses.php">Yêu cầu chi tiền</a></li>
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
                            <li><a class="<?php get_item_css(F_ORDERS_RESERVATION_LIST); ?>" href="../orders/notcompleted.php">Đơn hàng chờ bóc tách</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ORDERS_RESERVATION_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_RESERVATION_LIST); ?>" href="../orders/reservationlist.php">Duyệt thông tin đơn hàng</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_RETURN_APPROVE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_RETURN_APPROVE); ?>" href="../orders/return_approve_list.php">Approve phiếu trả hàng</a></li>
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
                         <?php if (in_array(F_ORDERS_DETAIL_LIST, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ORDERS_DETAIL_LIST); ?>" href="../orders/order_filter.php">Đơn hàng tổng thể</a></li>
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
                        <?php if (in_array(F_ORDERS_GUESTS_RETURNS, $arr[KEY_FUNCTION])): ?>
                             <li><a class="<?php get_item_css(F_ORDERS_GUESTS_RETURNS); ?>" href="../orders/guests_returns.php">Trả hàng</a></li>
                        <?php endif; ?>

                         <?php if (in_array(F_BILL_VOUCHERS, $arr[KEY_FUNCTION])): ?>
                             <li><a class="<?php get_item_css(F_BILL_VOUCHERS); ?>" href="../orders/vouchers.php">Giao chứng từ</a></li>
                        <?php endif; ?>

                    </ul>
                </li>
            <?php endif; ?>

            <!-- Quản lý KPI -->
             <?php if (in_array(G_MANAGER_KPI, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_MANAGER_KPI); ?>" href="#">Quản lý KPI</a>
                    <ul>
                        <?php if (in_array(F_KPI_DELIVER, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_KPI_DELIVER); ?>" href="../kpimanager/kpi_deliver.php">KPI nhân viên giao hàng</a></li>
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
                        <?php if (in_array(F_ITEMS_THONGKE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ITEMS_THONGKE); ?>" href="../items/thongke.php">Thống kê hàng đã bán</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_ITEMS_MUAHANG, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_ITEMS_MUAHANG); ?>" href="../items/muahang.php">Thống kê đặt hàng</a></li>
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
                        <?php if (in_array(F_EMPLOYEES_ORGCHART, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_EMPLOYEES_ORGCHART); ?>" href="../chartstaff/view_chart.php">Sơ đồ tổ chức</a></li>
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
                        <?php if (in_array(F_GUEST_UPLOAD, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GUEST_UPLOAD); ?>" href="../guest/guestupload.php">Thêm khách từ file excel</a></li>
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
                        <!-- nghỉ phép -->
                        <?php if (in_array(F_LEAVE_STATISTIC, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LEAVE_STATISTIC); ?>" href="../working_calendar/leave-statistic.php">Thống kê danh sách nghỉ</a></li>
                        <?php endif; ?>

                        <?php
                            if (in_array(F_LIST_APPROVE_LEAVE, $arr[KEY_FUNCTION])):
                        ?>
                            <li><a class="<?php get_item_css(F_LIST_APPROVE_LEAVE); ?>" href="../working_calendar/list-approve-leave.php"">Danh sách nghỉ cần approve</a></li>
                        <?php endif; ?>

                        <?php
                            if (in_array(F_LEAVE_ADD, $arr[KEY_FUNCTION])):
                        ?>
                            <li><a class="<?php get_item_css(F_LEAVE_ADD); ?>" href="../working_calendar/leave-add.php">Lập đơn nghỉ phép</a></li>
                        <?php endif; ?>

                        <!-- làm thêm -->
                         <?php if (in_array(F_REQUEST_STATISTIC, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_REQUEST_STATISTIC); ?>" href="../working_calendar/request-statistic.php">Thống kê danh sách làm thêm</a></li>
                        <?php endif; ?>

                        <?php
                            if (in_array(F_LIST_APPROVE_REQUEST, $arr[KEY_FUNCTION])):
                        ?>
                            <li><a class="<?php get_item_css(F_LIST_APPROVE_REQUEST); ?>" href="../working_calendar/list-approve-request.php"">Yêu cầu làm thêm chờ xác nhận</a></li>
                        <?php endif; ?>

                        <?php
                            if (in_array(F_REQUEST_ADD, $arr[KEY_FUNCTION])):
                        ?>
                            <li><a class="<?php get_item_css(F_REQUEST_ADD); ?>" href="../working_calendar/request-add.php">Yêu cầu làm thêm</a></li>
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
                        <?php if (in_array(F_SMS_TEMPLATE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_SMS_TEMPLATE); ?>" href="../sms/smstemplate.php">Quản lý SMS template</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <!-- Quản lý hạng mục -->
            <?php if (in_array(G_MANAGER_BUILDING, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_MANAGER_BUILDING); ?>" href="#">Quản lý hạng mục</a>
                    <ul>
                        <!-- Trạng thái hạng mục -->
                        <?php if (in_array(F_STATUS_CATEGORY_BUILDING, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_STATUS_CATEGORY_BUILDING); ?>" href="../building/status_category_building.php">Trạng thái hạng mục</a></li>
                        <?php endif; ?>
                        
                        <!-- Trạng thái công trình -->
                        <?php if (in_array(F_STATUS_BUILDING, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_STATUS_BUILDING); ?>" href="../building/status_building.php">Trạng thái công trình</a></li>
                        <?php endif; ?>

                        <!-- danh sách hạng mục -->
                        <?php if (in_array(F_GROUP_CATEGORY_BUILDING, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_GROUP_CATEGORY_BUILDING); ?>" href="../building/group_category_building.php">Nhóm hạng mục</a></li>
                        <?php endif; ?>
                        <!-- danh sách hạng mục -->
                        <?php if (in_array(F_CATEGORY_BUILDING, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_CATEGORY_BUILDING); ?>" href="../building/category_building.php">Danh sách hạng mục</a></li>
                        <?php endif; ?>

                        <!-- danh sách đội thi công -->
                        <?php if (in_array(F_LIST_GROUP_CONSTRUCTION, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_GROUP_CONSTRUCTION); ?>" href="../building/list_group_construction.php">Danh sách đội thi công</a></li>
                        <?php endif; ?>

                        <!-- Danh sách nhà cung cấp -->
                        <?php if (in_array(F_LIST_PROVIDER, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_PROVIDER); ?>" href="../building/list_provider.php">Danh sách nhà cung cấp</a></li>
                        <?php endif; ?>

                        <!-- Vật tư hạng mục tư công -->
                        <?php if (in_array(F_MATERIAL_CATEGORY, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_MATERIAL_CATEGORY); ?>" href="../building/material_category.php">Vật tư hạng mục tư công</a></li>
                        <?php endif; ?>

                        <!-- Công việc hạng mục thi công -->
                        <?php if (in_array(F_WORK_CATEGORY, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_WORK_CATEGORY); ?>" href="../building/work_category.php">Công việc hạng mục thi công</a></li>
                        <?php endif; ?>

                    </ul>
                    
                </li>
            <?php endif; ?>
            <!-- 2015-12-05 HT Quản lý công trình -->
            <?php if (in_array(G_MANAGER_BUILDING_1, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_MANAGER_BUILDING_1); ?>" href="#">Quản lý công trình</a>
                    <ul>
                        <!-- Thêm công trình mới -->
                        <?php if (in_array(F_STATUS_CATEGORY_BUILDING, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_CREATE_BUILDING); ?>" href="../building/create_building.php">Thêm công trình mới</a></li>
                        <?php endif; ?>
                         <!-- Danh sách công trình -->
                        <?php if (in_array(F_LIST_BUILDING, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING); ?>" href="../building/list_building.php">Danh sách công trình mới</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_LIST_BUILDING_WAIT_FOR_APPROVE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING_WAIT_FOR_APPROVE); ?>" href="../building/list_building_waiting_for_approve.php">Công trình chờ duyệt dự toán</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_LIST_BUILDING_REAL_DATA, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING_REAL_DATA); ?>" href="../building/list_building_waiting_for_real_data.php">Công trình chờ nhập dữ liệu thực tế</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_LIST_BUILDING_IMPLEMENT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING_IMPLEMENT); ?>" href="../building/list_building_waiting_for_implement.php">Công trình đang thi công</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_LIST_BUILDING_VATTU, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING_VATTU); ?>" href="../building/danhsachvattucanmua.php">Danh sách vật tư cần mua</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_LIST_BUILDING_VATTU, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING_VATTU); ?>" href="../building/building_change_request.php">Các yêu cầu thay đổi</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_LIST_BUILDING_VATTU, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING_VATTU); ?>" href="../building/building_assessment_list.php">Các hạng mục cần kiểm soát</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_LIST_BUILDING_VATTU, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING_VATTU); ?>" href="../building/building_group_management.php">Quản lý thầu phụ</a></li>
                        <?php endif; ?>

                        <?php if (in_array(F_LIST_BUILDING_IMPLEMENT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_LIST_BUILDING_IMPLEMENT); ?>" href="../building/duyetphatsinh.php">Duyệt phát sinh</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

             <!-- 2016-12-14 HT Quản lý cộng tác -->
            <?php if (in_array(G_MANAGER_COLLABORATORS, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(G_MANAGER_COLLABORATORS); ?>" href="#">Quản lý cộng tác</a>
                    <ul>
                        <!-- Thêm công công việc mới -->
                        <?php if (in_array(F_COLLABORATORS_CREATE_WORK, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COLLABORATORS_CREATE_WORK); ?>" href="../collaborators/create_collaborators.php">Thêm công việc</a></li>
                        <?php endif; ?>
                         <!-- Danh sách công việc -->
                        <?php if (in_array(F_COLLABORATORS_LIST_WORK, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COLLABORATORS_LIST_WORK); ?>" href="../collaborators/list_work.php">Danh sách công việc</a></li>
                        <?php endif; ?>
                      
                         <!-- Danh sách công việc chờ approve -->
                        <?php if (in_array(F_COLLABORATORS_LIST_APPROVE_WORK, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COLLABORATORS_LIST_APPROVE_WORK); ?>" href="../collaborators/list_approve.php">Danh sách công việc chờ approve</a></li>
                        <?php endif; ?>

                        <!-- Danh sách kết quả công việc -->
                        <?php if (in_array(F_COLLABORATORS_LIST_RESULT_WORK, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_COLLABORATORS_LIST_RESULT_WORK); ?>" href="../collaborators/list_result_work.php">Danh sách kết quả công việc</a></li>
                        <?php endif; ?>

                        
                    </ul>
                </li>
            <?php endif; ?>

             <!-- 2016-12-14 HT Hang san xuat theo module -->
            <?php if (in_array(MANAGER_PRODUCT_MODULE, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(MANAGER_PRODUCT_MODULE); ?>" href="#">Sản xuất module</a>
                    <ul>
                        <!-- danh sach san pham module -->
                        <?php if (in_array(F_MODULE_LOAICHITIETSANPHAM, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_MODULE_LOAICHITIETSANPHAM); ?>" href="../product_by_module/loaichitietsanpham.php">Loại chi tiết sản phẩm</a></li>
                        <?php endif; ?>

                        <?php if (in_array(F_MODULE_CHITIETSANPHAM, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_MODULE_CHITIETSANPHAM); ?>" href="../product_by_module/chitietsanpham.php">Chi tiết sản phẩm</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_DANHSACHSANPHAMMODULE, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_DANHSACHSANPHAMMODULE); ?>" href="../product_by_module/danhsachsanphammodule.php">Danh sách sản phẩm module</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_MODULE_KEHOACHSANXUAT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_MODULE_KEHOACHSANXUAT); ?>" href="../product_by_module/kehoachsanxuatchitiet.php">Kế hoạch sản xuất</a></li>
                        <?php endif; ?>
                        <?php if (in_array(F_AUTOUPLOAD_CHITIETSANPHAMMAPPING, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_AUTOUPLOAD_CHITIETSANPHAMMAPPING); ?>" href="../product_by_module/autoupload_chitietsanphammapping.php">Upload chi tiết sản phẩm mapping từ excel</a></li>
                        <?php endif; ?>
                      
                        <?php if (in_array(F_AUTOUPLOAD_TONKHOSANXUAT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_AUTOUPLOAD_TONKHOSANXUAT); ?>" href="../product_by_module/autoupload_tonkhosanxuat.php">Thêm tồn kho sản xuất từ excel</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <!-- 2016-01-02 san xuat phan bu -->
            <?php if (in_array(MANAGER_PREMIUM, $arr[KEY_GROUP])): ?>
                <li>
                    <a class="<?php get_sub_css(MANAGER_PREMIUM); ?>" href="#">Sản xuất phần bù</a>
                    <ul>
                        <?php if (in_array(F_PREMIUM_DANCHI, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_PREMIUM_DANCHI); ?>" href="../premium_sell/danchi.php">Danh sách dán chỉ</a></li>
                        <?php endif; ?>

                        <?php if (in_array(F_PREMIUM_MAVAN, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_PREMIUM_MAVAN); ?>" href="../premium_sell/mavan.php">Danh sách mã ván</a></li>
                        <?php endif; ?>

                        <?php if (in_array(F_PREMIUM_MAKHOAN, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_PREMIUM_MAKHOAN); ?>" href="../premium_sell/makhoan.php">Danh sách mã khoan</a></li>
                        <?php endif; ?>

                        <?php if (in_array(F_PREMIUM_DANHSACHCHITIETPHANBUCANSANXUAT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_PREMIUM_DANHSACHCHITIETPHANBUCANSANXUAT); ?>" href="../premium_sell/danhsachchitietphanbucansanxuat.php">Danh sách phần bù cần sản xuất</a></li>
                        <?php endif; ?>

                        <?php if (in_array(F_PREMIUM_DANHSACHCHITIETPHANBUDANGSANXUAT, $arr[KEY_FUNCTION])): ?>
                            <li><a class="<?php get_item_css(F_PREMIUM_DANHSACHCHITIETPHANBUDANGSANXUAT); ?>" href="../premium_sell/danhsachchitietphanbudangsanxuat.php">Danh sách phần bù đang sản xuất</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</div> 
