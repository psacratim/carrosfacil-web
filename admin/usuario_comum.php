<?php 
if (!isset($_SESSION)) {
  session_start();
}

if (!$_SESSION['user']){
    $_SESSION['messageType'] = 'error';
    $_SESSION['messageText'] = "Erro: Entre com seu usuário pra acessar essa área.";

    header("Location: /admin/index.php");
}
?>