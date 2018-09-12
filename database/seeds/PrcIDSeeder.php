<?php

use Illuminate\Database\Seeder;

class PrcIDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['prc_id' => '2015010211'],
            ['prc_id' => '2015010212'],
            ['prc_id' => '2015010213'],
            ['prc_id' => '2015010214'],
            ['prc_id' => '2015010215'],
            ['prc_id' => '2015010216'],
            ['prc_id' => '2015010217'],
            ['prc_id' => '2015010218'],
            ['prc_id' => '2015010219'],
            ['prc_id' => '2015010210'],
            ['prc_id' => '2015010211'],
            ['prc_id' => '2015010212'],
            ['prc_id' => '2015010213'],
            ['prc_id' => '2015010214'],
            ['prc_id' => '2015010215'],
        ];
        DB::table('prcraw')->insert($data);

    }
}
