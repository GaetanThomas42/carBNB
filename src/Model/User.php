<?php
namespace App\Model;

class User
{
    private ?int $id;
    private string $username;
    private string $password;
    private array  $roles; // Admin, CarOwner, CarLessee

    public function __construct(?int $id, string $username, string $password, array  $roles)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array 
    {
        return $this->roles;
    }

    public function setRole(array  $roles): void
    {
        $this->roles = $roles;
    }
}
