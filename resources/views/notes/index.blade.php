@extends('layouts.dashboard')

@section('dashboard-content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-3xl font-bold text-white mb-1">Baza Notatek</h2>
        <p class="text-slate-400">Przeglądaj materiały naukowe udostępnione przez innych.</p>
    </div>
    
    @if(Auth::user()->isAdmin())
    <button onclick="document.getElementById('add-note-modal').classList.remove('hidden')" class="px-5 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl font-medium shadow-lg transition-all duration-300 hover:scale-105 flex items-center">
        <i class="fa-solid fa-plus mr-2"></i> Dodaj Notatkę
    </button>
    @endif
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 flex items-center">
    <i class="fa-solid fa-circle-check mr-3"></i> {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse ($notes as $index => $note)
    <div class="glass rounded-2xl overflow-hidden border border-slate-700/50 group hover:-translate-y-1 transition-all duration-300 hover:shadow-[0_10px_30px_rgba(0,0,0,0.3)] flex flex-col">
        <!-- Image placeholder with gradient -->
        <div class="h-48 w-full bg-slate-800 relative overflow-hidden shrink-0">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/40 to-secondary/40 opacity-50 mix-blend-overlay z-10"></div>
            @php
                $images = [
                    'https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1456735190827-d1262f71b8a3?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1503694978374-8a2fa686963a?auto=format&fit=crop&q=80&w=800',
                ];
                $imgSrc = $images[$index % count($images)];
            @endphp
            <img src="{{ $imgSrc }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Notatki">
            
            <div class="absolute top-4 right-4 z-20">
                <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-full text-white text-sm font-medium border border-white/10">
                    {{ $note->type }}
                </span>
            </div>
            
            <div class="absolute bottom-4 left-4 z-20 flex items-center space-x-2">
                <span class="px-2 py-1 bg-primary/80 backdrop-blur-md rounded-lg text-white text-xs font-bold uppercase tracking-wider">
                    {{ strtoupper($note->subject->name ?? 'Inne') }}
                </span>
            </div>
        </div>
        
        <div class="p-6 flex-1 flex flex-col">
            <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ $note->title }}</h3>
            <p class="text-slate-400 text-sm mb-4 line-clamp-3 flex-1">{{ $note->description }}</p>
            
            <div class="flex items-center text-sm text-slate-300 mb-6">
                <div class="flex items-center">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-secondary to-primary flex items-center justify-center mr-2 text-xs text-white">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="font-medium mr-2">{{ $note->user->name ?? 'Anonim' }}</span>
                </div>
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                <div>
                    <span class="text-xs text-slate-400 block mb-1">Ocena i Pobrani</span>
                    <div class="flex items-center space-x-3 text-sm">
                        <span class="text-yellow-400 font-medium"><i class="fa-solid fa-star text-xs"></i> {{ $note->rating }}</span>
                        <span class="text-slate-300"><i class="fa-solid fa-download text-xs text-slate-400 mr-1"></i>{{ $note->downloads_count }}</span>
                    </div>
                </div>
                <button class="w-10 h-10 rounded-xl bg-primary/20 text-primary hover:bg-primary hover:text-white flex items-center justify-center transition-colors border border-primary/30">
                    <i class="fa-solid fa-arrow-down"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
        <i class="fa-solid fa-book-open text-5xl text-slate-600 mb-4"></i>
        <h3 class="text-xl font-medium text-white mb-2">Brak dostępnych notatek</h3>
        <p class="text-slate-400 max-w-md">Aktualnie nie mamy żadnych materiałów w naszej bazie. Zaglądaj tu częściej, by nie przegapić nowości!</p>
    </div>
    @endforelse
</div>

<!-- Modal Dodawania -->
@if(Auth::user()->isAdmin())
<div id="add-note-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('add-note-modal').classList.add('hidden')"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg">
        <div class="glass rounded-2xl p-6 md:p-8 shadow-2xl border border-slate-700 m-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Dodaj Notatkę</h3>
                <button onclick="document.getElementById('add-note-modal').classList.add('hidden')" class="text-slate-400 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('notes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-slate-300 mb-1">Tytuł Notatki</label>
                    <input type="text" name="title" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">ID Przedmiotu</label>
                        <input type="number" name="subject_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">Typ</label>
                        <select name="type" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary">
                            <option value="PDF">PDF</option>
                            <option value="Skan Zeszytu">Skan Zeszytu</option>
                            <option value="Opracowanie">Opracowanie</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1">Opis</label>
                    <textarea name="description" rows="4" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary"></textarea>
                </div>
                
                <input type="hidden" name="img" value="default.jpg">

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl font-medium mt-4">
                    Zapisz i Udostępnij
                </button>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
