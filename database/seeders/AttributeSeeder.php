<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attribute::insert([
            ['name' => 'years_experience', 'type' => 'number', 'options' => null],
            ['name' => 'required_degree', 'type' => 'select', 'options' => json_encode(['Bachelor', 'Master', 'PhD'])],
            ['name' => 'english_level', 'type' => 'select', 'options' => json_encode(['Beginner', 'Intermediate', 'Advanced', 'Fluent'])],
            ['name' => 'working_hours', 'type' => 'number', 'options' => null], 
            ['name' => 'contract_length', 'type' => 'text', 'options' => null], 
            ['name' => 'required_certifications', 'type' => 'text', 'options' => null], 
            ['name' => 'job_seniority', 'type' => 'select', 'options' => json_encode(['Junior', 'Mid', 'Senior', 'Lead'])],
        ]);
    }
}
