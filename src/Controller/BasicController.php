<?php

namespace App\Controller;

use App\Exception\ExceptionBadRequest;

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

    protected function entityNotFound(mixed $id): void
    {
        $exception = new ExceptionBadRequest();
        $exception->setEntityNotFoundMessage($id);
        throw $exception;
    }
}
