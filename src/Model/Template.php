<?php

namespace App\Model;

/**
 * Interface for model accessing database
 */
interface Template
{
    // Find all elements of a table
    public function findAll(): array|false;

    // Find one element of a table using its id
    public function find(int $id): array|false;

    // Find one element of a table using multiple criteria
    public function findBy(array $fields) : array|false;
}