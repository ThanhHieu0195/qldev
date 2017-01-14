<?php
define("MAX_LEAVE", "8");
define('CART_NAME', 'nhilongcart');
define('NONE_SPACE', '&nbsp;');
/* Information of account that is logged in */
define('LOGGED_IN_ACCOUNT', 'logged_in_account');
define('MANV', 'manv');
define('PASSWORD', 'password');
define('TENNV', 'tennv');
define('UID', 'uid');

/* Role account */
define('ACCOUNT_ADMIN', 'ADMIN');
define('ROLE_ADMIN', 'admin');
define('ROLE_FREELANCER', 'freelancer');
// define('ROLE_EMPLOYEE', 'employee');
// define('ROLE_STORE_MANAGER', 'store_manager');
define('ROLE_MANAGER', 'manager');
// define('ROLE_CASHIER', 'cashier');
// define('ROLE_CUSTOMER_CARE', 'customer_care');
// define('ROLE_FREELANCER', 'freelancer');
// define('ROLE_FREELANCER_MANAGER', 'freelancer_manager');

define('COUPON_CODE', 'coupon_code');

define('DEFAULT_SHOWROOM', 'DEFAULT_SHOWROOM');
define('DEFAULT_THO', 'DEFAULT_THO');

define('VALIDATE_UID', '0-9, a-z, A-Z, _');

/* 
 * Mail server configuration keys 
 */
define('MAIL_HOST', 'MAIL_HOST'); // Host
define('MAIL_UID', 'MAIL_UID'); // User name
define('MAIL_PWD', 'MAIL_PWD'); // Password
define('MAIL_TIMEOUT', 'MAIL_TIMEOUT'); // Time-out (in seconds)
define('MAIL_FROMNAME', 'MAIL_FROMNAME'); // From's name
define('MAIL_DFT_TIMEOUT', 10); // Default time-out (in seconds)

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error reporting code in ./part/error_reporting.php
 *
 */
// Hàng sản xuất theo module
define('MANAGER_PRODUCT_MODULE', 'manager_product_module');
define('F_DANHSACHSANPHAMMODULE', 'danhsachsanphammodule');
define('F_AUTOUPLOAD_CHITIETSANPHAMMAPPING', 'autouploadchitietsanphammapping');
define('F_AUTOUPLOAD_TONKHOSANXUAT', 'autoupload_tonkhosanxuat');
define('F_MODULE_LOAICHITIETSANPHAM', 'module_loaichitietsanpham');
define('F_MODULE_CHITIETSANPHAM', 'module_chitietsanpham');
define('F_MODULE_KEHOACHSANXUAT', 'product_makingplan');




define('ENVIRONMENT', 'production');
/*  define('ENVIRONMENT', 'development');*/

/* 
 * Coupon's status 
 */
define('COUPON_STATUS_ASSIGN', 'A');
define('COUPON_STATUS_USED', 'U');
define('COUPON_STATUS_VACANCY', 'V');

define('PROMOTION_GUEST', 'Khách liên hệ chờ khuyến mãi');
define('LOSERS_NEW_GUEST', 'Gửi mã giảm giá cho khách mới');

/* 
 * Coupon assigned type 
 */
define('COUPON_ASSIGN_GUEST_NEW', 'G');
define('COUPON_ASSIGN_GUEST_THIRD_USED', 'E');
define('COUPON_ASSIGN_FREELANCER_NEW', 'F');

define('EXCEL_FOLDER', 'excelfiles');
define('IMAGE_FOLDER', 'pic_images');
define('IMAGE_EXTENSION', '.jpg');
define('EXCEL_EXTENSION', '.xls');
define('UPLOAD_FOLDER', 'uploads');
define('UPLOAD_EQUIQMENT_FOLDER', 'uploads/equiqment');

/* 
 * Orders cashing
 */
define('CASHED_TYPE_PARTLY',          0); // Thu 1 phần tiền
define('CASHED_TYPE_TIEN_COC',        1); // Thu tiền cọc
define('CASHED_TYPE_TIEN_GIAO_HANG',  2); // Thu tiền giao hàng
define('CASHED_TYPE_ALL',             3); // Thu tất cả tiền
define('CASHED_TYPE_VAT',             4); // Thu tất cả tiền

