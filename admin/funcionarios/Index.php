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
              <h4 class="m-0">Funcionários</h4>
              
              <a href="inserir.php" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Adicionar</a>
            </div>

            <div class="card-body">
              <div class="row">
                <!-- CAMPO DE BUSCA -->
                <div class="col-4">
                  <form action="">
                    <input type="search" name="pesquisa" id="pesquisa" class="form-control"  placeholder="Nome do funcionário">
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
                <div class="col-2">
                  <form action="">
                    <select name="sexo" id="sexo" class="form-control">
                      <option value="T">Sexo</option>
                      <option value="N">Não Informado</option>
                      <option value="M">Masculino</option>
                      <option value="F">Feminino</option>
                    </select>
                </div>
                <div class="col-2">
                  <form action="">
                    <select name="tipo-acesso" id="tipo-acesso" class="form-control">
                      <option value="">Tipo de acesso</option>
                      <option value="administrador">Administrador</option>
                      <option value="normal">Normal</option>
                    </select>
                </div>
                <div class="col-2">
                  <form action="">
                    <select name="cargo" id="cargo" class="form-control">
                      <option value="">Cargo</option>
                      <option value="gerente">Gerente</option>
                      <option value="vendedor">Vendedor</option>
                      <option value="estoquista">Estoquista</option>
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
                    <th scope="col">Cargo</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Salário</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">Tipo Acesso</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Email</th>
                    <th scope="col">Data Cadastro</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>João Silva</td>
                    <td>Analista</td>
                    <td>123.456.789-00</td>
                    <td>R$ 4.500,00</td>
                    <td>M</td>
                    <td>15/03/1990</td>
                    <td>Administrador</td>
                    <td>(11) 91234-5678</td>
                    <td>joao.silva@email.com</td>
                    <td>10/09/2024</td>
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
                    <td>1</td>
                    <td>João Silva</td>
                    <td>Analista</td>
                    <td>123.456.789-00</td>
                    <td>R$ 4.500,00</td>
                    <td>M</td>
                    <td>15/03/1990</td>
                    <td>Administrador</td>
                    <td>(11) 91234-5678</td>
                    <td>joao.silva@email.com</td>
                    <td>10/09/2024</td>
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
                    <td>1</td>
                    <td>João Silva</td>
                    <td>Analista</td>
                    <td>123.456.789-00</td>
                    <td>R$ 4.500,00</td>
                    <td>M</td>
                    <td>15/03/1990</td>
                    <td>Administrador</td>
                    <td>(11) 91234-5678</td>
                    <td>joao.silva@email.com</td>
                    <td>10/09/2024</td>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>