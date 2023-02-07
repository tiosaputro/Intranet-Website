<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->seedUser();
    }

    public function seedUser()
    {
        DB::table('users')->insert(
            [
                'id' => '1',
                'name' => 'Mr.Test',
                'email' => 'test@intranet.com',
                'password' => Hash::make('123456')
            ]
        );
    }
}
