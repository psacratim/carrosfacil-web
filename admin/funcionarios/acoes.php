<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_funcionario") {
        try {
            $nome = mysqli_escape_string($conexao, $_POST['nome']);
            $nome_social = mysqli_escape_string($conexao, $_POST['nome-social']);
            $cpf = mysqli_escape_string($conexao, $_POST['cpf']);
            $rg = mysqli_escape_string($conexao, $_POST['rg']);
            $sexo = mysqli_escape_string($conexao, $_POST['sexo']);
            $estado_civil = mysqli_escape_string($conexao, $_POST['estado-civil']);
            $data_nascimento = mysqli_escape_string($conexao, $_POST['data-nascimento']);
            $cargo = mysqli_escape_string($conexao, $_POST['cargo']);
            $salario = $_POST['salario'];
            $status = mysqli_escape_string($conexao, $_POST['status']);
            $usuario = mysqli_escape_string($conexao, $_POST['usuario']);
            $senha = mysqli_escape_string($conexao, $_POST['senha']);
            $tipo_acesso = mysqli_escape_string($conexao, $_POST['tipo-acesso']);
            $telefone_recado = mysqli_escape_string($conexao, $_POST['telefone-recado']);
            $telefone_celular = mysqli_escape_string($conexao, $_POST['telefone-celular']);
            $telefone_residencial = mysqli_escape_string($conexao, $_POST['telefone-residencial']);
            $email = mysqli_escape_string($conexao, $_POST['email']);
            $cep = mysqli_escape_string($conexao, $_POST['cep']);
            $endereco = mysqli_escape_string($conexao, $_POST['endereco']);
            $numero_endereco = mysqli_escape_string($conexao, $_POST['numero-endereco']);
            $bairro = mysqli_escape_string($conexao, $_POST['bairro']);
            $cidade = mysqli_escape_string($conexao, $_POST['cidade']);
            $estado = mysqli_escape_string($conexao, $_POST['estado']);
            $complemento = mysqli_escape_string($conexao, $_POST['complemento']);
            $foto = mysqli_escape_string($conexao, $_POST['foto-perfil']);

            $sql = "INSERT INTO funcionario VALUES (
            0,
            $cargo,
            '$cpf',
            '$rg',
            '$nome',
            '$nome_social',
            '$senha',
            $salario,
            '$sexo',
            '$usuario',
            '$estado_civil',
            '$email',
            '$cep',
            '$foto',
            NOW(),
            1
            );";
            
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Cargo cadastrado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = 'Erro ao cadastrar o cargo!';
        }
        
        header('Location: Index.php');
    }
?>

