<?php
require_once '../part/common_start_page.php';
require_once '../models/finance_token.php';
require_once '../models/finance_token_detail.php';
require_once '../models/finance_reference.php';
require_once '../models/finance_product.php';
require_once '../models/finance_category.php';
require_once '../models/finance_item.php';

$result = array (
        'result' => "error", // Error status
        'message' => 'Thực hiện thao tác thất bại.', // Message
        'detail' => array (), // Detail message
        'enable' => BIT_FALSE 
);

if (verify_access_right ( current_account (), F_SYSTEM_ADMIN_FINANCE )) {
    
    try {
        // Enable/Disable an reference item
        if (isset ( $_POST ['enable_reference'] )) {
            // Get input data
            $uid = $_POST ['uid'];
            
            // DB model
            $model = new finance_reference ();
            
            // Get item detail
            $item = $model->detail ( $uid );
            if ($item != NULL) {
                // Change enable status
                $enable = BIT_FALSE;
                if ($item->enable == BIT_TRUE) {
                    $enable = BIT_FALSE;
                } else {
                    $enable = BIT_TRUE;
                }
                $item->enable = $enable;
                
                // Update to database
                if ($model->update ( $item )) {
                    $result ['result'] = "success";
                    $result ['message'] = "Thực hiện thao tác thành công";
                    $result ['enable'] = $enable;
                } else {
                    $result ['message'] = $model->getMessage ();
                }
            } else {
                $result ['message'] = "Không tìm thấy reference '{$uid}'";
            }
        }
        
        // Enable/Disable a product item
        if (isset ( $_POST ['enable_product'] )) {
            // Get input data
            $uid = $_POST ['uid'];
            
            // DB model
            $model = new finance_product ();
            
            // Get item detail
            $item = $model->detail ( $uid );
            if ($item != NULL) {
                // Change enable status
                $enable = BIT_FALSE;
                if ($item->enable == BIT_TRUE) {
                    $enable = BIT_FALSE;
                } else {
                    $enable = BIT_TRUE;
                }
                $item->enable = $enable;
                
                // Update to database
                if ($model->update ( $item )) {
                    $result ['result'] = "success";
                    $result ['message'] = "Thực hiện thao tác thành công";
                    $result ['enable'] = $enable;
                } else {
                    $result ['message'] = $model->getMessage ();
                }
            } else {
                $result ['message'] = "Không tìm thấy product '{$uid}'";
            }
        }
        
        // Enable/Disable a category item
        if (isset ( $_POST ['enable_category'] )) {
            // Get input data
            $uid = $_POST ['uid'];
            
            // DB model
            $model = new finance_category ();
            
            // Get item detail
            $item = $model->detail ( $uid );
            if ($item != NULL) {
                // Change enable status
                $enable = BIT_FALSE;
                if ($item->enable == BIT_TRUE) {
                    $enable = BIT_FALSE;
                } else {
                    $enable = BIT_TRUE;
                }
                $item->enable = $enable;
                
                // Update to database
                if ($model->update ( $item )) {
                    $result ['result'] = "success";
                    $result ['message'] = "Thực hiện thao tác thành công";
                    $result ['enable'] = $enable;
                } else {
                    $result ['message'] = $model->getMessage ();
                }
            } else {
                $result ['message'] = "Không tìm thấy category '{$uid}'";
            }
        }
        
        // Add new category and its items
        if (isset ( $_POST ['add_category'] )) {
            // Get input data
            $category_id = $_POST ['category_id'];
            $category_name = $_POST ['category_name'];
            $category_enable = isset ( $_POST ['category_enable'] );
            $item_name_list = $_POST ['item_name'];
            $item_enable_list = $_POST ['item_enable'];
            $category_used_type = $_POST ['used_type'];
            
            // Filter item list
            $items = array ();
            for($i = 0; $i < count ( $item_name_list ); $i ++) {
                if (! empty ( $item_name_list [$i] )) {
                    $items [] = array (
                            'name' => $item_name_list [$i],
                            'enable' => $item_enable_list [$i] 
                    );
                }
            }
            
            // DB model
            $category_model = new finance_category ();
            $item_model = new finance_item ();
            
            // Create a category
            $cat = new finance_category_entity ();
            $cat->category_id = $category_id;
            $cat->name = $category_name;
            $cat->enable = $category_enable;
            $cat->used_type = $category_used_type;
            
            if ($category_model->insert ( $cat )) {
                // Warning message list
                $warning = array ();
                
                if (count ( $items ) > 0) {
                    // Add items list to database
                    foreach ( $items as $z ) {
                        $t = new finance_item_entity ();
                        $t->category_id = $cat->category_id;
                        $t->name = $z ['name'];
                        $t->enable = $z ['enable'];
                        
                        if ($item_model->insert ( $t )) {
                            // Do nothing
                        } else {
                            $warning [] = array (
                                    'name' => $t->name,
                                    'error' => $item_model->getMessage () 
                            );
                        }
                    }
                }
                
                // Output result
                if (count ( $warning ) > 0) {
                    $result ['result'] = "success";
                    $result ['message'] = "Thực hiện thêm loại chi phí thành công. Tuy nhiên có một số lỗi khi thêm loại chi phí chi tiết như sau:";
                } else {
                    $result ['result'] = "warning";
                    $result ['message'] = "Thực hiện thêm loại chi phí thành công.";
                }
                $result ['detail'] = $warning;
            } else {
                $result ['message'] = "Lỗi thêm loại chi phí: '{$category_model->getMessage()}'";
            }
        }
        
        // Load items by category
        if (isset ( $_POST ['load_items_by_category'] )) {
            // Get input data
            $category_id = $_POST ['category_id'];
            
            // DB model
            $item_model = new finance_item ();
            $arr = $item_model->list_by_category ( $category_id, TRUE );
            $items = array ();
            if (is_array ( $arr ) && count ( $arr ) > 0) {
                foreach ( $arr as $z ) {
                    $items [] = array (
                            'id' => $z->item_id,
                            'name' => $z->name,
                            'enable' => $z->enable 
                    );
                }
            }
            
            // Output result
            $result ['result'] = "success";
            $result ['message'] = sprintf ( "Found '%d' item(s)", count ( $items ) );
            $result ['items'] = $items;
        }
        
        // Update a category and its items
        if (isset ( $_POST ['update_category'] )) {
            // Get input data
            $category_id = $_POST ['category_id'];
            $category_name = $_POST ['category_name'];
            $category_enable = isset ( $_POST ['category_enable'] );
            $item_id_list = $_POST ['item_id'];
            $item_name_list = $_POST ['item_name'];
            $item_enable_list = $_POST ['item_enable'];
            $category_used_type = $_POST ['used_type'];
            
            // Filter item list
            $items = array ();
            for($i = 0; $i < count ( $item_id_list ); $i ++) {
                if (! empty ( $item_id_list [$i] )) {
                    $items [] = array (
                            'id' => $item_id_list [$i],
                            'name' => $item_name_list [$i],
                            'enable' => $item_enable_list [$i] 
                    );
                } elseif (! empty ( $item_name_list [$i] )) {
                    $items [] = array (
                            'id' => '',
                            'name' => $item_name_list [$i],
                            'enable' => $item_enable_list [$i] 
                    );
                }
            }
            
            // DB model
            $category_model = new finance_category ();
            $item_model = new finance_item ();
            
            // Get category detail
            $cat = $category_model->detail ( $category_id );
            if ($cat != NULL) {
                // Update information of category
                $cat->name = $category_name;
                $cat->enable = $category_enable;
                $cat->used_type = $category_used_type;
                if ($category_model->update ( $cat )) {
                    // Warning message list
                    $warning = array ();
                    
                    if (count ( $items ) > 0) {
                        // Add/Update items list to database
                        foreach ( $items as $z ) {
                            if (! empty ( $z ['id'] )) { // Existing item
                                if (empty ( $z ['name'] )) {
                                    $warning [] = array (
                                            'name' => $z ['id'],
                                            'error' => "Tên loại chi phí chi tiết không hợp lệ" 
                                    );
                                } else {
                                    // Get detail from database
                                    $t = $item_model->detail ( $z ['id'] );
                                    if ($t != NULL) {
                                        $t->name = $z ['name'];
                                        $t->enable = $z ['enable'];
                                        
                                        if ($item_model->update ( $t )) {
                                            // Do nothing
                                        } else {
                                            $warning [] = array (
                                                    'name' => $t->name,
                                                    'error' => $item_model->getMessage () 
                                            );
                                        }
                                    } else {
                                        $warning [] = array (
                                                'name' => $z ['id'],
                                                'error' => "Không tìm thấy thông tin trong table 'finance_item'" 
                                        );
                                    }
                                }
                            } else { // New item
                                $t = new finance_item_entity ();
                                $t->category_id = $cat->category_id;
                                $t->name = $z ['name'];
                                $t->enable = $z ['enable'];
                                
                                if ($item_model->insert ( $t )) {
                                    // Do nothing
                                } else {
                                    $warning [] = array (
                                            'name' => $t->name,
                                            'error' => $item_model->getMessage () 
                                    );
                                }
                            }
                        }
                    }
                    
                    // Output result
                    if (count ( $warning ) > 0) {
                        $result ['result'] = "success";
                        $result ['message'] = "Thực hiện cập nhật loại chi phí thành công. Tuy nhiên có một số lỗi khi thêm loại chi phí chi tiết như sau:";
                    } else {
                        $result ['result'] = "warning";
                        $result ['message'] = "Thực hiện cập nhật loại chi phí thành công.";
                    }
                    $result ['detail'] = $warning;
                } else {
                    $result ['message'] = "Lỗi cập nhật thông tin loại chi phí: '{$category_model->getMessage ()}'";
                }
            } else {
                $result ['message'] = "Không tìm thấy chi tiết loại chi phí '{$category_id}'";
            }
        }
        
        // Do nothing
        //
    } catch ( Exception $e ) {
        $result ['message'] = $e->getMessage ();
    }
}

echo json_encode ( $result );
// echo $result ['detail'];
// ob_end_flush();
require_once '../part/common_end_page.php';
?>