define('CASHED_TYPE_TIENTHICONG', 5); //tiền thi công
define('CASHED_TYPE_TIENCATTHAM', 6); //tiền cắt thảm
define('CASHED_TYPE_PHUTHUGIAOHANG', 7); //phụ thu giao hàng
define('CASHED_TYPE_THUTIENGIUMKHACHSI', 8); //thu tiền giùm khách sỉ

// danh sach thu chi
define('TIENTHICONG', "APPROVED:tiền thi công"); //tiền thi công
define('TIENCATTHAM', "APPROVED:tiền cắt thảm"); //tiền cắt thảm
define('PHUTHUGIAOHANG', "APPROVED:phụ thu giao hàng"); //phụ thu giao hàng
define('THUTIENGIUMKHACHSI', "APPROVED:thu giùm khách sĩ"); //thu tiền giùm khách sỉ
define('THUTIENCOC', "APPROVED:thu tiền cọc");
define('THUTIENVAT', "APPROVED:thu tiền VAT");
define('THUTIENTATCA', "APPROVED:thu tiền tất cả");
define('THUTIENMOTPHAN', "APPROVED:thu tiền 1 phần");


// chi
define('CHITIENTRAKHACHSI', "APPROVED:chi tiền trả khách sĩ"); //Chi tiền trả khách sĩ
define('CHITIENTIENGIAOHANG', "APPROVED:chi tiền giao hàng");//Chi tiền giao hàng
define('CHITIENCATTHAM', "APPROVED:chi tiền cắt thảm"); //tiền cắt thảm
define('CHITIENTHICONG', "APPROVED:chi tiền thi công"); //tiền thi công
define('CHIPHUTHUGIAOHANG', "APPROVED:chi phụ thu giao hàng"); //phụ thu giao hàng

/*================================
=            building            =
================================*/
// category_building, detail_category, list_provider, list_group_construction, material_category, status_building, status_category_building, work_category
define('INIT', 0);
define('STATUS_DEFAULT', 0);
define('STATUS_APPROVE', 1);
define('STATUS_REJECT', 3);
define('G_MANAGER_BUILDING', 'manager_building');
define('F_CATEGORY_BUILDING', 'category_building');
define('F_DETAIL_CATEGORY', 'detail_category');
define('F_LIST_PROVIDER', 'list_provider');
define('F_LIST_GROUP_CONSTRUCTION', 'list_group_construction');
define('F_MATERIAL_CATEGORY', 'material_category');
define('F_STATUS_BUILDING', 'status_building');
define('F_STATUS_CATEGORY_BUILDING', 'status_category_building');
define('F_WORK_CATEGORY', 'work_category');
define('F_LIST_BUILDING_WAIT_FOR_APPROVE','building_wait_for_approve');    
define('F_LIST_BUILDING_REAL_DATA','building_wait_for_real_data'); 
define('F_LIST_BUILDING_IMPLEMENT','building_implement'); 
define('F_GROUP_CATEGORY_BUILDING','group_category_building'); 
define('F_LIST_BUILDING_VATTU','building_vattu');

define('G_MANAGER_BUILDING_1', 'manager_building_1');
define('F_CREATE_BUILDING', 'create_building');
define('F_LIST_BUILDING', 'list_building');

define('GMAIL_WORK_DETAIL', "tcthanhhieu@gmail.com");

/*=====  End of building  ======*/
define('G_MANAGER_COLLABORATORS', 'manager_collaborators');
define('F_COLLABORATORS_CREATE_WORK', 'collaborators_create_work');
define('F_COLLABORATORS_LIST_WORK', 'collaborators_list_work');
define('F_COLLABORATORS_LIST_APPROVE_WORK', 'collaborators_list_approve_work');
define('F_COLLABORATORS_LIST_RESULT_WORK', 'collaborators_list_result_work');
define('COMPLETED_WORK', '3');
define('REJECTED_WORK', '4');
define('TYPE_PAY', '1');
define('WORKINGDIR','/var/www/hethongdev/');
// define('WORKINGDIR','D:/Xampp/htdocs/parttime/');
define('TARGET_ATTACHMENT_DIR', 'uploads/');
define('IMAGE_EMPTY', '../uploads/empty.png');
define('DIR_UPLOAD_DEFAULT', '../uploads');

