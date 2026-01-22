<?php
namespace Database\Entities;

class Item {
    private int $id;
    private string $name;
    private string $observation;
    private int $icon;
    private string $createdAt;
    private bool $status;

    public function __construct(int $id, string $icon, string $name, ?string $observation, string $createdAt, bool $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->observation = $observation;
        $this->icon = $icon;
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