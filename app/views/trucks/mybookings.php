<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Bookings</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= URLROOT ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTable CSS -->
    <link href="<?= URLROOT ?>/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Bootstrap DatePicker CSS -->
    <link href="<?= URLROOT ?>/css/bootstrap-datepicker3.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= URLROOT ?>/css/bootstrap-icons.css">

    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="<?= URLROOT ?>/css/sweetalert.css">

    <!-- Custom styles -->
    <link href="<?= URLROOT ?>/css/offcanvas.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand fw-bolder" href="<?= URLROOT ?>">TRUCKS</a>
            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="<?= URLROOT ?>/Trucks/allTrucks">ALL Trucks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="<?= URLROOT ?>/Trucks/myTrucks">My Trucks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="<?= URLROOT ?>/Trucks/bookings">Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder active" href="<?= URLROOT ?>/Trucks/mybookings">My Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="<?= URLROOT ?>/home/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
            <div class="lh-1">
                <h1 class="h4 mb-0 text-white lh-1">List of My Bookings</h1>
            </div>
        </div>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table id="trucks" class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Booking ID</th>
                        <th>User Name</th>
                        <th>From Location</th>
                        <th>To Location</th>
                        <th>Booking Capacity</th>
                        <th>Booking Date</th>
                        <th>Truck Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data['bookings'] as $bookings) {
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $bookings->booking_id ?></td>
                            <td><?= $bookings->user_name ?></td>
                            <td><?= $bookings->loc_from ?></td>
                            <td><?= $bookings->loc_to ?></td>
                            <td><?= $bookings->booking_weight ?> Tons</td>
                            <td><?= date("d M, Y", strtotime($bookings->booking_date)) ?></td>
                            <td>Truck Id: <?= $bookings->truck_id ?><br>Reg No: <?= $data['Trucks'][$bookings->truck_id]->reg_no ?></td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </main>


    <!-- jQuery Library -->
    <script src="<?= URLROOT ?>/js/jquery-3.5.1.js"></script>

    <!-- Bootstrap JS -->
    <script src="<?= URLROOT ?>/js/bootstrap.bundle.min.js"></script>

    <!-- Cusotm JS -->
    <script src="<?= URLROOT ?>/js/offcanvas.js"></script>

    <!-- Datatable JS -->
    <script src="<?= URLROOT ?>/js/jquery.dataTables.min.js"></script>

    <!-- Sweetalert JS -->
    <script src="<?= URLROOT ?>/js/sweetalert.js"></script>

    <!-- Bootstrap DatePicker JS -->
    <script src="<?= URLROOT ?>/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#trucks').DataTable();

            $("#booking_btn").click(function(e) {
                $('#booking_modal').modal('show');
            });
            $('#date_picker input').datepicker({
                format: "dd MM, yyyy",
                todayBtn: "linked",
                clearBtn: true,
                autoclose: true,
                todayHighlight: true,
            });
        });
    </script>

</body>

</html>