<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

/*          for($i = 0; $i<3; $i++)
        DB::table('company')->insert([
             'name' => 'Кинотеатр '.$i,
            ]
        );

        for($i = 1; $i<3; $i++)
        DB::table('movies')->insert([
             'name' => 'Фильм '.$i,
             'time' => date("00:35:s"),
            ]
        );
*/

   for($i = 1; $i<5; $i++)
        DB::table('events')->insert([
             'company_id' => 2,
             'movie_id' => 2,
             'type' => 1,
             'visited' => rand(5,100)
            ]
        );



        $this->command->info(date("H:i:s"));
  }
}
