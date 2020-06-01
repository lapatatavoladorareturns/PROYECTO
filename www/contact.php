<?php
session_start();
?>
<html>

<head>
    <base target="_parent">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/logo/logo1.png">
	<title>Contacto</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        @media (max-height: 680px) {
            footer {
                position: relative;
            }
        }
    </style>

</head>

<body aria-busy="true">
    <div class="">
        <?php if (isset($_SESSION['loggedin'])) {

        ?>
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
                        <li class="nav-item ">
                            <a class="nav-link " href="allGroups.php">
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
        <?php
        } else {
        ?>


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
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                Iniciar sesion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">
                                Registrarse
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
            <!--Navbar -->

        <?php } ?>
        <div class="container py-5">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto text-center">




                    <div class="card-wrapper" style="">
                        <div id="my-card" class="card card-rotating rounded text-light font-weight-bold">


                            <div class="face frontrounded rounded" style="background-color: #3B707D">



                                <div class="form-header rounded-top pl-3" style="background-image:  linear-gradient(135deg, #FF5412 0%,#030A04 100%);">
                                    <h3 class="font-weight-500 p-2"><i class="fas fa-sign-in-alt"></i> Crear cuenta</h3>
                                </div>


                                <form id="login" autocomplete="on" class="card-body m-1" style="background-color: #3B707D">

                                    <div class="md-form">
                                        <i class="fas fa-envelope prefix  d-flex"></i>
                                        <input type="email" id="email" name="email" class="form-control validate text-light" required>
                                        <label for="email" class="d-flex text-light font-weight-bold">Your email</label>
                                    </div>


                                    <div class="md-form">
                                        <i class="fas fa-pencil-alt prefix  d-flex"></i>
                                        <textarea id="texto" name="texto" class="md-textarea form-control text-light" rows="3"></textarea>
                                        <label for="texto" class="d-flex text-light font-weight-bold">Texto</label>
                                    </div>




                                    <div class="text-center">
                                        <button class="btn btn-lg  boton">
                                            <span>Enviar</span>
                                        </button>
                                    </div>

                                </form>
                                <div class="loading ">
                                    <div class="spinner-border m-5 p-5" role="status" style="width: 1rem; height: 1rem;color: orange">
                                        <span class="sr-only">Registrando...</span>
                                    </div>
                                </div>
                                <div class="error ">
                                    <div class="d-flex justify-content-center">
                                        <div class="m-2 p-5" role="status">
                                            <i class="fa fa-exclamation-triangle fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: Red"></i>
                                            <p class="msg">Error en el registro</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="success ">
                                    <div class="d-flex justify-content-center">
                                        <div class="m-2 p-5" role="status">
                                            <i class="fas fa-check fa-6 mb-3" aria-hidden="true" style="font-size: 11rem;color: green"></i>
                                            <p class="msg">Error en el registro</p>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>
        <?php include "common/footer.php" ?>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script type="text/javascript">
        $("#password").on("focusout", function() {
            if ($(this).val() != $("#password2").val()) {
                $("#password2").removeClass("valid").addClass("invalid");
            } else {
                $("#password2").removeClass("invalid").addClass("valid");
            }
        });

        $("#password2").on("keyup", function() {

            if ($("#password").val() != $(this).val()) {
                $(this).removeClass("valid").addClass("invalid");
                this.setCustomValidity("Contraseña tiene que coincidir")
            } else {
                $(this).removeClass("invalid").addClass("valid");
                this.setCustomValidity("")

            }
        });

        function hide() {
            $(".loading").each(function(e, el) {
                el.style.display = "none"
            })
            $(".error").each(function(e, el) {
                el.style.display = "none"
            })
            $(".success").each(function(e, el) {
                el.style.display = "none"
            })
        }
        hide();

        $("form").submit(function(ev) {
            ev.preventDefault();

            document.getElementById("login").style.display = "none";
            $(".loading").each(function(e, el) {
                el.style.display = ""
            })

            //console.log(ev.target.getAttribute("action"));
            let a = {};
            $(this).find(".form-control").each(function(index, element) {
                a[element.getAttribute('name')] = $(element).val();
            })
            //console.log(a);
            $.ajax({
                    url: "dbActions/contact.php",
                    data: a,
                    method: "POST"
                })
                .done(function(data) {
                    console.log(data);

                    switch (data.code) {
                        case 0:
                            $(".success").each(function(e, el) {
                                el.style.display = ""
                            })
                            $(".success .msg").text("Enviado correctamente");
                            setTimeout(function() {
                                window.location.href = "home.php"
                            }, 1500);
                            break;
                        case 1:
                        case 2:
                        case 20:
                        case 21:
                        case 22:
                        case 3:
                        case 9:
                        default:
                            $(".error .msg").text(data.msg);
                            $(".error").each(function(e, el) {
                                el.style.display = ""
                            })
                    }

                })
                .fail(function() {
                    console.log("fail");
                    $(".error").each(function(e, el) {
                        el.style.display = ""
                    });
                })
                .always(function() {
                    $(".loading").each(function(e, el) {
                        el.style.display = "none"
                    })
                    setTimeout(function() {
                        hide();
                        document.getElementById("login").style = ""
                    }, 1000);
                });

        })
    </script>
</body>

</html>