// ID_RETURN
// PC-NHILONG
define('RETURN_PRODUCT_ID', "53b213f154da7");
define('RETURN_REFERENCE_ID', "57cd4acf69c05");
define('RETURN_CATEGORY_ID', "CP0015");
define('RETURN_ITEM_ID', "554d981427ecc");	

// PC-HIEU
// define('RETURN_PRODUCT_ID', "53b213f154da7");
// define('RETURN_REFERENCE_ID', "56554dc2dcbbc");
// define('RETURN_CATEGORY_ID', "CP0015");
// define('RETURN_ITEM_ID', "57de5f7f03a0b");	
/*
 * Task constants
 */
define('BIT_TRUE',                  1);
define('BIT_FALSE',                 0);

define('TASK_STATUS_NEW',           1);
define('TASK_STATUS_EXPIRED',       2);
define('TASK_STATUS_FINISHED',      3);
define('TASK_STATUS_FINISHED_LATE', 4);

define('TASK_RANK_NONE',            0);
define('TASK_RANK_WEAK',            1);
define('TASK_RANK_AVERAGE',         2);
define('TASK_RANK_GOOD',            3);
define('TASK_RANK_VERY_GOOD',       4);
define('TASK_RANK_EXCELLENT',       5);

define('TASK_RESULT_NA',          101);

/*
 * Rewards/Penalty constants
*/
define('REWARDS_PENALTY_TOP_DAYS', 30);

/*
 * Equipment constants
 */
define('EQUIPMENT_NEW', 0);
define('EQUIPMENT_ACCEPTED', 1);
define('EQUIPMENT_CANCELLED', 2);

define('ARRAY_DELIMITER', ';');

/*
 * Swapping & Detail
 */
 define('SWAPPING_NEW', 0);
 define('SWAPPING_FINISHED', 1);
 define('SWAPPING_DRAFT', 101);
 define('SWAPPING_COMPLETED', -1);
 define('SWAPPING_DETAIL_WAIT', 0);
 define('SWAPPING_DETAIL_DELIVERIED', 1);
 define('SWAPPING_DETAIL_RETURNED', 2);
 
 /*
  * Guest development status
 */
 define('GUEST_DEVELOPMENT_NONE', 0);
 define('GUEST_DEVELOPMENT_ONGOING', 1);
 define('GUEST_DEVELOPMENT_CANCELLED', 2);
 
 /*
  * Finance type
 */
 define('FINANCE_RECEIPT', 0); // Thu
 define('FINANCE_PAYMENT', 1); // Chi
 define('FINANCE_BOTH', 101); // Thu & Chi
 
/*
 * Function groups & Functions
 */
define('SITE_FUNCTION', 'site_function');
define('KEY_GROUP', 'group');
define('KEY_FUNCTION', 'function');
define('KEY_USER_DATA', 'user_data');
// Group(s)
define('G_NOTIFICATIONS', 'notifications');
define('G_NEWS', 'news');
define('G_SYSTEM_ADMIN', 'system_admin');
define('G_VIEW', 'view');
define('G_GUEST_DEVELOPMENT', 'guest_development');
define('G_FINANCE', 'finance');
define('G_COUPON', 'coupon');
define('G_ORDERS', 'orders');
define('G_ITEMS', 'items');
define('G_EMPLOYEES', 'employees');
define('G_STORES', 'stores');
define('G_GUEST', 'guest');
define('G_REPORT', 'report');
define('G_TASK', 'task');
define('G_REWARDS_PENALTY', 'rewards_penalty');
define('G_EQUIPMENT', 'equipment');
define('G_WORKING_CALENDAR', 'working_calendar');
define('G_DELIVER', 'deliver');
define('G_MANAGER_KPI', 'manager_kpi');
define('TYPE_ITEM_PRODUCE', 0);
define('TYPE_ITEM_ASSEMBLY', 1);
define('TYPE_ITEM_PREMIUM', 2);

