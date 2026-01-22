<?php
namespace Database\Entities;

class Vehicle
{
    private int $id;
    private int $idModel;

    private string $category;
    private string $vehicleState;

    private int $usageTime;

    private float $costPrice;
    private float $salePrice;
    private float $discountPrice;

    private int $discount;
    private bool $hasDiscount;

    private int $profit;
    private int $mileage;

    private string $color;
    private ?string $description;

    private int $year;
    private string $gearType;
    private string $fuelType;

    private string $photo;

    private int $stock;

    private string $createdAt;
    private ?bool $status;

    public function __construct(
        int $id,
        int $idModel,
        string $category,
        string $vehicleState,
        int $usageTime,
        float $costPrice,
        float $salePrice,
        float $discountPrice,
        int $discount,
        bool $hasDiscount,
        int $profit,
        int $mileage,
        string $color,
        ?string $description,
        int $year,
        string $gearType,
        string $fuelType,
        string $photo,
        int $stock,
        string $createdAt,
        ?bool $status
    ) {
        $this->id = $id;
        $this->idModel = $idModel;
        $this->category = $category;
        $this->vehicleState = $vehicleState;
        $this->usageTime = $usageTime;
        $this->costPrice = $costPrice;
        $this->salePrice = $salePrice;
        $this->discountPrice = $discountPrice;
        $this->discount = $discount;
        $this->hasDiscount = $hasDiscount;
        $this->profit = $profit;
        $this->mileage = $mileage;
        $this->color = $color;
        $this->description = $description;
        $this->year = $year;
        $this->gearType = $gearType;
        $this->fuelType = $fuelType;
        $this->photo = $photo;
        $this->stock = $stock;
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
