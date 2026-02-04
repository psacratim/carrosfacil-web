<?php
if (!isset($_SESSION)) {
  session_start();
}

require_once("../usuario_admin.php");
require_once("../../conexao/conecta.php");
require_once('../../Components/Sidebar.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$employee = null;

if ($id > 0) {
  $query = "SELECT * FROM funcionario WHERE id = $id";
  $result = mysqli_query($connection, $query);
  $employee = mysqli_fetch_assoc($result);
}

$pageTitle = $employee ? "Editar: " . $employee['nome'] : "Novo Funcionário";
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
      <?php echo Sidebar("employee"); ?>

      <main class="col-lg-10 ms-sm-auto px-md-4">
        <header id="admin-header" class="py-2 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="left-info"><?php echo mb_strtoupper($pageTitle); ?></div>
          <div id="right-info">
            <button type="button" id="mock-funcionario" class="btn btn-warning btn-sm py-2">
              <i class="bi bi-magic"></i> Mock Data
            </button>
            <a href="Index.php" class="py-2 btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Voltar</a>
          </div>
        </header>

        <hr class="m-0 mb-4">

        <div class="container-fluid p-0">
          <form id="form-funcionario" action="actions.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row g-4 mb-4">
              <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light"><strong>Informações Pessoais</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-7">
                      <label class="form-label">Nome Completo</label>
                      <input maxlength="80" type="text" name="name" class="form-control" value="<?php echo $employee['nome'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-5">
                      <label class="form-label">Nome Social</label>
                      <input maxlength="80" type="text" name="socialName" class="form-control" value="<?php echo $employee['nome_social'] ?? ''; ?>">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">CPF</label>
                      <input maxlength="14" type="text" name="cpf" class="form-control" data-mask="000.000.000-00" value="<?php echo $employee['cpf'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">RG</label>
                      <input maxlength="12" type="text" name="rg" class="form-control" data-mask="00.000.000-A" value="<?php echo $employee['rg'] ?? ''; ?>">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Nascimento</label>
                      <input type="date" id="birthDate" name="birthDate" class="form-control" value="<?php echo $employee['data_nascimento'] ?? ''; ?>" required>
                    </div>
                    <div class="col-3">
                      <label class="form-label">Salário (R$)</label>
                      <input maxlength="13" type="text" name="salary" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" value="<?php echo $employee['salario'] ?? ''; ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Sexo</label>
                      <select name="gender" class="form-select">
                        <option value="N" <?php if (($employee['sexo'] ?? '') == 'N') echo 'selected'; ?>>Não Informado</option>
                        <option value="M" <?php if (($employee['sexo'] ?? '') == 'M') echo 'selected'; ?>>Masculino</option>
                        <option value="F" <?php if (($employee['sexo'] ?? '') == 'F') echo 'selected'; ?>>Feminino</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Estado Civil</label>
                      <select name="maritalStatus" id="maritalStatus" class="form-select">
                        <?php
                        $maritalStatusItems = ["Solteiro(a)", "Casado(a)", "Separado(a)", "Divorciado(a)", "Viúvo(a)"];
                        foreach ($maritalStatusItems as $maritalStatusItem) {
                          $selected = ($employee && $employee['estado_civil'] == $maritalStatusItem) ? 'selected' : '';
                          echo "<option value='$maritalStatusItem' $selected>$maritalStatusItem</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Cargo</label>
                      <select name="role" id="role-select" class="form-select">
                        <option value="" disabled <?= empty($employee['id_cargo']) ? "selected" : "" ?>>Selecione um cargo</option>
                        <?php
                        $roles = mysqli_query($connection, "SELECT id, nome FROM cargo WHERE status = 1");
                        foreach ($roles as $role) {
                          $selectedAttr = $employee && $employee['id_cargo'] == $role['id'] ? 'selected' : '';
                          echo "<option value='{$role['id']}' $selectedAttr>{$role['nome']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light"><strong>Foto de Perfil</strong></div>
                  <div class="card-body d-flex flex-column text-center">
                    <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                      <img id="preview-photo" src="<?php echo ($employee && $employee['foto']) ? '../../images/' . $employee['foto'] : '../../assets/img/placeholder-funcionario.png'; ?>" class="img-fluid rounded border shadow-sm" style="max-height: 180px;">
                    </div>
                    <div class="mt-3">
                      <input type="file" name="photo" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row g-4 mb-4">
              <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light"><strong>Endereço</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-3">
                      <label class="form-label">CEP</label>
                      <input maxlength="9" type="text" name="zipcode" id="zipcode" class="form-control" data-mask="00000-000" value="<?php echo $employee['cep'] ?? ''; ?>">
                    </div>
                    <div class="col-md-7">
                      <label class="form-label">Endereço</label>
                      <input maxlength="60" type="text" name="address" id="address" class="form-control" value="<?php echo $employee['endereco'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label">Número</label>
                      <input type="text" name="number" class="form-control" id="number" data-mask="####0" value="<?php echo $employee['numero'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Complemento</label>
                      <input maxlength="200" type="text" name="complement" id="complement" class="form-control" value="<?php echo $employee['complemento'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Bairro</label>
                      <input maxlength="50" type="text" name="neighborhood" id="neighborhood" class="form-control" value="<?php echo $employee['bairro'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-8">
                      <label class="form-label">Cidade</label>
                      <input maxlength="50" type="text" name="city" id="city" class="form-control" value="<?php echo $employee['cidade'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Estado <span class="text-danger">*</span></label>
                      <select name="state" id="state" class="form-select" required>
                        <option value="" disabled <?= empty($employee['estado']) ? "selected" : "" ?>>Selecione um estado</option>
                        <option value="AC" <?= $employee && $employee['estado'] == 'AC' ? "selected" : "" ?>>Acre</option>
                        <option value="AL" <?= $employee && $employee['estado'] == 'AL' ? "selected" : "" ?>>Alagoas</option>
                        <option value="AP" <?= $employee && $employee['estado'] == 'AP' ? "selected" : "" ?>>Amapá</option>
                        <option value="AM" <?= $employee && $employee['estado'] == 'AM' ? "selected" : "" ?>>Amazonas</option>
                        <option value="BA" <?= $employee && $employee['estado'] == 'BA' ? "selected" : "" ?>>Bahia</option>
                        <option value="CE" <?= $employee && $employee['estado'] == 'CE' ? "selected" : "" ?>>Ceará</option>
                        <option value="DF" <?= $employee && $employee['estado'] == 'DF' ? "selected" : "" ?>>Distrito Federal</option>
                        <option value="ES" <?= $employee && $employee['estado'] == 'ES' ? "selected" : "" ?>>Espírito Santo</option>
                        <option value="GO" <?= $employee && $employee['estado'] == 'GO' ? "selected" : "" ?>>Goiás</option>
                        <option value="MA" <?= $employee && $employee['estado'] == 'MA' ? "selected" : "" ?>>Maranhão</option>
                        <option value="MT" <?= $employee && $employee['estado'] == 'MT' ? "selected" : "" ?>>Mato Grosso</option>
                        <option value="MS" <?= $employee && $employee['estado'] == 'MS' ? "selected" : "" ?>>Mato Grosso do Sul</option>
                        <option value="MG" <?= $employee && $employee['estado'] == 'MG' ? "selected" : "" ?>>Minas Gerais</option>
                        <option value="PA" <?= $employee && $employee['estado'] == 'PA' ? "selected" : "" ?>>Pará</option>
                        <option value="PB" <?= $employee && $employee['estado'] == 'PB' ? "selected" : "" ?>>Paraíba</option>
                        <option value="PR" <?= $employee && $employee['estado'] == 'PR' ? "selected" : "" ?>>Paraná</option>
                        <option value="PE" <?= $employee && $employee['estado'] == 'PE' ? "selected" : "" ?>>Pernambuco</option>
                        <option value="PI" <?= $employee && $employee['estado'] == 'PI' ? "selected" : "" ?>>Piauí</option>
                        <option value="RJ" <?= $employee && $employee['estado'] == 'RJ' ? "selected" : "" ?>>Rio de Janeiro</option>
                        <option value="RN" <?= $employee && $employee['estado'] == 'RN' ? "selected" : "" ?>>Rio Grande do Norte</option>
                        <option value="RS" <?= $employee && $employee['estado'] == 'RS' ? "selected" : "" ?>>Rio Grande do Sul</option>
                        <option value="RO" <?= $employee && $employee['estado'] == 'RO' ? "selected" : "" ?>>Rondônia</option>
                        <option value="RR" <?= $employee && $employee['estado'] == 'RR' ? "selected" : "" ?>>Roraima</option>
                        <option value="SC" <?= $employee && $employee['estado'] == 'SC' ? "selected" : "" ?>>Santa Catarina</option>
                        <option value="SP" <?= $employee && $employee['estado'] == 'SP' ? "selected" : "" ?>>São Paulo</option>
                        <option value="SE" <?= $employee && $employee['estado'] == 'SE' ? "selected" : "" ?>>Sergipe</option>
                        <option value="TO" <?= $employee && $employee['estado'] == 'TO' ? "selected" : "" ?>>Tocantins</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light"><strong>Dados de Acesso</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-12">
                      <label class="form-label">Usuário</label>
                      <input maxlength="20" type="text" name="username" class="form-control" value="<?php echo $employee["usuario"] ?? ''; ?>" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Senha</label>
                      <input maxlength="255" type="password" name="password" class="form-control" value="<?php echo $employee["senha"] ?? ''; ?>" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Tipo de Acesso</label>
                      <select name="accessType" class="form-select" required>
                        <option value="0" <?php if (($employee['tipo_acesso'] ?? '') == 0) echo 'selected'; ?>>Comum</option>
                        <option value="1" <?php if (($employee['tipo_acesso'] ?? '') == 1) echo 'selected'; ?>>Administrador</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row g-4 mb-4">
              <div class="col-lg-8">
                <div class="card shadow-sm">
                  <div class="card-header bg-light"><strong>Canais de Contato</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-6">
                      <label class="form-label">E-mail</label>
                      <input maxlength="120" type="email" name="email" class="form-control" value="<?php echo $employee['email'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Telefone Celular</label>
                      <input minlength="15" type="text" name="cellPhone" class="form-control" data-mask="(00) 00000-0000" value="<?php echo $employee['telefone_celular'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Telefone Residencial</label>
                      <input minlength="14" type="text" name="homePhone" class="form-control" data-mask="(00) 0000-0000" value="<?php echo $employee['telefone_residencial'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Telefone Recado (Obrigatório)</label>
                      <input type="text" name="messagesPhone" class="form-control"
                        data-mask="(00) 00000-0000"
                        pattern="\(\d{2}\)\s\d{5}-\d{4}"
                        title="Formato esperado: (00) 00000-0000"
                        value="<?php echo $employee['telefone_recado'] ?? ''; ?>" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light"><strong>Status do Cadastro</strong></div>
                  <div class="card-body">
                    <label class="form-label">Código</label>
                    <input disabled class="form-control" type="text" value="<?= $employee ? $employee['id'] : '' ?>">

                    <label class="form-label mt-3">Status</label>
                    <select <?= !$employee ? "disabled" : "" ?> name="status" class="form-select">
                      <option value="1" <?= $employee && $employee['status'] == 1 ? 'selected' : ''; ?>>Ativo</option>
                      <option value="0" <?= $employee && $employee['status'] == 0 ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-5">
                <button type="submit" name="actionSave" class="btn btn-primary w-100 py-3 shadow">
                  <i class="bi bi-save"></i> Salvar Registro do Funcionário
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
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#preview-photo').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#birthDate").on('change', function() {
      let year = parseInt(this.value.split("-")[0]);

      this.setCustomValidity('');
      if (year > new Date().getFullYear()) {
        this.setCustomValidity('Falha: O ano não pode ser maior que o atual.');
        this.reportValidity();
      }
    });

    $('#mock-funcionario').on('click', async function() {
      const btn = $(this);
      const originalHtml = btn.html();
      btn.html('<span class="spinner-border spinner-border-sm"></span> Carregando...').prop('disabled', true);

      // Mapeamento de Estados para bater com o Select (API retorna nome completo)
      const stateMap = {
        "acre": "AC",
        "alagoas": "AL",
        "amapá": "AP",
        "amazonas": "AM",
        "bahia": "BA",
        "ceará": "CE",
        "distrito federal": "DF",
        "espírito santo": "ES",
        "goiás": "GO",
        "maranhão": "MA",
        "mato grosso": "MT",
        "mato grosso do sul": "MS",
        "minas gerais": "MG",
        "pará": "PA",
        "paraíba": "PB",
        "paraná": "PR",
        "pernambuco": "PE",
        "piauí": "PI",
        "rio de janeiro": "RJ",
        "rio grande do norte": "RN",
        "rio grande do sul": "RS",
        "rondônia": "RO",
        "roraima": "RR",
        "santa catarina": "SC",
        "são paulo": "SP",
        "sergipe": "SE",
        "tocantins": "TO"
      };

      try {
        const response = await fetch('https://randomuser.me/api/?nat=br');
        const data = await response.json();
        const p = data.results[0];
        const rand = (n) => Math.floor(Math.random() * n);

        // Dados Básicos
        $('input[name="name"]').val(`${p.name.first} ${p.name.last}`);
        $('input[name="socialName"]').val(p.name.first);
        $('input[name="cpf"]').val(`${rand(899)+100}${rand(899)+100}${rand(899)+100}${rand(89)+10}`).trigger('input');
        $('input[name="rg"]').val(`${rand(89)}${rand(899)+100}${rand(899)+100}${rand(9)}`).trigger('input');
        $('input[name="birthDate"]').val(new Date(p.dob.date).toISOString().split('T')[0]);

        // Login e Financeiro
        $('input[name="username"]').val(p.login.username);
        $('input[name="password"]').val('Senha@123');
        $('input[name="salary"]').val((Math.random() * 5000 + 1500).toFixed(2).replace('.', ',')).trigger('input');

        // Endereço
        $('input[name="zipcode"]').val(p.location.postcode).trigger('input');
        $('input[name="address"]').val(p.location.street.name);
        $('input[name="number"]').val(p.location.street.number);
        $('input[name="neighborhood"]').val('Centro');
        $('input[name="city"]').val(p.location.city);

        // Trata o Select de Estado
        const stateSigla = stateMap[p.location.state.toLowerCase()];
        if (stateSigla) $('select[name="state"]').val(stateSigla);

        // Contatos
        $('input[name="email"]').val(p.email);
        // Limpa caracteres não numéricos antes de disparar a máscara
        $('input[name="cellPhone"]').val(p.cell.replace(/\D/g, '')).trigger('input');
        $('input[name="messagesPhone"]').val(p.phone.replace(/\D/g, '')).trigger('input');

        // Foto
        $('#preview-photo').attr('src', p.picture.large);

      } catch (e) {
        alert('Erro ao gerar dados. Verifique sua conexão.');
      } finally {
        btn.html(originalHtml).prop('disabled', false);
      }
    });

    $(function() {
      const cepInput = $('#zipcode')

      cepInput.on('blur', function() {
        const cep = $(this).val().replace(/\D/g, '')

        if (cep.length !== 8) return

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(res => res.json())
          .then(data => {
            console.log(data);
            if (data.erro) return

            $('#address').val(data.logradouro)
            $('#neighborhood').val(data.bairro)
            $('#city').val(data.localidade)
            $('#state').val(data.uf)

            $('#number').focus()

            console.log(data);
          })
          .catch(() => {})
      })
    })
  </script>
</body>

</html>