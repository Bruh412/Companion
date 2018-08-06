<?php

use Illuminate\Database\Seeder;

class VenueCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '1', 'venueCategory' => 'Small Room'],
            ['id' => '2', 'venueCategory' => 'Multipurpose Room'],
            ['id' => '3', 'venueCategory' => 'Open Area'],
        ];
        DB::table('venuecategories')->insert($data);
    }
}
