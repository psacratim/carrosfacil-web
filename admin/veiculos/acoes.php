<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_veiculo") {
        try {
            $cpf = mysqli_escape_string($conexao, $_POST['cpf']);
            $rg = mysqli_escape_string($conexao, $_POST['rg']);
            $nome_completo = mysqli_escape_string($conexao, $_POST['nome-completo']);
            $data_nascimento = mysqli_escape_string($conexao, $_POST['data-nascimento']);
            $usuario = mysqli_escape_string($conexao, $_POST['usuario']);
            $senha = mysqli_escape_string($conexao, $_POST['senha']);
            $endereco = mysqli_escape_string($conexao, $_POST['endereco']);
            $cep = mysqli_escape_string($conexao, $_POST['cep']);
            $numero = $_POST['numero-endereco'];
            $complemento = mysqli_escape_string($conexao, $_POST['complemento']);
            $bairro = mysqli_escape_string($conexao, $_POST['bairro']);
            $cidade = mysqli_escape_string($conexao, $_POST['cidade']);
            $estado = mysqli_escape_string($conexao, $_POST['estado']);
            $telefone1 = mysqli_escape_string($conexao, $_POST['telefone-1']);
            $telefone2 = mysqli_escape_string($conexao, $_POST['telefone-2']);
            $email = mysqli_escape_string($conexao, $_POST['email']);
            $estado_civil = mysqli_escape_string($conexao, $_POST['estado-civil']);
            $sexo = mysqli_escape_string($conexao, $_POST['sexo']);

            $sql = "INSERT INTO veiculo VALUES (
            0,
            '$cpf',
            '$rg',
            '$nome_completo',
            '$data_nascimento',
            '$usuario',
            '$senha',
            '$endereco',
            '$cep',
            $numero,
            '$complemento',
            '$bairro',
            '$cidade',
            '$estado',
            '$telefone1',
            '$telefone2',
            '$email',
            '$estado_civil',
            '$sexo',
            NOW(),
            1
            );";

            echo $sql;
            
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Veiculo cadastrado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = 'Erro ao cadastrar o veiculo!';
        }
        
        // header('Location: Index.php');
    }
?>

