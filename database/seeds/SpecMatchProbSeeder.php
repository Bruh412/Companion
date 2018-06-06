<?php

use Illuminate\Database\Seeder;

class SpecMatchProbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['spec_id'=>'SP0001','problem_id'=>'PB0001'],
            ['spec_id'=>'SP0001','problem_id'=>'PB0005'],

            ['spec_id'=>'SP0002','problem_id'=>'PB0002'],
            ['spec_id'=>'SP0002','problem_id'=>'PB0008'],

            ['spec_id'=>'SP0003','problem_id'=>'PB0006'],
            ['spec_id'=>'SP0003','problem_id'=>'PB0007'],
            ['spec_id'=>'SP0003','problem_id'=>'PB0009'],
            ['spec_id'=>'SP0003','problem_id'=>'PB0011'],

            ['spec_id'=>'SP0004','problem_id'=>'PB0004'],
            ['spec_id'=>'SP0004','problem_id'=>'PB0006'],
            ['spec_id'=>'SP0004','problem_id'=>'PB0007'],
            ['spec_id'=>'SP0004','problem_id'=>'PB0011'],

            ['spec_id'=>'SP0005','problem_id'=>'PB0006'],
            ['spec_id'=>'SP0005','problem_id'=>'PB0007'],
            ['spec_id'=>'SP0005','problem_id'=>'PB0010'],
            ['spec_id'=>'SP0005','problem_id'=>'PB0011'],

            ['spec_id'=>'SP0006','problem_id'=>'PB0006'],
            ['spec_id'=>'SP0006','problem_id'=>'PB0008'],
            ['spec_id'=>'SP0006','problem_id'=>'PB0011'],

            ['spec_id'=>'SP0007','problem_id'=>'PB0001'],
            ['spec_id'=>'SP0007','problem_id'=>'PB0006'],
            ['spec_id'=>'SP0007','problem_id'=>'PB0007'],

            ['spec_id'=>'SP0008','problem_id'=>'PB0002'],
            ['spec_id'=>'SP0008','problem_id'=>'PB0003'],
            ['spec_id'=>'SP0008','problem_id'=>'PB0008'],
        ];

        DB::table('specmatchprob')->insert($data);
    }
}
