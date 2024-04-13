<?php

namespace App\Controller;

abstract class BasicController
{
    protected function entitiesToArray(array $entities): array
    {
        $entitiesData = [];
        foreach ($entities as $entity) {
            $entitiesData[] = $entity->toArray();
        }

        return $entitiesData;
    }

    protected function success(mixed $data): void
    {
        echo json_encode(['success' => $data]);
        exit;
    }
}
