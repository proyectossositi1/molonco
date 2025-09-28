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
        <div class="coll-full">
            <div class="col span_12_of_12 content_listado">
                <div class="title2 left">
                    <span class="subtitle1">INICIO / <span class="color1">MI CARRITO</span></span>
                </div>
            </div>
        </div>
        <div class="coll-full">
            <div class="title7">Carrito de Compras</div>
        </div>
        <div class="coll-full">

            <div class="content_listado">

                <div class="col span_8_of_12 content_filtroi">
                    <div class="contentProducto">
                        <div class="contenttitle1">
                            <span class="left">Detalle del pedido</span>
                            <span class="right">Monto</span>
                        </div>
                        <table>
                            <tr class="cart-item" data-price="11.92">
                                <td><img src="<?= base_url("www/{$empresa}/images/img1.jpg"); ?>" class="product-img">
                                </td>
                                <td class="product-info">
                                    <div>Caja tipo chalupa 4X2 Plástico Voltech</div>
                                    <div class="sku">SKU 40031688</div>
                                    <div class="unit-price">Precio unitario: $11.92</div>
                                </td>
                                <td class="quantity">
                                    <button class="minus">-</button>
                                    <input type="text" value="1" disabled max="10">
                                    <button class="plus">+</button>
                                </td>
                                <td class="price">$11.92</td>
                                <td class="delete"><img src="<?= base_url("www/{$empresa}/images/eliminar.jpg"); ?>"
                                        alt="eliminar"></td>
                            </tr>

                            <tr class="cart-item" data-price="28.98">
                                <td><img src="<?= base_url("www/{$empresa}/images/img2.jpg"); ?>" class="product-img">
                                </td>
                                <td class="product-info">
                                    <div>Caja de acero cuadrada 4X4 Econ Voltech</div>
                                    <div class="sku">SKU 40031691</div>
                                    <div class="unit-price">Precio unitario: $14.49</div>
                                </td>
                                <td class="quantity">
                                    <button class="minus">-</button>
                                    <input type="text" value="2" disabled max="10">
                                    <button class="plus">+</button>
                                </td>
                                <td class="price">$28.98</td>
                                <td class="delete"><img src="<?= base_url("www/{$empresa}/images/eliminar.jpg"); ?>"
                                        alt="eliminar"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col span_4_of_12 content_filtrod">
                    <div class="contentProducto">
                        <div class="contenttitle1">
                            <center> Mi carrito</center>
                        </div>
                        <div class="contentbotons">
                            <div class="col span_1_of_2">
                                <div class="subcontentbtnenvio">
                                    <img src="<?= base_url("www/{$empresa}/images/recogertienda.jpg"); ?>"
                                        alt="recoger">
                                    <div class="txt3">Recoger en tienda</div>
                                </div>

                            </div>
                            <div class="col span_1_of_2">
                                <div class="subcontentbtnenvio active">
                                    <img src="<?= base_url("www/{$empresa}/images/enviodomicilio.jpg"); ?>" alt="envio">
                                    <div class="txt3">Envío a domicilio</div>
                                </div>
                            </div>
                        </div>
                        <div class="txt4">ID: 105489963214 (3 artículos)</div>
                        <div class="contsubto">
                            <div class="left subtotaltxt">Subtotal: </div>
                            <div class="right subtotaltxtprice">$ 40.90</div>
                        </div>
                        <div class="contsubto2">
                            <div class="left">Costo del envío: </div>
                            <div class="right">$ 65.90</div>
                        </div>
                        <div class="separate2"></div>
                        <div class="contentTotal">
                            <div class="total">Total: $ 105.00</div>
                            <div class="iva2">IVA Incluido</div>
                        </div>

                        <button class="btn2">Continúa con tu órden</button>
                        <div class="">

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
    let botonen = document.querySelector('.subcontentbtnenvio');
    botonen.addEventListener("click", () => {
        alert("a")
        botonen.className += ' active';
    });
    document.querySelectorAll("tr").forEach(row => {
        const unitPrice = parseFloat(row.getAttribute("data-price"));
        const minusBtn = row.querySelector(".minus");
        const plusBtn = row.querySelector(".plus");
        const qtyInput = row.querySelector("input");
        const priceCell = row.querySelector(".price");
        const deleteBtn = row.querySelector(".delete");

        function updatePrice() {
            const qty = parseInt(qtyInput.value);
            const total = (qty * unitPrice).toFixed(2);
            priceCell.textContent = `$${total}`;
        }

        plusBtn.addEventListener("click", () => {
            qtyInput.value = parseInt(qtyInput.value) + 1;
            updatePrice();
        });

        minusBtn.addEventListener("click", () => {
            if (parseInt(qtyInput.value) > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
                updatePrice();
            }
        });

        deleteBtn.addEventListener("click", () => {
            row.remove();
        });
    });
    </script>
</body>

</html>