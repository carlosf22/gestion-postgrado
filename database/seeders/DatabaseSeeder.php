<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => 'admin123',
            'role' => 'admin',
            'active' => true,
        ]);

        User::factory()->create([
            'name' => 'Operador',
            'email' => 'operador@admin.com',
            'password' => 'operador123',
            'role' => 'operator',
            'active' => true,
        ]);

        Student::create([
            'ci' => '1234567',
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'mother_last_name' => 'García',
            'phone' => '71234567',
            'registration_number' => 'REG-001',
            'discount' => 0,
        ]);

        Student::create([
            'ci' => '7654321',
            'first_name' => 'María',
            'last_name' => 'López',
            'mother_last_name' => 'Flores',
            'phone' => '79876543',
            'registration_number' => 'REG-002',
            'discount' => 10,
        ]);

        Course::create([
            'name' => 'Diplomado en Desarrollo Web',
            'edition' => 1,
            'version' => 2026,
            'type' => 'Diplomado',
            'cost' => 4500,
            'capacity' => 30,
            'active' => true,
        ]);

        Course::create([
            'name' => 'Maestría en Ciencias de Datos',
            'edition' => 2,
            'version' => 2026,
            'type' => 'Maestría',
            'cost' => 12000,
            'capacity' => 25,
            'active' => true,
        ]);
    }
}