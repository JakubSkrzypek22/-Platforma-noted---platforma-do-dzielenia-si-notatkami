<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $notes = [
            [
                'title' => 'Równania kwadratowe – kompletny zestaw',
                'description' => 'Szczegółowe notatki obejmujące wzory skróconego mnożenia, deltę i rozwiązywanie równań kwadratowych krok po kroku z przykładami.',
                'type' => 'PDF',
                'subject_id' => 1, // Matematyka
                'user_id' => 1,
                'rating' => 4.8,
                'downloads_count' => 134,
            ],
            [
                'title' => 'Fizyka Kwantowa – Wykłady z Równaniami',
                'description' => 'Kompletne notatki z wykładów z fizyki kwantowej. Zawierają równania Schrödingera, dualizm korpuskularno-falowy i zasadę nieoznaczoności.',
                'type' => 'Skan Zeszytu',
                'subject_id' => 2, // Fizyka
                'user_id' => 1,
                'rating' => 4.5,
                'downloads_count' => 89,
            ],
            [
                'title' => 'Makroekonomia – Ćwiczenia i Teoria',
                'description' => 'Szczegółowe opracowanie zagadnień makroekonomicznych: PKB, inflacja, bezrobocie, polityka monetarna. Idealne przed egzaminem.',
                'type' => 'Opracowanie',
                'subject_id' => 8, // Makroekonomia
                'user_id' => 1,
                'rating' => 5.0,
                'downloads_count' => 212,
            ],
            [
                'title' => 'Prawo Karne – Kompendium',
                'description' => 'Zbiór notatek z prawa karnego: definicje przestępstw, kodeks karny, orzecznictwo. Czytelne skany z kolorowymi zaznaczeniami.',
                'type' => 'Skan Zeszytu',
                'subject_id' => 6, // Prawo
                'user_id' => 1,
                'rating' => 4.7,
                'downloads_count' => 178,
            ],
            [
                'title' => 'Historia – II Wojna Światowa',
                'description' => 'Kompleksowe notatki dotyczące II Wojny Światowej: przyczyny, przebieg walk na wszystkich frontach, skutki dla Europy i świata.',
                'type' => 'PDF',
                'subject_id' => 5, // Historia
                'user_id' => 1,
                'rating' => 4.2,
                'downloads_count' => 95,
            ],
            [
                'title' => 'Algorytmy i Struktury Danych',
                'description' => 'Notatki z wykładów i laboratoriów. Sortowanie, drzewa BST, grafy, złożoność obliczeniowa – wszystko z przykładami w pseudokodzie.',
                'type' => 'PDF',
                'subject_id' => 9, // Informatyka
                'user_id' => 1,
                'rating' => 4.9,
                'downloads_count' => 301,
            ],
        ];

        foreach ($notes as $note) {
            Note::create($note);
        }
    }
}
