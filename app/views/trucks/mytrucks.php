<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Trucks</title>

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
                        <a class="nav-link fw-bolder active" href="<?= URLROOT ?>/Trucks/myTrucks">My Trucks</a>
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
                <h1 class="h4 mb-0 text-white lh-1">My Trucks</h1>
            </div>
        </div>
        <div class="my-3 p-3 bg-body rounded shadow-sm table-responsive">
            <button type="button" class="btn btn-primary float-end mb-3 add_truck">
                Add a Truck
            </button>
            <table id="trucks" class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Truck ID</th>
                        <th>Company Name</th>
                        <th>Registration Number</th>
                        <th>Manufacturing Year</th>
                        <th>Capacity</th>
                        <th>Availability</th>
                        <th>More</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data as $trucks) {
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $trucks->truck_id ?></td>
                            <td><?= $trucks->company_name ?></td>
                            <td><?= $trucks->reg_no ?></td>
                            <td><?= $trucks->mfg_year ?></td>
                            <td><?= $trucks->capacity ?> Tons</td>
                            <td><?= date("d M, Y", strtotime($trucks->availabilty_from)) ?> to <?= date("d M, Y", strtotime($trucks->availabilty_to)) ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm text-white me-2 update_btn" data-truck_id="<?= $trucks->truck_id ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm me-2 delete_btn" data-truck_id="<?= $trucks->truck_id ?>">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>

            <!-- Add Truck Modal -->
            <div class="modal fade" id="add_truck_modal" tabindex="-1" aria-labelledby="truck_modal" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <h4 class="modal-title text-center p-2" id="truck_modal"><span class="modal_heading"></span> <span class="float-end btn-close" style="width:0.5rem !important; height:0.5rem !important;" data-bs-dismiss="modal" aria-label="Close"></span></h4>
                        <form class="truck_form">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="hidden-input"></div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="company_name">Company Name</label>
                                        <input type="text" class="form-control" placeholder="Company Name" maxlength="50" name="company_name" id="company_name">
                                        <small class="text-danger" style="display:none" id="comp_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="reg_no">Registration Number</label>
                                        <input type="text" class="form-control" placeholder="Registration Number" maxlength="10" name="reg_no" id="reg_no">
                                        <small class="text-danger" style="display:none" id="reg_no_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="capacity">Capacity</label>
                                        <input type="text" class="form-control" placeholder="Capacity (in Tons)" maxlength="3" name="capacity" id="capacity">
                                        <small class="text-danger" style="display:none" id="cap_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="mfg_year">Manufacturing Year</label>
                                        <input type="text" class="form-control" placeholder="Manufacturing Year" maxlength="4" name="mfg_year" id="mfg_year">
                                        <small class="text-danger" style="display:none" id="mfg_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2" id="sandbox-container">
                                        <label class="form-label fw-bold" for="availabilty_from">Available From</label>
                                        <input type="text" class="form-control" placeholder="Available From" readonly name="availabilty_from" id="availabilty_from">
                                        <small class="text-danger" style="display:none" id="from_error"></small>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2" id="sandbox-container">
                                        <label class="form-label fw-bold" for="availabilty_to">Available Up To</label>
                                        <input type="text" class="form-control" placeholder="Available Up To" readonly name="availabilty_to" id="availabilty_to">
                                        <small class="text-danger" style="display:none" id="to_error"></small>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
                                    <button class="btn btn-secondary me-md-2" type="button" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                    <button class="btn btn-primary submit_btn" type="submit"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Truck Modal -->
            <div class="modal fade" id="edit_truck_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <h4 class="modal-title text-center p-2" id="exampleModalLabel">Add Truck <span class="float-end btn-close" style="width:0.5rem !important; height:0.5rem !important;" data-bs-dismiss="modal" aria-label="Close"></span></h4>
                        <form method="POST" id="add_truck_form">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="company_name">Company Name</label>
                                        <input type="text" class="form-control" placeholder="Company Name" name="company_name" id="company_name">
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="reg_no">Registration Number</label>
                                        <input type="text" class="form-control" placeholder="Registration Number" name="reg_no" id="reg_no">
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="capacity">Capacity</label>
                                        <input type="text" class="form-control" placeholder="Capacity" name="capacity" id="capacity">
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2">
                                        <label class="form-label fw-bold" for="mfg_year">Manufacturing Year</label>
                                        <input type="text" class="form-control" placeholder="Manufacturing Year" name="mfg_year" id="mfg_year">
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2" id="sandbox-container">
                                        <label class="form-label fw-bold" for="availabilty_from">Available From</label>
                                        <input type="text" class="form-control" placeholder="Available From" name="availabilty_from" id="availabilty_from">
                                    </div>
                                    <div class="col-md-6 col-sm-12 mt-2" id="sandbox-container">
                                        <label class="form-label fw-bold" for="availabilty_to">Available Up To</label>
                                        <input type="text" class="form-control" placeholder="Available Up To" name="availabilty_to" id="availabilty_to">
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
                                    <button class="btn btn-secondary me-md-2" type="button" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                    <button class="btn btn-primary" type="submit" name="edit_truck" id="edit_truck_btn">Update</button>
                                </div>
                            </div>
                        </form>
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

            $(".add_truck").click(function(e) {
                $(".hidden-input").empty();
                $('#add_truck_modal').modal('show');
                $(".submit_btn").attr("name", "add_truck");
                $(".submit_btn").attr("id", "add_truck_btn");
                $(".submit_btn").html("Add Truck");
                $(".truck_form").attr("id", "add_truck_form");
                $(".modal_heading").html("Add Truck");
            });

            $('#sandbox-container input').datepicker({
                format: "dd MM, yyyy",
                todayBtn: "linked",
                clearBtn: true,
                autoclose: true,
                todayHighlight: true
            });

            $("#reg_no").blur(function() {
                var reg_no = $('#reg_no').val();
                var reg_no_regex = /^[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{4}$/;

                if (reg_no.length == 0) {
                    $("#reg_no_error").html('Registration Number shouldnt Be Empty');
                    $("#reg_no_error").show();
                } else if (!reg_no_regex.test(reg_no)) {
                    $("#reg_no_error").html('Please enter valid registration number');
                    $("#reg_no_error").show();
                } else {
                    $("#reg_no_error").html();
                    $("#reg_no_error").hide();
                }

                $.ajax({
                    url: "<?= URLROOT ?>/Trucks/check_reg_no/" + reg_no,
                    method: "GET",
                    dataType: "json",
                    success: function(resp) {
                        if (resp.status) {
                            swal({
                                title: "Oops!",
                                text: "Registration Number already registered in this portal",
                                type: "error"
                            }, function() {
                                $("#reg_no_error").html('Registration Number already registered in this portal');
                                $("#reg_no_error").show();
                            });
                        }
                    }
                });

            })

            $(".truck_form").submit(function(e) {
                e.preventDefault();

                var form_id = $(this).attr("id");

                var error = 0;

                var company_name = $('#company_name').val();
                var reg_no = $('#reg_no').val();
                var capacity = $('#capacity').val();
                var mfg_year = $('#mfg_year').val();
                var to_date = new Date($('#availabilty_to').val());
                var from_date = new Date($('#availabilty_from').val());

                var company_name_regex = /^[a-zA-Z ]{3,50}$/;
                var reg_no_regex = /^[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{4}$/;
                var capacity_regex = /^[0-9]{1,3}$/;
                var mfg_year_regex = /^[0-9]{4}$/;
                var today = new Date();

                if (form_id == 'update_truck_form') {
                    var truck_id = $('#truck_id').val();
                    var truck_id_regex = /^[a-zA-Z0-9]{6}$/;

                    if (!truck_id_regex.test(truck_id) || truck_id.length == 0) {
                        swal({
                            title: "Oops!",
                            type: "error"
                        }, function() {
                            window.location.href = window.location.href;
                        });
                    }

                }

                if (company_name.length == 0) {
                    $("#comp_error").html('Company Name shouldnt Be Empty');
                    $("#comp_error").show();
                    error++;
                } else if (!company_name_regex.test(company_name)) {
                    $("#comp_error").html('Lenght of Company Name should Be between 3 and 50 Characters');
                    $("#comp_error").show();
                    error++;
                } else {
                    $("#comp_error").html();
                    $("#comp_error").hide();
                }

                if (reg_no.length == 0) {
                    $("#reg_no_error").html('Registration Number shouldnt Be Empty');
                    $("#reg_no_error").show();
                    error++;
                } else if (!reg_no_regex.test(reg_no)) {
                    $("#reg_no_error").html('Please enter valid registration number');
                    $("#reg_no_error").show();
                    error++;
                } else {
                    $("#reg_no_error").html();
                    $("#reg_no_error").hide();
                }

                if (capacity.length == 0) {
                    $("#cap_error").html('Capacity shouldnt Be Empty');
                    $("#cap_error").show();
                    error++;
                } else if (!capacity_regex.test(capacity)) {
                    $("#cap_error").html('Capacity wont be higher than 999');
                    $("#cap_error").show();
                    error++;
                } else {
                    $("#cap_error").html();
                    $("#cap_error").hide();
                }

                if (mfg_year.length == 0) {
                    $("#mfg_error").html('Manufacturing Year shouldnt Be Empty');
                    $("#mfg_error").show();
                    error++;
                } else if (!mfg_year_regex.test(mfg_year)) {
                    $("#mfg_error").html('Please Enter a valid Manufacturing Year');
                    $("#mfg_error").show();
                    error++;
                } else {
                    $("#mfg_error").html();
                    $("#mfg_error").hide();
                }

                if ($('#availabilty_from').val().length == 0) {
                    $("#from_error").html('From Date shouldnt Be Empty');
                    $("#from_error").show();
                    error++;
                } else if (from_date.getTime() < today.getTime()) {
                    $("#from_error").html('From Date wont be earlier than today');
                    $("#from_error").show();
                    error++;
                } else {
                    $("#from_error").html();
                    $("#from_error").hide();
                }

                if ($('#availabilty_to').val().length == 0) {
                    $("#to_error").html('To Date shouldnt Be Empty');
                    $("#to_error").show();
                    error++;
                } else if (to_date.getTime() < from_date.getTime()) {
                    $("#to_error").html('To Date wont be earlier than from date');
                    $("#to_error").show();
                    error++;
                } else {
                    $("#to_error").html();
                    $("#to_error").hide();
                }
                console.log(error);
                if (error == 0) {
                    var formData = $(".truck_form").serialize();
                    $.ajax({
                        url: "<?= URLROOT ?>/Trucks/addTruck",
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
            });

            $("button.update_btn").click(function() {
                var truck_id = $(this).data("truck_id");
                console.log(truck_id);
                $.ajax({
                    url: "<?= URLROOT ?>/Trucks/getTruckByID/" + truck_id,
                    method: "GET",
                    dataType: "json",
                    success: function(resp) {
                        console.log(resp);
                        if (resp.status == 1) {
                            var truck_id_input = $("<input>");
                            truck_id_input.attr("type", "hidden");
                            truck_id_input.attr("name", "truck_id");
                            truck_id_input.attr("id", "truck_id");
                            truck_id_input.attr("value", truck_id);
                            $(".hidden-input").html(truck_id_input);
                            $('#add_truck_modal').modal('show');

                            $('#company_name').val(resp.data.company_name);
                            $('#reg_no').val(resp.data.reg_no);
                            $('#capacity').val(resp.data.capacity);
                            $('#mfg_year').val(resp.data.mfg_year);
                            $('#availabilty_to').val(resp.data.availabilty_to);
                            $('#availabilty_from').val(resp.data.availabilty_from);
                            $(".submit_btn").attr("name", "update_truck");
                            $(".submit_btn").attr("id", "update_truck_btn");
                            $(".submit_btn").html("Update Truck");
                            $(".truck_form").attr("id", "update_truck_form");
                            $(".modal_heading").html("Update Truck");

                        } else if (resp.status == 2) {
                            swal({
                                title: "Oops!",
                                text: data.msg,
                                type: "error"
                            }, function() {
                                window.location.href = window.location.href;
                            });
                        } else if (resp.status == 3) {
                            swal({
                                title: "Oops!",
                                text: data.msg,
                                type: "error"
                            }, function() {
                                window.location.href = window.location.href;
                            });
                        }
                    }
                });
            });

            $("button.delete_btn").click(function() {
                var truck_id = $(this).data("truck_id");
                swal({
                    title: "Are you sure?",
                    text: "Once Deleted, It will not be recovered!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }, function() {
                    $.ajax({
                        url: "<?= URLROOT ?>/Trucks/deleteTruck/" + truck_id,
                        method: "GET",
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
                            } else if (resp.status == 2) {
                                swal({
                                    title: "Oops!",
                                    text: data.msg,
                                    type: "error"
                                }, function() {
                                    window.location.href = window.location.href;
                                });
                            } else if (resp.status == 3) {
                                swal({
                                    title: "Oops!",
                                    text: data.msg,
                                    type: "error"
                                }, function() {
                                    window.location.href = window.location.href;
                                });
                            }
                        }
                    });
                });
            });

        });
    </script>

</body>

</html>