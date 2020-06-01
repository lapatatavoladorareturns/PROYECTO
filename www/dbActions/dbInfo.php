<?php
header('Content-type: application/json');
include_once "../common/start.php";
//include_once "./uno.php";

function cleanData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


//Comprobar el grupo

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
include_once "./../../datasql.php";
$con = mysqli_connect(IP, USUARIO, CLAVE, BD);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

switch ($option) {
    case 0: //obtener la KDD con ID

        if ($stmt = $con->prepare('SELECT gpsLat,gpsLng,titulo,descripcion FROM KDD_POSTS WHERE id=?')) {
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($lat, $lng, $tit, $desc);

            while ($stmt->fetch()) {
                $response->msg[] = array("titulo" => $tit, "descripcion" => $desc, "lat" => $lat, "lng" => $lng);
            }
            $response->code = 0;


            $stmt->close();
        }

        break;

    case 1:
        //get info user
        $response->code = 23;
        if ($stmt = $con->prepare('SELECT username,picture,email,rango FROM accounts WHERE id=?')) {
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user, $pic, $email, $rango);
            $stmt->fetch();


            $response->msg = array("user" => $user, "pic" => $pic, "email" => $email, "rango" => $rango);

            $response->code = 0;

            $stmt->close();
        }

        break;

    case 2:
        //get users of group

        if ($stmt = $con->prepare('SELECT id_usu FROM grupos_miembros WHERE id_grupo=? AND rango >= 0')) {
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id_usu);

            while ($stmt->fetch()) {
                $response->msg[] = $id_usu;
            }
            $response->code = 0;


            $stmt->close();
        }

        break;

    case 3:
        //obtener datos de kdd mas grupo
        if ($stmt = $con->prepare('SELECT kdd.id,kdd.titulo,kdd.descripcion,kdd.gpsLat,kdd.gpsLng,kdd.dT,grupos.nombre FROM `kdd_posts` kdd LEFT JOIN grupos ON kdd.id_grupo=grupos.id WHERE id_grupo in (select id_grupo from grupos_miembros where id_usu = ?) AND kdd.dT > CURRENT_TIMESTAMP')) {

            $stmt->bind_param('i', $_SESSION['id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $titulo, $desc, $lat, $lng, $dt, $nombre);

            while ($stmt->fetch()) {
                $response->msg[] = array('id' => $id, 'title' => $titulo, 'desc' => $desc, 'gpsLat' => $lat, 'gpsLng' => $lng, 'time' => $dt, 'nombreGrupo' => $nombre);
            }
            $response->code = 0;

            $stmt->close();
        }

        break;

    case 4:
        //obtener grupos y kdds activos de los grupos del usuario
        if ($stmt = $con->prepare('SELECT grupos.nombre,grupos.id,(SELECT COUNT(kdd_posts.id) from kdd_posts where kdd_posts.id_grupo=grupos.id and kdd_posts.dT>=CURRENT_TIMESTAMP) FROM grupos where grupos.id in (select id_grupo from grupos_miembros where id_usu = ?)')) {

            $stmt->bind_param('i', $_SESSION['id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result( $nombre, $id,$num);

            while ($stmt->fetch()) {
                $response->msg[] = array("kddcount" => $num, "groupName" => $nombre, "id" => $id);
            }
            $response->code = 0;

            $stmt->close();
        }

        break;

        //SELECT count(kdd.id),grupos.nombre FROM `kdd_posts` kdd LEFT JOIN grupos ON kdd.id_grupo=grupos.id WHERE id_grupo in (select id_grupo from grupos_miembros where id_usu = 3) AND (kdd.dt > CURRENT_TIMESTAMP) GROUP BY grupos.nombre 

    case 5: //get GROUPS WHERE USER IS ADMIN Or rango
        if ($stmt = $con->prepare('SELECT grupos_miembros.id_grupo,grupos.nombre FROM `grupos_miembros` LEFT JOIN grupos ON grupos.id=grupos_miembros.id_grupo WHERE grupos_miembros.id_usu=? and grupos_miembros.rango >= ?')) {

            $rango = 5;
            if (isset($_GET['rango'])) {
                $rango = cleanData($_GET['rango']);
            }

            $stmt->bind_param('ii', $_SESSION['id'], $rango);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $nombre);

            while ($stmt->fetch()) {
                $response->msg[] = array("groupName" => $nombre, "id" => $id);
            }
            $response->code = 0;

            $stmt->close();
        }

        break;

    case 6: //GET ALL GROUPS
        if ($stmt = $con->prepare('SELECT grupos.id,grupos.nombre,count(grupos_miembros.id_usu),(SELECT count(id) from kdd_posts where kdd_posts.id_grupo = grupos.id and kdd_posts.dT>=CURRENT_TIMESTAMP) 
            FROM grupos LEFT JOIN grupos_miembros ON grupos.id = grupos_miembros.id_grupo GROUP BY grupos.nombre')) {

            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $nombre, $miembros, $numkdds);

            while ($stmt->fetch()) {
                $response->msg[] = array("groupName" => $nombre, "id" => $id, "numMiembros" => $miembros, "numKdds" => $numkdds);
            }
            $response->code = 0;

            $stmt->close();
        }

        break;

    case 7: //get kdd of a group
        if (!isset($_GET['id_grupo'])) {
            $response->code = 20;
            $response->msg = "Valor no introducido";
        } else {
            if ($stmt = $con->prepare('SELECT kdd.id,kdd.titulo,kdd.descripcion,kdd.gpsLat,kdd.gpsLng,kdd.dT,grupos.nombre FROM `kdd_posts` kdd LEFT JOIN grupos ON kdd.id_grupo=grupos.id WHERE id_grupo = ?')) {
                $stmt->bind_param('i', $_GET['id_grupo']);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id, $titulo, $desc, $lat, $lng, $dt, $nombre);

                while ($stmt->fetch()) {
                    $response->msg[] = array('id' => $id, 'title' => $titulo, 'desc' => $desc, 'gpsLat' => $lat, 'gpsLng' => $lng, 'time' => $dt, 'nombreGrupo' => $nombre);
                }
                $response->code = 0;

                $stmt->close();
            }
        }

        break;
}

$response->showJsonData();
