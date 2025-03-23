<?php
namespace App\Model;

class Car
{
    private ?int $id;
    private string $brand;
    private string $model;
    private int $horsePower;
    private string $image;
    private CarType $carType;
    private User $owner;

    public function __construct(?int $id, string $brand, string $model, int $horsePower, string $image, CarType $carType, User $owner)
    {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->horsePower = $horsePower;
        $this->image = $image;
        $this->carType = $carType;
        $this->owner = $owner;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getHorsePower(): int
    {
        return $this->horsePower;
    }

    public function setHorsePower(int $horsePower): void
    {
        $this->horsePower = $horsePower;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getCarType(): CarType
    {
        return $this->carType;
    }

    public function setCarType(CarType $carType): void
    {
        $this->carType = $carType;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }
}
