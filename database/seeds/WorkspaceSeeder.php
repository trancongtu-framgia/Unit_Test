<?php

use Illuminate\Database\Seeder;

class WorkspaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Workspace::class, 10)->create();
        factory(\App\User::class,10)->create();
    }
}
