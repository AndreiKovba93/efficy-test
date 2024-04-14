<?php

namespace App\Entity;

class Counter extends BaseEntity
{
    protected ?int $teamId = null;

    protected int $steps = 0;
}
