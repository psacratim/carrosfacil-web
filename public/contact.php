<?php
require_once("./conexao/conecta.php");
    require_once('./Components/Header.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carros Fácil - Suporte</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="./custom/css/style.css">
    <style>
        :root {
            --primary-blue: #004aad;
            --light-blue: #eef2f7;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .sect-page-header {
            background-color: var(--primary-blue);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }

        /* Estilização dos Cards com Shadow */
        .custom-card {
            background-color: #fff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
            /* Shadow para destacar do fundo */
            /* Garante que ambos tenham a mesma altura se necessário */
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .contact-info-item i {
            font-size: 1.5rem;
            color: var(--primary-blue);
            background: var(--light-blue);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 15px;
        }

        .form-control,
        .form-select {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 74, 173, 0.25);
        }

        .btn-send {
            background-color: var(--primary-blue);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
            width: 100%;
        }

        .btn-send:hover {
            background-color: #003a8c;
            color: white;
        }

        /* Ajuste fino para os títulos */
        .card-title-custom {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <?php
    echo HeaderComponent("contact");
    ?>

    <section class="sect-page-header">
        <div class="container text-center">
            <h1 class="fw-bold">Suporte ao Cliente</h1>
            <p>Estamos aqui para ajudar você com qualquer dúvida ou problema.</p>
        </div>
    </section>

    <main class="container mb-5">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="custom-card p-4 p-md-5">
                    <h3 class="card-title-custom">Envie uma mensagem</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome aqui" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email@exemplo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo do Contato</label>
                            <select class="form-select" id="motivo" name="motivo" required>
                                <option value="" selected disabled>Selecione uma opção</option>
                                <option value="Dúvida sobre Veículo">Dúvida sobre Veículo</option>
                                <option value="Financiamento">Financiamento</option>
                                <option value="Pós-venda">Pós-venda / Garantia</option>
                                <option value="Sugestão ou Crítica">Sugestão ou Crítica</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="mensagem" class="form-label">Mensagem (Opcional)</label>
                            <textarea class="form-control" id="mensagem" name="mensagem" rows="4" placeholder="Como podemos ajudar?"></textarea>
                        </div>

                        <button type="submit" class="btn-send">
                            <i class="bi bi-send-fill me-2"></i> Enviar Solicitação
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="custom-card p-4 p-md-5">
                    <h3 class="card-title-custom">Canais de Atendimento</h3>

                    <div class="contact-info-item">
                        <i class="bi bi-telephone"></i>
                        <div>
                            <p class="mb-0 fw-bold">Telefone</p>
                            <span>(19) 3333-3333</span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="bi bi-whatsapp"></i>
                        <div>
                            <p class="mb-0 fw-bold">WhatsApp</p>
                            <a href="https://wa.me/5519999999999" target="_blank" class="text-decoration-none text-dark">
                                (19) 99999-9999
                            </a>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <p class="mb-0 fw-bold">Endereço</p>
                            <span>Rua dos Carros, 123 - SP</span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <p class="mb-0 fw-bold">E-mail</p>
                            <span>contato@carrosfacil.com.br</span>
                        </div>
                    </div>

                    <hr class="my-4 text-secondary opacity-25">

                    <div class="text-center bg-light p-3 rounded-3">
                        <p class="fw-bold mb-1" style="color: var(--primary-blue);">Horário de Funcionamento</p>
                        <small class="text-muted d-block">Segunda à Sexta: 08h às 18h</small>
                        <small class="text-muted d-block">Sábado e Domingo: 10h às 14h</small>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    include_once('./Components/Footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>