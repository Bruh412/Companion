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
            ['categoryID'=>'C0002','categoryName'=>'Friends'],
            ['categoryID'=>'C0003','categoryName'=>'Relationship'],
            ['categoryID'=>'C0004','categoryName'=>'Health'],
            ['categoryID'=>'C0005','categoryName'=>'Academic'],
            ['categoryID'=>'C0006','categoryName'=>'Work'],
            ['categoryID'=>'C0007','categoryName'=>'Financial'],
            ['categoryID'=>'C0008','categoryName'=>'Personal'],
        ];

        DB::table('categories')->insert($data);
    }
}
