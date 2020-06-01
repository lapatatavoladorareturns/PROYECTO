<?php
include_once "./../common/ResponseClass.php";

include "./../../datasql.php";
// Change this to your connection info.

// Try and connect using the info above.
$con = mysqli_connect(IP, USUARIO, CLAVE, BD);

if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	$response->code = 9;
	$response->msg = 'Error en la conexion a la base de datos';
	exit(json_encode($response));
}
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	$response->code = 1;
	$response->msg = 'Introduzca la informacion necesaria';
	exit(json_encode($response));
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	$response->code = 1;
	$response->msg = 'Introduzca la informacion necesaria';
	exit(json_encode($response));
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$response->code = 20;
	$response->msg = 'Email invalido';
}
if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
	$response->code = 21;
	$response->msg = 'Usuario invalido';
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	$response->code = 22;
	$response->msg = 'Contraseña invalida debe tener de 5 a 20 caracteres';
}

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		$response->code = 3;
		$response->msg = 'Usuario ya existente';
	} else {
		// Insert new account
		// Username doesnt exists, insert new account
		if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activ) VALUES (?, ?, ?, false)')) {
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);

			$stmt->execute();

			$response->code = 0;
			$response->msg = 'Registro completado';
		} else {
			// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
			$response->code = 9;
			$response->msg = 'Error en la base de datos';
		}
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	$response->code = 9;
	$response->msg = 'Error en la base de datos';
}
$con->close();
echo json_encode($response);
