<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job;
use App\Models\Category;
use App\Models\Location;
use App\Models\Attribute;
use App\Models\Language;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'company_name' => $this->faker->company,
            'salary_min' => $this->faker->numberBetween(3000, 5000),
            'salary_max' => $this->faker->numberBetween(6000, 10000),
            'is_remote' => $this->faker->boolean,
            'job_type' => $this->faker->randomElement([ Job::FULL_TIME, Job::PART_TIME , Job::CONTRACT , Job::FREELANCE]),
            'status' => $this->faker->randomElement([Job::STATUS_DRAFT, Job::STATUS_PUBLISHED, Job::STATUS_ARCHIVED]),
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Job $job) {
            //add categories
            $categories = Category::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $job->categories()->attach($categories);

            // add locations
            $locations = Location::inRandomOrder()->limit(rand(1, 2))->pluck('id');
            $job->locations()->attach($locations);

            //add languages
            $languages = Language::inRandomOrder()->limit(rand(1, 2))->pluck('id');
            $job->languages()->attach($languages);

            //add attributes
            $attributes = Attribute::all();
            foreach ($attributes as $attribute) {
                $value = $this->generateAttributeValue($attribute);
                $job->attributes()->create([
                    'attribute_id' => $attribute->id,
                    'value' => $value,
                ]);
            }
        });
    }

    private function generateAttributeValue(Attribute $attribute)
    {
        if ($attribute->type == Attribute::TYPE_NUMBER) {
            return fake()->numberBetween(1, 20);
        }

        if ($attribute->type == Attribute::TYPE_SELECT) {
            
            return fake()->randomElement($attribute->options);
        }
        
        return fake()->word();

    }
}
