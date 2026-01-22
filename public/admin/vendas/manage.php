<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once("../../conexao/conecta.php");
require_once('../../Components/Sidebar.php');

$isEditing = false;
$saleData = null;
$itemsJson = '[]';
$paymentsJson = '[]';

if (isset($_GET['id'])) {
  $isEditing = true;
  $id = (int)$_GET['id'];

  $saleQuery = mysqli_query($connection, "SELECT v.*, c.nome as customer_name, f.nome as employee_name 
                                      FROM venda v 
                                      INNER JOIN cliente c ON v.id_cliente = c.id 
                                      INNER JOIN funcionario f ON v.id_funcionario = f.id 
                                      WHERE v.id = $id");
  $saleData = mysqli_fetch_assoc($saleQuery);

  $itemsQuery = mysqli_query($connection, "SELECT iv.*, m.nome as model, v.estoque 
                                      FROM item_venda iv 
                                      INNER JOIN veiculo v ON iv.id_veiculo = v.id 
                                      INNER JOIN modelo m ON v.id_modelo = m.id 
                                      WHERE iv.id_venda = $id");

  $itemsList = [];
  $itemsCount = mysqli_num_rows($itemsQuery);

  for ($index = 0; $index < $itemsCount; $index++) {
    $item = mysqli_fetch_assoc($itemsQuery);
    $itemsList[] = [
      'id' => $item['id_veiculo'],
      'name' => $item['model'],
      'price' => (float)$item['valor_unitario'],
      'quantity' => (int)$item['quantidade'],
      'stock' => (int)$item['estoque'] + (int)$item['quantidade']
    ];
  }
  $itemsJson = json_encode($itemsList);

  $paymentsQuery = mysqli_query($connection, "SELECT * FROM pagamento_venda WHERE id_venda = $id");

  $paymentsList = [];
  $paymentsCount = mysqli_num_rows($paymentsQuery);

  for ($index = 0; $index < $paymentsCount; $index++) {
    $pay = mysqli_fetch_assoc($paymentsQuery);
    $paymentsList[] = [
      'method' => $pay['metodo'],
      'amount' => (float)$pay['valor_final'],
      'installments' => $pay['parcelas'],
    ];
  }
  $paymentsJson = json_encode($paymentsList);
}

$mockCustomers = mysqli_fetch_all(mysqli_query($connection, "SELECT id, nome FROM cliente WHERE status = 1 LIMIT 5"), MYSQLI_ASSOC);
$mockEmployees = mysqli_fetch_all(mysqli_query($connection, "SELECT id, nome FROM funcionario WHERE status = 1 LIMIT 5"), MYSQLI_ASSOC);
$mockVehicles = mysqli_fetch_all(mysqli_query($connection, "SELECT v.id, m.nome, v.preco_venda, v.estoque FROM veiculo v JOIN modelo m ON v.id_modelo = m.id WHERE v.status = 1 AND v.estoque > 0 LIMIT 5"), MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carros Fácil - <?php echo $isEditing ? 'Editar' : 'Nova'; ?> Venda</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../custom/css/style.css">

  <style>
    .search-wrapper {
      position: relative;
    }

    .search-dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      z-index: 1050;
      background: #fff;
      border: 1px solid #dee2e6;
      border-radius: 0 0 8px 8px;
      display: none;
      max-height: 200px;
      overflow-y: auto;
    }

    .search-row {
      padding: 10px 15px;
      cursor: pointer;
      border-bottom: 1px solid #f8f9fa;
    }

    .search-row:hover {
      background: #f1f1f1;
    }

    .summary-card {
      background: #f8f9fa;
      border-left: 4px solid #0d6efd;
      position: sticky;
      top: 20px;
    }

    .field-selected {
      background-color: #e8f5e9 !important;
      border-color: #4caf50 !important;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php echo Sidebar("sell"); ?>

      <main class="col-lg-10">
        <header id="main-header" class="py-3 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="header-title"><?php echo $isEditing ? 'VISUALIZANDO' : 'NOVA'; ?> VENDA #<?php echo $isEditing ? $id : ''; ?></div>

          <div class="d-flex gap-2">
            <button type="button" onclick="generateMockData()" class="btn btn-warning btn-sm"><i class="bi bi-magic"></i> Gerar Mock</button>
            <a href="Index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Voltar</a>
          </div>
        </header>
        <?php include('../Mensagem.php'); ?>

        <div class="container mt-4 mb-5">
          <form action="actions.php" method="post" id="sale-form">
            <input type="hidden" name="saleId" value="<?php echo $isEditing ? $id : '0'; ?>">

            <div class="row g-4">
              <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light"><strong>Identificação</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-6 search-wrapper">
                      <label class="form-label">Cliente</label>
                      <div class="input-group">
                        <span class="input-group-text bg-white" id="customer-icon">
                          <?php echo $isEditing ? '<i class="bi bi-check-lg text-success"></i>' : '<i class="bi bi-search"></i>'; ?>
                        </span>
                        <input type="text" id="customer-search" class="form-control <?php echo $isEditing ? 'field-selected' : ''; ?>"
                          placeholder="Buscar cliente..." autocomplete="off" value="<?php echo $isEditing ? $saleData['customer_name'] : ''; ?>">
                        <input type="hidden" name="customerId" id="customer-id-hidden" value="<?php echo $isEditing ? $saleData['id_cliente'] : ''; ?>" required>
                      </div>
                      <div class="search-dropdown shadow" id="customer-results"></div>
                    </div>
                    <div class="col-md-6 search-wrapper">
                      <label class="form-label">Vendedor</label>
                      <div class="input-group">
                        <span class="input-group-text bg-white" id="seller-icon">
                          <?php echo $isEditing ? '<i class="bi bi-check-lg text-success"></i>' : '<i class="bi bi-person-badge"></i>'; ?>
                        </span>
                        <input type="text" id="seller-search" class="form-control <?php echo $isEditing ? 'field-selected' : ''; ?>"
                          placeholder="Buscar vendedor..." autocomplete="off" value="<?php echo $isEditing ? $saleData['employee_name'] : ''; ?>">
                        <input type="hidden" name="employeeId" id="seller-id-hidden" value="<?php echo $isEditing ? $saleData['id_funcionario'] : ''; ?>" required>
                      </div>
                      <div class="search-dropdown shadow" id="seller-results"></div>
                    </div>
                  </div>
                </div>

                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light"><strong>Veículos Vendidos</strong></div>
                  <div class="card-body">
                    <div class="row g-2 mb-4 align-items-end">
                      <div class="col-md-7 search-wrapper">
                        <label class="form-label small">Pesquisar Veículo</label>
                        <input type="text" id="vehicle-search" class="form-control" placeholder="Modelo ou cor...">
                        <div class="search-dropdown shadow" id="vehicle-results"></div>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label small">Qtd</label>
                        <input type="number" id="input-amount" class="form-control" value="1" min="1">
                      </div>
                      <div class="col-md-3">
                        <button type="button" id="btn-add-vehicle" class="btn btn-dark w-100">
                          <i class="bi bi-plus-lg"></i> Adicionar
                        </button>
                      </div>
                    </div>

                    <div class="table-responsive">
                      <table class="table align-middle">
                        <thead>
                          <tr>
                            <th>Veículo</th>
                            <th>Preço Unit.</th>
                            <th>Qtd</th>
                            <th>Subtotal</th>
                            <th width="50"></th>
                          </tr>
                        </thead>
                        <tbody id="vehicle-table-body"></tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="card shadow-sm">
                  <div class="card-header bg-light"><strong>Formas de Pagamento</strong></div>
                  <div class="card-body">
                    <div class="row g-2 mb-3 align-items-end">
                      <div class="col-md-4">
                        <label class="form-label small">Meio</label>
                        <select id="pay-method" class="form-select">
                          <option value="Pix">Pix</option>
                          <option value="Dinheiro">Dinheiro</option>
                          <option value="Cartão de Crédito">Cartão de Crédito</option>
                          <option value="Cartão de Débito">Cartão de Débito</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label small">Valor (R$)</label>
                        <input type="text" id="pay-amount" data-mask="#.##0,00" data-mask-reverse="true" class="form-control" placeholder="0,00">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label small">Parcelas</label>
                        <select disabled id="pay-installments" class="form-select">
                          <option value="1">1x</option>
                          <option value="3">3x</option>
                          <option value="6">6x</option>
                          <option value="12">12x</option>
                          <option value="24">24x</option>
                          <option value="48">48x</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <button type="button" id="btn-add-payment" class="btn btn-outline-dark w-100">Adicionar Pago</button>
                      </div>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-sm align-middle">
                        <thead>
                          <tr class="text-muted small">
                            <th>Meio</th>
                            <th>Parcelas</th>
                            <th>Valor</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="payment-table-body"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="card shadow-sm summary-card p-3">
                  <div class="mb-3">
                    <span class="text-muted small">Subtotal:</span>
                    <h5 id="view-subtotal">R$ 0,00</h5>
                  </div>

                  <div class="mb-3">
                    <label class="small">Desconto (%)</label>
                    <input type="text" maxlength="3" data-mask="##0" id="sale-discount" name="saleDiscount" class="form-control"
                      value="<?php echo $isEditing ? ($saleData['desconto'] ?? '') : ''; ?>">
                  </div>

                  <hr>

                  <div class="mb-2">
                    <span class="h6">Total Geral:</span>
                    <h4 class="text-primary" id="view-total">R$ 0,00</h4>
                  </div>

                  <div class="d-flex justify-content-between text-success small mb-1">
                    <span>Recebido:</span>
                    <span id="view-received">R$ 0,00</span>
                  </div>
                  <div class="d-flex justify-content-between text-danger small mb-4">
                    <span>Faltante/Troco:</span>
                    <span id="view-difference">R$ 0,00</span>
                  </div>

                  <button type="submit" name="actionSave" class="btn btn-primary w-100 py-3 shadow-sm">
                    <i class="bi bi-shield-check"></i> <?php echo $isEditing ? 'ATUALIZAR' : 'FINALIZAR'; ?> VENDA
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/jquery.mask.js"></script>
  <script src="../../assets/js/components/sidebar.js"></script>

  <script>
    let selectedItems = <?php echo $itemsJson; ?>;
    let selectedPayments = <?php echo $paymentsJson; ?>;
    let currentVehicle = null;

    function formatMoney(value) {
      return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
      });
    }

    function parseMoney(value) {
      if (!value) return 0;
      return parseFloat(value.replace(/\./g, '').replace(',', '.'));
    }

    $(document).ready(function() {
      if (selectedItems.length > 0) renderItemsTable();
      if (selectedPayments.length > 0) renderPaymentsTable();
      updateCalculations();
    });

function initSearch(inputId, resultsId, searchType) {
    // Esse timeout é um teste, resumindo, se eu esquecer:
    // Ele espera x tempo pra enviar a solicitação, isso evita enviar solicitações muitas vezes, qunado o usuário nem parou de digitar ainda.
    let timeout = null;

    $(`#${inputId}`).on('input', function() {
        clearTimeout(timeout);
        
        const query = $(this).val().trim();
        const results = $(`#${resultsId}`);

        if (query.length > 2) {
            timeout = setTimeout(() => {
                $.get('search.php', { 
                    type: searchType, 
                    q: query 
                }, function(response) {
                    results.html(response).show();
                });
            }, 300);
        } else {
            results.hide().html('');
        }
    });
}

    initSearch('customer-search', 'customer-results', 'customer');
    initSearch('seller-search', 'seller-results', 'employee');
    initSearch('vehicle-search', 'vehicle-results', 'vehicle');

    function selectCustomer(id, name) {
      $('#customer-id-hidden').val(id);
      $('#customer-search').val(name).addClass('field-selected');
      $('#customer-icon').html('<i class="bi bi-check-lg text-success"></i>');
      $('#customer-results').hide();
    }

    function selectEmployee(id, name) {
      $('#seller-id-hidden').val(id);
      $('#seller-search').val(name).addClass('field-selected');
      $('#seller-icon').html('<i class="bi bi-check-lg text-success"></i>');
      $('#seller-results').hide();
    }

    function selectVehicle(id, name, price, stock) {
      currentVehicle = {
        id: id,
        name: name,
        price: parseFloat(price),
        stock: parseInt(stock)
      };
      $('#vehicle-search').val(name);
      $('#vehicle-results').hide();
    }

    function updateCalculations() {
      let subtotalValue = 0;
      let itemsCount = selectedItems.length;

      for (let index = 0; index < itemsCount; index++) {
        subtotalValue += (selectedItems[index].price * selectedItems[index].quantity);
      }

      let discountPercent = parseFloat($('#sale-discount').val()) || 0;
      let totalValue = subtotalValue - (subtotalValue * (discountPercent / 100));

      let totalReceived = 0;
      let paymentsCount = selectedPayments.length;

      for (let index = 0; index < paymentsCount; index++) {
        totalReceived += selectedPayments[index].amount;
      }

      let difference = totalReceived - totalValue;

      $('#view-subtotal').text(formatMoney(subtotalValue));
      $('#view-total').text(formatMoney(totalValue));
      $('#view-received').text(formatMoney(totalReceived));
      $('#view-difference').text(formatMoney(difference));
    }

    $("#sale-discount").on('input', function() {
      if (parseInt($(this).val()) > 100) {
        $(this).val(100);
      }
    });

    $('#btn-add-vehicle').click(function() {
      if (!currentVehicle) return alert("Por favor, selecione um veículo.");
      let amount = parseInt($('#input-amount').val());
      if (amount > currentVehicle.stock) return alert("Estoque insuficiente.");

      // O push coloca um novo objeto dentro da lista (array)
      selectedItems.push({
        id: currentVehicle.id,
        name: currentVehicle.name,
        price: currentVehicle.price,
        quantity: amount
      });

      renderItemsTable();
      currentVehicle = null;
      $('#vehicle-search').val('');
    });

    function renderItemsTable() {
      let rowsHtml = '';
      let totalRecords = selectedItems.length;

      for (let index = 0; index < totalRecords; index++) {
        let item = selectedItems[index];
        let sub = item.price * item.quantity;
        rowsHtml += `<tr>
                    <td>${item.name} 
                        <input type="hidden" name="itemsId[]" value="${item.id}">
                        <input type="hidden" name="itemAmount[]" value="${item.quantity}">
                    </td>
                    <td>${formatMoney(item.price)}</td>
                    <td>${item.quantity}</td>
                    <td>${formatMoney(sub)}</td>
                    <td class="text-end"><i class="bi bi-trash text-danger pointer" onclick="removeItem(${index})"></i></td>
                </tr>`;
      }
      $('#vehicle-table-body').html(rowsHtml);
      updateCalculations();
    }

    function removeItem(index) {
      selectedItems.splice(index, 1);
      renderItemsTable();
    }

    $('#btn-add-payment').click(function() {
      let method = $('#pay-method').val();
      let amount = parseMoney($('#pay-amount').val());
      let installments = $('#pay-installments').val();

      if (amount <= 0) return alert("Informe um valor válido.");
      if (method !== "Cartão de Crédito") installments = 1;

      selectedPayments.push({
        method: method,
        amount: amount,
        installments: installments
      });
      renderPaymentsTable();
      $('#pay-amount').val('');
    });

    function renderPaymentsTable() {
      let rowsHtml = '';
      let totalRecords = selectedPayments.length;

      for (let index = 0; index < totalRecords; index++) {
        let p = selectedPayments[index];
        rowsHtml += `<tr>
                    <td>${p.method} 
                        <input type="hidden" name="payMethod[]" value="${p.method}">
                        <input type="hidden" name="payAmount[]" value="${p.amount}">
                        <input type="hidden" name="payInstallments[]" value="${p.installments}">
                    </td>
                    <td>${p.installments}x</td>
                    <td>${formatMoney(p.amount)}</td>
                    <td class="text-end"><i class="bi bi-x-lg text-danger pointer" onclick="removePayment(${index})"></i></td>
                </tr>`;
      }
      $('#payment-table-body').html(rowsHtml);
      updateCalculations();
    }

    function removePayment(index) {
      selectedPayments.splice(index, 1);
      renderPaymentsTable();
    }

    $('#sale-discount').on('keyup', updateCalculations);

    function generateMockData() {
      const customers = <?php echo json_encode($mockCustomers); ?>;
      const employees = <?php echo json_encode($mockEmployees); ?>;
      const vehicles = <?php echo json_encode($mockVehicles); ?>;
      if (customers.length === 0 || employees.length === 0 || vehicles.length === 0) return;

      selectCustomer(customers[0].id, customers[0].nome);
      selectEmployee(employees[0].id, employees[0].nome);

      selectedItems = [{
        id: vehicles[0].id,
        name: vehicles[0].nome,
        price: parseFloat(vehicles[0].preco_venda),
        quantity: 1
      }];
      renderItemsTable();
    }

    $("#pay-method").on('change', function() {
      const isCredit = $(this).val() === "Cartão de Crédito";
      $("#pay-installments").prop('disabled', !isCredit);
    });

    $('#sale-form').on('submit', function(e) {
      let customerId = $("#customer-id-hidden").val();
      let sellerId = $("#seller-id-hidden").val();
      let discountPercent = parseFloat($('#sale-discount').val()) || 0;

      if (customerId == "") {
        alert('Por favor, selecione um cliente antes de finalizar.');
        e.preventDefault();
        return;
      }

      if (sellerId == "") {
        alert('Por favor, selecione um vendedor antes de finalizar.');
        e.preventDefault();
        return;
      }

      if (selectedItems.length == 0) {
        alert('A venda não possui produtos. Adicione ao menos um veículo.');
        e.preventDefault();
        return;
      }

      if (selectedPayments.length == 0) {
        alert('Você precisa informar como o cliente vai pagar.');
        e.preventDefault();
        return;
      }

      let totalToPay = 0;
      for (let index = 0; index < selectedItems.length; index++) {
        totalToPay += (selectedItems[index].price * selectedItems[index].quantity);
      }

      let finalTotalWithDiscount = totalToPay - (totalToPay * (discountPercent / 100));

      let totalAmountPaid = 0;
      for (let index = 0; index < selectedPayments.length; index++) {
        totalAmountPaid += selectedPayments[index].amount;
      }

      if (totalAmountPaid < finalTotalWithDiscount) {
        alert('O valor total pago é menor que o valor final da venda. Ajuste os pagamentos.');
        // O preventDefault cancela o envio do formulário
        e.preventDefault();
        return;
      }
    });
  </script>
</body>

</html>