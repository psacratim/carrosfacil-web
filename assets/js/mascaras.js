$(document).ready(function() {
    $('#cep').on('input propertychange', async function(){
    let currentValue = $(this).val().replace("-", "")
    let currentLength = currentValue.length
    let maxLength = $(this).attr('maxlength') - 1

    if (currentLength == maxLength) {
        const response = await fetch('https://viacep.com.br/ws/'+currentValue+'/json/');
        const data = await response.json();
        
        $("#endereco").val(data.logradouro);
        $("#bairro").val(data.bairro);
        $("#cidade").val(data.localidade);
        $("#complemento").val(data.complemento);
        $("#estado").val(data.uf.toUpperCase());
    }
    })

    $('#foto-perfil').change(function(e) {
        let file = this.files[0]; // ou $(this)[0].files[0]
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $("#foto-img").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
})