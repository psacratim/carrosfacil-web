<?php

namespace Database\Repositories;

use Database\Database;
use Database\Entities\Role;
use PDO;

class RoleRepository
{

    private const TABLE_NAME = "cargos";
    private const SELECT_FULL_COLUMNS = "id, nome 'name', observacao 'observation', data_cadastro 'createdAt', status";

    public static function getById(int $id): ?Role
    {
        $connection = Database::getConnection();

        $sql = "SELECT " . self::SELECT_FULL_COLUMNS . "
            FROM " . self::TABLE_NAME . "
            WHERE id = :id
            LIMIT 1";

        $stmt = $connection->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return Role::fromArray($row);
    }

    /**
     * @return list<Role>
     */
    public static function getAll(): array
    {
        $connection = Database::getConnection();

        $sql = "SELECT " . self::SELECT_FULL_COLUMNS . "
            FROM " . self::TABLE_NAME;

        $stmt = $connection->prepare($sql);
        $stmt->execute();

        $roles = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roles[] = Role::fromArray($row);
        }

        return $roles;
    }


    public static function getAllWithFilter() {}

    public static function ensureSave(Role $role): ?Role
    {
        $connection = Database::getConnection();

        if ($role->getId() === null) {
            $sql = "
            INSERT INTO " . self::TABLE_NAME . " (nome, observacao, data_cadastro, status) VALUES (:name, :observation, NOW(), 1)
            ";

            $stmt = $connection->prepare($sql);
            $success = $stmt->execute([
                'name'        => $role->getName(),
                'observation' => $role->getObservation()
            ]);

            if (!$success) {
                return null;
            }

            $role->setId((int) $connection->lastInsertId());
            return $role;
        }

        $sql = "
        UPDATE " . self::TABLE_NAME . " SET nome = :name, observacao = :observation, data_cadastro = :createdAt, status = :status WHERE id = :id
        ";

        $stmt = $connection->prepare($sql);
        $success = $stmt->execute([
            'id'          => $role->getId(),
            'name'        => $role->getName(),
            'observation' => $role->getObservation(),
            'createdAt'   => $role->getCreatedAt(),
            'status'      => $role->isStatus(),
        ]);

        return $success ? $role : null;
    }
}
