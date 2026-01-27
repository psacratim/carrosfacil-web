<?php

namespace Database\Entities;

class Role
{
    private int $id;
    private string $name;
    private string $observation;
    private string $createdAt;
    private bool $status;

    public function __construct(int $id, string $name, ?string $observation, string $createdAt, bool $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->observation = $observation;
        $this->createdAt = $createdAt;
        $this->status = $status;
    }

    public static function fromArray(array $row): Role
    {
        return new Role(
            (int) $row['id'],
            $row['name'],
            $row['observation'],
            $row['createdAt'],
            (bool) $row['status']
        );
    }

    public static function fromNewRegister(string $name, string $observation): Role
    {
        // Cria um registro padrão que é identificavel como: CRIAÇÃO. Ele ignora os atributos na hora de cadastrar, sendo os atributos ignorados: ID, STATUS e DATA CADASTRO.

        return new Role(
            0,
            $name,
            $observation,
            "", 
            1
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): void
    {
        $this->observation = $observation;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }
}
