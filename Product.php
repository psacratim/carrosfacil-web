<?php

try {
    $vehicleId = $_GET['id'] ?? false;
    if (!$vehicleId) {
        throw new Exception("No vehicle in url.");
    }

    require_once('./conexao/conecta.php');
    require_once('./Components/Header.php');

    $vehicleResult = mysqli_execute_query($connection, "SELECT veiculo.id, modelo.id, modelo.nome 'modelName', modelo.id_marca, marca.id 'brandId', marca.nome 'brandName', veiculo.preco_venda, veiculo.preco_desconto, veiculo.desconto, veiculo.descricao, veiculo.ano, veiculo.quilometragem, veiculo.tipo_cambio, veiculo.tipo_combustivel, veiculo.foto FROM veiculo INNER JOIN modelo on modelo.id = veiculo.id_modelo INNER JOIN marca on marca.id = modelo.id_marca WHERE veiculo.id = " . $vehicleId . ";");
    if (!$vehicleResult || $vehicleResult->num_rows === 0) {
        throw new Exception("Failed to get vehicle data.");
    }

    $vehiclePhotos = mysqli_execute_query($connection, "SELECT caminho, ordem FROM foto_veiculo WHERE id_veiculo = " . $vehicleId . ";");
    $usePlaceholderPhoto = false;
    if (!$vehiclePhotos || $vehiclePhotos->num_rows === 0) {
        $usePlaceholderPhoto = true;
    }

    $vehicleItems = mysqli_execute_query($connection, "SELECT caracteristica.id, caracteristica.nome, caracteristica.icone FROM caracteristica_carro INNER JOIN caracteristica ON caracteristica.id = caracteristica_carro.id_caracteristica WHERE caracteristica_carro.id_veiculo = " . $vehicleId . ";");
    if (!$vehicleItems) {
        throw new Exception("Failed to get vehicle data.");
    }

    $vehicle = $vehicleResult->fetch_assoc();
} catch (Exception $e) {
    echo $e->getMessage();
    header('Location: Index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarrosFácil - <?= $vehicle['modelName'] ?></title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css" />

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="/custom/css/style.css">
</head>

<body>
    <?php
    echo HeaderComponent("product-viewer");
    ?>

    <main id="product-viewer" class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <section id="galery" class="col-12 col-lg-8 p-0 pe-lg-4 align-self-start">
                    <div id="main-container">
                        <img id="main-image" class="w-100 h-100" src="../images/<?= $vehicle['foto'] ?>" alt="">
                    </div>
                    <div id="pictures" class="d-flex align-items-center">
                        <ul class="list-unstyled m-0 p-0">
                            <?php
                            $diretorio = "./images/";

                            // 1. Validar e mostrar a Foto Principal (destaque) na galeria
                            if (!empty($vehicle['foto']) && file_exists($diretorio . $vehicle['foto'])) {
                                echo '<li>';
                                echo '  <button class="picture active">';
                                echo '      <img class="w-100 h-100" src="' . $diretorio . $vehicle['foto'] . '" alt="Foto Principal">';
                                echo '  </button>';
                                echo '</li>';
                            }

                            // 2. Validar e mostrar as Fotos Extras
                            foreach ($vehiclePhotos as $photo) {
                                $caminhoCompleto = $diretorio . $photo['caminho'];

                                if (!empty($photo['caminho']) && file_exists($caminhoCompleto)) {
                                    echo '<li>';
                                    echo '  <button class="picture">';
                                    echo '      <img class="w-100 h-100" src="' . $caminhoCompleto . '" alt="Foto Adicional">';
                                    echo '  </button>';
                                    echo '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </section>
                <section id="product-info" class="col-12 col-lg-4 align-self-start mt-4 mt-lg-0 ms-lg-auto white-bg">
                    <div id="model-info">
                        <span id="brand"><?= $vehicle['brandName'] ?></span>
                        <h1 id="model-name"><?= $vehicle['modelName'] ?></h1>
                    </div>
                    <div id="price">
                        <?php
                        $hasDiscount = $vehicle['desconto'] > 0;
                        if ($hasDiscount) {
                            echo '<div id="real-price">R$ ' . number_format($vehicle['preco_venda'], 2, ',', '.') . '</div>';
                        }

                        echo '<div id="current-price">R$ ' . number_format($hasDiscount ? $vehicle['preco_desconto'] : $vehicle['preco_venda'], 2, ',', '.') . '</div>';
                        ?>
                        <div id="extra-payments-info">
                            Financiamento em até 60x
                        </div>
                    </div>
                    <div class="contact">
                        <?php
                        $buyMessage = rawurlencode("Olá, eu gostaria de comprar o veiculo {$vehicle["modelName"]} da marca {$vehicle["brandName"]}.");
                        $testMessage = rawurlencode("Olá, eu gostaria de agendar um test-drive no veiculo {$vehicle["modelName"]} da marca {$vehicle["brandName"]}.");
                        ?>

                        <a href="https://wa.me/5519999999999?text=<?= htmlspecialchars($buyMessage) ?>" target="_blank" id="talk-consultant" class="w-100 d-flex justify-content-center align-items-center mb-2">
                            <i class="bi bi-whatsapp"></i>
                            Falar com Consultor
                        </a>
                        <a href="https://wa.me/5519999999999?text=<?= htmlspecialchars($testMessage) ?>" target="_blank" id="test-drive" class="w-100 d-flex justify-content-center align-items-center">
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
                            <span class="w-100 value"><?= $vehicle['ano'] ?></span>
                        </div>
                    </div>
                    <div class="basic-info-card">
                        <div class="content d-flex flex-wrap text-center p-2 white-bg">
                            <i class="w-100 bi bi-speedometer"></i>
                            <span class="w-100 info-name">KM</span>
                            <span class="w-100 value"><?= $vehicle['quilometragem'] ?> km</span>
                        </div>
                    </div>
                    <div class="basic-info-card col-6 col-md-3 mt-4 mt-md-0 pe-0">
                        <div class="content d-flex flex-wrap text-center p-2 white-bg">
                            <i class="w-100 bi bi-sliders"></i>
                            <span class="w-100 info-name">CÂMBIO</span>
                            <span class="w-100 value"><?= $vehicle['tipo_cambio'] ?></span>
                        </div>
                    </div>
                    <div class="basic-info-card col-6 col-md-3 mt-4 mt-md-0 pe-0">
                        <div class="content d-flex flex-wrap text-center p-2 white-bg">
                            <i class="w-100 bi bi-fuel-pump"></i>
                            <span class="w-100 info-name">COMBUSTÍVEL</span>
                            <span class="w-100 value"><?= $vehicle['tipo_combustivel'] ?></span>
                        </div>
                    </div>
                </section>
                <section id="description" class="mt-4 col-lg-8 col-12 ps-0 pe-lg-4 pe-0">
                    <div class="content p-3 white-bg">
                        <h2 class="info-card-title d-flex align-items-center gap-2">
                            <span class="w-1 h-6 bg-blue-900 rounded-full"></span>
                            Descrição
                        </h2>
                        <?= $vehicle['descricao'] ?>
                    </div>
                </section>
                <section id="vehicle-items-container" class="mt-4 col-lg-8 col-12 ps-0 pe-lg-4 pe-0">
                    <div class="content white-bg p-3">
                        <h2 class="info-card-title d-flex align-items-center gap-2">
                            <span class="w-1 h-6 bg-blue-900 rounded-full"></span>
                            Itens do veículo
                        </h2>
                        <ul class="list-unstyled row row-cols-1 row-cols-md-2 g-4 row-cols-xl-3" id="vehicle-items-list">
                            <?php
                            foreach ($vehicleItems as $item) {
                                echo '<li class="col">';
                                echo '  <div class="content">';
                                echo '      <img src="../images/' . $item['icone'] . '" class="item-icon" alt="">';
                                echo '      ' . $item['nome'];
                                echo '  </div>';
                                echo '</li>';
                            }
                            ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CUSTOM -->
    <script>
        $('.picture').click(function() {
            const newImage = $(this).find('img').attr('src');
            const currentImage = $('#main-image').attr('src');
            if (newImage == currentImage) {
                return;
            }

            $('#main-image').fadeOut(150, function() {
                $(this).attr('src', newImage).fadeIn(150);
            });

            $('.picture').removeClass('active');
            $(this).addClass('active');
        });
    </script>
</body>

</html>