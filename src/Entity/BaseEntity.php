<?php

namespace App\Entity;

use Exception;

abstract class BaseEntity
{
    protected ?int $id = null;

    public function __get(string $name): mixed
    {
        if (!property_exists($this, $name)) {
            throw new Exception($name . ' is not a valid property in ' . get_class($this));
        }

        return $this->$name;
    }

    public function __set(string $name, mixed $value): void
    {
        if (!property_exists($this, $name)) {
            throw new Exception($name . ' is not a valid property in ' . get_class($this));
        }
        $this->$name = $value;
    }

    public function toArray(): array
    {
        $reflect = new \ReflectionClass(get_class($this));
        $fields = $reflect->getProperties();
        $data = [];
        foreach ($fields as $field) {
            $fieldName = $field->getName();
            $data[$fieldName] = $this->$fieldName;
        }

        return $data;
    }

    public function fromArray($data): self
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }
}
