<?php

namespace Database\Factories;

use App\Models\Checklist;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Checklist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $options_length = rand(2, 20);
        $options = range(1, $options_length);

        foreach ($options as $key => &$value) {
            $value = [
                'tid' => $key + 1,
                'title' => $this->faker->paragraph(2),
                'is_done' => rand(0, 1),
            ];
        }

        
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'options' => $options,
            'task_increment' => $options_length + 1,
        ];
    }
}
