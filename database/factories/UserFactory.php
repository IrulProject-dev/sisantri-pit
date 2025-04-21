<?php
namespace Database\Factories;

use App\Models\Batch;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           => fake()->name(),
            'email'          => fake()->email(),
            'password'       => Hash::make('Password@123'),
            'role'           => fake()->randomElement(['mentor', 'santri']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Configure the model factory for mentor role.
     */
    public function mentor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'mentor',
            ];
        });
    }

    /**
     * Use for santri counter increment
     */
    protected static $santriCounter = 0;

    /**
     * Configure the model factory for santri role.
     */
    public function santri()
    {
        return $this->state(function (array $attributes) {
            $gender = fake()->randomElement(['male', 'female']);
            $year   = date('Y');
            self::$santriCounter++;

            return [
                'nis'           => $year . str_pad(self::$santriCounter++, 4, '0', STR_PAD_LEFT),
                'role'          => 'santri',
                'gender'        => $gender,
                'date_of_birth' => fake()->dateTimeBetween('-23 years', '-18 years'),
                'phone'         => fake()->phoneNumber(),
                'father_name'   => fake()->name('male'),
                'father_phone'  => fake()->phoneNumber(),
                'mother_name'   => fake()->name('female'),
                'mother_phone'  => fake()->phoneNumber(),
                'address'       => fake()->address(),
                'division_id'   => Division::inRandomOrder()->first()->id,
                'batch_id'      => Batch::inRandomOrder()->first()->id,
            ];
        });
    }
}
