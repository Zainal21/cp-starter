<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::create([
            'name' => 'Example Site Name',
            'tagline' => 'Example Tagline Site',
            'address' => 'Example Address Site',
            'description' => 'Example Description Site',
            'phone' => '088216756214',
            'code_analytic_google' => 'nws2p14wyEE3Bhg5GwqSeRJlQ2TEJMiWLUa+iBaYqCA='
        ]);
    }
}
