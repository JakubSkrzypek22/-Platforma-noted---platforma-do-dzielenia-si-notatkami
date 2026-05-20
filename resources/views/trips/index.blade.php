@extends('layouts.dashboard')

@section('dashboard-content')
    <!-- Custom style overrides for notes database page -->
    <style>
        .premium-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background-color: var(--bs-card-bg);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
        }
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--bs-primary);
        }
        .note-img-container {
            height: 180px;
            position: relative;
            overflow: hidden;
            background-color: var(--bs-tertiary-bg);
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

    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-body">Baza Notatek</h2>
            <p class="text-secondary mb-0">Przeglądaj najlepsze materiały naukowe udostępnione przez społeczność.</p>
        </div>
        
        @if(Auth::user()->isAdmin())
        <button type="button" class="btn btn-primary px-4 py-2.5 rounded-3 fw-bold d-flex align-items-center shadow-sm" data-bs-toggle="modal" data-bs-target="#addTripModal">
            <i class="bi bi-plus-lg me-2 fs-5"></i> Wystaw Notatkę
        </button>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center rounded-3 p-3 mb-4 border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
        <div>
            {{ session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        @forelse ($trips as $index => $trip)
        <div class="col">
            <div class="card premium-card h-100 d-flex flex-column justify-content-between">
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
                        
                        <span class="badge bg-black bg-opacity-70 text-white rounded-pill border border-secondary-subtle px-3 py-1.5 font-medium position-absolute" style="top: 15px; right: 15px; z-index: 2; font-size: 0.8rem;">
                            {{ $trip->period % 2 == 0 ? 'Wersja PDF' : 'Skan Zeszytu' }}
                        </span>
                        
                        <span class="badge bg-primary px-2.5 py-1.5 font-bold text-uppercase position-absolute" style="bottom: 15px; left: 15px; z-index: 2; font-size: 0.72rem; letter-spacing: 0.5px;">
                            {{ strtoupper($trip->continent) }}
                        </span>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="h5 fw-bold mb-2 text-break text-body">{{ $trip->name }}</h3>
                        <p class="text-secondary small mb-4" style="line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $trip->description }}
                        </p>
                        
                        <!-- Vinted Style Seller Rating -->
                        <div class="d-flex align-items-center text-secondary" style="font-size: 0.85rem;">
                            <div class="w-6 h-6 rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-primary me-2" style="width: 28px; height: 28px;">
                                <i class="bi bi-person"></i>
                            </div>
                            <span class="fw-bold me-2">Sprzedawca</span>
                            <div class="rating-stars me-1">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star text-muted"></i>
                            </div>
                            <span class="text-muted small">(12)</span>
                        </div>
                    </div>
                </div>
                
                <div class="px-4 pb-4">
                    <hr class="my-3 text-secondary border-opacity-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small d-block">Cena</span>
                            <span class="h4 fw-bold mb-0 text-body">{{ number_format($trip->price, 2, ',', ' ') }} zł</span>
                        </div>
                        <a href="#" class="btn btn-outline-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-arrow-right fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="empty-state shadow-sm">
                <i class="bi bi-journal-x display-3 text-secondary opacity-50 mb-3 d-block"></i>
                <h4 class="fw-bold text-body">Brak Dostępnych Notatek</h4>
                <p class="text-secondary small mx-auto mb-0" style="max-width: 480px;">
                    Aktualnie nie mamy żadnych materiałów w naszej bazie. Zaglądaj tu częściej, by nie przegapić nowości!
                </p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Modal Dodawania (Tylko dla Admina) -->
    @if(Auth::user()->isAdmin())
    <div class="modal fade" id="addTripModal" tabindex="-1" aria-labelledby="addTripModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden bg-body-tertiary">
                <div style="height: 4px; background: linear-gradient(135deg, var(--bs-primary) 0%, #818cf8 100%);"></div>
                
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-body" id="addTripModalLabel"><i class="bi bi-plus-circle text-primary me-2"></i>Wystaw Notatkę</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4">
                    <form action="{{ route('trips.store') }}" method="POST" class="needs-validation">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-body">Tytuł Materiału</label>
                            <input type="text" name="name" required class="form-control" placeholder="np. Makroekonomia - Opracowanie">
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-body">Przedmiot</label>
                                <input type="text" name="continent" required class="form-control" placeholder="np. Ekonomia">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-body">Stron / Rozmiar</label>
                                <input type="number" name="period" required class="form-control" placeholder="np. 24">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-body">Wydział ID</label>
                                <input type="number" name="country_id" required class="form-control" placeholder="np. 1">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-body">Cena (zł)</label>
                                <input type="number" step="0.01" name="price" required class="form-control" placeholder="0.00">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-body">Opis (czytelność, zakres)</label>
                            <textarea name="description" rows="3" required class="form-control" placeholder="Krótki opis zawartości, dla jakiego kierunku..."></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-body">Obrazek (Nazwa pliku)</label>
                            <input type="text" name="img" value="default.jpg" required class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow">
                            Wystaw Materiał
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection
