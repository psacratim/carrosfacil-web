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
              <h4 class="m-0">Novo Cliente</h4>

              <a href="Index.php" class="btn btn-primary btn-sm"><i class="bi bi-arrow-left-short"></i> Voltar</a>
            </div>

            <button type="button" id="preencher-cliente" class="btn btn-warning mt-2">
              Preencher com dados aleatórios (4Devs)
            </button>

            <div class="card-body">
              <form action="acoes.php" method="post">
                <div class="form-row">

                  <fieldset class="form-group">
                    <h3>Dados Pessoais</h3>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="nome-completo"><strong class="text-danger">*</strong> Nome Completo:</label>
                        <input type="text" name="nome-completo" id="nome-completo" class="form-control" maxlength="60" required>
                      </div>
                      <div class="col-lg-3 col-md-3">
                        <label for="cpf"><strong class="text-danger">*</strong> CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" maxlength="14" required data-mask="000.000.000-00">
                      </div>
                      <div class="col-lg-3 col-md-3">
                        <label for="rg">RG</label>
                        <input type="text" name="rg" id="rg" class="form-control" maxlength="12" data-mask="00.000.000-A">
                      </div>
                      <div class="col-lg-3 col-md-3 mt-3">
                        <label for="sexo"><strong class="text-danger">*</strong> Sexo</label>
                        <select name="sexo" id="sexo" class="form-control" required>
                          <option value="N">Não Informado</option>
                          <option value="M">Masculino</option>
                          <option value="F">Feminino</option>
                        </select>
                      </div>
                      <div class="col-lg-3 col-md-3 mt-3">
                        <label for="estado-civil"><strong class="text-danger">*</strong> Estado Civil</label>
                        <select name="estado-civil" id="estado-civil" class="form-control" required>
                          <option value="Solteiro(a)" selected>Solteiro(a)</option>
                          <option value="Casado(a)">Casado(a)</option>
                          <option value="Separado(a)">Separado(a)</option>
                          <option value="Divorciado(a)">Divorciado(a)</option>
                          <option value="Viuvo(a)">Viúvo(a)</option>
                        </select>
                      </div>
                      <div class="col-lg-3 col-md-3 mt-3">
                        <label for="data-nascimento"><strong class="text-danger">*</strong> Data Nascimento</label>
                        <input type="date" name="data-nascimento" id="data-nascimento" class="form-control">
                      </div>
                      <div class="col-lg-3 col-md-3 mt-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" disabled>
                          <option value="1">Ativo</option>
                          <option value="0">Inativo</option>
                        </select>
                      </div>
                    </div>
                  </fieldset>

                  <fieldset class="form-group col-lg-12 mt-3">
                    <h3>Dados de acesso</h3>
                    <div class="row">
                      <div class="col-md-6 mt-3">
                        <label for="usuario"><strong class="text-danger">*</strong> Usuário</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" maxlength="20" required>
                      </div>

                      <div class="col-md-6 mt-3">
                        <label for="senha"><strong class="text-danger">*</strong> Senha</label>
                        <input type="password" name="senha" id="senha" class="form-control" maxlength="26" required>
                      </div>
                    </div>
                  </fieldset>


                  <fieldset class="form-group col-lg-12 mt-3">
                    <h3>Dados de contato</h3>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 mt-3">
                        <label for="telefone-1"><strong class="text-danger">*</strong> Telefone 1</label>
                        <input type="text" name="telefone-1" id="telefone-1" class="form-control" minlength="15" maxlength="15" required data-mask="(00) 00000-0000">
                      </div>

                      <div class="col-lg-3 col-md-4 mt-3">
                        <label for="telefone-2">Telefone 2</label>
                        <input type="text" name="telefone-2" id="telefone-2" class="form-control" minlength="15" maxlength="15" data-mask="(00) 00000-0000">
                      </div>

                      <div class="col-lg-6 mt-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" maxlength="100">
                      </div>
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


                  <input type="hidden" name="cadastrar" value="cadastrar_cliente" class="btn btn-primary mt-3">
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
  
  <!-- DELETAR DEPOIS (TODO) -->
   <script>
    $('#preencher-cliente').on('click', function() {

      function rand(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
      }

      // ---------- GERAÇÕES SIMPLES ----------
      const nomes = ["Carlos","Ana","Mariana","Rafael","José","Luiza","Paula","Fernando","Julia","Bruno","Letícia","Pedro","Larissa","Hugo","Camila"];
      const sobrenomes = ["Silva","Souza","Oliveira","Costa","Santos","Ferreira","Mendes","Gomes","Barbosa","Castro","Moraes","Cardoso"];
      
      function nomeCompleto() {
        return nomes[rand(0,nomes.length-1)] + ' ' + sobrenomes[rand(0,sobrenomes.length-1)];
      }

      function cpfAleatorio() {
        return `${rand(100,999)}.${rand(100,999)}.${rand(100,999)}-${rand(10,99)}`;
      }

      function rgAleatorio() {
        return `${rand(10,99)}.${rand(100,999)}.${rand(100,999)}-${String.fromCharCode(rand(65,90))}`;
      }

      function telefone() {
        return `(${rand(10,99)}) ${rand(90000,99999)}-${rand(1000,9999)}`;
      }

      function emailDe(nome) {
        return nome.toLowerCase().replace(/\s/g,'') + rand(100,999) + "@teste.com";
      }

      function dataNascimento() {
        let ano = rand(1975, 2005);
        let mes = String(rand(1,12)).padStart(2,'0');
        let dia = String(rand(1,28)).padStart(2,'0');
        return `${ano}-${mes}-${dia}`;
      }

      const estados = ["SP","RJ","MG","BA","PR","PE","CE","RS","SC","GO"];

      // ---------- PREENCHIMENTO ----------
      let nome = nomeCompleto();
      $('#nome-completo').val(nome);
      $('#cpf').val(cpfAleatorio());
      $('#rg').val(rgAleatorio());
      $('#sexo').val(['M','F','N'][rand(0,2)]);
      $('#estado-civil').val(['Solteiro(a)','Casado(a)','Divorciado(a)','Separado(a)'][rand(0,3)]);
      $('#data-nascimento').val(dataNascimento());

      $('#usuario').val(nome.toLowerCase().replace(/\s/g,'') + rand(10,99));
      $('#senha').val('123456');

      $('#telefone-1').val(telefone());
      $('#telefone-2').val(telefone());
      $('#email').val(emailDe(nome));

      $('#cep').val(`${rand(10000,99999)}-${rand(100,999)}`);
      $('#endereco').val("Rua " + sobrenomes[rand(0, sobrenomes.length-1)]);
      $('#numero-endereco').val(rand(1, 9999));
      $('#bairro').val("Centro");
      $('#cidade').val("São Paulo");
      $('#estado').val(estados[rand(0, estados.length-1)]);
      $('#complemento').val("");

      console.log("✅ Formulário de cliente preenchido automaticamente.");
    });
    </script>

</body>

</html>