<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once("../../conexao/conecta.php");
require_once('../../Components/Sidebar.php');
require_once("../../Components/FormModal.php");

require_once("../usuario_comum.php");
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carros Fácil - Painel</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../custom/css/style.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php echo Sidebar("role"); ?>

      <main class="col-lg-10">
        <header id="admin-header" class="py-3 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="left-info">GERENCIANDO - CARGOS</div>
          <div id="right-info">
            <div id="current-time">AGORA</div>
          </div>
        </header>

        <hr class="m-0">

        <?php include('../Mensagem.php'); ?>

        <div class="container mt-5">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h4 class="m-0 lh-base">Cargos</h4>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cargosModal" data-entity="cargos">
                Adicionar
              </button>
            </div>


            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                  <input onkeyup="applyFilters()" type="text" name="id-filter" id="id-filter" class="form-control" placeholder="Filtrar por código">
                </div>

                <div class="col-7">
                  <input onkeyup="applyFilters()" type="search" name="search-filter" id="search-filter" class="form-control" placeholder="Filtrar por cargo">
                </div>

                <div class="col-3">
                  <select name="status-filter" id="status-filter" class="form-control" onchange="applyFilters()">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </div>
              </div>
            </div>

            <div id="table-target"></div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <?php
  echo FormModal::create([
    "modalId" => "cargosModal",
    "actionUrl" => "./actions.php",
    "submitButton" => '<button type="submit" class="btn btn-primary w-100">Cadastrar</button>'
  ], [
    ["id" => "name", "optional" => false, "label" => "Nome", "type" => "text", "length" => 80],
    ["id" => "observation", "optional" => true, "label" => "Observação", "type" => "text", "length" => 250],
    ["id" => "status", "optional" => false, "label" => "Status", "type" => "select", "options" => [
      ["label" => "Desativado", "value" => 0],
      ["label" => "Ativado", "value" => 1],
    ]]
  ]);
  ?>

  <!-- BOOTSTRAP JS + JQUERY -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>

  <script src="../../assets/js/components/form-modal.js"></script>
  <script src="../../assets/js/components/admin-header.js"></script>
  <script src="../../assets/js/components/sidebar.js"></script>
  
  <!-- CUSTOM SCRIPTS -->
  <script>
    // AJAX (FUNÇÃO PARA LISTAR OS FUNCIONÁRIOS)
    function updateTableWithFilters(id, name, status) {
      $.ajax({
        url: './table.php',
        method: 'POST',
        data: {
          id,
          name,
          status
        },
        dataType: 'html',
        success: function(response) {
          $("#table-target").html(response);
        }
      })
    }

    // AJAX (Função para aplicar o filtro)
    function applyFilters() {
      updateTableWithFilters($("#id-filter").val(), $("#search-filter").val(), $("#status-filter").val());
    }

    $(document).ready(function() {
      applyFilters();
    });
  </script>
</body>

</html>