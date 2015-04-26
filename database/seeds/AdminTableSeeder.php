<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserTableSeeders
 *
 * @author andres
 */
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder {

    public function run() {
        \DB::table('users')->insert(array(
            'first_name' => 'Andres',
            'last_name'  => 'Riveros',
            'email'      => 'andrete@gmail.com',
            'password'   => \Hash::make('secret'),
            'type'       => 'admin',
            'full_name'  => 'Andres Riveros'
        ));
        \DB::table('user_profiles')->insert(array(
            'user_id' => 1,
            'birthdate'  => '1979/05/18',
        ));
    }

}
