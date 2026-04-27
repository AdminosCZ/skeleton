<footer class="w-full border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950">
    <div class="mx-auto max-w-screen-2xl px-6 py-4 text-center text-xs text-gray-500 dark:text-gray-400">
        {!! __('footer.powered_by', [
            'brand' => '<a href="https://adminos.cz" target="_blank" rel="noopener noreferrer" class="font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">ADMINOS</a>',
        ]) !!}
        <span class="mx-1 text-gray-300 dark:text-gray-700">·</span>
        <span class="tabular-nums">{{ __('footer.version', ['version' => config('adminos.version', '1.0.0-alpha')]) }}</span>
    </div>
</footer>
