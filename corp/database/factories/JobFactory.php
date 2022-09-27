<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'corporation_id' => rand(1,10),
            'industry_id' => rand(1,10),
            'occupation_id' => rand(1,10),
            'title' => Str::random(20),
            'tag_id' => rand(1,10),
            'business_content' => Str::random(20),
            'image_path' => $this->faker->imageUrl($width = 640, $height = 480, $category = 'cats', $randomize = true, $word = null),
            'salary' => rand(100000,500000),
            'is_bonus' => rand(0,1),
            'various_allowances' => Str::random(10),
            'welfare' => Str::random(10),
            'work_location' => Str::random(10),
            // 'working_hours' => rand(160,200),
            'contract_period' => rand(3,12),
            'test_period' => rand(3,12),
            'work_place' => Str::random(10),
            'working_start_time' => '9:00',
            'working_end_time' => '18:00',
            'overtime_hours' => rand(10,80),
            'is_transfer' => rand(0,1),
            'employment_form' => rand(1,4),
            'hired_people_no' => rand(1,8),
            'status' => rand(0,1),
            'approval_status' => rand(0,1)
        ];
    }
}
