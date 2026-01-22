<?php
require_once("./conexao/conecta.php");
require_once('./Components/Header.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carros Fácil - Inicio</title>

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Newsreader:ital,opsz,wght@0,6.72,200.800;1,6.72,200.800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./custom/css/index.css">
    <link rel="stylesheet" href="./custom/css/style.css">
</head>

<!-- A página é pequena, essas classes é pra ela ter o tamanho mínimo igual da tela, pro footer ficar certo. -->

<body class="d-flex flex-column min-vh-100 m-0">
    <?php
    echo HeaderComponent('login');
    ?>

    <div class="container flex-fill p-0 p-sm-3">
        <main id="auth-container" class="my-5 d-flex justify-content-center align-items-center flex-wrap flex-column">
            <div class="auth-header d-flex justify-content-center align-content-center flex-wrap">
                <img src="./assets/img/logotipo-empresa.png" width="auto" height="32"
                    class="d-inline-block align-top my-auto" alt="">
                <p class="w-100 text-center mt-2">Preencha as informações pra criar a conta</p>
            </div>
            <div class="p-4 white-bg col-12 col-md-8 col-lg-6 col-xl-4 mt-2">
                <form action="/auth" method="post" id="auth-form">
                    <div class="form-group">
                        <label for="auth-name" class="text-c1 fw-bold mb-1">E-mail</label>

                        <div class="input-group">
                            <div class="input-icon"><i class="bi bi-person-fill"></i></div>
                            <input class="form-control" type="text" name="auth-name" id="auth-name" placeholder="ex: meu-email@email.com">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="input-user-password" class="text-c1 fw-bold mb-1">Senha</label>
                        <div class="input-group position-relative">
                            <div class="input-icon"><i class="bi bi-lock"></i></div>
                            <input class="form-control input-password" type="password" name="input-user-password" id="input-user-password" placeholder="••••••••">
                            <button type="button" class="show-password" aria-label="Show password"><i class="bi bi-eye-slash"></i></button>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="input-confirm-password" class="text-c1 fw-bold mb-1">Confirmar senha</label>
                        <div class="input-group position-relative">
                            <div class="input-icon"><i class="bi bi-lock"></i></div>
                            <input class="form-control input-password" type="password" name="input-confirm-password" id="input-confirm-password" placeholder="••••••••">
                            <button type="button" class="show-password" aria-label="Show password"><i class="bi bi-eye-slash"></i></button>
                        </div>
                    </div>

                    <div id="accept-info" class="d-flex justify-content-center align-items-center mt-3">
                        <input type="checkbox" name="accept-terms" id="accept-terms" class="me-2 me-lg-1">
                        <span>Eu aceito os <a href="#" class="fw-bold">Termos de Uso</a> e <a href="#" class="fw-bold">Política de Privacidade</a></span>
                    </div>

                    <button id="auth-button" class="mt-3" type="submit">Criar conta</button>
                </form>
            </div>

            <div id="no-account-warn" class="mt-4">
                Já tem uma conta? <a href="/Login.php">Entrar na conta.</a>
            </div>
        </main>
    </div>

    <?php
    include_once('./Components/Footer.php');
    ?>

    <!-- BOOTSTRAP -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function() {
            $(".show-password").on('click', function() {
                let passwordInput = $(this).parent().find('.input-password')[0];
                console.log($(this).parent())
                let isShowing = passwordInput.type == 'password'

                passwordInput.type = isShowing ? "text" : "password"
            });
        })
    </script>
</body>

</html>