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
    <title>Gestor de grupos</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mdb.min.css">

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
                            <a class="dropdown-item rounded active" href="viewGroups.php">Tus grupos</a>
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

        <div class="container py-5">
            <div class="row main-container">

                <div class="content container  blue-grey darken-3 text-light pt-2">
                    

                    <div>

                        <ul class="list-group list-group-horizontal-sm" id="myTab" role="tablist">
                            <li class="list-group-item list-group-item-action">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Grupos</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a class="nav-link" id="createGroup-tab" data-toggle="tab" href="#createGroup" role="tab" aria-controls="createGroup" aria-selected="false">Crear Grupo</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Preferencias grupos</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a class="nav-link" id="gestion-tab" data-toggle="tab" href="#gestion" role="tab" aria-controls="gestion" aria-selected="false">Gestion usuarios</a>
                            </li>
                        </ul>
                        <div class="tab-content py-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <div id="mainData">
                                    <div class="table-responsive " style="max-height:50vh;">
                                        <table class="table text-light">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Kdds activas</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="createGroup" role="tabpanel" aria-labelledby="createGroup-tab">

                                <div>
                                    <form class="d-block d-md-flex justify-content-around align-items-center text-center row border-bottom mb-4 mb-md-3 mt-4 mt-md-0 pb-3 pb-md-0" id="createGroupMain">
                                        <span class="font-weight-bold col-md-4">Crear Grupo</span>

                                        <div class="col-md-8">
                                            <div class="content d-block d-lg-flex  align-items-center text-center">



                                                <div class="md-form mr-2 mt-5">
                                                    <i class="fas fa-users prefix  d-flex"></i>

                                                    <input name="nombre" type="text" id="nombreGrupo" class="form-control validate text-light" required>
                                                    <label for="nombre" class="d-flex text-light font-weight-bold">Nombre</label>
                                                </div>

                                                <button class="btn  boton" id="createGroupSend">
                                                    <span>Crear</span>
                                                </button>

                                            </div>

                                            <div class="loading">
                                                <div class="spinner-border m-5 p-5" role="status" style="width: 1rem; height: 1rem;color: orange">
                                                    <span class="sr-only">Creando..</span>
                                                </div>
                                            </div>

                                            <div class="error">
                                                <div class="d-flex justify-content-center">
                                                    <div class="m-2 p-5" role="status">
                                                        <i class="fa fa-exclamation-triangle fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: Red"></i>
                                                        <p class="msg">Error</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="success ">
                                                <div class="d-flex justify-content-center">
                                                    <div class="m-2 p-5" role="status">
                                                        <i class="fas fa-check fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: green"></i>
                                                        <p class="msg"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>
                            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                <div class="row justify-content-center">
                                    <label for="grupoSelect1" class="d-flex text-light font-weight-bold ">Seleccione grupo a administrar</label>
                                </div>
                                <div class=" row justify-content-center py-2">

                                    <select name="grupoSelect1" id="grupoSelect1" class="browser-default custom-select rounded disabled col-10 col-md-5 selectGroup">
                                        <option value="-1" selected>Cargando opciones..</option>
                                    </select>
                                    <div class="col-1 h2">
                                        <i class="fas fa-redo fa-spin "></i>
                                    </div>

                                </div>


                                <div class="row justify-content-around content" id="options">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="col-6 col-md-3 ">Opcion</th>
                                                <th class="col-6 col-md-3 ">Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-option="0">
                                                <td class="mr-4">Grupo privado</td>
                                                <td class="d-flex ml-4">
                                                    <label for="privacidad1">Publico</label><input type="radio" name="privacidad" id="privacidad1" value="0">
                                                    <label for="privacidad2">Privado</label><input type="radio" name="privacidad" id="privacidad2" value="1">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn boton" onclick="setValuesSettings()">
                                        <span>Guardar</span>
                                    </button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="gestion" role="tabpanel" aria-labelledby="gestion-tab">
                                <div class="row justify-content-center">
                                    <label for="grupoSelect" class="d-flex text-light font-weight-bold ">Seleccione grupo a administrar</label>
                                </div>

                                <div class=" row justify-content-center py-2">

                                    <select name="grupoSelect" id="grupoSelect" class="browser-default custom-select rounded disabled col-10 col-md-5 selectGroup">
                                        <option value="-1" selected>Cargando opciones..</option>
                                    </select>
                                    <div class="col-1 h2">
                                        <i class="fas fa-redo fa-spin"></i>
                                    </div>

                                </div>


                                <div class="row justify-content-around content" id="acceptUsers">
                                    <table class="col-12 col-md-8 col-lg-6 " style="max-height: 100vh;">
                                        <thead>
                                            <th class="col-6 col-md-3 ">Usuario</th>
                                            <th class="col-6 col-md-3 ">Accion</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="row justify-content-around content" id="gestionUsers">
                                    <table class="col-12 col-md-8 col-lg-6 " style="max-height: 100vh;">
                                        <thead>
                                            <th class="col-4 col-md-2 ">Usuario</th>
                                            <th class="col-6 col-md-3 ">Rango</th>
                                            <th class="col-2 col-md-2 ">Accion</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
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
    <script src="js/main/common.js"></script>

    <script>
        function showContainer(elem) {
            elem.removeClass("d-none");
            elem.addClass("d-block");
            elem.addClass("d-lg-flex");

        }

        function hideContainer(elem) {
            elem.addClass("d-none");
            elem.removeClass("d-block");
            elem.removeClass("d-lg-flex");

        }

        $(".loading").addClass("d-none");
        $(".error").addClass("d-none");
        $(".success").addClass("d-none");

        $("#createGroupSend").click(createGroup);

        mainData();
        getGroupsUserAdmin($(".selectGroup"));

        $("#grupoSelect").siblings().find(".fa-redo").click(allData);
        $("#grupoSelect1").siblings().find(".fa-redo").click(allData);

        $("#grupoSelect").change(function() {
            $("#grupoSelect").siblings().find(".fa-redo").removeClass("fa-spin");
        })
        //$("#grupoSelect").siblings().find(".fa-spin").addClass("d-none");

        $("#grupoSelect1").change(function() {
            $("#grupoSelect1").siblings().find(".fa-redo").removeClass("fa-spin");

        })
        //$("#grupoSelect").siblings().find(".fa-spin").addClass("d-none");

        $(".selectGroup").change(syncSelects);

        function allData() {
            getValuesSettings();
            formAcceptUsers();
            formGroupUsers();
        }

        function syncSelects(ev) {
            console.log(ev.target);
            let elem = $(ev.target);
            $(".selectGroup").not(elem).val(elem.val());
            allData();
        }

        function createGroup(ev) {
            ev.preventDefault();
            hideContainer($("#createGroupMain").find(".content"));
            $("#createGroupMain").find(".loading").removeClass("d-none");

            let a = {
                "option": 1,
                "nombre": $("#nombreGrupo").val(),
            };
            console.log(a);

            $.ajax({
                    url: "./dbActions/dbActionsGroups.php",
                    data: a,
                    method: "POST"
                })
                .done(function(data) {
                    console.log(data);

                    if (data.code == 0) {
                        $("#createGroupMain").find(".success").removeClass("d-none");

                    } else {
                        let elem = $("#createGroupMain").find(".error");
                        elem.find(".msg").text(data.msg);
                        elem.removeClass("d-none");

                    }


                })
                .fail(function() {
                    console.log("fail");

                })
                .always(function() {
                    $("#createGroupMain").find(".loading").addClass("d-none");
                    setTimeout(function() {
                        $("#createGroupMain").find(".success").addClass("d-none");
                        $("#createGroupMain").find(".error").addClass("d-none");
                        showContainer($("#createGroupMain").find(".content"))
                    }, 1500);

                });

        }

        function viewGroup(ev) {
            console.log(ev);
            let elem = $(ev.target);
            while (elem.attr("data-id") == undefined) {
                elem = elem.parent();
            }
            window.location.href = `viewGroup.php?id=${elem.attr("data-id")}`;
        }

        function mainData() {

            let a = {
                "option": 4
            };
            console.log(a);

            $.ajax({
                    url: "./dbActions/dbInfo.php",
                    data: a,
                    method: "GET"
                })
                .done(function(data) {
                    console.log("si");
                    console.log(data);

                    if (data.code == 0) {
                        console.log("si");
                        let table = $("#mainData").find("tbody");
                        table.empty();
                        $.each(data.msg, function(ind, elem) {
                            let tr = $("<tr class='hoverable rounded'></tr>").attr("data-id", elem.id);
                            tr.append($("<td></td>").text(elem.groupName));
                            tr.append($("<td></td>").text(elem.kddcount));
                            tr.click(viewGroup);

                            table.append(tr);


                        })

                        table.find("tr").click(function() {
                            console.log(this);
                            window.location.href = `viewGroup.php?id=${$(this).attr("data-id")}`;
                        })
                    }


                    /*if (data.code == 0) {
                        $("#mainData").find(".success").removeClass("d-none");

                    } else {
                        let elem = $("#createGroupMain").find(".error");
                        elem.find(".msg").text(data.msg);
                        elem.removeClass("d-none");

                    }*/


                })
                .fail(function() {
                    console.log("fail");

                })
            /*.always(function() {
                $("#createGroupMain").find(".loading").addClass("d-none");
                setTimeout(function() {
                    $("#createGroupMain").find(".success").addClass("d-none");
                    $("#createGroupMain").find(".error").addClass("d-none");
                    showContainer($("#createGroupMain").find(".content"))
                }, 1500);

            });*/

        }

        function getGroupsUserAdmin(select) {

            let a = {
                "option": 5
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
                        select.siblings().find(".fa-redo").removeClass("fa-spin");
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

        function formAcceptUsers() {

            let main = $("#acceptUsers").find("tbody");

            $.ajax({
                    url: "dbActions/dbActionsGroups.php",
                    data: {
                        "option": 2,
                        "id_grupo": $("#grupoSelect").val()
                    },
                    method: "POST"
                })
                .done(function(data) {
                    console.log(data);
                    if (data.code == 0) {

                        main.empty();

                        $.each(data.msg, function(i, elem) {
                            let tr = $("<tr class='border-top'></tr>").attr("data-id", elem);
                            tr.append((`<td class='border-right px-2'><div><div class="usuario invitation" data-id=${elem}></div></div></td>`));
                            tr.append($(`<td data-id=${elem} class="d-flex justify-content-around"><button type="button" class="btn btn-outline-success btn-rounded btn-md waves-effect accept" value="1">Aceptar</button><button type="button" class="btn btn-outline-danger btn-rounded btn-md waves-effect denied" value="0">Eliminar</button></td>`))
                            main.append(tr);
                        })
                        main.find(".accept").click(acceptUser);
                        main.find(".denied").click(deleteUser);

                        $("#grupoSelect").siblings().find(".fa-redo").removeClass("fa-spin");

                        generataUsers();

                    }
                });
        }

        function acceptUser(ev) {
            let id = $(ev.target).parent().attr("data-id");

            console.log(ev);
            let tr = $(ev.target).closest("tr");
            tr.empty();
            tr.append("<td colspan='3' class='text-center h2'><i class='fas fa-circle-notch fa-spin'></i></td>");

            $.ajax({
                    url: "dbActions/dbActionsGroups.php",
                    data: {
                        "option": 3,
                        "id": id,
                        "id_grupo": $("#grupoSelect").val()
                    },
                    method: "POST"
                })
                .done(function(data) {
                    console.log(data);
                    if (data.code == 0) {
                        tr.empty();
                        tr.append("<td colspan='3' class='text-center h3 text-success'>usuario aceptado</td>");
                    }

                })
                .fail(function() {
                    tr.empty();
                    tr.append("<td colspan='3' class='text-center h3 text-danger'>Error, recargue la pagina</td>");
                })
                .always(function() {
                    setTimeout(() => {
                        tr.remove();
                        formGroupUsers();
                    }, 2500);
                });

        }

        function deleteUser(ev) {
            let id = $(ev.target).parent().attr("data-id");
            console.log(ev.target);
            let tr = $(ev.target).closest("tr")

            tr.empty();
            tr.append("<td colspan='3' class='text-center h2'><i class='fas fa-circle-notch fa-spin'></i></td>");

            $.ajax({
                    url: "dbActions/dbActionsGroups.php",
                    data: {
                        "option": 4,
                        "id": id,
                        "id_grupo": $("#grupoSelect").val()
                    },
                    method: "POST"
                })
                .done(function(data) {
                    console.log(data);
                    tr.empty();
                    tr.append("<td colspan='3' class='text-center h3 text-warning'>usuario eliminado</td>");
                })
                .fail(function() {
                    tr.empty();
                    tr.append("<td colspan='3' class='text-center h3 text-danger'>Error, recargue la pagina</td>");
                })
                .always(function() {
                    setTimeout(() => {
                        tr.remove();
                        formGroupUsers();
                    }, 2500);
                });



        }

        function rangoUser(ev) {
            let id = $(ev.target).parent().attr("data-id");

            let tr = $(ev.target).closest("tr");

            tr.find("button").addClass("d-none");
            tr.find(".fa-spin").removeClass("d-none");

            $.ajax({
                    url: "dbActions/dbActionsGroups.php",
                    data: {
                        "option": 3,
                        "id": id,
                        "id_grupo": $("#grupoSelect").val(),
                        "rango": $(ev.target).val()
                    },
                    method: "POST"
                })
                .done(function(data) {
                    console.log(data);
                    if (data.code == 0) {
                        tr.find(".fa-check").removeClass("d-none");
                        tr.find(".fa-spin").addClass("d-none");
                    } else {
                        tr.find(".fa-times").removeClass("d-none");
                        tr.find(".fa-spin").addClass("d-none");
                    }

                })
                .fail(function() {
                    tr.find(".fa-times").removeClass("d-none");
                    tr.find(".fa-spin").addClass("d-none");
                })
                .always(function() {
                    setTimeout(() => {
                        tr.find(".fas").addClass("d-none");
                        tr.find("button").removeClass("d-none");
                    }, 1000);
                });

        }

        function formGroupUsers() {

            let main = $("#gestionUsers").find("tbody");

            $.ajax({
                    url: "dbActions/dbInfo.php",
                    data: {
                        "option": 2,
                        "id": $("#grupoSelect").val()

                    },
                    method: "GET"
                })
                .done(function(data) {
                    console.log(data);
                    if (data.code == 0) {

                        main.empty();

                        $.each(data.msg, function(i, elem) {
                            let tr = $("<tr class='border-top'></tr>").attr("data-id", elem);
                            tr.append((`<td class='border-right px-2'><div><div class="usuario" data-id=${elem}></div></div></td>`));
                            tr.append($(`<td data-id=${elem} class="d-flex justify-content-around">
                                <i class="fas fa-check d-none"></i>
                                <i class="fas fa-times d-none"></i>
                                <i class='fas fa-circle-notch fa-spin d-none'></i>
                                <button type="button" class="btn btn-outline-success btn-rounded btn-md waves-effect admin" value="0">Noob</button>
                                <button type="button" class="btn btn-outline-success btn-rounded btn-md waves-effect admin" value="5">Admin</button>
                            </td>`))
                            tr.append($(`<td data-id=${elem}>
                                <button type="button" class="btn btn-outline-danger btn-rounded btn-md waves-effect denied" value="0">Eliminar</button>
                            </td>`))
                            main.append(tr);
                        })
                        main.find(".admin").click(rangoUser);
                        main.find(".denied").click(deleteUser);


                        generataUsers();
                    }
                })
                .fail(function(data) {
                    console.log(data);
                })

        }

        $("#grupoSelect1").change(getValuesSettings);

        function getValuesSettings() {
            $.each($("#options tr[data-option]"), function(ind, elem) {
                let id = $(elem).attr("data-option");

                let a = {
                    "option": 6,
                    "id_grupo": $("#grupoSelect1").val(),
                    "opcion": id
                };
                //console.log(a);

                $.ajax({
                        url: "./dbActions/dbActionsGroups.php",
                        data: a,
                        method: "POST"
                    })
                    .done(function(data) {
                        //console.log("hola");
                        console.log(data);

                        if (data.code == 0) {
                            let msg = 0;
                            if (data.msg==1){
                                msg=1;
                            }
                            $(`#options tr[data-option=${id}] input[value=${msg}]`).prop("checked", true);
                        }
                    })
                    .fail(function() {
                        console.log("fail");

                    })
            })

        }

        function setValuesSettings() {
            $.each($("#options tr[data-option]"), function(ind, elem) {
                let id = $(elem).attr("data-option");
                let val = $(elem).find("td input:checked").val();
                let a = {
                    "option": 5,
                    "id_grupo": $("#grupoSelect1").val(),
                    "opcion": id,
                    "data": val
                };
                console.log(a);

                $.ajax({
                        url: "./dbActions/dbActionsGroups.php",
                        data: a,
                        method: "POST"
                    })
                    .done(function(data) {
                        //console.log("hola");
                        console.log(data);

                        if (data.code == 0) {
                            //let table = $("#mainData").find("tbody");
                            /*table.empty();
                            $.each(data.msg, function(ind, elem) {
                                let tr = $("<tr class='hoverable rounded'></tr>").attr("data-id", elem.id);
                                tr.append($("<td></td>").text(elem.groupName));
                                tr.append($("<td></td>").text(elem.kddcount));
                                tr.click(viewGroup);

                                table.append(tr);


                            })

                            table.find("tr").click(function() {
                                console.log(this);
                                window.location.href = `viewGroup.php?id=${$(this).attr("data-id")}`;
                            })*/
                        }
                    })
                    .fail(function() {
                        console.log("fail");

                    })
            })

        }
    </script>

    <link rel="stylesheet" href="css/style.css">
</body>

</html>