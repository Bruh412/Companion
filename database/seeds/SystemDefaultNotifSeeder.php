<?php

use Illuminate\Database\Seeder;

class SystemDefaultNotifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '1', 'message' => 'Your facilitator has finished adding the details for the event'],
            ['id' => '2', 'message' => 'You are now part of a group!'],
            ['id' => '3', 'message' => 'Reminding you of your event that will occur an hour from now'],
        ];
        DB::table('systemdefaultnotif')->insert($data);
    }
}
