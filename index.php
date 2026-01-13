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
    <link rel="stylesheet" href="./custom/css/style.css">
</head>

<body>
    <?php 
    include_once('./Components/Header.php');
    ?>

    <body>
        <section id="sect-search-car">
            <div class="container">
                <h1>Encontre o seu veículo ideal</h1>
                <p>Veículos usados, semi-novos e novos com as melhores condições do mercado</p>

                <form action="" id="form-search-car">
                    <input onkeyup="applyFilters()" class="input" type="text" name="search_value" id="search-value" placeholder="Digite a marca, modelo ou ano...">
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
                        <input onkeyup="applyFilters()" class="default" type="text" name="search_value" id="search_value" placeholder="Digite a marca, modelo ou ano...">
                    </div>

                    <div class="filter-item">
                        <label for="category">Categoria</label>
                        <select onchange="applyFilters()" class="form-select default" name="category" id="category">
                            <option value="" selected>- Todas as categorias -</option>
                            <?php
                            $query = "SELECT DISTINCT categoria FROM veiculo";
                            $result = mysqli_query($connection, $query);
                            foreach ($result as $veiculo) {
                                echo "<option value='" . $veiculo['categoria'] . "'>" . $veiculo['categoria'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="condition">Condição</label>
                        <select onchange="applyFilters()" class="form-select default" name="condition" id="condition">
                            <option value="" selected>- Todas as condicoes -</option>
                            <option value="Novo">Novo</option>
                            <option value="Semi-novo">Semi-novo</option>
                            <option value="Usado">Usado</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="brand">Marca</label>
                        <select onchange="applyFilters()" class="form-select default" name="brand" id="brand">
                            <option value="" selected>- Todas as marcas -</option>
                            <?php
                            $query = "SELECT id, nome FROM marca WHERE status = 1";
                            $result = mysqli_query($connection, $query);
                            foreach ($result as $marca) {
                                echo "<option value='" . $marca['id'] . "'>" . $marca['nome'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="fuel">Tipo de combustível</label>
                        <select onchange="applyFilters()" class="form-select default" name="fuel" id="fuel">
                            <option value="" selected>- Todos os tipos -</option>
                            <option value="Gasolina">Gasolina</option>
                            <option value="Etanol">Etanol</option>
                            <option value="Flex">Flex</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Elétrico">Elétrico</option>
                            <option value="GNV (Gás Natural Veicular)">GNV (Gás Natural Veicular)</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="gearbox">Câmbio</label>
                        <select onchange="applyFilters()" class="form-select default" name="gearbox" id="gearbox">
                            <option value="" selected>- Todas os câmbios -</option>
                            <option value="Manual">Manual</option>
                            <option value="Automático T.">Automático Tradicional</option>
                            <option value="CVT">CVT</option>
                            <option value="Auto. Mono-Emb.">Automatizado (Monoembreagem)</option>
                            <option value="DCT">DCT (Automático de Dupla Embreagem)</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="mileage">Quilômetragem Máxima</label>
                        <input onkeyup="applyFilters()" class="default" type="text" name="mileage" id="mileage" placeholder="Ex: 50.000">
                    </div>

                    <div class="filter-item">
                        <label for="year">Ano</label>
                        <input onkeyup="applyFilters()" class="default" type="text" name="year" id="year" placeholder="Ex: 2025">
                    </div>

                    <div class="filter-item">
                        <label for="price_range">Faixa de Preço</label>
                        <input onchange="applyFilters()" type="range" class="form-range" min="0" max="10000000" value="10000000" id="price_range">
                        <div class="range-info">
                            <span>R$0</span>
                            <span>R$10.000.000</span>
                        </div>
                    </div>
                </aside>
                <section id="sect-vehicles-list"></section>
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


    <?php 
    include_once('./Components/Footer.php');
    ?>

    <!-- BOOTSTRAP -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
        let mainHeader = $('#main-header')

        $(function(){
            const headerObserver = new IntersectionObserver(([entry]) => {
                mainHeader.toggleClass('scrolled', !entry.isIntersecting)
            }, { threshold: 0 })

            headerObserver.observe(document.querySelector("#header-sentinel"));
        });

        // AJAX (FUNÇÃO PARA LISTAR OS FUNCIONÁRIOS)
        function updateTableWithFilters(search_value, category, condition, brand, fuel, gearbox, mileage, price_range, year) {
            $.ajax({
                url: 'vehicle-list.php',
                method: 'POST',
                data: {
                    search_value,
                    category,
                    condition,
                    brand,
                    fuel,
                    gearbox,
                    mileage,
                    price_range,
                    year
                },
                dataType: 'html',
                success: function(response) {
                    $("#sect-vehicles-list").html(response);
                }
            })
        }

        // AJAX (Função para aplicar o filtro)
        function applyFilters() {
            let search_value = $("#search_value").val();
            let category = $("#category").val();
            let condition = $("#condition").val();
            let brand = $("#brand").val();
            let fuel = $("#fuel").val();
            let gearbox = $("#gearbox").val();
            let mileage = $("#mileage").val();
            let price_range = $("#price_range").val();
            let year = $("#year").val();

            updateTableWithFilters(search_value, category, condition, brand, fuel, gearbox, mileage, price_range, year);
        }

        $(document).ready(function() {
            applyFilters();
        });
    </script>
</body>

</html>