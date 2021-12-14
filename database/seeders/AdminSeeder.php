<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = array(
            array(
                'email' => 'work@tvzcorp.com' ,
                'type' => 'Admin',
                'name' => 'tvz corp',
                'password' => bcrypt('12345678'),
            ),
            array(
                'email' => 'segun@gmail.com' ,
                'type' => 'Writer',
                'name' => 'segun josh',
                'password' => bcrypt('12345678'),
            )
        );

        foreach ($admin as $value) {
            $user = User::updateOrCreate($value);
        }
    }
}
