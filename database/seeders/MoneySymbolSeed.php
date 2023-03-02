<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Money;

class MoneySymbolSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $userInputs = [
            ['name' => 'Tsh'],

            ['name' => 'Ksh'],

            ['name' => 'Doller'],
              
            ];       

            // foreach($userInputs as $userInput){
            //     Money::create($userInput);
            // }
    }
}
