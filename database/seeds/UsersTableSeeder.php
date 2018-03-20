<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name'          => 'Everan',
            'email'         => 'everan@aliyun.com',
            'password'      => bcrypt('199457'),
            'department_id' => 1,
            'sex'           => 1,
            'identify'      => 1,
            'status'        => 1,
        ];

        DB::table('users')->insert($user);

        $users = User::find(1);

        $users->assignRole('Founder');
    }
}
