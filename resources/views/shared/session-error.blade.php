@if (session('error'))
<div class="flex justify-center mb-4">
    <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 text-red-700 dark:text-red-400 p-4 rounded-xl text-sm w-full text-center">{{ session('error') }}</div>
</div>
@endif
