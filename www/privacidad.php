<?php // We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...



?>
<!DOCTYPE html>
<html>

<head>
	<base target="_parent">
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="img/logo/logo1.png">
	<title>Terminos y condiciones</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mdb.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>

	</style>

</head>

<body aria-busy="true">
	<div class="">

		<?php if (isset($_SESSION['loggedin'])) {

		?>
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
						<li class="nav-item ">
							<a class="nav-link " href="allGroups.php">
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
		<?php
		} else {
		?>


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
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="index.php">
								Iniciar sesion
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="register.php">
								Registrarse
							</a>
						</li>

					</ul>
				</div>
			</nav>
			<!--Navbar -->

		<?php } ?>

		<div class="container py-2 ">
			<div class="row main-container">
				<div class="content container  blue-grey darken-3 text-light ">
					<div>
						<div>
							<h2>Política de Privacidad</h2>
							<p>Eduardo Sanz Gil te informa sobre su Política de Privacidad respecto del tratamiento y protección de los datos de carácter personal de los usuarios y clientes que puedan ser recabados por la navegación o contratación de servicios a través del sitio Web http://www.supermotorsport.net/</p>
							<p>En este sentido, el Titular garantiza el cumplimiento de la normativa vigente en materia de protección de datos personales, reflejada en la Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y de Garantía de Derechos Digitales (LOPD GDD). Cumple también con el Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo de 27 de abril de 2016 relativo a la protección de las personas físicas (RGPD).</p>
							<p>El uso de sitio Web implica la aceptación de esta Política de Privacidad así como las condiciones incluidas en el Aviso Legal.</p>
						</div>
						<div>
							<h2>Identidad del responsable</h2>
							<ul>
								<li>Titular: Eduardo Sanz Gil</li>
								<li>NIF/CIF: 72897033M</li>
								<li>Domicilio: Donde nace el Agua,15. 42190</li>
								<li>Correo electrónico: admin@supermotorsport.net</li>
								<li>Sitio Web: http://www.supermotorsport.net/</li>
							</ul>
						</div>
						<div>
							<h2>Principios aplicados en el tratamiento de datos</h2>
							<p>En el tratamiento de tus datos personales, el Titular aplicará los siguientes principios que se ajustan a las exigencias del nuevo reglamento europeo de protección de datos:</p>
							<ul>
								<li><strong>Principio de licitud, lealtad y transparencia:</strong> El Titular siempre requerirá el consentimiento para el tratamiento de tus datos personales que puede ser para uno o varios fines específicos sobre los que te informará previamente con absoluta transparencia.</li>
								<li><strong>Principio de minimización de datos:</strong> El Titular te solicitará solo los datos estrictamente necesarios para el fin o los fines que los solicita.</li>
								<li><strong>Principio de limitación del plazo de conservación:</strong> Los datos se mantendrán durante el tiempo estrictamente necesario para el fin o los fines del tratamiento.<br>El Titular te informará del plazo de conservación correspondiente según la finalidad. En el caso de suscripciones, el Titular revisará periódicamente las listas y eliminará aquellos registros inactivos durante un tiempo considerable.</li>
								<li><strong>Principio de integridad y confidencialidad:</strong> Tus datos serán tratados de tal manera que su seguridad, confidencialidad e integridad esté garantizada. Debes saber que el Titular toma las precauciones necesarias para evitar el acceso no autorizado o uso indebido de los datos de sus usuarios por parte de terceros.</li>
							</ul>
						</div>
						<div>
							<h2>Tus derechos</h2>
							<p>El Titular te informa que sobre tus datos personales tienes derecho a:</p>
							<ul>
								<li>Solicitar el acceso a los datos almacenados.</li>
								<li>Solicitar una rectificación o la cancelación.</li>
								<li>Solicitar la limitación de su tratamiento.</li>
								<li>Oponerte al tratamiento.</li>
								<li>Solicitar la portabilidad de tus datos.</li>
							</ul>
							<p>El ejercicio de estos derechos es personal y por tanto debe ser ejercido directamente por el interesado, solicitándolo directamente al Titular, lo que significa que cualquier cliente, suscriptor o colaborador que haya facilitado sus datos en algún momento puede dirigirse al Titular y pedir información sobre los datos que tiene almacenados y cómo los ha obtenido, solicitar la rectificación de los mismos, solicitar la portabilidad de sus datos personales, oponerse al tratamiento, limitar su uso o solicitar la cancelación de esos datos en los ficheros del Titular.</p>
							<p>Para ejercitar tus derechos de acceso, rectificación, cancelación, portabilidad y oposición tienes que enviar un correo electrónico a admin@supermotorsport.net junto con la prueba válida en derecho como una fotocopia del D.N.I. o equivalente.</p>
							<p>Tienes derecho a la tutela judicial efectiva y a presentar una reclamación ante la autoridad de control, en este caso, la Agencia Española de Protección de Datos, si consideras que el tratamiento de datos personales que te conciernen infringe el Reglamento.</p>
						</div>
						<div>
							<h2>Finalidad del tratamiento de datos personales</h2>
							<p>Cuando te conectas al sitio Web para mandar un correo al Titular, te suscribes a su boletín o realizas una contratación, estás facilitando información de carácter personal de la que el responsable es el Titular. Esta información puede incluir datos de carácter personal como pueden ser tu dirección IP, nombre y apellidos, dirección física, dirección de correo electrónico, número de teléfono, y otra información. Al facilitar esta información, das tu consentimiento para que tu información sea recopilada, utilizada, gestionada y almacenada por superadmin.es , sólo como se describe en el Aviso Legal y en la presente Política de Privacidad.</p>
							<p>Los datos personales y la finalidad del tratamiento por parte del Titular es diferente según el sistema de captura de información:</p>
							<ul>
								<li><strong>Formularios de contacto:</strong>El Titular solicita datos personales entre los que pueden estar: Nombre y apellidos, dirección de correo electrónico, número de teléfono y dirección de tu sitio Web con la finalidad de responder a tus consultas.<br>Por ejemplo, el Titular utiliza esos datos para dar respuesta a tus mensajes, dudas, quejas, comentarios o inquietudes que puedas tener relativas a la información incluida en el sitio Web, los servicios que se prestan a través del sitio Web, el tratamiento de tus datos personales, cuestiones referentes a los textos legales incluidos en el sitio Web, así como cualquier otra consulta que puedas tener y que no esté sujeta a las condiciones del sitio Web o de la contratación.</li>
							</ul>
							<p>Existen otras finalidades por las que el Titular trata tus datos personales:</p>
							<ul>
								<li>Para garantizar el cumplimiento de las condiciones recogidas en el Aviso Legal y en la ley aplicable. Esto puede incluir el desarrollo de herramientas y algoritmos que ayuden a este sitio Web a garantizar la confidencialidad de los datos personales que recoge.</li>
								<li>Para apoyar y mejorar los servicios que ofrece este sitio Web.</li>
								<li>Para analizar la navegación. El Titular recoge otros datos no identificativos que se obtienen mediante el uso de cookies que se descargan en tu ordenador cuando navegas por el sitio Web cuyas caracterísiticas y finalidad están detalladas en la Política de Cookies .</li>
								<li>Para gestionar las redes sociales. el Titular tiene presencia en redes sociales. Si te haces seguidor en las redes sociales del Titular el tratamiento de los datos personales se regirá por este apartado, así como por aquellas condiciones de uso, políticas de privacidad y normativas de acceso que pertenezcan a la red social que proceda en cada caso y que has aceptado previamente.</li>
							</ul>
						</div>
						<div>
							<h2>Seguridad de los datos personales</h2>
							<p>Para proteger tus datos personales, el Titular toma todas las precauciones razonables y sigue las mejores prácticas de la industria para evitar su pérdida, mal uso, acceso indebido, divulgación, alteración o destrucción de los mismos.</p>
						</div>
						<div>
							<h2>Contenido de otros sitios web</h2>
							<p>Las páginas de este sitio Web pueden incluir contenido incrustado (por ejemplo, vídeos, imágenes, artículos, etc.). El contenido incrustado de otras web se comporta exactamente de la misma manera que si hubieras visitado la otra web.</p>
							<p>Estos sitios Web pueden recopilar datos sobre ti, utilizar cookies, incrustar un código de seguimiento adicional de terceros, y supervisar tu interacción usando este código.</p>
						</div>
						<div>
							<h2>Legitimación para el tratamiento de datos</h2>
							<p>La base legal para el tratamiento de tus datos es: el consentimiento.</p>
							<p>Para contactar con el Titular, suscribirte a un boletín o realizar comentarios en este sitio Web tienes que aceptar la presente Política de Privacidad.</p>
						</div>
						<div>
							<h2>Categorías de datos personales</h2>
							<p>Las categorías de datos personales que trata el Titular son:</p>
							<ul>
								<li>Datos identificativos.</li>
							</ul>
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