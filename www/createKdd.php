<?php
include_once "./common/start.php";

?>
<!DOCTYPE html>
<html>

<head>
    <base target="_parent">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/logo/logo1.png">
	<title>Creador de KDD</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="stylesheet" href="css/style.css">

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
                    <li class="nav-item active">
                        <a class="nav-link" href="createKdd.php">
                            <i class="fas fa-plus-circle"></i></i> Crear kdd
                            <span class="sr-only">(current)</span>
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
                <div class="container  blue-grey darken-3 text-light ">

                    <div class="p-2">
                        <div class="alert alert-danger d-none" role="alert" id="warning">
                            Algun valor no ha sido definido correctamente
                        </div>
                        <!--new Date ( Date.parse("/****dt***/".split(" ")[0]) - 7200000) -->
                        <div class="content">
                            <div class="d-flex justify-content-between">
                                <h3><input name="Titulo" type="text" id="tit" placeholder="Titulo" class="form-control"></h3>
                                <div class="d-flex text-center align-middle">
                                    <!--<label for="grupoSelect1" class="h3">Grupo: </label>-->
                                    <select name="grupoSelect1" id="grupoSelect1" class="browser-default custom-select rounded disabled selectGroup">
                                        <option value="-1" selected>Cargando opciones..</option>
                                    </select>
                                    <div class="col-1 h2">
                                        <i class="fas fa-circle-notch fa-spin"></i>
                                    </div>
                                </div>

                            </div>
                            <div id="mapid" style=" min-width:50vw;min-height:60vh;max-height:70vh"></div>
                            <hr>
                            <div id="descripcion" class="pb-2">
                                <div class="input-group px-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descripcion</span>
                                    </div>
                                    <textarea class="form-control" aria-label="Descripcion kdd" id="desc" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-md-between justify-content-center pt-2">
                                <div class="col-12 col-md-5">
                                    <div class="d-flex" id="date">
                                        <label for="date" class="col-4">Fecha y Hora</label>
                                        <input name="Fecha" type="date" class="form-control col-4">
                                        <input name="Hora" type="time" class="form-control col-3">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <button class="btn boton " id="send">
                                        <span>Enviar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="loading">
                            <div class="d-flex justify-content-center ">
                                <div class="spinner-border m-5 p-5 " role="status" style="width: 1rem; height: 1rem;color: orange">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <div class="error">
                            <div class="d-flex justify-content-center">
                                <div class="m-2 p-5" role="status">
                                    <i class="fa fa-exclamation-triangle fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: Red"></i>
                                    <p class="msg text-center">Error</p>
                                </div>
                            </div>
                        </div>
                        <div class="success ">
                            <div class="d-flex justify-content-center">
                                <div class="m-2 p-5" role="status">
                                    <i class="fas fa-check fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: green"></i>
                                    <p class="msg">Enviado</p>
                                </div>
                            </div>
                        </div>

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
        var mymap = L.map('mapid').setView([40.42, -3.69], 6);
        var marker;

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

        marker = L.marker([40.42, -3.69]).addTo(mymap)
            .bindPopup("<b>Haz click en el lugar de encuentro</b>").openPopup();


        var popup = L.popup();

        function onMapClick(e) {
            mymap.removeLayer(marker);

            marker = new L.Marker(e.latlng, {
                draggable: true
            });
            mymap.addLayer(marker);
            marker.bindPopup("Coordenadas: " + e.latlng.toString());
            setTimeout(() => {
                marker.openPopup();
            }, 250);

        }

        mymap.on('click', onMapClick);


        $("#send").click(send);

        function send() {
            let i = marker._latlng;
            //console.log();

            $("select, input, textarea").change(function() {
                $("#warning").addClass("d-none");
            })

            if (($("#tit").val() == "") || ($("#grupoSelect1").val() <= 0) || ($("#date input").first().val() == "")) {
                $("#warning").removeClass("d-none");
            } else {
                $(".content").addClass("d-none");
                $(".loading").removeClass("d-none");
                let a = {
                    "option": 0,
                    "lat": i.lat,
                    "lng": i.lng,
                    "tit": $("#tit").val(),
                    "date": $("#date input").first().val() + " " + $("#date input").last().val(),
                    "desc": $("#desc").val(),
                    "id_grupo": parseInt($("#grupoSelect1").val())
                };
                console.log(a);
                $.ajax({
                            url: "./dbActions/dbActionsGroups.php",
                            data: a,
                            method: "POST"
                        }

                    )
                    .done(function(data) {

                        console.log(data);
                        if (data.code == 0){
                            $(".loading").addClass("d-none");
                            $(".success").removeClass("d-none");
                        }
                        else{
                            $(".loading").addClass("d-none");
                            $(".error").removeClass("d-none");

                        }

                    })
                    .fail(function(data){
                        console.log(data);
                    })
                    .always(function(){
                        setTimeout(() => {
                            $(".loading, .error, .success").addClass("d-none");
                            $(".content").removeClass("d-none");
                        }, 1500);
                    })
            }
        }
    </script>

    <script>
        $(".loading, .error, .success").addClass("d-none");

        getGroupsUser($("#grupoSelect1"))

        function getGroupsUser(select) {

            let a = {
                "option": 5,
                "rango": 0
            };

            $.ajax({
                    url: "./dbActions/dbInfo.php",
                    data: a,
                    method: "GET"
                })
                .done(function(data) {
                    console.log(data);

                    if (data.code == 0) {
                        select.empty();
                        select.append('<option selected="true" value="-1">Selecciona grupo</option>');
                        select.prop('selectedIndex', 0);
                        $.each(data.msg, function(ind, elem) {
                            select.append($('<option></option>').attr('value', elem.id).text(elem.groupName));
                        })
                        select.removeClass("disabled");
                        select.siblings().find(".fa-spin").addClass("d-none");
                    }


                    /*if (data.code == 0) {
                        $("#mainData").find(".success").removeClass("d-none");

                    } else {
                        let elem = $("#createGroupMain").find(".error");
                        elem.find(".msg").text(data.msg);
                        elem.removeClass("d-none");

                    }*/


                })
                .fail(function(data) {
                    console.log("fail");
                    console.log(data)

                })
        }
    </script>

</body>

</html>