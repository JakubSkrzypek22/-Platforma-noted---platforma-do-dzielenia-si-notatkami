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
                        <label for="university" class="block text-xs font-bold text-text-body mb-1.5">Uczelnia</label>
                        <input type="text" name="university" id="university" value="{{ old('university') }}"
                               class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm"
                               placeholder="np. Uniwersytet Rzeszowski">
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
                        <span class="text-sm font-semibold text-text-body">Przeciągnij pliki tutaj lub kliknij, aby wybrać</span>
                        <span class="text-xs text-slate-400">PDF, JPG lub PNG · możesz dodawać wielokrotnie · maks. 20 MB / plik</span>
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
        const dropArea = document.getElementById('dropArea');
        const list     = document.getElementById('fileList');
        const mainIdx  = document.getElementById('mainIndex');
        const mainHint = document.getElementById('mainHint');

        // Akumulator wszystkich wybranych plików — dzięki niemu kolejne wybory NIE nadpisują poprzednich.
        const dt = new DataTransfer();
        let mainName = null; // który plik (po nazwie) jest zdjęciem głównym

        const iconFor = (name) => name.toLowerCase().endsWith('.pdf') ? 'bi-file-earmark-pdf-fill' : 'bi-file-earmark-image-fill';
        const keyOf   = (f) => f.name + '|' + f.size;
        const isAllowed = (f) => /\.(pdf|jpe?g|png)$/i.test(f.name);

        function addFiles(fileList) {
            const existing = new Set(Array.from(dt.files).map(keyOf));
            Array.from(fileList).forEach(f => {
                if (isAllowed(f) && !existing.has(keyOf(f))) {
                    dt.items.add(f);
                    existing.add(keyOf(f));
                }
            });
            input.files = dt.files; // przepisujemy komplet do inputa, aby wysłać wszystkie pliki
            render();
        }

        function removeAt(i) {
            dt.items.remove(i);
            input.files = dt.files;
            render();
        }

        function render() {
            const files = Array.from(dt.files);
            list.innerHTML = '';

            if (files.length === 0) {
                mainHint.classList.add('hidden');
                mainIdx.value = '0';
                return;
            }
            mainHint.classList.remove('hidden');

            if (!files.some(f => f.name === mainName)) mainName = files[0].name;
            mainIdx.value = String(files.findIndex(f => f.name === mainName));

            files.forEach((file, i) => {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between gap-3 p-3 rounded-xl border border-border bg-card-bg';
                row.innerHTML = `
                    <label class="flex items-center gap-2 min-w-0 flex-grow cursor-pointer">
                        <input type="radio" name="mainPick" value="${i}" ${file.name === mainName ? 'checked' : ''} class="text-primary focus:ring-primary">
                        <i class="bi ${iconFor(file.name)} text-primary text-lg"></i>
                        <span class="text-sm text-text-body truncate">${file.name}</span>
                        <span class="text-[11px] text-slate-400 whitespace-nowrap">${(file.size / 1048576).toFixed(1)} MB</span>
                    </label>
                    <button type="button" data-remove="${i}" class="text-slate-400 hover:text-red-500 p-1.5 rounded-lg transition-colors" title="Usuń plik">
                        <i class="bi bi-x-lg"></i>
                    </button>`;
                list.appendChild(row);
            });

            list.querySelectorAll('input[name="mainPick"]').forEach((radio, i) => {
                radio.addEventListener('change', () => { mainName = files[i].name; mainIdx.value = String(i); });
            });
            list.querySelectorAll('button[data-remove]').forEach(btn => {
                btn.addEventListener('click', () => removeAt(parseInt(btn.dataset.remove, 10)));
            });
        }

        input.addEventListener('change', () => addFiles(input.files));

        // Przeciąganie i upuszczanie
        ['dragenter', 'dragover'].forEach(ev => dropArea.addEventListener(ev, (e) => {
            e.preventDefault(); e.stopPropagation();
            dropArea.classList.add('border-primary', 'bg-primary/5');
        }));
        ['dragleave', 'drop'].forEach(ev => dropArea.addEventListener(ev, (e) => {
            e.preventDefault(); e.stopPropagation();
            dropArea.classList.remove('border-primary', 'bg-primary/5');
        }));
        dropArea.addEventListener('drop', (e) => {
            if (e.dataTransfer && e.dataTransfer.files) addFiles(e.dataTransfer.files);
        });
    })();
</script>

@include('shared.footer')
@endsection
