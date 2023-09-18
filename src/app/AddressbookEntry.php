<?php

namespace App;


class AddressbookEntry
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;
    private string $city;
    private string $street;
    private string $homeNumber;

    public function __construct(string $firstname, string $lastName)
    {
        $this->id = 0;
        $this->firstName = $firstname;
        $this->lastName = $lastName;

    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
    
}

?>
