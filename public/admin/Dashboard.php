<?php
require_once('../conexao/conecta.php');
require_once('../Components/Sidebar.php');

if (!isset($_SESSION)) {
    session_start();
}

// 1. Coleta de Estatísticas (Lógica em EN / Banco em PT-BR)

// Total de Vendas (Soma do valor_total)
$salesQuery = mysqli_query($connection, "SELECT SUM(valor_total) AS total FROM venda");
$totalSales = mysqli_fetch_assoc($salesQuery)['total'] ?? 0;

// Total de Clientes
$customersQuery = mysqli_query($connection, "SELECT COUNT(id) AS total FROM cliente");
$totalCustomers = mysqli_fetch_assoc($customersQuery)['total'] ?? 0;

// Total de Veículos em Estoque
$stockQuery = mysqli_query($connection, "SELECT SUM(estoque) AS total FROM veiculo");
$totalStock = mysqli_fetch_assoc($stockQuery)['total'] ?? 0;

// Total de Funcionários
$employeesQuery = mysqli_query($connection, "SELECT COUNT(id) AS total FROM funcionario");
$totalEmployees = mysqli_fetch_assoc($employeesQuery)['total'] ?? 0;

// 2. Vendas Recentes (Join para pegar o nome do cliente)
$recentSalesQuery = mysqli_query($connection, "
        SELECT v.id, c.nome AS cliente_nome, v.valor_total, v.data_cadastro 
        FROM venda v 
        INNER JOIN cliente c ON v.id_cliente = c.id 
        ORDER BY v.data_cadastro DESC LIMIT 5
    ");

// 3. Alerta de Estoque Baixo (Menos de 3 unidades)
$lowStockQuery = mysqli_query($connection, "
        SELECT m.nome AS modelo, v.cor, v.estoque 
        FROM veiculo v 
        INNER JOIN modelo m ON v.id_modelo = m.id 
        WHERE v.estoque < 3 
        ORDER BY v.estoque ASC LIMIT 5
    ");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Sistema de Veículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">


    <link rel="stylesheet" href="../../custom/css/style.css">
    <style>
        .stat-card {
            transition: transform 0.2s;
            border: none;
            border-radius: 15px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="d-flex">
        <?php echo Sidebar("dashboard"); ?>

        <main class="flex-grow-1 p-4">
            <div class="container-fluid">

                <div class="row mb-4">
                    <div class="col">
                        <h2 class="fw-bold">Visão Geral</h2>
                        <p class="text-secondary">Bem-vindo ao painel administrativo.</p>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-success text-white me-3">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div>
                                    <h6 class="text-secondary mb-0">Total Vendas</h6>
                                    <h4 class="fw-bold mb-0">R$ <?= number_format($totalSales, 2, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary text-white me-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <h6 class="text-secondary mb-0">Clientes</h6>
                                    <h4 class="fw-bold mb-0"><?= $totalCustomers ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-warning text-dark me-3">
                                    <i class="bi bi-car-front"></i>
                                </div>
                                <div>
                                    <h6 class="text-secondary mb-0">Veículos</h6>
                                    <h4 class="fw-bold mb-0"><?= $totalStock ?> un.</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-info text-white me-3">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div>
                                    <h6 class="text-secondary mb-0">Equipe</h6>
                                    <h4 class="fw-bold mb-0"><?= $totalEmployees ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm p-4 rounded-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Vendas Recentes</h5>
                                <a href="vendas/Index.php" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Data</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($sale = mysqli_fetch_assoc($recentSalesQuery)): ?>
                                            <tr>
                                                <td>#<?= $sale['id'] ?></td>
                                                <td class="fw-semibold"><?= $sale['cliente_nome'] ?></td>
                                                <td><?= date('d/m/Y', strtotime($sale['data_cadastro'])) ?></td>
                                                <td class="text-success fw-bold">R$ <?= number_format($sale['valor_total'], 2, ',', '.') ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                            <h5 class="fw-bold mb-4 text-danger">Atenção ao Estoque</h5>
                            <div class="list-group list-group-flush">
                                <?php while ($stock = mysqli_fetch_assoc($lowStockQuery)): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                        <div>
                                            <h6 class="mb-0 fw-bold"><?= $stock['modelo'] ?></h6>
                                            <small class="text-secondary"><?= $stock['cor'] ?></small>
                                        </div>
                                        <span class="badge bg-danger rounded-pill"><?= $stock['estoque'] ?> un.</span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            <?php if (mysqli_num_rows($lowStockQuery) == 0): ?>
                                <p class="text-center text-muted py-4">Tudo em ordem com o estoque!</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- API JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CUSTOM JS -->
    <script src="../../assets/js/components/admin-header.js"></script>
    <script src="../../assets/js/components/sidebar.js"></script>
</body>

</html>