@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-10 bg-slate-100/50 dark:bg-slate-900/30">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('notes.show', $note) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-primary mb-6">
            <i class="bi bi-arrow-left"></i> Wróć do notatki
        </a>

        @if (session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 p-4 rounded-xl text-sm mb-6">
                <i class="bi bi-check-circle-fill mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="bg-card-bg border border-border rounded-2xl p-6 sm:p-8 shadow-sm">
            <h1 class="text-2xl font-extrabold text-text-body mb-1">Edytuj notatkę</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Zmień dane, zarządzaj plikami i wybierz zdjęcie główne.</p>

            @include('shared.validation-error')

            <form action="{{ route('notes.update', $note) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-xs font-bold text-text-body mb-1.5">Tytuł notatki</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $note->title) }}"
                           class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" required>
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-text-body mb-1.5">Opis</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm resize-none" required>{{ old('description', $note->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="category" class="block text-xs font-bold text-text-body mb-1.5">Kategoria</label>
                        <select name="category" id="category"
                                class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" required>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $note->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="university" class="block text-xs font-bold text-text-body mb-1.5">Uczelnia (opcjonalnie)</label>
                        <input type="text" name="university" id="university" value="{{ old('university', $note->university) }}"
                               class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm">
                    </div>
                </div>

                <div>
                    <label for="price" class="block text-xs font-bold text-text-body mb-1.5">Cena (zł)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $note->price) }}" step="0.01" min="0" max="99999"
                           class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" required>
                </div>

                <!-- Istniejące pliki -->
                <div>
                    <label class="block text-xs font-bold text-text-body mb-1.5">Pliki notatki ({{ $note->files->count() }}) — wybierz zdjęcie główne</label>
                    <div class="flex flex-col gap-2">
                        @foreach ($note->files as $file)
                            <div class="flex items-center justify-between gap-3 p-3 rounded-xl border border-border bg-card-bg">
                                <label class="flex items-center gap-3 min-w-0 cursor-pointer">
                                    <input type="radio" name="main_file_id" value="{{ $file->id }}" {{ $file->is_main ? 'checked' : '' }} class="text-primary focus:ring-primary">
                                    @if ($file->isPdf())
                                        <i class="bi bi-file-earmark-pdf-fill text-primary text-xl"></i>
                                    @else
                                        <img src="{{ route('notes.files.show', [$note, $file]) }}" class="w-10 h-10 rounded-lg object-cover border border-border" alt="">
                                    @endif
                                    <span class="text-sm text-text-body truncate">
                                        {{ $file->original_name ?? 'plik' }}
                                        @if ($file->is_main)
                                            <span class="ml-1 text-[10px] font-bold text-primary uppercase">główny</span>
                                        @endif
                                    </span>
                                </label>
                                @if ($note->files->count() > 1)
                                    <button type="button" form="del-{{ $file->id }}"
                                            onclick="if(confirm('Usunąć ten plik?')) document.getElementById('del-{{ $file->id }}').submit();"
                                            class="text-red-500 hover:bg-red-500/10 rounded-lg p-2 transition-colors" title="Usuń plik">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Dodanie kolejnych plików -->
                <div>
                    <label class="block text-xs font-bold text-text-body mb-1.5">Dodaj kolejne pliki (opcjonalnie)</label>
                    <label for="new_files" id="newDropArea"
                           class="flex flex-col items-center justify-center gap-2 w-full p-6 border-2 border-dashed border-border rounded-xl cursor-pointer hover:border-primary hover:bg-primary/5 transition-colors text-center">
                        <i class="bi bi-cloud-arrow-up text-2xl text-primary"></i>
                        <span class="text-sm font-semibold text-text-body">Przeciągnij pliki tutaj lub kliknij, aby wybrać</span>
                        <span class="text-xs text-slate-400">PDF, JPG lub PNG · możesz dodawać wielokrotnie · maks. 20 MB / plik</span>
                        <input type="file" name="new_files[]" id="new_files" accept=".pdf,.jpg,.jpeg,.png" multiple class="hidden">
                    </label>
                    <div id="newFileList" class="mt-3 flex flex-col gap-2"></div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all">
                    <i class="bi bi-check-lg"></i> Zapisz zmiany
                </button>
            </form>
        </div>

        <!-- Usunięcie całej notatki -->
        <div class="mt-6 bg-card-bg border border-red-200 dark:border-red-900/40 rounded-2xl p-5 flex items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-text-body text-sm">Usuń notatkę</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Tej operacji nie można cofnąć — pliki i opinie zostaną usunięte.</p>
            </div>
            <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Na pewno usunąć tę notatkę? Operacja jest nieodwracalna.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold text-sm transition-colors whitespace-nowrap">
                    <i class="bi bi-trash3 mr-1.5"></i> Usuń
                </button>
            </form>
        </div>
    </div>
</main>

<!-- Ukryte formularze usuwania pojedynczych plików (poza głównym formularzem) -->
@foreach ($note->files as $file)
    <form id="del-{{ $file->id }}" action="{{ route('notes.files.destroy', [$note, $file]) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<script>
    (function () {
        const input    = document.getElementById('new_files');
        const dropArea = document.getElementById('newDropArea');
        const list     = document.getElementById('newFileList');
        if (!input) return;

        const dt = new DataTransfer(); // akumulacja — kolejne wybory nie nadpisują poprzednich
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
            input.files = dt.files;
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
            files.forEach((file, i) => {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between gap-3 p-3 rounded-xl border border-border bg-card-bg';
                row.innerHTML = `
                    <span class="flex items-center gap-2 min-w-0">
                        <i class="bi ${iconFor(file.name)} text-primary text-lg"></i>
                        <span class="text-sm text-text-body truncate">${file.name}</span>
                        <span class="text-[11px] text-slate-400 whitespace-nowrap">${(file.size / 1048576).toFixed(1)} MB</span>
                    </span>
                    <button type="button" data-remove="${i}" class="text-slate-400 hover:text-red-500 p-1.5 rounded-lg transition-colors" title="Usuń plik">
                        <i class="bi bi-x-lg"></i>
                    </button>`;
                list.appendChild(row);
            });
            list.querySelectorAll('button[data-remove]').forEach(btn => {
                btn.addEventListener('click', () => removeAt(parseInt(btn.dataset.remove, 10)));
            });
        }

        input.addEventListener('change', () => addFiles(input.files));

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
