<?php

namespace App\Repositories;

class TypeRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Type::class;
    }
}
