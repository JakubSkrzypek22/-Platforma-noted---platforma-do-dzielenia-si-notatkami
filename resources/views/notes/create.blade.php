@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-10 bg-slate-100/50 dark:bg-slate-900/30">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-primary mb-6">
            <i class="bi bi-arrow-left"></i> Wróć do katalogu
        </a>

        <div class="bg-card-bg border border-border rounded-2xl p-6 sm:p-8 shadow-sm">
            <h1 class="text-2xl font-extrabold text-text-body mb-1">Wystaw nową notatkę</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Wgraj plik (PDF, JPG lub PNG). Pierwsza strona posłuży jako podgląd dla kupujących.</p>

            @include('shared.validation-error')

            <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
                @csrf

                <div>
                    <label for="title" class="block text-xs font-bold text-text-body mb-1.5">Tytuł notatki</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm"
                           placeholder="np. Analiza Matematyczna 1 — pełne opracowanie" required>
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-text-body mb-1.5">Opis</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm resize-none"
                              placeholder="Opisz zawartość, liczbę stron, zakres materiału…" required>{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="category" class="block text-xs font-bold text-text-body mb-1.5">Kategoria</label>
                        <select name="category" id="category"
                                class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" required>
                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>Wybierz kategorię…</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="university" class="block text-xs font-bold text-text-body mb-1.5">Uczelnia (opcjonalnie)</label>
                        <input type="text" name="university" id="university" value="{{ old('university') }}"
                               class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm"
                               placeholder="np. Politechnika Warszawska">
                    </div>
                </div>

                <div>
                    <label for="price" class="block text-xs font-bold text-text-body mb-1.5">Cena (zł) — wpisz 0 dla materiału darmowego</label>
                    <input type="number" name="price" id="price" value="{{ old('price', 0) }}" step="0.01" min="0" max="99999"
                           class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-body mb-1.5">Plik notatki</label>
                    <label for="file" id="dropArea"
                           class="flex flex-col items-center justify-center gap-2 w-full p-8 border-2 border-dashed border-border rounded-xl cursor-pointer hover:border-primary hover:bg-primary/5 transition-colors text-center">
                        <i class="bi bi-cloud-arrow-up text-3xl text-primary"></i>
                        <span class="text-sm font-semibold text-text-body" id="fileLabel">Kliknij, aby wybrać plik</span>
                        <span class="text-xs text-slate-400">PDF, JPG lub PNG · maks. 20 MB</span>
                        <input type="file" name="file" id="file" accept=".pdf,.jpg,.jpeg,.png" class="hidden" required>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all">
                    <i class="bi bi-upload"></i> Opublikuj notatkę
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    (function () {
        const input = document.getElementById('file');
        const label = document.getElementById('fileLabel');
        if (!input) return;
        input.addEventListener('change', () => {
            label.textContent = input.files.length ? input.files[0].name : 'Kliknij, aby wybrać plik';
        });
    })();
</script>

@include('shared.footer')
@endsection
