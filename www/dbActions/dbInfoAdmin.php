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
    case 0: //obtener todos los mensajes de contacto
        //SELECT * FROM `contact` ORDER BY `contact`.`dT` ASC

        //$resul = false;

        if ($stmt = $con->prepare('SELECT email,comment,id FROM `contact` ORDER BY `contact`.`dT` ASC')) {

            $stmt->execute();

            $stmt->store_result();

            $stmt->bind_result($email, $comment,$id);

            $response->msg = [];
            $response->code = 0;

            while ($stmt->fetch()) {
                $response->msg[] = array("email" => $email, "comment" => $comment,"id"=>$id);
            }
        }

        $stmt->close();

        break;
    case 1: //obtener todas las cuentas pendientes de activar
        //SELECT * FROM `contact` ORDER BY `contact`.`dT` ASC

        //$resul = false;

        if ($stmt = $con->prepare('SELECT id,username,email FROM `accounts` WHERE activ = false ORDER BY `accounts`.`id` ASC ')) {

            $stmt->execute();

            $stmt->store_result();

            $stmt->bind_result($id,$user,$email);

            $response->msg = [];
            $response->code = 0;

            while ($stmt->fetch()) {
                $response->msg[] = array("id" => $id, "user" => $user,"email" => $email);
            }
        }

        $stmt->close();

        break;
}

$response->showJsonData();
