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
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Możesz dodać kilka plików (PDF, JPG lub PNG) i wybrać, który będzie zdjęciem głównym. Dla pliku PDF okładką jest jego pierwsza strona.</p>

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
                    <label class="block text-xs font-bold text-text-body mb-1.5">Pliki notatki</label>
                    <label for="files" id="dropArea"
                           class="flex flex-col items-center justify-center gap-2 w-full p-8 border-2 border-dashed border-border rounded-xl cursor-pointer hover:border-primary hover:bg-primary/5 transition-colors text-center">
                        <i class="bi bi-cloud-arrow-up text-3xl text-primary"></i>
                        <span class="text-sm font-semibold text-text-body">Kliknij, aby wybrać pliki</span>
                        <span class="text-xs text-slate-400">PDF, JPG lub PNG · można zaznaczyć wiele · maks. 20 MB / plik</span>
                        <input type="file" name="files[]" id="files" accept=".pdf,.jpg,.jpeg,.png" class="hidden" multiple required>
                    </label>

                    <!-- Lista wybranych plików z wyborem głównego -->
                    <div id="fileList" class="mt-3 flex flex-col gap-2"></div>
                    <input type="hidden" name="main_index" id="mainIndex" value="0">
                    <p id="mainHint" class="hidden text-xs text-slate-400 mt-2"><i class="bi bi-info-circle"></i> Zaznacz, który plik ma być zdjęciem głównym (okładką).</p>
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
        const input    = document.getElementById('files');
        const list     = document.getElementById('fileList');
        const mainIdx  = document.getElementById('mainIndex');
        const mainHint = document.getElementById('mainHint');

        function iconFor(name) {
            return name.toLowerCase().endsWith('.pdf') ? 'bi-file-earmark-pdf-fill' : 'bi-file-earmark-image-fill';
        }

        input.addEventListener('change', () => {
            list.innerHTML = '';
            const files = Array.from(input.files);

            if (files.length === 0) {
                mainHint.classList.add('hidden');
                return;
            }
            mainHint.classList.remove('hidden');
            mainIdx.value = '0';

            files.forEach((file, i) => {
                const row = document.createElement('label');
                row.className = 'flex items-center justify-between gap-3 p-3 rounded-xl border border-border bg-card-bg cursor-pointer';
                row.innerHTML = `
                    <span class="flex items-center gap-2 min-w-0">
                        <i class="bi ${iconFor(file.name)} text-primary text-lg"></i>
                        <span class="text-sm text-text-body truncate">${file.name}</span>
                    </span>
                    <span class="flex items-center gap-1.5 text-xs font-semibold text-slate-500 whitespace-nowrap">
                        <input type="radio" name="mainPick" value="${i}" ${i === 0 ? 'checked' : ''} class="text-primary focus:ring-primary">
                        Główny
                    </span>`;
                list.appendChild(row);
            });

            list.querySelectorAll('input[name="mainPick"]').forEach(radio => {
                radio.addEventListener('change', () => { mainIdx.value = radio.value; });
            });
        });
    })();
</script>

@include('shared.footer')
@endsection
