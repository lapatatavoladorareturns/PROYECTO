<?php
include_once "./common/start.php";

//conexion base de datos
include "../datasql.php";
$con = mysqli_connect(IP, USUARIO, CLAVE, BD);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $response->code = 2;
    $response->msg = "Error de opcion";
    $response->showJsonData();
    exit;
}
$id = intval($_GET['id']);

if ($stmt = $con->prepare('SELECT count(id_usu) FROM `grupos_miembros` where id_grupo = ? AND id_usu = ? and rango >= 0')) {
    $stmt->bind_param('ii', $id, $_SESSION['id']);
    $stmt->execute();
    $stmt->store_result();
    $inGroup = false;
    $stmt->bind_result($inGroup);
    $stmt->fetch();
}

if ($stmt = $con->prepare('SELECT grupos.nombre,grupos.id_creador,(SELECT grupo_data.datos From grupo_data where grupos.id = grupo_data.id_grupo AND grupo_data.opcion = 0) FROM grupos where grupos.id = ?')) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();


?>
    <!DOCTYPE html>
    <html>

    <head>
        <base target="_parent">
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="img/logo/logo1.png">
        <title>Ver grupo</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/mdb.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>


        <style>

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
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">
                                <i class="fa fa-home"></i> Home

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

            <div class="container py-2 ">
                <div class="row main-container">
                    <div class="content container  blue-grey darken-3 text-light ">
                        <?php
                        echo $stmt->error;
                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($nombre, $id_creador, $privacy);
                            $stmt->fetch(); ?>

                            <div class="p-2">

                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <h2 class="col-5" data-id="<?php echo $id ?>" id="grupo"><?php echo $nombre ?></h2>

                                    </div>
                                    <?php if ($inGroup != 1) { ?>
                                        <button onclick="joinGroup()" class="btn boton">
                                            <span>Unirse</span>
                                        </button>
                                    <?php } ?>
                                    <div class="usuario col-2" data-id="<?php echo $id_creador ?>">

                                    </div>
                                </div>

                                <?php
                                //echo "privacidad: ".$privacy."asd";
                                if (($privacy == 0 || $privacy == null) || $inGroup == 1) { ?>
                                    <div class="d-md-flex">
                                        <div id="usuarios" class="col-12 col-md-4">

                                        </div>
                                        <div id="posts" class="col-12 col-md-8">
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
                                <?php } else { ?>
                                    <div class="p-2 text-center">
                                        <h3 class="text-warning">Unase al grupo para tener mas informacion</h3>
                                    </div>

                                <?php } ?>
                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="p-2 text-center">
                                <h2 class="text-warning">El grupo no existe</h2>
                            </div>
                    <?php
                        }
                    }

                    ?>

                    </div>
                </div>
            </div>

            <?php include "./common/footer.php" ?>
        </div>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/popper.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/mdb.min.js"></script>
        <script src="js/main/common.js"></script>

        <script>
            $(document).ready(function() {


                $.ajax({
                        url: "dbActions/dbInfo.php",
                        data: {
                            "option": 2,
                            "id": document.getElementById('grupo').dataset.id
                        },
                        method: "GET"
                    })
                    .done(function(data) {
                        if (data.code == 0) {
                            let dat = data.msg;
                            $.each(dat, function(i, elem) {
                                $("#usuarios").append((`<div><div class="usuario col-6" data-id="${elem}"></div></div>`));
                            })

                            generataUsers();
                        }
                    });


                $.ajax({
                        url: "dbActions/dbInfo.php",
                        data: {
                            "option": 7,
                            "id_grupo": document.getElementById('grupo').dataset.id

                        },
                        method: "GET"
                    })
                    .done(function(data) {
                        console.log(data);
                        let el = $("#posts").find("tbody");
                        for (let i of data.msg) {
                            let li = $(`<tr class='w-100 hoverable' data-id=${i.id}></tr>`);
                            li.append($("<td></td>").text(i.nombreGrupo));
                            li.append($("<td></td>").text(i.title));
                            li.append($("<td style='overflow-y: hidden'></td>").text(i.desc));
                            li.append($("<td></td>").text(i.gpsLat + "\t" + i.gpsLng));
                            li.append($("<td></td>").text(i.time));
                            el.append(li);
                            //new Date ( Date.parse("2020-06-20 00:00:00".split(" ")[0]) - 7200000) 
                        }

                        $("#posts tr").click(function() {
                            console.log(this);
                            window.location.href = `viewKdd.php?id=${$(this).attr("data-id")}`;
                        })

                    })
                    .fail(function() {
                        console.log("fail");

                    })
            });



            /*function generataUsers(secondClass = "", main = $(document)) {
                main.find(".usuario").each(function() {
                    let self = this;


                    $.ajax({
                            url: "dbActions/dbInfo.php",
                            data: {
                                "option": 1,
                                "id": self.dataset.id
                            },
                            method: "GET"
                        })
                        .done(function(data) {
                            if (data.code == 0) {
                                let dat = data.msg;
                                $(self).addClass(secondClass);
                                $(self).append($("<div class='rounded mb-0 border border-light d-flex justify-content-around  align-items-center' style='background-color: #3B707D'></div>").html(`<span>${dat.user}</span> <img src="./img/profile/${dat.pic}" class="rounded-circle z-depth-0" alt="avatar image" height="35">`));
                            }
                        });
                });
            }*/

            function joinGroup() {
                let id = $("#grupo").attr("data-id");

                $.ajax({
                        url: "dbActions/dbActionsUsers.php",
                        data: {
                            "option": 3,
                            "id_grupo": id
                        },
                        method: "POST"
                    })
                    .done(function(data) {
                        console.log(data);
                        /*if (data.code == 0) {
                            let dat = data.msg;

                        }*/
                    })
                    .fail(function(data) {
                        console.log("fail");
                        console.log(data);
                    })
            }
        </script>

    </body>

    </html>