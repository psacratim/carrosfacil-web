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
  <title>Carros Fácil - Painel</title>

  <!-- BOOTSTRAP CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

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

  <?php include('../Topo.php'); ?>

  <div class="container-fluid">
    <div class="row">
      <?php include('../Navegacao.php'); ?>

      <main class="ml-auto col-lg-10 px-md-4">
        <?php
        include('../LoggedUser.php');
        include('../Mensagem.php');
        ?>

        <div class="container mt-5">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="m-0 lh-base">Marca</h4>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#marcaModal">Adicionar</button>
            </div>

            <!-- Modal CADASTRAR -->
            <div class="modal fade" id="marcaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="marcaModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="marcaModalLabel">Cadastrar Marca</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="acoes.php" method="post">
                      <div class="form-group">
                        <label for="nome"><strong class="text-danger">*</strong> Nome da marca:</label>
                        <input type="text" name="nome" id="nome" class="form-control" maxlength="80" required>
                      </div>
                      <div class="form-group">
                        <label for="observacao">Observação:</label>
                        <textarea name="observacao" id="observacao" class="form-control" maxlength="250"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="status"><strong class="text-danger">*</strong> Status:</label>
                        <select name="status" id="status" class="form-control" disabled>
                          <option value="1">Ativo</option>
                          <option value="0">Inativo</option>
                        </select>
                      </div>
                      <input type="hidden" name="cadastrar" value="cadastrar_marca">
                      <input type="submit" class="btn btn-primary btn-block" value="Cadastrar">
                    </form>
                    <button class="btn btn-danger btn-block mt-2" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>

            <?php
            $sql = "SELECT * FROM marca";
            $query = mysqli_query($conexao, $sql);

            if (mysqli_num_rows($query) > 0) {
            ?>
              <div class="card-body">
                <div class="row">
                  <div class="col-3">
                    <input onkeyup="applyFilters()" type="text" name="nome-filter" id="nome-filter" class="form-control" placeholder="Nome da marca">
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
            <?php
            } else {
              echo '<div class="alert alert-danger m-3" role="alert">Nenhum registro encontrado!</div>';
            }
            ?>
          </div>
        </div>

      </main>
    </div>
  </div>

  <!-- Modal EDITAR -->
  <div class="modal fade" id="editarMarcaModal" tabindex="-1" aria-labelledby="editarMarcaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editarMarcaModalLabel">Editar Marca</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="acoes.php" method="post">
            <input type="hidden" name="id" id="edit_id">

            <div class="form-group">
              <label for="edit_nome"><strong class="text-danger">*</strong> Nome da marca:</label>
              <input type="text" name="nome" id="edit_nome" class="form-control" maxlength="80" required>
            </div>
            <div class="form-group">
              <label for="edit_observacao">Observação:</label>
              <textarea name="observacao" id="edit_observacao" class="form-control" maxlength="250"></textarea>
            </div>
            <div class="form-group">
              <label for="edit_status"><strong class="text-danger">*</strong> Status:</label>
              <select name="status" id="edit_status" class="form-control">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
              </select>
            </div>

            <input type="hidden" name="atualizar" value="atualizar_marca">
            <input type="submit" class="btn btn-success btn-block" value="Salvar Alterações">
          </form>
          <button class="btn btn-secondary btn-block mt-2" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- BOOTSTRAP JS + JQUERY -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>

  <!-- SCRIPT EDIÇÃO -->
  <script>
    $(document).on('click', '.editar-btn', function() {
      const id = $(this).data('id');
      const nome = $(this).data('nome');
      const observacao = $(this).data('observacao');
      const status = $(this).data('status');

      $('#edit_id').val(id);
      $('#edit_nome').val(nome);
      $('#edit_observacao').val(observacao);
      $('#edit_status').val(status);

      $('#editarMarcaModal').modal('show');
    });

    // AJAX (FUNÇÃO PARA LISTAR OS FUNCIONÁRIOS)
    function updateTableWithFilters(nome, status){
      $.ajax({
        url: 'table.php',
        method: 'POST',
        data: {
          nome,
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
      let nome = $("#nome-filter").val();
      let status = $("#status-filter").val();

      updateTableWithFilters(nome, status);
    }

    $(document).ready(function(){
      applyFilters();
    });
  </script>
</body>

</html>