<?php
require_once("./conexao/conecta.php");

header('Content-Type: application/json; charset=utf-8');
ob_start();

$counterResult = mysqli_query($connection, "SELECT id FROM veiculo WHERE status = 1");
$sqlCount = mysqli_num_rows($counterResult); // quantidade

var_dump($sqlCount);
echo '<br>';

var_dump($_POST['page'] );
$currentPage = $_POST['page'] ?? 1;
$url = "?page=";

$viewAmountPerPage = 2;  // paginaQtdd
$startLimit = ($currentPage * $viewAmountPerPage) - $viewAmountPerPage; // valorInicial
$maxPages = ceil($sqlCount / $viewAmountPerPage);

$nextPage = $currentPage + 1;
$previousPage = $currentPage - 1;

echo '<br>';
var_dump($maxPages);

$query = "
SELECT veiculo.id, modelo.nome 'nome_modelo', veiculo.tem_desconto, veiculo.desconto, veiculo.ano, veiculo.quilometragem, veiculo.tipo_combustivel, veiculo.tipo_cambio, veiculo.preco_venda, veiculo.preco_desconto, veiculo.foto, veiculo.status, veiculo.descricao, marca.nome FROM veiculo INNER JOIN modelo ON modelo.id = veiculo.id_modelo
INNER JOIN marca ON marca.id = modelo.id_marca
";
$search_value = $_POST['search_value'] ?? "";
$category = $_POST['category'] ?? "";
$condition = $_POST['condition'] ?? "";
$brand = $_POST['brand'] ?? "";
$fuel = $_POST['fuel'] ?? "";
$gearbox = $_POST['gearbox'] ?? "";
$mileage = $_POST['mileage'] ?? "";
$price_range = $_POST['price_range'] ?? "";
$year = $_POST['year'] ?? "";
$conditions = [];

if ($search_value !== "") {
    $conditions[] = "(
        modelo.nome LIKE '%$search_value%' 
        OR marca.nome LIKE '%$search_value%' 
        OR veiculo.descricao LIKE '%$search_value%'
    )";
}

if ($category !== "") {
    $conditions[] = "veiculo.categoria LIKE '%$category%'";
}

if ($condition !== "") {
    $conditions[] = "veiculo.estado_do_veiculo = '$condition'";
}

if ($brand !== "") {
    $conditions[] = "marca.id = $brand";
}
if ($fuel !== "") {
    $conditions[] = "veiculo.tipo_combustivel LIKE '%$fuel%'";
}
if ($gearbox !== "") {
    $conditions[] = "veiculo.tipo_cambio LIKE '%$gearbox%'";
}
if ($mileage !== "") {
    $conditions[] = "veiculo.quilometragem BETWEEN 0 AND $mileage";
}
if ($price_range !== "10000000") {
    $conditions[] = "veiculo.preco_venda BETWEEN 0 AND $price_range";
    $conditions[] = "veiculo.preco_desconto BETWEEN 0 AND $price_range";
}
if ($year !== "") {
    $conditions[] = "veiculo.ano = $year";
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}
$query .= " " . "LIMIT $startLimit, $viewAmountPerPage";

$result = mysqli_query($connection, $query);
$num_rows = mysqli_num_rows($result);
?>

<?php
?>
<div class="col-12 mb-2">
    <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm">
        <h5 class="fw-bold mb-0">Nossos veículos</h5>
        <span class="badge bg-primary rounded-pill"><?php echo $num_rows ?> veículos</span>
    </div>
</div>

<?php
if ($num_rows > 0) {
    foreach ($result as $veiculo) {
        $caminho_imagem = "./images/" . $veiculo['foto'];
        $placeholder = './assets/img/placeholder-veiculo.avif';
        $foto_final = (!empty($veiculo['foto']) && file_exists($caminho_imagem)) ? $caminho_imagem : $placeholder;
?>
        <div class="col-12 col-md-6 col-xl-4 d-flex align-items-stretch">
            <div class="card w-100 border-0 shadow-sm vehicle-card-modern position-relative">

                <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1" style="z-index: 3;">
                    <?php if ($veiculo['status'] == 0): ?>
                        <span class="badge bg-danger">Indisponível</span>
                    <?php else: ?>
                        <span class="badge bg-success">Disponível</span>
                    <?php endif; ?>

                    <?php if ($veiculo['tem_desconto']): ?>
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-tag-fill"></i> -<?php echo $veiculo['desconto']; ?>%
                        </span>
                    <?php endif; ?>
                </div>

                <div class="vehicle-image-container">
                    <img src="<?php echo $foto_final; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($veiculo['nome_modelo']); ?>">
                </div>

                <div class="card-body p-3 d-flex flex-column">
                    <div class="text-primary fw-bold small text-uppercase mb-1"><?php echo $veiculo['nome']; ?></div>
                    <h5 class="card-title fw-bold text-dark mb-3"><?php echo $veiculo['nome_modelo'] ?></h5>

                    <div class="row g-2 mb-3">
                        <div class="col-6 small text-muted">
                            <i class="bi bi-calendar3 text-primary me-1"></i> <?php echo $veiculo['ano'] ?>
                        </div>
                        <div class="col-6 small text-muted text-end">
                            <i class="bi bi-gear text-primary me-1"></i> <?php echo $veiculo['tipo_cambio'] ?>
                        </div>
                        <div class="col-6 small text-muted">
                            <i class="bi bi-fuel-pump text-primary me-1"></i> <?php echo $veiculo['tipo_combustivel'] ?>
                        </div>
                        <div class="col-6 small text-muted text-end">
                            <i class="bi bi-speedometer text-primary me-1"></i>
                            <?php echo ($veiculo['quilometragem'] > 0) ? number_format($veiculo['quilometragem'], 0, ',', '.') . ' km' : 'Zero KM'; ?>
                        </div>
                    </div>

                    <div class="mt-auto pt-3 border-top">
                        <div class="price-section-container mb-3">
                            <?php if ($veiculo['tem_desconto']): ?>
                                <small class="text-muted text-decoration-line-through d-block old-price-height">
                                    R$ <?php echo number_format($veiculo['preco_venda'], 2, ',', '.') ?>
                                </small>
                                <span class="h4 fw-bold text-success mb-0 d-block">
                                    R$ <?php echo number_format($veiculo['preco_desconto'], 2, ',', '.') ?>
                                </span>
                            <?php else: ?>
                                <small class="text-muted d-block old-price-height invisible">Placeholder</small>
                                <span class="h4 fw-bold text-dark mb-0 d-block">
                                    R$ <?php echo number_format($veiculo['preco_venda'], 2, ',', '.') ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <a href="Product.php?id=<?= $veiculo['id'] ?>" class="btn btn-primary w-100 fw-bold rounded-pill">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

<?php
} else {
    echo '<div class="col-12 text-center py-5"><h4 class="text-muted">Nenhum veículo encontrado.</h4></div>';
}

$html = ob_get_clean();

echo json_encode([
    "html" => $html,
    "maxPages" => (string) $maxPages
]);
?>