// Function(s)
define('F_NOTIFICATIONS_DASHBOARD', 'notifications_dashboard');
define('F_NEWS_VIEW', 'news_view');
define('F_SETTINGS_ORDER_CONFIGURE', 'settings_order_configure');
define('F_SETTINGS_MAIL_CONFIGURE', 'settings_mail_configure');
define('F_SETTINGS_TASK_CONFIGURE', 'settings_task_configure');
define('F_SETTINGS_DEFAULT_USER', 'settings_default_user');
define('F_DECENTRALIZE_ROLE_GROUP', 'decentralize_role_group');
define('F_SYSTEM_ADMIN_NEWS_MANAGEMENT', 'system_admin_news_management');
define('F_SYSTEM_ADMIN_FINANCE', 'system_admin_finance');
define('F_ORDERS_QUESTIONS_LIST', 'orders_questions_list');
define('F_SMS_TEMPLATE', 'sms_template');
define('F_VIEW_COUPON_VERIFY', 'view_coupon_verify');
define('F_VIEW_SALE', 'view_sale');
define('F_VIEW_STORE', 'view_store');
define('F_VIEW_ORDER', 'view_order');
define('F_VIEW_BAOGIA', 'view_baogia');
define('F_VIEW_QLBAOGIA', 'view_qlbaogia');
define('F_VIEW_QLBAOGIA_ALL', 'view_qlbaogia_all');	
define('F_VIEW_CART', 'view_cart');
define('F_VIEW_TRADE', 'view_trade');
define('F_VIEW_TRADE_DATE', 'view_trade_date');
define('F_VIEW_TRADE_ADMIN', 'view_trade_admin');
define('F_GUEST_DEVELOPMENT_ADD_NEW', 'guest_development_add_new');
define('F_GUEST_DEVELOPMENT_POOL', 'guest_development_pool');
define('F_GUEST_DEVELOPMENT_ADD_FROM_DB', 'guest_development_add_from_db');
define('F_GUEST_DEVELOPMENT_LIST_ASSIGNED', 'guest_development_list_assigned');
define('F_GUEST_DEVELOPMENT_LIST_ALL', 'guest_development_list_all');
define('F_GUEST_DEVELOPMENT_LIST_CANCELLED', 'guest_development_list_cancelled');
define('F_GUEST_DEVELOPMENT_LIST_FAVOURITE', 'guest_development_list_favourite');
define('F_GUEST_DEVELOPMENT_LIST_UNFOLLOW', 'guest_development_list_unfollow');
define('F_GUEST_DEVELOPMENT_EVENTS', 'guest_development_events');
define('F_GUEST_DEVELOPMENT_HAUMAI', 'guest_development_haumai');
define('F_GUEST_DEVELOPMENT_STATISTIC_UPDATED', 'guest_development_statistic_updated');
define('F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED', 'guest_development_statistic_contacted');
define('F_GUEST_DEVELOPMENT_CATALOG', 'guest_development_catalog');
define('F_GUEST_DEVELOPMENT_REVENUE','guest_development_revenue');
define('F_FINANCE_CREATE_RECEIPT', 'finance_create_receipt');
define('F_FINANCE_CREATE_PAYMENT', 'finance_create_payment');
define('F_FINANCE_APPROVE', 'finance_approve');
define('F_FINANCE_STATISTIC', 'finance_statistic');
define('F_STATISTIC_VAT', 'statistic_vat');

define('F_IMPORT_RED_BILL', 'import_red_bill');
define('F_INF_TK', 'information_account');
define('F_COUPON_GROUP', 'coupon_group');
define('F_COUPON_GENERATE', 'coupon_generate');
define('F_COUPON_ASSIGN_GROUP', 'coupon_assign_group');
define('F_COUPON_ASSIGN_LIST', 'coupon_assign_list');
define('F_COUPON_THIRD_USED', 'coupon_third_used');
define('F_COUPON_USED_STATISTIC', 'coupon_used_statistic');
define('F_COUPON_FREELANCER_STATISTIC_ALL', 'coupon_freelancer_statistic_all');
define('F_COUPON_FREELANCER_ASSIGN', 'coupon_freelancer_assign');
define('F_COUPON_FREELANCER_USED', 'coupon_freelancer_used');
define('F_COUPON_FREELANCER_EXPIRED', 'coupon_freelancer_expired');
define('F_COUPON_FREELANCER_STATISTIC', 'coupon_freelancer_statistic');
define('F_ORDERS_RESERVATION_LIST', 'orders_reservation_list');
define('F_ORDERS_ORDER_LIST', 'orders_order_list');
define('F_ORDERS_DELIVERY', 'orders_delivery');
define('F_ORDERS_RETURNS', 'orders_returns');
define('F_ORDERS_CASH_LIST', 'orders_cash_list');
define('F_ORDERS_CASH_STATISTIC', 'orders_cash_statistic');
define('F_ORDERS_SUPPORT_LIST', 'orders_support_list');
define('F_ORDERS_UPDATE_CASH', 'orders_update_cash');
define('F_ORDERS_SPECIAL_LIST', 'orders_special_list');
define('F_ORDERS_ORDER_DELIVERED', 'orders_order_delivered');
define('F_ORDERS_UNCHECKED_LIST', 'orders_unchecked_list');
define('F_ORDERS_CHECKED_LIST', 'orders_checked_list');
define('F_ORDERS_ASSIGN_DELIVERED', 'orders_assign_delivered');
define('F_ORDERS_TP', 'orders_tp');
define('F_ORDERS_DIFFERENCE', 'orders_difference');
define('F_ORDERS_UPDATE_CASHING_DATE', 'orders_update_cashing_date');
define('F_ORDERS_CASHED_LIST', 'orders_cashed_list');
define('F_ORDERS_DETAIL_LIST', 'orders_detail_list');
define('F_ORDERS_CASHFLOW_LIST', 'orders_cashflow');
define('F_ORDERS_GUESTS_RETURNS', 'orders_guests_returns');
define('F_BILL_VOUCHERS', 'bill_vouchers');

define('F_REQUEST_EXPENSES', 'request_expenses');
define('F_EXPENSES_APPROVE', 'expenses_approve');
define('F_LIST_EXPENSES', 'listexpenses');

define('F_RETURN_APPROVE', 'return_approve');
define('F_RETURN_WAITING', 'return_waiting');

