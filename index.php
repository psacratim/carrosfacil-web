<?php
require_once("./conexao/conecta.php")
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carros Fácil - Inicio</title>

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./custom/css/index.css">
</head>

<body>
    <header id="main-header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary h-100">
            <div class="container h-100">
                <a class="navbar-brand" href="#">
                    <img src="./assets/img/logotipo-empresa.png" width="auto" height="25"
                        class="d-inline-block align-top my-auto" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Veículos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Ofertas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Contato</a>
                        </li>
                    </ul>

                    <div class="auth-content">
                        <a href="#" class="btn btn-login">Login</a>
                        <a href="#" class="btn btn-register">Registrar</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <body>
        <section id="sect-search-car">
            <div class="container">
                <h1>Encontre o seu veículo ideal</h1>
                <p>Veículos usados, semi-novos e novos com as melhores condições do mercado</p>

                <form action="" id="form-search-car">
                    <input class="input" type="text" name="search_value" id="search-value" placeholder="Digite a marca, modelo ou ano...">
                    <button class="button" type="submit">
                        <i class="bi bi-search"></i>
                        Buscar
                    </button>
                </form>
            </div>
        </section>
        <section id="sect-vehicles">
            <div class="container">
                <aside id="asid-filters">
                    <div class="header">
                        <h2>Filtros</h2>
                        <button id="clear-filters">
                            <i class="bi bi-arrow-clockwise"></i>
                            Limpar
                        </button>
                    </div>

                    <div class="filter-item">
                        <label for="search_value">Buscar</label>
                        <input class="default" type="text" name="search_value" id="search_value" placeholder="Digite a marca, modelo ou ano...">
                    </div>

                    <div class="filter-item">
                        <label for="category">Categoria</label>
                        <select class="form-select default" name="category" id="category">
                            <option selected>- Todas as categorias -</option>
                            <option value="test">SUVs</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="condition">Condição</label>
                        <select class="form-select default" name="condition" id="condition">
                            <option selected>- Todas as condicoes -</option>
                            <option value="test">SUVs</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="brand">Marca</label>
                        <select class="form-select default" name="brand" id="brand">
                            <option selected>- Todas as marcas -</option>
                            <option value="test">SUVs</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="fuel">Tipo de combustível</label>
                        <select class="form-select default" name="fuel" id="fuel">
                            <option selected>- Todos os tipos -</option>
                            <option value="test">SUVs</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="gearbox">Câmbio</label>
                        <select class="form-select default" name="gearbox" id="gearbox">
                            <option selected>- Todas os câmbios -</option>
                            <option value="test">SUVs</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="mileage">Quilômetragem Máxima</label>
                        <input class="default" type="text" name="mileage" id="mileage" placeholder="Ex: 50.000">
                    </div>

                    <div class="filter-item">
                        <label for="price_range">Faixa de Preço</label>
                        <input type="range" class="form-range" min="0" max="10.000.000" id="price_range">
                        <div class="range-info">
                            <span>R$0</span>
                            <span>R$10.000.000</span>
                        </div>
                    </div>

                    <div class="filter-item">
                        <label for="year">Ano</label>
                        <input type="range" class="form-range" min="1920" max="2025" id="year">
                        <div class="range-info">
                            <span>1920</span>
                            <span>2025</span>
                        </div>
                    </div>
                </aside>
                <section id="sect-vehicles-list">
                    <?php
                    $sql = "
                        SELECT veiculo.id, modelo.nome 'nome_modelo', veiculo.tem_desconto, veiculo.desconto, veiculo.ano, veiculo.kms_rodado, veiculo.tipo_combustivel, veiculo.tipo_cambio, veiculo.preco_venda, veiculo.preco_desconto, veiculo.foto, veiculo.status, veiculo.descricao FROM veiculo
                        INNER JOIN modelo ON modelo.id = veiculo.id_modelo;
                        ";
                    $query = mysqli_query($conexao, $sql);
                    $num_rows = mysqli_num_rows($query);
                    ?>
                    <div class="header">
                        <h2>Nossos veículos</h2>
                        <div class="vehicles-counter">
                            <?php echo $num_rows ?> veículos encontrados
                        </div>
                    </div>

                    <div class="list">
                        <?php
                        if ($num_rows > 0) {
                            foreach ($query as $veiculo) {
                        ?>
                                <div class="vehicle-card col-4">
                                    <div class="header">
                                        <?php
                                        if ($veiculo['status'] == 0) {
                                            echo '<div class="status bg-danger">Indisponível</div>';
                                        } else {
                                            echo '<div class="status">Disponível</div>';
                                        }
                                        ?>
                                        <?php
                                        if ($veiculo['tem_desconto']) {
                                            echo '<div class="discount"><i class="bi bi-tag"></i>-'. $veiculo['desconto'] .'%</div>';
                                        }
                                        ?>
                                    </div>
                                    <?php 
                                    
                                    ?>
                                    <img src="./images/<?php echo $veiculo['foto'] ?>" class="img-fluid">
                                    <h4>
                                        <?php echo $veiculo['nome_modelo']?>
                                    </h4>
                                    <div class="infos">
                                        <div class="info">
                                            <i class="bi bi-calendar3"></i>
                                            <?php echo $veiculo['ano'] ?>
                                        </div>
                                        <div class="info text-end">
                                            <i class="bi bi-speedometer"></i>
                                            <?php 
                                            if ($veiculo['kms_rodado'] > 0){
                                            echo number_format($veiculo['kms_rodado'], 0, ',', '.');
                                            } else echo 'Zero';
                                            ?>
                                        </div>
                                        <div class="info">
                                            <i class="bi bi-fuel-pump text-start"></i>
                                            <?php echo $veiculo['tipo_combustivel'] ?>
                                        </div>
                                        <!-- <div class="info d-flex justify-content-between text-end align-items-center"> -->
                                        <div class="info text-end">
                                            <i class="bi bi-gear text-end"></i>
                                            <?php echo $veiculo['tipo_cambio'] ?>
                                        </div>
                                    </div>

                                    <div class="tags">
                                        <div class="tag">
                                            USADO
                                        </div>
                                        <div class="tag">
                                            SUV
                                        </div>
                                    </div>

                                    <?php 
                                    if ($veiculo['tem_desconto']) {
                                        echo "<div class='price-discount'>";
                                        echo "<span class='discount'>R$". number_format($veiculo['preco_venda'], 2, ',', '.') ."</span>";
                                        echo "<span class='current'>R$". number_format($veiculo['preco_desconto'], 2, ',', '.') ."</span>";
                                        echo "</div>";
                                    } else {
                                        echo "<div class='price-normal'>";
                                        echo "<span class='current'>R$ ". number_format($veiculo['preco_venda'], 2, ',', '.') ."</span>";
                                        echo "</div>";
                                    }
                                    ?>

                                    <a href="#" class="view-more">Saber Mais</a>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </section>
            </div>
        </section>
        <div id="sect-data">
            <div class="row">
                <div class="data-item col-4">
                    <i class="bi bi-whatsapp"></i>
                    <span>(19) 99999-9999</span>
                </div>
                <div class="data-item col-4">
                    <i class="bi bi-geo-alt"></i>
                    <span>Rua dos Carros, 123</span>
                    <span>São Paulo - SP</span>
                </div>
                <div class="data-item col-4">
                    <i class="bi bi-clock"></i>
                    <span>Segunda á Sexta: 8h até 18h</span>
                    <span>Sábado e Domingo: 10h até 14h</span>
                </div>
            </div>
        </div>
    </body>

    <footer class="footer">
        <div class="copyright">
            CarrosFácil<br>
            © 2025 Carros Fácil. Todos os direitos reservados.
        </div>
    </footer>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
        crossorigin="anonymous"></script>
</body>

</html>