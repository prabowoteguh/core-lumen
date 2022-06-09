<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->count(10)->create();
        $faker = \Faker\Factory::create();
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'name'     => 'Restu Dwi Cahyo',
                'email'    => 'dwi.restu3@gmail.com',
                'password' => app('hash')->make('12345678'),
                'phone'    => $faker->unique()->e164PhoneNumber,
                'role'     => 1,
                'address'  => $faker->address,
                'birth'    => $faker->date,
                'avatar'   => "https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png",
                'position' => "Fullstack Web Developer",
                'relation_id' => "R001",
            ],
            [
                'name'     => 'Teguh Agung Prabowo',
                'email'    => 'teguhagungprabowo@gmail.com',
                'password' => app('hash')->make('12345678'),
                'phone'    => $faker->unique()->e164PhoneNumber,
                'role'     => 2,
                'address'  => $faker->address,
                'birth'    => $faker->date,
                'avatar'   => "https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png",
                'position' => "Fullstack Web Developer",
                'relation_id' => "R002",
            ],
            [
                'name'     => 'Revin Reginal',
                'email'    => 'babaw17@gmail.com',
                'password' => app('hash')->make('12345678'),
                'phone'    => $faker->unique()->e164PhoneNumber,
                'role'     => 2,
                'address'  => $faker->address,
                'birth'    => $faker->date,
                'avatar'   => "https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png",
                'position' => "Fullstack Web Developer",
                'relation_id' => "R003",
            ],
            [
                'name'     => 'Abu Muh',
                'email'    => 'ggabumuh2021@gmail.com',
                'password' => app('hash')->make('12345678'),
                'phone'    => $faker->unique()->e164PhoneNumber,
                'role'     => 1,
                'address'  => $faker->address,
                'birth'    => $faker->date,
                'avatar'   => "https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png",
                'position' => "Kepala Divisi",
                'relation_id' => "R004",
            ],
            [
                'name'     => 'Ilham Fathur',
                'email'    => 'ilhammrohang@gmail.com',
                'password' => app('hash')->make('12345678'),
                'phone'    => $faker->unique()->e164PhoneNumber,
                'role'     => 1,
                'address'  => $faker->address,
                'birth'    => $faker->date,
                'avatar'   => "https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png",
                'position' => "UI/UX",
                'relation_id' => "R005",
            ],
        ]);
    }
}
