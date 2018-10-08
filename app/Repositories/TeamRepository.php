<?php

namespace App\Repositories;

class TeamRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Team::class;
    }
}
