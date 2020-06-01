<?php
header('Content-type: application/json');

include_once "../common/ResponseClass.php";

function cleanData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


//comprobar que el usuario esta logueado
if (!isset($_POST['email'])) {
    $response->code = 100;
    $response->msg = "Valor no introducido";
    $response->showJsonData();
    exit;
}

//comprobar que el usuario esta logueado
if (!isset($_POST['texto'])) {
    $response->code = 100;
    $response->msg = "Valor no introducido";
    $response->showJsonData();
    exit;
}

//conexion base de datos
include "./../../datasql.php";
$con = mysqli_connect(IP, USUARIO, CLAVE, BD);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ($stmt = $con->prepare('INSERT INTO contact (email, comment) VALUES (?, ?)')) {

    $email = cleanData($_POST['email']);
    $text = cleanData($_POST['texto']);
    
    $stmt->bind_param('ss', $email , $text);

    $stmt->execute();

    $response->code = 0;

    $stmt->close();
} else {
    $response->code = 900;
    $response->msg = "Error de base de datos";
}

$response->showJsonData();
