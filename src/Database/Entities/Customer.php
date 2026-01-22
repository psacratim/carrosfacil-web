<?php
namespace Database\Entities;

class Client
{
    private int $id;

    private string $cpf;
    private ?string $rg;

    private string $name;
    private string $birthDate;

    private string $username;
    private string $password;

    private string $address;
    private ?string $zipCode;
    private int $number;
    private ?string $complement;
    private string $district;
    private string $city;
    private string $state;

    private string $phone1;
    private ?string $phone2;

    private ?string $email;

    private string $maritalStatus;
    private string $gender;

    private string $createdAt;
    private ?bool $status;

    public function __construct(
        int $id,
        string $cpf,
        ?string $rg,
        string $name,
        string $birthDate,
        string $username,
        string $password,
        string $address,
        ?string $zipCode,
        int $number,
        ?string $complement,
        string $district,
        string $city,
        string $state,
        string $phone1,
        ?string $phone2,
        ?string $email,
        string $maritalStatus,
        string $gender,
        string $createdAt,
        ?bool $status
    ) {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->username = $username;
        $this->password = $password;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->number = $number;
        $this->complement = $complement;
        $this->district = $district;
        $this->city = $city;
        $this->state = $state;
        $this->phone1 = $phone1;
        $this->phone2 = $phone2;
        $this->email = $email;
        $this->maritalStatus = $maritalStatus;
        $this->gender = $gender;
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
