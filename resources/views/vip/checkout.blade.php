@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-12 bg-slate-50 dark:bg-slate-900">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-card-bg border border-border rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl font-black text-text-body mb-2 flex items-center gap-2">
                <i class="bi bi-credit-card text-amber-500"></i> Aktywacja pakietu VIP
            </h2>
            <p class="text-sm text-slate-400 mb-6">Symulacja bezpiecznej płatności za subskrypcję Premium (19,99 zł).</p>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl text-sm font-bold">
                    <ul class="list-disc pl-5">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                </div>
            @endif

            <form action="{{ route('vip.payment') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Właściciel karty</label>
                        <input type="text" name="card_name" value="{{ old('card_name') }}" class="w-full px-3 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 focus:outline-none text-sm placeholder-slate-400" placeholder="Jan Kowalski">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Numer karty</label>
                        <input type="text" name="card_number" value="{{ old('card_number') }}" class="w-full px-3 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 focus:outline-none text-sm placeholder-slate-400" placeholder="4000 1234 5678 9010">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Ważność (MM/RR)</label>
                            <input type="text" name="card_expiry" value="{{ old('card_expiry') }}" class="w-full px-3 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 focus:outline-none text-sm placeholder-slate-400" placeholder="12/28">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Kod CVC</label>
                            <input type="text" name="card_cvc" value="{{ old('card_cvc') }}" class="w-full px-3 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 focus:outline-none text-sm placeholder-slate-400" placeholder="123">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 py-3.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all text-sm">
                    <i class="bi bi-shield-check text-base"></i> Zapłać 19,99 zł i aktywuj VIP
                </button>
            </form>
        </div>
    </div>
</main>

@include('shared.footer')
@endsection