<?php
require_once("../../conexao/conecta.php");

$sql = "SELECT id, nome, descricao, icone, data_cadastro, status FROM caracteristica";
$nome = $_POST['nome'];
$status = $_POST['status'];
$conditions = [];

if ($nome !== "") {
    $conditions[] = "nome LIKE '%$nome%'";
}

if ($status !== "") {
    $conditions[] = "status = $status";
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
                    <th>Ícone</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($query as $caracteristica) { ?>
                    <tr>
                        <td><?php echo $caracteristica['id'] ?></td>
                        <td>
                            <img class="icone-tabela" src="../../images/<?php echo $caracteristica['icone']; ?>" alt="">
                        </td>
                        <td><?php echo htmlspecialchars($caracteristica['nome']); ?></td>
                        <td><?php echo htmlspecialchars($caracteristica['descricao']); ?></td>
                        <td>
                            <?php
                            if ($caracteristica['status'] == 0) {
                                echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-success">Ativo</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <button type="button"
                                class="btn btn-outline-success btn-sm editar-btn"
                                data-id="<?php echo $caracteristica['id']; ?>"
                                data-nome="<?php echo htmlspecialchars($caracteristica['nome']); ?>"
                                data-descricao="<?php echo htmlspecialchars($caracteristica['descricao']); ?>"
                                data-icone="<?php echo htmlspecialchars($caracteristica['icone']); ?>"
                                data-status="<?php echo $caracteristica['status']; ?>"
                                title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="actions.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_caracteristica" value="<?php echo $caracteristica['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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