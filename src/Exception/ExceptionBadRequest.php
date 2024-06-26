<?php

namespace App\Exception;

class ExceptionBadRequest extends \Exception
{
    public function setEntityNotFoundMessage($id)
    {
        $this->setMessage('Entity with id ' . $id . ' not found');
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
