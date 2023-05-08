<?php

namespace App\Entity;

/**
 * Parent class entity
 * 
 * @package AbstractEntity
 * 
 * @var int     $_id
 */
abstract class AbstractEntity
{
    /**
     * @var int Identifies entity
     */
    protected int $_id;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->_id = $id;

        return $this;
    }
}