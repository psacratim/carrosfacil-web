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
          <?php 
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $id = $_GET['id'];

                $sql = "SELECT * FROM veiculo WHERE id=$id";
                $query = mysqli_execute_query($conexao, $sql);
                $veiculo = mysqli_fetch_assoc($query);
          ?>
            <div class="card">
              <div class="card-header d-flex justify-content-between">
                <h4 class="m-0">Editar Veiculo</h4>

                <a href="Index.php" class="btn btn-primary btn-sm"><i class="bi bi-arrow-left-short"></i> Voltar</a>
              </div>

              <div class="card-body">
                <form action="acoes.php" method="post" enctype="multipart/form-data">
                  <fieldset class="form-fs row">
                    <div class="title">Identificação do veículo</div>
                      <div class="col-md-12">
                        <input hidden type="text" name="id" id="id" class="form-control" maxlength="60" required value="<?php echo $veiculo ['id'] ?>">
                      </div>
                    <div class="col-md-4 mt-2 fs-container ">
                      <label for="modelo">Modelo <strong class="text-danger">*</strong></label>
                      <select name="modelo" id="modelo" class="form-select" required>
                        <option value="none" selected>- Nenhum Selecionado -</option>
                        <?php 
                          $sql = 'SELECT id, nome FROM modelo;';
                          $query = mysqli_execute_query($conexao, $sql);

                          foreach ($query as $modelo) {
                            echo '<option '. ($modelo['id'] == $veiculo['id_modelo'] ? 'selected' : '' ) .' value="'. $modelo['id'] .'">'. $modelo['nome'] .'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-5 mt-2 fs-container ">
                      <label for="categoria">Categoria <strong class="text-danger">*</strong></label>
                      <select required name="categoria" id="categoria" class="form-select">
                          <option <?php if ($veiculo['categoria'] == 'none') echo 'selected'; ?> value="none">- Nenhum Selecionado -</option>
                          <option <?php if ($veiculo['categoria'] == 'Hatchback') echo 'selected'; ?> value="Hatchback">Hatchback</option>
                          <option <?php if ($veiculo['categoria'] == 'Sedan') echo 'selected'; ?> value="Sedan">Sedan</option>
                          <option <?php if ($veiculo['categoria'] == 'SUV') echo 'selected'; ?> value="SUV">SUV</option>
                          <option <?php if ($veiculo['categoria'] == 'Crossover') echo 'selected'; ?> value="Crossover">Crossover</option>
                          <option <?php if ($veiculo['categoria'] == 'Cupê') echo 'selected'; ?> value="Cupê">Cupê</option>
                          <option <?php if ($veiculo['categoria'] == 'Conversível') echo 'selected'; ?> value="Conversível">Conversível</option>
                          <option <?php if ($veiculo['categoria'] == 'Perua') echo 'selected'; ?> value="Perua ">Perua</option>
                          <option <?php if ($veiculo['categoria'] == 'Roadster') echo 'selected'; ?> value="Roadster">Roadster</option>
                          <option <?php if ($veiculo['categoria'] == 'Esportivo') echo 'selected'; ?> value="Esportivo">Esportivo</option>
                          <option <?php if ($veiculo['categoria'] == 'Compacto') echo 'selected'; ?> value="Compacto">Compacto</option>
                          <option <?php if ($veiculo['categoria'] == 'Minivan') echo 'selected'; ?> value="Minivan">Minivan</option>
                          <option <?php if ($veiculo['categoria'] == 'Pickup') echo 'selected'; ?> value="Pickup">Pickup</option>

                          <option <?php if ($veiculo['categoria'] == 'Van') echo 'selected'; ?> value="Van">Van</option>
                          <option <?php if ($veiculo['categoria'] == 'Furgão') echo 'selected'; ?> value="Furgão">Furgão</option>
                          <option <?php if ($veiculo['categoria'] == 'Caminhonete') echo 'selected'; ?> value="Caminhonete">Caminhonete</option>

                          <option <?php if ($veiculo['categoria'] == 'Superesportivo') echo 'selected'; ?> value="Superesportivo">Superesportivo</option>
                          <option <?php if ($veiculo['categoria'] == 'Luxo / Premium') echo 'selected'; ?> value="Luxo / Premium">Luxo / Premium</option>
                          <option <?php if ($veiculo['categoria'] == 'Gran Turismo (GT)') echo 'selected'; ?> value="Gran Turismo (GT)">Gran Turismo (GT)</option>
                          <option <?php if ($veiculo['categoria'] == 'Conversível Esportivo') echo 'selected'; ?> value="Conversível Esportivo">Conversível Esportivo</option>

                          <option <?php if ($veiculo['categoria'] == 'Caminhão Leve') echo 'selected'; ?> value="Caminhão Leve">Caminhão Leve</option>
                          <option <?php if ($veiculo['categoria'] == 'Caminhão Médio') echo 'selected'; ?> value="Caminhão Médio">Caminhão Médio</option>
                          <option <?php if ($veiculo['categoria'] == 'Caminhão Pesado') echo 'selected'; ?> value="Caminhão Pesado">Caminhão Pesado</option>
                          <option <?php if ($veiculo['categoria'] == 'Carreta') echo 'selected'; ?> value="Carreta">Carreta</option>

                          <option <?php if ($veiculo['categoria'] == 'Motocicleta') echo 'selected'; ?> value="Motocicleta">Motocicleta</option>
                          <option <?php if ($veiculo['categoria'] == 'Scooter') echo 'selected'; ?> value="Scooter">Scooter</option>
                          <option <?php if ($veiculo['categoria'] == 'Triciclo') echo 'selected'; ?> value="Triciclo">Triciclo</option>
                          <option <?php if ($veiculo['categoria'] == 'Quadriciclo') echo 'selected'; ?> value="Quadriciclo">Quadriciclo</option>

                          <option <?php if ($veiculo['categoria'] == 'Buggy') echo 'selected'; ?> value="Buggy">Buggy</option>
                          <option <?php if ($veiculo['categoria'] == 'Off-Road / 4x4') echo 'selected'; ?> value="Off-Road / 4x4">Off-Road / 4x4</option>
                          <option <?php if ($veiculo['categoria'] == 'Motorhome') echo 'selected'; ?> value="Motorhome">Motorhome</option>
                      </select>
                    </div>
                    <div class="col-md-3 mt-2 fs-container ">
                      <label for="cor">Cor <strong class="text-danger">*</strong></label>
                      <select required name="cor" id="cor" class="form-select">
                        <option <?php if ($veiculo['cor'] == 'Branco') echo 'selected'; ?> value="Branco">Branco</option>
                        <option <?php if ($veiculo['cor'] == 'Preto') echo 'selected'; ?> value="Preto">Preto</option>
                        <option <?php if ($veiculo['cor'] == 'Prata') echo 'selected'; ?> value="Prata">Prata</option>
                        <option <?php if ($veiculo['cor'] == 'Cinza') echo 'selected'; ?> value="Cinza">Cinza</option>
                        <option <?php if ($veiculo['cor'] == 'Vermelho') echo 'selected'; ?> value="Vermelho">Vermelho</option>
                        <option <?php if ($veiculo['cor'] == 'Azul') echo 'selected'; ?> value="Azul">Azul</option>
                        <option <?php if ($veiculo['cor'] == 'Verde') echo 'selected'; ?> value="Verde">Verde</option>
                        <option <?php if ($veiculo['cor'] == 'Amarelo') echo 'selected'; ?> value="Amarelo">Amarelo</option>
                        <option <?php if ($veiculo['cor'] == 'Laranja') echo 'selected'; ?> value="Laranja">Laranja</option>
                        <option <?php if ($veiculo['cor'] == 'Marrom') echo 'selected'; ?> value="Marrom">Marrom</option>
                        <option <?php if ($veiculo['cor'] == 'Bege') echo 'selected'; ?> value="Bege">Bege</option>
                        <option <?php if ($veiculo['cor'] == 'Bordo') echo 'selected'; ?> value="Bordo">Bordo</option>
                        <option <?php if ($veiculo['cor'] == 'Dourado') echo 'selected'; ?> value="Dourado">Dourado</option>
                        <option <?php if ($veiculo['cor'] == 'Roxo') echo 'selected'; ?> value="Roxo">Roxo</option>
                        <option <?php if ($veiculo['cor'] == 'Rosa') echo 'selected'; ?> value="Rosa">Rosa</option>
                        <option <?php if ($veiculo['cor'] == 'Grafite') echo 'selected'; ?> value="Grafite">Grafite</option>
                        <option <?php if ($veiculo['cor'] == 'Champagne') echo 'selected'; ?> value="Champagne">Champagne</option>
                        <option <?php if ($veiculo['cor'] == 'Vinho') echo 'selected'; ?> value="Vinho">Vinho</option>
                      </select>
                    </div>
                  </fieldset>
                  <hr>
                  <fieldset class="form-fs row">
                    <div class="title">Informações básicas</div>
                    <div class="col-md-5 mt-2 fs-container ">
                      <label for="estado">Estado do Veículo <strong class="text-danger">*</strong></label>
                      <select required name="estado" id="estado" class="form-select">
                        <option <?php if ($veiculo['estado_do_veiculo'] == 'none') echo 'selected'; ?> value="none" selected>- Nenhum Selecionado -</option>
                        <option <?php if ($veiculo['estado_do_veiculo'] == 'Novo') echo 'selected'; ?> value="Novo">Novo</option>
                        <option <?php if ($veiculo['estado_do_veiculo'] == 'Semi-novo') echo 'selected'; ?> value="Semi-novo">Semi-novo</option>
                        <option <?php if ($veiculo['estado_do_veiculo'] == 'Usado') echo 'selected'; ?> value="Usado">Usado</option>
                      </select>
                    </div>
                    <div class="col-md-2 mt-2 fs-container">
                      <label for="ano">Ano <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['ano']; ?>" required type="text" name="ano" id="ano" class="form-control" maxlength="4" placeholder="Ex: 2025">
                    </div>
                    <div class="col-md-3 mt-2 fs-container">
                      <label for="final_placa">Final da placa <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['final_placa']; ?>" required type="text" name="final_placa" id="final_placa" class="form-control" maxlength="1" placeholder="Ex: 1">
                    </div>
                    <div class="col-md-2 mt-2 fs-container">
                      <label for="estoque">Estoque <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['estoque']; ?>" type="text" name="estoque" id="estoque" class="form-control" data-mask="#" data-mask-reverse="true" maxlength="5" placeholder="Ex: 20">
                    </div>
                    <div class="col-md-3 mt-2 fs-container">
                      <label for="quilometragem">Quilômetragem <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['kms_rodado']; ?>" required type="text" name="quilometragem" id="quilometragem" class="form-control" maxlength="7" placeholder="0">
                    </div>
                    <div class="col-md-3 mt-2 fs-container">
                      <label for="tempo_usado">Tempo de uso <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['tempo_de_uso']; ?>" required type="text" name="tempo_usado" id="tempo_usado" class="form-control" maxlength="5" placeholder="0">
                    </div>
                    <div class="col-md-3 mt-2 fs-container">
                      <label for="tipo_combustivel">Tipo de combustivel <strong class="text-danger">*</strong></label>
                      <select required name="tipo_combustivel" id="tipo_combustivel" class="form-control">
                        <option <?php if ($veiculo['tipo_combustivel'] == 'Gasolina') echo 'selected'; ?> value="Gasolina">Gasolina</option>
                        <option <?php if ($veiculo['tipo_combustivel'] == 'Etanol') echo 'selected'; ?> value="Etanol">Etanol</option>
                        <option <?php if ($veiculo['tipo_combustivel'] == 'Flex') echo 'selected'; ?> value="Flex">Flex</option>
                        <option <?php if ($veiculo['tipo_combustivel'] == 'Diesel') echo 'selected'; ?> value="Diesel">Diesel</option>
                        <option <?php if ($veiculo['tipo_combustivel'] == 'Elétrico') echo 'selected'; ?> value="Elétrico">Elétrico</option>
                        <option <?php if ($veiculo['tipo_combustivel'] == 'GNV (Gás Natural Veicular)') echo 'selected'; ?> value="GNV (Gás Natural Veicular)">GNV (Gás Natural Veicular)</option>
                      </select>
                    </div>
                    <div class="col-md-3 mt-2 fs-container">
                      <label for="tipo_cambio">Tipo de câmbio <strong class="text-danger">*</strong></label>
                      
                      <select required name="tipo_cambio" id="tipo_cambio" class="form-control">
                        <option <?php if ($veiculo['tipo_cambio'] == 'Manual') echo 'selected'; ?> value="Manual">Manual</option>
                        <option <?php if ($veiculo['tipo_cambio'] == 'Automático Tradicional') echo 'selected'; ?> value="Automático Tradicional">Automático Tradicional</option>
                        <option <?php if ($veiculo['tipo_cambio'] == 'CVT') echo 'selected'; ?> value="CVT">CVT (Transmissão Continuamente Variável)</option>
                        <option <?php if ($veiculo['tipo_cambio'] == 'Automatizado (Monoembreagem)') echo 'selected'; ?> value="Automatizado (Monoembreagem)">Automatizado (Monoembreagem)</option>
                        <option <?php if ($veiculo['tipo_cambio'] == 'DCT (Automático de Dupla Embreagem)') echo 'selected'; ?> value="DCT (Automático de Dupla Embreagem)">DCT (Automático de Dupla Embreagem)</option>
                      </select>
                    </div>
                  </fieldset>
                  <hr>
                  <fieldset class="form-fs row">
                    <div class="title">Valores</div>
                    <div class="col-md-4 mt-2 fs-container">
                      <label for="preco_custo">Preço Custo <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['preco_custo'] ?>" required type="text" name="preco_custo" id="preco_custo" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" maxlength="13" placeholder="R$0,00">
                    </div>

                    <div class="col-md-4 mt-2 fs-container">
                      <label for="lucro_esperado">Lucro (%) <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['lucro'] ?>" required type="text" name="lucro_esperado" id="lucro_esperado" class="form-control" data-mask="#" data-mask-reverse="true" maxlength="5" placeholder="0">
                    </div>

                    <div class="col-md-4 mt-2 fs-container">
                      <label for="desconto">Desconto (%) <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['desconto'] ?>" type="text" name="desconto" id="desconto" class="form-control" data-mask="#" data-mask-reverse="true" placeholder="0">
                    </div>

                    <div class="col-md-6 mt-2 fs-container">
                      <label for="preco_venda">Preço Venda <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['preco_venda'] ?>" readonly required type="text" name="preco_venda" id="preco_venda" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" maxlength="13" placeholder="R$0,00">
                    </div>

                    <div class="col-md-6 mt-2 fs-container">
                      <label for="preco_desconto">Preço Desconto <strong class="text-danger">*</strong></label>
                      <input value="<?php echo $veiculo['preco_desconto'] ?>" readonly required type="text" name="preco_desconto" id="preco_desconto" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" maxlength="13" placeholder="R$0,00">
                    </div>
                  </fieldset>
                  <hr>
                  <fieldset class="form-fs row">
                    <div class="title">Descrição</div>
                    <div class="col-md-12 mt-2 fs-container">
                      <label for="descricao">Descrição do anúncio <strong class="text-danger">*</strong></label>
                      <textarea type="text" name="descricao" id="descricao" class="form-control" maxlength="250" placeholder="Descreva as características do veículo, estado de conservação e diferenciais."><?php echo $veiculo['descricao']; ?></textarea>
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
                        <img required id="foto-veiculo" style="display: none;" <?php echo 'src="../../images/'. $veiculo['foto'] .'"' ?> alt="">
                      </div>
                      
                      
                      <input type="file" name="foto-veiculo-input" id="foto-veiculo-input" class="form-control mt-3 mx-auto w-50" accept="image/*">
                    </div>
                  </fieldset>
                  <hr>
                  <fieldset class="form-fs row">
                    <div class="col-md-12 fs-container">
                      <input type="hidden" name="editar" value="editar_veiculo" class="btn btn-primary mt-3">
                      <input type="submit" value="Atualizar" class="btn btn-primary w-100">
                    </div>
                  </fieldset>
                </form>
              </div>

            </div>
          <?php } else {
            echo '<div class="alert alert-danger m-3" role="alert">Funcionário não encontrado!</div>';
          } ?>
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
  <script>
    $('#foto-veiculo').on('load', function () {
        const src = $(this).attr('src');

        if (src && src.trim() !== '') {
            // Tem imagem → mostra a imagem, esconde o preview
            $('#foto-veiculo').css('display', 'block');
            $('#veiculo-foto-preview').css('display', 'none');
        } else {
            // Sem imagem → oculta imagem, mostra preview
            $('#foto-veiculo').css('display', 'none');
            $('#veiculo-foto-preview').css('display', 'block');
        }
    });


    $(document).ready(function () {
      $('#lucro_esperado').trigger('input');
      $('#foto-veiculo').trigger('load');
    });
  </script>
</body>

</html>