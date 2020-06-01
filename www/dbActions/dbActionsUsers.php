<?php
header('Content-type: application/json');
session_start();

class Response
{
    public $code = 99;
    public $msg = '';

    public function showJsonData()
    {
        echo json_encode($this);
    }
}

function cleanData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$response = new Response;

//comprobar que el usuario esta logueado
if (!isset($_SESSION['loggedin'])) {
    $response->code = 1;
    $response->msg = "No se ha inciado sesion";
    $response->showJsonData();
    exit;
}

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
    case 0: //cambio de contraseña
        if (!isset($_POST['OldPass']) || !isset($_POST['NewPass'])) {
            $response->code = 20;
            $response->msg = "Error de opcion, Valores no recibidos";
        } else {
            $resul = false;
            //Comprobar la contraseña anterior
            if ($stmt = $con->prepare('SELECT password FROM accounts WHERE id = ?')) {
                $stmt->bind_param('i', $_SESSION['id']);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($password);
                    $stmt->fetch();
                    if (password_verify($_POST['OldPass'], $password)) {
                        $resul = true;
                    } else {
                        $response->code = 21;
                        $response->msg = 'Incorrect old password!';
                    }
                } else {
                    //error
                    $response->code = 3;
                    $response->msg = '';
                }
            }


            if ($resul) {
                //Comprobacion complejidad contraseña nueva
                if (strlen($_POST['NewPass']) > 20 || strlen($_POST['NewPass']) < 5) {
                    $response->code = 22;
                    $response->msg = 'Incorrect new password!';
                } else {
                    //Cambio de contraseña
                    if ($stmt = $con->prepare('UPDATE accounts SET password = ? WHERE id = ?')) {

                        $password = password_hash($_POST['NewPass'], PASSWORD_DEFAULT);

                        $stmt->bind_param('si', $password, $_SESSION['id']);

                        $stmt->execute();

                        $response->code = 0;
                    } else {
                        //error 99
                    }
                }
            }
            $stmt->close();
        }
        break;

    case 1: //cambio de correo

        if (!isset($_POST['mail'])) {
            $response->code = 30;
            $response->msg = 'Error de opcion, Valor no recibido';
        } else {
            $email = cleanData($_POST["mail"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response->code = 31;
                $response->msg = 'Error de opcion, Valor no valido';
            } else {
                //Cambiar en base de datos
                if ($stmt = $con->prepare('UPDATE accounts SET email = ? WHERE id = ?')) {

                    $stmt->bind_param('si', $email, $_SESSION['id']);

                    $stmt->execute();

                    $response->code = 0;
                } else {
                }
            }
        }

        break;

    case 2://cambio de foto de perfil

        /*comprobar que solo se sube un archivo
        if (!is_array($_FILES['ficheros']['name'])){
            header("Location: formularioSubida.php");
            exit;
        }*/
        //var_dump($_FILES);
        $response->code = 40;
        $response->msg = 'Error de opcion, Datos no recibidos';

        if (!isset($_FILES['ficheros'])) {
            $response->code = 40;
            $response->msg = 'Error de opcion, Datos no recibidos';
        } else {
            if (!preg_match('/^image/', $_FILES['ficheros']['type'])) {
                $response->code = 41;
                $response->msg = 'Error de opcion, no es una imagen';
            } else {
                switch ($_FILES['ficheros']['error']) {

                    case UPLOAD_ERR_OK:
                        $id = $_SESSION['id'] /*. "_" . $_FILES['ficheros']['name']*/;
                        $ficheroSubido = "./../img/profile/" . $id;
                        if (move_uploaded_file($_FILES['ficheros']['tmp_name'], $ficheroSubido)) {

                            if ($stmt = $con->prepare('UPDATE accounts SET picture = ? WHERE id = ?')) {

                                $stmt->bind_param('si', $id, $_SESSION['id']);

                                $stmt->execute();

                                $response->code = 0;
                                $response->msg = "img/profile/" . $id;
                                $_SESSION['pic'] = $id;
                            } else {
                                //error 99
                            }
                        } else {
                            $response->msg .= basename($_FILES['ficheros']['name'][$i]) . " error desconocido. ";
                        }
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $response->msg .= basename($_FILES['ficheros']['name'][$i]) . " no existe. ";
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $response->msg .= basename($_FILES['ficheros']['name'][$i]) . " excede el límite. ";
                    default:
                        $response->msg .= basename($_FILES['ficheros']['name'][$i]) . " error desconocido. ";
                }
            }
        }

        break;

    case 3: //SOLICITAR UNIRSE A UN GRUPO

        
        

        if (!isset($_POST['id_grupo'])) {
            $response->code = 30;
            $response->msg = 'Error de opcion, Valor no recibido';
        } else {
            
            $id = cleanData($_POST["id_grupo"]);

            if ($stmt = $con->prepare('select count(id_usu) from grupos_miembros where id_grupo = ? AND id_usu = ?')){
                $stmt->bind_param('ii', $id, $_SESSION['id']);
                $stmt->bind_result($num);
                $stmt->execute();
                $stmt->fetch();
                $stmt->close();
                

                if ($num !=0){
                    $response->code = 1;
                    $response->msg="usuario ya esta en el grupo";
                }
                else if ($stmt = $con->prepare('select datos from grupo_data where id_grupo = ? AND opcion = 0')) {
                    //comprobar si es publico o no
                    $stmt->bind_param('i', $id);
                    $stmt->bind_result($data);
                    $stmt->execute();
                    $stmt->fetch();
                    $stmt->close();
    
                    if ($data == null || $data == 0) {
                        $sql = 'insert into grupos_miembros(id_grupo,id_usu,rango) values(?,?,0)';
    
                        $msg = "Grupo publico";
    
                    } else {
                        $sql = 'insert into grupos_miembros(id_grupo,id_usu,rango) values(?,?,-1)';
                        
                        $msg = "Grupo privado";
                    }
    
                    //Cambiar en base de datos
                    if ($stmt = $con->prepare($sql)) {
    
                        $stmt->bind_param('ii', $id, $_SESSION['id']);
    
                        $stmt->execute();
    
                        $response->code = 0;
                        $response->msg = $msg;
                    } else {
                    }
                }
            }


            
            
        }

        break;
}

$response->showJsonData();
