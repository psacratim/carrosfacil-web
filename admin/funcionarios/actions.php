<?php 
    require_once('../../conexao/conecta.php');

    if (!isset($_SESSION)) { session_start(); }

    // Excluir
    if (isset($_POST["delete"])) {
        $id = (int)$_POST["delete"]; 

        try {
            $query = "DELETE FROM funcionario WHERE id = $id;";
            if (mysqli_query($connection, $query)) {
                $_SESSION['messageType'] = 'success';
                $_SESSION['messageText'] = "Sucesso: Funcionário excluído.";
            } else {
                throw new mysqli_sql_exception();
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $query = "SELECT COUNT(id) AS total FROM venda WHERE id_funcionario = $id";
                $result = mysqli_query($connection, $query);
                $totalCount = mysqli_fetch_assoc($result)['total'];

                $_SESSION['messageType'] = 'info';
                $_SESSION['messageText'] = "Falhou: Existem $totalCount vendas vinculadas a este funcionário.";
            } else {
                $_SESSION['messageType'] = 'error';
                $_SESSION['messageText'] = "Erro ao excluir funcionário.";
            }
        }
        header('Location: Index.php');
        exit;
    }

    // Cadastrar e Editar
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $isEditing = ($id > 0);

    // Coleta e Sanitização baseada no banco PT-BR
    $role = isset($_POST['role']) ? (int)$_POST['role'] : "NULL";
    $cpf = mysqli_real_escape_string($connection, $_POST['cpf']);
    $rg = mysqli_real_escape_string($connection, $_POST['rg']);
    $name = mysqli_real_escape_string($connection, $_POST["name"]);
    $socialName = mysqli_real_escape_string($connection, $_POST['socialName']);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $salary = !empty($_POST["salary"]) ? str_replace(['.', ','], ['', '.'], $_POST["salary"]) : 0;
    $gender = mysqli_real_escape_string($connection, $_POST["gender"]);
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $maritalStatus = mysqli_real_escape_string($connection, $_POST['maritalStatus']);
    $birthDate = mysqli_real_escape_string($connection, $_POST['birthDate']);
    $accessType = mysqli_real_escape_string($connection, $_POST["accessType"]);
    $cellPhone = mysqli_real_escape_string($connection, $_POST["cellPhone"]);
    $messagesPhone = mysqli_real_escape_string($connection, $_POST['messagesPhone']);
    $homePhone = mysqli_real_escape_string($connection, $_POST['homePhone']);
    $address = mysqli_real_escape_string($connection, $_POST["address"]);
    $zipcode = mysqli_real_escape_string($connection, $_POST["zipcode"]);
    $number = mysqli_real_escape_string($connection, $_POST["number"]);
    $complement = mysqli_real_escape_string($connection, $_POST["complement"]);
    $neighborhood = mysqli_real_escape_string($connection, $_POST["neighborhood"]);
    $city = mysqli_real_escape_string($connection, $_POST["city"]);
    $state = mysqli_real_escape_string($connection, $_POST["state"]);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $status = (int) ($_POST['status'] ?? 1);

    // Lógica da Foto
    $photoQuery = "";
    if (!empty($_FILES["photo"]['name'])) {
        $finalPhoto = time() . "_" . basename($_FILES["photo"]['name']);
        if (move_uploaded_file($_FILES["photo"]['tmp_name'], '../../images/' . $finalPhoto)) {
            $photoQuery = ", foto = '$finalPhoto'";
        }
    }

    if ($isEditing) {
        $query = "UPDATE funcionario SET 
            id_cargo = $role, cpf = '$cpf', rg = '$rg', nome = '$name', nome_social = '$socialName', 
            senha = '$password', salario = $salary, sexo = '$gender', usuario = '$username', 
            estado_civil = '$maritalStatus', data_nascimento = '$birthDate', tipo_acesso = '$accessType', 
            telefone_celular = '$cellPhone', telefone_recado = '$messagesPhone', telefone_residencial = '$homePhone', 
            endereco = '$address', cep = '$zipcode', numero = '$number', complemento = '$complement', 
            bairro = '$neighborhood', cidade = '$city', estado = '$state', email = '$email', status = $status $photoQuery 
            WHERE id = $id";
        $successMessage = "Funcionário atualizado!";
    } else {
        $photoEntry = isset($finalPhoto) ? $finalPhoto : 'placeholder-funcionario.png';
        $query = "INSERT INTO funcionario VALUES (
            0, $role, '$cpf', '$rg', '$name', '$socialName', '$password', $salary, 
            '$gender', '$username', '$maritalStatus', '$birthDate', '$accessType', 
            '$cellPhone', '$messagesPhone', '$homePhone', '$address', '$zipcode', 
            '$number', '$complement', '$neighborhood', '$city', '$state', '$email', 
            '$photoEntry', NOW(), 1
        )";
        $successMessage = "Funcionário cadastrado!";
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
        $_SESSION['messageText'] = ($e->getCode() == 1062) ? "Erro: Usuário ou CPF duplicado." : "Erro ao processar funcionário.";
    }

    header('Location: Index.php');
    exit;
?>