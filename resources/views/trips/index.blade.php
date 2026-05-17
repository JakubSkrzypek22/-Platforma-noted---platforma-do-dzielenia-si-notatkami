@extends('layouts.dashboard')

@section('dashboard-content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-3xl font-bold text-white mb-1">Oferty Wycieczek</h2>
        <p class="text-slate-400">Przeglądaj ekskluzywne pakiety podróżnicze.</p>
    </div>
    
    @if(Auth::user()->isAdmin())
    <button onclick="document.getElementById('add-trip-modal').classList.remove('hidden')" class="px-5 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl font-medium shadow-lg transition-all duration-300 hover:scale-105 flex items-center">
        <i class="fa-solid fa-plus mr-2"></i> Dodaj Ofertę
    </button>
    @endif
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 flex items-center">
    <i class="fa-solid fa-circle-check mr-3"></i> {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse ($trips as $trip)
    <div class="glass rounded-2xl overflow-hidden border border-slate-700/50 group hover:-translate-y-1 transition-all duration-300 hover:shadow-[0_10px_30px_rgba(0,0,0,0.3)]">
        <!-- Image placeholder with gradient -->
        <div class="h-48 w-full bg-slate-800 relative overflow-hidden">
            <!-- W realnej aplikacji użylibyśmy {{ asset('storage/'.$trip->img) }} -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary/40 to-secondary/40 opacity-80 mix-blend-overlay z-10"></div>
            <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Wycieczka">
            
            <div class="absolute top-4 right-4 z-20">
                <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-full text-white text-sm font-medium border border-white/10">
                    {{ $trip->period }} dni
                </span>
            </div>
            
            <div class="absolute bottom-4 left-4 z-20 flex items-center space-x-2">
                <span class="px-2 py-1 bg-primary/80 backdrop-blur-md rounded-lg text-white text-xs font-bold uppercase tracking-wider">
                    {{ $trip->continent }}
                </span>
            </div>
        </div>
        
        <div class="p-6">
            <h3 class="text-xl font-bold text-white mb-2">{{ $trip->name }}</h3>
            <p class="text-slate-400 text-sm mb-4 line-clamp-2">{{ $trip->description }}</p>
            
            <div class="flex items-center text-sm text-slate-300 mb-6">
                <i class="fa-solid fa-location-dot text-red-400 mr-2"></i> {{ $trip->country ? $trip->country->name : 'Nieznany kraj' }}
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                <div>
                    <span class="text-xs text-slate-400 block">Cena za osobę</span>
                    <span class="text-xl font-bold text-white">{{ number_format($trip->price, 2, ',', ' ') }} zł</span>
                </div>
                <button class="w-10 h-10 rounded-xl bg-primary/20 text-primary hover:bg-primary hover:text-white flex items-center justify-center transition-colors border border-primary/30">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
        <i class="fa-solid fa-plane-slash text-5xl text-slate-600 mb-4"></i>
        <h3 class="text-xl font-medium text-white mb-2">Brak dostępnych wycieczek</h3>
        <p class="text-slate-400 max-w-md">Aktualnie nie mamy żadnych ofert wycieczek w naszej bazie. Zaglądaj tu częściej, by nie przegapić nowości!</p>
    </div>
    @endforelse
</div>

<!-- Modal Dodawania (Tylko dla Admina) -->
@if(Auth::user()->isAdmin())
<div id="add-trip-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('add-trip-modal').classList.add('hidden')"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg">
        <div class="glass rounded-2xl p-6 md:p-8 shadow-2xl border border-slate-700 m-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Nowa Wycieczka</h3>
                <button onclick="document.getElementById('add-trip-modal').classList.add('hidden')" class="text-slate-400 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('trips.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-slate-300 mb-1">Nazwa Wycieczki</label>
                    <input type="text" name="name" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">Kontynent</label>
                        <input type="text" name="continent" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">Dni (Period)</label>
                        <input type="number" name="period" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">Kraj ID</label>
                        <input type="number" name="country_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary" placeholder="np. 1">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">Cena</label>
                        <input type="number" step="0.01" name="price" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1">Opis</label>
                    <textarea name="description" rows="3" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm text-slate-300 mb-1">Obrazek (Nazwa/Link)</label>
                    <input type="text" name="img" value="default.jpg" required class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2 px-3 text-white focus:ring-2 focus:ring-primary">
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl font-medium mt-4">
                    Zapisz Ofertę
                </button>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
