<?php 
    require_once('../../conexao/conecta.php');

    if (!isset($_SESSION)) { session_start(); }

    // Excluir
    if (isset($_POST["delete"])) {
        $id = (int)$_POST["delete"]; 

        try {
            $query = "DELETE FROM cliente WHERE id = $id;";
            if (mysqli_query($connection, $query)) {
                $_SESSION['messageType'] = 'success';
                $_SESSION['messageText'] = "Sucesso: Cliente removido.";
            } else {
                throw new mysqli_sql_exception();
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $query = "SELECT COUNT(id) AS total FROM venda WHERE id_cliente = $id";
                $result = mysqli_query($connection, $query);
                $totalCount = mysqli_fetch_assoc($result)['total'];

                $_SESSION['messageType'] = 'info';
                $_SESSION['messageText'] = "Falhou: Existem $totalCount vendas vinculadas a este cliente.";
            } else {
                $_SESSION['messageType'] = 'error';
                $_SESSION['messageText'] = "Erro ao excluir cliente.";
            }
        }
        header('Location: Index.php');
        exit;
    }

    // Cadastrar e Editar
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $isEditing = ($id > 0);

    // Coleta e Sanitização (EN logic)
    $cpf = mysqli_real_escape_string($connection, $_POST['cpf']);
    $rg = mysqli_real_escape_string($connection, $_POST['rg']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $birthDate = mysqli_real_escape_string($connection, $_POST['birthDate']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $zipcode = mysqli_real_escape_string($connection, $_POST['zipcode']);
    $number = mysqli_real_escape_string($connection, $_POST['number']);
    $complement = mysqli_real_escape_string($connection, $_POST['complement']);
    $neighborhood = mysqli_real_escape_string($connection, $_POST['neighborhood']);
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $state = mysqli_real_escape_string($connection, $_POST['state']);
    $phone1 = mysqli_real_escape_string($connection, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($connection, $_POST['phone2']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $maritalStatus = mysqli_real_escape_string($connection, $_POST['maritalStatus']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

    if ($isEditing) {
        $query = "UPDATE cliente SET 
            cpf = '$cpf', rg = '$rg', nome = '$name', data_nascimento = '$birthDate', 
            usuario = '$username', senha = '$password', endereco = '$address', cep = '$zipcode', 
            numero = '$number', complemento = '$complement', bairro = '$neighborhood', 
            cidade = '$city', estado = '$state', telefone1 = '$phone1', telefone2 = '$phone2', 
            email = '$email', estado_civil = '$maritalStatus', sexo = '$gender', status = $status 
            WHERE id = $id";
        $successMessage = "Dados do cliente atualizados!";
    } else {
        $query = "INSERT INTO cliente (
            cpf, rg, nome, data_nascimento, usuario, senha, endereco, cep, 
            numero, complemento, bairro, cidade, estado, telefone1, telefone2, 
            email, estado_civil, sexo, data_cadastro, status
        ) VALUES (
            '$cpf', '$rg', '$name', '$birthDate', '$username', '$password', '$address', '$zipcode', 
            '$number', '$complement', '$neighborhood', '$city', '$state', '$phone1', '$phone2', 
            '$email', '$maritalStatus', '$gender', NOW(), 1
        )";
        $successMessage = "Cliente cadastrado com sucesso!";
    }

    try {
        if (mysqli_query($connection, $query)) {
            $_SESSION['messageType'] = 'success';
            $_SESSION['messageText'] = $successMessage;
        } else {
            throw new mysqli_sql_exception();
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['messageType'] = 'error';
        if ($e->getCode() == 1062) {
            $_SESSION['messageText'] = "Erro: CPF ou usuário já cadastrado.";
        } else {
            $_SESSION['messageText'] = "Erro ao processar cliente.";
        }
    }

    header('Location: Index.php');
    exit;
?>