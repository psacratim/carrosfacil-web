<?php 
if (!isset($_SESSION)) { session_start(); }
require_once("../../conexao/conecta.php");
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carros Fácil - Gerenciar Funcionários</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../custom/css/style.css">
</head>
<body>
    
  <div class="container-fluid">
    <div class="row">
      <?php require_once('../../Components/Sidebar.php'); ?>

      <main class="col-lg-10">
        <header id="admin-header" class="py-3 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="left-info">GERENCIANDO - QUADRO DE FUNCIONÁRIOS</div>
          <div id="right-info">
            <div id="current-time">AGORA</div>
          </div>
        </header>

        <hr class="m-0">

        <?php include('../Mensagem.php'); ?>

        <div class="container mt-3">
          <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="m-0">Funcionários</h4>
              <a href="manage.php" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Adicionar
              </a>
            </div>

            <div class="card-body">
              <div class="row g-2">
                <div class="col-md-3">
                  <input onkeyup="applyFilters()" type="text" id="name-filter" class="form-control" placeholder="Nome do funcionário">
                </div>
                <div class="col-md-2">
                  <input onkeyup="applyFilters()" type="text" id="cpf-filter" class="form-control" placeholder="CPF" data-mask="000.000.000-00">
                </div>
                <div class="col-md-2">
                  <select onchange="applyFilters()" id="gender-filter" class="form-select">
                    <option value="">Sexo</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="N">Não Informado</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <input onchange="applyFilters()" type="date" id="birthDate-filter" class="form-control">
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
  <script src="../../assets/js/jquery.mask.js"></script>
  <script src="../../assets/js/components/admin-header.js"></script>
  <script src="../../assets/js/components/sidebar.js"></script>

  <script>
    function applyFilters() {
      $.ajax({
        url: 'table.php',
        method: 'POST',
        data: {
          name: $("#name-filter").val(),
          cpf: $("#cpf-filter").val(),
          gender: $("#gender-filter").val(),
          nascimento: $("#birthDate-filter").val(),
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