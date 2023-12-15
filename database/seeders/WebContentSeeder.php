<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\WebContent::create([
            'banner' => 'No.jpg',
            'title' => 'Default title',
            'superintendent_name' => 'NAME',
            'superintendent_desc' => 'Description',
            'content' => 'Default Content',
        ]);
    }
}
