<?php
// STARTING SESSION
if (!isset($_SESSION)) {
  session_start();
}

require_once("../../conexao/conecta.php")
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Carros Fácil - Painel</title>

  <!-- BOOTSTRAP CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- CUSTOMIZAÇÃO DO TEMPLATE -->
  <link rel="stylesheet" href="../../assets/css/dashboard.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">

  <!-- FAVICON -->
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">

  <!-- CSS -->
  <link rel="stylesheet" href="../../custom/css/style.css">
</head>

<body>

  <?php
  #Início TOPO
  include('../Topo.php');
  #Final TOPO
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
      #Início MENU
      include('../Navegacao.php');
      #Final MENU
      ?>

      <main class="ml-auto col-lg-10 px-md-4">
        <?php
        include('../LoggedUser.php');
        include('../Mensagem.php');
        ?>
        <div class="container mt-5">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h4 class="m-0">Veiculos</h4>

              <a href="inserir.php" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Adicionar</a>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-2">
                  <input onkeyup="applyFilters()" type="text" name="id-filter" id="id-filter" class="form-control" placeholder="Ex: 1">
                </div>
                <div class="col-3">
                  <input onkeyup="applyFilters()" type="text" name="model-filter" id="model-filter" class="form-control" placeholder="Ex: BMW M4">
                </div>
                <div class="col-2">
                  <select onchange="applyFilters()" name="category-filter" id="category-filter" class="form-control">
                      <option value="" selected>- Nenhum Selecionado -</option>
                      <option value="Hatchback">Hatchback</option>
                      <option value="Sedan">Sedan</option>
                      <option value="SUV">SUV</option>
                      <option value="Crossover">Crossover</option>
                      <option value="Cupê">Cupê</option>
                      <option value="Conversível">Conversível</option>
                      <option value="Perua / Station Wagon">Perua / Station Wagon</option>
                      <option value="Roadster">Roadster</option>
                      <option value="Esportivo">Esportivo</option>
                      <option value="Compacto">Compacto</option>
                      <option value="Minivan">Minivan</option>
                      <option value="Pickup">Pickup</option>

                      <option value="Van">Van</option>
                      <option value="Furgão">Furgão</option>
                      <option value="Caminhonete">Caminhonete</option>

                      <option value="Superesportivo">Superesportivo</option>
                      <option value="Luxo / Premium">Luxo / Premium</option>
                      <option value="Gran Turismo (GT)">Gran Turismo (GT)</option>
                      <option value="Conversível Esportivo">Conversível Esportivo</option>

                      <option value="Caminhão Leve">Caminhão Leve</option>
                      <option value="Caminhão Médio">Caminhão Médio</option>
                      <option value="Caminhão Pesado">Caminhão Pesado</option>
                      <option value="Carreta">Carreta</option>

                      <option value="Motocicleta">Motocicleta</option>
                      <option value="Scooter">Scooter</option>
                      <option value="Triciclo">Triciclo</option>
                      <option value="Quadriciclo">Quadriciclo</option>

                      <option value="Buggy">Buggy</option>
                      <option value="Off-Road / 4x4">Off-Road / 4x4</option>
                      <option value="Motorhome">Motorhome</option>
                  </select>
                </div>
                <div class="col-2">
                  <select onchange="applyFilters()" name="states-filter" id="states-filter" class="form-control">
                    <option value="" selected>- Nenhum Selecionado -</option>
                    <option value="Novo">Novo</option>
                    <option value="Semi-novo">Semi-novo</option>
                    <option value="Usado">Usado</option>
                  </select>
                </div>
                <div class="col-2">
                  <select onchange="applyFilters()" name="status-filter" id="status-filter" class="form-control">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </div>
              </div>
            </div>

            <div id="listar"></div>
          </div>
        </div>

      </main>
    </div>
  </div>

  <!-- BOOTSTRAP JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <script>
        // AJAX (FUNÇÃO PARA LISTAR OS FUNCIONÁRIOS)
    function updateTableWithFilters(id, model, category, states, status){
      $.ajax({
        url: 'table.php',
        method: 'POST',
        data: {
          id,
          model,
          category,
          states,
          status
        },
        dataType: 'html',
        success: function(response){
          $("#listar").html(response);
        }
      })
    }

    // AJAX (Função para aplicar o filtro)
    function applyFilters() {
      let id = $("#id-filter").val();
      let model = $("#model-filter").val();
      let category = $("#category-filter").val();
      let states = $("#states-filter").val();
      let status = $("#status-filter").val();

      updateTableWithFilters(id, model, category, states, status);
    }

    $(document).ready(function(){
      applyFilters();
    });
  </script>
</body>

</html>