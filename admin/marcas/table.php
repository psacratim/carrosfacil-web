<?php
require_once("../../conexao/conecta.php");

$sql = "SELECT * FROM marca";
$nome = $_POST['nome'];
$status = $_POST['status'];
$conditions = [];

if ($nome !== "") {
    $conditions[] = "marca.nome LIKE '%$nome%'";
}

if ($status !== "") {
    $conditions[] = "marca.status = $status";
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
                    <th>#</th>
                    <th>Nome</th>
                    <th>Observação</th>
                    <th>Data Cadastro</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($query as $marca) { ?>
                    <tr>
                        <td><?php echo $marca['id']; ?></td>
                        <td><?php echo htmlspecialchars($marca['nome']); ?></td>
                        <td><?php echo ($marca['observacao'] == "" ? "Nenhuma observação" : $marca['observacao']) ?></td>
                        <td><?php echo date('d/m/Y', strtotime($marca['data_cadastro'])); ?></td>
                        <td>
                            <?php
                            if ($marca['status'] == 0) {
                                echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-success">Ativo</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <button type="button"
                                class="btn btn-outline-success btn-sm editar-btn"
                                data-id="<?php echo $marca['id']; ?>"
                                data-nome="<?php echo htmlspecialchars($marca['nome']); ?>"
                                data-observacao="<?php echo htmlspecialchars($marca['observacao']); ?>"
                                data-status="<?php echo $marca['status']; ?>"
                                title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="acoes.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_marca" value="<?php echo $marca['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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