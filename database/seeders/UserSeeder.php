<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '01725361208',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $employee = User::create([
            'name' => 'Employee',
            'email' => 'employee@gmail.com',
            'phone' => '01930384220',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $admin->assignRole('Admin');
        $employee->assignRole('Employee');

        // for ($i = 0; $i < 5000; $i++) {
        //     $data[] = [
        //         'name'                  => fake()->name(),
        //         'email'                 => fake()->unique()->safeEmail(),
        //         'phone'                 => fake()->phoneNumber(),
        //         'password'              => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'email_verified_at'     => now(),
        //         'remember_token'        => Str::random(10),
        //         'created_at'            => now(),
        //     ];
        // }

        // $chunks = array_chunk($data, 1000);
        // foreach ($chunks as $chunk) {
        //     User::insert($chunk);
        // }
    }
}
