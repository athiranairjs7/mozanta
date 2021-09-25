<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
class studentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('students')->insert([
           'id'=>0,'student_id'=>'R-000','student_name'=>'testname','standard'=>'i','division'=>'A','gender'=>'female'
       ]);
    }
}
