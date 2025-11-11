<?php 
    // STARTING SESSION
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

            <?php 
              $sql = "
                SELECT id, cpf, nome_completo, data_nascimento, telefone1, sexo, status
                FROM
                cliente;
              ";

              $query = mysqli_query($conexao, $sql);
              if (mysqli_num_rows($query) > 0) {
            ?>

              <div class="card-body">
                <div class="row">
                  <!-- CAMPO DE BUSCA -->
                  <div class="col-4">
                    <form method="post">
                      <input type="search" name="pesquisa" id="pesquisa" class="form-control"  placeholder="Nome do cliente">
                    </form>
                  </div>

                  <div class="col-2">
                    <form method="post">
                      <select name="status" id="status" class="form-control">
                        <option value="">Status</option>
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                      </select>
                    </form>
                  </div>
                </div>
              </div>

              <div class="card-body p-0">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">CPF</th>
                      <th scope="col">Nome Completo</th>
                      <th scope="col">Telefone</th>
                      <th scope="col">Sexo</th>
                      <th scope="col">Data Nascimento</th>
                      <th scope="col">Status</th>
                      <th scope="col">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($query as $cliente) { ?>
                    <tr>
                      <td><?php echo $cliente['id'] ?></td>
                      <td><?php echo $cliente['cpf'] ?></td>
                      <td><?php echo $cliente['nome_completo'] ?></td>
                      <td><?php echo $cliente['telefone1'] ?></td>
                      <td><?php echo $cliente['sexo'] ?></td>
                      <td><?php echo $cliente['data_nascimento'] ?></td>
                      <td>
                        <?php 
                          if ($cliente['status'] == 0){
                            echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                          } else {
                            echo '<span class="badge badge-pill badge-success">Ativo</span>';
                          }
                        ?>
                      </td>
                      <td>
                        <a href="edit.php?id=<?php echo $cliente['id'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="acoes.php" method="post" class="d-inline">
                          <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_cliente" value="<?php echo $cliente['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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

  <!-- BOOTSTRAP JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>