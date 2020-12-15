<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('rooms')->insert([
        [
            'type' => 'deluxe',
            'max_capacity' => 5,
            'availability' => true,
            'created_at' => Carbon::now()
        ],
        [
            'type' => 'deluxe',
            'max_capacity' => 5,
            'availability' => true,
            'created_at' => Carbon::now()
        ],
        [
            'type' => 'classic',
            'max_capacity' => 4,
            'availability' => true,
            'created_at' => Carbon::now()
        ],
        [
            'type' => 'classic',
            'max_capacity' => 3,
            'availability' => true,
            'created_at' => Carbon::now()
        ],
        [
            'type' => 'classic',
            'max_capacity' => 3,
            'availability' => true,
            'created_at' => Carbon::now()
        ],
        ]);
    }
}
