<?php
require_once("./conexao/conecta.php");
require_once('./Components/Header.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carros Fácil - Inicio</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="./custom/css/index.css">
    <link rel="stylesheet" href="./custom/css/style.css">
</head>

<body class="bg-light">
    <?php
    echo HeaderComponent("index");
    ?>

    <section id="sect-search-car" class="py-5 text-white text-center shadow-sm">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Encontre o seu veículo ideal</h1>
                    <p class="lead mb-4">Veículos usados, semi-novos e novos com as melhores condições do mercado</p>
                    <form action="" id="form-search-car" class="row g-2 justify-content-center align-items-stretch">
                        <div class="col-md-9">
                            <div class="search-input-container">
                                <input onkeyup="applyFilters()"
                                    class="form-control form-control-lg search-input-field"
                                    type="text"
                                    name="search_value"
                                    id="search-value"
                                    placeholder="Digite a marca, modelo ou ano...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-dark btn-lg w-100 h-100 fw-bold border-0" type="submit">
                                BUSCAR
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <main class="container my-5">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="card border-0 shadow-sm sticky-lg-top" style="top: 80px; z-index: 10;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary">Filtros</h5>
                        <button id="clear-filters" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Limpar
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="search_value" class="form-label fw-medium small">Palavra-chave</label>
                            <input onkeyup="applyFilters()" class="form-control" type="text" name="search_value" id="search_value" placeholder="Marca, modelo...">
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label fw-medium small">Categoria</label>
                            <select onchange="applyFilters()" class="form-select" name="category" id="category">
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

                        <div class="mb-3">
                            <label for="condition" class="form-label fw-medium small">Condição</label>
                            <select onchange="applyFilters()" class="form-select" name="condition" id="condition">
                                <option value="" selected>- Todas as condições -</option>
                                <option value="Novo">Novo</option>
                                <option value="Semi-novo">Semi-novo</option>
                                <option value="Usado">Usado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label fw-medium small">Marca</label>
                            <select onchange="applyFilters()" class="form-select" name="brand" id="brand">
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

                        <div class="mb-3">
                            <label for="fuel" class="form-label fw-medium small">Combustível</label>
                            <select onchange="applyFilters()" class="form-select" name="fuel" id="fuel">
                                <option value="" selected>- Todos os tipos -</option>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Etanol">Etanol</option>
                                <option value="Flex">Flex</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Elétrico">Elétrico</option>
                                <option value="GNV (Gás Natural Veicular)">GNV</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="gearbox" class="form-label fw-medium small">Câmbio</label>
                            <select onchange="applyFilters()" class="form-select" name="gearbox" id="gearbox">
                                <option value="" selected>- Todos os câmbios -</option>
                                <option value="Manual">Manual</option>
                                <option value="Automático T.">Automático Tradicional</option>
                                <option value="CVT">CVT</option>
                                <option value="Auto. Mono-Emb.">Automatizado</option>
                                <option value="DCT">DCT (Dupla Embreagem)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mileage" class="form-label fw-medium small">KM Máxima</label>
                            <input onkeyup="applyFilters()" class="form-control" type="text" name="mileage" id="mileage" placeholder="Ex: 50.000">
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label fw-medium small">Ano</label>
                            <input onkeyup="applyFilters()" class="form-control" type="text" name="year" id="year" placeholder="Ex: 2025">
                        </div>

                        <div class="mb-2">
                            <label for="price_range" class="form-label fw-medium small d-flex justify-content-between">
                                Preço Máximo <span>R$<span id="range-val-display">10M</span></span>
                            </label>
                            <input oninput="updateRangeDisplay(this.value); applyFilters()" type="range" class="form-range" min="0" max="10000000" step="5000" value="10000000" id="price_range">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>R$0</span>
                                <span>R$10M+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <section class="col-lg-9">
                <div id="sect-vehicles-list" class="row g-4">
                </div>

                <nav aria-label="paginacao">
                    <ul class="pagination justify-content-center">

                        <li class="page-item">
                            <button class="page-link" id="gotoFirstPage" onclick="gotoPage('first')">Início</button>
                        </li>



                        <li class="page-item">
                            <button class="page-link" onclick="gotoPage('previous')" aria-label="Previous" id="gotoPreviousPage">
                                <span aria-hidden="true">&laquo;</span>
                            </button>
                        </li>



                        <li class="page-item">
                            <button class="page-link" onclick="gotoPage('next')" aria-label="Previous" id="gotoNextPage">
                                <span aria-hidden="true">&raquo;</span>
                            </button>
                        </li>

                        <li class="page-item">
                            <button class="page-link" id="gotoLastPage" onclick="gotoPage('last')">Final</button>
                        </li>

                    </ul>
                </nav>
            </section>
        </div>
    </main>

    <div id="sect-data" class="py-5">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-whatsapp fs-1 mb-3 d-block"></i>
                        <h6 class="fw-bold mb-1">WhatsApp</h6>
                        <span class="">(19) 99999-9999</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border-start border-end border-md-0">
                        <i class="bi bi-geo-alt fs-1 mb-3 d-block"></i>
                        <h6 class="fw-bold mb-1">Localização</h6>
                        <span class="d-block">Rua dos Carros, 123</span>
                        <span class="">São Paulo - SP</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-clock fs-1 mb-3 d-block"></i>
                        <h6 class="fw-bold mb-1">Horários</h6>
                        <span class="d-block">Segunda à Sexta: 8h - 18h</span>
                        <span class="">Sáb. e Dom.: 10h - 14h</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once('./Components/Footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let mainHeader = $('#main-header')

        $(function() {
            const headerObserver = new IntersectionObserver(([entry]) => {
                mainHeader.toggleClass('scrolled', !entry.isIntersecting)
            }, {
                threshold: 0
            })

            // Ajuste caso o sentinel não exista no HeaderComponent, aplicamos ao body top
            const sentinel = document.querySelector("#header-sentinel") || document.body;
            headerObserver.observe(sentinel);
        });

        // Auxiliar para mostrar o valor do range
        function updateRangeDisplay(val) {
            let display = val >= 1000000 ? (val / 1000000).toFixed(0) + 'M' : (val / 1000).toFixed(0) + 'k';
            $("#range-val-display").text(display);
        }

        // Limpar filtros
        $("#clear-filters").click(function() {
            $("#asid-filters input, #asid-filters select").val('');
            $("#price_range").val(10000000);
            updateRangeDisplay(10000000);
            applyFilters();
        });

        // AJAX (FUNÇÃO PARA LISTAR OS VEÍCULOS)
        var currentPage = 1;
        var maxPages = 1;

        function updateTableWithFilters(search_value, category, condition, brand, fuel, gearbox, mileage, price_range, year, page) {
            $.ajax({
                url: 'vehicle-list.php?',
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
                    year,
                    page
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#sect-vehicles-list").css('opacity', '0.5');
                },
                success: function(response) {
                    console.log(response);
                    $("#sect-vehicles-list").html(response.html).css('opacity', '1');
                    maxPages = response.maxPages;
                }
            })
        }

        // AJAX (Função para aplicar o filtro)
        function applyFilters() {
            let search_value = $("#search_value").val() || $("#search-value").val();
            let category = $("#category").val();
            let condition = $("#condition").val();
            let brand = $("#brand").val();
            let fuel = $("#fuel").val();
            let gearbox = $("#gearbox").val();
            let mileage = $("#mileage").val();
            let price_range = $("#price_range").val();
            let year = $("#year").val();

            updateTableWithFilters(search_value, category, condition, brand, fuel, gearbox, mileage, price_range, year, currentPage);
        }

        $("#form-search-car").on("submit", function(e) {
            e.preventDefault();
            // sincroniza o input do topo com o input real do filtro
            $("#search_value").val($("#search-value").val());
            applyFilters();
        });

        $(document).ready(function() {
            applyFilters();
        });

        // Page system
        function gotoPage(action) {
            switch (action.toLowerCase()) {
                case "next":
                    currentPage++;
                    console.log('oi ' + currentPage);
                    break;
                case "previous":
                    currentPage--;
                    break;
                case "last":
                    currentPage = maxPages;
                    break;
                default: // "first"
                    currentPage = 1;
                    break;
            }

            if (currentPage < 1) currentPage = 1;
            if (currentPage > maxPages) currentPage = maxPages;

            // 🔄 Atualiza listagem
            applyFilters();

            // 🎛️ Controle dos botões
            const isFirstPage = currentPage === 1;
            const isLastPage = currentPage === maxPages;

            $("#gotoFirstPage").prop("disabled", isFirstPage);
            $("#gotoPreviousPage").prop("disabled", isFirstPage);

            $("#gotoNextPage").prop("disabled", isLastPage);
            $("#gotoLastPage").prop("disabled", isLastPage);
        }
    </script>
</body>

</html>