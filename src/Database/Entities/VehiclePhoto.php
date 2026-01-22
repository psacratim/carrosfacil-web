<?php
namespace Database\Entities;

class VehiclePhoto
{
    private int $id;
    private int $idVehicle;

    private string $path;
    private int $order;

    private string $createdAt;
    private ?bool $status;

    public function __construct(
        int $id,
        int $idVehicle,
        string $path,
        int $order,
        string $createdAt,
        ?bool $status
    ) {
        $this->id = $id;
        $this->idVehicle = $idVehicle;
        $this->path = $path;
        $this->order = $order;
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
