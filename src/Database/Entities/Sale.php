<?php
namespace Database\Entities;

class Sale
{
    private int $id;

    private int $idEmployee;
    private int $idClient;

    private float $totalValue;
    private float $discountValue;
    private int $discount;

    private string $createdAt;
    private ?bool $status;

    public function __construct(
        int $id,
        int $idEmployee,
        int $idClient,
        float $totalValue,
        float $discountValue,
        int $discount,
        string $createdAt,
        ?bool $status
    ) {
        $this->id = $id;
        $this->idEmployee = $idEmployee;
        $this->idClient = $idClient;
        $this->totalValue = $totalValue;
        $this->discountValue = $discountValue;
        $this->discount = $discount;
        $this->createdAt = $createdAt;
        $this->status = $status;
    }

    public function __get(string $property)
    {
        if (!property_exists($this, $property)) {
            throw new \Exception("Propriedade {$property} não existe");
        }

        return $this->$property;
    }

    public function __set(string $property, $value): void
    {
        if (!property_exists($this, $property)) {
            throw new \Exception("Propriedade {$property} não existe");
        }

        $this->$property = $value;
    }
}
