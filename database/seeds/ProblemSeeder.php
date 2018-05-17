<?php

use Illuminate\Database\Seeder;

class ProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [   
            ['problem_id'=>'PB0001','problem_name'=>'Health Problem'],
            ['problem_id'=>'PB0002','problem_name'=>'Work and Career Problem'],
            ['problem_id'=>'PB0003','problem_name'=>'Academic Problem'],
            ['problem_id'=>'PB0004','problem_name'=>'Loss of Loved One'],
            ['problem_id'=>'PB0005','problem_name'=>'Alcohol and Drug-related Problem'],
            ['problem_id'=>'PB0006','problem_name'=>'Social and Relationship Problem'],
            ['problem_id'=>'PB0007','problem_name'=>'Personal Issues'],
            ['problem_id'=>'PB0008','problem_name'=>'Financial Problem'],
            ['problem_id'=>'PB0009','problem_name'=>'Violence'],
            ['problem_id'=>'PB0009','problem_name'=>'Gender Problem'],
            ['problem_id'=>'PB0010','problem_name'=>'Family Problem'],
        ];
        DB::table('problem')->insert($data);
    }
}
