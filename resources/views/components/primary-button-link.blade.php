<a
    {{ $attributes->merge([
        'class' => 'inline-flex items-center justify-center px-4 py-2 rounded-md font-semibold text-xs text-white uppercase tracking-wider 
                        bg-gray-800 border border-transparent 
                        hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                        active:bg-gray-900 transition ease-in-out duration-150',
    ]) }}>
    <span>{{ $slot }}</span>
</a>
