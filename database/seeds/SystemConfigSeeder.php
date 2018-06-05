<?php

use Illuminate\Database\Seeder;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'numberOfUsersToGroup' => '4',
            'numberOfDaysUntilNewVideoForQuotes' => '2',
        ];
        DB::table('abcsystemconfig')->insert($data);
    }
}
