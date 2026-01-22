<?php
namespace Database\Entities;

class VehicleItem
{
    private int $idVehicle;
    private int $idFeature;

    public function __construct(
        int $idVehicle,
        int $idFeature
    ) {
        $this->idVehicle = $idVehicle;
        $this->idFeature = $idFeature;
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
