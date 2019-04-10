<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $sexs = ['f','m'];

        for($i=1;$i<=15;$i++) {
            $ran_sex = array_rand($sexs);
            $username = $faker->unique()->userName;
            $public_folder_name = "users". DS .uniqid(rand()) . DS;

            $user_id = \DB::table('users')->insertGetId([
                'user_name' => $username,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'email' => $faker->unique()->email,
                'sex'   => $sexs[$ran_sex],
                'password' => bcrypt('123'),
                'created_at' => date('Y-m-d H:i:s', time()),
            ]);
            $avatar = \DB::table('photos')->insertGetId([
                'user_id'   => $user_id,
                'is_avatar' => true,
                'original'  => "img/default_avatar.png",
                'large'     => "img/default_avatar.png",
                'medium'    => "img/default_avatar.png",
                'small'     => "img/default_avatar.png",
            ]);
            \DB::table('profiles')->insert([
                'user_id'   => $user_id,
                'avatar_photo_id'  => $avatar,
                'public_folder' => $public_folder_name,
                'sex_preference'=> $sexs[$ran_sex] == "f" ? "m" : "f"
            ]);

            mkdir("public".DS.$public_folder_name, 7555, true);
        }
    }
}
