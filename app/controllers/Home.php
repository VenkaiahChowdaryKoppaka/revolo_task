<?php

class Home extends Controller
{
    public function __construct()
    {
        $this->truck = $this->model('TruckModel');
        if (isLoggedIn()) {
            redirect('Trucks/bookings');
        }
    }

    public function index()
    {
        $data['trucks'] = $this->truck->truckDetails();
        $data['capacity'] = $this->truck->capacity_details();
        $this->view("home/index", $data);
    }


    public function addBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->truck->booking_id = $this->randomId();
            $this->truck->truck_id = $_POST['truck_id'];
            $this->truck->truck_owner_id = $_POST['owner_id'];
            $this->truck->booked_by = '';
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


    public function login()
    {
        $data = "";
        $this->view("home/login", $data);
    }

    public function userLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->truck->email = $_POST['user_name'];
            $this->truck->password = md5($_POST['password']);
            $data = $this->truck->login();
            // print_r($data);
            if ($data['status'] == 'success') {
                $this->createUserSession($data['data']);
                $resp['status'] = 1;
            } else {
                $resp['status'] = 2;
                $resp['msg'] = 'Username or Password Mismatch';
            }
        } else {
            $resp['status'] = 3;
            $resp['msg'] = 'Wrong Method';
        }

        echo json_encode($resp);
        exit;
    }

    public function createUserSession($user)
    {
        $_SESSION['uid'] = $user->id;
    }

    public function logout()
    {
        unset($_SESSION['uid']);
        session_destroy();
        redirect('home/login');
    }

    public function randomId()
    {
        return substr(hash('sha256', time()), 0, 6);
    }
}
