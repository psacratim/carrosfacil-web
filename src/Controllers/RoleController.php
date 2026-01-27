<?php

namespace Controller;

use DTO\Response\CreateRoleDTO;
use Database\Entities\Role;
use Services\RoleService;

class RoleController {

    public static function create() {
        // Header: Fala pro navegador que retornará uma resposta em JSON.
        header('Content-Type: application/json');

        // Obter os dados inicais enviados na solicitação e validar para criar o objeto de cargo.
        if (empty($_POST['name'])) {
            http_response_code(400);
            return json_encode([
                'code' => 'INVALID_REQUEST',
                'message' => "Field 'name' is required"
            ]); // Pedido invalido.
        }

        // Criar o objeto de role e enviar ao service, o nome é o único obrigatório.
        $name = $_POST['name'];
        $observation = $_POST['observation'] ?? "";
        $role = Role::fromNewRegister($name, $observation);

        // Envie pro service processar e retornar a resposta.
        $role = RoleService::create($role);
        if ($role === null){
            http_response_code(500);
            return json_encode([
                'code' => 'ROLE_ENSURE_SAVE_FAILED',
                'message' => "Unexpected server error."
            ]); // Opções: Banco não conectado, exception interna não conhecida ou erro não identificado.
        }

        http_response_code(201);
        return json_encode([
            new CreateRoleDTO($role->getId())
        ]);
    }

    public static function update() {

    }

    public static function delete() {

    }

    public static function show() {

    }
}

?>