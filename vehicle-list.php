<?php
require_once("./conexao/conecta.php");

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

if ($search_value !== ""){    
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
    $query .= " WHERE " . implode(" AND ", $conditions); // O implode é igual o String.join do java. Pega uma lista e converte pra string com um separator, sendo o 'AND' nesse caso.
}

$result = mysqli_query($connection, $query);
$num_rows = mysqli_num_rows($result);
?>
<div class="header">
    <h2>Nossos veículos</h2>
    <div class="vehicles-counter">
        <?php echo $num_rows ?> veículos encontrados
    </div>
</div>

<div class="list">
    <?php
    if ($num_rows > 0) {
        foreach ($result as $veiculo) {
    ?>
            <div class="vehicle-card col-4">
                <div class="header">
                    <?php
                    if ($veiculo['status'] == 0) {
                        echo '<div class="status bg-danger">Indisponível</div>';
                    } else {
                        echo '<div class="status">Disponível</div>';
                    }
                    ?>
                    <?php
                    if ($veiculo['tem_desconto']) {
                        echo '<div class="discount"><i class="bi bi-tag"></i>-' . $veiculo['desconto'] . '%</div>';
                    }
                    ?>
                </div>
                <?php

                ?>
                <img src="./images/<?php echo $veiculo['foto'] ?>" class="img-fluid">
                <h4>
                    <?php echo $veiculo['nome_modelo'] ?>
                </h4>
                <div class="infos">
                    <div class="info w-25">
                        <i class="bi bi-calendar3"></i>
                        <?php echo $veiculo['ano'] ?>
                    </div>
                    <div class="info w-75 text-end">
                        <i class="bi bi-gear"></i>
                        <?php echo $veiculo['tipo_cambio'] ?>
                    </div>
                    <div class="info">
                        <i class="bi bi-fuel-pump text-start"></i>
                        <?php echo $veiculo['tipo_combustivel'] ?>
                    </div>
                    <!-- <div class="info d-flex justify-content-between text-end align-items-center"> -->
                    <div class="info text-end">
                        <i class="bi bi-speedometer"></i>
                        <?php
                        if ($veiculo['quilometragem'] > 0) {
                            echo number_format($veiculo['quilometragem'], 0, ',', '.');
                        } else echo 'Zero KM';
                        ?>
                    </div>
                </div>

                <div class="tags">
                    <div class="tag">
                        USADO
                    </div>
                    <div class="tag">
                        SUV
                    </div>
                </div>

                <?php
                if ($veiculo['tem_desconto']) {
                    echo "<div class='price-discount'>";
                    echo "<span class='discount'>R$" . number_format($veiculo['preco_venda'], 2, ',', '.') . "</span>";
                    echo "<span class='current'>R$" . number_format($veiculo['preco_desconto'], 2, ',', '.') . "</span>";
                    echo "</div>";
                } else {
                    echo "<div class='price-normal'>";
                    echo "<span class='current'>R$ " . number_format($veiculo['preco_venda'], 2, ',', '.') . "</span>";
                    echo "</div>";
                }
                ?>

                <a href="#" class="view-more">Saber Mais</a>
            </div>
    <?php
        }
    }
    ?>
</div>