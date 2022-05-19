<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Trucks</title>

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
                        <a class="nav-link fw-bolder active" href="<?= URLROOT ?>/Trucks/allTrucks">ALL Trucks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="<?= URLROOT ?>/Trucks/myTrucks">My Trucks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="<?= URLROOT ?>/Trucks/bookings">Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="<?= URLROOT ?>/Trucks/mybookings">My Bookings</a>
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
                <h1 class="h6 mb-0 text-white lh-1">List of all Available Trucks</h1>
            </div>
        </div>
        <div class="my-3 p-3 bg-body rounded shadow-sm">

            <table id="trucks" class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Truck ID</th>
                        <th>Company Name</th>
                        <th>Registration Number</th>
                        <th>Manufacturing Year</th>
                        <th>Remaining Capacity</th>
                        <th>Availability</th>
                        <th>Book</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $capacity = $data['capacity'];
                    foreach ($data['trucks'] as $trucks) {
                        $balance_capacity = $capacity[$trucks->truck_id]['balance_capacity'];
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $trucks->truck_id ?></td>
                            <td><?= $trucks->company_name ?></td>
                            <td><?= $trucks->reg_no ?></td>
                            <td><?= $trucks->mfg_year ?></td>
                            <td><?= $balance_capacity ?> Tons</td>
                            <td><?= date("d M, Y", strtotime($trucks->availabilty_from)) ?> to <?= date("d M, Y", strtotime($trucks->availabilty_to)) ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm text-white booking_btn" data-capacity=<?= $balance_capacity ?> data-availabilty_from=<?= $trucks->availabilty_from ?> data-availabilty_to=<?= $trucks->availabilty_to ?> data-owner_id=<?= $trucks->owner_id ?> data-truck_id="<?= $trucks->truck_id ?>">
                                    Book Now
                                </button>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>

            <div class="modal fade" id="booking_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <h4 class="modal-title text-center p-2" id="exampleModalLabel">Book Truck <span class="float-end btn-close" style="width:0.5rem !important; height:0.5rem !important;" aria-label="Close"></span></h4>
                        <form id="booking_form">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="hidden-input-truck"></div>
                                    <div class="hidden-input-owner"></div>
                                    <div class="hidden-input-availabilty"></div>
                                    <div class="hidden-input-balance_capacity"></div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="user_name">User Name</label>
                                        <input type="text" class="form-control" placeholder="User Name" name="user_name" id="user_name">
                                        <small class="text-danger" style="display:none" id="user_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="booking_weight">Booking Capacity</label>
                                        <input type="text" class="form-control" placeholder="Booking Capacity" name="booking_weight" id="booking_weight">
                                        <small class="text-danger" style="display:none" id="cap_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="loc_from">From Location</label>
                                        <input type="text" class="form-control" placeholder="From Location" name="loc_from" id="loc_from">
                                        <small class="text-danger" style="display:none" id="loc_from_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="loc_to">To Location</label>
                                        <input type="text" class="form-control" placeholder="To Location" name="loc_to" id="loc_to">
                                        <small class="text-danger" style="display:none" id="loc_to_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2" id="sandbox-container">
                                        <label class="form-label fw-bold" for="booking_date">Date of Booking</label>
                                        <input type="text" class="form-control" placeholder="Date of Booking" readonly="readonly" name="booking_date" id="booking_date">
                                        <small class="text-danger" style="display:none" id="bd_error"></small>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
                                    <button class="btn btn-primary" type="submit">Book Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

            $('#sandbox-container input').datepicker({
                format: "dd MM, yyyy",
                todayBtn: "linked",
                clearBtn: true,
                autoclose: true,
                todayHighlight: true
            });

            $(".booking_btn").click(function() {
                var truck_id = $(this).data("truck_id");
                var truck_id_input = $("<input>");
                truck_id_input.attr("type", "hidden");
                truck_id_input.attr("name", "truck_id");
                truck_id_input.attr("id", "truck_id");
                truck_id_input.attr("value", truck_id);
                $(".hidden-input-truck").html(truck_id_input);

                var owner_id = $(this).data("owner_id");
                var owner_id_input = $("<input>");
                owner_id_input.attr("type", "hidden");
                owner_id_input.attr("name", "owner_id");
                owner_id_input.attr("id", "owner_id");
                owner_id_input.attr("value", owner_id);
                $(".hidden-input-owner").html(owner_id_input);

                var availabilty = $(this).data("availabilty_from");
                availabilty += "#";
                availabilty += $(this).data("availabilty_to");
                var availabilty_input = $("<input>");
                availabilty_input.attr("type", "hidden");
                availabilty_input.attr("name", "availabilty");
                availabilty_input.attr("id", "availabilty");
                availabilty_input.attr("value", availabilty);
                $(".hidden-input-availabilty").html(availabilty_input);

                var balance_capacity = $(this).data("capacity");
                var balance_capacity_input = $("<input>");
                balance_capacity_input.attr("type", "hidden");
                balance_capacity_input.attr("name", "balance_capacity");
                balance_capacity_input.attr("id", "balance_capacity");
                balance_capacity_input.attr("value", balance_capacity);
                $(".hidden-input-balance_capacity").html(balance_capacity_input);

                $('#booking_modal').modal('show');
            });

            $(".btn-close").click(function() {
                $("#booking_form")[0].reset();
                $("#user_error").hide();
                $("#cap_error").hide();
                $("#loc_from_error").hide();
                $("#loc_to_error").hide();
                $("#bd_error").hide();
                $("#booking_modal").modal('hide');
            })

            $("#booking_form").submit(function(e) {
                e.preventDefault();

                var user_name = $('#user_name').val();
                var booking_weight = $('#booking_weight').val();
                var balance_capacity = $('#balance_capacity').val();
                var loc_from = $('#loc_from').val();
                var loc_to = $('#loc_to').val();
                var booking_date = new Date($('#booking_date').val());

                var user_name_regex = /^[a-zA-Z ]{3,50}$/;
                var capacity_regex = /^[0-9]{1,3}$/;
                var loc_regex = /^[a-zA-Z ]{3,50}$/;
                var availabilty = $("#availabilty").val().split('#');
                var from_date = new Date(availabilty[0]);
                var to_date = new Date(availabilty[1]);

                var error = 0;

                if (user_name.length == 0) {
                    $("#user_error").html('User Name shouldnt Be Empty');
                    $("#user_error").show();
                    error++;
                } else if (!user_name_regex.test(user_name)) {
                    $("#user_error").html('Lenght of User Name should Be between 3 and 50 Characters');
                    $("#user_error").show();
                    error++;
                } else {
                    $("#user_error").html();
                    $("#user_error").hide();
                }

                if (booking_weight.length == 0) {
                    $("#cap_error").html('Booking Capacity shouldnt Be Empty');
                    $("#cap_error").show();
                    error++;
                } else if (!capacity_regex.test(booking_weight)) {
                    $("#cap_error").html('Booking Capacity wont be higher than 999');
                    $("#cap_error").show();
                    error++;
                } else {
                    $("#cap_error").html();
                    $("#cap_error").hide();
                }

                if (loc_from.length == 0) {
                    $("#loc_from_error").html('From Location shouldnt Be Empty');
                    $("#loc_from_error").show();
                    error++;
                } else if (!user_name_regex.test(user_name)) {
                    $("#loc_from_error").html('Lenght of From Location should Be between 3 and 50 Characters');
                    $("#loc_from_error").show();
                    error++;
                } else {
                    $("#loc_from_error").html();
                    $("#loc_from_error").hide();
                }

                if (loc_to.length == 0) {
                    $("#loc_to_error").html('To Location shouldnt Be Empty');
                    $("#loc_to_error").show();
                    error++;
                } else if (!user_name_regex.test(user_name)) {
                    $("#loc_to_error").html('Lenght of To Location should Be between 3 and 50 Characters');
                    $("#loc_to_error").show();
                    error++;
                } else {
                    $("#loc_to_error").html();
                    $("#loc_to_error").hide();
                }

                if ($('#booking_date').val().length == 0) {
                    $("#bd_error").html('Booking Date shouldnt Be Empty');
                    $("#bd_error").show();
                    error++;
                } else if (booking_date.getTime() < from_date.getTime() || booking_date.getTime() > to_date.getTime()) {
                    $("#bd_error").html('Booking Date should be in b/w From & To Date');
                    $("#bd_error").show();
                    error++;
                } else {
                    $("#bd_error").html();
                    $("#bd_error").hide();
                }

                console.log(error);
                if (error == 0) {
                    var formData = $("#booking_form").serialize();
                    $.ajax({
                        url: "<?= URLROOT ?>/Trucks/addBooking",
                        method: "POST",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if (data.status == 1) {
                                swal({
                                    title: "Success",
                                    text: data.msg,
                                    type: "success"
                                }, function() {
                                    window.location.href = window.location.href;
                                });
                            } else if (data.status == 2) {
                                swal({
                                    title: "Oops!",
                                    text: data.msg,
                                    type: "error"
                                });
                            } else if (data.status == 3) {
                                swal({
                                    title: "Oops!",
                                    text: data.msg,
                                    type: "error"
                                });
                            } else if (data.status == 4) {
                                swal({
                                    title: "Oops!",
                                    text: data.msg.replace(/<br>/, "\n"),
                                    type: "error"
                                });
                            }
                        }
                    });
                }

            })

        });
    </script>

</body>

</html>