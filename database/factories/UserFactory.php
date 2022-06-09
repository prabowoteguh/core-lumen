<?php
/* ==============================================================
| Author        : prabowoteguh
| Created at    : Tue, April 16 2021 23:49:20
| Modify at     : Tue, April 16 2021 23:49:20
| Location      : Unknown
| Description   : Authentication User
=================================================================*/

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'     => $this->faker->name,
            'email'    => $this->faker->unique()->safeEmail,
            'password' => app('hash')->make('12345678'),
            'phone'    => $this->faker->unique()->e164PhoneNumber,
            'role'     => 1,
            'address'  => $this->faker->address,
            'birth'    => $this->faker->date,
            'avatar'   => $this->faker->imageUrl,
            'position' => 1,
        ];
    }
}
