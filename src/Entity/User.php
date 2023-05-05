<?php

namespace App\Entity;

/**
 * Class entity representing one user
 * 
 * @package User
 * 
 * @var int $_id
 * @var string $_email
 * @var string $_password
 * @var string $_first_name
 * @var string $_last_name
 */
class User
{
    /**
     * @var int Identifier
     */
    private int $_id;

    /**
     * @var string Email, to auth & to contact
     */
    private string $_email;

    /**
     * @var string Password to auth, NOT stored in session
     */
    private string $_password;

    /**
     * @var string First name, personal info
     */
    private string $_first_name;

    /**
     * @var string Last name, personal info
     */
    private string $_last_name;

    /**
     * Get the value of _id
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * Set the value of _id
     */
    public function setId(int $_id): self
    {
        $this->_id = $_id;

        return $this;
    }

    /**
     * Get the value of _email
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * Set the value of _email
     */
    public function setEmail(string $_email): self
    {
        $this->_email = $_email;

        return $this;
    }

    /**
     * Get the value of _password
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * Set the value of _password
     */
    public function setPassword(string $_password): self
    {
        $this->_password = $_password;

        return $this;
    }

    /**
     * Get the value of _first_name
     */
    public function getFirstName(): string
    {
        return $this->_first_name;
    }

    /**
     * Set the value of _first_name
     */
    public function setFirstName(string $_first_name): self
    {
        $this->_first_name = $_first_name;

        return $this;
    }

    /**
     * Get the value of _last_name
     */
    public function getLastName(): string
    {
        return $this->_last_name;
    }

    /**
     * Set the value of _last_name
     */
    public function setLastName(string $_last_name): self
    {
        $this->_last_name = $_last_name;

        return $this;
    }
}