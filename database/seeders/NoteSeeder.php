<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Note;
use App\Models\NoteFile;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        Favorite::query()->delete();
        Review::query()->delete();
        Purchase::query()->delete();
        NoteFile::query()->delete();
        Note::query()->delete();

        // Czyścimy wcześniej wygenerowane podglądy demonstracyjne
        foreach (Storage::disk('local')->files('notes') as $existing) {
            if (str_contains($existing, 'seed-')) {
                Storage::disk('local')->delete($existing);
            }
        }

        $userIds = User::pluck('id')->all();
        if (empty($userIds)) {
            return;
        }

        $samples = [
            ['Analiza Matematyczna 1 — kompletne opracowanie teorii', 'Matematyka', 'Politechnika Warszawska', 14.99, 'Zbiór twierdzeń, definicji i przykładowych zadań z analizy matematycznej: granice, pochodne, całki oznaczone i nieoznaczone. Zawiera rysunki pomocnicze i typowe zadania egzaminacyjne.'],
            ['Anatomia Prawidłowa — układ nerwowy i naczyniowy', 'Medycyna', 'Uniwersytet Jagielloński', 24.50, 'Szczegółowe streszczenie struktur ośrodkowego i obwodowego układu nerwowego. Tabele z unerwieniem i unaczynieniem mięśni oraz przejrzyste schematy.'],
            ['Programowanie Obiektowe w C++ i Java', 'Informatyka', 'AGH w Krakowie', 0, 'Wyjaśnienie polimorfizmu, dziedziczenia, hermetyzacji, interfejsów i klas abstrakcyjnych. Przykłady kodu gotowe do kompilacji.'],
            ['Prawo Rzymskie — skrót przedegzaminacyjny', 'Prawo', 'Uniwersytet Warszawski', 9.99, 'Najważniejsze pojęcia, skróty i łacińskie paremie prawne niezbędne do zaliczenia egzaminu. Przejrzysty układ i schematy powiązań.'],
            ['Podstawy Makroekonomii — wskaźniki, modele, polityka', 'Ekonomia', 'Szkoła Główna Handlowa', 12.00, 'Opracowanie modeli IS-LM, bezrobocia, inflacji oraz stóp procentowych. Mechanizmy polityki monetarnej i fiskalnej banku centralnego.'],
            ['Gramatyka opisowa języka angielskiego (Tenses & Syntax)', 'Języki Obce', 'Uniwersytet Wrocławski', 7.50, 'Kompendium struktur czasowych, zdań warunkowych i mowy zależnej. Idealne pod kolokwium z gramatyki praktycznej.'],
            ['Mechanika Kwantowa — podstawy i formalizm', 'Fizyka', 'Politechnika Gdańska', 19.99, 'Omówienie równania Schrödingera, zasady nieoznaczoności Heisenberga i modelu atomu Bohra. Wyprowadzenia i przykłady zastosowań.'],
            ['Termodynamika — zasady i procesy', 'Fizyka', 'Politechnika Łódzka', 0, 'Streszczenie czterech zasad termodynamiki, cyklu Carnota, entropii i entalpii. Tabele wzorów przydatne na egzamin.'],
            ['Chemia Organiczna — reakcje substytucji i eliminacji', 'Chemia', 'Politechnika Wrocławska', 11.00, 'Systematyczne omówienie reakcji SN1, SN2, E1 i E2 z mechanizmami krokowymi i przykładami substratów.'],
            ['Stechiometria — skrypt ćwiczeniowy', 'Chemia', 'Uniwersytet Gdański', 8.99, 'Zestaw 60 rozwiązanych zadań: stężenia, pH, równowagi i ilości molarne. Pełne toki rozwiązań krok po kroku.'],
            ['Algorytmy i Struktury Danych — kompleksowy przewodnik', 'Informatyka', 'Politechnika Poznańska', 22.00, 'Opracowanie sortowania, grafów, drzew binarnych i programowania dynamicznego. Każdy algorytm z analizą złożoności.'],
            ['Algebra liniowa — macierze, wektory i przekształcenia', 'Matematyka', 'UAM Poznań', 13.50, 'Działania na macierzach, wyznaczniki, przestrzenie wektorowe i wartości własne. Schematy do typowych zadań egzaminacyjnych.'],
        ];

        $colors = [
            'Matematyka' => '#06b6d4', 'Medycyna' => '#ef4444', 'Informatyka' => '#3b82f6',
            'Prawo' => '#f59e0b', 'Ekonomia' => '#10b981', 'Języki Obce' => '#64748b',
            'Fizyka' => '#8b5cf6', 'Chemia' => '#84cc16',
        ];

        $createdNotes = [];

        foreach ($samples as $i => [$title, $category, $university, $price, $description]) {
            $authorId = $userIds[$i % count($userIds)];
            $color    = $colors[$category] ?? '#3b82f6';

            $note = Note::create([
                'user_id'     => $authorId,
                'title'       => $title,
                'description' => $description,
                'category'    => $category,
                'university'  => $university,
                'price'       => $price,
                'views'       => rand(800, 5200),
                'downloads'   => rand(120, 2100),
            ]);

            // Kilka "stron" (plików) — pierwsza jest zdjęciem głównym (okładką)
            $pageCount = rand(2, 4);
            for ($p = 1; $p <= $pageCount; $p++) {
                $svg  = $this->buildPreviewSvg($title, $category, $color, $p);
                $path = "notes/seed-{$note->id}-{$p}.svg";
                Storage::disk('local')->put($path, $svg);

                $note->files()->create([
                    'path'          => $path,
                    'file_type'     => 'image',
                    'original_name' => "strona-{$p}.svg",
                    'is_main'       => $p === 1,
                    'position'      => $p - 1,
                ]);
            }

            $createdNotes[] = $note;
        }

        // Przykładowe zakupy + oceny, aby sprzedawcy mieli reputację
        $sampleComments = [
            'Świetne notatki, bardzo pomogły mi przed egzaminem!',
            'Przejrzyste i dobrze opracowane. Polecam.',
            'Dużo treści w przystępnej formie. Wart swojej ceny.',
            'Pomogło, choć przydałoby się więcej przykładów.',
            'Rewelacja, zdałem dzięki tym materiałom!',
        ];

        foreach ($createdNotes as $idx => $note) {
            $buyers  = collect($userIds)->reject(fn ($id) => $id === $note->user_id)->values();
            $howMany = min(rand(1, 3), $buyers->count());

            foreach ($buyers->take($howMany) as $j => $buyerId) {
                Purchase::create([
                    'user_id'         => $buyerId,
                    'note_id'         => $note->id,
                    'amount'          => $note->price,
                    'payment_method'  => 'card',
                    'status'          => 'completed',
                    'transaction_ref' => 'SEED-' . $note->id . '-' . $buyerId,
                ]);

                Review::create([
                    'note_id'   => $note->id,
                    'user_id'   => $buyerId,
                    'seller_id' => $note->user_id,
                    'rating'    => rand(4, 5),
                    'comment'   => $sampleComments[($idx + $j) % count($sampleComments)],
                ]);
            }
        }

        // Przykładowe ulubione — każdy użytkownik dodaje kilka cudzych notatek do ulubionych
        foreach ($userIds as $uid) {
            $candidates = collect($createdNotes)->reject(fn ($n) => $n->user_id === $uid)->shuffle()->take(rand(2, 4));
            foreach ($candidates as $note) {
                Favorite::firstOrCreate(['user_id' => $uid, 'note_id' => $note->id]);
            }
        }
    }

    /**
     * Buduje prosty podgląd strony w formacie SVG (bez bibliotek graficznych).
     */
    private function buildPreviewSvg(string $title, string $category, string $color, int $pageNum): string
    {
        $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $safeCat   = htmlspecialchars($category, ENT_QUOTES | ENT_XML1, 'UTF-8');

        // Zawijanie tytułu do kilku linii
        $words = explode(' ', $safeTitle);
        $lines = [];
        $current = '';
        foreach ($words as $word) {
            if (mb_strlen($current . ' ' . $word) > 28) {
                $lines[] = trim($current);
                $current = $word;
            } else {
                $current .= ' ' . $word;
            }
        }
        $lines[] = trim($current);
        $lines = array_slice($lines, 0, 3);

        $heading = $pageNum === 1 ? $safeTitle : "{$safeTitle} — strona {$pageNum}";
        $hWords  = explode(' ', $heading);
        $hLines  = [];
        $cur = '';
        foreach ($hWords as $word) {
            if (mb_strlen($cur . ' ' . $word) > 28) { $hLines[] = trim($cur); $cur = $word; }
            else { $cur .= ' ' . $word; }
        }
        $hLines[] = trim($cur);
        $hLines = array_slice($hLines, 0, 3);

        $titleTspans = '';
        foreach ($hLines as $k => $line) {
            $y = 150 + ($k * 34);
            $titleTspans .= "<text x='60' y='{$y}' font-family='Segoe UI, Arial, sans-serif' font-size='26' font-weight='700' fill='#0f172a'>{$line}</text>";
        }

        // Linie imitujące tekst
        $bodyLines = '';
        for ($l = 0; $l < 14; $l++) {
            $y = 280 + ($l * 26);
            $w = [420, 460, 380, 440, 300][($l + $pageNum) % 5];
            $bodyLines .= "<rect x='60' y='{$y}' width='{$w}' height='9' rx='4.5' fill='#e2e8f0'/>";
        }

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="595" height="842" viewBox="0 0 595 842">
  <rect width="595" height="842" fill="#ffffff"/>
  <rect x="0" y="0" width="595" height="14" fill="{$color}"/>
  <rect x="60" y="60" width="120" height="26" rx="13" fill="{$color}" opacity="0.15"/>
  <text x="120" y="78" text-anchor="middle" font-family="Segoe UI, Arial, sans-serif" font-size="13" font-weight="700" fill="{$color}">{$safeCat}</text>
  {$titleTspans}
  <rect x="60" y="230" width="475" height="2" fill="#cbd5e1"/>
  {$bodyLines}
  <text x="297" y="800" text-anchor="middle" font-family="Segoe UI, Arial, sans-serif" font-size="12" fill="#94a3b8">Noted — strona {$pageNum} · podgląd</text>
</svg>
SVG;
    }
}
