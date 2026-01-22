<?php
require_once("./conexao/conecta.php");
require_once('./Components/Header.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Carros Fácil</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="./custom/css/style.css">
    <style>
        :root {
            --blue-primary: rgb(30, 58, 138); /* Cor extraída do seu style.css */
        }

        .hero-about {
            background: linear-gradient(rgba(30, 58, 138, 0.85), rgba(30, 58, 138, 0.85)), url('https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .section-padding {
            padding: 60px 0;
        }

        .icon-box {
            padding: 30px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #eee;
            transition: all 0.3s ease;
            height: 100%;
        }

        .icon-box:hover {
            border-color: var(--blue-primary);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .icon-box i {
            font-size: 2.5rem;
            color: var(--blue-primary);
            margin-bottom: 15px;
            display: inline-block;
        }

        .about-text {
            font-family: 'Poppins', sans-serif;
            line-height: 1.8;
            color: #475569;
        }

        .value-card {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            border-left: 5px solid var(--blue-primary);
        }
    </style>
</head>

<body>
    <?php echo HeaderComponent("about"); ?>

    <section class="hero-about">
        <div class="container">
            <h1 class="display-4 fw-bold">O Jeito Fácil de Comprar seu Carro</h1>
            <p class="lead">Transparência e tecnologia para conectar você ao seu próximo veículo.</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="./assets/img/about-us-image.png" alt="Carros Selecionados" class="img-fluid rounded-4 shadow-sm">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 class="mb-4 text-c1 fw-bold">Quem somos</h2>
                    <div class="about-text">
                        <p>A <strong>Carros Fácil</strong> nasceu da vontade de simplificar o mercado automotivo. Sabemos que comprar um veículo é um passo importante, e nossa missão é garantir que esse processo seja claro, seguro e, acima de tudo, fácil.</p>
                        <p>Diferente do modelo tradicional, focamos em uma <strong>curadoria digital rigorosa</strong>. Cada carro em nosso estoque é selecionado criteriosamente para garantir que você leve para casa qualidade e procedência, sem letras miúdas.</p>
                    </div>
                    
                    <div class="row mt-4 g-3">
                        <div class="col-md-6">
                            <div class="value-card h-100">
                                <h6 class="fw-bold text-uppercase small text-primary">Nossa Missão</h6>
                                <p class="mb-0 small">Proporcionar a melhor experiência de compra, eliminando burocracias desnecessárias.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="value-card h-100">
                                <h6 class="fw-bold text-uppercase small text-primary">Nosso Diferencial</h6>
                                <p class="mb-0 small">Atendimento humanizado aliado a ferramentas digitais para facilitar sua escolha.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-c1">Por que escolher a Carros Fácil?</h2>
                <p class="text-muted">Focamos no que realmente importa para você.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="icon-box text-center">
                        <i class="bi bi-search"></i>
                        <h5>Curadoria Exclusiva</h5>
                        <p class="small text-muted">Não temos todos os carros, apenas os melhores. Filtramos o estoque para que você tenha apenas opções de alta qualidade.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon-box text-center">
                        <i class="bi bi-shield-lock"></i>
                        <h5>Transparência Total</h5>
                        <p class="small text-muted">Informações reais sobre o estado de cada veículo. Sem surpresas negativas na hora da visita ou da compra.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon-box text-center">
                        <i class="bi bi-chat-heart"></i>
                        <h5>Foco no Cliente</h5>
                        <p class="small text-muted">Somos uma loja nova com energia para oferecer o melhor atendimento personalizado da região.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('./Components/Footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>