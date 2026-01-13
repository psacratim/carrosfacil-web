<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarrosFácil - Produto</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css" />


    <!-- CSS --> <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../../custom/css/style.css">
</head>

<body>
    <?php
    include_once('./Components/Header.php');
    ?>

    <main id="product-viewer" class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <section id="galery" class="col-12 col-lg-8 p-0 pe-lg-4 align-self-start">
                    <div id="main-container">
                        <img id="main-image" class="img-fluid" src="../images/x1.webp" alt="">
                    </div>
                    <div id="pictures" class="d-flex align-items-center">
                        <ul class="list-unstyled m-0 p-0">
                            <li>
                                <button class="picture active">
                                    <img class="w-100 h-100" src="../images/x1.webp" alt="">
                                </button>
                            </li>
                            <li>
                                <button class="picture">
                                    <img class="w-100 h-100" src="../images/x1.webp" alt="">
                                </button>
                            </li>
                            <li>
                                <button class="picture">
                                    <img class="w-100 h-100" src="../images/x1.webp" alt="">
                                </button>
                            </li>
                        </ul>
                    </div>
                </section>
                <section id="product-info" class="col-12 col-lg-4 align-self-start mt-4 mt-lg-0 ms-lg-auto white-bg">
                    <div id="model-info">
                        <span id="brand">PORSCHE</span>
                        <h1 id="model-name">911 Carreira S 3.0</h1>
                    </div>
                    <div id="price">
                        <div id="real-price">
                            R$1.250.000
                        </div>
                        <div id="current-price">
                            R$1.149.900
                        </div>
                        <div id="extra-payments-info">
                            Financiamento em até 60x
                        </div>
                    </div>
                    <div class="contact">
                        <a href="#" target="_blank" id="talk-consultant" class="w-100 d-flex justify-content-center align-items-center mb-2">
                            <i class="bi bi-whatsapp"></i>
                            Falar com Consultor
                        </a>
                        <a href="#" target="_blank" id="test-drive" class="w-100 d-flex justify-content-center align-items-center">
                            <i class="icon-life-buoy"></i>
                            Agendar Test-Drive
                        </a>
                    </div>
                </section>
                <section id="basic-infos" class="mt-4 col-12 col-lg-8 p-0 m-0 pe-lg-4 d-flex justify-content-between flex-wrap">
                    <div class="basic-info-card">
                        <div class="content d-flex flex-wrap text-center p-2 white-bg">
                            <i class="bi bi-calendar3 w-100"></i>
                            <span class="w-100 info-name">Ano</span>
                            <span class="w-100 value">2023/24</span>
                        </div>
                    </div>
                    <div class="basic-info-card">
                        <div class="content d-flex flex-wrap text-center p-2 white-bg">
                            <i class="w-100 bi bi-speedometer"></i>
                            <span class="w-100 info-name">KM</span>
                            <span class="w-100 value">999.999 km</span>
                        </div>
                    </div>
                    <div class="basic-info-card col-6 col-md-3 mt-4 mt-md-0 pe-0">
                        <div class="content d-flex flex-wrap text-center p-2 white-bg">
                            <i class="w-100 bi bi-sliders"></i>
                            <span class="w-100 info-name">CÂMBIO</span>
                            <span class="w-100 value">PDK AUTO</span>
                        </div>
                    </div>
                    <div class="basic-info-card col-6 col-md-3 mt-4 mt-md-0 pe-0">
                        <div class="content d-flex flex-wrap text-center p-2 white-bg">
                            <i class="w-100 bi bi-fuel-pump"></i>
                            <span class="w-100 info-name">COMBUSTÍVEL</span>
                            <span class="w-100 value">Gasolina</span>
                        </div>
                    </div>
                </section>
                <section id="description" class="mt-4 col-lg-8 col-12 ps-0 pe-lg-4 pe-0">
                    <div class="content p-3 white-bg">
                        <h2 class="info-card-title d-flex align-items-center gap-2">
                            <span class="w-1 h-6 bg-blue-900 rounded-full"></span>
                            Descrição
                        </h2>
                        A lenda em estado impecável. Este exemplar na cor Chalk Grey conta com o exclusivo interior bi-color Marrom e Bege. Equipado com o pacote Sport Chrono, escapamento esportivo original e rodas RS Spyder Design. Um único dono, sem histórico de pista ou colisões. Proteção de pintura (PPF) integral aplicada.
                    </div>
                </section>
                <section id="vehicle-items-container" class="mt-4 col-lg-8 col-12 ps-0 pe-lg-4 pe-0">
                    <div class="content white-bg p-3">
                        <h2 class="info-card-title d-flex align-items-center gap-2">
                            <span class="w-1 h-6 bg-blue-900 rounded-full"></span>
                            Itens do veículo
                        </h2>
                        <ul class="list-unstyled row row-cols-1 row-cols-md-2 g-4 row-cols-xl-3" id="vehicle-items-list">
                            <li class="col">
                                <div class="content">
                                    <img src="../images/x1.webp" class="item-icon" alt="">
                                    Pacote de Sport Chronoasdasdasd
                                </div>
                            </li>
                            <li class="col">
                                <div class="content">
                                    <img src="../images/x1.webp" class="item-icon" alt="">
                                    Pacote de Sport Chronoasdasdasd
                                </div>
                            </li>
                            <li class="col">
                                <div class="content">
                                    <img src="../images/x1.webp" class="item-icon" alt="">
                                    Pacote de Sport Chronoasdasdasd
                                </div>
                            </li>
                            <li class="col">
                                <div class="content">
                                    <img src="../images/x1.webp" class="item-icon" alt="">
                                    Pacote de Sport Chronoasdasdasd
                                </div>
                            </li>
                            <li class="col">
                                <div class="content">
                                    <img src="../images/x1.webp" class="item-icon" alt="">
                                    Pacote de Sport Chronoasdasdasd
                                </div>
                            </li>
                            <li class="col">
                                <div class="content">
                                    <img src="../images/x1.webp" class="item-icon" alt="">
                                    Pacote de Sport Chronoasdasdasd
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </main>


    <?php
    include_once('./Components/Footer.php');
    ?>

    <!-- BOOTSTRAP JS + JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
</body>

</html>