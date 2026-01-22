<?php
if (!isset($_SESSION)) {
  session_start();
}

?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Carros Fácil - Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="../assets/css/signin.css">
  <link rel="stylesheet" href="../assets/css/styles.css">
  <link rel="stylesheet" href="../custom/css/style.css">
</head>

<body class="text-center">
  
  <main class="form-signin">
  <div class="login-response"><?php include('./Mensagem.php'); ?></div>

    <form action="login.php" method="POST">
      <h2 class="h3 mb-3">Faça seu Login</h2>

      <input type="text" class="form-control mb-2" name="username" placeholder="Usuário" required autofocus>

      <input type="password" class="form-control mb-3" name="password" placeholder="Senha" required>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

    </form>
    
    <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y') ?></p>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>