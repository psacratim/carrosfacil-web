$(function() {
    const costInput = $('#preco_custo');
    const profitInput = $('#lucro_esperado');
    const discountInput = $('#desconto');
    const saleInput = $('#preco_venda');
    const finalInput = $('#preco_desconto');

    function parseValue(value) {
        return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
    }

    function formatValue(value) {
        return value.toLocaleString('pt-br', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function calculatePrices() {
        const cost = parseValue(costInput.val());
        const profit = parseFloat(profitInput.val()) || 0;
        const discount = parseFloat(discountInput.val()) || 0;

        const salePrice = cost * (1 + profit / 100);
        const finalPrice = salePrice * (1 - discount / 100);

        saleInput.val(formatValue(salePrice));
        finalInput.val(formatValue(finalPrice));

        if (discount > 0 && finalPrice < cost) {
            const costFormatted = formatValue(cost);
            
            discountInput[0].setCustomValidity(`Preço com desconto abaixo do custo (R$ ${costFormatted}). Reduza o desconto.`);
            discountInput[0].reportValidity();
            discountInput.addClass('is-invalid');
        } else {
            discountInput[0].setCustomValidity('');
            discountInput.removeClass('is-invalid');
        }
    }

    costInput.on('input', calculatePrices);
    profitInput.on('input', calculatePrices);
    
    discountInput.on('input', function() {
        let value = parseInt($(this).val().replace(/\D/g, '')) || 0;
        if (value > 100) value = 100;
        $(this).val(value);
        calculatePrices();
    });

    $('form').on('submit', function(e) {
        calculatePrices();
        
        if (!this.checkValidity()) {
            e.preventDefault();
            this.reportValidity();
            return;
        }

        const cost = parseValue(costInput.val());
        const finalPrice = parseValue(finalInput.val());

        if (finalPrice < cost && parseValue(discountInput.val()) > 0) {
            alert("Atenção: O valor final está abaixo do custo.");
            e.preventDefault();
        }
    });
});