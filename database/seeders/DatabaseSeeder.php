<?php

namespace Database\Seeders;

use App\Modules\Course\Domain\Models\Course;
use App\Modules\User\Domain\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        
        $teacher = User::factory()->teacher()->create([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => bcrypt('password'),
        ]);

        Course::factory(20)->create([
            'teacher_id' => $teacher->id,
        ]);
    }
}
