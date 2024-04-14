<?php

namespace App\Repository;

use App\Entity\Counter;

class CounterRepository extends BasicRepository
{
    protected function getKey(): string
    {
        return Counter::class;
    }
}
