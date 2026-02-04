<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once("../usuario_comum.php");
require_once("../../conexao/conecta.php");
require_once('../../Components/Sidebar.php');
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carros Fácil - Gerenciar Veículos</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../custom/css/style.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php echo Sidebar("vehicle"); ?>

      <main class="col-lg-10">
        <header id="admin-header" class="py-3 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="left-info">GERENCIANDO - ESTOQUE DE VEÍCULOS</div>
          <div id="right-info">
            <div id="current-time">AGORA</div>
          </div>
        </header>

        <hr class="m-0">

        <?php include('../Mensagem.php'); ?>

        <div class="container mt-3">
          <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="m-0">Lista de Veículos</h4>
              <a href="manage.php" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Adicionar Veículo
              </a>
            </div>

            <div class="card-body">
              <div class="row g-2">
                <div class="col-md-1">
                  <input onkeyup="applyFilters()" type="text" id="id-filter" class="form-control" placeholder="Código" data-mask="00000">
                </div>
                <div class="col-md-3">
                  <input onkeyup="applyFilters()" type="text" id="model-filter" class="form-control" placeholder="Filtrar por modelo">
                </div>
                <div class="col-md-3">
                  <select onchange="applyFilters()" id="category-filter" class="form-select">
                    <option value="">Todas Categorias</option>
                    <option value="Hatchback">Hatchback</option>
                    <option value="Sedan">Sedan</option>
                    <option value="SUV">SUV</option>
                    <option value="Pickup">Picape</option>
                    </select>
                </div>
                <div class="col-md-3">
                  <select onchange="applyFilters()" id="conditions-filter" class="form-select">
                    <option value="">Todos Estados</option>
                    <option value="Novo">Novo</option>
                    <option value="Semi-novo">Semi-novo</option>
                    <option value="Usado">Usado</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <select onchange="applyFilters()" id="status-filter" class="form-select">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </div>
              </div>
            </div>

            <div id="table-target">
              </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/components/admin-header.js"></script>
  <script src="../../assets/js/components/sidebar.js"></script>
  <script src="../../assets/js/jquery.mask.js"></script>

  <script>
    function applyFilters() {
      $.ajax({
        url: 'table.php',
        method: 'POST',
        data: {
          id: $("#id-filter").val(),
          model: $("#model-filter").val(),
          category: $("#category-filter").val(),
          conditions: $("#conditions-filter").val(),
          status: $("#status-filter").val()
        },
        success: function(response) {
          $("#table-target").html(response);
        }
      });
    }

    $(document).ready(function() {
      applyFilters();
    });
  </script>
</body>
</html>