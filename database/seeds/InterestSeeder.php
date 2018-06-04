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
                ['interestID'=>'I001','interestName'=>'Arts/Drawing'],
                ['interestID'=>'I002','interestName'=>'Crafts'],
                ['interestID'=>'I003','interestName'=>'Literature'],
                ['interestID'=>'I004','interestName'=>'Music'],
                ['interestID'=>'I005','interestName'=>'E-Gaming'],
                ['interestID'=>'I006','interestName'=>'Movies/Tv'],
                ['interestID'=>'I007','interestName'=>'Puzzles'],
                ['interestID'=>'I008','interestName'=>'Sports'],
                ['interestID'=>'I009','interestName'=>'Adventures'],
                ['interestID'=>'I010','interestName'=>'Self-Get-togethers'],
                // ['interestID'=>'I011','interestName'=>'Meditation'],
       ];

       DB::table('interests')->insert($interest);
    }
}
