<?php
namespace Database\Entities;

class Model {
    private int $id;
    private int $brandId;
    private string $name;
    private string $observation;
    private string $createdAt;
    private bool $status;

    public function __construct(int $id, int $brandId,string $name, ?string $observation, string $createdAt, bool $status)
    {
        $this->id = $id;
        $this->brandId = $brandId;
        $this->name = $name;
        $this->observation = $observation;
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
?>