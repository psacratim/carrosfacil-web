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
  <title>Editar Funcionário - Painel</title>

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
          <?php 
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $id = $_GET['id'];

                $sql = "SELECT * FROM funcionario WHERE id=$id";
                $query = mysqli_execute_query($conexao, $sql);
                $funcionario = mysqli_fetch_assoc($query);
          ?>
            <div class="card">
              <div class="card-header d-flex justify-content-between">
                <h4 class="m-0">Editar Funcionário</h4>

                <a href="Index.php" class="btn btn-primary btn-sm"><i class="bi bi-arrow-left-short"></i> Voltar</a>
              </div>

              <div class="card-body">
                <!-- Se o formulario envia arquivos ao banco (foto) o enctype='multipart/form-data' é necessário! Caso contrário ele não receberá os arquivos. -->
                <form action="acoes.php" method="post" enctype="multipart/form-data">
                  <div class="form-row">

                    <div class="col-12 mb-3 text-center">
                      <label for="foto-perfil">Foto de Perfil</label>

                      <div>
                        <img id="foto-img" src="<?php echo $funcionario['foto'] != "" ? '../../images/'.$funcionario['foto'] : '../../assets/img/placeholder-funcionario.png' ?>" alt="" class="rounded-3">
                      </div>

                      <input type="file" name="foto-perfil" id="foto-perfil" class="form-control mt-3 mx-auto w-50" accept="image/*">
                    </div>

                    <fieldset class="form-group">
                      <h3>Dados Pessoais</h3>
                      <div class="row">
                        <div class="col-md-12">
                          <input hidden type="text" name="id" id="id" class="form-control" maxlength="60" required value="<?php echo $funcionario['id'] ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="nome"><strong class="text-danger">*</strong> Nome:</label>
                          <input type="text" name="nome" id="nome" class="form-control" maxlength="60" required value="<?php echo $funcionario['nome'] ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="nome-social">Nome Social</label>
                          <input type="text" name="nome-social" id="nome-social" class="form-control" maxlength="60" value="<?php echo $funcionario['nome_social'] ?>">
                        </div>
                        <div class="col-lg-3 col-md-3 mt-3">
                          <label for="cpf"><strong class="text-danger">*</strong> CPF</label>
                          <input type="text" name="cpf" id="cpf" class="form-control" maxlength="14" required data-mask="000.000.000-00" value="<?php echo $funcionario['cpf'] ?>">
                        </div>
                        <div class="col-lg-3 col-md-3 mt-3">
                          <label for="rg">RG</label>
                          <input type="text" name="rg" id="rg" class="form-control" maxlength="12" data-mask="00.000.000-A" value="<?php echo $funcionario['rg'] ?>">
                        </div>
                        <div class="col-lg-3 col-md-3 mt-3">
                          <label for="sexo"><strong class="text-danger">*</strong> Sexo</label>
                          <select name="sexo" id="sexo" class="form-control">
                            <option value="N" <?php if ($funcionario['sexo'] == 'N') echo 'selected'; ?>>Não Informado</option>
                            <option value="M" <?php if ($funcionario['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
                            <option value="F" <?php if ($funcionario['sexo'] == 'F') echo 'selected'; ?>>Feminino</option>
                          </select>
                        </div>
                        <div class="col-lg-3 col-md-3 mt-3">
                          <label for="estado-civil"><strong class="text-danger">*</strong> Estado Civil</label>
                          <select name="estado-civil" id="estado-civil" class="form-control" required>
                            <option value="Solteiro(a)" <?php if ($funcionario['estado_civil'] == 'Solteiro(a)') echo 'selected' ?>>Solteiro(a)</option>
                            <option value="Casado(a)" <?php if ($funcionario['estado_civil'] == 'Casado(a)') echo 'selected' ?>>Casado(a)</option>
                            <option value="Separado(a)" <?php if ($funcionario['estado_civil'] == 'Separado(a)') echo 'selected' ?>>Separado(a)</option>
                            <option value="Divorciado(a)" <?php if ($funcionario['estado_civil'] == 'Divorciado(a)') echo 'selected' ?>>Divorciado(a)</option>
                            <option value="Viúvo(a)" <?php if ($funcionario['estado_civil'] == 'Viúvo(a)') echo 'selected' ?>>Viúvo(a)</option>
                          </select>
                        </div>
                        <div class="col-lg-3 col-md-3 mt-3">
                          <label for="data-nascimento"><strong class="text-danger">*</strong> Data Nascimento</label>
                          <input type="date" name="data-nascimento" id="data-nascimento" class="form-control" value="<?php echo $funcionario['data_nascimento'] ?>">
                        </div>
                        <div class="col-lg-3 col-md-3 mt-3">
                          <label for="cargo">Cargo</label>
                          <select name="cargo" id="cargo" class="form-control">
                            <option value="">- Selecione -</option>
                            <?php 
                              $sql = 'SELECT id, nome FROM cargo WHERE status = 1;';
                              $query = mysqli_execute_query($conexao, $sql);
                              foreach ($query as $cargo) { 
                                $select = $cargo['id'] == $funcionario['id_cargo'] ? 'selected' : '';
                                echo '<option '. $select .' value="'. $cargo['id'] .'">'. $cargo['nome'] .'</option>';
                              } 
                            ?>
                          </select>
                        </div>
                        <div class="col-lg-3 col-md-3 mt-3">
                          <label for="salario">Salario</label>
                          <input type="text" name="salario" id="salario" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" value="<?php echo $funcionario['salario'] ?>">
                        </div>
                        <div class="col-lg-3 col-md-3 mt-3">
                          <label for="status">Status</label>
                          <select name="status" id="status" class="form-control">
                            <option value="1" <?php if ($funcionario['status'] == 1) echo 'selected' ?>>Ativo</option>
                            <option value="0" <?php if ($funcionario['status'] == 0) echo 'selected' ?>>Inativo</option>
                          </select>
                        </div>
                      </div>
                    </fieldset>

                    <fieldset class="form-group col-lg-12 mt-3">
                      <h3>Dados de acesso</h3>
                      <div class="row">
                        <div class="col-md-4 mt-3">
                          <label for="usuario"><strong class="text-danger">*</strong> Usuário</label>
                          <input type="text" name="usuario" id="usuario" class="form-control" maxlength="20" required value="<?php echo $funcionario['usuario'] ?>">
                        </div>

                        <div class="col-md-4 mt-3">
                          <label for="senha"><strong class="text-danger">*</strong> Senha</label>
                          <input type="password" name="senha" id="senha" class="form-control" maxlength="26" required value="<?php echo $funcionario['senha'] ?>">
                        </div>

                        <div class="col-md-4 mt-3">
                          <label for="tipo-acesso"><strong class="text-danger">*</strong> Tipo de acesso</label>
                          <select name="tipo-acesso" id="tipo-acesso" class="form-control" required>
                            <option value="0" <?php if ($funcionario['tipo_acesso'] == 0) echo 'selected' ?>>Comum</option>
                            <option value="1" <?php if ($funcionario['tipo_acesso'] == 1) echo 'selected' ?>>Administrador</option>
                          </select>
                        </div>
                      </div>
                    </fieldset>


                    <fieldset class="form-group col-lg-12 mt-3">
                      <h3>Dados de contato</h3>
                      <div class="row">
                        <div class="col-lg-2 col-md-4 mt-3">
                          <label for="telefone-recado"><strong class="text-danger">*</strong> Telefone Recado</label>
                          <input type="text" name="telefone-recado" id="telefone-recado" class="form-control" minlength="15" maxlength="15" required data-mask="(00) 00000-0000" value="<?php echo $funcionario['telefone_recado'] ?>">
                        </div>

                        <div class="col-lg-2 col-md-4 mt-3">
                          <label for="telefone-celular">Telefone Celular</label>
                          <input type="text" name="telefone-celular" id="telefone-celular" class="form-control" minlength="15" maxlength="15" data-mask="(00) 00000-0000" value="<?php echo $funcionario['telefone_celular'] ?>">
                        </div>

                        <div class="col-lg-2 col-md-4 mt-3">
                          <label for="telefone-residencial">Telefone Residencial</label>
                          <input type="text" name="telefone-residencial" id="telefone-residencial" class="form-control" minlength="15" maxlength="15" data-mask="(00) 00000-0000" value="<?php echo $funcionario['telefone_residencial'] ?>">
                        </div>

                        <div class="col-lg-6 mt-3">
                          <label for="email">Email</label>
                          <input type="email" name="email" id="email" class="form-control" maxlength="100" value="<?php echo $funcionario['email'] ?>">
                        </div>
                      </div>
                    </fieldset>

                    

                    <fieldset class="form-group col-lg-12 mt-3">
                      <h3>Dados do endereço</h3>
                      <div class="row">
                        <div class="col-lg-2 col-md-3 mt-3">
                          <label for="cep">CEP</label>
                          <input type="text" name="cep" id="cep" class="form-control" maxlength="10" data-mask="00000-000" value="<?php echo $funcionario['cep'] ?>">
                        </div>

                        <div class="col-lg-4 col-md-7 mt-3">
                          <label for="endereco"><strong class="text-danger">*</strong> Endereço</label>
                          <input type="text" name="endereco" id="endereco" class="form-control" maxlength="60" required value="<?php echo $funcionario['endereco'] ?>">
                        </div>

                        <div class="col-lg-2 col-md-2 mt-3">
                          <label for="numero-endereco"><strong class="text-danger">*</strong> Número</label>
                          <input type="number" name="numero-endereco" id="numero-endereco" class="form-control" min="1" max="99999" required  value="<?php echo $funcionario['numero'] ?>">
                        </div>

                        <div class="col-lg-4 col-md-6 mt-3">
                          <label for="bairro"><strong class="text-danger">*</strong> Bairro</label>
                          <input type="text" name="bairro" id="bairro" class="form-control" maxlength="32" required value="<?php echo $funcionario['bairro'] ?>">
                        </div>

                        <div class="col-lg-5 col-md-6 mt-3">
                          <label for="cidade"><strong class="text-danger">*</strong> Cidade</label>
                          <input type="text" name="cidade" id="cidade" class="form-control" maxlength="50" required value="<?php echo $funcionario['cidade'] ?>">
                        </div>

                        <div class="col-lg-2 col-md-6 mt-3">
                          <label for="estado"><strong class="text-danger">*</strong> Estado</label>

                          <select name="estado" id="estado" class="form-control" required>
                            <option value="AC" <?php if($funcionario['estado'] == 'AC') echo 'selected'; ?>>Acre</option>
                            <option value="AL" <?php if($funcionario['estado'] == 'AL') echo 'selected'; ?>>Alagoas</option>
                            <option value="AP" <?php if($funcionario['estado'] == 'AP') echo 'selected'; ?>>Amapá</option>
                            <option value="AM" <?php if($funcionario['estado'] == 'AM') echo 'selected'; ?>>Amazonas</option>
                            <option value="BA" <?php if($funcionario['estado'] == 'BA') echo 'selected'; ?>>Bahia</option>
                            <option value="CE" <?php if($funcionario['estado'] == 'CE') echo 'selected'; ?>>Ceará</option>
                            <option value="DF" <?php if($funcionario['estado'] == 'DF') echo 'selected'; ?>>Distrito Federal</option>
                            <option value="ES" <?php if($funcionario['estado'] == 'ES') echo 'selected'; ?>>Espírito Santo</option>
                            <option value="GO" <?php if($funcionario['estado'] == 'GO') echo 'selected'; ?>>Goiás</option>
                            <option value="MA" <?php if($funcionario['estado'] == 'MA') echo 'selected'; ?>>Maranhão</option>
                            <option value="MT" <?php if($funcionario['estado'] == 'MT') echo 'selected'; ?>>Mato Grosso</option>
                            <option value="MS" <?php if($funcionario['estado'] == 'MS') echo 'selected'; ?>>Mato Grosso do Sul</option>
                            <option value="MG" <?php if($funcionario['estado'] == 'MG') echo 'selected'; ?>>Minas Gerais</option>
                            <option value="PA" <?php if($funcionario['estado'] == 'PA') echo 'selected'; ?>>Pará</option>
                            <option value="PB" <?php if($funcionario['estado'] == 'PB') echo 'selected'; ?>>Paraíba</option>
                            <option value="PR" <?php if($funcionario['estado'] == 'PR') echo 'selected'; ?>>Paraná</option>
                            <option value="PE" <?php if($funcionario['estado'] == 'PE') echo 'selected'; ?>>Pernambuco</option>
                            <option value="PI" <?php if($funcionario['estado'] == 'PI') echo 'selected'; ?>>Piauí</option>
                            <option value="RJ" <?php if($funcionario['estado'] == 'RJ') echo 'selected'; ?>>Rio de Janeiro</option>
                            <option value="RN" <?php if($funcionario['estado'] == 'RN') echo 'selected'; ?>>Rio Grande do Norte</option>
                            <option value="RS" <?php if($funcionario['estado'] == 'RS') echo 'selected'; ?>>Rio Grande do Sul</option>
                            <option value="RO" <?php if($funcionario['estado'] == 'RO') echo 'selected'; ?>>Rondônia</option>
                            <option value="RR" <?php if($funcionario['estado'] == 'RR') echo 'selected'; ?>>Roraima</option>
                            <option value="SC" <?php if($funcionario['estado'] == 'SC') echo 'selected'; ?>>Santa Catarina</option>
                            <option value="SP" <?php if($funcionario['estado'] == 'SP') echo 'selected'; ?>>São Paulo</option>
                            <option value="SE" <?php if($funcionario['estado'] == 'SE') echo 'selected'; ?>>Sergipe</option>
                            <option value="TO" <?php if($funcionario['estado'] == 'TO') echo 'selected'; ?>>Tocantins</option>
                          </select>
                        </div>

                        <div class="col-lg-5 col-md-6 mt-3">
                          <label for="complemento">Complemento</label>
                          <input type="text" name="complemento" id="complemento" class="form-control" maxlength="200" value="<?php echo $funcionario['complemento'] ?>">
                          </input>
                        </div>
                      </div>
                    </fieldset>

                    <input type="hidden" name="editar" value="editar_funcionario" class="btn btn-primary mt-3">
                    <input type="submit" value="Atualizar" class="btn btn-primary mt-3">
                  </div>
                </form>
              </div>

            </div>
          <?php } else {
            echo '<div class="alert alert-danger m-3" role="alert">Funcionário não encontrado!</div>';
          } ?>
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
</body>

</html>