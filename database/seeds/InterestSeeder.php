<?php

use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interest = [   
                ['interestID'=>'I001','interestName'=>'Arts/Crafts'],
                ['interestID'=>'I002','interestName'=>'Music'],
                ['interestID'=>'I003','interestName'=>'Writing'],
                ['interestID'=>'I004','interestName'=>'Games'],
                ['interestID'=>'I005','interestName'=>'Puzzles'],
                ['interestID'=>'I006','interestName'=>'Sports'],
                ['interestID'=>'I007','interestName'=>'Funny'],
                ['interestID'=>'I008','interestName'=>'Exercises'],
                ['interestID'=>'I009','interestName'=>'Social'],
                ['interestID'=>'I010','interestName'=>'Self-Care'],
                ['interestID'=>'I011','interestName'=>'Experiental'],
       ];

       DB::table('interests')->insert($interest);
    }
}
