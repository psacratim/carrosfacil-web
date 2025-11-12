$(document).ready(function() {
    var precoDescontoInput = $('#preco_desconto')
    var descontoInput = $('#desconto')

    function updateFinalPrice(){
        const vehicleCostRaw = $('#preco_custo').val(); // -> text
        if (!vehicleCostRaw) { 
            return;
        }

        const vehicleCost = parseFloat(vehicleCostRaw.replaceAll('.', '').replaceAll(',', '.')); // double
        const expectedProfit = $('#lucro_esperado').val(); // -> number
        if (!expectedProfit) { 
            return;
        }

        const profitFactor = (expectedProfit / 100) + 1;
        let sellPrice = vehicleCost * profitFactor
        let discountPrice = 0

        const discount = parseInt(descontoInput.val()) / 100;
        if (discount > 0) {
            discountPrice = sellPrice - (sellPrice * discount)
        
            const discountPriceF = discountPrice
            .toFixed(2)              // 1234.56
            .replace('.', ',')       // 1234,56
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // 1.234,56
            $('#preco_desconto').val(discountPriceF); // atualiza com máscara

            if (discountPrice < vehicleCost) {
                descontoInput[0].setCustomValidity('O preço com promoção não pode ser menor que o de custo.');
                descontoInput[0].reportValidity();
                descontoInput.toggleClass('error-input', true);
                precoDescontoInput.toggleClass('error-input', true);
                return;
            }
        } else $('#preco_desconto').val('0')

        // Reseta a mensagem
        descontoInput[0].setCustomValidity('');
        descontoInput.toggleClass('error-input', false);
        precoDescontoInput.toggleClass('error-input', false);
        
        // Formata o resultado com 2 casas decimais e vírgula
        const sellPriceF = sellPrice
            .toFixed(2)              // 1234.56
            .replace('.', ',')       // 1234,56
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // 1.234,56

        $('#preco_venda').val(sellPriceF); // atualiza com máscara
    }

    $('#preco_custo').on('input', function(){
        updateFinalPrice();
    })

    $('#lucro_esperado').on('input', function(){
        updateFinalPrice();
    })

    descontoInput.on('input', function() {
        let discountRaw = $(this).val().replace(/\D/g, '');
        if (discountRaw === '') {
            $(this).val('0');
            updateFinalPrice();
            return;
        }

        let discount = parseInt(discountRaw);
        if (discount > 100) discount = 100;
        if (discount < 0) discount = 0;
        
        $(this).val(discount);
        updateFinalPrice();
    });
    
    $('#foto-veiculo-input').change(function(e) {
        let file = this.files[0]; // ou $(this)[0].files[0]
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $("#veiculo-foto-preview").attr("style", "display: none !important");
                $("#foto-veiculo").css("display", "block");
                $("#foto-veiculo").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    $("form").on("submit", function(event) {
        const costRaw = document.querySelector("#preco_custo").value;
        const profitRaw = document.querySelector("#lucro_esperado").value;
        const discountRaw = document.querySelector("#desconto").value;

        const cost = parseFloat(costRaw.replace(/\./g, '').replace(',', '.')) || 0;
        const profit = parseFloat(profitRaw) || 0;
        const discount = parseFloat(discountRaw) || 0;

        let finalPrice = cost + (cost * (profit / 100));
        finalPrice -= finalPrice * (discount / 100);

        if (finalPrice < cost && discount > 0) {
            alert("O valor com desconto é menor que o preço de custo. Diminua o desconto ou aumente o custo ou lucro.");
            event.preventDefault(); // cancela o envio
            return;
        }

        if (isNaN(finalPrice) || finalPrice <= 0) {
            alert("Valor final inválido. Verifique o custo, lucro e desconto.");
            event.preventDefault(); // cancela o envio
            return;
        }
        
        // document.querySelector("#preco_final").value = precoFinal.toLocaleString('pt-BR', {
        //     minimumFractionDigits: 2,
        //     maximumFractionDigits: 2
        // });
    });
});