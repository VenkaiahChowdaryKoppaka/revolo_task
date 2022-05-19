<?php

class Trucks extends Controller
{

    public function __construct()
    {
        $this->truck = $this->model('TruckModel');
        if (!isLoggedIn()) {
            redirect('home/login');
        }
    }

    public function addBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->truck->booking_id = $this->randomId();
            $this->truck->truck_id = $_POST['truck_id'];
            $this->truck->booked_by = $_SESSION['uid'];
            $this->truck->truck_owner_id = $_POST['owner_id'];
            $availabilty = explode("#", $_POST['availabilty']);
            $from_date = $availabilty[0];
            $to_date = $availabilty[1];

            $error = 0;
            $msg = '';

            if (isset($_POST['user_name']) && $_POST['user_name'] == '') {
                $error++;
                $msg .= ' User Name shouldnt Be Empty<br> ';
            } elseif (!preg_match('/^[a-zA-Z ]{3,50}$/', $_POST['user_name'])) {
                $error++;
                $msg .= ' Lenght of User Name should Be between 3 and 50 Characters<br> ';
            } else {
                $this->truck->user_name = $_POST['user_name'];
            }

            if (isset($_POST['loc_from']) && $_POST['loc_from'] == '') {
                $error++;
                $msg .= ' From Location shouldnt Be Empty<br> ';
            } elseif (!preg_match('/^[a-zA-Z ]{3,50}$/', $_POST['loc_from'])) {
                $error++;
                $msg .= ' Lenght of From Location should Be between 3 and 50 Characters<br> ';
            } else {
                $this->truck->loc_from = $_POST['loc_from'];
            }

            if (isset($_POST['loc_to']) && $_POST['loc_to'] == '') {
                $error++;
                $msg .= ' To Location shouldnt Be Empty<br> ';
            } elseif (!preg_match('/^[a-zA-Z ]{3,50}$/', $_POST['loc_to'])) {
                $error++;
                $msg .= ' Lenght of To Location should Be between 3 and 50 Characters<br> ';
            } else {
                $this->truck->loc_to = $_POST['loc_to'];
            }

            if (isset($_POST['booking_weight']) && $_POST['booking_weight'] == '') {
                $error++;
                $msg .= ' Booking Weight shouldnt Be Empty<br> ';
            } elseif (!preg_match('/^[0-9]{1,3}$/', $_POST['booking_weight'])) {
                $error++;
                $msg .= ' Booking Weight wont be higher than 999<br> ';
            } else {
                $this->truck->booking_weight = $_POST['booking_weight'];
            }

            if (isset($_POST['booking_date']) && $_POST['booking_date'] == '') {
                $error++;
                $msg .= ' Booking Date shouldnt Be Empty<br> ';
            } elseif (date("Y-m-d", strtotime($_POST['booking_date'])) < date("Y-m-d", strtotime($from_date)) || date("Y-m-d", strtotime($_POST['booking_date'])) > date("Y-m-d", strtotime($to_date))) {
                $error++;
                $msg .= ' Booking Date should be in b/w From & To Date<br> ';
            } else {
                $this->truck->booking_date = date("Y-m-d", strtotime($_POST['booking_date']));
            }

            if ($_POST['booking_weight'] > $_POST['balance_capacity']) {
                $error++;
                $msg .= ' Booking Weight shouldnt Be greater than Balace Capacity<br> ';
            }

