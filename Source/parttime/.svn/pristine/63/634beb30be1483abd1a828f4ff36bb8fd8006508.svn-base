<?php
require_once '../entities/guest_events_entity.php';
require_once '../models/database.php';
class guest_events extends database {
    public function insert(guest_events_entity $item) {
        $sql = "INSERT INTO `guest_events` 
                    (`uid`, `guest_id`, `event_date`, 
                    `note`, `is_event`, `enable`
                    )
                VALUES
                    ('{$item->uid}', '{$item->guest_id}', '{$item->event_date}', 
                    '{$item->note}', '{$item->is_event}', '{$item->enable}'
                    );";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete_by_guest($guest_id, $all_event = FALSE) {
        $sql = "DELETE FROM `guest_events` WHERE `guest_id` = '{$guest_id}' ";
        if (! $all_event) {
            $is_event = BIT_TRUE;
            $sql .= " AND `is_event` = '{$is_event}'";
        }
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_by_guest($guest_id, $all_event = FALSE) {
        $sql = "SELECT * 
                FROM `guest_events`
                WHERE `guest_id` = '{$guest_id}' ";
        if (! $all_event) {
            $is_event = BIT_TRUE;
            $sql .= " AND `is_event` = '{$is_event}'";
        }
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new guest_events_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
    public function list_by_time($start, $end, $guest_id = '', $all = FALSE) {
        $where = " (`event_date` BETWEEN '{$start}' AND '{$end}') ";
        if (! empty ( $guest_id )) {
            $where .= " AND (`guest_id` = '{$guest_id}') ";
        }
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " AND `enable` = '{$enable}'";
        }
        
        $sql = "SELECT * FROM `guest_events` WHERE $where ";
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new guest_events_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
    public function is_existing_schedule($guest_id, $date) {
        $sql = "SELECT `uid` FROM `guest_events` WHERE `guest_id` = '{$guest_id}' AND `event_date` = '{$date}'";
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return ((is_array ( $result ) && count ( $result ) > 0));
    }
    public function statistic_amount_by_time($start, $end, $employee_id = '', $all = FALSE) {
        $tmp = "";
        
        // Get enabled events
        if (! $all) {
            $enable = BIT_TRUE;
            $tmp .= " AND e.enable = '{$enable}' ";
        }
        // Get events by employee
        if (! empty ( $employee_id )) {
            $tmp .= " AND r.employee_id = '{$employee_id}' ";
        }
        // Get events of guests that is developing
        $development = GUEST_DEVELOPMENT_ONGOING;
        $tmp .= " AND k.development = '{$development}' ";
        
        $sql = "SELECT e.event_date, e.guest_id, r.employee_id, k.hoten, k.development, n.hoten AS tennv
                FROM guest_events e INNER JOIN guest_responsibility r ON e.guest_id = r.guest_id
                                    INNER JOIN khach k ON e.guest_id = k.makhach
                                    INNER JOIN nhanvien n ON r.employee_id = n.manv
                WHERE (e.event_date BETWEEN '{$start}' AND '{$end}') $tmp
                ORDER BY e.event_date";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        if (is_array ( $result ) && count ( $result ) > 0) {
            $arr = array ();
            
            foreach ( $result as $r ) {
                // Check the date
                $date = $r ['event_date'];
                if (isset ( $arr [$date] )) {
                    // Do nothing
                } else {
                    $arr [$date] = array (
                            'event_date' => $date,
                            'employees' => array () 
                    );
                }
                
                // Check the employee
                $employee = $r ['employee_id'];
                if (isset ( $arr [$date] ['employees'] [$employee] )) {
                } else {
                    $arr [$date] ['employees'] [$employee] = array (
                            'id' => $employee,
                            'name' => $r ['tennv'],
                            'guests' => array () 
                    );
                }
                
                // Check the guest
                $guest = $r ['guest_id'];
                if (! isset ( $arr [$date] ['employees'] [$employee] ['guests'] [$guest] )) {
                    $arr [$date] ['employees'] [$employee] ['guests'] [] = $guest;
                }
            }
            
            return $arr;
        }
        
        return $result;
    }
    public function count_need_contacting($employee_id, $start, $end) {
        $enable = BIT_TRUE;
        $development = GUEST_DEVELOPMENT_ONGOING;
        $sql = "SELECT COUNT(DISTINCT(e.guest_id)) AS num
                FROM guest_events e INNER JOIN guest_responsibility r ON e.guest_id = r.guest_id
                                    INNER JOIN khach k ON e.guest_id = k.makhach
                WHERE e.enable = '{$enable}' 
                      AND (DATE(e.event_date) BETWEEN '{$start}' AND '{$end}')
                      AND r.employee_id = '{$employee_id}'
                      /* AND k.development = '{$development}' */ 
                ";
        
        $this->setQuery ( $sql );
        $result = mysql_fetch_assoc ( $this->query () );
        $this->disconnect ();
        
        if (is_array ( $result )) {
            return $result ['num'];
        }
        return 0;
    }
}

/* End of file */