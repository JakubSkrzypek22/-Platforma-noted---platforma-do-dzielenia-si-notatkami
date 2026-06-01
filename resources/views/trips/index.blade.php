@extends('layouts.dashboard')

@section('dashboard-content')
    <!-- Custom style overrides for notes database page -->
    <style>
        .premium-card {
            border: 1px solid var(--color-border);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background-color: var(--color-card-bg);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
        }
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--color-primary);
        }
        .note-img-container {
            height: 180px;
            position: relative;
            overflow: hidden;
            background-color: var(--color-border);
        }
        .note-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .premium-card:hover .note-img-container img {
            transform: scale(1.08);
        }
        .rating-stars {
            color: #ffc107;
        }
    </style>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-text-body mb-1">Baza Notatek</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Przeglądaj najlepsze materiały naukowe udostępnione przez społeczność.</p>
        </div>
        
        @if(Auth::user()->isAdmin())
        <button type="button" onclick="toggleModal('addTripModal', true)" class="bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-xl font-bold flex items-center shadow-md hover:shadow-lg transition-all cursor-pointer">
            <i class="bi bi-plus-lg mr-2 text-lg"></i> Wystaw Notatkę
        </button>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 p-4 rounded-xl text-sm flex items-center justify-between shadow-sm mb-6" id="successAlert">
        <div class="flex items-center">
            <i class="bi bi-check-circle-fill text-lg mr-3 text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="document.getElementById('successAlert').style.display='none'" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"><i class="bi bi-x-lg"></i></button>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @forelse ($trips as $index => $trip)
        <div class="flex">
            <div class="premium-card h-full flex flex-col justify-between flex-grow">
                <div>
                    <!-- Image placeholder with gradient -->
                    <div class="note-img-container">
                        <div class="bg-dark opacity-10" style="position: absolute; top:0; left:0; right:0; bottom:0; z-index: 1;"></div>
                        @php
                            // Randomize image to look like notes
                            $images = [
                                'https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&q=80&w=800',
                                'https://images.unsplash.com/photo-1456735190827-d1262f71b8a3?auto=format&fit=crop&q=80&w=800',
                                'https://images.unsplash.com/photo-1503694978374-8a2fa686963a?auto=format&fit=crop&q=80&w=800',
                            ];
                            $imgSrc = $images[$index % count($images)];
                        @endphp
                        <img src="{{ $imgSrc }}" alt="Notatki">
                        
                        <span class="bg-black/70 text-white border border-white/20 px-3 py-1.5 text-xs font-semibold rounded-full position-absolute" style="top: 15px; right: 15px; z-index: 2;">
                            {{ $trip->period % 2 == 0 ? 'Wersja PDF' : 'Skan Zeszytu' }}
                        </span>
                        
                        <span class="bg-primary px-2.5 py-1 text-white font-bold text-uppercase position-absolute rounded" style="bottom: 15px; left: 15px; z-index: 2; font-size: 0.72rem; letter-spacing: 0.5px;">
                            {{ strtoupper($trip->continent) }}
                        </span>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-2 text-break text-text-body">{{ $trip->name }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mb-5 leading-relaxed" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $trip->description }}
                        </p>
                        
                        <!-- Vinted Style Seller Rating -->
                        <div class="flex items-center text-slate-500 dark:text-slate-400 text-xs">
                            <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-2.5">
                                <i class="bi bi-person"></i>
                            </div>
                            <span class="font-bold mr-2 text-text-body">Sprzedawca</span>
                            <div class="rating-stars mr-1">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star opacity-30"></i>
                            </div>
                            <span class="text-slate-400 text-xs">(12)</span>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 pb-6">
                    <div class="border-t border-border my-4"></div>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-slate-400 text-xs block mb-0.5">Cena</span>
                            <span class="text-xl font-extrabold text-text-body">{{ number_format($trip->price, 2, ',', ' ') }} zł</span>
                        </div>
                        <a href="#" class="border border-primary text-primary hover:bg-primary hover:text-white rounded-xl p-2 flex items-center justify-center transition-all w-10 h-10">
                            <i class="bi bi-arrow-right text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="bg-card-bg border-2 border-dashed border-border rounded-2xl p-12 max-w-md mx-auto">
                <i class="bi bi-journal-x text-5xl text-slate-400 mb-3 block"></i>
                <h4 class="text-lg font-bold text-text-body mb-1">Brak Dostępnych Notatek</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm">
                    Aktualnie nie mamy żadnych materiałów w naszej bazie. Zaglądaj tu częściej, by nie przegapić nowości!
                </p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Modal Dodawania (Tylko dla Admina) -->
    @if(Auth::user()->isAdmin())
    <div id="addTripModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative bg-card-bg w-full max-w-md rounded-2xl overflow-hidden shadow-2xl border border-border">
            <div style="height: 4px; background: linear-gradient(135deg, var(--color-primary) 0%, #818cf8 100%);"></div>
            
            <div class="flex items-center justify-between p-6 border-b border-border">
                <h5 class="text-lg font-bold text-text-body flex items-center"><i class="bi bi-plus-circle text-primary mr-2"></i>Wystaw Notatkę</h5>
                <button type="button" onclick="toggleModal('addTripModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"><i class="bi bi-x-lg text-lg"></i></button>
            </div>
            
            <div class="p-6">
                <form action="{{ route('trips.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-text-body mb-1.5">Tytuł Materiału</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400" placeholder="np. Makroekonomia - Opracowanie">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-text-body mb-1.5">Przedmiot</label>
                            <input type="text" name="continent" required class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400" placeholder="np. Ekonomia">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text-body mb-1.5">Stron / Rozmiar</label>
                            <input type="number" name="period" required class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400" placeholder="np. 24">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-text-body mb-1.5">Wydział ID</label>
                            <input type="number" name="country_id" required class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400" placeholder="np. 1">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text-body mb-1.5">Cena (zł)</label>
                            <input type="number" step="0.01" name="price" required class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400" placeholder="0.00">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-body mb-1.5">Opis (czytelność, zakres)</label>
                        <textarea name="description" rows="3" required class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400 resize-none" placeholder="Krótki opis zawartości, dla jakiego kierunku..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-text-body mb-1.5">Obrazek (Nazwa pliku)</label>
                        <input type="text" name="img" value="default.jpg" required class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" />
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all mt-2 cursor-pointer">
                        Wystaw Materiał
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script>
        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            if (modal) {
                if (show) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        }
    </script>
@endsection
