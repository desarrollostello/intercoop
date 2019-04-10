<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use File;

class CreateUser extends Seeder
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

        $default_avatars = new \Pheaks\Photo();
        $default_avatars->original = "img/default_avatar.png";
        $default_avatars->large = "img/default_avatar.png";
        $default_avatars->medium = "img/default_avatar.png";
        $default_avatars->small = "img/default_avatar.png";
        $default_avatars->status = 1;
        $default_avatars->save();

        for($i=1;$i<=15;$i++) {
            $ran_sex = array_rand($sexs);
            $username = $faker->unique()->userName;
            $public_folder_name = "users". DS .uniqid($username) . DS;

            $user_id = Db::table('users')->insertGetId([
                'user_name' => $username,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'birthday' => date('Y-m-d'),
                'email' => $faker->unique()->email,
                'sex'   => $sexs[$ran_sex],
                'password' => bcrypt('123'),
                'created_at' => date('Y-m-d H:i:s', time()),
            ]);
            Db:table('profiles')->insert([
                'user_id'   => $user_id,
                'avatar_photo_id'  => $default_avatars->id,
                'public_folder' => $public_folder_name,
                'sex_preference'=> $sexs[$ran_sex] == "f" ? "m" : "f"
            ]);

            File::makeDirectory($public_folder_name, 0777);
        }
    }
}
