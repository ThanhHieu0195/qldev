<?php

require_once 'database.php';

class items_swapping_note extends database {
    
    // Them mot ghi chu vao trong database
    function add_new($create_date, $create_by, $swap_uid, $content)
    {
        $sql = "INSERT INTO items_swapping_note(id, create_date, create_by, swap_uid, content)
                VALUES('%s', '%s', '%s', '%s', '%s')";
        $sql = sprintf($sql, uniqid('', true), $create_date, $create_by, $swap_uid, $content);

        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Xoa mot ghi chu
    function delete($id)
    {
        $sql = "DELETE FROM items_swapping_note WHERE id = '%s'";
        $sql = sprintf($sql, $id);
    
        $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
    }
    
    // Danh sach cac ghi chu
    function get_notes_list($swap_uid)
    {
        $sql = "SELECT id, create_date, create_by, swap_uid, content
                FROM items_swapping_note
                WHERE swap_uid = '%s'
                ORDER BY create_date ASC";
        $sql = sprintf($sql, $swap_uid);
    
        $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
    
        return $result;
    }
}

/* End of file items_swapping_note.php */
/* Location: ./models/items_swapping_note.php */