define('F_ITEMS_LIST', 'items_list');
define('F_ITEMS_ADD', 'items_add');
define('F_ITEMS_AUTO_UPLOAD', 'items_auto_upload');
define('F_GUEST_UPLOAD', 'guest_upload');
define('F_ITEMS_UPLOAD', 'items_upload');
define('F_ITEMS_TYPE', 'items_type');
define('F_ITEMS_HISTORY', 'items_history');
define('F_ITEMS_THONGKE', 'items_thongke');
define('F_ITEMS_MUAHANG', 'items_muahang');
define('F_EMPLOYEES_ADD_EMPLOYEE', 'employees_add_employee');
define('F_EMPLOYEES_ADD_FREELANCER', 'employees_add_freelancer');
define('F_EMPLOYEES_EMPLOYEE_LIST', 'employees_employee_list');
define('F_EMPLOYEES_FREELANCER_LIST', 'employees_freelancer_list');
define('F_EMPLOYEES_ASSIGN_FREELANCER', 'employees_assign_freelancer');
define('F_EMPLOYEES_ADD_STAFF', 'employees_add_staff');
define('F_EMPLOYEES_STAFF_LIST', 'employees_staff_list');
define('F_EMPLOYEES_EMPLOYEE_GROUP', 'employees_employee_group');
define('F_EMPLOYEES_ORGCHART', 'view_chart');
define('F_STORES_STORE_LIST', 'stores_store_list');
define('F_STORES_ADD_STORE', 'stores_add_store');
define('F_STORES_STORE_MANAGEMENT', 'stores_store_management');
define('F_STORES_ITEM_OF_STORE', 'stores_item_of_store');
define('F_STORES_AMOUNT_MANAGEMENT', 'stores_amount_management');
define('F_STORES_SWAP', 'stores_swap');
define('TEMP_STORE_ID', -1);
define('F_GUEST_ADD_GUEST', 'guest_add_guest');
define('F_GUEST_GUEST_LIST', 'guest_guest_list');
define('F_GUEST_GUEST_GROUP', 'guest_guest_group');
define('F_REPORT_RPT_BY_GUEST_GROUP', 'report_rpt_by_guest_group');
define('F_REPORT_RPT_BY_STORE', 'report_rpt_by_store');
define('F_REPORT_RPT_BY_WORKER', 'report_rpt_by_worker');
define('F_REPORT_RPT_BY_DISTRICT', 'report_rpt_by_district');
define('F_REPORT_RPT_BY_EMPLOYEE', 'report_rpt_by_employee');
define('F_TASK_TEMPLATE_LIST', 'task_template_list');
define('F_TASK_CREATE_TASK', 'task_create_task');
define('F_TASK_DETAIL', 'task_detail');
define('F_TASK_MY_FINISHED', 'task_my_finished');
define('F_TASK_LIST_ALL', 'task_list_all');
define('F_TASK_STATISTIC', 'task_statistic');
define('F_REWARDS_PENALTY_ADD_NEW', 'rewards_penalty_add_new');
define('F_REWARDS_PENALTY_CREATED_LIST', 'rewards_penalty_created_list');
define('F_REWARDS_PENALTY_ASSIGNED_LIST', 'rewards_penalty_assigned_list');
define('F_REWARDS_PENALTY_UNAPPROVED_LIST', 'rewards_penalty_unapproved_list');
define('F_REWARDS_PENALTY_STATISTIC_LIST', 'rewards_penalty_statistic_list');
define('F_EQUIPMENT_ADD_NEW', 'equipment_add_new');
define('F_EQUIPMENT_IMPORT_EXCEL', 'equipment_import_excel');
define('F_EQUIPMENT_ASSIGNED_LIST', 'equipment_assigned_list');
define('F_EQUIPMENT_LIST_ALL', 'equipment_list_all');
define('F_EQUIPMENT_SWAP', 'equipment_swap');

define('F_WORKING_CALENDAR_ADD_NEW', 'working_calendar_add_new');
define('F_WORKING_CALENDAR_APPROVE_CALENDAR', 'working_calendar_approve_calendar');
define('F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD', 'working_calendar_approve_leave_days_add');
define('F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_CHANGE', 'working_calendar_approve_leave_days_change');
define('F_WORKING_CALENDAR_LEAVE_DAYS', 'working_calendar_leave_days');
define('F_WORKING_CALENDAR_LEAVE_DAYS_CHANGE', 'working_calendar_leave_days_change');
define('F_WORKING_CALENDAR_LEAVE_DAYS_STATISTIC', 'working_calendar_leave_days_statistic');
define('F_WORKING_CALENDAR_CALENDAR', 'working_calendar_calendar');
define('F_WORKING_CALENDAR_CALENDAR_BY_TIME', 'working_calendar_calendar_by_time');
define('F_WORKING_CALENDAR_UPDATE_CALENDAR', 'working_calendar_update_calendar');

define('F_REQUEST_STATISTIC', 'request_statistic');
define('F_LIST_APPROVE_REQUEST', 'list_approve_request');
define('F_REQUEST_ADD', 'request_add');

define('F_LEAVE_STATISTIC', 'leave_statistic');
define('F_LIST_APPROVE_LEAVE', 'list_approve_leave');
define('F_LEAVE_ADD', 'leave_add');




define('F_KPI_DELIVER', 'kpi_deliver');
//phanbu
define('MANAGER_PREMIUM', 'manager_premium');
define('F_PREMIUM_DANCHI', 'premium_danchi');
define('F_PREMIUM_MAVAN', 'premium_mavan');
define('F_PREMIUM_MAKHOAN', 'premium_makhoan');
define('F_PREMIUM_DANHSACHCHITIETPHANBUCANSANXUAT', 'premium_danhsachchitietphanbucansanxuat');
define('F_PREMIUM_DANHSACHCHITIETPHANBUDANGSANXUAT', 'premium_danhsachchitietphanbudangsanxuat');
/* End of file constants.php */

