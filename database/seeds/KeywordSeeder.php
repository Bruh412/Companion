<?php

use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $words = [
            [
                'id' => 'K0001',
                'keyword_name' => 'family',
            ],
            [
                'id' => 'K0002',
                'keyword_name' => 'heart',
            ],
            [
                'id' => 'K0003',
                'keyword_name' => 'love',
            ],
            [
                'id' => 'K0004',
                'keyword_name' => 'relationship',
            ],
            [
                'id' => 'K0005',
                'keyword_name' => 'reject',
            ],
            [
                'id' => 'K0006',
                'keyword_name' => 'hate',
            ],
            [
                'id' => 'K0007',
                'keyword_name' => 'lonely',
            ],
            [
                'id' => 'K0008',
                'keyword_name' => 'gf',
            ],
            [
                'id' => 'K0009',
                'keyword_name' => 'bf',
            ],
            [
                'id' => 'K0010',
                'keyword_name' => 'girlfriend',
            ],
            [
                'id' => 'K0011',
                'keyword_name' => 'boyfriend',
            ],
            [
                'id' => 'K0012',
                'keyword_name' => 'mom',
            ],
            [
                'id' => 'K0013',
                'keyword_name' => 'dad',
            ],
            [
                'id' => 'K0014',
                'keyword_name' => 'sis',
            ],
            [
                'id' => 'K0015',
                'keyword_name' => 'sister',
            ],
            [
                'id' => 'K0016',
                'keyword_name' => 'brother',
            ],
            [
                'id' => 'K0017',
                'keyword_name' => 'cousin',
            ],
            [
                'id' => 'K0018',
                'keyword_name' => 'aunt',
            ],
            [
                'id' => 'K0019',
                'keyword_name' => 'uncle',
            ],
            [
                'id' => 'K0020',
                'keyword_name' => 'papa',
            ],
            [
                'id' => 'K0021',
                'keyword_name' => 'mama',
            ],
            [
                'id' => 'K0022',
                'keyword_name' => 'grades',
            ],
            [
                'id' => 'K0023',
                'keyword_name' => 'job',
            ],
            [
                'id' => 'K0024',
                'keyword_name' => 'work',
            ],
            [
                'id' => 'K0025',
                'keyword_name' => 'fail',
            ],
            [
                'id' => 'K0026',
                'keyword_name' => 'drugs',
            ],
            [
                'id' => 'K0027',
                'keyword_name' => 'grandma',
            ],
            [
                'id' => 'K0028',
                'keyword_name' => 'grandpa',
            ],
        ];

        DB::table('keywords')->insert($words);
    }
}
