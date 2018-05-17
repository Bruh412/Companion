<?php

use Illuminate\Database\Seeder;

class UserInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [   
            ['user_id'=>'S0001','interestID'=>'I002'],
            ['user_id'=>'S0001','interestID'=>'I003'],
            ['user_id'=>'S0001','interestID'=>'I004'],
            ['user_id'=>'S0001','interestID'=>'I005'],
            ['user_id'=>'S0001','interestID'=>'I009'],
            ['user_id'=>'S0001','interestID'=>'I010'],

            ['user_id'=>'S0002','interestID'=>'I001'],
            ['user_id'=>'S0002','interestID'=>'I002'],
            ['user_id'=>'S0002','interestID'=>'I003'],
            ['user_id'=>'S0002','interestID'=>'I006'],
            ['user_id'=>'S0002','interestID'=>'I009'],
            ['user_id'=>'S0002','interestID'=>'I011'],

            ['user_id'=>'S0003','interestID'=>'I001'],
            ['user_id'=>'S0003','interestID'=>'I002'],
            ['user_id'=>'S0003','interestID'=>'I007'],
            ['user_id'=>'S0003','interestID'=>'I009'],
            ['user_id'=>'S0003','interestID'=>'I010'],
            ['user_id'=>'S0003','interestID'=>'I011'],

            ['user_id'=>'S0004','interestID'=>'I002'],
            ['user_id'=>'S0004','interestID'=>'I005'],
            ['user_id'=>'S0004','interestID'=>'I006'],
            ['user_id'=>'S0004','interestID'=>'I007'],
            ['user_id'=>'S0004','interestID'=>'I009'],
            ['user_id'=>'S0004','interestID'=>'I011'],

            ['user_id'=>'S0005','interestID'=>'I001'],
            ['user_id'=>'S0005','interestID'=>'I002'],
            ['user_id'=>'S0005','interestID'=>'I003'],
            ['user_id'=>'S0005','interestID'=>'I005'],
            ['user_id'=>'S0005','interestID'=>'I007'],
            ['user_id'=>'S0005','interestID'=>'I009'],

            ['user_id'=>'S0006','interestID'=>'I002'],
            ['user_id'=>'S0006','interestID'=>'I004'],
            ['user_id'=>'S0006','interestID'=>'I005'],
            ['user_id'=>'S0006','interestID'=>'I006'],
            ['user_id'=>'S0006','interestID'=>'I007'],
            ['user_id'=>'S0006','interestID'=>'I011'],

            ['user_id'=>'S0007','interestID'=>'I001'],
            ['user_id'=>'S0007','interestID'=>'I002'],
            ['user_id'=>'S0007','interestID'=>'I005'],
            ['user_id'=>'S0007','interestID'=>'I006'],
            ['user_id'=>'S0007','interestID'=>'I007'],
            ['user_id'=>'S0007','interestID'=>'I008'],
        ];

        DB::table('usersinterests')->insert($data);
    }
}
