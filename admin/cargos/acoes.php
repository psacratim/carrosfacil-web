<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_cargo") {
        $nome_cargo = mysqli_real_escape_string($conexao, $_POST['nome-cargo']);
        $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

        $sql = "INSERT INTO cargo VALUES (0, '$nome_cargo', '$observacao', NOW(), 1);";
        
        if (mysqli_query($conexao, $sql)) {
            header('Location: Index.php');
        } else {
            die('Erro: '. $sql . '<hr>' . mysqli_error($conexao));
        }
    }
?>

