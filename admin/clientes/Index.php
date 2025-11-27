<?php
// STARTING SESSION
if (!isset($_SESSION)) {
  session_start();
}

require_once("../../conexao/conecta.php");
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
              <h4 class="m-0">Clientes</h4>

              <a href="inserir.php" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Adicionar</a>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-3">
                  <input onkeyup="applyFilters()" type="text" name="nome" id="nome" class="form-control" placeholder="Nome do cliente">
                </div>
                <div class="col-2">
                  <input onkeyup="applyFilters()" type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" maxlength="14" data-mask="000.000.000-00">
                </div>
                <div class="col-2">
                  <input onkeyup="applyFilters()" type="text" name="telefone" id="telefone" class="form-control" placeholder="(00) 00000-0000" minlength="15" maxlength="15" data-mask="(00) 00000-0000">
                </div>
                <div class="col-2">
                  <input onchange="applyFilters()" type="date" name="data_nascimento" id="data_nascimento" class="form-control">
                </div>

                <div class="col-2">
                  <select onchange="applyFilters()" name="sexo" id="sexo" class="form-control">
                    <option value="">Sexo</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="N">Não Informado</option>
                  </select>
                </div>

                <div class="col-2">
                  <select onchange="applyFilters()" name="status" id="status" class="form-control">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="card-body p-0">
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

  <!-- JS MASK -->
  <script src="../../assets/js/jquery.mask.js"></script>

  <script>
    // AJAX (FUNÇÃO PARA LISTAR OS FUNCIONÁRIOS)
    function updateTableWithFilters(cpf, nome, telefone, sexo, data_nascimento, status) {
      $.ajax({
        url: 'table.php',
        method: 'POST',
        data: {
          cpf,
          nome,
          telefone,
          sexo,
          data_nascimento,
          status
        },
        dataType: 'html',
        success: function(response) {
          $("#listar").html(response);
        }
      })
    }

    // AJAX (Função para aplicar o filtro)
    function applyFilters() {
      let cpf = $("#cpf").val();
      let nome = $("#nome").val();
      let telefone = $("#telefone").val();
      let sexo = $("#sexo").val();
      let data_nascimento = $("#data_nascimento").val();
      let status = $("#status").val();

      updateTableWithFilters(cpf, nome, telefone, sexo, data_nascimento, status);
    }

    $(document).ready(function() {
      applyFilters();
    });
  </script>
</body>

</html>