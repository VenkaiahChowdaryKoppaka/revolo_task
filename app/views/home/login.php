<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Bootstrap core CSS -->
  <link href="<?= URLROOT ?>/css/bootstrap.min.css" rel="stylesheet">

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
            <a class="nav-link fw-bolder" aria-current="page" href="<?= URLROOT ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-bolder active" href="<?= URLROOT ?>/home/login">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container">
    <div class="my-3 p-3">
      <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-12 mx-auto">

          <div class="card card-body shadow-lg bg-body rounded">
            <h4 class="card-title text-center">Login</h4>
            <hr>
            <form id="login_form" method="POST">
              <div class="mb-3">
                <label for="user_name" class="form-label fw-bold">User Name</label>
                <input type="email" class="form-control" id="user_name" autofocus name="user_name" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" name="login"><span class="fw-bolder">Login</span></button>
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

  <!-- Sweetalert JS -->
  <script src="<?= URLROOT ?>/js/sweetalert.js"></script>

  <script>
    $(document).ready(function() {
      $("#login_form").submit(function(e) {
        e.preventDefault();
        var formData = $("#login_form").serialize();
        $.ajax({
          url: "<?= URLROOT ?>/home/userLogin",
          method: "POST",
          data: formData,
          dataType: "json",
          success: function(data) {
            if (data.status == 1) {
              window.location.href = "<?= URLROOT; ?>/Trucks/bookings"
            } else if (data.status == 2) {
              swal({
                title: "Oops!",
                text: data.msg,
                icon: "error"
              });
            } else if (data.status == 3) {
              swal({
                title: "Oops!",
                text: data.msg,
                icon: "error"
              });
            }
          }
        });
      });
    });
  </script>

</body>

</html>