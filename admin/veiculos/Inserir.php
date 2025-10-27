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
          include('../Mensagem.php');
        ?>

        <div class="container mt-5">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h4 class="m-0">Novo Veiculo</h4>

              <a href="Index.php" class="btn btn-primary btn-sm"><i class="bi bi-arrow-left-short"></i> Voltar</a>
            </div>

            <div class="card-body">
              <form action="acoes.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                  <fieldset class="form-group col-lg-12">
                    <div class="row">
                      <div class="col-12 mb-3 text-center">
                        <label for="foto-veiculo">Foto do Veículo</label>

                        <div>
                          <img id="foto-img" src="../../assets/img/placeholder-veiculo.avif" alt="" class="rounded-3">
                        </div>

                        <input type="file" name="foto-veiculo" id="foto-veiculo" class="form-control mt-3 mx-auto w-50" accept="image/*">
                      </div>

                      <div class="col-md-2">
                        <label for="id_veiculo"><strong class="text-danger">*</strong> ID:</label>
                        <input type="text" name="id_veiculo" id="id_veiculo" class="form-control" maxlength="11" value="0" required disabled>
                      </div>

                      <div class="col-md-2">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" disabled>
                          <option value="1">Ativo</option>
                          <option value="0">Inativo</option>
                        </select>
                      </div>

                      <div class="col-md-2">
                        <label for="data_cadastro">Data de Cadastro:</label>
                        <input disabled type="date" name="data_cadastro" id="data_cadastro" class="form-control" value="1000-01-01">
                      </div>

                      <div class="col-md-3">
                        <label for="modelo"><strong class="text-danger">*</strong> Modelo:</label>
                        <select name="modelo" id="modelo" class="form-control" required>
                          <option value="none" selected>- Nenhum Selecionado -</option>
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
                          <option value="none" selected>- Nenhum Selecionado -</option>
                          <option value="Hatchback">Hatchback</option>
                          <option value="Sedan">Sedan</option>
                          <option value="SUV">SUV</option>
                          <option value="Crossover">Crossover</option>
                          <option value="Cupê">Cupê</option>
                          <option value="Conversível">Conversível</option>
                          <option value="Perua / Station Wagon">Perua / Station Wagon</option>
                          <option value="Roadster">Roadster</option>
                          <option value="Esportivo">Esportivo</option>
                          <option value="Compacto">Compacto</option>
                          <option value="Minivan">Minivan</option>
                          <option value="Pickup">Pickup</option>

                          <option value="Van">Van</option>
                          <option value="Furgão">Furgão</option>
                          <option value="Caminhonete">Caminhonete</option>

                          <option value="Superesportivo">Superesportivo</option>
                          <option value="Luxo / Premium">Luxo / Premium</option>
                          <option value="Gran Turismo (GT)">Gran Turismo (GT)</option>
                          <option value="Conversível Esportivo">Conversível Esportivo</option>

                          <option value="Caminhão Leve">Caminhão Leve</option>
                          <option value="Caminhão Médio">Caminhão Médio</option>
                          <option value="Caminhão Pesado">Caminhão Pesado</option>
                          <option value="Carreta">Carreta</option>

                          <option value="Motocicleta">Motocicleta</option>
                          <option value="Scooter">Scooter</option>
                          <option value="Triciclo">Triciclo</option>
                          <option value="Quadriciclo">Quadriciclo</option>

                          <option value="Buggy">Buggy</option>
                          <option value="Off-Road / 4x4">Off-Road / 4x4</option>
                          <option value="Motorhome">Motorhome</option>
                        </select>
                      </div>

                      <div class="col-md-2 mt-3">
                        <label for="estado"><strong class="text-danger">*</strong> Estado do veículo:</label>
                        <select name="estado" id="estado" class="form-control" required>
                          <option value="Novo">Novo</option>
                          <option value="Usado">Semi-novo</option>
                          <option value="Usado">Usado</option>
                        </select>
                      </div>

                      <div class="col-md-2 mt-3">
                        <label for="tempo_uso"><strong class="text-danger">*</strong> Tempo de uso:</label>
                        <input type="text" name="tempo_uso" id="tempo_uso" class="form-control" maxlength="5" required>
                      </div>

                      <div class="col-md-2 mt-3">
                        <label for="kms_rodados"><strong class="text-danger">*</strong> KMs rodado:</label>
                        <input type="text" name="kms_rodados" id="kms_rodados" class="form-control" maxlength="7" required>
                      </div>

                      <div class="col-md-2 mt-3">
                        <label for="final_placa"><strong class="text-danger">*</strong> Final da placa:</label>
                        <input type="text" name="final_placa" id="final_placa" class="form-control" maxlength="1" required>
                      </div>

                      <div class="col-md-2 mt-3">
                        <label for="cor"><strong class="text-danger">*</strong> Cor principal:</label>
                        <select name="cor" id="cor" class="form-control" required>
                          <option value="Branco">Branco</option>
                          <option value="Preto">Preto</option>
                          <option value="Prata">Prata</option>
                          <option value="Cinza">Cinza</option>
                          <option value="Vermelho">Vermelho</option>
                          <option value="Azul">Azul</option>
                          <option value="Verde">Verde</option>
                          <option value="Amarelo">Amarelo</option>
                          <option value="Laranja">Laranja</option>
                          <option value="Marrom">Marrom</option>
                          <option value="Bege">Bege</option>
                          <option value="Bordo">Bordo</option>
                          <option value="Dourado">Dourado</option>
                          <option value="Roxo">Roxo</option>
                          <option value="Rosa">Rosa</option>
                          <option value="Grafite">Grafite</option>
                          <option value="Champagne">Champagne</option>
                          <option value="Vinho">Vinho</option>
                        </select>
                      </div>

                      <div class="col-md-2 mt-3">
                        <label for="ano"><strong class="text-danger">*</strong> Ano do carro:</label>
                        <input type="text" name="ano" id="ano" class="form-control" maxlength="4" required>
                      </div>

                      <div class="col-md-3 mt-3">
                        <label for="tipo_combustivel"><strong class="text-danger">*</strong> Tipo de combustível/energia:</label>
                        <select name="tipo_combustivel" id="tipo_combustivel" class="form-control" required>
                          <option value="none" selected>- Nenhum Selecionado -</option>
                          <option value="Gasolina">Gasolina</option>
                          <option value="Etanol">Etanol</option>
                          <option value="Flex">Flex</option>
                          <option value="Diesel">Diesel</option>
                          <option value="Elétrico">Elétrico</option>
                          <option value="Gás Natural Veicular (GNV)">Gás Natural Veicular (GNV)</option>
                        </select>
                      </div>

                      <div class="col-md-3 mt-3">
                        <label for="tipo_cambio"><strong class="text-danger">*</strong> Tipo de câmbio:</label>
                        <select name="tipo_cambio" id="tipo_cambio" class="form-control" required>
                          <option value="none" selected>- Nenhum Selecionado -</option>
                          <option value="Manual">Manual</option>
                          <option value="Automático Tradicional">Automático Tradicional</option>
                          <option value="CVT (Transmissão Continuamente Variável)">CVT (Transmissão Continuamente Variável)</option>
                          <option value="Automatizado (Monoembreagem)">Automatizado (Monoembreagem)</option>
                          <option value="Automático de Dupla Embreagem (DCT)">Automático de Dupla Embreagem (DCT)</option>
                        </select>
                      </div>

                      <div class="col-md-3 mt-3">
                        <label for="estoque"><strong class="text-danger">*</strong> Estoque:</label>
                        <input type="text" name="estoque" id="estoque" class="form-control" data-mask="#" data-mask-reverse="true">
                      </div>

                      <div class="col-md-3 mt-3">
                        <label for="custo"><strong class="text-danger">*</strong> Custo:</label>
                        <input type="text" name="custo" id="custo" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" maxlength="13">
                      </div>

                      <div class="col-md-3 mt-3">
                        <label for="lucro_esperado"><strong class="text-danger">*</strong> Lucro desejado (%):</label>
                        <input type="text" name="lucro_esperado" id="lucro_esperado" class="form-control" data-mask="#" data-mask-reverse="true" maxlength="5">
                      </div>
                      <div class="col-md-3 mt-3">
                        <label for="desconto"><strong class="text-danger">*</strong> Promoção (%):</label>
                        <input type="text" name="desconto" id="desconto" class="form-control" data-mask="#" data-mask-reverse="true">
                      </div>

                      <div class="col-md-3 mt-3">
                        <label for="preco_final"><strong class="text-danger">*</strong> Preço de Venda:</label>
                        <input disabled type="text" name="preco_final" id="preco_final" class="form-control" data-mask="#" data-mask-reverse="true" required>
                      </div>

                      <div class="form-group mt-3">
                          <label for="descricao">Descrição:</label>
                          <textarea type="text" name="descricao" id="descricao" class="form-control" maxlength="250"></textarea>
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
  <script src="../../assets/js/register-vehicle-form-extras.js"></script>
  
</body>

</html>