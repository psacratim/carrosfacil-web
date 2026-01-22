<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Carros Fácil - Login</title>

  <!-- BOOTSTRAP CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- FAVICON -->
  <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">

  <!-- CUSTOM CSS -->
  <link rel="stylesheet" href="../assets/css/signin.css">
  <link rel="stylesheet" href="../assets/css/styles.css">
  <link rel="stylesheet" href="../custom/css/style.css">
</head>

<body class="text-center">

  <main class="form-signin">
    <form action="login.php" method="POST">
      <h2 class="h3 mb-3">Faça seu Login</h2>

      <input type="text" class="form-control mb-2" name="username" placeholder="Usuário">

      <input type="password" class="form-control" name="password" placeholder="Senha">

      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

    </form>

    <div class="pt-2">
      STATUS DE MENSAGEM
    </div>

    <p class="mt-5 text-muted">&copy; <?= date('Y') ?></p>
  </main>

  <!-- BOOTSTRAP JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>