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

        foreach (Storage::disk('local')->files('notes') as $existing) {
            if (str_contains($existing, 'seed-')) {
                Storage::disk('local')->delete($existing);
            }
        }

        $userIds = User::pluck('id')->all();
        if (empty($userIds)) {
            return;
        }

        $samples = require __DIR__ . '/data/note_samples.php';

        $colors = [
            'Matematyka'   => '#06b6d4',
            'Medycyna'     => '#ef4444',
            'Informatyka'  => '#3b82f6',
            'Prawo'        => '#f59e0b',
            'Ekonomia'     => '#10b981',
            'Języki Obce'  => '#64748b',
            'Fizyka'       => '#8b5cf6',
            'Chemia'       => '#84cc16',
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
                'views'       => rand(0, 45),
                'downloads'   => rand(0, 12),
            ]);

            $pageCount = rand(2, 5);
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

        $sampleComments = [
            'Świetne notatki, bardzo pomogły mi przed egzaminem!',
            'Przejrzyste i dobrze opracowane. Polecam.',
            'Dużo treści w przystępnej formie. Wart swojej ceny.',
            'Pomogło, choć przydałoby się więcej przykładów.',
            'Rewelacja, zdałem dzięki tym materiałom!',
            'Dokładne streszczenie wykładu — oszczędza godziny nauki.',
            'Materiał zgodny z programem uczelni, polecam przed kolokwium.',
            'Dobre schematy i tabele, łatwo się uczyć.',
        ];

        foreach ($createdNotes as $idx => $note) {
            if ($note->isFree()) {
                continue;
            }

            $buyers  = collect($userIds)->reject(fn ($id) => $id === $note->user_id)->shuffle()->values();
            $howMany = min(rand(1, 4), $buyers->count());

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
                    'rating'    => rand(3, 5),
                    'comment'   => $sampleComments[($idx + $j) % count($sampleComments)],
                ]);
            }
        }

        foreach ($userIds as $uid) {
            $candidates = collect($createdNotes)
                ->reject(fn ($n) => $n->user_id === $uid)
                ->shuffle()
                ->take(rand(4, 10));

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

        $heading = $pageNum === 1 ? $safeTitle : "{$safeTitle} — strona {$pageNum}";
        $hWords  = explode(' ', $heading);
        $hLines  = [];
        $cur     = '';
        foreach ($hWords as $word) {
            if (mb_strlen($cur . ' ' . $word) > 28) {
                $hLines[] = trim($cur);
                $cur      = $word;
            } else {
                $cur .= ' ' . $word;
            }
        }
        $hLines[] = trim($cur);
        $hLines   = array_slice($hLines, 0, 3);

        $titleTspans = '';
        foreach ($hLines as $k => $line) {
            $y = 150 + ($k * 34);
            $titleTspans .= "<text x='60' y='{$y}' font-family='Segoe UI, Arial, sans-serif' font-size='26' font-weight='700' fill='#0f172a'>{$line}</text>";
        }

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
