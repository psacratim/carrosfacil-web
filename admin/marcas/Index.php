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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Painel Administrativo</h1>
          <h2 class="h3">Olá, USUÁRIO!</h2>
        </div>

        <div class="container mt-5">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h4 class="m-0 lh-base">Marca</h4>
              
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#marcaModal"> 
                Adicionar
              </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="marcaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="marcaModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="marcaModalLabel">Cadastrar Marca</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-12 mb-3">
                        <label for="nome"><strong class="text-danger">*</strong> Nome da marca:</label>
                        <input type="text" name="nome" id="nome" class="form-control" maxlength="60" required>
                      </div>
                      
                      <div class="col-12">
                        <label for="status"><strong class="text-danger">*</strong> Status:</label>
                        <select name="status" id="status" class="form-control" disabled>
                          <option value="1">Ativo</option>
                          <option value="0">Inativo</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Cadastrar</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="row">
                <!-- CAMPO DE BUSCA -->
                <div class="col-4">
                  <form action="">
                    <input type="search" name="pesquisa" id="pesquisa" class="form-control"  placeholder="Nome da marca">
                  </form>
                </div>

                <div class="col-2">
                  <form action="">
                    <select name="status" id="status" class="form-control">
                      <option value="">Status</option>
                      <option value="1">Ativo</option>
                      <option value="0">Inativo</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="card-body p-0">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Data Cadastro</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>BMW</td>
                    <td>29/09/2025</td>
                    <td><span class="badge badge-pill badge-success">Ativo</span></td>
                    <td>
                      <a href="#" class="btn btn-outline-success btn-sm" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      <a href="#" class="btn btn-outline-danger btn-sm" title="Excluir">
                        <i class="bi bi-trash3"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Ferrari</td>
                    <td>29/09/2025</td>
                    <td><span class="badge badge-pill badge-success">Ativo</span></td>
                    <td>
                      <a href="#" class="btn btn-outline-success btn-sm" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      <a href="#" class="btn btn-outline-danger btn-sm" title="Excluir">
                        <i class="bi bi-trash3"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Fiat</td>
                    <td>29/09/2025</td>
                    <td><span class="badge badge-pill badge-danger">Inativo</span></td>
                    <td>
                      <a href="#" class="btn btn-outline-success btn-sm" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      <a href="#" class="btn btn-outline-danger btn-sm" title="Excluir">
                        <i class="bi bi-trash3"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </main>
    </div>
  </div>

  <!-- BOOTSTRAP JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body> 
</html>