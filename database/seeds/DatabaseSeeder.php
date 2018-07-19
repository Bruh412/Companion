<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PostFeelingsSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(KeywordSeeder::class);
        // $this->call(InterestSeeder::class);
        // $this->call(AdminSeeder::class);
        // $this->call(SpecializationSeeder::class);
        // $this->call(PrcIDSeeder::class);
        // $this->call(ProblemSeeder::class);
        // $this->call(SystemConfigSeeder::class);

        $this->call(QueueSeeder::class);
        $this->call(UserInterestSeeder::class);
        $this->call(SystemConfigSeeder::class);
        $this->call(SpecMatchProbSeeder::class);
    }

}
