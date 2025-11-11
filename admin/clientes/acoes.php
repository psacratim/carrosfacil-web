<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_cliente") {
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
        
        $sql = "INSERT INTO cliente VALUES (
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

        try {       
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'error';
                $_SESSION['message_text'] = "Sucesso: Cargo cadastrado com sucesso.";
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['message_type'] = 'error';
            $_SESSION['message_text'] = "Erro: Não foi possível cadastrar esse cargo.";
        }
        
        header('Location: Index.php');
    }

    // EDITAR CARGO NOVO
    if (isset($_POST['atualizar']) && $_POST['atualizar'] == "atualizar_cliente") {
        $id = $_POST['id'];
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
        $status = $_POST['status'];
        
        $sql = "UPDATE cliente SET
        cpf = '$cpf',
        rg = '$rg',
        nome_completo = '$nome_completo',
        data_nascimento = '$data_nascimento',
        usuario = '$usuario',
        senha = '$senha',
        endereco = '$endereco',
        cep = '$cep',
        numero =  $numero,
        complemento = '$complemento',
        bairro = '$bairro',
        cidade = '$cidade',
        estado = '$estado',
        telefone1 = '$telefone1',
        telefone2 = '$telefone2',
        email = '$email',
        estado_civil = '$estado_civil',
        sexo = '$sexo',
        status = $status
        WHERE id = $id;";

        try {       
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'error';
                $_SESSION['message_text'] = 'Sucesso: Cliente editado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['message_type'] = 'error';
            $_SESSION['message_text'] = "Erro: Não foi possível editar esse cargo.";
        }
        
        header('Location: Index.php');
    }

    // EXCLUINDO CARGO
    if (isset($_POST['excluir_cliente'])) {
        $id = $_POST['excluir_cliente'];

        try {
            $sql = "DELETE FROM cliente WHERE id = $id;";
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = "Sucesso: O cliente foi excluido com sucesso.";
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $sql = "SELECT COUNT(id) AS total FROM venda WHERE id_cliente = $id";
                $query = mysqli_query($conexao, $sql);
                $total = mysqli_fetch_assoc($query)['total'];

                $_SESSION['message_type'] = 'info';
                $_SESSION['message_text'] = "Falhou: Não foi possível excluir esse cliente. Existem $total vendas que dependem dele.";
            } else {
                $_SESSION['message_type'] = 'error';
                $_SESSION['message_text'] = "Erro: Não foi possível excluir esse cliente.";
            }
        }

        header('Location: Index.php');
    }
?>

