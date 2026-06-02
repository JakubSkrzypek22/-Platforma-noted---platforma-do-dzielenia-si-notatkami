@if (Session::has('successToast'))
<div id="themeToast" class="toast fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 bg-emerald-600 text-white rounded-xl shadow-2xl p-4 max-w-sm w-full" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="flex items-center justify-between">
        <div class="font-medium text-sm">{{Session::get('successToast')}}</div>
        <button type="button" class="text-white hover:text-emerald-200 transition-colors ml-4" data-close aria-label="Close">
            <i class="bi bi-x-lg text-sm"></i>
        </button>
    </div>
</div>
@endif
