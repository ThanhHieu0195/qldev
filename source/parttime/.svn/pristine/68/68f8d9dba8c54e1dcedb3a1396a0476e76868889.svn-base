<?php
require_once '../entities/news_entity.php';
require_once '../models/database.php';
class news extends database {
    // Insert new item
    public function insert(news_entity $item) {
        // Set the order of that news
        $item->news_order = 1;
        // $item->news_order = $this->get_max_order ( $item->group_id, FALSE ) + 1;
        
        $sql = "INSERT INTO `news` (`news_id`, `group_id`, `title`, `summary`, 
                                    `content`, `created_date`, `last_modified`, `news_order`, `enable`)
                VALUES ('{$item->news_id}', '{$item->group_id}', '{$item->title}', '{$item->summary}', 
                        '{$item->content}', '{$item->created_date}', '{$item->last_modified}', '{$item->news_order}', '{$item->enable}'); ";
        
        // debug($sql);
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        // Re-order all items of that group
        if ($result) {
            $this->correct_order ( $item->group_id, $item->news_order );
        }
        
        return $result;
    }
    
    // Update an item
    public function update(news_entity $item, $old_group_id = '') {
        $sql = "UPDATE `news` 
                SET
                    `group_id` = '{$item->group_id}' , 
                    `title` = '{$item->title}' , 
                    `summary` = '{$item->summary}' , 
                    `content` = '{$item->content}' , 
                    `created_date` = '{$item->created_date}' , 
                    `last_modified` = '{$item->last_modified}' ,
                    `news_order` = '{$item->news_order}' ,  
                    `enable` = '{$item->enable}'
                WHERE
                    `news_id` = '{$item->news_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        // Re-order all items of that group
        if ($result) {
            if (! empty ( $old_group_id ) && $old_group_id != $item->group_id) {
                $this->correct_order ( $old_group_id );
                $this->correct_order ( $item->group_id );
            }
        }
        
        return $result;
    }
    
    // Get detail of an item
    public function detail($news_id) {
        $sql = "SELECT * FROM `news` WHERE `news_id` = '{$news_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new news_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Get detail of an item
    public function detail_by_order($group_id, $news_order) {
        $sql = "SELECT * FROM `news` WHERE `group_id` = '{$group_id}' AND `news_order` = '{$news_order}' LIMIT 1 ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new news_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Get detail of an item
    public function get_latest() {
        $enable = BIT_TRUE;
        $sql = "SELECT * FROM `news` WHERE `enable` = '{$enable}' ORDER BY last_modified DESC LIMIT 1 ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new news_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    
    // Get maximum ordering by a group
    public function get_max_order($group_id, $auto_disconnect = TRUE) {
        $sql = "SELECT MAX(news_order) AS num FROM news WHERE group_id = '{$group_id}'";
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        // Disconnect
        if ($auto_disconnect) {
            $this->disconnect ();
        }
        
        // Output result
        if (is_array ( $array )) {
            return $array ['num'];
        }
        
        return 0;
    }
    
    // Update order of an item
    public function re_order($news_id, $news_order) {
        $sql = "UPDATE `news` SET `news_order` = '{$news_order}' WHERE `news_id` = '{$news_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    
    // Re-order of news list in a group
    public function correct_order($group_id, $start_num = 0, $seed = NULL, $except_news = NULL) {
        // Get all news an their ordering
        $sql = "SELECT news_id, news_order FROM news WHERE group_id = '{$group_id}' AND news_order >= '{$start_num}' 
                ORDER BY news_order ASC, created_date DESC";
        $this->setQuery ( $sql );
        $arr = $this->loadAllRow ();
        $this->disconnect ();
        
        // Processing
        if (is_array ( $arr )) {
            if ($start_num <= 0) {
                $start_num = 1;
            }
            // Start counting
            $i = $start_num;
            if ($seed != NULL) {
                $i = $seed;
            }
            // Update order of items
            foreach ( $arr as $row ) {
                // Skip the specified item
                if ($except_news != NULL && $row ['news_id'] == $except_news) {
                    continue;
                }
                // Change order of the news
                if ($row ['news_order'] != $i) {
                    $this->re_order ( $row ['news_id'], $i );
                }
                
                $i ++;
            }
        }
    }
    private function create_search_condition($keyword) {
        if (empty ( $keyword )) {
            return "";
        }
        
        $str = " AND (`title` LIKE '%{$keyword}%' OR `summary` LIKE '%{$keyword}%' OR `content` LIKE '%{$keyword}%') ";
        return $str;
    }
    public function num_of_news($group_id, $keyword = "", $all = FALSE) {
        $tmp = $this->create_search_condition ( $keyword );
        $sql = "SELECT COUNT(news_id) AS num FROM news WHERE group_id = '{$group_id}' $tmp ";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " AND enable = '{$enable}' ";
        }
        
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        $this->disconnect ();
        
        // Output result
        if (is_array ( $array )) {
            return $array ['num'];
        }
        
        return 0;
    }
    public function list_news($group_id, $position, $items_per_group, $keyword = "") {
        $tmp = $this->create_search_condition ( $keyword );
        $enable = BIT_TRUE;
        $sql = "SELECT news_id, title, summary, last_modified 
                FROM news
                WHERE group_id = '{$group_id}' AND enable = '{$enable}' $tmp
                ORDER BY news_order ASC LIMIT $position, $items_per_group";
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return $result;
    }
}

/* End of file */