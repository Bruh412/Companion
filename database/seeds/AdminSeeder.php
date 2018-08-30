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
            ['user_id'=>'A0001','first_name'=>'Xavier','last_name'=>'Comabig','username'=>'bruh412','email'=>'xcomabig@gmail.com','birthday'=>'02201999','gender'=>'Male','password'=>bcrypt('happybruh'),'userType' => 'admin'
            ],
            // ['user_id'=>'S0001','first_name'=>'Jules Van','last_name'=>'Catubig','username'=>'van01','email'=>'van01@gmail.com','birthday'=>'03211998','gender'=>'Male','password'=>bcrypt('van01'),'userType' => 'seeker'
            // ],
            // ['user_id'=>'S0002','first_name'=>'Emman John','last_name'=>'Sisnorio','username'=>'sis123','email'=>'sis123@gmail.com','birthday'=>'04011999','gender'=>'Male','password'=>bcrypt('sis123'),'userType' => 'seeker'
            // ],
            // ['user_id'=>'S0003','first_name'=>'Trisha','last_name'=>'Abarquez','username'=>'trisha123','email'=>'trisha123@gmail.com','birthday'=>'07221998','gender'=>'Female','password'=>bcrypt('trisha123'),'userType' => 'seeker'
            // ],
            // ['user_id'=>'S0004','first_name'=>'Shane','last_name'=>'Borces','username'=>'shane123','email'=>'shane123@gmail.com','birthday'=>'03211998','gender'=>'Female','password'=>bcrypt('shane123'),'userType' => 'seeker'
            // ],
            // ['user_id'=>'S0005','first_name'=>'Kate Pearl','last_name'=>'David','username'=>'kate123','email'=>'kate123@gmail.com','birthday'=>'04111999','gender'=>'Female','password'=>bcrypt('kate123'),'userType' => 'seeker'
            // ],
            // ['user_id'=>'S0006','first_name'=>'Julius Ceasar','last_name'=>'Nacua','username'=>'jc123','email'=>'jc123@gmail.com','birthday'=>'05281998','gender'=>'Male','password'=>bcrypt('jc123'),'userType' => 'seeker'
            // ],
            // ['user_id'=>'S0007','first_name'=>'Ruziel Jon','last_name'=>'Mantalaba','username'=>'ruz123','email'=>'ruz123@gmail.com','birthday'=>'09221998','gender'=>'Male','password'=>bcrypt('ruz123'),'userType' => 'seeker'
            // ],
            
        ];

        DB::table('systemusers')->insert($data);
    }
}
