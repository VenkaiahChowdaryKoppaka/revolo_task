<?php

class TruckModel
{
    public $truck_id;
    public $reg_no;
    public $capacity;
    public $mfg_year;
    public $available_from;
    public $available_to;
    public $added_by;
    public $updated_on;

    public $booking_id;
    public $user_name;
    public $loc_from;
    public $loc_to;
    public $booking_date;
    public $booking_capacity;

    public $user_id;
    public $name;
    public $mobile;
    public $email;
    public $password;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function login()
    {
        $this->db->query('SELECT id FROM users WHERE `email` = :email AND `password` = :pswd');
        $this->db->bind(':email', $this->email);
        $this->db->bind(':pswd', $this->password);
        $this->db->single();
        if ($this->db->rowCount() > 0) {
            $this->row = $this->db->single();
            $resp['status'] = 'success';
            $resp['data'] = $this->row;
        } else {
            $resp['status'] = 'error';
        }
        return $resp;
    }

    public function addTruck()
    {
        $this->db->query("INSERT INTO `trucks`(`truck_id`, `company_name` , `owner_id`, `reg_no`, `capacity`, `mfg_year`, `availabilty_from`, `availabilty_to`, `added_by`) VALUES (:truck_id,:company_name,:owner_id,:reg_no,:capacity,:mfg_year,:availabilty_from,:availabilty_to,:added_by)");
        $this->db->bind(":truck_id", $this->truck_id);
        $this->db->bind(":company_name", $this->company_name);
        $this->db->bind(":owner_id", $_SESSION['uid']);
        $this->db->bind(":reg_no", $this->reg_no);
        $this->db->bind(":capacity", $this->capacity);
        $this->db->bind(":mfg_year", $this->mfg_year);
        $this->db->bind(":availabilty_from", $this->availabilty_from);
        $this->db->bind(":availabilty_to", $this->availabilty_to);
        $this->db->bind(":added_by", $_SESSION['uid']);
        $data = $this->db->execute();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function check_reg_no()
    {
        $this->db->query("SELECT * FROM trucks WHERE reg_no = :reg_no");
        $this->db->bind("reg_no", $this->reg_no);
        $data = $this->db->resultSet();
        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTruck()
    {
        $this->db->query("UPDATE trucks SET company_name = :company_name, owner_id=:owner_id, reg_no=:reg_no, capacity=:capacity, mfg_year=:mfg_year, availabilty_from=:availabilty_from, availabilty_to=:availabilty_to, added_by=:added_by WHERE truck_id=:truck_id");
        $this->db->bind(":truck_id", $this->truck_id);
        $this->db->bind(":company_name", $this->company_name);
        $this->db->bind(":owner_id", $_SESSION['uid']);
        $this->db->bind(":reg_no", $this->reg_no);
        $this->db->bind(":capacity", $this->capacity);
        $this->db->bind(":mfg_year", $this->mfg_year);
        $this->db->bind(":availabilty_from", $this->availabilty_from);
        $this->db->bind(":availabilty_to", $this->availabilty_to);
        $this->db->bind(":added_by", $_SESSION['uid']);
        $data = $this->db->execute();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function truckDetailsByID()
    {
        $this->db->query('SELECT * FROM trucks WHERE `truck_id` = :truck_id');
        $this->db->bind(':truck_id', $this->truck_id);
        $this->db->single();
        if ($this->db->rowCount() > 0) {
            $this->row = $this->db->single();
            $this->row->status = 'success';
        } else {
            $this->row->status = 'error';
        }
        return $this->row;
    }

    public function truckDetails()
    {
        $this->db->query('SELECT * FROM trucks ORDER BY id ASC');
        $result = $this->db->resultSet();
        if (count($result) > 0) {
            return $result;
        } else {
            return array();
        }
    }

    public function truckDetailsNotMine()
    {
        $this->db->query('SELECT * FROM trucks WHERE owner_id != :owner_id ORDER BY id ASC');
        $this->db->bind("owner_id", $this->owner_id);
        $result = $this->db->resultSet();
        if (count($result) > 0) {
            return $result;
        } else {
            return array();
        }
    }

    public function myBookings()
    {
        $this->db->query('SELECT * FROM bookings WHERE `booked_by` = :booked_by ORDER BY booking_id ASC');
        $this->db->bind(":booked_by", $this->booked_by);
        $result = $this->db->resultSet();
        return $result;
    }

    public function Bookings()
    {
        $this->db->query('SELECT * FROM bookings WHERE `truck_owner_id` = :truck_owner_id ORDER BY booking_id ASC');
        $this->db->bind(":truck_owner_id", $this->truck_owner_id);
        $result = $this->db->resultSet();
        return $result;
    }

    public function addBooking()
    {
        $this->db->query("INSERT INTO `bookings`(`booking_id`, `truck_id`, `user_name`, `loc_from`, `loc_to`, `booking_date`, `booking_weight`, `truck_owner_id`, `booked_by`) VALUES (:booking_id, :truck_id, :user_name, :loc_from, :loc_to, :booking_date, :booking_weight, :truck_owner_id, :booked_by)");
        $this->db->bind(":booking_id", $this->booking_id);
        $this->db->bind(":truck_id", $this->truck_id);
        $this->db->bind(":user_name", $this->user_name);
        $this->db->bind(":truck_owner_id", $this->truck_owner_id);
        $this->db->bind(":loc_from", $this->loc_from);
        $this->db->bind(":loc_to", $this->loc_to);
        $this->db->bind(":booking_weight", $this->booking_weight);
        $this->db->bind(":booking_date", $this->booking_date);
        $this->db->bind(":booked_by", $this->booked_by);
        $data = $this->db->execute();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function myTrucks()
    {
        $this->db->query('SELECT * FROM trucks WHERE `owner_id` = :owner_id ORDER BY id ASC');
        $this->db->bind(":owner_id", $this->user_id);
        $result = $this->db->resultSet();
        return $result;
    }

    public function deleteTruck()
    {
        $this->db->query('DELETE FROM trucks WHERE `truck_id` = :truck_id');
        $this->db->bind(":truck_id", $this->truck_id);
        $result = $this->db->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function capacity_details()
    {
        $trucks = $this->truckDetails();
        $data = array();
        foreach ($trucks as $truck) {
            $truck_id = $truck->truck_id;
            $available_from = $truck->availabilty_from;
            $available_to = $truck->availabilty_to;
            $capacity = $truck->capacity;
            $data[$truck_id]['capacity'] = $capacity;
            $this->db->query("SELECT SUM(booking_weight) as capacity FROM `bookings` WHERE truck_id = :truck_id AND booking_date BETWEEN :available_from AND :available_to");
            $this->db->bind("truck_id", $truck_id);
            $this->db->bind("available_from", $available_from);
            $this->db->bind("available_to", $available_to);
            $booked_capacity = $this->db->single();
            $data[$truck_id]['booked_capacity'] = $booked_capacity->capacity;
            $data[$truck_id]['balance_capacity'] = (float)$capacity - (float)$booked_capacity->capacity;
        }
        return $data;
    }
}
