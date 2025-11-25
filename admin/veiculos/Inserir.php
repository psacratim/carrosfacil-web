<?php
// STARTING SESSION
if (!isset($_SESSION)) {
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
  <link rel="stylesheet" href="../../custom/css/insert-vehicle.css">
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

            <button type="button" id="preencher-veiculo" class="btn btn-warning mt-2">
              Preencher com dados aleatórios
            </button>

            <div class="card-body">
              <form action="acoes.php" method="post" enctype="multipart/form-data">
                <fieldset class="form-fs row">
                  <div class="title">Identificação do veículo</div>
                  <div class="col-md-4 mt-2 fs-container ">
                    <label for="modelo">Modelo <strong class="text-danger">*</strong></label>
                    <select name="modelo" id="modelo" class="form-select" required>
                      <option value="none" selected>- Nenhum Selecionado -</option>
                      <?php
                      $sql = 'SELECT id, nome FROM modelo;';
                      $query = mysqli_execute_query($conexao, $sql);

                      foreach ($query as $modelo) {
                        echo '<option value="' . $modelo['id'] . '">' . $modelo['nome'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-5 mt-2 fs-container ">
                    <label for="categoria">Categoria <strong class="text-danger">*</strong></label>
                    <select required name="categoria" id="categoria" class="form-select">
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
                  <div class="col-md-3 mt-2 fs-container ">
                    <label for="cor">Cor <strong class="text-danger">*</strong></label>
                    <select required name="cor" id="cor" class="form-select">
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
                </fieldset>
                <hr>
                <fieldset class="form-fs row">
                  <div class="title">Informações básicas</div>
                  <div class="col-md-5 mt-2 fs-container ">
                    <label for="estado">Estado do Veículo <strong class="text-danger">*</strong></label>
                    <select required name="estado" id="estado" class="form-select">
                      <option value="none" selected>- Nenhum Selecionado -</option>
                      <option value="Novo">Novo</option>
                      <option value="Semi-novo">Semi-novo</option>
                      <option value="Usado">Usado</option>
                    </select>
                  </div>
                  <div class="col-md-2 mt-2 fs-container">
                    <label for="ano">Ano <strong class="text-danger">*</strong></label>
                    <input required type="text" name="ano" id="ano" class="form-control" maxlength="4" placeholder="Ex: 2025">
                  </div>
                  <div class="col-md-3 mt-2 fs-container">
                    <label for="final_placa">Final da placa <strong class="text-danger">*</strong></label>
                    <input required type="text" name="final_placa" id="final_placa" class="form-control" maxlength="1" placeholder="Ex: 1">
                  </div>
                  <div class="col-md-2 mt-2 fs-container">
                    <label for="estoque">Estoque <strong class="text-danger">*</strong></label>
                    <input type="text" name="estoque" id="estoque" class="form-control" data-mask="#" data-mask-reverse="true" maxlength="5" placeholder="Ex: 20">
                  </div>
                  <div class="col-md-3 mt-2 fs-container">
                    <label for="quilometragem">Quilômetragem <strong class="text-danger">*</strong></label>
                    <input required type="text" name="quilometragem" id="quilometragem" class="form-control" maxlength="7" placeholder="0">
                  </div>
                  <div class="col-md-3 mt-2 fs-container">
                    <label for="tempo_usado">Tempo de uso <strong class="text-danger">*</strong></label>
                    <input required type="text" name="tempo_usado" id="tempo_usado" class="form-control" maxlength="5" placeholder="0">
                  </div>
                  <div class="col-md-3 mt-2 fs-container">
                    <label for="tipo_combustivel">Tipo de combustivel <strong class="text-danger">*</strong></label>
                    <select required name="tipo_combustivel" id="tipo_combustivel" class="form-control">
                      <option value="Gasolina">Gasolina</option>
                      <option value="Etanol">Etanol</option>
                      <option value="Flex">Flex</option>
                      <option value="Diesel">Diesel</option>
                      <option value="Elétrico">Elétrico</option>
                      <option value="GNV (Gás Natural Veicular)">GNV (Gás Natural Veicular)</option>
                    </select>
                  </div>
                  <div class="col-md-3 mt-2 fs-container">
                    <label for="tipo_cambio">Tipo de câmbio <strong class="text-danger">*</strong></label>

                    <select required name="tipo_cambio" id="tipo_cambio" class="form-control">
                      <option value="Manual">Manual</option>
                      <option value="Automático T.">Automático Tradicional</option>
                      <option value="CVT">CVT</option>
                      <option value="Automático Monoembreagem">Automatizado (Monoembreagem)</option>
                      <option value="DCT">DCT (Automático de Dupla Embreagem)</option>
                    </select>
                  </div>
                </fieldset>
                <hr>
                <fieldset class="form-fs row">
                  <div class="title">Valores</div>
                  <div class="col-md-4 mt-2 fs-container">
                    <label for="preco_custo">Preço Custo <strong class="text-danger">*</strong></label>
                    <input required type="text" name="preco_custo" id="preco_custo" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" maxlength="13" placeholder="R$0,00">
                  </div>

                  <div class="col-md-4 mt-2 fs-container">
                    <label for="lucro_esperado">Lucro (%) <strong class="text-danger">*</strong></label>
                    <input required type="text" name="lucro_esperado" id="lucro_esperado" class="form-control" data-mask="#" data-mask-reverse="true" maxlength="5" placeholder="0">
                  </div>

                  <div class="col-md-4 mt-2 fs-container">
                    <label for="desconto">Desconto (%) <strong class="text-danger">*</strong></label>
                    <input type="text" name="desconto" id="desconto" class="form-control" data-mask="#" data-mask-reverse="true" placeholder="0">
                  </div>

                  <div class="col-md-6 mt-2 fs-container">
                    <label for="preco_venda">Preço Venda <strong class="text-danger">*</strong></label>
                    <input readonly required type="text" name="preco_venda" id="preco_venda" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" maxlength="13" placeholder="R$0,00">
                  </div>

                  <div class="col-md-6 mt-2 fs-container">
                    <label for="preco_desconto">Preço Desconto <strong class="text-danger">*</strong></label>
                    <input readonly required type="text" name="preco_desconto" id="preco_desconto" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" maxlength="13" placeholder="R$0,00">
                  </div>
                </fieldset>
                <hr>
                <fieldset class="form-fs row">
                  <div class="title">Descrição</div>
                  <div class="col-md-12 mt-2 fs-container">
                    <label for="descricao">Descrição do anúncio <strong class="text-danger">*</strong></label>
                    <textarea type="text" name="descricao" id="descricao" class="form-control" maxlength="250" placeholder="Descreva as características do veículo, estado de conservação e diferenciais."></textarea>
                  </div>
                </fieldset>
                <hr>

                <fieldset class="form-fs row">
                  <div class="title text-center">Foto Principal</div>
                  <div class="col-md-12 mt-2 fs-container h-100">
                    <div class="image-preview h-100 mx-auto d-flex flex-wrap justify-content-center align-content-center text-center">
                      <div id="veiculo-foto-preview" class="image-preview-empty h-100">
                        <i class="bi bi-card-image"></i>

                        <h3 class="w-100">Adicionar foto do veículo</h3>
                        <p class="w-100">Selecione uma imagem do veículo</p>
                      </div>
                      <img required id="foto-veiculo" style="display: none;" src="" alt="">
                    </div>


                    <input type="file" name="foto-veiculo-input" id="foto-veiculo-input" class="form-control mt-3 mx-auto w-50" accept="image/*" required>
                  </div>
                </fieldset>
                <hr>
                <fieldset class="form-fs row">
                  <div class="col-md-12 fs-container">
                    <input type="hidden" name="cadastrar" value="cadastrar_veiculo" class="btn btn-primary mt-3">
                    <input type="submit" value="Cadastrar" class="btn btn-primary w-100">
                  </div>
                </fieldset>
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

  <!-- DELETAR DEPOIS ESSE CÓDIGO ABAIXO (TODO) -->
  <script>
    $('#preencher-veiculo').on('click', function() {

      function rand(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
      }

      const categorias = [
        "Hatchback", "Sedan", "SUV", "Crossover", "Compacto",
        "Esportivo", "Pickup", "Off-Road / 4x4"
      ];

      const cores = [
        "Branco", "Preto", "Prata", "Cinza", "Vermelho", "Azul", "Verde", "Amarelo", "Marrom"
      ];

      const combustiveis = [
        "Gasolina", "Etanol", "Flex", "Diesel", "Elétrico", "GNV (Gás Natural Veicular)"
      ];

      const cambios = [
        "Manual", "Automático T.", "CVT", "Automático Monoembreagem", "DCT"
      ];

      // Modelo → Seleciona qualquer um que exista
      $('#modelo').prop('selectedIndex', rand(1, $('#modelo option').length - 1));

      // Categoria
      $('#categoria').val(categorias[rand(0, categorias.length - 1)]);

      // Cor
      $('#cor').val(cores[rand(0, cores.length - 1)]);

      // Estado do veículo
      $('#estado').val(['Novo', 'Semi-novo', 'Usado'][rand(0, 2)]);

      // Ano
      $('#ano').val(rand(2005, 2024));

      // Final da placa
      $('#final_placa').val(rand(0, 9));

      // Estoque
      $('#estoque').val(rand(1, 15));

      // Km rodado
      $('#quilometragem').val(rand(0, 180000));

      // Tempo de uso (dias)
      $('#tempo_usado').val(rand(1, 2000));

      // Tipo combustivel
      $('#tipo_combustivel').val(combustiveis[rand(0, combustiveis.length - 1)]);

      // Tipo de câmbio
      $('#tipo_cambio').val(cambios[rand(0, cambios.length - 1)]);

      // Valores:
      // preço custo: 15.000 a 250.000 (rand bruto)
      let precoCusto = rand(15000, 250000);
      let lucro = rand(5, 35); // %
      let precoVenda = precoCusto + (precoCusto * (lucro / 100));

      // opcional desconto
      let desconto = rand(0, 10); // %
      let precoComDesconto = precoVenda - (precoVenda * (desconto / 100));

      $('#preco_custo').val(precoCusto.toFixed(2));
      $('#lucro_esperado').val(lucro);
      $('#desconto').val(desconto);
      $('#preco_venda').val(precoVenda.toFixed(2));
      $('#preco_desconto').val(precoComDesconto.toFixed(2));

      // Descrição
      $('#descricao').val(
        "Veículo em excelente estado. Revisões em dia. " +
        "Sem detalhes relevantes. Ótimo custo-benefício."
      );

      console.log("✅ Formulário de veículo preenchido automaticamente.");
    });
  </script>

</body>

</html>