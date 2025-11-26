<?php
require_once("../../conexao/conecta.php");

$sql = "SELECT id, nome, observacao, data_cadastro, status FROM cargo";
$status = $_POST['status'] ?? ""; // Esse ?? é legal: Se o valor da esquerda não existe, usa da direita.
$nome = $_POST['nome'];
$conditions = [];

if ($status !== "") {
    $conditions[] = "status = $status";
}

if ($nome !== "") {
    $conditions[] = "nome LIKE '%$nome%'";
}

if (!empty($conditions)) {
    $sql .= " WHERE ". implode(" AND ", $conditions); // O implode é igual o String.join do java. Pega uma lista e converte pra string com um separator, sendo o 'AND' nesse caso.
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
                <?php foreach ($query as $cargo) { ?>
                    <tr>
                        <td><?php echo $cargo['id'] ?></td>
                        <td><?php echo htmlspecialchars($cargo['nome']); ?></td>
                        <td><?php echo ($cargo['observacao'] == "" ? "Nenhuma observação" : $cargo['observacao']) ?></td>
                        <td><?php echo date('d/m/Y', strtotime($cargo['data_cadastro'])) ?></td>
                        <td>
                            <?php
                            if ($cargo['status'] == 0) {
                                echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-success">Ativo</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <button type="button"
                                class="btn btn-outline-success btn-sm editar-btn d-inline"
                                data-id="<?php echo $cargo['id']; ?>"
                                data-nome="<?php echo htmlspecialchars($cargo['nome']); ?>"
                                data-observacao="<?php echo htmlspecialchars($cargo['observacao']); ?>"
                                data-icone="<?php echo htmlspecialchars($cargo['icone']); ?>"
                                data-status="<?php echo $cargo['status']; ?>"
                                title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="actions.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_cargo" value="<?php echo $cargo['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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