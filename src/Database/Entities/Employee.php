<?php
namespace Database\Entities;

class Employee
{
    private int $id;
    private ?int $idCargo;

    private string $cpf;
    private ?string $rg;

    private string $name;
    private ?string $socialName;

    private string $password;
    private ?float $salary;

    private string $gender;
    private string $username;
    private string $maritalStatus;

    private string $birthDate;
    private int $accessType;

    private ?string $mobilePhone;
    private string $contactPhone;
    private ?string $homePhone;

    private string $address;
    private ?string $zipCode;
    private int $number;
    private ?string $complement;
    private string $district;
    private string $city;
    private string $state;

    private ?string $email;
    private ?string $photo;

    private string $createdAt;
    private bool $status;

    public function __construct(
        int $id,
        ?int $idCargo,
        string $cpf,
        ?string $rg,
        string $name,
        ?string $socialName,
        string $password,
        ?float $salary,
        string $gender,
        string $username,
        string $maritalStatus,
        string $birthDate,
        int $accessType,
        ?string $mobilePhone,
        string $contactPhone,
        ?string $homePhone,
        string $address,
        ?string $zipCode,
        int $number,
        ?string $complement,
        string $district,
        string $city,
        string $state,
        ?string $email,
        ?string $photo,
        string $createdAt,
        bool $status
    ) {
        $this->id = $id;
        $this->idCargo = $idCargo;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->name = $name;
        $this->socialName = $socialName;
        $this->password = $password;
        $this->salary = $salary;
        $this->gender = $gender;
        $this->username = $username;
        $this->maritalStatus = $maritalStatus;
        $this->birthDate = $birthDate;
        $this->accessType = $accessType;
        $this->mobilePhone = $mobilePhone;
        $this->contactPhone = $contactPhone;
        $this->homePhone = $homePhone;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->number = $number;
        $this->complement = $complement;
        $this->district = $district;
        $this->city = $city;
        $this->state = $state;
        $this->email = $email;
        $this->photo = $photo;
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
