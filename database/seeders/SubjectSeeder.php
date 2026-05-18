<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Matematyka',         'department' => 'Wydział Nauk Ścisłych'],
            ['name' => 'Fizyka',             'department' => 'Wydział Nauk Ścisłych'],
            ['name' => 'Chemia',             'department' => 'Wydział Nauk Ścisłych'],
            ['name' => 'Biologia',           'department' => 'Wydział Nauk Przyrodniczych'],
            ['name' => 'Historia',           'department' => 'Wydział Humanistyczny'],
            ['name' => 'Prawo',              'department' => 'Wydział Prawa i Administracji'],
            ['name' => 'Ekonomia',           'department' => 'Wydział Ekonomii'],
            ['name' => 'Makroekonomia',      'department' => 'Wydział Ekonomii'],
            ['name' => 'Informatyka',        'department' => 'Wydział Informatyki'],
            ['name' => 'Psychologia',        'department' => 'Wydział Nauk Społecznych'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
