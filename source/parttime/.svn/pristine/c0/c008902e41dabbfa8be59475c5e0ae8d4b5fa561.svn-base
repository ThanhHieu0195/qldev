<?php
require_once '../part/common_start_page.php';
require_once '../models/account_function.php';
require_once '../models/account_function_group.php';
require_once '../models/account_function_of_role.php';
require_once '../models/account_role_group.php';
require_once '../models/account_role_of_employee.php';

$result = array (
        'result' => 0, // Error status
                       // 0: Error occurred
                       // 1: There is no data
                       // 2: Success
        'flag' => 0, // 0: Disable; 1: Enable
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => ''  // Detail message
);

if (verify_access_right ( current_account (), F_DECENTRALIZE_ROLE_GROUP )) {
    
    // DB model
    $role_group_model = new account_role_group ();
    
    try {
        // Enable/Disable a role group
        if (isset ( $_REQUEST ['enable_role'] )) {
            // Get input data
            $role_id = $_REQUEST ['role_id'];
            $enable = $_REQUEST ['enable'];
            
            // Enable/Disable role group
            if ($role_group_model->enable ( $role_id, $enable )) {
                $result ['result'] = 1;
                $result ['message'] = '';
            } else {
                $result ['message'] = $role_group_model->getMessage ();
            }
        }
        
        // Get list function include 'checked' status (if any) of a role group
        if (isset ( $_REQUEST ['load_functions'] )) {
            // Get input data
            $role_id = (isset ( $_REQUEST ['role_id'] )) ? $_REQUEST ['role_id'] : "";
            
            // Get list function of a role group
            $arr = array ();
            if ($role_id != "") {
                $function_of_role_model = new account_function_of_role ();
                $list = $function_of_role_model->list_role_of_role ( $role_id );
                foreach ( $list as $l ) {
                    if (! in_array ( $l->function_id, $arr )) {
                        $arr [] = $l->function_id;
                    }
                }
            }
            // debug($arr);
            
            $function_group_model = new account_function_group ();
            $groups = $function_group_model->list_group ();
            
            $function_model = new account_function ();
            
            // Create result array
            $output = array ();
            foreach ( $groups as $g ) {
                $temp = array (
                        'group_id' => $g->group_id,
                        'group_name' => $g->group_name,
                        'functions' => array () 
                );
                
                $functions = $function_model->list_function_of_group ( $g->group_id );
                
                foreach ( $functions as $f ) {
                    $z = array (
                            'function_id' => $f->function_id,
                            'function_name' => $f->function_name,
                            'note' => $f->note,
                            'checked' => (in_array ( $f->function_id, $arr )) ? 1 : 0 
                    );
                    $temp ['functions'] [] = $z;
                }
                
                $output [] = $temp;
            }
            // debug ( json_encode ( $output ) );
            
            // Output
            $result ['result'] = 1;
            $result ['message'] = '';
            $result ['detail'] = $output;
            $result ['flag'] = ($role_id == ROLE_ADMIN) ? 0 : 1;
        }
        
        // Create a new role group
        if (isset ( $_REQUEST ['create_role'] )) {
            // Get input data
            $role_id = $_REQUEST ['role_id'];
            $role_name = $_REQUEST ['role_name'];
            $enable = (isset ( $_REQUEST ['enable'] )) ? BIT_TRUE : BIT_FALSE;
            $functions = $_REQUEST ['function'];
            
            // Check 'role_id': chi cho phep cac ky tu 0-9, a-z, A-Z, _
            if (! isset ( $role_id ) || empty ( $role_id ) || ! is_valid_uid ( $role_id )) {
                $result ['message'] = 'Mã nhóm quyền chỉ cho phép chứa các ký tự: ' . VALIDATE_UID . '.';
            } else {
                
                // DB model
                $role_group_model = new account_role_group ();
                $function_of_role_model = new account_function_of_role ();
                
                // Insert new role group into database
                $role = new account_role_group_entity ();
                $role->role_id = $role_id;
                $role->role_name = $role_name;
                $role->enable = $enable;
                
                if ($role_group_model->insert ( $role )) {
                    $result ['result'] = 1;
                    $result ['message'] = "Thực hiện thêm nhóm quyền thành công!";
                    
                    // Warning list
                    $warning = array ();
                    
                    if (is_array ( $functions ) && count ( $functions ) > 0) {
                        // Create an entity
                        $item = new account_function_of_role_entity ();
                        $item->role_id = $role_id;
                        
                        // Insert function list of above role
                        foreach ( $functions as $f ) {
                            $item->function_id = $f;
                            if ($function_of_role_model->insert ( $item )) {
                                // Do nothing
                            } else {
                                $warning [] = array (
                                        'function_id' => $f,
                                        'error' => $function_of_role_model->getMessage () 
                                );
                            }
                        }
                    }
                    
                    // Set warning message
                    $result ['warning'] = $warning;
                } else {
                    $result ['message'] = $role_group_model->getMessage ();
                }
            }
        }
        
        // Update a role group
        if (isset ( $_REQUEST ['update_role'] )) {
            // Get input data
            $role_id = $_REQUEST ['role_id'];
            $role_name = $_REQUEST ['role_name'];
            $enable = (isset ( $_REQUEST ['enable'] )) ? BIT_TRUE : BIT_FALSE;
            $functions = $_REQUEST ['function'];
            
            // Check 'role_id': chi cho phep cac ky tu 0-9, a-z, A-Z, _
            if (! isset ( $role_id ) || empty ( $role_id ) || ! is_valid_uid ( $role_id )) {
                $result ['message'] = 'Mã nhóm quyền chỉ cho phép chứa các ký tự: ' . VALIDATE_UID . '.';
            } else {
                if ($role_id == ROLE_ADMIN) {
                    $result ['message'] = "Không cho phép thay đổi thông tin của nhóm quyền '{$role_id}'";
                } else {
                    // DB model
                    $role_group_model = new account_role_group ();
                    $function_of_role_model = new account_function_of_role ();
                    
                    // Get role group information from database
                    $role = $role_group_model->detail ( $role_id );
                    if ($role == NULL) {
                        $result ['message'] = "Không tìm thấy thông tin của nhóm quyền '{$role_id}'";
                    } else {
                        // Update information
                        $role->role_name = $role_name;
                        $role->enable = $enable;
                        
                        if ($role_group_model->update ( $role )) {
                            // Delete old function list
                            if ($function_of_role_model->delete_by_role ( $role_id )) {
                                // Result
                                $result ['result'] = 1;
                                $result ['message'] = "Thực hiện cập nhật nhóm quyền thành công!";
                                
                                // Warning list
                                $warning = array ();
                                
                                // Insert new function list
                                if (is_array ( $functions ) && count ( $functions ) > 0) {
                                    // Create an entity
                                    $item = new account_function_of_role_entity ();
                                    $item->role_id = $role_id;
                                    
                                    // Insert function list of above role
                                    foreach ( $functions as $f ) {
                                        $item->function_id = $f;
                                        if ($function_of_role_model->insert ( $item )) {
                                            // Do nothing
                                        } else {
                                            $warning [] = array (
                                                    'function_id' => $f,
                                                    'error' => $function_of_role_model->getMessage () 
                                            );
                                        }
                                    }
                                }
                                
                                // Set warning message
                                $result ['warning'] = $warning;
                            } else {
                                $result ['message'] = "Cannot remove old function list of '{$role_id}' role group";
                            }
                        } else {
                            $result ['message'] = $role_group_model->getMessage ();
                        }
                    }
                }
            }
        }
    } catch ( Exception $e ) {
        $result ['message'] = $e->getMessage ();
    }
}

echo json_encode ( $result );
// echo $result ['detail'];
// ob_end_flush();
require_once '../part/common_end_page.php';
?>