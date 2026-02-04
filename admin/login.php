<?php
// Conexão com o banco
require_once('../conexao/conecta.php');

// Iniciando sessão
if (!isset($_SESSION)) {
    session_start();
}



if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = mysqli_escape_string($connection, $_POST['username']);
    $password = mysqli_escape_string($connection, $_POST['password']);

    $query = mysqli_query($connection, "
    SELECT id, usuario, tipo_acesso, nome FROM funcionario WHERE usuario='$username' AND senha='$password'
    ");

    $employee = mysqli_fetch_assoc($query);
    if (isset($employee)) {
        $_SESSION['id'] = $employee['id'];
        $_SESSION['name'] = $employee['nome'];
        $_SESSION['user'] = $employee['usuario'];
        $_SESSION['type'] = $employee['tipo_acesso'];

        header('Location: dashboard.php');
    } else {
        header('Location: index.php');

        $_SESSION['messageType'] = 'error';
        $_SESSION['messageText'] = "Erro: Usuário ou senha incorreta!";
    }
} else {
    header('Location: index.php');
    $_SESSION['messageType'] = 'error';
    $_SESSION['messageText'] = "Insira o seu usuário e senha.";
}
