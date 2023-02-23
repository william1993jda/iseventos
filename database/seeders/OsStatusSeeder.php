<?php

namespace Database\Seeders;

use App\Models\OsStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OsStatus::create([
            'name' => 'Aberto',
            'slug' => 'aberto',
            'color' => '#FFC107',
            'active' => 1,
        ]);
    }
}
