<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;

class TeamController extends BasicController
{

    public function getAll(): void
    {
        $teamRepository = new TeamRepository();
        $this->success($this->entitiesToArray($teamRepository->getAll()));
    }

    public function getOne(int $id): void
    {
        $teamRepository = new TeamRepository();
        $team = $teamRepository->getOne($id);
        if (is_null($team)) {
            $this->entityNotFound($id);
        }
        $this->success($team->toArray());
    }


    public function create(): void
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );
        $team = new Team();
        $team = $team->fromArray($data);
        $teamRepository = new TeamRepository();
        $team = $teamRepository->create($team);
        $this->success($team->toArray());
    }

    public function update(int $id): void
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );
        $teamRepository = new TeamRepository();
        $team = $teamRepository->getOne($id);
        if (is_null($team)) {
            $this->entityNotFound($id);
        }
        $team = $team->fromArray($data);
        $team = $teamRepository->update($id, $team);

        $this->success($team->toArray());
    }

    public function delete(int $id): void
    {
        $teamRepository = new TeamRepository();
        $success = $teamRepository->delete($id);
        if ($success === false) {
            $this->entityNotFound($id);
        }
        $this->success($success);
    }
}
