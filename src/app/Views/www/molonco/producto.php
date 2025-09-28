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

<body class="inter-tight-iTighThin">
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
                    <span class="subtitle1">INICIO / ELECTRICIDAD / INSTALACIÓN ELÉCTRICA BÁSICA / CHALUPAS Y PASTILLAS
                        / <span class="color1">CAJA TIPO CHALUPA 4X2 PLÁSTICO VOLTECH</span></span>
                </div>
            </div>

        </div>
        <div class="coll-full">
            <div class="content_listado">
                <div class="col span_7_of_12 content_filtroi">
                    <div class="contentProducto">
                        <div class="title5">
                            Chalupas y Pastillas / SKU 40031688
                        </div>
                        <div class="contentTitleProducto">
                            <div class="title1">Caja tipo Chalupa 4x2 Plástico VOLTECH</div>
                            <div class="contentImgcomp">
                                <a href="#"><img src="<?= base_url("www/{$empresa}/images/compartir.jpg"); ?>"
                                        alt="compartir"></a>
                            </div>
                        </div>
                        <div class="calificacioncontent">
                            <div class="contentestrellas">
                                <? for($i = 1; $i <= 5; $i++): ?>
                                <img src="<?= base_url("www/{$empresa}/images/estrellaproducto.jpg"); ?>"
                                    alt="estrellas">
                                <? endfor; ?>
                                <span class="promedio">5.0</span><span class="cantidadcal">(21)</span>
                                <span class="separate1"></span>
                                <span class="txt1">Calificar este producto</span>
                            </div>

                        </div>
                        <div class="contentimgprodgt">
                            <div class="col span_2_of_12">
                                <div class="tmbimagecontent">
                                    <img src="<?= base_url("www/{$empresa}/images/img1.jpg"); ?>" alt="img1">
                                </div>
                            </div>
                            <div class="col span_10_of_12">
                                <div class="gdeimagecontent">
                                    <img src="<?= base_url("www/{$empresa}/images/img1.jpg"); ?>" alt="img1">
                                    <div class="contentlupa">
                                        <img src="<?= base_url("www/{$empresa}/images/lupaproducto.jpg"); ?>"
                                            alt="lupaproducto">
                                    </div>
                                </div>
                                <div class="txt2">Fotografía ilustrativa. La imagen del producto puede variar en tienda
                                </div>
                            </div>
                        </div>
                        <div class="descproductcontent">
                            <div class="title3">Acerca del Producto</div>
                            <p class="descproducto">La caja chalupa Volteck 4×2″ es una solución práctica, liviana y
                                robusta para instalaciones eléctricas. Su diseño en polipropileno la hace anticorrosiva
                                y segura en ambientes con humedad, con compatibilidad para conexiones de ½″ y ¾″, y
                                respaldo de garantía TRUPER.</p>
                        </div>
                    </div>
                </div>
                <div class="col span_5_of_12 content_filtrod">
                    <div class="contentProducto">
                        <div class="contentprecio">
                            <div class="col span_1_of_2">
                                <div class="txtprecio">Precio</div>
                                <div class="txtiva">IVA Incluido</div>
                            </div>
                            <div class="col span_1_of_2 preciob">
                                <span class="txtsignop">$</span>
                                <span class="cantprecio">11.92</span>
                            </div>
                        </div>
                        <div class="contentcantadd">
                            <div class="col span_1_of_2">
                                <span class="btnmen"></span>
                                <input type="text" value="1" class="cantidadprod">
                                <span class="btnmas"></span>
                            </div>
                            <div class="col span_1_of_2">
                                <a href="<?= site_url("/navegation/carrito"); ?>" class="btn1">Agregar al Carrito</a>
                            </div>
                        </div>
                        <div class="separate2"></div>
                        <div class="contentcaract">
                            <div class="col span_4_of_7">
                                <div class="caraccontent">
                                    <img src="<?= base_url("www/{$empresa}/images/carritoproducto.jpg"); ?>"
                                        alt="carritoproducto" class="carritoproducto">
                                    <div class="carritoproductotext">
                                        <span class="titledescripcar">Envío Gratis*</span>
                                        <br>
                                        <span class="descrpcar">Compra mínima $ 500.00 MXN.</span>
                                    </div>
                                </div>
                                <div class="caraccontent">
                                    <img src="<?= base_url("www/{$empresa}/images/tarjetaproducto.jpg"); ?>"
                                        alt="tarjetaproducto" class="carritoproducto">
                                    <div class="carritoproductotext">
                                        <span class="titledescripcar">Pagos Seguros</span>
                                        <br>
                                        <span class="descrpcar">Con tarjeta de crédito, débito, Paypal o
                                            efectivo.</span>
                                    </div>
                                </div>
                                <div class="caraccontent">
                                    <img src="<?= base_url("www/{$empresa}/images/puntoproducto.jpg"); ?>"
                                        alt="puntoproducto" class="carritoproducto">
                                    <div class="carritoproductotext">
                                        <span class="titledescripcar">Amplia Cobertura</span>
                                        <br>
                                        <span class="descrpcar">Entregamos en tienda y a domicilio.</span>
                                    </div>
                                </div>
                                <div class="caraccontent">
                                    <img src="<?= base_url("www/{$empresa}/images/garantiaproducto.jpg"); ?>"
                                        alt="garantiaproducto" class="carritoproducto">
                                    <div class="carritoproductotext">
                                        <span class="titledescripcar">Garantía Molonko</span>
                                        <br>
                                        <span class="descrpcar">Seguridad en todas tus compras.</span>
                                    </div>
                                </div>

                            </div>
                            <div class="col span_3_of_7 productocontentder">
                                <div class="contentDisponibildadproduc">
                                    <div class="title6">Disponibilad</div>
                                    <div class="caraccontent">
                                        <img src="<?= base_url("www/{$empresa}/images/listoproducto.jpg"); ?>"
                                            alt="listoproducto" class="carritoproducto">
                                        <div class="carritoproductotext">
                                            <p class="titledescripcar">80 artículos disponibles para compra en línea.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="separate2"></div>
                                    <div class="caraccontent">
                                        <img src="<?= base_url("www/{$empresa}/images/listoproducto.jpg"); ?>"
                                            alt="listoproducto" class="carritoproducto">
                                        <div class="carritoproductotext">
                                            <p class="titledescripcar">80 artículos disponibles físicamente en Tienda
                                                sucursal Mazatlán, Sinaloa.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }
    </script>
</body>

</html>