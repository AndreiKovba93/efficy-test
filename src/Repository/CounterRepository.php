<?php

namespace App\Repository;

use App\Entity\Counter;
use App\Entity\Team;

class CounterRepository extends BasicRepository
{
    public function getByTeam(Team $team): array
    {
        $countersByTeam = [];
        $countersData = $this->getAllAsData();
        foreach ($countersData as $counterData) {
            if ($counterData['teamId'] == $team->id) {
                $counter = new Counter();
                $countersByTeam[] = $counter->fromArray($counterData);
            }
        }

        return $countersByTeam;
    }

    public function getTotalsSteps(Team $team): int
    {
        $totalSteps = 0;
        $counters = $this->getByTeam($team);
        foreach ($counters as $counter) {
            $totalSteps += $counter->steps;
        }

        return $totalSteps;
    }

    protected function getKey(): string
    {
        return Counter::class;
    }
}
