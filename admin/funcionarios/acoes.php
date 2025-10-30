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
            $cargo = $_POST['cargo'] != null ? $_POST['cargo'] : "NULL";
            $salario = $_POST['salario'] != null ? str_replace(array('.', ','), array('', '.'), $_POST['salario']) : 0;
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

            // ENVIANDO FOTO PARA O SERVIDOR
            $foto = basename($_FILES['foto-perfil']['name']); // Obtém caminho da foto (name = caminho da foto)
            $tmp = $_FILES['foto-perfil']['tmp_name']; // Caminho da foto na pasta tmp (temporaria)
            $final = '../../images/' . $foto;
            move_uploaded_file($tmp, $final);

            // CRIANDO QUERY SQL
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
            '$data_nascimento',
            '$tipo_acesso',
            '$telefone_celular',
            '$telefone_recado',
            '$telefone_residencial',
            '$endereco',
            '$cep',
            '$numero_endereco',
            '$complemento',
            '$bairro',
            '$cidade',
            '$estado',
            '$email',
            '$foto',
            NOW(),
            1
            );";

            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Funcionario cadastrado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception $ex) {
            $_SESSION['mensagem'] = 'Erro ao cadastrar o funcionário!';
        }
        
        header('Location: Index.php');
    }

    // EDITANDO
    if (isset($_POST['editar']) && $_POST['editar'] == "editar_funcionario") {
        $id = mysqli_escape_string($conexao, $_POST['id']);
        $nome = mysqli_escape_string($conexao, $_POST['nome']);
        $nome_social = mysqli_escape_string($conexao, $_POST['nome-social']);
        $cpf = mysqli_escape_string($conexao, $_POST['cpf']);
        $rg = mysqli_escape_string($conexao, $_POST['rg']);
        $sexo = mysqli_escape_string($conexao, $_POST['sexo']);
        $estado_civil = mysqli_escape_string($conexao, $_POST['estado-civil']);
        $data_nascimento = mysqli_escape_string($conexao, $_POST['data-nascimento']);
        $cargo = $_POST['cargo'] != null ? $_POST['cargo'] : "NULL";
        $salario = $_POST['salario'] != null ? str_replace(array('.', ','), array('', '.'), $_POST['salario']) : 0;
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

        // ENVIANDO FOTO PARA O SERVIDOR
        $foto = basename($_FILES['foto-perfil']['name']); // Obtém caminho da foto (name = caminho da foto)
        $tmp = $_FILES['foto-perfil']['tmp_name']; // Caminho da foto na pasta tmp (temporaria)
        $final = '../../images/' . $foto;
        move_uploaded_file($tmp, $final);

        $fotoQuery = $foto != null ? "foto = '$foto'," : '';

        // CRIANDO QUERY SQL
        $sql = "UPDATE funcionario SET
            id_cargo = $cargo,
            cpf = '$cpf',
            rg = '$rg',
            nome = '$nome',
            nome_social = '$nome_social',
            senha = '$senha',
            salario =  $salario,
            sexo = '$sexo',
            usuario = '$usuario',
            estado_civil = '$estado_civil',
            data_nascimento = '$data_nascimento',
            tipo_acesso = '$tipo_acesso',
            telefone_celular = '$telefone_celular',
            telefone_recado = '$telefone_recado',
            telefone_residencial = '$telefone_residencial',
            endereco = '$endereco',
            cep = '$cep',
            numero = '$numero_endereco',
            complemento = '$complemento',
            bairro = '$bairro',
            cidade = '$cidade',
            estado = '$estado',
            email = '$email',
            $fotoQuery
            status = $status
            WHERE id = $id;
        ";
   
        try {
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Funcionario atualizar com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception $ex) {
            $_SESSION['mensagem'] = 'Erro ao atualizar o funcionário!';
        }
        
        header('Location: Index.php');
    }
?>

