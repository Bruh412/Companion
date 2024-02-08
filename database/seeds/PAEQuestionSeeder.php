<?php

use Illuminate\Database\Seeder;

class PAEQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id'=>'1','question'=>'How well did the event satisfy you?', 'type'=>'rating'],
            ['id'=>'2','question'=>'How well was the facilitator accommodating the group?', 'type'=>'rating'],
            ['id'=>'3','question'=>'Were the activities helpful to the problems of your group?', 'type'=>'rating'],
            ['id'=>'4','question'=>'How well were you satisfied by the venue?', 'type'=>'rating'],
            ['id'=>'5','question'=>'Were your groupmates accommodating and cooperative?', 'type'=>'rating'],
            ['id'=>'6','question'=>'Any few comments about the event?', 'type'=>'essay'],
            ['id'=>'7','question'=>'Are there any suggestions from you that might help us improve our services in the future?', 'type'=>'essay'],
        ];

        DB::table('paequestions')->insert($data);
    }
}
