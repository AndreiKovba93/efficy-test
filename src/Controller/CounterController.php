<?php

namespace App\Controller;

use App\Entity\Counter;
use App\Exception\ExceptionBadRequest;
use App\Repository\CounterRepository;
use App\Repository\TeamRepository;

class CounterController extends BasicController
{

    public function getAll(): void
    {
        $counterRepository = new CounterRepository();
        $this->success($this->entitiesToArray($counterRepository->getAll()));
    }

    public function getOne(int $id): void
    {
        $counterRepository = new CounterRepository();
        $counter = $counterRepository->getOne($id);
        if (is_null($counter)) {
            $this->entityNotFound($id);
        }
        $this->success($counter->toArray());
    }

    public function create(): void
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );
        $teamRepository = new TeamRepository();
        if (!isset($data['teamId'])) {
            $exception = new ExceptionBadRequest();
            $exception->setMessage('teamId is undefined');
            throw $exception;
        }
        $team = $teamRepository->getOne($data['teamId']);
        if (is_null($team)) {
            $this->entityNotFound($data['teamId']);
        }

        $counter = new Counter();
        $counter->teamId = $data['teamId'];
        $counterRepository = new CounterRepository();
        $counter = $counterRepository->create($counter);
        $this->success($counter->toArray());
    }

    public function increment(int $id): void
    {
        $counterRepository = new CounterRepository();
        $counter = $counterRepository->getOne($id);
        if (is_null($counter)) {
            $this->entityNotFound($id);
        }
        $counter->steps = $counter->steps + 1;
        $counter = $counterRepository->update($id, $counter);

        $this->success($counter->toArray());
    }

    public function delete(int $id): void
    {
        $counterRepository = new CounterRepository();
        $success = $counterRepository->delete($id);
        if ($success === false) {
            $this->entityNotFound($id);
        }
        $this->success($success);
    }
}
