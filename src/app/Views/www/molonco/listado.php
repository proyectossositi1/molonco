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

<body class="inter-tight-iTighThin" id="carrito">
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
        <img src="<?= base_url("www/{$empresa}/images/bannercategorias.jpg"); ?>" alt="bannerlist" class="bannerlist">
        <div class="coll-full">
            <div class="col span_3_of_12 content_listado">
                <div class="title2">
                    Subcategorías
                </div>
            </div>
            <div class="col span_8_of_12 content_filtrod">
                <div class="title2 left">
                    Instalación eléctrica básica
                    <span class="subtitle1">(90 productos)</span>
                </div>
                <div class="right">
                    <label for="filtroSelect">Ordenar Por: </label>
                    <select class="select-css">
                        <option>Relevancia</option>
                        <option>A-Z</option>
                        <option>Mayor a Menor Precio</option>
                        <option>Menor a Mayor Precio</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="coll-full">
            <div class="content_listado">
                <div class="col span_3_of_12 content_filtroi">
                    <div class="contentFiltroList">
                        <div class="title3">Instalación eléctrica básica</div>
                        <div class="contentSelects">
                            <div><input type="checkbox" id="check1"><label for="check1">Cables eléctricos </label></div>
                            <div><input type="checkbox" id="check2"><label for="check2">Conectores </label></div>
                            <div><input type="checkbox" id="check3"><label for="check3">Canaletas y tubos </label></div>
                            <div><input type="checkbox" id="check4"><label for="check4">Abrazaderas y grapas </label>
                            </div>
                            <div><input type="checkbox" id="check5"><label for="check5">Cajas de registro </label></div>
                            <div><input type="checkbox" id="check6"><label for="check6">Chalupas y pastillas </label>
                            </div>
                            <div><input type="checkbox" id="check7"><label for="check7">Portafusibles y fusibles
                                </label></div>
                        </div>
                    </div>
                    <div class="contentFiltroList min">
                        <div class="title3">Apagadores y Contactos</div>
                        <div class="contentSelects">
                            <div><input type="checkbox" id="check8"><label for="check8">Cables eléctricos </label></div>
                            <div><input type="checkbox" id="check9"><label for="check9">Conectores </label></div>
                            <div><input type="checkbox" id="check10"><label for="check10">Canaletas y tubos </label>
                            </div>
                            <div><input type="checkbox" id="check11"><label for="check11">Abrazaderas y grapas </label>
                            </div>
                            <div><input type="checkbox" id="check12"><label for="check12">Cajas de registro </label>
                            </div>
                            <div><input type="checkbox" id="check13"><label for="check13">Chalupas y pastillas </label>
                            </div>
                            <div><input type="checkbox" id="check14"><label for="check14">Portafusibles y fusibles
                                </label></div>
                        </div>
                    </div>
                    <div class="contentFiltroList min">
                        <div class="title3">Distribución y Protección</div>
                        <div class="contentSelects">
                            <div><input type="checkbox" id="check15"><label for="check15">Cables eléctricos </label>
                            </div>
                            <div><input type="checkbox" id="check16"><label for="check16">Conectores </label></div>
                            <div><input type="checkbox" id="check17"><label for="check17">Canaletas y tubos </label>
                            </div>
                            <div><input type="checkbox" id="check18"><label for="check18">Abrazaderas y grapas </label>
                            </div>
                            <div><input type="checkbox" id="check19"><label for="check19">Cajas de registro </label>
                            </div>
                            <div><input type="checkbox" id="check20"><label for="check20">Chalupas y pastillas </label>
                            </div>
                            <div><input type="checkbox" id="check21"><label for="check21">Portafusibles y fusibles
                                </label></div>
                        </div>
                    </div>
                    <div class="contentFiltroList min">
                        <div class="title3">Herramientas y Accesorios</div>
                        <div class="contentSelects">
                            <div><input type="checkbox" id="check1"><label for="check1">Cables eléctricos </label></div>
                            <div><input type="checkbox" id="check2"><label for="check2">Conectores </label></div>
                            <div><input type="checkbox" id="check3"><label for="check3">Canaletas y tubos </label></div>
                            <div><input type="checkbox" id="check4"><label for="check4">Abrazaderas y grapas </label>
                            </div>
                            <div><input type="checkbox" id="check5"><label for="check5">Cajas de registro </label></div>
                            <div><input type="checkbox" id="check6"><label for="check6">Chalupas y pastillas </label>
                            </div>
                            <div><input type="checkbox" id="check7"><label for="check7">Portafusibles y fusibles
                                </label></div>
                        </div>
                    </div>
                    <div class="contentFiltroList preciocontent">
                        <div class="title3">Precio</div>
                        <div class="slidecontainer">
                            <span class="left txtrange">Min.</span>
                            <span class="right txtrange">Max.</span>
                            <input type="range" min="0" max="1000" value="0" class="slider" id="myRange">
                            <br><br>
                            <p class="left txtrange">$ <span id="demo"></span></p>
                            <span class="right txtrange">1000</span>
                            <br><br>

                        </div>
                    </div>
                </div>

                <div class="col span_8_of_12 content_filtrod">
                    <div class="rowsproducts">
                        <? for($i = 1; $i <= 7; $i++): ?>
                        <div class="col span_1_of_4">
                            <div class="contentimgProduct">
                                <a href="<?= site_url("/navegation/producto"); ?>"> <img
                                        src="<?= base_url("www/{$empresa}/images/img{$i}.jpg"); ?>" alt="img{$i}"></a>
                                <div class="title2 nproduct">Caja tipo chalupa 4X2 Plástico Voltech</div>
                                <div class="desc1 sku">SKU 40031688</div>
                                <div class="title3 precio">$11.92</div>
                                <div class="contentcantadd">
                                    <div class="col span_1_of_4">
                                        <input type="number" class="cantproduct" name="cant" value="1">
                                    </div>
                                    <div class="col span_3_of_4 contaddprod">
                                        <a href="<?= site_url("/navegation/carrito"); ?>" class="btn1">Agregar al
                                            carrito</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <? endfor; ?>
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