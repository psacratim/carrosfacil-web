<?php
namespace Database\Entities;

class SalePayment
{
    private int $id;
    private int $idSale;

    private string $method;
    private float $finalValue;

    private int $installments;
    private ?bool $status;

    public function __construct(
        int $id,
        int $idSale,
        string $method,
        float $finalValue,
        int $installments,
        ?bool $status
    ) {
        $this->id = $id;
        $this->idSale = $idSale;
        $this->method = $method;
        $this->finalValue = $finalValue;
        $this->installments = $installments;
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
