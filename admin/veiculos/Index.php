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
        ?>

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
                    <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Nome da acessorio">
                  </form>
                </div>
              </div>
            </div>

            <div class="card-body p-0">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Categoria</th> <!-- SUVs, Esportivo -->
                    <th scope="col">Tipo</th> <!-- Usado, Novo -->
                    <!-- <th scope="col">Vendedor</th> Loja ou Revendedor: Se o estoque for 0, é revendedor vendendo seu próprio carro, caso seja mais que 0, é a loja oficial. -->
                    <th scope="col">Preço</th>
                    <th scope="col">Estoque</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>  
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>BMW M4</td>
                    <td>Esportivo</td>
                    <td>Novo</td>
                    <td>R$ 12.958.571</td>
                    <td>1</td>
                    <td><span class="badge badge-pill badge-success">Disponível</span></td>
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
                    <td>BMW M4</td>
                    <td>Esportivo</td>
                    <td>Novo</td>
                    <td>R$ 12.958,57</td>
                    <td>1</td>
                    <td><span class="badge badge-pill badge-success">Disponível</span></td>
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
                    <td>BMW M4</td>
                    <td>Esportivo</td>
                    <td>Novo</td>
                    <td>R$ 12.958.571</td>
                    <td>1</td>
                    <td><span class="badge badge-pill badge-success">Disponível</span></td>
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

  <!-- CUSTOM SCRIPTS -->
  <script>
    $('#icone-acessorio').change(function(e) {
        let file = this.files[0]; // ou $(this)[0].files[0]
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $("#icone-img").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
  </script>
</body>

</html>