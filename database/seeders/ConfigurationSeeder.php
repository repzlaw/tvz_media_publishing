<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = array(
            
            array(
                'key' => 'login_email',
                'value' => 0
            ),
            array(
                'key' => 'new_task_email',
                'value' => 0
            ),
            array(
                'key' => 'task_coversation_email',
                'value' => 0
            ),
        );

        foreach ($setting as $value) {
            $set = Configuration::updateOrCreate($value);
        }
    }
}
