<?php

namespace App\Repository;

use App\Entity\Team;

class TeamRepository extends BasicRepository
{
    protected function getKey(): string
    {
        return Team::class;
    }
}
