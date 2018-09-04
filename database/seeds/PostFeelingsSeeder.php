<?php

use Illuminate\Database\Seeder;

class PostFeelingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feelings = [
            [
                'post_feeling_id'=>'PF01',
                'post_feeling_name'=>'Sad'
            ],
            [
                'post_feeling_id'=>'PF02',
                'post_feeling_name'=>'Sorry'
            ],
            [
                'post_feeling_id'=>'PF03',
                'post_feeling_name'=>'Heartbroken'
            ],
            [
                'post_feeling_id'=>'PF04',
                'post_feeling_name'=>'Worried'
            ],
            [
                'post_feeling_id'=>'PF05',
                'post_feeling_name'=>'Angry'
            ],
            [
                'post_feeling_id'=>'PF06',
                'post_feeling_name'=>'Confused'
            ],
            [
                'post_feeling_id'=>'PF07',
                'post_feeling_name'=>'Annoyed'
            ],
            [
                'post_feeling_id'=>'PF08',
                'post_feeling_name'=>'Disappointed'
            ],
            [
                'post_feeling_id'=>'PF09',
                'post_feeling_name'=>'Contented'
            ],
            [
                'post_feeling_id'=>'PF10',
                'post_feeling_name'=>'Excited'
            ],
            [
                'post_feeling_id'=>'PF11',
                'post_feeling_name'=>'Funny'
            ],
            [
                'post_feeling_id'=>'PF12',
                'post_feeling_name'=>'Happy'
            ],
            [
                'post_feeling_id'=>'PF13',
                'post_feeling_name'=>'Loved'
            ],
            [
                'post_feeling_id'=>'PF14',
                'post_feeling_name'=>'Nervous'
            ],
            [
                'post_feeling_id'=>'PF15',
                'post_feeling_name'=>'Shocked'
            ],
            [
                'post_feeling_id'=>'PF16',
                'post_feeling_name'=>'Thankful'
            ]
        ];

        DB::table('postfeelings')->insert($feelings);
    }
}
