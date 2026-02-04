<?php
if (!isset($_SESSION)) {
  session_start();
}

require_once("../usuario_comum.php");
require_once("../../conexao/conecta.php");
require_once("../../Components/FormModal.php");
require_once("../../Components/Table.php");
require_once('../../Components/Sidebar.php');
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
      <?php echo Sidebar("brand"); ?>

      <main class="col-lg-10">
        <header id="admin-header" class="py-3 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="left-info">GERENCIANDO - MARCAS</div>
          <div id="right-info">
            <div id="current-time">AGORA</div>
          </div>
        </header>

        <hr class="m-0">

        <?php include('../Mensagem.php'); ?>

        <div class="container mt-3">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="m-0">Marcas de Veículos</h4>
              <button type="button" class="btn btn-primary" data-entity="marcas" data-bs-toggle="modal" data-bs-target="#marcasModal">
                <i class="bi bi-plus-lg"></i> Adicionar
              </button>
            </div>

            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-2">
                  <input onkeyup="applyFilters()" type="text" name="id-filter" id="id-filter" class="form-control" placeholder="Código" data-mask="00000">
                </div>
                <div class="col-md-7">
                  <input onkeyup="applyFilters()" type="text" name="name-filter" id="name-filter" class="form-control" placeholder="Filtrar por marca">
                </div>
                <div class="col-md-3">
                  <select onchange="applyFilters()" name="status-filter" id="status-filter" class="form-control">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </div>
              </div>
            </div>

            <div id="table-target">
                <?php
                // Listagem inicial
                $query = "SELECT id, nome 'name', observacao 'observation', data_cadastro 'createdAt', status FROM marca";
                $result = mysqli_query($connection, $query);
                
                echo Table::render([
                  "#" => "id",
                  "Nome" => "name",
                  "Observação" => "observation",
                  "Cadastro" => "createdAt",
                  "Status" => "status"
                ], $result, [
                  "entity" => "marcas",
                  "modalTarget" => "#marcasModal"
                ]);
                ?>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <?php
  // Criação do Modal usando o Componente
  echo FormModal::create([
    "modalId" => "marcasModal",
    "actionUrl" => "./actions.php",
    "submitButton" => '<button type="submit" class="btn btn-primary w-100">Salvar Marca</button>'
  ], [
    ["id" => "name", "optional" => false, "label" => "Nome da Marca", "type" => "text", "length" => 80],
    ["id" => "observation", "optional" => true, "label" => "Observação", "type" => "text", "length" => 250],
    ["id" => "status", "optional" => false, "label" => "Status", "type" => "select", "options" => [
      ["label" => "Desativado", "value" => 0],
      ["label" => "Ativado", "value" => 1],
    ]]
  ]);
  ?>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="../../assets/js/components/form-modal.js"></script>
  <script src="../../assets/js/components/admin-header.js"></script>
  <script src="../../assets/js/components/sidebar.js"></script>
  <script src="../../assets/js/jquery.mask.js"></script>

  <script>
    function updateTableWithFilters(id, name, status) {
      $.ajax({
        url: 'table.php',
        method: 'POST',
        data: { id, name, status },
        success: function(response) {
          $("#table-target").html(response);
        }
      });
    }

    function applyFilters() {
      updateTableWithFilters($("#id-filter").val(), $("#name-filter").val(), $("#status-filter").val());
    }

    $(document).ready(function() {
      // Carrega a tabela com filtros vazios ao iniciar
      applyFilters();
    });
  </script>
</body>
</html>