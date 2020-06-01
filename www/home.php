<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<base target="_parent">
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="img/logo/logo1.png">
	<title>Pagina Inicio</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mdb.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		@media (max-height: 400px) {
			footer {
				position: relative;
			}
		}
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
					<li class="nav-item active">
						<a class="nav-link" href="home.php">
							<i class="fa fa-home"></i> Home
							<span class="sr-only">(current)</span>
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
							<a class="dropdown-item rounded" href="profile.php">My account</a>
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

		<div class="container py-5">
			<div class="row main-container">

				<div class="content container  blue-grey darken-3 text-light ">
					<div>
						<h2>Home Page</h2>
						<p>Welcome back, <?= $_SESSION['name'] ?>!</p>
					</div>

					<div id="mainData">
						<div class="table-responsive " style="max-height:50vh;">
							<table class="table text-light">
								<thead>
									<tr>
									</tr>
								</thead>
								<tbody>

								</tbody>

							</table>
						</div>
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
		$.ajax({
				url: "dbActions/dbInfo.php",
				data: {
					option: 3
				},
				method: "GET"
			})
			.done(function(data) {
				console.log(data);
				let el = $("#mainData").find("tbody");
				for (let i of data.msg) {
					let li = $(`<tr class='w-100 hoverable' data-id=${i.id}></tr>`);
					li.append($("<td></td>").text(i.nombreGrupo));
					li.append($("<td></td>").text(i.title));
					li.append($("<td style='overflow: hidden'></td>").text(i.desc));
					li.append($("<td></td>").text(i.gpsLat + "\t" + i.gpsLng));
					li.append($("<td></td>").text(i.time));
					el.append(li);
					//new Date ( Date.parse("2020-06-20 00:00:00".split(" ")[0]) - 7200000) 
				}

				$("#mainData tr").click(function() {
					console.log(this);
					window.location.href = `viewKdd.php?id=${$(this).attr("data-id")}`;
				})

			})
			.fail(function() {
				console.log("fail");

			})
	</script>

</body>

</html>