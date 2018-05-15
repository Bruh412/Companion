<?php

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
        $data = [   
            ['user_id'=>'A0001','first_name'=>'Xavier','last_name'=>'Comabig','username'=>'bruh412','email'=>'xcomabig@gmail.com','birthday'=>'02201999','address'=>'Cebu City','gender'=>'Male','password'=>bcrypt('happybruh'),'userType' => 'admin'
            ],
        ];

        DB::table('systemusers')->insert($data);
    }
}
