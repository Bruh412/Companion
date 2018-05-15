<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [   
            ['categoryID'=>'C0001','categoryName'=>'Family'],
            ['categoryID'=>'C0002','categoryName'=>'Sadness'],
            ['categoryID'=>'C0003','categoryName'=>'Inspirational'],
            ['categoryID'=>'C0004','categoryName'=>'Happiness'],
            ['categoryID'=>'C0005','categoryName'=>'Success'],
        ];

        DB::table('categories')->insert($data);
    }
}
