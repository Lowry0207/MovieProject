<?php

use Illuminate\Database\Seeder;

class data_test extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('Таблица пользователей заполнена данными!');

        DB::create(array('email' => 'foo@bar.com'));
    }
}
