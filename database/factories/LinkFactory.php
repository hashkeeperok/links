<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'short_code' => str_replace('-', '', Str::uuid()->toString()),
            'title' => $this->faker->word() . ' link',
            'long_url' => Arr::random(['https://google.com/', 'https://medium.com/']),
        ];
    }
}
