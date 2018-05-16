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
            ['spec_id' => 'SP0003', 'spec_name' => 'Child Counselor'],
            ['spec_id' => 'SP0004', 'spec_name' => 'College Counselor'],
            ['spec_id' => 'SP0005', 'spec_name' => 'Domestic Violence Counselor'],
            ['spec_id' => 'SP0006', 'spec_name' => 'Forensic Counselor'],
            ['spec_id' => 'SP0007', 'spec_name' => 'Geriatric Counselor'],
            ['spec_id' => 'SP0008', 'spec_name' => 'Grief Counselor'],
            ['spec_id' => 'SP0009', 'spec_name' => 'Humanistic Counselor'],
            ['spec_id' => 'SP0010', 'spec_name' => 'LGBTQ Counselor'],
            ['spec_id' => 'SP0011', 'spec_name' => 'Marriage and Family Counselor'],
            ['spec_id' => 'SP0012', 'spec_name' => 'Mental Health Counselor'],
            ['spec_id' => 'SP0013', 'spec_name' => 'Multicultural Counselor'],
            ['spec_id' => 'SP0014', 'spec_name' => 'Rehabilitation Counselor'],
            ['spec_id' => 'SP0015', 'spec_name' => 'School Counselor'],
            ['spec_id' => 'SP0016', 'spec_name' => 'Spiritual Counselor'],
            ['spec_id' => 'SP0017', 'spec_name' => 'Veteran Counselor'],
        ];
         DB::table('specialization')->insert($data);
    }
}
