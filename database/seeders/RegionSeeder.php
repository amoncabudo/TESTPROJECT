<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run()
    {
        Region::create(['name' => 'Europa', 'description' => 'Europa']);
        Region::create(['name' => 'Asia', 'description' => 'Asia']);
        Region::create(['name' => 'América', 'description' => 'América']);
        Region::create(['name' => 'África', 'description' => 'África']);
    }
}