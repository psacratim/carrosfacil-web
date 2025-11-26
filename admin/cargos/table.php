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