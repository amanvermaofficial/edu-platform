<?php

namespace Database\Seeders;

use App\Models\Trade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $trades = [
            ['name' => 'COPA', 'description' => 'Computer Operator and Programming Assistant'],
            ['name' => 'Fitter', 'description' => 'Mechanical fitting trade'],
            ['name' => 'Electrician', 'description' => 'Electrical maintenance and wiring'],
            ['name' => 'Cosmetology', 'description' => 'Beauty and Hair care'],
        ];

        foreach ($trades as $trade) {
            Trade::create($trade);
        }
    }
}
