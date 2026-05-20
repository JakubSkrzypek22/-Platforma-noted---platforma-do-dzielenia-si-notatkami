@extends('layouts.dashboard')

@section('dashboard-content')
    <!-- Custom styles for subjects page -->
    <style>
        .premium-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background-color: var(--bs-card-bg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
        }
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--bs-primary);
        }
        .icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: var(--bs-tertiary-bg);
            color: var(--bs-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            transition: background-color 0.3s, color 0.3s;
        }
        .premium-card:hover .icon-wrapper {
            background-color: var(--bs-primary);
            color: white;
        }
    </style>

    <div class="row align-items-center g-3 mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold mb-1 text-body">Przedmioty</h2>
            <p class="text-secondary mb-0">Wydziały i przedmioty dostępne na platformie Notet.</p>
        </div>
        
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                <input type="text" id="subjectSearch" placeholder="Szukaj przedmiotu..." class="form-control border-start-0 ps-0" oninput="filterSubjects()">
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-5" id="subjectsContainer">
        @forelse ($countries as $country)
        <div class="col subject-card" data-name="{{ strtolower($country->name) }}">
            <div class="card premium-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-wrapper">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 py-1.5 fs-8 font-medium">
                            Wydział
                        </span>
                    </div>
                    
                    <h3 class="h5 fw-bold mb-1 text-body subject-title">{{ $country->name }}</h3>
                    <p class="text-secondary small mb-4"><i class="bi bi-folder2-open me-1.5"></i> Materiały: {{ $country->area }}</p>
                </div>
                
                <div>
                    <hr class="my-3 text-secondary border-opacity-10">
                    <div class="d-flex justify-content-between align-items-center small">
                        <span class="text-muted">Język wykładowy:</span>
                        <span class="fw-bold text-body">{{ $country->language }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="empty-state shadow-sm">
                <i class="bi bi-mortarboard display-3 text-secondary opacity-50 mb-3 d-block"></i>
                <h4 class="fw-bold text-body">Brak danych</h4>
                <p class="text-secondary small mx-auto mb-0" style="max-width: 480px;">
                    Baza przedmiotów jest obecnie pusta.
                </p>
            </div>
        </div>
        @endforelse
    </div>

    <script>
        function filterSubjects() {
            const query = document.getElementById('subjectSearch').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.subject-card');
            
            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection
