<?php
namespace App\Model;

class Rental
{
    private ?int $id;
    private Car $car;
    private User $renter;
    private \DateTime $startDate;
    private \DateTime $endDate;
    private string $status; // Pending, Approved, Rejected, Completed

    public function __construct(?int $id, Car $car, User $renter, \DateTime $startDate, \DateTime $endDate, string $status)
    {
        $this->id = $id;
        $this->car = $car;
        $this->renter = $renter;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function setCar(Car $car): void
    {
        $this->car = $car;
    }

    public function getRenter(): User
    {
        return $this->renter;
    }

    public function setRenter(User $renter): void
    {
        $this->renter = $renter;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
