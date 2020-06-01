<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
include "./../datasql.php";
// Change this to your connection info.

// Try and connect using the info above.
$con = mysqli_connect(IP, USUARIO, CLAVE, BD);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>

<head>
	<base target="_parent">
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="img/logo/logo1.png">
	<title>Perfil</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mdb.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>

	</style>

</head>

<body aria-busy="true">
	<div class="">


		<!--Navbar -->
        <nav class="mb-1 navbar navbar-expand-lg navbar-dark py-0">
            <a class="navbar-brand col-3 p-0" href="home.php">
                <img src="./img/logo/logo1.png" alt="Motorsport" class="img-fluid d-lg-inline-block d-none mr-2" style="max-height: 10vh">
                <span class="d-inline-block">Motorsport</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <ul class="navbar-nav ml-auto ">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">
                            <i class="fa fa-home"></i> Home

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="allGroups.php">
                            <i class="fas fa-users"></i></i> Grupos
                            
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="createKdd.php">
                            <i class="fas fa-plus-circle"></i></i> Crear kdd
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img id="imgProfile" src="<?php echo './img/profile/' . $_SESSION['pic'] ?>" class="rounded-circle z-depth-0" alt="avatar image" height="45vh" width="45vh">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-info w-100" aria-labelledby="navbarDropdownMenuLink-4">
                            <a class="dropdown-item rounded active" href="profile.php">My account</a>
                            <a class="dropdown-item rounded" href="viewGroups.php">Tus grupos</a>
                            <?php if ($_SESSION['rango'] == 5) { ?>
                                <a class="dropdown-item rounded" href="admin.php">Panel administrador</a>
                            <?php } ?>
                            <a class="dropdown-item rounded" href="loginSystem/logout.php">Log out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!--/.Navbar -->

		<div class="container py-2 ">
			<div class="row main-container">
				<div class="content container  blue-grey darken-3 text-light ">

					<div>
						<form class="d-block d-md-flex justify-content-around align-items-center text-center row border-bottom mb-4 mb-md-3 mt-4 mt-md-0 pb-3 pb-md-0" id="mail">
							<span class="font-weight-bold col-md-4">Cambiar Email</span>

							<div class="col-md-8">
								<div class="content d-block d-lg-flex  align-items-center text-center">



									<div class="md-form mr-2 mt-5">
										<i class="fas fa-envelope prefix  d-flex"></i>
										<input type="email" id="email" name="email" class="form-control validate text-light" required>
										<label for="email" class="d-flex text-light font-weight-bold"><?php echo $email ?></label>
									</div>

									<button class="btn btn-success">Guardar</button>

								</div>

								<div class="loading">
									<div class="spinner-border m-5 p-5" role="status" style="width: 1rem; height: 1rem;color: orange">
										<span class="sr-only">Login...</span>
									</div>
								</div>

								<div class="error">
									<div class="d-flex justify-content-center">
										<div class="m-2 p-5" role="status">
											<i class="fa fa-exclamation-triangle fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: Red"></i>
											<p class="msg">Error</p>
										</div>
									</div>
								</div>
								<div class="success ">
									<div class="d-flex justify-content-center">
										<div class="m-2 p-5" role="status">
											<i class="fas fa-check fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: green"></i>
											<p class="msg"></p>
										</div>
									</div>
								</div>
							</div>
						</form>


						<form class="d-block d-md-flex justify-content-around align-items-center text-center row border-bottom mb-4 mb-md-3 mt-4 mt-md-1 py-3" id="password">
							<span class="font-weight-bold col-md-4">Cambiar contraseña</span>
							<div class="col-md-8">
								<div class="content d-block d-lg-flex align-items-center text-center">

									<div class="md-form">
										<i class="fas fa-lock prefix d-flex"></i>
										<input type="password" id="OldPass" name="OldPass" class="form-control text-light" required>
										<label for="OldPass" class="d-flex text-light font-weight-bold">Contraseña actual</label>
									</div>

									<div class="md-form">
										<i class="fas fa-lock prefix d-flex"></i>
										<input type="password" id="NewPass" name="NewPass" class="form-control text-light" required>
										<label for="NewPass" class="d-flex text-light font-weight-bold">Nueva contraseña</label>
									</div>

									<button class="btn btn-success">Guardar</button>

								</div>

								<div class="loading">
									<div class="spinner-border m-5 p-5" role="status" style="width: 1rem; height: 1rem;color: orange">
										<span class="sr-only">Login...</span>
									</div>
								</div>

								<div class="error">
									<div class="d-flex justify-content-center">
										<div class="m-2 p-5" role="status">
											<i class="fa fa-exclamation-triangle fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: Red"></i>
											<p class="msg">Error</p>
										</div>
									</div>
								</div>
								<div class="success ">
									<div class="d-flex justify-content-center">
										<div class="m-2 p-5" role="status">
											<i class="fas fa-check fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: green"></i>
											<p class="msg"></p>
										</div>
									</div>
								</div>
							</div>
						</form>


						<form class="d-block d-md-flex justify-content-around align-items-center text-center row border-bottom mb-4 mb-md-3 mt-4 mt-md-1 pt-1 pb-3" id="imgForm" enctype="multipart/form-data">
							<span class="font-weight-bold col-md-4">Cambiar Email</span>

							<div class="col-md-8">
								<div class="content d-block d-lg-flex  align-items-center text-center">


									<div style="background-color: white" class="col-3 mx-auto border border-light rounded mt-3">
										<img src="<?php echo "./img/profile/" . $_SESSION['pic'] ?>" id="img" width="100" height="100">
									</div>

									<div class="input-group my-2 mx-3 col-12 col-md-9 mt-3">
										<div class="input-group-prepend">
											<span class="input-group-text btn-success" id="botonUploadImg">Upload</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="file" aria-describedby="img profile file" name="file" accept="image/*">
											<label class="custom-file-label input-group-prepend" for="file">Choose file</label>
										</div>
									</div>



								</div>

								<div class="loading">
									<div class="spinner-border m-5 p-5" role="status" style="width: 1rem; height: 1rem;color: orange">
										<span class="sr-only">Login...</span>
									</div>
								</div>

								<div class="error">
									<div class="d-flex justify-content-center">
										<div class="m-2 p-5" role="status">
											<i class="fa fa-exclamation-triangle fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: Red"></i>
											<p class="msg">Error</p>
										</div>
									</div>
								</div>
								<div class="success ">
									<div class="d-flex justify-content-center">
										<div class="m-2 p-5" role="status">
											<i class="fas fa-check fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: green"></i>
											<p class="msg"></p>
										</div>
									</div>
								</div>
							</div>
						</form>


					</div>
				</div>
			</div>
		</div>

		<?php include "./common/footer.php" ?>
	</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/popper.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/mdb.min.js"></script>
	<script>
		function showContainer(elem) {
			elem.removeClass("d-none");
			elem.addClass("d-block");
			elem.addClass("d-lg-flex");

		}

		function hideContainer(elem) {
			elem.addClass("d-none");
			elem.removeClass("d-block");
			elem.removeClass("d-lg-flex");

		}

		$(".loading").addClass("d-none");
		$(".error").addClass("d-none");
		$(".success").addClass("d-none");

		$("#password").submit(changePassword);
		$("#mail").submit(changeEmail);
		$("#botonUploadImg").click(changeImg);


		function changePassword(ev) {
			ev.preventDefault();
			hideContainer($("#password").find(".content"));
			$("#password").find(".loading").removeClass("d-none");

			$.ajax({
					url: "dbActions/dbActionsUsers.php",
					data: {
						"option": 0,
						"OldPass": $("#password").find("input#OldPass").val(),
						"NewPass": $("#password").find("input#NewPass").val()
					},
					method: "POST"
				})
				.done(function(data) {
					console.log(data);

					if (data.code == 0) {
						$("#password").find(".success").removeClass("d-none");

					} else {
						let elem = $("#password").find(".error");
						elem.find(".msg").text(data.msg);
						elem.removeClass("d-none");

					}


				})
				.fail(function() {
					console.log("fail");

				})
				.always(function() {
					$("#password").find(".loading").addClass("d-none");
					setTimeout(function() {
						$("#password").find(".success").addClass("d-none");
						$("#password").find(".error").addClass("d-none");
						showContainer($("#password").find(".content"))
					}, 1250);

				});

		}

		function changeEmail(ev) {
			ev.preventDefault();
			hideContainer($("#mail").find(".content"));
			$("#mail").find(".loading").removeClass("d-none");

			$.ajax({
					url: "dbActions/dbActionsUsers.php",
					data: {
						"option": 1,
						"mail": $("#mail").find("input#email").val(),
					},
					method: "POST"
				})
				.done(function(data) {
					console.log(data);

					if (data.code == 0) {
						$("#mail label[for=email]").text($("#mail").find("input#email").val());
						$("#mail").find("input#email").val("");

						$("#mail").find(".success").removeClass("d-none");


					} else {
						let elem = $("#mail").find(".error");
						elem.find(".msg").text(data.msg);
						elem.removeClass("d-none");

					}


				})
				.fail(function() {
					console.log("fail");

				})
				.always(function() {
					$("#mail").find(".loading").addClass("d-none");
					setTimeout(function() {
						$("#mail").find(".success").addClass("d-none");
						$("#mail").find(".error").addClass("d-none");
						showContainer($("#mail").find(".content"));
					}, 1250);

				});

		}

		function changeImg() {

			let fd = new FormData();
			let files = $('#file')[0].files[0];
			fd.append('ficheros', files);
			fd.append('option', 2);


			hideContainer($("#imgForm").find(".content"));
			$("#password").find(".loading").removeClass("d-none");

			$.ajax({
				url: 'dbActions/dbActionsUsers.php',
				type: 'post',
				data: fd,
				contentType: false,
				processData: false,
				success: function(response) {
					console.log("si");
					console.log(response);

					if (response.code == 0) {
						d = new Date();
						$("#img").attr("src", response.msg+"?"+d.getTime());
						$("#imgProfile").attr("src", response.msg+"?"+d.getTime());
						$("#imgForm").find(".success").removeClass("d-none");
					} else {
						$("#imgForm").find(".error").removeClass("d-none");
						$("#imgForm").find(".error .msg").text(response.msg);
					}
					$("#password").find(".loading").addClass("d-none");
					setTimeout(function() {
						$("#imgForm").find(".success").addClass("d-none");
						$("#imgForm").find(".error").addClass("d-none");
						showContainer($("#imgForm").find(".content"));
					}, 1250);
				},
				error: function(error) {
					console.log(error);

					$("#imgForm").find(".loading").addClass("d-none");
					$("#imgForm").find(".error").removeClass("d-none");
					setTimeout(function() {

						$("#imgForm").find(".error").addClass("d-none");
						showContainer($("#imgForm").find(".content"));
					}, 1250);

				}
			});



		}
	</script>

</body>

</html>