<?php

use App\Day;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 31; $i++) {
            Day::create([
                'day' => $i
            ]);
        }
    }
}
