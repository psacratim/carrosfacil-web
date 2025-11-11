<?php 
    if (!isset($_SESSION)){
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../assets/css/dashboard.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
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
            <div class="card-header d-flex justify-content-between">
              <h4 class="m-0 lh-base">Cargos</h4>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cargosModal">
                Adicionar
              </button>
            </div>

            <!-- MODAL CADASTRO -->
            <div class="modal fade" id="cargosModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cargosModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cargosModalLabel">Cadastrar Cargo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <form action="actions.php" method="post" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-12 mb-3">
                          <label for="nome-cargo"><strong class="text-danger">*</strong> Nome do cargo:</label>
                          <input type="text" name="nome-cargo" id="nome-cargo" class="form-control" maxlength="60" required placeholder="Ex: Vendedor externo">
                        </div>

                        <div class="col-12">
                          <label for="status">Status</label>
                          <select name="status" id="status" class="form-control" disabled>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                          </select>
                        </div>
                        <div class="col-12 mt-3">
                          <label for="observacao">Observação</label>
                          <textarea name="observacao" id="observacao" placeholder="Ex: Vendedores externos visitam os clientes em suas casas para vender." maxlength="250" class="form-control" placeholder="Ex: O vendedor externo vai até a casa dos clientes para fazer vendas."></textarea>
                        </div>
                      </div>

                      <hr>
                      <input type="hidden" name="cadastrar" value="cadastrar_cargo">
                      <input type="submit" class="btn btn-primary btn-block" value="Cadastrar">
                    </form>
                    <button class="btn btn-danger btn-block mt-2" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>

            <?php 
              $sql = "SELECT id, nome, observacao, data_cadastro, status FROM cargo;";
              $query = mysqli_query($conexao, $sql);

              if (mysqli_num_rows($query) > 0) {
            ?>

            <div class="card-body">
              <div class="row">
                <div class="col-4">
                  <form action="">
                    <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Nome do cargo">
                  </form>
                </div>
              </div>
            </div>

            <div class="card-body p-0">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Observação</th>
                    <th>Data Cadastro</th>
                    <th>Status</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($query as $cargo) { ?>
                    <tr>
                      <td><?php echo $cargo['id'] ?></td>
                      <td><?php echo htmlspecialchars($cargo['nome']); ?></td>
                      <td><?php echo ($cargo['observacao'] == "" ? "Nenhuma observação" : $cargo['observacao']) ?></td>
                      <td><?php echo date('d/m/Y', strtotime($cargo['data_cadastro'])) ?></td>
                      <td>
                        <?php 
                          if ($cargo['status'] == 0){
                            echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                          } else {
                            echo '<span class="badge badge-pill badge-success">Ativo</span>';
                          }
                        ?>
                      </td>
                      <td>
                        <button type="button" 
                                class="btn btn-outline-success btn-sm editar-btn d-inline"
                                data-id="<?php echo $cargo['id']; ?>"
                                data-nome="<?php echo htmlspecialchars($cargo['nome']); ?>"
                                data-observacao="<?php echo htmlspecialchars($cargo['observacao']); ?>"
                                data-icone="<?php echo htmlspecialchars($cargo['icone']); ?>"
                                data-status="<?php echo $cargo['status']; ?>"
                                title="Editar">
                          <i class="bi bi-pencil-square"></i>
                        </button>

                        <form action="actions.php" method="post" class="d-inline">
                          <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_cargo" value="<?php echo $cargo['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                            <i class="bi bi-trash3"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
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

  <!-- MODAL EDIÇÃO -->
  <div class="modal fade" id="editarCargoModal" tabindex="-1" aria-labelledby="editarCargoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editarCargoModalLabel">Editar Cargo</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="actions.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" id="edit_id">

            <div class="form-group mb-3">
              <label for="edit_nome"><strong class="text-danger">*</strong> Nome do cargo:</label>
              <input type="text" name="edit_nome" id="edit_nome" class="form-control" maxlength="60" required>
            </div>

            <div class="form-group mb-3">
              <label for="edit_observacao"><strong class="text-danger">*</strong> Observação:</label>
              <input type="text" name="edit_observacao" id="edit_observacao" class="form-control" maxlength="60">
            </div>

            <div class="form-group mb-3">
              <label for="edit_status"><strong class="text-danger">*</strong> Status:</label>
              <select name="edit_status" id="edit_status" class="form-control">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
              </select>
            </div>

            <input type="hidden" name="atualizar" value="atualizar_cargo">
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

  <!-- CUSTOM SCRIPTS -->
  <script>
    // Preview do ícone no cadastro
    $('#icone-acessorio').change(function(e) {
      let file = this.files[0];
      if (file) {
        let reader = new FileReader();
        reader.onload = function(event) {
          $("#icone-img").attr("src", event.target.result);
        };
        reader.readAsDataURL(file);
      }
    });

    // Preencher modal de edição
    $(document).on('click', '.editar-btn', function() {
      const id = $(this).data('id');
      const nome = $(this).data('nome');
      const observacao = $(this).data('observacao');
      const status = $(this).data('status');

      $('#edit_id').val(id);
      $('#edit_nome').val(nome);
      $('#edit_observacao').val(observacao);
      $('#edit_status').val(status);

      $('#editarCargoModal').modal('show');
    });

    // Preview do ícone novo no modal de edição
    $('#edit_icone').change(function(e) {
      let file = this.files[0];
      if (file) {
        let reader = new FileReader();
        reader.onload = function(event) {
          $("#edit_icone_preview").attr("src", event.target.result);
        };
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>
</html>
