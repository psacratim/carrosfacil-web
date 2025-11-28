<?php
require_once("../../conexao/conecta.php");

$sql = "
SELECT veiculo.id, modelo.nome 'modelo', veiculo.categoria, veiculo.estado_do_veiculo, veiculo.preco_venda, veiculo.preco_desconto, veiculo.estoque, veiculo.data_cadastro, veiculo.status
FROM veiculo
INNER JOIN modelo ON modelo.id = veiculo.id_modelo
";
$id = $_POST['id'] ?? "";
$model = $_POST['model'];
$category = $_POST['category'];
$states = $_POST['states'] ?? "";
$status = $_POST['status'];
$conditions = [];

if ($id !== "") {
    $conditions[] = "veiculo.id = $id";
}

if ($model !== "") {
    $conditions[] = "modelo.nome LIKE '%$model%'";
}

if ($category !== "") {
    $conditions[] = "veiculo.categoria = '$category'";
}

if ($states !== "") {
    $conditions[] = "veiculo.estado_do_veiculo = '$states'";
}
if ($status !== "") {
    $conditions[] = "veiculo.status = $status";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions); // O implode é igual o String.join do java. Pega uma lista e converte pra string com um separator, sendo o 'AND' nesse caso.
}

$query = mysqli_query($conexao, $sql);
if (mysqli_num_rows($query) > 0) {
?>
    <div class="card-body p-0">
        <table class="table m-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Situação</th>
                    <th scope="col">Preço Venda</th>
                    <th scope="col">Preço Desconto</th>
                    <th scope="col">Estoque</th>
                    <th scope="col">Data Cadastro</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($query as $veiculo) {
                ?>
                    <tr>
                        <td><?php echo $veiculo['id'] ?></td>
                        <td><?php echo $veiculo['modelo'] ?></td>
                        <td><?php echo $veiculo['categoria'] ?></td>
                        <td><?php echo $veiculo['estado_do_veiculo'] ?></td>
                        <td><?php echo number_format($veiculo['preco_venda'], 2, ',', '.') ?></td>
                        <td><?php echo number_format($veiculo['preco_desconto'], 2, ',', '.') ?></td>
                        <td><?php echo $veiculo['estoque'] ?></td>
                        <td><?php echo $veiculo['data_cadastro'] ?></td>
                        <td>
                            <?php
                            if ($veiculo['status'] == 0) {
                                echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-success">Ativo</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $veiculo['id'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="acoes.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_veiculo" value="<?php echo $veiculo['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo '<div class="alert alert-danger m-3" role="alert">Nenhum registro encontrado!</div>';
}
?>