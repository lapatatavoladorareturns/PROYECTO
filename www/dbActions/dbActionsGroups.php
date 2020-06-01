 <?php
header('Content-type: application/json');
include_once "./../common/start.php";

function cleanData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



//comprobar que el usuario esta logueado
if (!isset($_SESSION['loggedin'])) {
    $response->code = 1;
    $response->msg = "No se ha inciado sesion";
    $response->showJsonData();
    exit;
}

/*TODO comprobar que es miembro del grupo*****************************************/



if (!isset($_POST['option']) || !is_numeric($_POST['option'])) {
    $response->code = 2;
    $response->msg = "Error de opcion";
    $response->showJsonData();
    exit;
}
$option = intval($_POST['option']);

//conexion base de datos
include "./../../datasql.php";
$con = mysqli_connect(IP, USUARIO, CLAVE, BD);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

switch ($option) {
    case 8:
        var_dump($_POST);
        break;
    case 0: //Introducir KDD en la base de datos

        if (!isset($_POST['tit']) || !isset($_POST['desc']) || !isset($_POST['lat']) || !isset($_POST['lng']) || !isset($_POST['date'])) {
            $response->code = 20;
            $response->msg = "Error de opcion, Valores no recibidos";
        } else {
            //TODO Quizas comprobar si hay en ese mismo dia  y en la zona otra KDD
            if ($stmt = $con->prepare('INSERT INTO kdd_posts(titulo,descripcion,gpsLat,gpsLng,dT,id_grupo) values(?,?,?,?,?,?)')) {
                $tit = cleanData($_POST['tit']);
                $desc = cleanData($_POST['desc']);
                $lat = cleanData($_POST['lat']);
                $lng = cleanData($_POST['lng']);
                $grupo = cleanData($_POST['id_grupo']);
                $date = cleanData($_POST['date']);

                $stmt->bind_param('ssddsi', $tit, $desc, $lat, $lng, $date, $grupo);

                $stmt->execute();

                $response->code = 0;
                $response->msg = $stmt->affected_rows;
            }
        }
        break;

    case 1://Creacion de nuevo grupo
        if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
            $response->code = 20;
            $response->msg = "Error de opcion, Valores no recibidos";
        } else {
            if ($stmt = $con->prepare('INSERT INTO grupos(id_creador,nombre) values(?,?)')) {

                $nombre = cleanData($_POST['nombre']);

                $stmt->bind_param('is', $_SESSION['id'], $nombre);

                $stmt->execute();

                $stmt->store_result();

                $rows = $stmt->affected_rows;

                $response->code = 0;

                if ($rows == -1) {
                    $response->code = 1;
                    $response->msg = "Error no se ha creado el grupo, por favor cambie el nombre del grupo";
                }
            }
        }
        break;

    case 2: //get users invitations of group
        if (!isset($_POST['id_grupo'])) {
            $response->code = 30;
            $response->msg = 'Error de opcion, Valor no recibido';
        } else {
            $id = cleanData($_POST["id_grupo"]);

            if ($stmt = $con->prepare('SELECT id_usu FROM grupos_miembros WHERE id_grupo=? AND rango < 0')) {
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id_usu);

                while ($stmt->fetch()) {
                    $response->msg[] = $id_usu;
                }
                $response->code = 0;


                $stmt->close();
            }
        }

        break;

    case 3: //cambiar rango a usuario o aceptarlo en el grupo

        if (!isset($_POST['id']) && !isset($_POST['id_grupo'])) {
            $response->code = 21;
            $response->msg = 'Valores no introducidos';
        } else {
            $rango = 0;
            if (isset($_POST['rango'])) {
                $rango = cleanData($_POST['rango']);
            }
            if ($stmt = $con->prepare('UPDATE grupos_miembros SET rango = ? WHERE id_usu = ? and id_grupo = ?')) {

                $stmt->bind_param('iii', $rango, $_POST['id'], $_POST['id_grupo']);

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

    case 4: //Eliminar usuario

        if (!isset($_POST['id']) && !isset($_POST['id_grupo'])) {
            $response->code = 21;
            $response->msg = 'Valores no introducidos';
        } else {
            if ($stmt = $con->prepare('DELETE FROM grupos_miembros WHERE grupos_miembros.id_grupo = ? AND grupos_miembros.id_usu = ? ')) {

                $stmt->bind_param('ii', $_POST["id_grupo"], $_POST['id']);

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

    case 5: //change option



        if ($stmt = $con->prepare('INSERT INTO grupo_data (id_grupo, opcion, datos) VALUES (?,?,?) ON DUPLICATE KEY UPDATE datos=?')) {
            //comprobar si es publico o no
            $stmt->bind_param('iiss', $_POST['id_grupo'], $_POST['opcion'],$_POST['data'],$_POST['data']);

            $stmt->execute();

            $response->code = 0;

            $response->msg = $stmt->affected_rows;

            if ($stmt->affected_rows == 0) {
                $response->code = 1;
                $response->msg = ["msg" => "Ningun cambio realizado", "obj" => ["opcion" => $_POST['opcion'], "data" => $_POST['data']]];
            }


            $stmt->close();
        }

        break;


    case 6: //GET option



        if ($stmt = $con->prepare('SELECT datos FROM grupo_data WHERE id_grupo = ? AND opcion = ?')) {
            //comprobar si es publico o no
            $stmt->bind_param('ii', $_POST['id_grupo'], $_POST['opcion']);
            $stmt->bind_result($data);
            $stmt->execute();
            $stmt->fetch();

            $response->code = 0;

            $response->msg = $data;

            $stmt->close();
        }

        break;
}
//sleep(2);
$response->showJsonData();
