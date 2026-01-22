<?php 
if (!isset($_SESSION)) {
  session_start();
}

if (!$_SESSION['type']){
    $_SESSION['messageType'] = 'error';
    $_SESSION['messageText'] = "Erro: Entre com seu usuário administrador pra acessar essa área.";

    header("Location: ./Index.php");
}
?>