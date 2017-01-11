<?php
require_once '../entities/guest_development_history_entity.php';
require_once '../models/database.php';
class guest_development_history extends database {
    public function insert(guest_development_history_entity $item) {
        $sql = "INSERT INTO `guest_development_history` 
                    (`uid`, `guest_id`, `created_date`, 
                    `employee_id`, `note`, `is_history`
                    )
                VALUES
                    ('{$item->uid}', '{$item->guest_id}', '{$item->created_date}', 
                    '{$item->employee_id}', '{$item->note}', '{$item->is_history}'
                    );";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_by_guest($guest_id) {
        $sql = "SELECT * FROM `guest_development_history` WHERE `guest_id` = '{$guest_id}' ORDER BY created_date";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new guest_development_history_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
    public function statistic_updated($from_date, $to_date, $employee_id = NULL) {
        $tmp = "";
        if (! empty ( $employee_id )) {
            $tmp = "AND h.employee_id = '{$employee_id}'";
        }
        $enable = BIT_TRUE;
        $sql = "SELECT k.hoten, k.diachi, k.dienthoai1, k.dienthoai2, k.email, n.hoten AS tennv, h.guest_id, h.employee_id
                FROM guest_development_history h INNER JOIN khach k ON h.guest_id = k.makhach
                                     INNER JOIN guest_responsibility r ON h.guest_id = r.guest_id
                                     INNER JOIN nhanvien n ON r.employee_id = n.manv
                WHERE (DATE(h.created_date) BETWEEN '{$from_date}' AND '{$to_date}') AND (h.is_history = '{$enable}') 
                      $tmp
                ORDER BY k.hoten";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Remove duplicate row(s)
        if (is_array ( $result ) && count ( $result ) > 0) {
            $arr = array (); // Result array
            $table = array (); // Checking table
                               
            // Overview statistic
            if (empty ( $employee_id )) {
                foreach ( $result as $r ) {
                    $e = $r ['employee_id']; // Employee Id of creator
                    $g = $r ['guest_id'];
                    
                    if (in_array ( $g, $table )) {
                        // Do nothing
                    } else {
                        $table [] = $g;
                        
                        // Add row to result array
                        $arr [] = $r;
                    }
                }
            } else { // Detail statistic
                foreach ( $result as $r ) {
                    $e = $r ['employee_id']; // Employee Id of creator
                    $g = $r ['guest_id'];
                    
                    if (isset ( $table [$e] )) {
                        if (! in_array ( $g, $table [$e] )) {
                            $table [$e] [] = $g;
                            
                            $arr [] = $r;
                        }
                    } else {
                        $table [$e] = array ();
                        $table [$e] [] = $g;
                        
                        // Add row to result array
                        $arr [] = $r;
                    }
                }
            }
            
            return $arr;
        }
        
        return $result;
    }
    public function calculate_guest_payment($from_date, $to_date, $guests, $calculate = TRUE) {
        // For calculating
        $amount = 0;
        $money = 0;
        
        // For get orders list
        $orders = array ();
        
        // Valid data
        if (is_array ( $guests )) {
            $tmp = "'" . str_replace ( ", ", "', '", implode ( ", ", $guests ) ) . "'";
            $approved = BIT_TRUE;
            $sql = "SELECT d.madon, d.ngaydat, d.ngaygiao, d.thanhtien, d.makhach, k.hoten, d.trangthai
                    FROM donhang d INNER JOIN khach k ON d.makhach = k.makhach
                    WHERE (DATE(d.ngaydat) BETWEEN '{$from_date}' AND '{$to_date}') AND d.makhach IN ({$tmp})
                          AND d.approved = '{$approved}'
                    ORDER BY d.ngaydat";
            
            $this->setQuery ( $sql );
            $result = $this->loadAllRow ();
            $this->disconnect ();
            
            // debug($result);
            if (is_array ( $result ) && count ( $result ) > 0) {
                
                // For calculating
                if ($calculate) {
                    $table = array (); // Checking array
                    
                    foreach ( $result as $r ) {
                        // The number of guests
                        if (! in_array ( $r ['makhach'], $table )) {
                            $amount ++;
                            
                            $table [] = $r ['makhach'];
                        }
                        
                        // The total of money
                        $money += $r ['thanhtien'];
                    }
                } else { // For get orders list
                    $orders = $result;
                }
            }
        }
        
        // Output result
        if ($calculate) {
            return array (
                    'payment_amount' => $amount,
                    'payment_money' => $money 
            );
        } else {
            return $orders;
        }
    }
    public function statistic_contacted($from_date, $to_date, $employee_id = '') {
        $tmp = "";
        if (! empty ( $employee_id )) {
            $tmp = "AND h.employee_id = '{$employee_id}'";
        }
        $enable = BIT_TRUE;
        $sql = "SELECT h.employee_id, n.hoten, h.guest_id
                FROM guest_development_history h INNER JOIN nhanvien n ON h.employee_id = n.manv
                WHERE DATE(h.created_date) BETWEEN '{$from_date}' AND '{$to_date}' AND (h.is_history = '{$enable}') 
                      $tmp
                ORDER BY h.employee_id
               ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Create result array
        if (is_array ( $result ) && count ( $result ) > 0) {
            $arr = array (); // Items array
                             
            // Remove duplicate row(s)
            foreach ( $result as $r ) {
                $e = $r ['employee_id'];
                $g = $r ['guest_id'];
                
                // Check employee
                if (! isset ( $arr [$e] )) {
                    $arr [$e] = array (
                            'employee_name' => $r ['hoten'],
                            'guests' => array () 
                    );
                }
                
                // Check guest
                if (! in_array ( $g, $arr [$e] ['guests'] )) {
                    $arr [$e] ['guests'] [] = $g;
                }
            }
            
            if (empty ( $employee_id )) {
                // Calculate the trading of guests
                foreach ( $arr as $key => $v ) {
                    // Get trading calculating
                    $tmp = $this->calculate_guest_payment ( $from_date, $to_date, $v ['guests'] );
                    
                    // Set the value
                    $arr [$key] ['payment_amount'] = $tmp ['payment_amount'];
                    $arr [$key] ['payment_money'] = $tmp ['payment_money'];
                }
                
                // Output result
                return $arr;
            } else {
                // Get orders list
                foreach ( $arr as $key => $v ) {
                    return $this->calculate_guest_payment ( $from_date, $to_date, $v ['guests'], FALSE );
                }
            }
        }
        
        return $result;
    }
    public function count_contacted($employee_id, $start, $end) {
        $enable = BIT_TRUE;
        $sql = "SELECT COUNT(DISTINCT(guest_id)) AS num
                FROM guest_development_history 
                WHERE employee_id = '{$employee_id}' AND (DATE(created_date) BETWEEN '{$start}' AND '{$end}') 
                      AND (`is_history` = '{$enable}')
                ";
        $sql= "select COUNT(DISTINCT(g.guest_id)) AS num from guest_events as g left join guest_responsibility as r on r.guest_id = g.guest_id left join guest_development_history as h on h.guest_id=g.guest_id where r.employee_id='".$employee_id."' and g.event_date='".$end."' and h.created_date like '%".$end."%' and h.is_history=1";
        //error_log ($sql, 3, '/var/log/phpdebug.log'); 
        $this->setQuery ( $sql );
        $result = mysql_fetch_assoc ( $this->query () );
        $this->disconnect ();
        
        if (is_array ( $result )) {
            return $result ['num'];
        }
        return 0;
    }
    public function check_updating($employee_id, $guest_id, $date) {
        $enable = BIT_TRUE;
        $sql = "SELECT guest_id 
                FROM guest_development_history 
                WHERE (guest_id = '{$guest_id}') 
                      AND (DATE(created_date) BETWEEN '{$date}' AND '{$date}')
                      AND (`is_history` = '{$enable}')
                ";
        //error_log ("HISTORY " . $sql, 3, '/var/log/phpdebug.log'); 
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return (is_array ( $result ) && count ( $result ) > 0);
    }
}

/* End of file */
