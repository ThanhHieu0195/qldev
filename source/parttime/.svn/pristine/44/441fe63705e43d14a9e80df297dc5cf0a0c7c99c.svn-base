<?php
require_once '../models/account_role_of_employee.php';

// Check if an account is logged in system
if (! function_exists ( 'is_logged_in' )) {
    function is_logged_in() {
        return isset ( $_SESSION [LOGGED_IN_ACCOUNT] [MANV] );
    }
}

// Get information of account that is logged in system
if (! function_exists ( 'current_account' )) {
    function current_account($key = MANV) {
        if (isset ( $_SESSION [LOGGED_IN_ACCOUNT] [$key] )) {
            return $_SESSION [LOGGED_IN_ACCOUNT] [$key];
        }
        
        return '';
    }
}

// Set information of account that is logged in system
if (! function_exists ( 'set_current_account' )) {
    function set_current_account($key, $value) {
        if (isset ( $_SESSION [LOGGED_IN_ACCOUNT] [$key] )) {
            $_SESSION [LOGGED_IN_ACCOUNT] [$key] = $value;
        }
    }
}

// Set current function of system
if (! function_exists ( 'set_site_function' )) {
    function set_site_function($group = '', $function = '', $user_data = NULL) {
        if (! isset ( $_SESSION [SITE_FUNCTION] )) {
            $_SESSION [SITE_FUNCTION] = array (
                    KEY_GROUP => $group,
                    KEY_FUNCTION => $function,
                    KEY_USER_DATA => $user_data 
            );
        } else {
            $_SESSION [SITE_FUNCTION] [KEY_GROUP] = $group;
            $_SESSION [SITE_FUNCTION] [KEY_FUNCTION] = $function;
            $_SESSION [SITE_FUNCTION] [KEY_USER_DATA] = $user_data;
        }
    }
}

// Get current function of system
if (! function_exists ( 'get_site_function' )) {
    function get_site_function($key = KEY_FUNCTION) {
        if (isset ( $_SESSION [SITE_FUNCTION] [$key] )) {
            return $_SESSION [SITE_FUNCTION] [$key];
        }
        
        return '';
    }
}

// Check if an account has access to the specified function
if (! function_exists ( 'verify_access_right' )) {
    function verify_access_right($account, $data, $type = KEY_FUNCTION) {
        
        // SQL statement
        $enable = BIT_TRUE;
        $where = "r.enable = {$enable} AND e.employee_id = '{$account}' AND g.enable = {$enable} ";
        
        if ($type == KEY_FUNCTION) {
            
            // List of functions
            if (is_array ( $data )) {
                $tmp = "'" . str_replace ( ", ", "', '", implode ( ", ", $data ) ) . "'";
                
                $where .= " AND f.function_id IN ({$tmp})";
            } else { // A single function
                $where .= " AND f.function_id = '{$data}'";
            }
        } else {
            
            // List of groups
            if (is_array ( $data )) {
                $tmp = "'" . str_replace ( ", ", "', '", implode ( ", ", $data ) ) . "'";
                
                $where .= " AND g.group_id IN ({$tmp})";
            } else { // A single group
                $where .= " AND g.group_id = '{$data}'";
            }
        }
        
        $sql = "SELECT e.role_id, g.group_id, f.function_id
                FROM account_role_of_employee e INNER JOIN account_role_group r ON  e.role_id = r.role_id
                                                INNER JOIN account_function_of_role f ON r.role_id = f.role_id
                                                INNER JOIN account_function g ON f.function_id = g.function_id
                WHERE $where";
        
        // Get data from database
        $model = new database ();
        $model->setQuery ( $sql );
        $result = $model->loadAllRow ();
        $model->disconnect ();
        
        return ((is_array ( $result ) && count ( $result ) > 0));
    }
}

// Verify that an account has access on which store
if (! function_exists ( 'check_store_manager' )) {
    function check_store_manager($account, $store) {
        if (is_admin ( $account )) {
            return TRUE;
        }
        
        $nv = new nhanvien ();
        $obj = $nv->detail ( $account );
        if ($obj != NULL && $obj->macn == $store) {
            return TRUE;
        }
        return FALSE;
    }
}

