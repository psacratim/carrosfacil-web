<?php
if (!isset($_SESSION)) {
  session_start();
}

require_once("../usuario_comum.php");
require_once("../../conexao/conecta.php");
require_once('../../Components/Sidebar.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$vehicle = null;

if ($id > 0) {
  $query = "SELECT * FROM veiculo WHERE id = $id";
  $result = mysqli_query($connection, $query);
  $vehicle = mysqli_fetch_assoc($result);
  $photosGalery = [];
  if ($id > 0) {
    $vehiclePhotos = mysqli_query($connection, "SELECT caminho, ordem FROM foto_veiculo WHERE id_veiculo = $id");
    while ($f = mysqli_fetch_assoc($vehiclePhotos)) {
      $photosGalery[$f['ordem']] = $f['caminho'];
    }
  }
}

$pageTitle = $vehicle ? "Editar Veículo #" . $vehicle['id'] : "Novo Veículo";
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carros Fácil - <?php echo $pageTitle; ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../custom/css/style.css">

  <style>
    .image-preview {
      border: 2px dashed #ccc;
      padding: 20px;
      border-radius: 8px;
      background: #f9f9f9;
      min-height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #foto-preview {
      max-height: 300px;
      border-radius: 8px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php echo Sidebar("vehicle"); ?>

      <main class="col-lg-10">
        <header id="admin-header" class="py-2 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="left-info"><?php echo mb_strtoupper($pageTitle); ?></div>
          <div id="right-info">
            <button type="button" id="mock-veiculo" class="btn btn-warning btn-sm py-2">
              <i class="bi bi-magic"></i> Mock Veículo
            </button>
            <a href="Index.php" class="py-2 btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Voltar</a>
          </div>
        </header>

        <hr class="m-0">

        <div class="container mt-4 mb-5">
          <form action="actions.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row g-4">
              <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light"><strong>Identificação e Estilo</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-5">
                      <label class="form-label">Modelo <span class="text-danger">*</span></label>
                      <select name="model" id="model" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php
                        $result = mysqli_query($connection, "SELECT id, nome FROM modelo ORDER BY nome ASC");
                        while ($m = mysqli_fetch_assoc($result)) {
                          $selected = ($vehicle && $vehicle['id_modelo'] == $m['id']) ? 'selected' : '';
                          echo "<option value='{$m['id']}' $selected>{$m['nome']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Categoria <span class="text-danger">*</span></label>
                      <select name="category" id="category" class="form-select" required>
                        <option value="" disabled <?= $vehicle ? '' : "selected" ?>>Selecione uma categoria</option>

                        <?php
                        $categories = [
                          // Hatch
                          "Hatch Compacto",
                          "Hatch Médio",

                          // Sedan
                          "Sedan Compacto",
                          "Sedan Médio",
                          "Sedan Premium",

                          // SUV
                          "SUV Compacto",
                          "SUV Médio",
                          "SUV de Luxo",
                          "SUV 7 Lugares",

                          // Picape
                          "Picape Compacta",      // Fiat Strada
                          "Picape Média",
                          "Picape Full-size",

                          // Caminhões / Utilitários
                          "Caminhão Leve",
                          "Caminhão Médio",       // Mercedes-Benz 1113
                          "Utilitário / Carga",

                          // Esportivos e motos
                          "Esportivo",            // BMW S1000 (moto esportiva)
                          "Superesportivo",

                          // Outros tipos
                          "Off-Road / 4x4",
                          "Minivan",
                          "Perua (SW)",
                          "Van de Passageiros",

                          // Clássicos
                          "Antigo / Colecionador", // Mercedes-Benz 1113

                          // Energia
                          "Híbrido",
                          "Elétrico",

                          // ➕ Categorias extras comuns (novas)
                          "Popular / Entrada",    // Gol, Onix
                          "Executivo",
                          "Uso Urbano"
                        ];

                        foreach ($categories as $category) {
                        ?>
                          <option value="<?= $category; ?>" <?php if (isset($vehicle) && $vehicle["categoria"] == $category) echo 'selected'; ?>>
                            <?= $category; ?>
                          </option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Cor <span class="text-danger">*</span></label>
                      <select name="color" id="color" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php
                        $colorList = [
                          "Branco",
                          "Preto",
                          "Prata",
                          "Cinza",
                          "Vermelho",
                          "Azul",
                          "Verde",
                          "Amarelo",
                          "Laranja",
                          "Marrom",
                          "Bege",
                          "Bordo",
                          "Dourado",
                          "Roxo",
                          "Rosa",
                          "Grafite",
                          "Champagne",
                          "Vinho"
                        ];
                        foreach ($colorList as $colorName) {
                          // Verifica se o veículo já tem essa cor salva (para o modo edição)
                          $selected = ($vehicle && $vehicle["cor"] == $colorName) ? 'selected' : '';
                          echo "<option value='$colorName' $selected>$colorName</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light"><strong>Ficha Técnica e Condição</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-3">
                      <label class="form-label">Ano</label>
                      <input type="text" data-mask="0000" name="year" id="year" class="form-control" value="<?php echo $vehicle["ano"] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Quilometragem</label>
                      <input type="text" data-mask="######0" name="mileage" id="mileage" class="form-control" value="<?php echo $vehicle["quilometragem"] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Condição</label>
                      <select name="condition" id="condition" class="form-select">
                        <option value="Novo" <?php if ($vehicle && $vehicle["estado_do_veiculo"] == 'Novo') echo 'selected'; ?>>Novo</option>
                        <option value="Semi-novo" <?php if ($vehicle && $vehicle["estado_do_veiculo"] == 'Semi-novo') echo 'selected'; ?>>Semi-novo</option>
                        <option value="Usado" <?php if ($vehicle && $vehicle["estado_do_veiculo"] == 'Usado') echo 'selected'; ?>>Usado</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Tempo de Uso (dias)</label>
                      <input data-mask="####0" type="text" name="usageTime" id="usageTime" class="form-control" placeholder="Ex: 365" value="<?= $vehicle ? $vehicle['tempo_de_uso'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Câmbio</label>
                      <select name="transmissionType" id="transmissionType" class="form-select">
                        <option value="Manual" <?php if ($vehicle && $vehicle["tipo_cambio"] == 'Manual') echo 'selected'; ?>>Manual</option>
                        <option value="Auto Trad." <?php if ($vehicle && $vehicle["tipo_cambio"] == 'Auto Trad.') echo 'selected'; ?>>Automático Tradicional</option>
                        <option value="CVT" <?php if ($vehicle && $vehicle["tipo_cambio"] == 'CVT') echo 'selected'; ?>>(CVT) Transmissão Continuamente Variável</option>
                        <option value="Auto Mono." <?php if ($vehicle && $vehicle["tipo_cambio"] == 'Auto Mono.') echo 'selected'; ?>>Automático Tradicional</option>
                        <option value="DCT" <?php if ($vehicle && $vehicle["tipo_cambio"] == 'DCT') echo 'selected'; ?>>Automático de Dupla Embreagem</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Combustível</label>
                      <select name="fuelType" id="fuelType" class="form-select">
                        <option value="Flex" <?php if ($vehicle && $vehicle["tipo_combustivel"] == 'Flex') echo 'selected'; ?>>Flex</option>
                        <option value="Gasolina" <?php if ($vehicle && $vehicle["tipo_combustivel"] == 'Gasolina') echo 'selected'; ?>>Gasolina</option>
                        <option value="Diesel" <?php if ($vehicle && $vehicle["tipo_combustivel"] == 'Diesel') echo 'selected'; ?>>Diesel</option>
                        <option value="Etanol" <?php if ($vehicle && $vehicle["tipo_combustivel"] == 'Etanol') echo 'selected'; ?>>Etanol</option>
                        <option value="GNV" <?php if ($vehicle && $vehicle["tipo_combustivel"] == 'GNV') echo 'selected'; ?>>(GNV) Gás Natural Veicular</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label class="form-label">Descrição do Anúncio</label>
                      <textarea maxlength="250" name="description" id="description" class="form-control" rows="3"><?= $vehicle ? $vehicle['descricao'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>

                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <strong>Características e Opcionais</strong>
                  </div>
                  <div class="card-body">
                    <div class="row g-2 mb-3">
                      <div class="col-md-10">
                        <select id="select-feature" class="form-select">
                          <option value="">Selecione uma característica...</option>
                          <?php
                          $featuresQuery = mysqli_query($connection, "SELECT * FROM caracteristica WHERE status = 1 ORDER BY nome ASC");
                          while ($f = mysqli_fetch_assoc($featuresQuery)) {
                            echo "<option value='{$f['id']}' data-nome='{$f['nome']}'>{$f['nome']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <button type="button" class="btn btn-secondary w-100" onclick="addFeature()">
                          <i class="bi bi-plus-lg"></i> Adicionar
                        </button>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered">
                        <thead class="table-light">
                          <tr>
                            <th>Característica</th>
                            <th width="100" class="text-center">Ação</th>
                          </tr>
                        </thead>
                        <tbody id="features-table-body">
                          <?php
                          if ($id > 0) {
                            $currentFeatures = mysqli_query($connection, "SELECT c.id, c.nome FROM caracteristica c 
                              INNER JOIN caracteristica_carro cc ON c.id = cc.id_caracteristica 
                              WHERE cc.id_veiculo = $id");
                            while ($cf = mysqli_fetch_assoc($currentFeatures)) {
                              echo "<tr id='feature-row-{$cf['id']}'>
                                      <td class='align-middle'>{$cf['nome']} <input type='hidden' name='features[]' value='{$cf['id']}'></td>
                                      <td class='text-center'><button type='button' class='btn btn-danger btn-sm' onclick='removeFeature({$cf['id']})'><i class='bi bi-trash'></i></button></td>
                                    </tr>";
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="card shadow-sm">
                  <div class="card-header bg-light"><strong>Preços e Valores</strong></div>
                  <div class="card-body row g-3">

                    <div class="col-md-4">
                      <label class="form-label">Preço Custo (R$)</label>
                      <input maxlength="16" data-mask="#.##0,00" data-mask-reverse="true" type="text" id="costPrice" name="costPrice" class="form-control" value="<?= $vehicle ? number_format($vehicle["preco_custo"], 2, ',', '.') : '' ?>" placeholder="R$ 0,00">
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Lucro (%)</label>
                      <input data-mask="####0" id="expected_profit" name="expected_profit" class="form-control" placeholder="0" value="<?= $vehicle ? $vehicle["lucro"] : '' ?>">
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Preço Venda (R$)</label>
                      <input maxlength="16" data-mask="#.##0,00" data-mask-reverse="true" placeholder="R$ 0,00" type="text" id="sellPrice" name="sellPrice" class="form-control" readonly value="<?= $vehicle ? number_format($vehicle["preco_venda"], 2, ',', '.') : '' ?>">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Desconto (%)</label>
                      <input data-mask="##0" id="discount" name="discount" class="form-control" placeholder="0"
                        value="<?= $vehicle ? $vehicle["desconto"] : '' ?>">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Preço com Desconto (R$)</label>
                      <input maxlength="16" data-mask="#.##0,00" data-mask-reverse="true" placeholder="R$ 0,00" type="text" id="discountPrice" name="discountPrice" class="form-control" readonly
                        value="<?= $vehicle ? number_format($vehicle["preco_desconto"], 2, ',', '.') : '' ?>">
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light"><strong>Galeria de Fotos (Upload Individual)</strong></div>
                  <div class="card-body">
                    <div class="row g-3">
                      <?php for ($i = 1; $i <= 6; $i++): ?>
                        <div class="col-md-6 col-6">
                          <div class="upload-slot border rounded p-2 text-center" style="background: #f8f9fa; cursor: pointer;" onclick="document.getElementById('photo-input-<?php echo $i; ?>').click();">
                            <div id="preview-container-<?php echo $i; ?>">
                              <?php
                              // Se for o slot 1, tenta pegar a foto principal. Se for outro slot, pega da galeria.
                              $mainPhoto = ($i == 1) ? ($vehicle ? $vehicle['foto'] : '') : ($photosGalery[$i] ?? '');

                              if (!empty($mainPhoto) && $mainPhoto != 'default.png'):
                              ?>
                                <img src="../../images/<?php echo $mainPhoto; ?>" class="img-fluid rounded mb-2" style="height: 100px; width: 100%; object-fit: cover;">
                              <?php else: ?>
                                <i class="bi bi-camera" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="small text-muted mb-0">Foto <?php echo $i; ?></p>
                              <?php endif; ?>
                            </div>

                            <input type="file"
                              name="photo_<?php echo $i; ?>"
                              id="photo-input-<?php echo $i; ?>"
                              class="d-none"
                              accept="image/*"
                              onchange="previewImage(this, <?php echo $i; ?>)">

                            <button type="button" class="btn btn-sm btn-outline-primary mt-2 w-100">
                              Selecionar
                            </button>
                          </div>
                        </div>
                      <?php endfor; ?>
                    </div>
                    <small class="text-muted d-block mt-2 text-center w-100">* A primeira foto será a principal do anúncio.</small>
                  </div>
                </div>

                <div class="card shadow-sm mt-5">
                  <div class="card-header bg-light"><strong>Controle</strong></div>
                  <div class="card-body">
                    <label class="form-label">Quantidade em Estoque</label>
                    <input type="text" data-mask="####0" name="stock" class="form-control mb-3" value="<?= $vehicle ? $vehicle['estoque'] : ''; ?>">

                    <button type="submit" name="actionSave" class="btn btn-primary w-100 py-2 mt-4">
                      <i class="bi bi-reportValidity();-circle"></i> <?= $vehicle ? "Atualizar Dados" : "Cadastrar Veículo"; ?>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="../../assets/js/jquery.mask.js"></script>

  <script src="../../assets/js/components/sidebar.js"></script>
  <script src="../../assets/js/register-vehicle-form-extras.js"></script>
  <script>
    function addFeature() {
      const select = document.getElementById('select-feature');
      const id = select.value;
      const nome = select.options[select.selectedIndex].getAttribute('data-nome');

      if (!id) return;

      if (document.getElementById('feature-row-' + id)) {
        alert('Esta característica já foi adicionada.');
        return;
      }

      const html = `
        <tr id="feature-row-${id}">
          <td class="align-middle">${nome} <input type="hidden" name="features[]" value="${id}"></td>
          <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(${id})">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      `;

      $('#features-table-body').append(html);
      select.value = "";
    }

    function removeFeature(id) {
      $('#feature-row-' + id).remove();
    }

    function previewImage(input, index) {
      const container = document.getElementById('preview-container-' + index);

      if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
          // Limpa o ícone e adiciona a foto
          container.innerHTML = `
                <img src="${e.target.result}" 
                     class="img-fluid rounded mb-2" 
                     style="height: 100px; width: 100%; object-fit: cover;">
                <p class="small text-success mb-0">Pronta!</p>
            `;
        };

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#photo-input").change(function() {
      const file = this.files[0];
      if (file) {
        let reader = new FileReader();
        reader.onload = function(event) {
          $("#foto-preview").attr("src", event.target.result).removeClass("d-none");
          $("#placeholder-icon").addClass("d-none");
        }
        reader.readAsDataURL(file);
      }
    });

    $("#discount").on('input', function() {
      if (parseInt($(this).val()) > 100) {
        $(this).val(100);
      }
    });

    function tryParseInt(str, defaultValue) {
      const parsed = parseInt(str, 10);
      if (Number.isNaN(parsed)) {
        return defaultValue;
      }
      return parsed;
    }

    $(function() {
      function parseCurrency(value) {
        if (!value) return 0;
        return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
      }

      function formatCurrency(value) {
        return value.toLocaleString('pt-BR', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      }

      function calculatePrices() {
        const cost = parseCurrency($('#costPrice').val());
        const profitPercentage = parseFloat($('#expected_profit').val()) || 0;
        const discountPercentage = parseFloat($('#discount').val()) || 0;

        const margin = cost * (profitPercentage / 100);
        const sellPrice = cost + margin;

        const discountAmount = sellPrice * (discountPercentage / 100);
        const discountedPrice = sellPrice - discountAmount;

        $('#sellPrice').val(formatCurrency(sellPrice));
        $('#discountPrice').val(formatCurrency(discountedPrice));

        const profitInput = document.getElementById('expected_profit');
        const discountInput = document.getElementById('discount');

        profitInput.setCustomValidity('');
        discountInput.setCustomValidity('');

        if (sellPrice < cost && cost > 0) {
          profitInput.setCustomValidity('Falha: O preço de venda não pode ser inferior ao preço de custo. Aumente a margem de lucro.');
        } else if (discountedPrice < cost && cost > 0) {
          discountInput.setCustomValidity('Falha: O preço de desconto está abaixo do preço de custo, diminua o desconto ou aumente o lucro.');
        }
      }

      $('#costPrice, #expected_profit, #discount').on('input', function() {
        calculatePrices();
      });

      if ($('#costPrice').val()) {
        calculatePrices();
      }

      $("#year").on('keyup', function(event) {
        let year = tryParseInt(this.value, -1);
        if (year < 0) return;

        this.setCustomValidity('');
        if (year > new Date().getFullYear()) {
          this.setCustomValidity('Falha: O ano não pode ser maior que o atual.');
          this.reportValidity();
        }
      });
    });

    $('#mock-veiculo').on('click', function() {
      try {
        const rand = (arr) => arr[Math.floor(Math.random() * arr.length)];
        const randInt = (min, max) => Math.floor(Math.random() * (max - min + 1) + min);

        // 1. FILTRO DE MODELOS (Ignora nomes comuns se quiser focar em exóticos)  480]
        const nomesProibidos = ["X1", "Kicks", "Compass", "Civic", "HB20", "Ranger", "Strada", "Onix", "Gol", "Corolla"];
        const $opcoesValidas = $('#model option').filter(function() {
          const texto = $(this).text().toUpperCase();
          const valor = $(this).val();
          return valor !== "" && !nomesProibidos.some(proibido => texto.includes(proibido.toUpperCase()));
        });

        if ($opcoesValidas.length > 0) {
          $(rand($opcoesValidas)).prop('selected', true);
        } else {
          $('#model option:eq(1)').prop('selected', true);
        }

        // 2. DADOS PADRONIZADOS (Cores agora devem bater exatamente com o seu SELECT) 
        const baseExotica = {
          // Lista de cores ajustada para o seu novo select
          cores: [
            "Branco", "Preto", "Prata", "Cinza", "Vermelho", "Azul", "Verde",
            "Amarelo", "Laranja", "Marrom", "Bege", "Bordo", "Dourado",
            "Roxo", "Rosa", "Grafite", "Champagne", "Vinho"
          ],
          categorias: ["Sedan", "Hatchback", "SUV", "Pickup"],
          cambios: ["Manual", "Automático"],
          combustiveis: ["Gasolina", "Flex", "Diesel"],
          descricoes: [
            "Edição limitada com acabamento em fibra de carbono e escape esportivo original.",
            "Configuração exclusiva, interior em alcântara e freios de cerâmica. Impecável.",
            "Veículo de importação oficial, revisado em concessionária por tempo e não km.",
            "Performance absurda, 0-100km/h em 2.9s. Um verdadeiro item de colecionador."
          ]
        };

        // 3. PREENCHIMENTO DOS CAMPOS (O .val() funcionará perfeitamente no select) 
        $('#category').val(rand(baseExotica.categorias));
        $('#transmissionType').val(rand(baseExotica.cambios));
        $('#fuelType').val(rand(baseExotica.combustiveis));
        $('#color').val(rand(baseExotica.cores)); // Sorteia uma cor da lista acima
        $('#year').val(randInt(2022, 2026));
        $('#mileage').val(randInt(50, 5000));
        $('#description').val(rand(baseExotica.descricoes));
        $('#stock').val(randInt(1, 2));

        // 4. FINANCEIRO 
        const cost = randInt(850000, 3500000);
        const profit = rand([5, 8, 10, 15]);
        const costFormatted = cost.toLocaleString('pt-br', {
          minimumFractionDigits: 2
        });

        $('#costPrice').val(costFormatted);
        $('#expected_profit').val(profit);

        // Dispara o cálculo automático do preço de venda 
        calcularVenda();

        // 5. IMAGENS 
        const marcasFlickr = ["ferrari", "lamborghini", "porsche-911", "mclaren", "rolls-royce"];
        const imgUrl = `https://loremflickr.com/640/480/${rand(marcasFlickr)}?lock=${randInt(1, 1000)}`;

        $("#foto-preview").attr("src", imgUrl).removeClass("d-none").show();
        $("#placeholder-icon").addClass("d-none");

        console.log("💎 Mock 'Exotic Edition' com Select aplicado!");

      } catch (err) {
        console.error("Erro no Mock:", err);
      }
    });
  </script>
</body>

</html>