@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen py-12">
    <div class="w-full max-w-[440px] px-5">
        <div class="text-center mb-6">
            <span class="text-4xl block mb-2">📚</span>
            <h1 class="text-3xl font-bold mb-1 text-text-body">Noted</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Platforma Dzielenia się Notatkami Studenckimi</p>
        </div>

        <div class="bg-card-bg shadow-xl border border-border rounded-2xl overflow-hidden">
            <!-- Top premium colored line -->
            <div style="height: 4px; background: linear-gradient(135deg, var(--color-primary) 0%, #818cf8 100%);"></div>

            <div class="p-6 md:p-8">
                @yield('auth-content')
            </div>
        </div>
    </div>
</div>
@endsection
