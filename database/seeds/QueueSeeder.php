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
            ['queueID'=>'Q00001', 'latitude'=>'10.2899241', 'longitude'=>'123.8603253', 'user_id'=>'S0001'],
            ['queueID'=>'Q00002', 'latitude'=>'10.2624883', 'longitude'=>'123.8412269', 'user_id'=>'S0002'],
            ['queueID'=>'Q00003', 'latitude'=>'10.2618894', 'longitude'=>'123.8407868', 'user_id'=>'S0003'],
            ['queueID'=>'Q00004', 'latitude'=>'10.2599308', 'longitude'=>'123.8424966', 'user_id'=>'S0004'],
            ['queueID'=>'Q00005', 'latitude'=>'10.2864211', 'longitude'=>'123.8610371', 'user_id'=>'S0005'],
            ['queueID'=>'Q00006', 'latitude'=>'10.2870457', 'longitude'=>'123.85846', 'user_id'=>'S0006'],
            ['queueID'=>'Q00007', 'latitude'=>'10.2899241', 'longitude'=>'123.8603253', 'user_id'=>'S0007'],
        ];

        DB::table('queuetalkcircle')->insert($data);
    }
}
