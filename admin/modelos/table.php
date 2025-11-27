<?php
require_once("../../conexao/conecta.php");

$sql = "
SELECT modelo.id, modelo.id_marca, marca.nome AS nome_marca, modelo.nome AS nome_modelo, modelo.observacao, modelo.data_cadastro, modelo.status
FROM modelo
INNER JOIN marca ON marca.id = modelo.id_marca
";
$nome_marca = $_POST['nome_marca'];
$nome_modelo = $_POST['nome_modelo'];
$status = $_POST['status'];
$conditions = [];

if ($nome_modelo !== "") {
    $conditions[] = "modelo.nome LIKE '%$nome_modelo%'";
}

if ($nome_marca !== "") {
    $conditions[] = "marca.nome LIKE '%$nome_marca%'";
}

if ($status !== "") {
    $conditions[] = "modelo.status = $status";
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
                    <th scope="col">Marca</th>
                    <th scope="col">Nome do Modelo</th>
                    <th scope="col">Observação</th>
                    <th scope="col">Data Cadastro</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($query as $modelo) { ?>
                    <tr>
                        <td><?php echo  $modelo['id'] ?></td>
                        <td><?php echo $modelo['nome_marca'] ?></td>
                        <td><?php echo $modelo['nome_modelo'] ?></td>
                        <td><?php echo $modelo['observacao'] ?></td>
                        <td><?php echo date('d/m/Y', strtotime($modelo['data_cadastro'])) ?></td>
                        <td>
                            <?php
                            if ($modelo['status'] == 0) {
                                echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-success">Ativo</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="#"
                                class="btn btn-outline-success btn-sm btn-editar"
                                title="Editar"
                                data-id="<?php echo $modelo['id'] ?>"
                                data-id-marca="<?php echo $modelo['id_marca'] ?>"
                                data-nome-modelo="<?php echo $modelo['nome_modelo'] ?>"
                                data-observacao="<?php echo $modelo['observacao'] ?>"
                                data-status="<?php echo $modelo['status'] ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#modelosModal">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="acoes.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_modelo" value="<?php echo $modelo['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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