<?php 
    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

  require_once("../../conexao/conecta.php")
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
        ?>

        <div class="container mt-5">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h4 class="m-0">Novo Veiculo</h4>

              <a href="Index.php" class="btn btn-primary btn-sm"><i class="bi bi-arrow-left-short"></i> Voltar</a>
            </div>

            <div class="card-body">
              <form action="acoes.php" method="post">
                <div class="form-row">

                  <fieldset class="form-group col-12">
                    <h3 class="mt-2">Dados sobre vendas:</h3>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="vendedor"><strong class="text-danger">*</strong> Vendedor:</label>
                        <select name="vendedor" id="vendedor" class="form-control" required>
                          <?php 
                            $sql = 'SELECT id, nome_completo FROM cliente WHERE status = 1;';
                            $query = mysqli_execute_query($conexao, $sql);

                            foreach ($query as $cliente) {
                              echo '<option value="'. $cliente['id'] .'">'. $cliente['nome_completo'] .'</option>';
                            }
                          ?>
                        </select>
                      </div>

                      <div class="col-md-3">
                        <label for="preco"><strong class="text-danger">*</strong> Preço:</label>
                        <input type="text" name="preco" id="preco" class="form-control" data-mask="#.##0,00" data-mask-reverse="true">
                      </div>
                      
                      <div class="col-md-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" disabled>
                          <option value="1">Ativo</option>
                          <option value="0">Inativo</option>
                        </select>
                      </div>
                    </div>
                  </fieldset>

                  <fieldset class="form-group col-lg-12 mt-3">
                    <h3>Dados do veículo:</h3>
                    <div class="row">
                      <div class="col-md-3">
                        <label for="modelo"><strong class="text-danger">*</strong> Modelo:</label>
                        <select name="modelo" id="modelo" class="form-control" required>
                          <?php 
                            $sql = 'SELECT id, nome FROM modelo WHERE status = 1;';
                            $query = mysqli_execute_query($conexao, $sql);

                            foreach ($query as $modelo) {
                              echo '<option value="'. $modelo['id'] .'">'. $modelo['nome'] .'</option>';
                            }
                          ?>
                        </select>
                      </div>

                      <div class="col-md-3">
                        <label for="categoria"><strong class="text-danger">*</strong> Categoria:</label>
                        <select name="categoria" id="categoria" class="form-control" required>
                          <option value=""></option>
                        </select>
                      </div>
                  </fieldset>

                  

                  <fieldset class="form-group col-lg-12 mt-3">
                    <h3>Dados do endereço</h3>
                    <div class="row">
                      <div class="col-lg-2 col-md-3 mt-3">
                        <label for="cep">CEP</label>
                        <input type="text" name="cep" id="cep" class="form-control" maxlength="10" data-mask="00000-000">
                      </div>

                      <div class="col-lg-4 col-md-7 mt-3">
                        <label for="endereco"><strong class="text-danger">*</strong> Endereço</label>
                        <input type="text" name="endereco" id="endereco" class="form-control" maxlength="60" required>
                      </div>

                      <div class="col-lg-2 col-md-2 mt-3">
                        <label for="numero-endereco"><strong class="text-danger">*</strong> Número</label>
                        <input type="number" name="numero-endereco" id="numero-endereco" class="form-control" min="1" max="99999" required>
                      </div>

                      <div class="col-lg-4 col-md-6 mt-3">
                        <label for="bairro"><strong class="text-danger">*</strong> Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="form-control" maxlength="32" required>
                      </div>

                      <div class="col-lg-5 col-md-6 mt-3">
                        <label for="cidade"><strong class="text-danger">*</strong> Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" maxlength="50" required>
                      </div>

                      <div class="col-lg-2 col-md-6 mt-3">
                        <label for="estado"><strong class="text-danger">*</strong> Estado</label>

                        <select name="estado" id="estado" class="form-control" required>
                          <option value="AC">Acre</option>
                          <option value="AL">Alagoas</option>
                          <option value="AP">Amapá</option>
                          <option value="AM">Amazonas</option>
                          <option value="BA">Bahia</option>
                          <option value="CE">Ceará</option>
                          <option value="DF">Distrito Federal</option>
                          <option value="ES">Espírito Santo</option>
                          <option value="GO">Goiás</option>
                          <option value="MA">Maranhão</option>
                          <option value="MT">Mato Grosso</option>
                          <option value="MS">Mato Grosso do Sul</option>
                          <option value="MG">Minas Gerais</option>
                          <option value="PA">Pará</option>
                          <option value="PB">Paraíba</option>
                          <option value="PR">Paraná</option>
                          <option value="PE">Pernambuco</option>
                          <option value="PI">Piauí</option>
                          <option value="RJ">Rio de Janeiro</option>
                          <option value="RN">Rio Grande do Norte</option>
                          <option value="RS">Rio Grande do Sul</option>
                          <option value="RO">Rondônia</option>
                          <option value="RR">Roraima</option>
                          <option value="SC">Santa Catarina</option>
                          <option value="SP" selected>São Paulo</option>
                          <option value="SE">Sergipe</option>
                          <option value="TO">Tocantins</option>
                        </select>
                      </div>

                      <div class="col-lg-5 col-md-6 mt-3">
                        <label for="complemento">Complemento</label>
                        <input type="text" name="complemento" id="complemento" class="form-control" maxlength="200">
                        </input>
                      </div>
                    </div>
                  </fieldset>


                  <input type="hidden" name="cadastrar" value="cadastrar_veiculo" class="btn btn-primary mt-3">
                  <input type="submit" value="Cadastrar" class="btn btn-primary mt-3">
                </div>
              </form>
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
  
  <!-- JS MASK -->
  <script src="../../assets/js/jquery.mask.js"></script>
  <script src="../../assets/js/mascaras.js"></script>
  
</body>

</html>