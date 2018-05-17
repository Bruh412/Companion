<?php

use Illuminate\Database\Seeder;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [   
            ['queueID'=>'Q00001','feeling'=>'Devastated', 'user_id'=>'S0001'],
            ['queueID'=>'Q00002','feeling'=>'Devastated', 'user_id'=>'S0002'],
            ['queueID'=>'Q00003','feeling'=>'Devastated', 'user_id'=>'S0003'],
            ['queueID'=>'Q00004','feeling'=>'Sad', 'user_id'=>'S0004'],
            ['queueID'=>'Q00005','feeling'=>'Sad', 'user_id'=>'S0005'],
            ['queueID'=>'Q00006','feeling'=>'Sad', 'user_id'=>'S0006'],
            ['queueID'=>'Q00007','feeling'=>'Devastated', 'user_id'=>'S0007'],
        ];

        DB::table('queuetalkcircle')->insert($data);
    }
}
