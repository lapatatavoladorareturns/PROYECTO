<?php

include_once "ResponseClass.php";

session_start();

//comprobar que el usuario esta logueado
if (!isset($_SESSION['loggedin'])) {
    $response->code = 1;
    $response->msg = "No se ha inciado sesion";
    $response->showJsonData();
    
    exit ;
}

?>