<?php

namespace App\Repository;

use App\Entity\BaseEntity;
use Memcached;

abstract class BasicRepository
{
    private const MEMCACHED_SERVER = 'testMemcached'; // ToDo: move it to Environment
    private const MEMCACHED_PORT = 11211;

    protected Memcached $memcached;
    abstract protected function getKey(): string;

    public function __construct()
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer(self::MEMCACHED_SERVER, self::MEMCACHED_PORT);
    }

    public function getAll(): array
    {
        $className = $this->getKey();
        $entitiesData = $this->getAllAsData();

        $entities = [];
        foreach ($entitiesData as $id => $data) {
            $entity = new $className;
            $entities[$id] = $entity->fromArray($data);
        }

        return $entities;
    }

    public function getOne(int $id): ?BaseEntity
    {
        $entitiesData = $this->getAllAsData();
        if (!isset($entitiesData[$id])) {
            return null;
        }

        $className = $this->getKey();
        $entity = new $className;

        return $entity->fromArray($entitiesData[$id]);
    }

    public function create(BaseEntity $entity): BaseEntity
    {
        $nextId = $this->getLastId() + 1;
        $entity->id = $nextId;
        $entitiesData = $this->getAllAsData();
        $entitiesData[$nextId] = $entity->toArray();
        $this->memcached->set($this->getKey(), json_encode($entitiesData));

        return $entity;
    }

    public function update(int $id, BaseEntity $entity): ?BaseEntity
    {
        $entitiesData = $this->getAllAsData();
        if (!isset($entitiesData[$id])) {
            return null;
        }

        $entity->id = $id;
        $entitiesData[$id] = $entity->toArray();
        $this->memcached->set($this->getKey(), json_encode($entitiesData));

        return $entity;
    }

    public function delete(int $id): bool
    {
        $entitiesData = $this->getAllAsData();
        if (!isset($entitiesData[$id])) {
            return false;
        }

        unset($entitiesData[$id]);
        $this->memcached->set($this->getKey(), json_encode($entitiesData));

        return true;
    }

    protected function getAllAsData(): array
    {
        $entitiesData = json_decode(
            $this->memcached->get($this->getKey()),
            true
        );
        if (!$entitiesData) {
            return [];
        }

        return $entitiesData;
    }

    private function getLastId(): int
    {
        $lastId = 0;
        $entities = $this->getAll();
        if (count($entities) == 0) {
            return $lastId;
        }

        return max(array_keys($entities));
    }
}
