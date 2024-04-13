<?php

namespace App\Controller;

class CounterController
{

    public function getAll(): void
    {
        echo 'getAll';
        echo "\n\n";
    }

    public function getOne(int $id): void
    {
        echo 'getOne - ' . $id;
        echo "\n\n";
    }
}
