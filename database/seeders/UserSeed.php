<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $year = FinancialYear::whereName('2020/21')->first();
        

        $userInputs = [
            ['fname' => 'Admin', 'mname' => 'Juma', 'lname' => 'Rashid' ,'gender' => 'Male'
            ,'phone' => '0235465465', 'email' => 'admin@gmail.com', 'password' => Hash::make(123456789),'role' => 'Admin'],
            ['fname' => 'Manager', 'mname' => 'Juma', 'lname' => 'Rashid' ,'gender' => 'Male'
            ,'phone' => '0235465465', 'email' => 'manager@gmail.com', 'password' => Hash::make(123456789),'role' => 'Manager'],

         
              
            ];               
            foreach($userInputs as $userInput){
                User::create($userInput); 
            }
    }
}
