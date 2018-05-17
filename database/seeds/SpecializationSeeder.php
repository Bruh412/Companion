<?php

use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['spec_id' => 'SP0001', 'spec_name' => 'Addiction and Substance Abuse'],
            ['spec_id' => 'SP0002', 'spec_name' => 'Career and Vocational'],
            ['spec_id' => 'SP0003', 'spec_name' => 'Domestic Violence'],
            ['spec_id' => 'SP0004', 'spec_name' => 'Grief'],
            ['spec_id' => 'SP0005', 'spec_name' => 'LGBTQ'],
            ['spec_id' => 'SP0006', 'spec_name' => 'Marriage and Family'],
            ['spec_id' => 'SP0007', 'spec_name' => 'Mental Health'],
            ['spec_id' => 'SP0008', 'spec_name' => 'School or Academic'],
        ];
        DB::table('specialization')->insert($data);
    }
}
