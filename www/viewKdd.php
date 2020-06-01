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

if ($stmt = $con->prepare('SELECT KDD_POSTS.gpsLat,KDD_POSTS.gpsLng,KDD_POSTS.titulo,KDD_POSTS.descripcion,grupos.nombre,KDD_POSTS.dT FROM KDD_POSTS LEFT JOIN grupos ON kdd_posts.id_grupo = grupos.id where kdd_posts.id = ?')) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($lat, $lng, $titulo, $descripcion, $grupo_nombre,$dt);
        $stmt->fetch();

?>
        <!DOCTYPE html>
        <html>

        <head>
            <base target="_parent">
            <meta charset="utf-8">
            <link rel="icon" type="image/png" href="img/logo/logo1.png">
            <title>Visualizador de KDDs</title>
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
                                        <a class="dropdown-item rounded active" href="admin.php">Panel administrador</a>
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

                            <div class="p-2">
                                <!--new Date ( Date.parse("/****dt***/".split(" ")[0]) - 7200000) -->
                                <div class="d-flex justify-content-between">
                                    <h1><?php echo $titulo; ?></h1>
                                    <p>Grupo: <?php echo $grupo_nombre; ?></p>
                                </div>
                                <div id="mapid" style=" min-width:50vw;min-height:60vh;max-height:70vh"></div>
                                <hr>
                                <div id="descripcion"><?php echo $descripcion ?></div>
                                <div>Fecha y Hora: <?php echo $dt ?></div>

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
            <script>
                //mapa
                var mymap = L.map('mapid').setView([<?php echo $lat . "," . $lng ?>], 13);

                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                    maxZoom: 18,
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1
                }).addTo(mymap);

                L.marker([<?php echo $lat . "," . $lng ?>]).addTo(mymap);
            </script>
            <script>
                /*$.ajax({
                url: "dbActions/dbInfoAdmin.php",
                data: {
                    option: 0
                },
                method: "GET"
            })
            .done(function(data) {
                console.log(data);
                let el = $("#comentarios").find("tbody");
                for (let i of data.msg) {
                    let li = $("<tr class='w-100'></tr>");
                    li.append($("<td></td>").text(i.email));
                    li.append($("<td class='col-10' style='overflow-y: scroll'></td>").text(i.comment));
                    li.append($("<td class='py-2'></td>").html(`<button type="button" class="btn btn-outline-danger btn-rounded btn-md waves-effect" value="${i.id}">Eliminar</button>`));
                    el.append(li);
                }

                $("#comentarios tbody .btn").click(botonComment);


            })
            .fail(function() {
                console.log("fail");

            })
        /*.always(function() {
            $(".loading").each(function(e, el) {
                el.style.display = "none"
            })
            setTimeout(function() {
                hide();
                document.getElementById("login").style = "";
            }, 1000);
        })*/
                ;
                /*$.ajax({
                url: "dbActions/dbInfoAdmin.php",
                data: {
                    option: 1
                },
                method: "GET"
            })
            .done(function(data) {
                console.log(data);
                let el = $("#cuentas").find("tbody");
                for (let i of data.msg) {
                    let li = $("<tr></tr>");
                    li.attr('value',i.id);
                    li.append($("<td></td>").text(i.user));
                    li.append($("<td></td>").text(i.email));
                    li.append($("<td class='py-2'></td>").html(`<button type="button" class="btn btn-outline-success btn-rounded btn-md waves-effect " value="1">Activar</button><button type="button" class="btn btn-outline-danger btn-rounded btn-md waves-effect d-none" value="0">Deshacer</button>`));
                    el.append(li);
                }

                $("#cuentas tbody .btn").click(botonActiv);


            })
            .fail(function() {
                console.log("fail");

            })

        function botonActiv(ev){
            console.log(ev);
            let el = $(ev.target);
            activate(el.parent().parent().attr('value'),el.val());
            
        }
        

        function activate(id,bool){

            console.log(id);
            console.log(bool);
            $.ajax({
                url: "dbActions/dbActionsAdmin.php",
                data: {
                    'option': 0,
                    'id':id,
                    'bool': bool
                },
                method: "GET"
            })
            .done(function(data) {
                console.log(data);
                if (data.code == 0){
                    $(`#cuentas [value=${id}] .btn`).toggleClass("d-none");
                }
                return true;
            })
            .fail(function() {
                return false;
            })
        }

        function botonComment(ev){
            console.log($(ev.target).val());
            $.ajax({
                url: "dbActions/dbActionsAdmin.php",
                data: {
                    'option': 1,
                    'id':$(ev.target).val(),
                },
                method: "GET"
            })
            .done(function(data) {
                console.log(data);
                if (data.code == 0){                    
                    $(ev.target).parent().parent().remove();
                }
                return true;
            })
            .fail(function() {
                return false;
            })
        }

*/
            </script>

        </body>

        </html>

<?php
    } else {
        echo "Error";
    }
}

?>