<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fs = new Filesystem;
        
        // Delete files
        $except_file_names = [
            'place\tugu digulis.jpg', // Add file names to exclude (menu\<file_name)
        ];
        
        $file_paths = $fs->files(public_path('upload/place'));
        foreach ($file_paths as $file_path) {
            $file_name = last(explode('/', $file_path));
            if (!in_array($file_name, $except_file_names)) {
                $fs->delete($file_path);
            }
        }

        echo "Upload/place/* successfully deleted!\n";
        // \App\Models\User::factory(10)->create();
        \App\Models\Place::create([
            'name' => 'Tugu Digulis',
            'latitude' => '-0.0554477132152489', 
            'longitude' => '109.34944360854895',
            'address' => 'Bansir Laut, Kec. Pontianak Tenggara, Kota Pontianak, Kalimantan Barat',
            'description' => 'Tugu landwark Kalimantan',
            'image' => 'tugu digulis.jpg'

        ]);
        
        \App\Models\User::create([
            'name' => 'Budi Utomo',
            'email' => 'superadmin@roles.id',
            'password'=> Hash::make('123456')
        ]);
    }
}
