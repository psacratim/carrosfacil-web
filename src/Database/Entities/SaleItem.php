<?php
namespace Database\Entities;

class SaleItem
{
    private int $id;

    private int $idVehicle;
    private int $idSale;

    private int $quantity;

    private float $unitValue;
    private float $totalValue;

    public function __construct(
        int $id,
        int $idVehicle,
        int $idSale,
        int $quantity,
        float $unitValue,
        float $totalValue
    ) {
        $this->id = $id;
        $this->idVehicle = $idVehicle;
        $this->idSale = $idSale;
        $this->quantity = $quantity;
        $this->unitValue = $unitValue;
        $this->totalValue = $totalValue;
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
