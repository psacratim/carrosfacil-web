<?php 
if (!isset($_SESSION)) { session_start(); }
require_once("../../conexao/conecta.php");

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
      <?php require_once('../../Components/Sidebar.php'); ?>

      <main class="col-lg-10">
        <header id="admin-header" class="py-3 d-flex align-items-center justify-content-between gap-2 px-3">
          <div id="left-info"><?php echo mb_strtoupper($pageTitle); ?></div>
          <div class="d-flex gap-2">
            <button type="button" id="mock-funcionario" class="btn btn-warning btn-sm">
                <i class="bi bi-magic"></i> Mock Data
            </button>
            <a href="Index.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
          </div>
        </header>

        <div class="container mt-4 mb-5">
          <form id="form-funcionario" action="actions.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row g-4">
              <div class="col-lg-4 order-lg-2">
                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light"><strong>Foto de Perfil</strong></div>
                  <div class="card-body text-center">
                    <img id="preview-photo" src="<?php echo ($employee && $employee['foto']) ? '../../images/'.$employee['foto'] : '../../assets/img/placeholder-funcionario.png'; ?>" class="img-fluid rounded mb-3" style="max-height: 200px;">
                    <input type="file" name="photo" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                  </div>
                </div>

                <div class="card shadow-sm mb-4">
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
                      <select name="accessType" class="form-select">
                        <option value="0" <?php if($employee && $employee['tipo_acesso'] == 0) echo 'selected'; ?>>Comum</option>
                        <option value="1" <?php if($employee && $employee['tipo_acesso'] == 1) echo 'selected'; ?>>Administrador</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-8 order-lg-1">
                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light"><strong>Informações Pessoais</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Nome Completo</label>
                      <input maxlength="80" type="text" name="name" class="form-control" value="<?php echo $employee['nome'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Nome Social</label>
                      <input maxlength="80" type="text" name="socialName" class="form-control" value="<?php echo $employee['socialName'] ?? ''; ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">CPF</label>
                      <input maxlength="14" type="text" name="cpf" class="form-control" data-mask="000.000.000-00" value="<?php echo $employee['cpf'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">RG</label>
                      <input maxlength="12" type="text" name="rg" class="form-control" data-mask="00.000.000-A" value="<?php echo $employee['rg'] ?? ''; ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Nascimento</label>
                      <input type="date" name="birthDate" class="form-control" value="<?php echo $employee['data_nascimento'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Cargo</label>
                      <select name="role" id="role-select" class="form-select">
                        <?php 
                        $roles = mysqli_query($connection, "SELECT id, nome FROM cargo WHERE status = 1");
                        while($c = mysqli_fetch_assoc($roles)) {
                          $sel = ($employee && $employee['id_cargo'] == $c['id']) ? 'selected' : '';
                          echo "<option value='{$c['id']}' $sel>{$c['nome']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Salário (R$)</label>
                      <input maxlength="13" type="text" name="salary" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" value="<?php echo $employee['salario'] ?? ''; ?>">
                    </div>
                  </div>
                </div>

                <div class="card shadow-sm mb-4">
                  <div class="card-header bg-light"><strong>Endereço e Contato</strong></div>
                  <div class="card-body row g-3">
                    <div class="col-md-3">
                      <label class="form-label">CEP</label>
                      <input maxlength="9" type="text" name="zipcode" class="form-control" data-mask="00000-000" value="<?php echo $employee['cep'] ?? ''; ?>">
                    </div>
                    <div class="col-md-7">
                      <label class="form-label">Logradouro</label>
                      <input maxlength="60" type="text" name=address class="form-control" value="<?php echo $employee['endereco'] ?? ''; ?>">
                    </div>
                    <div class="col-md-2">
                      <label class="form-label">Nº</label>
                      <input maxlength="5" type="text" name="number" class="form-control" value="<?php echo $employee['numero'] ?? ''; ?>">
                    </div>
                    <div class="col-md-5">
                      <label class="form-label">E-mail</label>
                      <input maxlength="100" type="email" name="email" class="form-control" value="<?php echo $employee['email'] ?? ''; ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Celular</label>
                      <input maxlength="15" type="text" name="cellPhone" class="form-control" data-mask="(00) 00000-0000" value="<?php echo $employee['telefone_celular'] ?? ''; ?>">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-select">
                        <option value="1" <?php if($employee && $employee['status'] == 1) echo 'selected'; ?>>Ativo</option>
                        <option value="0" <?php if($employee && $employee['status'] == 0) echo 'selected'; ?>>Inativo</option>
                      </select>
                    </div>
                  </div>
                </div>

                <button type="submit" name="actionSave" class="btn btn-primary w-100 py-3 shadow-sm">
                  <i class="bi bi-save"></i> Salvar Alterações
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
        reader.onload = function(e) { $('#preview-photo').attr('src', e.target.result); }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $('#mock-funcionario').on('click', async function() {
        const btn = $(this);
        btn.html('<span class="spinner-border spinner-border-sm"></span>').prop('disabled', true);

        try {
            const response = await fetch('https://randomuser.me/api/?nat=br');
            const data = await response.json();
            const p = data.results[0];

            const rand = (n) => Math.floor(Math.random() * n);
            const num = (n) => Math.floor(Math.random() * (n * 10)).toString().padStart(n, '0');
            
            $('input[name="name"]').val(`${p.name.first} ${p.name.last}`);
            $('input[name="socialName"]').val(p.name.first);
            $('input[name="cpf"]').val(`${rand(899)+100}.${rand(899)+100}.${rand(899)+100}-${rand(89)+10}`).trigger('input');
            $('input[name="rg"]').val(`${rand(89)}.${rand(899)+100}.${rand(899)+100}-${rand(9)}`).trigger('input');
            
            const dob = new Date(p.dob.date).toISOString().split('T')[0];
            $('input[name="birthDate"]').val(dob);

            $('input[name="username"]').val(p.login.username);
            $('input[name="password"]').val('123456');
            $('select[name="accessType"]').val(rand(10) > 7 ? "1" : "0");

            const salBase = (Math.random() * (8000 - 1500) + 1500).toFixed(2).replace('.', ',');
            $('input[name="salary"]').val(salBase).trigger('input');

            const roleOptions = $('#role-select option');
            if(roleOptions.length > 0) {
                const randomRole = roleOptions[rand(roleOptions.length)].value;
                $('#role-select').val(randomRole);
            }

            $('input[name="zipcode"]').val(p.location.postcode).trigger('input');
            $('input[name=address]').val(p.location.street.name);
            $('input[name="number"]').val(p.location.street.number);
            $('input[name="email"]').val(p.email);
            $('input[name="cellPhone"]').val(p.cell.replace(/\D/g, '').replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3')).trigger('input');
            
            $('#preview-photo').attr('src', p.picture.large);

        } catch (e) {
            alert('Erro ao gerar dados');
        } finally {
            btn.html('<i class="bi bi-magic"></i> Mock Data').prop('disabled', false);
        }
    });
  </script>
</body>
</html>