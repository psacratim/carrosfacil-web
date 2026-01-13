<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once("../../conexao/conecta.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$customer = null;

if ($id > 0) {
  $query = "SELECT * FROM cliente WHERE id = $id";
  $result = mysqli_query($connection, $query);
  $customer = mysqli_fetch_assoc($result);
}

$pageTitle = $customer ? "Editar Cliente: " . $customer['nome'] : "Novo Cliente";
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
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php require_once('../../Components/Sidebar.php'); ?>

      <main class="col-lg-10">
        <header id="admin-header" class="py-3 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="left-info"><?php echo mb_strtoupper($pageTitle); ?></div>
          <div class="d-flex gap-2">
            <button type="button" id="fillCustomer" class="btn btn-warning btn-sm">
              <i class="bi bi-magic"></i> Mock Data
            </button>
            <a href="Index.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
          </div>
        </header>

        <div class="container mt-4 mb-5">
          <form action="actions.php" method="post">
            <input maxlength="999" type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row g-4">
              <div class="col-md-12">
                <div class="card shadow-sm">
                  <div class="card-header bg-light"><strong>Dados Pessoais</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-6">
                      <label for="name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                      <input maxlength="80" type="text" name="name" id="name" class="form-control" value="<?php echo $customer['nome'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">CPF <span class="text-danger">*</span></label>
                      <input maxlength="14" type="text" name="cpf" id="cpf" class="form-control" data-mask="000.000.000-00" value="<?php echo $customer['cpf'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">RG</label>
                      <input maxlength="12" type="text" name="rg" id="rg" class="form-control" data-mask="00.000.000-A" value="<?php echo $customer['rg'] ?? ''; ?>">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Sexo</label>
                      <select name="gender" id="gender" class="form-select">
                        <option value="N" <?php if ($customer && $customer['sexo'] == 'N') echo 'selected'; ?>>Não Informado</option>
                        <option value="M" <?php if ($customer && $customer['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
                        <option value="F" <?php if ($customer && $customer['sexo'] == 'F') echo 'selected'; ?>>Feminino</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Estado Civil</label>
                      <select name="maritalStatus" id="maritalStatus" class="form-select">
                        <?php
                        $maritalStatusItems = ["Solteiro(a)", "Casado(a)", "Separado(a)", "Divorciado(a)", "Viúvo(a)"];
                        foreach ($maritalStatusItems as $maritalStatusItem) {
                          $selected = ($customer && $customer['estado_civil'] == $maritalStatusItem) ? 'selected' : '';
                          echo "<option value='$maritalStatusItem' $selected>$maritalStatusItem</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Data Nascimento</label>
                      <input type="date" name="birthDate" id="birthDate" class="form-control" value="<?php echo $customer['data_nascimento'] ?? ''; ?>">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Status</label>
                      <select name="status" id="status" class="form-select">
                        <option value="1" <?php if ($customer && $customer['status'] == 1) echo 'selected'; ?>>Ativo</option>
                        <option value="0" <?php if ($customer && $customer['status'] == 0) echo 'selected'; ?>>Inativo</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light"><strong>Acesso e Segurança</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Usuário <span class="text-danger">*</span></label>
                      <input maxlength="20" type="text" name="username" id="username" class="form-control" value="<?php echo $customer["usuario"] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Senha <span class="text-danger">*</span></label>
                      <input maxlength="255" type="password" name="password" id="password" class="form-control" value="<?php echo $customer["senha"] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-12">
                      <label class="form-label">E-mail</label>
                      <input maxlength="100" type="email" name="email" id="email" class="form-control" value="<?php echo $customer['email'] ?? ''; ?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light"><strong>Contatos</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Telefone 1 <span class="text-danger">*</span></label>
                      <input maxlength="15" type="text" name="phone-1" id="phone-1" class="form-control" data-mask="(00) 00000-0000" value="<?php echo $customer['telefone1'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Telefone 2</label>
                      <input maxlength="15" type="text" name="phone-2" id="phone-2" class="form-control" data-mask="(00) 00000-0000" value="<?php echo $customer['telefone2'] ?? ''; ?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="card shadow-sm">
                  <div class="card-header bg-light"><strong>Localização</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-2">
                      <label class="form-label">CEP</label>
                      <input maxlength="9"="text" name="zipcode" id="zipcode" class="form-control" data-mask="00000-000" value="<?php echo $customer['cep'] ?? ''; ?>">
                    </div>
                    <div class="col-md-8">
                      <label class="form-label">Endereço <span class="text-danger">*</span></label>
                      <input maxlength="60" type="text" name=address id=address class="form-control" value="<?php echo $customer['endereco'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label">Número <span class="text-danger">*</span></label>
                      <input maxlength="5" type="text" name="number" id="number" class="form-control" value="<?php echo $customer['numero'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Bairro <span class="text-danger">*</span></label>
                      <input maxlength="50" type="text" name="neighborhood" id="neighborhood" class="form-control" value="<?php echo $customer['bairro'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Cidade <span class="text-danger">*</span></label>
                      <input maxlength="50" type="text" name="city" id="city" class="form-control" value="<?php echo $customer['cidade'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Estado <span class="text-danger">*</span></label>
                      <select name="state" id="state" class="form-select" required>
                        <option value="SP">São Paulo</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <button type="submit" name="actionSave" class="btn btn-primary w-100 py-3 shadow-sm">
                  <i class="bi bi-check2-circle"></i> <?php echo $customer ? "Atualizar Cadastro" : "Finalizar Cadastro"; ?>
                </button>
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
  <script>
    $('#fillCustomer').on('click', async function() {
      const btn = $(this);
      // Feedback visual de carregamento
      btn.html('<span class="spinner-border spinner-border-sm"></span> Gerando...').prop('disabled', true);

      try {
        // 1. Busca dados base na API (Nomes, Emails, Cidades reais)
        const response = await fetch('https://randomuser.me/api/?nat=br');
        const data = await response.json();
        const person = data.results[0];

        // 2. Funções para dados aleatórios brasileiros
        const rand = (n) => Math.floor(Math.random() * n);

        const geraCPF = () => `${rand(900)+100}.${rand(900)+100}.${rand(900)+100}-${rand(90)+10}`;
        const geraRG = () => `${rand(90)}.${rand(900)+100}.${rand(900)+100}-${rand(9)}`;

        // Gera telefone no formato (XX) 9XXXX-XXXX
        const generatePhoneNumber = () => `(${rand(89)+10}) 9${rand(8999)+1000}-${rand(8999)+1000}`;

        // 3. Lista de Estados Civis (igual ao seu PHP)
        const maritalStatusItems = ["Solteiro(a)", "Casado(a)", "Separado(a)", "Divorciado(a)", "Viúvo(a)"];

        // --- PREENCHIMENTO DOS CAMPOS ---

        // Dados Pessoais
        $('#name').val(`${person.name.first} ${person.name.last}`);
        $('#cpf').val(geraCPF());
        $('#rg').val(geraRG());
        $('#gender').val(person.gender === 'male' ? 'M' : 'F');
        $('#maritalStatus').val(maritalStatusItems[rand(maritalStatusItems.length)]); // Sorteio do Estado Civil

        const birthDate = new Date(person.dob.date).toISOString().split('T')[0];
        $('#birthDate').val(birthDate);

        // Acesso
        $('#username').val(person.login.username);
        $('#password').val('123456');
        $('#email').val(person.email);

        // Contatos (Telefone 1 e 2 aleatórios)
        $('#phone-1').val(generatePhoneNumber());
        $('#phone-2').val(generatePhoneNumber());

        // Localização
        $('#zipcode').val(person.location.postcode);
        $('#address').val(person.location.street.name);
        $('#number').val(rand(999) + 1);
        $('#neighborhood').val('Centro');
        $('#city').val(person.location.city);
        $('#state').val("SP"); // Mantendo SP conforme seu select

      } catch (error) {
        console.error(error);
        alert('Erro ao buscar dados externos. Verifique sua conexão.');
      } finally {
        // Restaura o botão
        btn.html('<i class="bi bi-magic"></i> Mock Data').prop('disabled', false);
      }
    });
  </script>
</body>

</html>