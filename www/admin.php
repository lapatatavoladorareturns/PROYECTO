<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <base target="_parent">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/logo/logo1.png">
	<title>Panel administrador</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>

    </style>

</head>
<?php
if ($_SESSION['rango'] < 5) { ?>

    <div class="text-center text-danger">
        <h2>Solo administradores permitidos</h2>
    </div>
<?php } else { ?>

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

                        <div class="table-responsive " style="max-height:50vh;">
                            <table id="comentarios" class="table text-light">
                                <thead>
                                    <tr>
                                        <th scope="col" class="font-weight-bold th-sm col-md-3">E-mail</th>
                                        <th scope="col" class="font-weight-bold th-lg col-md-8">Mensaje</th>
                                        <th scope="col" class="font-weight-bold th-lg col-md-2">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                        </div>
                        <div class="table-responsive" style="max-height:50vh;">
                            <table id="cuentas" class="table text-light">
                                <thead>
                                    <tr>
                                        <th scope="col" class="font-weight-bold th-sm col-md-3">Usuario</th>
                                        <th scope="col" class="font-weight-bold th-lg col-md-6">E-mail</th>
                                        <th scope="col" class="font-weight-bold th-lg col-md-2">Activar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                        </div>

                        <div>
                            <form class="d-block d-md-flex justify-content-around align-items-center text-center row border-bottom mb-4 mb-md-3 mt-4 mt-md-1 py-3" id="rango">
                                <span class="font-weight-bold col-md-4">Cambiar rango</span>
                                <div class="col-md-8">
                                    <div class="content d-block d-lg-flex align-items-center text-center">

                                        <div class="md-form">
                                            <i class="fas fa-user prefix d-flex"></i>
                                            <input type="text" id="username" name="username" class="form-control text-light" required>
                                            <label for="username" class="d-flex text-light font-weight-bold">Nombre usuario</label>
                                        </div>

                                        <div class="md-form">
                                            <i class=""></i>
                                            <input type="number" id="rangoVal" name="rango" class="form-control text-light" required>
                                            <label for="rango" class="d-flex text-light font-weight-bold">Rango</label>
                                        </div>

                                        <button class="btn btn-success">Enviar</button>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include "./common/footer.php" ?>
    </div>
    <script type=" text/javascript" src="js/jquery.min.js"></script>
                                            <script type="text/javascript" src="js/popper.min.js"></script>
                                            <script type="text/javascript" src="js/bootstrap.min.js"></script>
                                            <script type="text/javascript" src="js/mdb.min.js"></script>
                                            <script>
                                                $("#rango").submit(changeRango);
                                                //rango

                                                $.ajax({
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
                                                $.ajax({
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
                                                            li.attr('value', i.id);
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

                                                function botonActiv(ev) {
                                                    console.log(ev);
                                                    let el = $(ev.target);
                                                    activate(el.parent().parent().attr('value'), el.val());

                                                }


                                                function activate(id, bool) {

                                                    console.log(id);
                                                    console.log(bool);
                                                    $.ajax({
                                                            url: "dbActions/dbActionsAdmin.php",
                                                            data: {
                                                                'option': 0,
                                                                'id': id,
                                                                'bool': bool
                                                            },
                                                            method: "GET"
                                                        })
                                                        .done(function(data) {
                                                            console.log(data);
                                                            if (data.code == 0) {
                                                                $(`#cuentas [value=${id}] .btn`).toggleClass("d-none");
                                                            }
                                                            return true;
                                                        })
                                                        .fail(function() {
                                                            return false;
                                                        })
                                                }

                                                function botonComment(ev) {
                                                    console.log($(ev.target).val());
                                                    $.ajax({
                                                            url: "dbActions/dbActionsAdmin.php",
                                                            data: {
                                                                'option': 1,
                                                                'id': $(ev.target).val(),
                                                            },
                                                            method: "GET"
                                                        })
                                                        .done(function(data) {
                                                            console.log(data);
                                                            if (data.code == 0) {
                                                                $(ev.target).parent().parent().remove();
                                                            }
                                                            return true;
                                                        })
                                                        .fail(function() {
                                                            return false;
                                                        })
                                                }

                                                function changeRango(ev) {
                                                    ev.preventDefault();
                                                    $.ajax({
                                                            url: "dbActions/dbActionsAdmin.php",
                                                            data: {
                                                                option: 2,
                                                                username: $('#username').val(),
                                                                rango: $("#rangoVal").val()
                                                            },
                                                            method: "GET"
                                                        })
                                                        .done(function(data) {
                                                            console.log(data);
                                                            if (data.code == 0) {
                                                                if (data.msg == 0) {
                                                                    alert("ningun usuario afectado");
                                                                } else {
                                                                    alert("usuario actualizado");
                                                                }
                                                            } else {
                                                                alert("error\n" + data.msg);
                                                            }

                                                        })
                                                        .fail(function(response) {
                                                            console.log(response)
                                                            console.log("fail");

                                                        })
                                                }
                                            </script>

    </body>

</html>

<?php } ?>