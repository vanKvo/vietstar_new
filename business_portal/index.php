<?php
	//Start session
	session_start();
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_MEMBER_ID']);
	unset($_SESSION['SESS_NAME']);
	unset($_SESSION['SESS_POSITION']);
?>
<html>
<head>
	<title>
	Vietstar Shipping
	</title>
	<link href="main/css/lib/bootstrap.css" rel="stylesheet">
	<link href="main/css/lib/bootstrap-responsive.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
			.divider:after,
			.divider:before {
				content: "";
				flex: 1;
				height: 1px;
				background: #eee;
			}
			.h-custom {
				height: calc(100% - 73px);
			}
			@media (max-width: 450px) {
				.h-custom {
					height: 100%;
				}
			}
    </style>
</head>
<body>
<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">Vietstar Shipping</h3>
						<form action="login.php" method="post">
						<!-- <div class="form-outline mb-4">
								<input type="email" id="typeEmailX-2" class="form-control form-control-lg" />
								<label class="form-label" for="typeEmailX-2">Email</label>
							</div>-->
							<div class="form-outline mb-4">
								<input type="text" id="username" name="username"  class="form-control form-control-lg" placeholder="Username" required/>
							</div>

							<div class="form-outline mb-4">
								<input type="password" name="password" id="typePasswordX-2" class="form-control form-control-lg"  placeholder="Password" required/>
							</div>

							<!-- Checkbox -->
							<!--<div class="form-check d-flex justify-content-start mb-4">
								<a href="reset_password.php">
								<label class="form-check-label" for="form1Example3">Forgot password?</label>
							</div>-->

							<button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
						</form>	
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>