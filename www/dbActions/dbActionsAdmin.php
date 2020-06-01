<?php
header('Content-type: application/json');
include "../common/start.php";


function cleanData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



/*if (!isset($_SESSION['rango']) || $_SESSION['rango'] < 5) {
    $response->code = 900;
    $response->msg = "ADMINS ONLY";
    $response->showJsonData();
    exit;
}*/

if (!isset($_GET['option']) || !is_numeric($_GET['option'])) {
    $response->code = 2;
    $response->msg = "Error de opcion";
    $response->showJsonData();
    exit;
}

$option = intval($_GET['option']);

//conexion base de datos
include "./../../datasql.php";
$con = mysqli_connect(IP, USUARIO, CLAVE, BD);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

switch ($option) {

    case 0: //activacion o desactivacion de usuarios

        if (!isset($_GET['id']) /*|| empty($_GET['id'])*/ || !isset($_GET['bool']) /*|| empty($_GET['bool'])*/) {
            $response->code = 21;
            $response->msg = 'Valores no introducidos';
        } else {
            if ($stmt = $con->prepare('UPDATE accounts SET activ = ? WHERE id = ?')) {

                $stmt->bind_param('ii', $_GET['bool'], $_GET['id']);

                $stmt->execute();

                $stmt->close();

                $response->code = 0;
            } else {
                //error 99
            }
        }

        break;

    case 1: //ELIMINACION DE MENSAJE DE CONTACTO

        if (!isset($_GET['id'])) {
            $response->code = 21;
            $response->msg = 'Valores no introducidos';
        } else {
            if ($stmt = $con->prepare('DELETE FROM contact WHERE id=?;')) {

                $stmt->bind_param('i', $_GET['id']);

                $stmt->execute();

                $stmt->close();

                $response->code = 0;
            } else {
                //error 99
            }
        }

        break;

    case 2://CAMBIO DE RANGO DE USUARIO

        if (!isset($_GET['username']) && !isset($_GET['rango'])) {
            $response->code = 21;
            $response->msg = 'Valores no introducidos';
        } else {
            if ($stmt = $con->prepare('UPDATE accounts SET rango = ? WHERE username = ?')) {

                $stmt->bind_param('is', $_GET['rango'], $_GET['username']);

                $stmt->execute();

                $stmt->store_result();

                $response->msg = $stmt->affected_rows;

                $stmt->close();

                $response->code = 0;
            } else {
                //error 99
            }
        }

        break;
}

$response->showJsonData();