            if ($error == 0) {
                $data = $this->truck->addBooking();
                if ($data) {
                    $resp['status'] = 1;
                    $resp['msg'] = 'Truck Booked Successfully';
                } else {
                    $resp['status'] = 2;
                    $resp['msg'] = 'Booking Failed';
                }
            } else {
                $resp['status'] = 4;
                $resp['msg'] = $msg;
            }
        } else {
            $resp['status'] = 3;
            $resp['msg'] = 'Wrong Method';
        }

        echo json_encode($resp);
        exit;
    }

    public function getTruckByID($truck_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->truck->truck_id = $truck_id;
            $data = $this->truck->truckDetailsByID();
            if ($data->status == 'success') {
                $data->availabilty_from = date('d M, Y', strtotime($data->availabilty_from));
                $data->availabilty_to = date('d M, Y', strtotime($data->availabilty_to));
                $resp['status'] = 1;
                $resp['data'] = $data;
                $resp['msg'] = 'Success';
            } else {
                $resp['status'] = 2;
                $resp['msg'] = 'No Data Available';
            }
        } else {
            $resp['status'] = 3;
            $resp['msg'] = 'Wrong Method';
        }

        echo json_encode($resp);
        exit;
    }

    public function check_reg_no($reg_no)
    {
        $this->truck->reg_no = $reg_no;
        $check['status'] = $this->truck->check_reg_no();
        echo json_encode($check);
        exit;
    }

    public function allTrucks()
    {
        $this->truck->owner_id = $_SESSION['uid'];
        $data['trucks'] = $this->truck->truckDetailsNotMine();
        $data['capacity'] = $this->truck->capacity_details();
        $this->view("trucks/alltrucks", $data);
    }

    public function myTrucks()
    {
        $this->truck->user_id = $_SESSION['uid'];
        $data = $this->truck->myTrucks();
        $this->view("trucks/mytrucks", $data);
    }

    public function bookings()
    {
        $this->truck->truck_owner_id = $_SESSION['uid'];
        $allTrucks = $this->truck->truckDetails();
        $trucks = array();
        foreach ($allTrucks as $truck_data) {
            $trucks[$truck_data->truck_id] = $truck_data;
        }
        $data['Trucks'] = $trucks;
        $data['bookings'] = $this->truck->Bookings();
        $this->view("trucks/bookings", $data);
    }

    public function mybookings()
    {
        $this->truck->truck_owner_id = $_SESSION['uid'];
        $this->truck->booked_by = $_SESSION['uid'];
        $allTrucks = $this->truck->truckDetails();
        $trucks = array();
        foreach ($allTrucks as $truck_data) {
            $trucks[$truck_data->truck_id] = $truck_data;
        }
        $data['Trucks'] = $trucks;
        $data['bookings'] = $this->truck->myBookings();
        $data['capacity'] = $this->truck->capacity_details();
        $this->view("trucks/mybookings", $data);
    }

    public function addTruck()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = 0;
            $msg = '';
            $today = date('Y-m-d');

            if (isset($_POST['company_name']) && $_POST['company_name'] == '') {
                $error++;
                $msg .= ' Company Name shouldnt Be Empty<br> ';
            } elseif (!preg_match('/^[a-zA-Z ]{3,50}$/', $_POST['company_name'])) {
                $error++;
                $msg .= ' Lenght of Company Name should Be between 3 and 50 Characters<br> ';
            } else {
                $this->truck->company_name = $_POST['company_name'];
            }

            if (isset($_POST['reg_no']) && $_POST['reg_no'] == '') {
                $error++;
                $msg .= ' Registration Number shouldnt Be Empty<br> ';
            } elseif (!preg_match('/^[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{4}$/i', $_POST['reg_no'])) {
                $error++;
                $msg .= ' Please enter valid registration number<br> ';
            } else {
                $this->truck->reg_no = $_POST['reg_no'];
            }

            if (isset($_POST['capacity']) && $_POST['capacity'] == '') {
                $error++;
                $msg .= ' Capacity shouldnt Be Empty<br> ';
            } elseif (!preg_match('/^[0-9]{1,3}$/', $_POST['capacity'])) {
                $error++;
                $msg .= ' Capacity wont be higher than 999<br> ';
            } else {
                $this->truck->capacity = $_POST['capacity'];
            }

            if (isset($_POST['mfg_year']) && $_POST['mfg_year'] == '') {
                $error++;
                $msg .= ' Manufacturing Year shouldnt Be Empty<br> ';
            } elseif (!preg_match('/^[0-9]{4}$/', $_POST['mfg_year'])) {
                $error++;
                $msg .= ' Please Enter a valid Manufacturing Year<br> ';
            } else {
                $this->truck->mfg_year = $_POST['mfg_year'];
            }

            if (isset($_POST['availabilty_from']) && $_POST['availabilty_from'] == '') {
                $error++;
                $msg .= ' From Date shouldnt Be Empty<br> ';
            } elseif (date("Y-m-d", strtotime($_POST['availabilty_from'])) < $today) {
                $error++;
                $msg .= ' From Date wont be earlier than today<br> ';
            } else {
                $this->truck->availabilty_from = date("Y-m-d", strtotime($_POST['availabilty_from']));
            }

            if (isset($_POST['availabilty_to']) && $_POST['availabilty_to'] == '') {
                $error++;
                $msg .= ' To Date shouldnt Be Empty<br> ';
            } elseif (date("Y-m-d", strtotime($_POST['availabilty_to'])) < date("Y-m-d", strtotime($_POST['availabilty_from']))) {
                $error++;
                $msg .= ' To Date wont be earlier than From Date<br> ';
            } else {
                $this->truck->availabilty_to = date("Y-m-d", strtotime($_POST['availabilty_to']));
            }

            if ($error == 0) {
                if (isset($_POST['truck_id'])) {
                    $this->truck->truck_id = $_POST['truck_id'];
                    $data = $this->truck->updateTruck();
                    if ($data) {
                        $resp['status'] = 1;
                        $resp['msg'] = 'Truck Details Updated Successfully';
                    } else {
                        $resp['status'] = 2;
                        $resp['msg'] = 'Failed to Update Truck Details';
                    }
                } else {
                    $this->truck->truck_id = $this->randomId();
                    $data = $this->truck->addTruck();
                    if ($data) {
                        $resp['status'] = 1;
                        $resp['msg'] = 'Truck Added Successfully';
                    } else {
                        $resp['status'] = 2;
                        $resp['msg'] = 'Failed to Add Truck';
                    }
                }
            } else {
                $resp['status'] = 4;
                $resp['msg'] = $msg;
            }
        } else {
            $resp['status'] = 3;
            $resp['msg'] = 'Wrong Method';
        }

        echo json_encode($resp);
        exit;
    }

    public function randomId()
    {
        return substr(hash('sha256', time()), 0, 6);
    }

    public function deleteTruck($truck_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->truck->truck_id = $truck_id;
            $data = $this->truck->deleteTruck();
            if ($data) {
                $resp['status'] = 1;
                $resp['msg'] = 'Deleted Successfully';
            } else {
                $resp['status'] = 2;
                $resp['msg'] = 'Failed to delete Truck';
            }
        } else {
            $resp['status'] = 3;
            $resp['msg'] = 'Wrong Method';
        }

        echo json_encode($resp);
        exit;
    }
}
