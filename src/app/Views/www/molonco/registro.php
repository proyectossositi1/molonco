<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/html5reset.css"); ?>" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/col.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/style.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/2cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/3cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/4cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/5cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/6cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/7cols.csss"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/ccss/8cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/9cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/10cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/11cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/12cols.css"); ?>" media="all">
    <link rel="stylesheet" href="<?= base_url("www/{$empresa}/css/responsive.css"); ?>" media="all">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="<?= base_url("www/{$empresa}/js/main.js"); ?>"></script>
    <title>Inicio</title>
</head>

<body class="inter-tight-iTighThin" id="registro">
    <header>
        <div class="liston">
            <center><span class="inter-tight-iTighThin">Compras mayores a $600 incluyen servicio a domicilio
                    gratis*.</span><span class="separate1"></span><span class="inter-tight-iTighBold">Envíos a toda la
                    República Mexicana.</span><span class="carrito"></span></center>
        </div>
        <div id="contentmenu">
            <div class="logo"></div>
            <ul id="menu" class="inter-tight-iTighBold">
                <li><a href="#" class="selected">Inicio</a></li>
                <li class="arrowd"><a href="<?= site_url('/navegation/listado'); ?>">Tienda</a></li>
                <li><a href="#">Marcas</a></li>
                <li><a href="#">Nosotros</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
            <div id="buscador">
                <div class="icon-buscador"></div>
                <input type="text" class="input_buscador">
            </div>
            <div id="content_car_user">
                <a href="<?= site_url("/navegation/carrito"); ?>"><img
                        src="<?= base_url("www/{$empresa}/images/carritorojo.png"); ?>" alt="carhead"
                        class="carhead"></a>
                <a href="<?= site_url("/navegation/login"); ?>"><img
                        src="<?= base_url("www/{$empresa}/images/loginrojo.png"); ?>" alt="loghead" class="loghead"></a>
                <!-- <div class="car"></div>
                <div class="user"></div> -->
            </div>
        </div>
        <div id="contentbtnmenu">
            <div id="btnmenumobil1">
                <img src="<?= base_url("www/{$empresa}/images/menu1.svg"); ?>" alt="menu1">
            </div>
            <div id="btnmenumobil2">
                <img src="<?= base_url("www/{$empresa}/images/menu1.svg"); ?>" alt="menu1">
            </div>
        </div>

        <div id="menumobil1">

        </div>

        <div id="contentmenucategorias">
            <ul id="menucategorias" class="inter-tight-iTighRegular">
                <li><a href="#" class="selected">Electricidad</a></li>
                <li><a href="#">Plomería</a></li>
                <li><a href="#">Construcción</a></li>
                <li><a href="#">Ferretería</a></li>
                <li><a href="#">Carpintería</a></li>
                <li><a href="#">Acabados</a></li>
                <li><a href="#">Seguridad</a></li>
                <li><a href="#">Equipos</a></li>
            </ul>
        </div>
    </header>
    <div id="contentmain">
        <div class="coll-full">
            <div class="col span_12_of_12 content_listado">
                <div class="title2 left">
                    <span class="subtitle1">INICIO / <span class="color1">REGISTRO</span></span>
                </div>
            </div>
        </div>
        <div class="coll-full">
            <div class="content_listado">
                <div class="content_filtroi">
                    <div class="contentFormR">
                        <div class="titleFormlr">
                            <center>REGISTRO</center>
                            <img src="<?= base_url("www/{$empresa}/images/cerrar.png"); ?>" alt="cerrar" class="cerrar">
                        </div>
                        <div class="login-container">
                            <img src="<?= base_url("www/{$empresa}/images/logocolor.png"); ?>" alt="logocolores">
                            <form id="registroForm">
                                <div class="form-group">
                                    <label for="nombre">Nombre completo</label>
                                    <input type="text" id="nombre" placeholder="Ingresa tu nombre">
                                    <span class="error" id="error-nombre"></span>
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" id="email" placeholder="ejemplo@email.com">
                                    <span class="error" id="error-email"></span>
                                </div>
                                <div class="form-group">
                                    <label for="usuario">Usuario</label>
                                    <input type="text" id="usuario" placeholder="Crea un usuario">
                                    <span class="error" id="error-usuario"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" id="password" placeholder="Crea una contraseña">
                                    <span class="error" id="error-password"></span>
                                </div>
                                <div class="form-group">
                                    <label for="confirmar">Confirmar contraseña</label>
                                    <input type="password" id="confirmar" placeholder="Repite la contraseña">
                                    <span class="error" id="error-confirmar"></span>
                                </div>
                                <button type="submit" class="btn">Registrarse</button>
                            </form>
                            <p>¿Ya tienes cuenta? <a href="#">Inicia sesión aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="coll-full2">
            <div class="col span_1_of_5">
                <div class="contenttitleFooter">
                    <div class="titleFooter">categorías</div>
                </div>
                <div class="subcontentspan2">
                    <ul class="col span_1_of_2">
                        <li>
                            <a href="#">Electricidad</a>
                        </li>
                        <li>
                            <a href="#">Construcción</a>
                        </li>
                        <li>
                            <a href="#">Plomería</a>
                        </li>
                        <li>
                            <a href="#">Ferretería</a>
                        </li>
                        <li>
                            <a href="#">Carpintería</a>
                        </li>
                    </ul>
                    <ul class="col span_1_of_2">
                        <li>
                            <a href="#">Acabados</a>
                        </li>
                        <li>
                            <a href="#">Seguridad</a>
                        </li>
                        <li>
                            <a href="#">Equipo</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col span_1_of_5">
                <div class="contenttitleFooter">
                    <div class="titleFooter">Soporte</div>
                </div>
                <div class="subcontentspan2">
                    <ul>
                        <li>
                            <a href="#">Terminos y condicones de uso</a>
                        </li>
                        <li>
                            <a href="#">Preguntas frecuentes</a>
                        </li>
                        <li>
                            <a href="#">Politicas y devoluciones</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col span_1_of_5">
                <div class="contenttitleFooter">
                    <div class="titleFooter">Servicio al Cliente</div>
                </div>
                <div class="subcontentspan2">
                    <ul>
                        <li>
                            <a href="tel:+34678567876">(669) 326 9793</a>
                        </li>
                        <li>
                            <a href="#">compraenlinea@construrama.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col span_1_of_5">
                <div class="contenttitleFooter">
                    <div class="titleFooter">Moneda</div>
                </div>
                <div class="subcontentspan2">
                    <ul>
                        <li>
                            <span>($) MXN</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col span_1_of_5">
                <div>
                    <img src="<?= base_url("www/{$empresa}/images/logofooter.png"); ?>" alt="logofooter">
                </div>
            </div>
        </div>
        <div class="coll-full">
            <div class="copyrightrs">
                <div class="col span_11_of_12 cr">
                    <center> © 2025 Molonko. Todos los derechos reservados.</center>
                </div>
                <div class="col span_1_of_12 rscontent">
                    <a href="#"><img src="<?= base_url("www/{$empresa}/images/facebookfooter.png"); ?>"
                            alt="facebookimg"></a>
                    <a href="#"><img src="<?= base_url("www/{$empresa}/images/instagram.png"); ?>"
                            alt="instagramimg"></a>
                </div>
            </div>
        </div>
    </footer>
    <script>
    document.getElementById("registroForm").addEventListener("submit", function(e) {
        e.preventDefault();
        let valido = true;

        // limpiar errores
        document.querySelectorAll(".error").forEach(el => el.textContent = "");

        const nombre = document.getElementById("nombre").value.trim();
        const email = document.getElementById("email").value.trim();
        const usuario = document.getElementById("usuario").value.trim();
        const password = document.getElementById("password").value.trim();
        const confirmar = document.getElementById("confirmar").value.trim();

        // Validar nombre
        if (nombre === "") {
            document.getElementById("error-nombre").textContent = "El nombre es obligatorio.";
            valido = false;
        }

        // Validar email
        const regexEmail = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
        if (email === "" || !regexEmail.test(email)) {
            document.getElementById("error-email").textContent = "Ingresa un correo válido.";
            valido = false;
        }

        // Validar usuario
        if (usuario.length < 4) {
            document.getElementById("error-usuario").textContent =
                "El usuario debe tener al menos 4 caracteres.";
            valido = false;
        }

        // Validar contraseña
        if (password.length < 6) {
            document.getElementById("error-password").textContent =
                "La contraseña debe tener mínimo 6 caracteres.";
            valido = false;
        }

        // Confirmar contraseña
        if (password !== confirmar) {
            document.getElementById("error-confirmar").textContent = "Las contraseñas no coinciden.";
            valido = false;
        }

        if (valido) {
            alert("✅ Registro exitoso");
            document.getElementById("registroForm").reset();
        }
    });
    </script>
</body>

</html>