// Get function list of an account
if (! function_exists ( 'function_list_of_account' )) {
    function function_list_of_account($account, $all = FALSE) {
        
        // SQL statement
        $where = "WHERE e.employee_id = '{$account}'";
        if (! $all) {
            $enable = BIT_TRUE;
            $where .= " AND r.enable = {$enable} AND g.enable = {$enable} ";
        }
        
        $sql = "SELECT e.role_id, g.group_id, f.function_id
                FROM account_role_of_employee e INNER JOIN account_role_group r ON  e.role_id = r.role_id
                                                INNER JOIN account_function_of_role f ON r.role_id = f.role_id
                                                INNER JOIN account_function g ON f.function_id = g.function_id
                $where
                ORDER BY g.group_id";
        
        // Get data from database
        $model = new database ();
        $model->setQuery ( $sql );
        $result = $model->loadAllRow ();
        $model->disconnect ();
        
        // Put above list to table(s)
        $arr = array (
                KEY_GROUP => array (),
                KEY_FUNCTION => array () 
        );
        if (is_array ( $result )) {
            foreach ( $result as $r ) {
                // Put group
                if (in_array ( $r ['group_id'], $arr [KEY_GROUP] ) === FALSE) {
                    $arr [KEY_GROUP] [] = $r ['group_id'];
                }
                
                // Put function
                if (in_array ( $r ['function_id'], $arr [KEY_FUNCTION] ) === FALSE) {
                    $arr [KEY_FUNCTION] [] = $r ['function_id'];
                }
            }
        }
        
        return $arr;
    }
}

// Do authenticate for an account
if (! function_exists ( 'do_authenticate' )) {
    function do_authenticate($group = '', $function = '', $authenticate = TRUE) {
        // Check access rights
        if (! is_logged_in ()) {
            redirect ( "../index.php?url=" . urlencode ( $_SERVER ['REQUEST_URI'] ) );
        }
        
        // Set group & function
        set_site_function ( $group, (is_array ( $function )) ? $function [0] : $function );
        
        // Check access rights
        if ($authenticate) {
            $account = current_account ();
            
            if ($function != '') {
                $type = KEY_FUNCTION;
                $data = $function;
            } else {
                $type = KEY_GROUP;
                $data = $group;
            }
            
            $is_access = verify_access_right ( $account, $data, $type );
            
            if (! $is_access) {
                redirect ( "../part/access_forbidden.php?url=" . urlencode ( $_SERVER ['REQUEST_URI'] ) );
            }
        }
    }
}

// Check if an account has 'admin' role
if (! function_exists ( 'is_admin' )) {
    function is_admin($account) {
        $model = new account_role_of_employee ();
        $list = $model->list_role_of_account ( $account );
        
        if (is_array ( $list ) && count ( $list ) > 0) {
            foreach ( $list as $r ) {
                if ($r->role_id === ROLE_ADMIN) {
                    return TRUE;
                }
            }
        }
        
        return FALSE;
    }
}

// Check if an account only has 'freelancer' role
if (! function_exists ( 'is_freelancer' )) {
    function is_freelancer($account) {
        $model = new account_role_of_employee ();
        $list = $model->list_role_of_account ( $account );
        
        if (is_array ( $list ) && count ( $list ) === 1) {
            foreach ( $list as $r ) {
                if ($r->role_id === ROLE_FREELANCER) {
                    return TRUE;
                }
            }
        }
        
        return FALSE;
    }
}

// Get default site of an account
if (! function_exists ( 'default_site' )) {
    function default_site($username) {
        if (is_freelancer ( $username )) {
            return "../view/store.php";
        } else {
            return "../employees/dashboard.php";
        }
    }
}

// Get sub item css class
if (! function_exists ( 'get_sub_css' )) {
    function get_sub_css($group, $echo = TRUE) {
        $css = (get_site_function ( KEY_GROUP ) == $group) ? "nav-top-item current" : "nav-top-item";
        
        // Output result
        if ($echo) {
            echo $css;
        }
        return $css;
    }
}

// Get item css class
if (! function_exists ( 'get_item_css' )) {
    function get_item_css($function, $echo = TRUE) {
        $css = "";
        
        if (is_array ( $function )) {
            if (in_array ( get_site_function (), $function ) !== FALSE) {
                $css = "current";
            } else {
                $css = "";
            }
        } else {
            $css = (get_site_function () == $function) ? "current" : "";
        }
        
        // Output result
        if ($echo) {
            echo $css;
        }
        return $css;
    }
}
?>
