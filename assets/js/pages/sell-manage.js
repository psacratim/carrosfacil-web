
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

$(function () {
    if (selectedItems.length > 0) renderItemsTable();
    if (selectedPayments.length > 0) renderPaymentsTable();
    updateCalculations();
});

function initSearch(inputId, resultsId, searchType) {
    $(`#${inputId}`).on('keyup', function () {
        let term = $(this).val();
        if (term.length > 2) {
            $.get('search.php', {
                type: searchType,
                q: term
            }, function (data) {
                $(`#${resultsId}`).html(data).show();
            });
        } else {
            $(`#${resultsId}`).hide();
        }
    });
}

initSearch('customer-search', 'customer-results', 'cliente');
initSearch('seller-search', 'seller-results', 'vendedor');
initSearch('vehicle-search', 'vehicle-results', 'veiculo');

function selecionarCliente(id, name) {
    $('#customer-id-hidden').val(id);
    $('#customer-search').val(name).addClass('field-selected');
    $('#customer-icon').html('<i class="bi bi-check-lg text-success"></i>');
    $('#customer-results').hide();
}

function selecionarVendedor(id, name) {
    $('#seller-id-hidden').val(id);
    $('#seller-search').val(name).addClass('field-selected');
    $('#seller-icon').html('<i class="bi bi-check-lg text-success"></i>');
    $('#seller-results').hide();
}

function selecionarVeiculo(id, name, price, stock) {
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

$("#sale-discount").on('input', function () {
    if (parseInt($(this).val()) > 100) {
        $(this).val(100);
    }
});

$('#btn-add-vehicle').click(function () {
    if (!currentVehicle) return alert("Por favor, selecione um veículo.");
    let qty = parseInt($('#input-qty').val());
    if (qty > currentVehicle.stock) return alert("Estoque insuficiente.");

    // O push coloca um novo objeto dentro da lista (array)
    selectedItems.push({
        id: currentVehicle.id,
        name: currentVehicle.name,
        price: currentVehicle.price,
        quantity: qty
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
                        <input type="hidden" name="item_id[]" value="${item.id}">
                        <input type="hidden" name="item_qty[]" value="${item.quantity}">
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

$('#btn-add-payment').click(function () {
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
                        <input type="hidden" name="pay_method[]" value="${p.method}">
                        <input type="hidden" name="pay_amount[]" value="${p.amount}">
                        <input type="hidden" name="pay_installments[]" value="${p.installments}">
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
    const customers = <? php echo json_encode($mockCustomers); ?>;
    const employees = <? php echo json_encode($mockEmployees); ?>;
    const vehicles = <? php echo json_encode($mockVehicles); ?>;
    if (customers.length === 0 || employees.length === 0 || vehicles.length === 0) return;

    selecionarCliente(customers[0].id, customers[0].nome);
    selecionarVendedor(employees[0].id, employees[0].nome);

    selectedItems = [{
        id: vehicles[0].id,
        name: vehicles[0].nome,
        price: parseFloat(vehicles[0].preco_venda),
        quantity: 1
    }];
    renderItemsTable();
}

$("#pay-method").on('change', function () {
    const isCredit = $(this).val() === "Cartão de Crédito";
    $("#pay-installments").prop('disabled', !isCredit);
});

$('#sale-form').on('submit', function (e) {
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