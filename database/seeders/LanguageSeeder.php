<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([
            ['name' => 'PHP'],
            ['name' => 'JavaScript'],
            ['name' => 'Python'],
            ['name' => 'Java'],
            ['name' => 'C++'],
            ['name' => 'Asp.net'],
            ['name' => 'HTML5'],
            ['name' => 'Laravel'],
            ['name' => 'Css3'],


        ]);
    }
}
