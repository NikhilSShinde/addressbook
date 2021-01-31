<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->delete();
        
        $cities = array(
            array('city' => "Pune"),
            array('city' => "Kolhapur"),
            array('city' => "Mumbai"),
            array('city' => "Solapur"),
            array('city' => "Jalgaon"),
            array('city' => "Indore"),
            array('city' => "Bhopal")
        );
        
        DB::table('cities')->insert($cities);
        
    }
}
